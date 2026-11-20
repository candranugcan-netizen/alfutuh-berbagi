const CACHE_NAME = 'alfutuh-donasi-pwa-v2';
const urlsToCache = [
    '/',
    '/programs',
    '/kabar',
    '/transparansi',
    '/manifest.json'
];

// Install Service Worker
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(urlsToCache).catch((err) => {
                console.log('SW cache addAll warning:', err);
            });
        })
    );
    self.skipWaiting();
});

// Activate Service Worker & Clean old cache
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((name) => {
                    if (name !== CACHE_NAME) {
                        return caches.delete(name);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch Strategy: Network First with Cache Fallback
self.addEventListener('fetch', (event) => {
    // Hanya tangani GET requests
    if (event.request.method !== 'GET') return;

    // Abaikan route dinamis internal / admin / migrasi agar tidak terkena cache usang
    const url = new URL(event.request.url);
    if (url.pathname.startsWith('/admin') || url.pathname.startsWith('/dashboard') || url.pathname.includes('migrasi')) {
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((networkResponse) => {
                // Simpan cache jika respon valid
                if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
                    const responseClone = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                }
                return networkResponse;
            })
            .catch(() => {
                return caches.match(event.request).then((cachedResponse) => {
                    return cachedResponse || caches.match('/');
                });
            })
    );
});
