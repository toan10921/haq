jQuery(function ($) {
  const $accordions = $('.t888-accordion-wrapper');
  $accordions.each(function () {
    const $wrapper = $(this);
    const $items   = $wrapper.find('.t888-accordion-item');
    $items.find('.t888-accordion-content').removeAttr('hidden');
    const expand = ($item) => {
      const $content = $item.find('.t888-accordion-content');
      const el = $content[0];
      $content.css('max-height', el.scrollHeight + 'px');
      $item.addClass('is-open')
           .find('.t888-accordion-title').attr('aria-expanded', 'true');
      $item.find('.t888-accordion-icon i').removeClass('la-plus').addClass('la-minus');
    };

    const collapse = ($item) => {
      const $content = $item.find('.t888-accordion-content');
      const el = $content[0];
      $content.css('max-height', el.scrollHeight + 'px');
      requestAnimationFrame(() => $content.css('max-height', '0px'));
      $item.removeClass('is-open')
           .find('.t888-accordion-title').attr('aria-expanded', 'false');
      $item.find('.t888-accordion-icon i').removeClass('la-minus').addClass('la-plus');
    };
    const $first = $items.first();
    expand($first);
    $wrapper.on('click', '.t888-accordion-title', function () {
      const $item = $(this).closest('.t888-accordion-item');
      const isOpen = $item.hasClass('is-open');

      $items.filter('.is-open').each(function(){ collapse($(this)); });

      if (!isOpen) expand($item);
    });
    $items.find('.t888-accordion-content').on('transitionend', function (e) {
      if (e.originalEvent.propertyName !== 'max-height') return;
      const $content = $(this);
      if ($content.closest('.t888-accordion-item').hasClass('is-open')) {
        $content.css('max-height', 'none'); // mở xong thì thả tự nhiên
      }
    });
  });
});
