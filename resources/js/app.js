import './gallery-lightbox';

const trackConversion = (eventName, target = null) => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    if (! csrfToken) {
        return;
    }

    fetch('/conversion-events', {
        method: 'POST',
        keepalive: true,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            event_name: eventName,
            target: target?.dataset.trackTarget || target?.getAttribute('href'),
        }),
    }).catch(() => {
        // Tracking must never interrupt the user's interaction.
    });
};

document.addEventListener('click', (event) => {
    const target = event.target.closest('[data-track-event]');

    if (target) {
        trackConversion(target.dataset.trackEvent, target);
    }
});

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js', { scope: '/' }).catch(() => {
            // PWA enhancements must never block normal site navigation.
        });
    });
}
