(function ($) {
    'use strict';

    function initPriceFilter(root) {
        if (!root || root.dataset.priceFilterReady === 'yes') return;
        root.dataset.priceFilterReady = 'yes';

        var minRange = root.querySelector('.t888-price-filter__range--min');
        var maxRange = root.querySelector('.t888-price-filter__range--max');
        var minInput = root.querySelector('.t888-price-filter__min-input');
        var maxInput = root.querySelector('.t888-price-filter__max-input');
        var minLabel = root.querySelector('.t888-price-filter__min-label');
        var maxLabel = root.querySelector('.t888-price-filter__max-label');
        var fill = root.querySelector('.t888-price-filter__range-fill');
        if (!minRange || !maxRange) return;

        var minimum = Number(root.dataset.min || 0);
        var maximum = Number(root.dataset.max || 1);
        var currency = minLabel ? minLabel.textContent.replace(/[\d\s.,-]/g, '') : '';
        var activeRange = null;

        function format(value) {
            return currency + Math.round(value).toLocaleString(document.documentElement.lang || undefined);
        }

        function update(changed) {
            var low = Number(minRange.value);
            var high = Number(maxRange.value);
            if (low > high) {
                if (changed === minRange) high = low;
                else low = high;
            }
            minRange.value = low;
            maxRange.value = high;
            minInput.value = low;
            maxInput.value = high;

            // A full-width range means "all products". Do not submit a price
            // meta query in that state, otherwise products without _price are
            // excluded even though both handles are at their outer limits.
            var isFullRange = low <= minimum && high >= maximum;
            minInput.disabled = isFullRange;
            maxInput.disabled = isFullRange;

            if (minLabel) minLabel.textContent = format(low);
            if (maxLabel) maxLabel.textContent = format(high);
            var span = Math.max(1, maximum - minimum);
            fill.style.left = ((low - minimum) / span * 100) + '%';
            fill.style.right = (100 - ((high - minimum) / span * 100)) + '%';
            minRange.style.zIndex = low >= high - 1 ? '5' : '3';
            maxRange.style.zIndex = '4';
        }

        function valueFromPointer(event) {
            var rect = root.querySelector('.t888-price-filter__slider').getBoundingClientRect();
            var ratio = Math.max(0, Math.min(1, (event.clientX - rect.left) / Math.max(1, rect.width)));
            return Math.round(minimum + ratio * (maximum - minimum));
        }

        function chooseRange(value) {
            var lowDistance = Math.abs(value - Number(minRange.value));
            var highDistance = Math.abs(value - Number(maxRange.value));
            return lowDistance <= highDistance ? minRange : maxRange;
        }

        function setRangeValue(range, value) {
            if (range === minRange) {
                range.value = Math.min(value, Number(maxRange.value));
            } else {
                range.value = Math.max(value, Number(minRange.value));
            }
            update(range);
            range.dispatchEvent(new Event('change', { bubbles: true }));
        }

        function startDrag(event) {
            if (event.button !== undefined && event.button !== 0) return;
            var value = valueFromPointer(event);
            activeRange = chooseRange(value);
            if (slider.setPointerCapture && event.pointerId !== undefined) {
                slider.setPointerCapture(event.pointerId);
            }
            setRangeValue(activeRange, value);
            root.classList.add('is-price-dragging');
            event.preventDefault();
        }

        function moveDrag(event) {
            if (!activeRange) return;
            setRangeValue(activeRange, valueFromPointer(event));
            event.preventDefault();
        }

        function stopDrag(event) {
            if (!activeRange) return;
            activeRange = null;
            root.classList.remove('is-price-dragging');
            if (slider.releasePointerCapture && event && event.pointerId !== undefined && slider.hasPointerCapture(event.pointerId)) {
                slider.releasePointerCapture(event.pointerId);
            }
        }

        minRange.addEventListener('input', function () { update(minRange); });
        maxRange.addEventListener('input', function () { update(maxRange); });
        var slider = root.querySelector('.t888-price-filter__slider');
        slider.addEventListener('pointerdown', startDrag);
        slider.addEventListener('pointermove', moveDrag, { passive: false });
        slider.addEventListener('pointerup', stopDrag);
        slider.addEventListener('pointercancel', stopDrag);
        update();
    }

    function initScope(scope) {
        var element = scope && scope.jquery ? scope[0] : scope;
        if (!element) return;
        if (element.matches && element.matches('.t888-price-filter')) initPriceFilter(element);
        Array.prototype.forEach.call(element.querySelectorAll('.t888-price-filter'), initPriceFilter);
    }

    $(function () { $('.t888-price-filter').each(function () { initPriceFilter(this); }); });
    $(window).on('elementor/frontend/init', function () {
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction('frontend/element_ready/t888-shop-price-filter.default', initScope);
        }
    });
})(jQuery);
