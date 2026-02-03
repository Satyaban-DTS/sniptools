const CACHE_NAME = 'sniptools-v2';
const ASSETS_TO_CACHE = [
    '/',
    'manifest.json',
    'favicon.ico'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return Promise.allSettled(
                ASSETS_TO_CACHE.map(url => cache.add(url))
            );
        })
    );
    self.skipWaiting();
});

self.addEventListener('fetch', (event) => {
    // 1. Only handle GET requests
    if (event.request.method !== 'GET') return;

    // 2. Ignore External Tracking / Analytics / Ads
    const url = event.request.url;
    if (url.includes('google-analytics.com') ||
        url.includes('googletagmanager.com') ||
        url.includes('aclib.js') ||
        url.includes('adnxs.com') ||
        url.includes('doubleclick.net')) {
        return;
    }

    // 3. Stale-while-revalidate strategy
    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            const fetchPromise = fetch(event.request).then((networkResponse) => {
                // Check if we received a valid response
                if (!networkResponse || networkResponse.status !== 200 || networkResponse.type !== 'basic') {
                    return networkResponse;
                }

                const responseToCache = networkResponse.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseToCache);
                });

                return networkResponse;
            }).catch(() => {
                // Return cached response if network fails
                return cachedResponse;
            });

            return cachedResponse || fetchPromise;
        })
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keyList) => {
            return Promise.all(
                keyList.map((key) => {
                    if (key !== CACHE_NAME) {
                        return caches.delete(key);
                    }
                })
            );
        })
    );
    return self.clients.claim();
});
