(function ($) {
    'use strict';

    function initHeroSlider(root) {
        if (!root || root.dataset.t888HeroReady === 'yes') {
            return;
        }

        var slides = Array.prototype.slice.call(root.querySelectorAll('.t888-industrial-hero__slide'));
        var prevButton = root.querySelector('.t888-industrial-hero__prev');
        var nextButton = root.querySelector('.t888-industrial-hero__next');

        if (!slides.length) {
            return;
        }

        root.dataset.t888HeroReady = 'yes';
        root.dataset.animationEngine = window.gsap ? 'gsap' : 'native';

        var currentIndex = 0;
        var isAnimating = false;
        var activeTimeline = null;
        var activeAnimations = [];
        var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function getParts(slide) {
            return {
                titleMask: slide.querySelector('.t888-industrial-hero__title-mask'),
                title: slide.querySelector('.t888-industrial-hero__title'),
                description: slide.querySelector('.t888-industrial-hero__description'),
                button: slide.querySelector('.t888-industrial-hero__button'),
                play: slide.querySelector('.t888-industrial-hero__play')
            };
        }

        function setNavigationLocked(locked) {
            isAnimating = locked;
            root.classList.toggle('is-transitioning', locked);
            root.setAttribute('aria-busy', locked ? 'true' : 'false');
            [prevButton, nextButton].forEach(function (button) {
                if (button) {
                    button.setAttribute('aria-disabled', locked ? 'true' : 'false');
                }
            });
        }

        slides.forEach(function (slide) {
            var image = slide.querySelector('.t888-industrial-hero__background img');
            if (image) {
                image.loading = 'eager';
                if (typeof image.decode === 'function') {
                    image.decode().catch(function () {});
                }
            }
        });

        function settleSlides(newSlide, newIndex) {
            slides.forEach(function (slide, index) {
                var active = index === newIndex;
                slide.classList.toggle('is-active', active);
                slide.setAttribute('aria-hidden', active ? 'false' : 'true');
                slide.style.zIndex = active ? '1' : '0';
                if (!active) {
                    slide.style.opacity = '0';
                    slide.style.visibility = 'hidden';
                }
            });

            newSlide.style.opacity = '1';
            newSlide.style.visibility = 'visible';
        }

        function runNativeAnimation(oldSlide, newSlide, newIndex) {
            var parts = getParts(newSlide);
            var animations = [];
            var power3Out = 'cubic-bezier(0.165, 0.84, 0.44, 1)';

            activeAnimations.forEach(function (animation) {
                animation.cancel();
            });
            activeAnimations = [];
            root.classList.add('is-content-animating');

            if (reduceMotion) {
                newSlide.style.opacity = '1';
                newSlide.style.visibility = 'visible';
                if (oldSlide && oldSlide !== newSlide) oldSlide.style.opacity = '0';
                [parts.titleMask, parts.title, parts.description, parts.button, parts.play].forEach(function (part) {
                    if (part) part.style.transform = 'none';
                });
                root.classList.add('is-animation-ready');
                settleSlides(newSlide, newIndex);
                root.classList.remove('is-content-animating');
                setNavigationLocked(false);
                return;
            }

            newSlide.style.visibility = 'visible';
            newSlide.style.zIndex = '2';
            animations.push(newSlide.animate([{ opacity: 0 }, { opacity: 1 }], { duration: 500, fill: 'forwards', easing: 'linear' }));
            if (oldSlide && oldSlide !== newSlide) {
                animations.push(oldSlide.animate([{ opacity: 1 }, { opacity: 0 }], { duration: 500, fill: 'forwards', easing: 'linear' }));
            }
            if (parts.titleMask) {
                animations.push(parts.titleMask.animate([{ transform: 'translateX(100%)' }, { transform: 'translateX(0)' }], { duration: 1000, fill: 'forwards', easing: power3Out }));
            }
            if (parts.title) {
                animations.push(parts.title.animate([{ transform: 'translateX(-175%)' }, { transform: 'translateX(0)' }], { duration: 1000, fill: 'forwards', easing: power3Out }));
            }
            if (parts.description) {
                animations.push(parts.description.animate([{ transform: 'translateY(-100%)' }, { transform: 'translateY(0)' }], { duration: 1200, delay: 500, fill: 'forwards', easing: power3Out }));
            }
            if (parts.button) {
                animations.push(parts.button.animate(
                    [{ transform: 'translateX(-100%)', opacity: 0 }, { transform: 'translateX(0)', opacity: 1 }],
                    { duration: 1000, delay: 1170, fill: 'both', easing: power3Out }
                ));
            }
            if (parts.play) {
                animations.push(parts.play.animate(
                    [{ transform: 'translateX(50px)', opacity: 0 }, { transform: 'translateX(0)', opacity: 1 }],
                    { duration: 1000, delay: 1670, fill: 'both', easing: power3Out }
                ));
            }
            activeAnimations = animations;
            root.classList.add('is-animation-ready');
            Promise.all(animations.map(function (animation) {
                return animation.finished.catch(function () {});
            })).then(function () {
                if (activeAnimations !== animations) return;
                settleSlides(newSlide, newIndex);
                root.classList.remove('is-content-animating');
                activeAnimations = [];
                setNavigationLocked(false);
            });
        }

        function runGsapAnimation(oldSlide, newSlide, newIndex) {
            var parts = getParts(newSlide);

            if (activeTimeline) {
                activeTimeline.kill();
            }

            root.classList.add('is-content-animating');

            window.gsap.killTweensOf([oldSlide, newSlide, parts.titleMask, parts.title, parts.description, parts.button, parts.play]);
            window.gsap.set(newSlide, { autoAlpha: 0, zIndex: 2, force3D: true });
            if (parts.titleMask) window.gsap.set(parts.titleMask, { xPercent: 100, opacity: 1, force3D: true });
            if (parts.title) window.gsap.set(parts.title, { xPercent: -175, opacity: 1, force3D: true });
            if (parts.description) window.gsap.set(parts.description, { yPercent: -100, opacity: 1, force3D: true });
            if (parts.button) {
                window.gsap.set(parts.button, {
                    xPercent: -100,
                    autoAlpha: 0,
                    force3D: true
                });
            }

            if (parts.play) {
                window.gsap.set(parts.play, {
                    x: 50,
                    autoAlpha: 0,
                    force3D: true
                });
            }

            root.classList.add('is-animation-ready');

            var timeline = window.gsap.timeline({
                onComplete: function () {
                    if (activeTimeline === timeline) {
                        settleSlides(newSlide, newIndex);
                        root.classList.remove('is-content-animating');
                        activeTimeline = null;
                        setNavigationLocked(false);
                    }
                }
            });
            activeTimeline = timeline;

            timeline.to(newSlide, { autoAlpha: 1, duration: reduceMotion ? 0.01 : 0.5, ease: 'none', force3D: true, overwrite: 'auto' }, 0);
            if (oldSlide && oldSlide !== newSlide) {
                timeline.to(oldSlide, { autoAlpha: 0, duration: reduceMotion ? 0.01 : 0.5, ease: 'none', force3D: true, overwrite: 'auto' }, 0);
            }
            if (parts.titleMask) {
                timeline.to(parts.titleMask, { xPercent: 0, duration: reduceMotion ? 0.01 : 1, ease: 'power3.out', force3D: true }, 0);
            }
            if (parts.title) {
                timeline.to(parts.title, { xPercent: 0, duration: reduceMotion ? 0.01 : 1, ease: 'power3.out', force3D: true }, 0);
            }
            if (parts.description) {
                timeline.to(parts.description, { yPercent: 0, duration: reduceMotion ? 0.01 : 1.2, ease: 'power3.out', force3D: true }, reduceMotion ? 0 : 0.5);
            }
            if (parts.button) {
                timeline.to(parts.button, { xPercent: 0, autoAlpha: 1, duration: reduceMotion ? 0.01 : 1, ease: 'power3.out', force3D: true }, reduceMotion ? 0 : 1.17);
            }
            if (parts.play) {
                timeline.to(parts.play, { x: 0, autoAlpha: 1, duration: reduceMotion ? 0.01 : 1, ease: 'power3.out', force3D: true }, reduceMotion ? 0 : 1.67);
            }
        }

        function goToSlide(newIndex, initial) {
            if (isAnimating && !initial) {
                return;
            }

            newIndex = (newIndex + slides.length) % slides.length;
            if (!initial && newIndex === currentIndex) {
                return;
            }

            var oldSlide = initial ? null : slides[currentIndex];
            var newSlide = slides[newIndex];

            setNavigationLocked(true);
            currentIndex = newIndex;
            newSlide.classList.add('is-active');
            newSlide.setAttribute('aria-hidden', 'false');

            if (window.gsap) {
                runGsapAnimation(oldSlide, newSlide, newIndex);
            } else {
                runNativeAnimation(oldSlide, newSlide, newIndex);
            }
        }

        if (nextButton) {
            nextButton.addEventListener('click', function () {
                goToSlide(currentIndex + 1, false);
            });
        }

        if (prevButton) {
            prevButton.addEventListener('click', function () {
                goToSlide(currentIndex - 1, false);
            });
        }

        root.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowRight') {
                event.preventDefault();
                goToSlide(currentIndex + 1, false);
            } else if (event.key === 'ArrowLeft') {
                event.preventDefault();
                goToSlide(currentIndex - 1, false);
            }
        });

        goToSlide(0, true);
    }

    function initInScope(scope) {
        var element = scope && scope.jquery ? scope[0] : scope;
        if (!element) return;

        if (element.matches && element.matches('.t888-industrial-hero')) {
            initHeroSlider(element);
        }

        Array.prototype.forEach.call(element.querySelectorAll('.t888-industrial-hero'), initHeroSlider);
    }

    $(function () {
        $('.t888-industrial-hero').each(function () {
            initHeroSlider(this);
        });
    });

    $(window).on('elementor/frontend/init', function () {
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction('frontend/element_ready/t888-hero-slider.default', initInScope);
        }
    });
})(jQuery);
