/**
 * Lightbox simplu pentru galeria de imagini din pagina de proiect.
 * Fara dependinte externe - functioneaza cu click, tastatura (Esc, sageti)
 * si click pe fundal pentru inchidere.
 */
function initGalleryLightbox() {
    const items = Array.from(document.querySelectorAll('[data-gallery-item]'));
    const lightbox = document.querySelector('[data-lightbox]');

    if (! items.length || ! lightbox) {
        return;
    }

    const image = lightbox.querySelector('[data-lightbox-image]');
    const caption = lightbox.querySelector('[data-lightbox-caption]');
    const closeButton = lightbox.querySelector('[data-lightbox-close]');
    const prevButton = lightbox.querySelector('[data-lightbox-prev]');
    const nextButton = lightbox.querySelector('[data-lightbox-next]');

    let currentIndex = 0;

    const show = (index) => {
        currentIndex = (index + items.length) % items.length;
        const item = items[currentIndex];
        image.src = item.dataset.full;
        image.alt = item.dataset.caption || '';
        caption.textContent = item.dataset.caption || '';
    };

    const open = (index) => {
        show(index);
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
        closeButton?.focus();
    };

    const close = () => {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = '';
        image.src = '';
    };

    items.forEach((item, index) => {
        item.addEventListener('click', () => open(index));
    });

    closeButton?.addEventListener('click', close);
    prevButton?.addEventListener('click', () => show(currentIndex - 1));
    nextButton?.addEventListener('click', () => show(currentIndex + 1));

    lightbox.addEventListener('click', (event) => {
        if (event.target === lightbox) {
            close();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (lightbox.classList.contains('hidden')) {
            return;
        }

        if (event.key === 'Escape') {
            close();
        } else if (event.key === 'ArrowLeft') {
            show(currentIndex - 1);
        } else if (event.key === 'ArrowRight') {
            show(currentIndex + 1);
        }
    });
}

document.addEventListener('DOMContentLoaded', initGalleryLightbox);
