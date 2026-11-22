<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-[#155E4B] hover:bg-[#0E4436] border border-transparent rounded-full font-bold text-xs text-white shadow-sm hover:shadow active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#155E4B] focus:ring-offset-2 transition']) }}>
    {{ $slot }}
</button>
