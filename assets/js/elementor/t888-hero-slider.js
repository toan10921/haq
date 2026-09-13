(function ($) {
    'use strict';

    function initHeroSlider(root) {
        if (!root || root.dataset.t888HeroReady === 'yes') return;

        var slides = Array.prototype.slice.call(root.querySelectorAll('.t888-industrial-hero__slide'));
        var prevButton = root.querySelector('.t888-industrial-hero__prev');
        var nextButton = root.querySelector('.t888-industrial-hero__next');

        if (!slides.length) return;

        root.dataset.t888HeroReady = 'yes';

        var currentIndex = 0;
        var isAnimating = false;
        var activeAnimations = [];
        var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var swipeMedia = window.matchMedia ? window.matchMedia('(max-width: 1024px)') : null;
        var mobileAutoplayMedia = window.matchMedia ? window.matchMedia('(max-width: 767px)') : null;
        var autoplayDelay = 10000;
        var transitionDuration = 1000;
        var transitionEasing = 'cubic-bezier(0.4, 0, 0.2, 1)';
        var autoplayTimer = null;
        var swipeStartX = 0;
        var swipeStartY = 0;
        var swipePointerId = null;
        var swipeTracking = false;
        var swipeThreshold = 50;
        var resizeFrame = null;

        function stopAutoplay() {
            if (!autoplayTimer) return;
            window.clearTimeout(autoplayTimer);
            autoplayTimer = null;
        }

        function scheduleAutoplay() {
            stopAutoplay();

            if (
                slides.length < 2 ||
                reduceMotion ||
                document.hidden ||
                !mobileAutoplayMedia ||
                !mobileAutoplayMedia.matches
            ) {
                return;
            }

            autoplayTimer = window.setTimeout(function () {
                autoplayTimer = null;

                if (isAnimating) {
                    scheduleAutoplay();
                    return;
                }

                goToSlide(currentIndex + 1, false);
            }, autoplayDelay);
        }

        function getImage(slide) {
            return slide ? slide.querySelector('.t888-industrial-hero__image') : null;
        }

        function syncImageRatio(slide) {
            var image = getImage(slide);
            if (!image || image.naturalWidth <= 0 || image.naturalHeight <= 0) return;

            root.style.setProperty(
                '--t888-hero-image-ratio',
                image.naturalWidth + ' / ' + image.naturalHeight
            );
        }

        function setNavigationLocked(locked) {
            isAnimating = locked;
            root.setAttribute('aria-busy', locked ? 'true' : 'false');

            [prevButton, nextButton].forEach(function (button) {
                if (button) button.setAttribute('aria-disabled', locked ? 'true' : 'false');
            });
        }

        function settleSlides(newIndex) {
            slides.forEach(function (slide, index) {
                var active = index === newIndex;
                slide.classList.toggle('is-active', active);
                slide.setAttribute('aria-hidden', active ? 'false' : 'true');
                slide.style.zIndex = active ? '1' : '0';
                slide.style.opacity = active ? '1' : '0';
                slide.style.visibility = active ? 'visible' : 'hidden';
            });
        }

        function finishTransition(newIndex, animations) {
            if (activeAnimations !== animations) return;

            settleSlides(newIndex);
            activeAnimations = [];
            setNavigationLocked(false);
            scheduleAutoplay();
        }

        function goToSlide(newIndex, initial) {
            if (isAnimating && !initial) return;

            stopAutoplay();

            newIndex = (newIndex + slides.length) % slides.length;
            if (!initial && newIndex === currentIndex) return;

            var oldSlide = initial ? null : slides[currentIndex];
            var newSlide = slides[newIndex];

            activeAnimations.forEach(function (animation) {
                animation.cancel();
            });
            activeAnimations = [];

            currentIndex = newIndex;

            if (initial || reduceMotion || typeof newSlide.animate !== 'function') {
                settleSlides(newIndex);
                setNavigationLocked(false);
                scheduleAutoplay();
                return;
            }

            setNavigationLocked(true);
            newSlide.classList.add('is-active');
            newSlide.setAttribute('aria-hidden', 'false');
            newSlide.style.zIndex = '2';
            newSlide.style.visibility = 'visible';

            var animations = [
                newSlide.animate(
                    [{ opacity: 0 }, { opacity: 1 }],
                    { duration: transitionDuration, fill: 'forwards', easing: transitionEasing }
                )
            ];

            if (oldSlide && oldSlide !== newSlide) {
                animations.push(oldSlide.animate(
                    [{ opacity: 1 }, { opacity: 0 }],
                    { duration: transitionDuration, fill: 'forwards', easing: transitionEasing }
                ));
            }

            activeAnimations = animations;
            Promise.all(animations.map(function (animation) {
                return animation.finished.catch(function () {});
            })).then(function () {
                finishTransition(newIndex, animations);
            });
        }

        slides.forEach(function (slide, index) {
            var image = getImage(slide);
            if (!image) return;

            image.addEventListener('load', function () {
                if (index === 0) syncImageRatio(slide);
            });

            if (image.complete && index === 0) syncImageRatio(slide);
        });

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

        function resetSwipe() {
            swipePointerId = null;
            swipeTracking = false;
        }

        root.addEventListener('pointerdown', function (event) {
            if (slides.length < 2 || isAnimating || (swipeMedia && !swipeMedia.matches)) return;
            if (event.pointerType === 'mouse' || !event.isPrimary) return;
            if (event.target.closest && event.target.closest('a, button, input, select, textarea')) return;

            swipeStartX = event.clientX;
            swipeStartY = event.clientY;
            swipePointerId = event.pointerId;
            swipeTracking = true;
            stopAutoplay();
        });

        root.addEventListener('pointerup', function (event) {
            if (!swipeTracking || event.pointerId !== swipePointerId) return;

            var distanceX = event.clientX - swipeStartX;
            var distanceY = event.clientY - swipeStartY;
            resetSwipe();

            if (Math.abs(distanceX) < swipeThreshold || Math.abs(distanceX) <= Math.abs(distanceY)) {
                scheduleAutoplay();
                return;
            }
            goToSlide(currentIndex + (distanceX < 0 ? 1 : -1), false);
        });

        root.addEventListener('pointercancel', function () {
            resetSwipe();
            scheduleAutoplay();
        });

        root.addEventListener('keydown', function (event) {
            if (event.key === 'ArrowRight') {
                event.preventDefault();
                goToSlide(currentIndex + 1, false);
            } else if (event.key === 'ArrowLeft') {
                event.preventDefault();
                goToSlide(currentIndex - 1, false);
            }
        });

        window.addEventListener('resize', function () {
            if (resizeFrame) window.cancelAnimationFrame(resizeFrame);
            resizeFrame = window.requestAnimationFrame(function () {
                syncImageRatio(slides[0]);
                scheduleAutoplay();
            });
        });

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                stopAutoplay();
            } else {
                scheduleAutoplay();
            }
        });

        if (mobileAutoplayMedia) {
            var handleAutoplayBreakpoint = function () {
                scheduleAutoplay();
            };

            if (typeof mobileAutoplayMedia.addEventListener === 'function') {
                mobileAutoplayMedia.addEventListener('change', handleAutoplayBreakpoint);
            } else if (typeof mobileAutoplayMedia.addListener === 'function') {
                mobileAutoplayMedia.addListener(handleAutoplayBreakpoint);
            }
        }

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
