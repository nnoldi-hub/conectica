import './gallery-lightbox';

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js', { scope: '/' }).catch(() => {
            // PWA enhancements must never block normal site navigation.
        });
    });
}
