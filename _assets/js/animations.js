'use strict';

import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { SplitText } from 'gsap/SplitText';
import { CustomEase } from 'gsap/CustomEase';

gsap.registerPlugin(ScrollTrigger, SplitText, CustomEase);

export default {
    init() {
        CustomEase.create('customExpo', '0.16, 1, 0.3, 1');

        /*gsap.set('.page-title', {opacity: 1});
    ScrollTrigger.create({
        trigger: '.page-title',
        start:   'top 80%',
        onEnter: () => {
            SplitText.create('.page-title', {
                type:      'words, chars',
                mask:      'chars',
                autoSplit: true,
                onSplit(self) {
                    gsap.set('.page-title', {opacity: 1});
                    gsap.set(self.chars, {
                        y:       '105%',
                        opacity: 0,
                    });

                    return gsap.to(self.chars, {
                        y:        '0%',
                        opacity:  1,
                        stagger:  0.015,
                        duration: 1,
                        ease:     'customExpo',
                        delay:    0.6,
                    });
                },
            });
        },
    });*/

        gsap.utils.toArray('.fadeUp').forEach((element) => {
            gsap.from(element, {
                opacity:       0,
                y:             50,
                duration:      1,
                ease:          'power2.out',
                scrollTrigger: {
                    trigger:       element,
                    start:         'top 90%',
                    end:           'bottom 80%',
                    toggleActions: 'play none none none',
                },
            });
        });
    },
};
