'use strict';

import 'bootstrap';

import domReady from './domReady.js';
import animations from './animations';

domReady(async () => {
    animations.init();
});
