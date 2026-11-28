<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiDakwahService
{
    /**
     * Generate konten dakwah via Gemini API dengan fallback otomatis ke model Free Tier.
     *
     * @return array{success: bool, content?: string, model?: string, message?: string, status?: int}
     */
    public function generate(string $systemInstruction, string $userPrompt): array
    {
        @set_time_limit(180);

        $apiKey = config('services.gemini.api_key');
        if (empty($apiKey)) {
            return [
                'success' => false,
                'status' => 422,
                'message' => 'GEMINI_API_KEY belum dikonfigurasi di file .env server. Silakan hubungi admin.',
            ];
        }

        $primaryModel = config('services.gemini.model', 'gemini-4-hydrogen');
        $candidateModels = array_values(array_unique([
            $primaryModel,
            'gemini-3.8-flash',
            'gemini-3.6-flash',
            'gemini-3.5-flash-lite',
        ]));

        $basePayload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $systemInstruction],
                ],
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'temperature' => 0.4,
                'maxOutputTokens' => 4096,
                'thinkingConfig' => [
                    'thinkingLevel' => 'low',
                ],
            ],
        ];

        try {
            $lastError = 'Terjadi kesalahan saat menghubungi layanan Gemini AI.';

            foreach ($candidateModels as $model) {
                $payload = $basePayload;
                if (str_contains($model, 'flash-lite')) {
                    unset($payload['generationConfig']['thinkingConfig']);
                }

                $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
                $response = Http::timeout(90)->post($endpoint, $payload);

                if ($response->successful()) {
                    $text = $response->json('candidates.0.content.parts.0.text');
                    if (!empty($text)) {
                        return [
                            'success' => true,
                            'content' => $text,
                            'model' => $model,
                            'status' => 200,
                        ];
                    }
                    $lastError = 'Respons AI kosong. Silakan coba lagi dengan tema yang lebih spesifik.';
                    continue;
                }

                $status = $response->status();
                $errBody = $response->json('error.message') ?? $lastError;
                $lastError = $errBody;

                if (in_array($status, [404, 429, 500, 502, 503, 504], true) || str_contains(strtolower($errBody), 'high demand')) {
                    continue;
                }

                break;
            }

            return [
                'success' => false,
                'status' => 502,
                'message' => 'Gagal menghasilkan naskah: ' . $lastError,
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'status' => 500,
                'message' => 'Koneksi ke Gemini AI terputus atau timeout. Silakan coba beberapa saat lagi.',
            ];
        }
    }
}
