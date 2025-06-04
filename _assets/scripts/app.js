'use strict';

import 'bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';

import domReady from './domReady.js';

domReady(async () => {
    const string = document.querySelector('.myString');
    if (string) {
        const module = await import('./helpers/helpers.js');
        module.wordWrap(string);
    }

    const loaderModule = await import('./loader.js');
    await loaderModule.default.init('.paragraph', './templates/paragraph', 'paragraph--type--');
    await loaderModule.default.init('.block', './templates/block', 'block--');

    AOS.init({
        easing:   'ease-out-cubic',
        duration: 600,
        once:     true,
    });
});
