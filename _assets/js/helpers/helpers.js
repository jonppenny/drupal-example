'use strict';

/**
 * Get the current version of the application.
 *
 * @returns {string}
 */
export function version() {
    return '0.1.1';
}

export function wordWrap(element) {
    const text = element.getAttribute('aria-label').trim();
    const words = text.split(/\s+/);

    const result = words.map(word => {
        return `<span>${word.split('').map(letter => `<span class="letter">${letter}</span>`).join('')}</span>`;
    }).join(' ');

    setTimeout(
        () => {
            element.querySelectorAll('span>*').forEach((letter, index) => {
                setTimeout(() => {
                    letter.classList.add('show');
                }, 15 * index);
            });
        },
        600,
    );

    return element.innerHTML = result;
}
