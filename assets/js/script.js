jQuery(document).ready(function ($) {

	$(".main-gallery .main-image").removeClass("active");
	$(".main-gallery .main-image").eq(0).addClass("active");

	$(".gallery-thumbs .swiper-slide").removeClass("thumb-active");
	$(".gallery-thumbs .swiper-slide").eq(0).addClass("thumb-active");



	function custom_filter() {
		jQuery(document).ready(function ($) {
			var $dropdownToggle = $(".custom-dropdown-toggle");
			var $dropdownItems = $(".custom-dropdown-menu li");
			var $hiddenInput = $("#custom-orderby-input");

			$dropdownItems.on("click", function () {
				var selectedValue = $(this).data("value");
				$hiddenInput.val(selectedValue);
				$dropdownToggle.text($(this).text());

				var currentUrl = new URL(window.location.href);
				currentUrl.searchParams.set("orderby", selectedValue);
				window.location.href = currentUrl.toString();
			});
		});
	}

	function opentoggle_widget() {
		jQuery(function ($) {
			$(".wc-block-product-categories-list--depth-0 .wc-block-product-categories-list-item").each(function () {
				if ($(this).find("> .wc-block-product-categories-list--depth-1").length) {
					if (!$(this).find("> .toggle-icon").length) {
						$(this).children("a").after('<i class="las la-angle-down toggle-icon"></i>');
					}
				}
			});

			const setHeightVar = ($el) => {
				const el = $el[0];
				if (!el) return;
				const wasClosed = !$el.hasClass('is-open');
				if (wasClosed) { el.style.maxHeight = 'none'; el.style.visibility = 'hidden'; el.style.display = 'block'; }
				el.style.setProperty('--submenu-h', el.scrollHeight + 'px');
				if (wasClosed) { el.style.removeProperty('max-height'); el.style.removeProperty('visibility'); el.style.display = ''; }
			};

			$(".wc-block-product-categories-list--depth-1").each(function () {
				setHeightVar($(this));
			});

			$(document).off("click.toggleCat").on("click.toggleCat", ".toggle-icon", function (e) {
				e.preventDefault();

				const $icon = $(this);
				const $item = $icon.closest(".wc-block-product-categories-list-item");
				const $sub = $item.find("> .wc-block-product-categories-list--depth-1").first();
				if (!$sub.length) return;

				setHeightVar($sub);

				const open = !$sub.hasClass("is-open");
				if (open) {
					$sub.addClass("is-open");
					$icon.addClass("is-open");
				} else {
					$sub.removeClass("is-open");
					$icon.removeClass("is-open");
				}
			});
			let t;
			$(window).off('resize.toggleCat').on('resize.toggleCat', function () {
				clearTimeout(t);
				t = setTimeout(function () {
					$(".wc-block-product-categories-list--depth-1.is-open").each(function () {
						setHeightVar($(this));
					});
				}, 120);
			});
		});
	}

	function addClassToCurrentCate() {
		var currentPath = window.location.pathname;

		$(".wc-block-product-categories-list-item a").each(function () {
			var linkPath = new URL($(this).attr("href"), window.location.origin).pathname;

			if (currentPath === linkPath) {
				$(this).parent().addClass("current-cat");
			}
		});
	}

	function tech888_swiper_slider() {
		$('.eltech888-swiper-slider:not(.swiper-container-initialized)').each(function () {
			var slidesPerView = Number($(this).attr('data-items'));
			var items_custom = $(this).attr('data-items-custom');
			var direction = $(this).attr('data-direction');
			var slidertype = $(this).attr('data-slidertype');
			var effect = $(this).attr('data-effect');
			if (!effect) effect = false;
			if (!direction) direction = 'horizontal';
			if (!slidesPerView) slidesPerView = 1;
			var number_active = slidesPerView;

			var spaceBetween = Number($(this).attr('data-space'));
			if (!spaceBetween) spaceBetween = 0;

			var slidesPerColumn = Number($(this).attr('data-column'));
			if (!slidesPerColumn) slidesPerColumn = 1;

			var slidesPerColumnFill = 'column';
			if (slidesPerColumn > 1) slidesPerColumnFill = 'row';

			var loop = $(this).attr('data-loop');
			if (loop != 'yes') loop = false;
			else loop = true;

			var auto = $(this).attr('data-auto');
			if (auto != 'yes') auto = false;
			else auto = true;
			if (auto) slidesPerView = 'auto';


			var centeredSlides = $(this).attr('data-center');
			if (centeredSlides != 'yes') centeredSlides = false;
			else centeredSlides = true;

			var breakpoints = {};
			var items_widescreen = Number($(this).attr('data-items-widescreen'));
			var items_laptop = Number($(this).attr('data-items-laptop'));
			var items_tablet_extra = Number($(this).attr('data-items-tablet-extra'));
			var items_tablet = Number($(this).attr('data-items-tablet'));
			var items_mobile_extra = Number($(this).attr('data-items-mobile-extra'));
			var items_mobile = Number($(this).attr('data-items-mobile'));

			var space_widescreen = Number($(this).attr('data-space-widescreen'));
			var space_laptop = Number($(this).attr('data-space-laptop'));
			var space_tablet_extra = Number($(this).attr('data-space-tablet-extra'));
			var space_tablet = Number($(this).attr('data-space-tablet'));
			var space_mobile_extra = Number($(this).attr('data-space-mobile-extra'));
			var space_mobile = Number($(this).attr('data-space-mobile'));



			if (items_tablet || items_mobile || items_widescreen || items_laptop || items_tablet_extra || items_mobile_extra || space_tablet || space_mobile || space_widescreen || space_laptop || space_tablet_extra || space_mobile_extra) {
				if (auto) items_tablet = items_mobile = 'auto';
				if (items_widescreen == '') items_widescreen = slidesPerView;
				if (items_laptop == '') items_laptop = slidesPerView;
				if (items_tablet_extra == '') items_tablet_extra = items_laptop;
				if (items_tablet == '') items_tablet = items_tablet_extra;
				if (items_mobile_extra == '') items_mobile_extra = items_tablet;
				if (items_mobile == '') items_mobile = items_mobile_extra;

				if (space_widescreen == '') space_widescreen = spaceBetween;
				if (space_laptop == '') space_laptop = spaceBetween;
				if (space_tablet_extra == '') space_tablet_extra = space_laptop;
				if (space_tablet == '') space_tablet = space_tablet_extra;
				if (space_mobile_extra == '') space_mobile_extra = space_tablet;
				if (space_mobile == '') space_mobile = space_mobile_extra;

				breakpoints = {
					0: {
						slidesPerView: items_mobile,
						slidesPerColumn: slidesPerColumn,
						spaceBetween: space_mobile
					},
					768: {
						slidesPerView: items_mobile_extra,
						slidesPerColumn: slidesPerColumn,
						spaceBetween: space_mobile_extra
					},
					881: {
						slidesPerView: items_tablet,
						slidesPerColumn: slidesPerColumn,
						spaceBetween: space_tablet
					},
					1025: {
						slidesPerView: items_tablet_extra,
						slidesPerColumn: slidesPerColumn,
						spaceBetween: space_tablet_extra
					},
					1201: {
						slidesPerView: items_laptop,
						slidesPerColumn: slidesPerColumn,
						spaceBetween: space_laptop
					},
					1367: {
						slidesPerView: slidesPerView,
						slidesPerColumn: slidesPerColumn,
						spaceBetween: spaceBetween
					},
					2401: {
						slidesPerView: items_widescreen,
						slidesPerColumn: slidesPerColumn,
						spaceBetween: space_widescreen
					}
				}

			}

			if (items_custom) {
				items_custom = items_custom.split(',');
				var breakpoints = {};
				var i;

				for (i = 0; i < items_custom.length; i++) {

					items_custom[i] = items_custom[i].split(':');

					var res_dv = {};
					res_dv.slidesPerView = parseInt(items_custom[i][1], 10);

					if (767 > Number(items_custom[i][0]) && Number(items_custom[i][0]) >= 0 && space_mobile) {
						res_dv.spaceBetween = space_mobile;
					} else if (1170 > Number(items_custom[i][0]) && Number(items_custom[i][0]) >= 767 && space_tablet) {
						res_dv.spaceBetween = space_tablet;
					} else if (Number(items_custom[i][0]) >= 1170 && spaceBetween) {
						res_dv.spaceBetween = spaceBetween;
					}
					res_dv.slidesPerColumn = slidesPerColumn;
					breakpoints[items_custom[i][0]] = res_dv;
					var max_items_custom = items_custom[0][0];
					var max_items_custom_v = items_custom[0][1];
					if (max_items_custom < items_custom[i][0]) {
						max_items_custom = items_custom[i][0];
						max_items_custom_v = parseInt(items_custom[i][1], 10);
					}
				}
				if (Number(max_items_custom) < 1170) {
					var breakpoints_c = {
						1170: {
							slidesPerView: Number(max_items_custom_v),
							spaceBetween: spaceBetween,
							slidesPerColumn: slidesPerColumn,
						}
					}

					let a = { ...breakpoints_c, ...breakpoints };
					breakpoints = a;
				}
			}
			var autoplayAttr = $(this).attr('data-autoplay');
			var speed = Number($(this).attr('data-speed'));
			var autoplay = false;

			if (autoplayAttr === 'yes' && speed) {
				autoplay = {
					delay: speed,
					disableOnInteraction: $(this).attr('data-pause-on-interaction') === 'yes' ? false : true,
					pauseOnMouseEnter: $(this).attr('data-pause-on-hover') === 'yes'
				};
			}



			var navigation = $(this).attr('data-navigation');
			if (navigation == '') navigation = {};
			else navigation = {
				nextEl: $(this).parent().find('.swiper-button-next'),
				prevEl: $(this).parent().find('.swiper-button-prev'),
			};

			var pagination = $(this).attr('data-pagination');

			// Nếu không có pagination, đặt là `false`
			if (!pagination || pagination === "false") {
				pagination = false;
			} else if (pagination === "bullets") {
				pagination = {
					el: $(this).find('.swiper-pagination')[0], // Đảm bảo lấy đúng pagination của slider
					clickable: true
				};
			} else if (pagination === "fraction") {
				pagination = {
					el: $(this).find('.swiper-pagination')[0],
					type: 'fraction'
				};
			} else if (pagination === "progress") {
				pagination = {
					el: $(this).find('.swiper-pagination')[0],
					type: 'progressbar'
				};
			} else if (pagination === "number") {
				pagination = {
					el: $(this).find('.swiper-pagination')[0],
					clickable: true,
					renderBullet: function (index, className) {
						return '<span class="' + className + ' pagination' + (index + 1) + '">' + (index + 1) + '</span>';
					},
				};
			}


			if (slidertype == 'marquee') {
				var swiper = new Swiper($(this)[0], {
					spaceBetween: 0,
					centeredSlides: true,
					speed: 3000,
					autoplay: {
						delay: 1,
					},
					loop: true,
					slidesPerView: 'auto',
					allowTouchMove: false,
					disableOnInteraction: true
				});
			} else {
				var swiper = new Swiper($(this)[0], {
					autoHeight: false,
					direction: direction,
					slidesPerView: slidesPerView,
					spaceBetween: spaceBetween,
					slidesPerColumn: slidesPerColumn,
					slidesPerColumnFill: slidesPerColumnFill,
					loop: loop,
					centeredSlides: centeredSlides,
					breakpoints: breakpoints,
					autoplay: autoplay,
					navigation: {
						nextEl: $(this).find('.swiper-button-next')[0],
						prevEl: $(this).find('.swiper-button-prev')[0]
					},
					pagination: pagination,
					observer: true,
					observeParents: true,
					effect: effect,
					fadeEffect: {
						crossFade: true
					},
					scrollbar: {
						el: '.swiper-scrollbar',
						hide: true
					},
					on: {
						init: function () {
							var activeIndex = this.activeIndex + 1;
							var $swiperEl = $(this.el);
							$swiperEl.find('.swiper-slide').removeClass('tech888-active-swiper');

							for (var i = activeIndex; i < number_active + activeIndex; i++) {
								$swiperEl.find('.swiper-slide:nth-child(' + i + ')').addClass('tech888-active-swiper');
							}
						},
						slideChange: function () {
							var activeIndex = this.activeIndex + 1;
							var $swiperEl = $(this.el);
							$swiperEl.find('.swiper-slide').removeClass('tech888-active-swiper');

							for (var i = activeIndex; i < number_active + activeIndex; i++) {
								$swiperEl.find('.swiper-slide:nth-child(' + i + ')').addClass('tech888-active-swiper');
							}

							// Fix pagination sync: CHỈ tìm bullet trong slider hiện tại
							if (this.pagination && this.pagination.el) {
								var bullets = this.pagination.el.querySelectorAll('.swiper-pagination-bullet');
								bullets.forEach((bullet, index) => {
									bullet.classList.toggle('swiper-pagination-bullet-active', index === this.realIndex);
								});
							}
						}
					}
				});

			}
			$('.slider-type-marquee').on('mouseenter', function (e) {
				swiper.autoplay.stop();
			});
			$('.slider-type-marquee').on('mouseleave', function (e) {
				swiper.autoplay.start();
			});
		})
	}

	// update price in button addtocart when change quantity in Grouped Product andand Simple Product
	function updatePrice() {
		var dynamicPrice = $('#dynamic-price');

		if (!dynamicPrice.length) return;

		//Grouped Product
		if ($('.woocommerce-grouped-product-list').length) {
			var totalPrice = 0;

			$('.woocommerce-grouped-product-list input.qty').each(function () {
				var qty = parseFloat($(this).val()) || 0;
				var productRow = $(this).closest('tr');
				var priceText = productRow.find('.woocommerce-Price-amount').text();
				var price = parseFloat(priceText.replace(/[^0-9.]/g, '')) || 0;

				totalPrice += qty * price;
			});

			dynamicPrice.text(wc_format_price(totalPrice));

		}
		else if ($('.variations_form').length) {
			// Variable Product
			var selectedVariationPrice = $('.woocommerce-variation-price .woocommerce-Price-amount').text();
			var basePrice = parseFloat(selectedVariationPrice.replace(/[^0-9.]/g, '')) || 0;
			var qty = $('.quantity input.qty').val() || 1;

			var newPrice = basePrice * qty;
			dynamicPrice.text(wc_format_price(newPrice));
		}
		else {
			// Simple Product
			var qty = $('.quantity input.qty').val();
			var basePrice = dynamicPrice.data('base-price') || 0;
			var newPrice = qty * basePrice;

			dynamicPrice.text(wc_format_price(newPrice));
		}
	}

	// update dynamic price
	function updateDynamicPrice() {
		var dynamicPrice = $('#dynamic-price');
		if (dynamicPrice.length) {
			var basePrice = parseFloat(dynamicPrice.text().replace(/[^0-9.]/g, '')) || 0;
			dynamicPrice.data('base-price', basePrice);
			updatePrice();
		}
	}

	function wc_format_price(price) {
		var currencySymbol = $('#dynamic-price').data('currency-symbol') || '$';
		var formattedPrice = price % 1 === 0 ? price.toFixed(0) : price.toFixed(2);

		return currencySymbol + formattedPrice;
	}

	function addPlaceHolderToSearchField() {
		var searchInput = $('#searchform #s');
		if (searchInput.length) {
			searchInput.attr('placeholder', 'Search'); // Set placeholder text
		}
	}

	function handleChangeQuantityProduct() {
		$(document).on('change', '.quantity input.qty', function () {
			updatePrice();
		});

		$(document).on('click', '.quantity .plus, .quantity .minus', function () {
			var qty = $(this).closest('.quantity').find('input.qty');
			var val = parseFloat(qty.val()) || 0;
			var max = parseFloat(qty.attr('max')) || Infinity;
			var min = parseFloat(qty.attr('min')) || 0;
			var step = parseFloat(qty.attr('step')) || 1;

			if ($(this).hasClass('plus')) {
				qty.val(val + step <= max ? (val + step).toFixed(step % 1 === 0 ? 0 : 1) : max);
			} else if ($(this).hasClass('minus')) {
				qty.val(val - step >= min ? (val - step).toFixed(step % 1 === 0 ? 0 : 1) : min);
			}

			qty.trigger('change');
		});
	}

	function calculateMegaMenuPosition() {
		const isRTL = $('html').hasClass('rtl-mode');

		$('.mega-menu').each(function () {
			const $menu = $(this);
			const $parent = $menu.closest('.has-mega-menu');

			// Keep vertical style4 flyout position from CSS (left: 100%, top: 0).
			if ($parent.closest('.t888-vertical-menu__list').length) {
				$menu[0].style.left = '';
				$menu[0].style.right = '';
				return;
			}

			const windowWidth = $(window).width();
			const menuWidth = $menu.outerWidth();

			const parentOffset = isRTL
				? windowWidth - ($parent.offset().left + $parent.outerWidth())
				: $parent.offset().left;

			$menu[0].style.left = '';
			$menu[0].style.right = '';

			if (windowWidth < 768) {
				$menu[0].style[isRTL ? 'right' : 'left'] = '0px';
				return;
			}

			if (menuWidth >= windowWidth * 0.6) {
				const offset = (windowWidth - menuWidth) / 2 - parentOffset;
				$menu[0].style[isRTL ? 'right' : 'left'] = `${offset}px`;
			} else {
				$menu[0].style[isRTL ? 'right' : 'left'] = '0px';
			}
		});
	}

	function handleElementorScript() {

		// editor mode
		if ($('.elementor-editor-active').length) {
			function waitForAllElements(selector, callback) {
				// Set store all elements that have been handled
				const handledElements = new Set();

				function checkElements() {
					const elements = document.querySelectorAll(selector);
					elements.forEach(el => {
						if (!handledElements.has(el)) {
							handledElements.add(el);
							callback(el);
						}
					});
				}

				// check imediatly first timetime
				checkElements();

				// Create a MutationObserver to watch for changes in the DOM
				const observer = new MutationObserver(() => {
					checkElements();
				});

				observer.observe(document.body, {
					childList: true,
					subtree: true,
				});
			}

			// call in editor mode
			if (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode()) {
				waitForAllElements('.eltech888-swiper-slider', function (el) {
					$(window).trigger('resize');
				});
			}
		}
		// frontend mode
		$(window).on('elementor/frontend/init', function () {
			if (window.elementorFrontend) {
				// call init all slider in frontend mode
				tech888_swiper_slider();
				elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) {
					//  todo for specific element
				});

				elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
					//  todo for specific element
				});

				elementorFrontend.hooks.addAction('elementor/frontend/init', function () {
					// Do something that is based on the elementorFrontend object.
				});
			}
		});
	}

	function updatePriceDisplay($wrapper, variations, productId) {
		const $priceBox = $('#price-display-' + productId);
		const selectedAttributes = {};

		$wrapper.find('select').each(function () {
			const key = $(this).data('attribute_name');
			const val = $(this).val();
			if (val) selectedAttributes[key] = val;
		});

		const requiredCount = $wrapper.find('select').length;
		if (Object.keys(selectedAttributes).length < requiredCount) {
			$priceBox.html('');
			return;
		}

		const match = variations.find(function (v) {
			return Object.entries(v.attributes).every(function ([k, val]) {
				return selectedAttributes[k] === val;
			});
		});

		if (match && match.price_html) {
			$priceBox.html(match.price_html);
		} else {
			$priceBox.html('<span class="no-price">Price not found</span>');
		}
	}

	function updateResetButtonVisibility() {
		const $form = $('.variations_form');
		const allSelected = $form.find('.variations select').toArray().every(function (select) {
			return $(select).val() !== '';
		});
		if (allSelected) {
			$('.reset_variations').show();
		} else {
			$('.reset_variations').hide();
		}
	}

	function enableSelectOptionButton($btn) {
		// return if the button is not inside a product item list default with ajax add to cart
		if (!$btn.parents('.list-product-item.ajax_add_to_cart').length)
			return;
		let $parent = $btn.parents('.list-product-item.ajax_add_to_cart');
		let productData = $parent.find('.variations_form').data("product_variations");
		if (!productData || !productData.length) {
			console.warn('No product variations found for this item.');
			return;
		}
		$btn.parents('.list-product-item.ajax_add_to_cart').find('select').map(function () {
			const $select = $(this);

			const attributeName = $select.data('attribute_name');
			const selectedValue = $select.val();
			if (selectedValue) {
				productData = productData.filter(variation => variation.attributes[attributeName] === selectedValue
				);
			}

			return productData;
		});

		if (productData.length == 0 || productData.length > 1) {
			console.warn('No valid product variations found after filtering.');

		} else {
			$parent.find('.product-actions .add_to_cart_button').removeAttr('disabled');
		}
	}

	// this function affected to product page and shop list item
	function handleVariationButtons() {
		$('.loop-product-variations, .variations_form').each(function () {
			const $wrapper = $(this);
			const productId = $wrapper.data('product_id');

			let variations = [];
			const rawJson = $wrapper.attr('data-product_variations') || $wrapper.attr('data-variations');
			try {
				variations = JSON.parse(rawJson);
			} catch (e) {
				console.warn('Variations cannot be parsed:', rawJson);
				return;
			}

			$wrapper.find('.variation-button').on('click', function () {

				const $btn = $(this);
				const value = $btn.data('value');
				const attributeWrapper = $btn.closest('.detail-attr, .variation-group');
				const selectBox = attributeWrapper.find('select');

				attributeWrapper.find('.variation-button').removeClass('selected');
				$btn.addClass('selected');

				selectBox.val(value).trigger('change');

				$('.variations_form').trigger('woocommerce_update_variation_values');
				$('.variations_form').trigger('check_variations');
				enableSelectOptionButton($btn);
				updatePriceDisplay($wrapper, variations, productId);
				updateResetButtonVisibility();
			});
		});

		$('.reset_variations').on('click', function (e) {
			e.preventDefault();
			$('.variation-button').removeClass('selected');
			$('.variations_form .variations select').val('').trigger('change');
			$('.variations_form').trigger('woocommerce_update_variation_values');
			$('.variations_form').trigger('check_variations');
			updateResetButtonVisibility();
		});

		updateResetButtonVisibility();
	}

	window.handleVariationButtons = handleVariationButtons;

	function initSharePopup() {
		$('.product-guide .share').on('click', function (e) {
			e.preventDefault();
			const $guide = $(this).closest('.product-guide');
			const $popup = $guide.find('.share-popup');

			// Toggle popup visibility
			$('.share-popup').not($popup).hide(); // hide others
			$popup.toggle();
		});

		// Click outside to close
		$(document).on('click', function (e) {
			if (!$(e.target).closest('.product-guide').length) {
				$('.share-popup').hide();
			}
		});
	}
	function initShippingPopup() {
		const $popup = $('#popup-shipping');
		if (!$popup.length) return;
		if (!$popup.data('moved')) {
			$popup.appendTo('body').data('moved', true);
		}
		$popup.removeAttr('style');

		// Helpers
		const openPopup = () => {
			$('.shipping-popup').not($popup).removeClass('is-open');

			$('body').addClass('no-scroll');

			void $popup[0].offsetWidth;
			$popup.addClass('is-open');
		};

		const closePopup = () => {
			$('body').removeClass('no-scroll');
			$popup.removeClass('is-open');
		};

		$('.guide-wrapper .shipping')
			.off('click.shipping').on('click.shipping', function (e) {
				e.preventDefault();
				openPopup();
				return false;
			});

		$popup.find('.close-popup')
			.off('click.shipping').on('click.shipping', function (e) {
				e.preventDefault();
				closePopup();
			});

		$popup.off('click.bg').on('click.bg', function (e) {
			if (!$(e.target).closest('.modal-content').length) {
				closePopup();
			}
		});

		$popup.find('.modal-content')
			.off('click.inner').on('click.inner', function (e) { e.stopPropagation(); });

		$(document).off('keydown.shipping').on('keydown.shipping', function (e) {
			if (e.key === 'Escape') closePopup();
		});
	}



	function initMegaMenuPreview(menuSelector = '.mega-menu-list li', previewSelector = '.previewImageWrapper img') {
		const $items = jQuery(menuSelector);
		const $preview = jQuery(previewSelector);
		const currentPath = normalizePath(window.location.pathname);
		let $defaultItem = null;
		let defaultImg = '';
		let currentLink = '';

		function normalizePath(path) {
			if (!path || path === '/') return '/';
			return path.replace(/\/$/, '');
		}

		const $fallbackItem = $items.first();

		$items.each(function () {
			const $item = jQuery(this);
			const link = normalizePath($item.data('link') || '');
			const imgSrc = $item.data('img');

			if (link === currentPath) {
				$item.addClass('active');
				$defaultItem = $item;
				defaultImg = imgSrc;
				currentLink = link;
				$preview.attr('src', imgSrc);
			}
		});

		if (!$defaultItem && $fallbackItem.length) {
			$fallbackItem.addClass('active');
			$defaultItem = $fallbackItem;
			defaultImg = $fallbackItem.data('img');
			currentLink = normalizePath($fallbackItem.data('link') || '');
			$preview.attr('src', defaultImg);
		}

		$items.on('mouseenter', function () {
			const $item = jQuery(this);
			const imgSrc = $item.data('img');
			const link = normalizePath($item.data('link') || '');

			$items.removeClass('active');
			$item.addClass('active');
			$preview.attr('src', imgSrc);
			currentLink = link;
		});

		jQuery('.mega-menu-wrapper').on('mouseleave', function () {
			if ($defaultItem && defaultImg) {
				$items.removeClass('active');
				$defaultItem.addClass('active');
				$preview.attr('src', defaultImg);
				currentLink = normalizePath($defaultItem.data('link') || '');
			}
		});

		$items.on('click', function () {
			const link = jQuery(this).data('link');
			if (link) window.location.href = link;
		});

		$preview.on('click', function () {
			const now = normalizePath(window.location.pathname);
			if (currentLink && currentLink !== now) {
				window.location.href = currentLink;
			} else if (currentLink === '/') {
				window.location.href = '/';
			}
		});
	}


	function enableStickyOnScroll(selector = '.sticky-on') {
		jQuery(function ($) {
			var $header = $('header[data-enable-sticky="1"]');
			var $stickyEl = $(selector);

			if ($header.length === 0 || $stickyEl.length === 0) return;

			var stickyOffset = $stickyEl.offset().top;

			$(window).on('scroll', function () {
				var scrollTop = $(window).scrollTop();

				if (scrollTop === 0) {
					$stickyEl.removeClass('is-sticky-active');
					$('body').removeClass('scrolled');
					return;
				}
				if (scrollTop >= stickyOffset) {
					$stickyEl.addClass('is-sticky-active');
					$('body').addClass('scrolled');
				} else {
					$stickyEl.removeClass('is-sticky-active');
					$('body').removeClass('scrolled');
				}
			});
		});
	}


	function initThemeColorSwitcher() {
		const colorVars = ['--primary-color', '--third-color'];

		function changeThemeColor(cssVar, color) {
			if (!cssVar || !color) return;

			document.documentElement.style.setProperty(cssVar, color);
			localStorage.setItem(`tacheThemeColor-${cssVar}`, color);

			const selector = `.switch-color[data-var="${cssVar}"][data-color="${color}"]`;
			jQuery(`.switch-color[data-var="${cssVar}"]`).removeClass('active');
			jQuery(selector).addClass('active');
		}

		colorVars.forEach(function (cssVar) {
			const savedColor = localStorage.getItem(`tacheThemeColor-${cssVar}`);
			if (savedColor) {
				changeThemeColor(cssVar, savedColor);
			}
		});

		jQuery(document).on('click', '.switch-color', function () {
			const cssVar = jQuery(this).data('var');
			const color = jQuery(this).data('color');
			changeThemeColor(cssVar, color);
		});
		window.changeThemeColor = changeThemeColor;
	}

	function initColorSwitcherToggle(toggleBtnSelector = '#t888ToggleSwitcher', panelSelector = '#color-switcher', floatingBtnSelector = '.t888-floating-buttons') {
		jQuery(function ($) {
			$(toggleBtnSelector).on('click', function () {
				$(panelSelector).toggleClass('open');
				$(floatingBtnSelector).toggleClass('pushed');

				const isOpen = $(panelSelector).hasClass('open');
				$(this).find('span').text(isOpen ? 'Close' : 'Open');
				$(this).toggleClass('open');
			});
			$(document).on('click', '.js-color-switcher-trigger, .js-color-switcher-trigger > a', function (e) {
				e.preventDefault();
				e.stopPropagation();
				$('#t888ToggleSwitcher').trigger('click');
			});
		});
	}

	function hidePreloader(duration = 500) {
		const $preloader = jQuery('#preloader');
		if ($preloader.length) {
			$preloader.fadeOut(duration);
		}
	}

	// left to right and right to left
	function initDirectionToggle() {
		jQuery(document).ready(function ($) {
			const html = $('html');

			function applyDirection(dir) {
				html.attr('dir', dir);
				html.toggleClass('rtl-mode', dir === 'rtl');
				localStorage.setItem('siteDirection', dir);

				setTimeout(function () {
					if (typeof window.reInitFeatureProductSwiper === 'function') {
						window.reInitFeatureProductSwiper();
					}
				}, 100);
			}

			$('#toggle-direction').on('click', function (e) {
				e.preventDefault();
				const currentDir = html.attr('dir') || 'ltr';
				const newDir = currentDir === 'rtl' ? 'ltr' : 'rtl';
				applyDirection(newDir);
			});

			const savedDir = localStorage.getItem('siteDirection');
			if (savedDir && savedDir !== html.attr('dir')) {
				applyDirection(savedDir);
			}
		});
	}

	function handleCompareScript() {
		// fix close popup compare when click on close button scroll to top
		$(document).on('click', 'a.yith-woocompare-popup-close', function (e) {
			e.preventDefault(); // prevent the default link action (like jumping to #)
			// This will not re-trigger this exact handler due to jQuery handling recursion
			$(document).find('.yith-compare-button i.la-circle-notch')
				.removeClass('las la-circle-notch spinner').addClass('la la-check');
			this.click();
		});

		$(document).on('click', '.yith-compare-button', function (e) {
			e.preventDefault();
			$(this).find('i').removeClass('la la-refresh').addClass('las la-circle-notch spinner');
			this.click(); // This will trigger the default action of the button
		});
	}

	function handleWishListScript() {
		var tracker = {};
		try { tracker = JSON.parse(localStorage.getItem('nebon_wl_trk')) || {}; } catch(e) {}
		function saveTracker() { localStorage.setItem('nebon_wl_trk', JSON.stringify(tracker)); }

		var ignoreDomSyncFor = {};

		// ========= HELPER: Force heart red =========
		function forceHeartAdded($wrapper) {
			$wrapper.addClass('is-added');
			var $icon = $wrapper.find('.icon-layer i');
			$icon.removeClass('lar la-heart').addClass('las la-heart');
			$icon.css('color', '#c8605f');
			
			// Sync native tooltip name
			var $yithLink = $wrapper.find('.btn-layer a');
			if ($yithLink.length && $yithLink.text().trim() !== '') {
				$wrapper.attr('title', $yithLink.text().trim());
			}
		}

		// ========= HELPER: Reset heart =========
		function resetHeart($wrapper) {
			$wrapper.removeClass('is-added');
			var $icon = $wrapper.find('.icon-layer i');
			$icon.removeClass('las').addClass('lar');
			$icon.css('color', '');

			var $yithLink = $wrapper.find('.btn-layer a');
			if ($yithLink.length && $yithLink.text().trim() !== '') {
				$wrapper.attr('title', $yithLink.text().trim());
			} else {
				$wrapper.attr('title', 'Wishlist'); // Default
			}
		}

		// ========= 1. CAPTURING CLICK HANDLER =========
		document.addEventListener('click', function(e) {
			var wrapper = e.target.closest('.action-btn.wishlist-btn');
			if (!wrapper) return;
			
			var pid = String(wrapper.getAttribute('data-product-id'));
			var targetA = e.target.closest('a');
			if (!targetA || !pid || pid === 'undefined') return;

			var isYithRemove = targetA.classList.contains('delete_item') || targetA.classList.contains('remove_from_wishlist') || targetA.getAttribute('data-action') === 'remove';
			var isYithAdd = targetA.classList.contains('add_to_wishlist') || targetA.getAttribute('data-action') === 'add';

			if (isYithRemove) {
				delete tracker[pid];
				saveTracker();
				ignoreDomSyncFor[pid] = Date.now() + 2000;
				resetHeart($(wrapper));
			} else if (isYithAdd) {
				if (tracker[pid]) {
					// Block accidental re-adding if it's already explicitly tracked locally.
					// This answers the user's issue where "it's red but still adds successfully"
					e.preventDefault();
					e.stopPropagation();
				} else {
					tracker[pid] = true;
					saveTracker();
					ignoreDomSyncFor[pid] = Date.now() + 2000;
					forceHeartAdded($(wrapper));
				}
			}
		}, true); 

		// ========= 2. YITH EVENTS & GLOBAL REMOVAL FALLBACK =========
		$(document).on('removed_from_wishlist', function(e, fragments, cart_hash, $button) {
			if ($button && $button.length) {
				var $wrapper = $button.closest('.action-btn.wishlist-btn');
				var pid = String($wrapper.attr('data-product-id'));
				if (pid && pid !== 'undefined') {
					delete tracker[pid];
					saveTracker();
					ignoreDomSyncFor[pid] = Date.now() + 2000;
					resetHeart($wrapper);
				}
			}
		});

		// Fallback for removals from other interfaces (AJAX Payload parsing)
		$(document).ajaxComplete(function(event, xhr, settings) {
			if (settings && settings.data && typeof settings.data === 'string') {
				var rmMatch = settings.data.match(/remove_from_wishlist=(\d+)/);
				if (rmMatch && rmMatch[1]) {
					delete tracker[rmMatch[1]];
					saveTracker();
				}
			}
		});

		// ========= 3. UI SYNC =========
		function syncUI() {
			$('.action-btn.wishlist-btn').each(function() {
				var $wrapper = $(this);
				var pid = String($wrapper.attr('data-product-id'));
				if (!pid || pid === 'undefined') return;

				var isTracked = tracker[pid] === true;
				
				var yithHtmlClaimsAdded = $wrapper.find('.delete_item, .yith-wcwl-wishlistaddedbrowse, .yith-wcwl-wishlistexistsbrowse, .exists, a[data-action="remove"]').length > 0;
				
				// Wait 2s after a click before trusting DOM again to bypass Race Conditions
				var canTrustDom = !ignoreDomSyncFor[pid] || Date.now() > ignoreDomSyncFor[pid];

				if (canTrustDom && yithHtmlClaimsAdded) {
					if (!isTracked) {
						tracker[pid] = true;
						saveTracker();
						isTracked = true;
					}
				}

				if (isTracked) forceHeartAdded($wrapper);
				else resetHeart($wrapper);
			});
		}

		syncUI();
		setInterval(syncUI, 300);

		// Visually fallback for loading icons if YITH native clicks are allowed
		$(document).on('click', '.add_to_wishlist', function () {
			var $wrapper = $(this).closest('.action-btn.wishlist-btn');
			var pid = String($wrapper.attr('data-product-id'));
			if (!tracker[pid]) {
				if ($wrapper.length) $wrapper.find('.icon-layer i').removeClass('la la-heart las lar').addClass('las la-circle-notch la-spin');
			}
		});
	}

	function initMobileMenuTabs() {
		jQuery(document).on('click', '.mobile-menu-tabs .tab-btn', function () {
			var $btn = jQuery(this);
			var target = $btn.data('tab');

			$btn.addClass('active').siblings().removeClass('active');
			jQuery('.mobile-menu-content .tab-content').removeClass('active');
			jQuery('#' + target).addClass('active');
		});
	}

	function initMasonryGrid() {
		var $grid = $('.masonry-grid');

		if ($grid.length) {
			var msnry = $grid.masonry({
				itemSelector: '.grid-item',
				columnWidth: '.grid-sizer',
				percentPosition: true
			});

			$grid.imagesLoaded().progress(function () {
				msnry.masonry('layout');
			});
		}
	}

	function applyPagiOffset(selector = '.pagi-nav.style2 .pagi-link-wrap', offsetPx = -50) {
		jQuery(selector).each(function () {
			const $w = jQuery(this);
			const empty = $w.children().length === 0 && jQuery.trim($w.text()) === '';
			$w.css('margin-top', empty ? (offsetPx + 'px') : '');
		});
	}

	function set_theme_colors(cfg) {
    if (!cfg) return;
    var root = document.documentElement;

    if (cfg.primary)          root.style.setProperty('--primary-color', cfg.primary);
    if (cfg.primary_switch)   root.style.setProperty('--primary-color-switch', cfg.primary_switch);
    if (cfg.secondary)        root.style.setProperty('--third-color', cfg.secondary);
    if (cfg.secondary_switch) root.style.setProperty('--third-color-switch', cfg.secondary_switch);

    window.tacheThemeColors = cfg;
  }

  if (window.tacheThemeColors) {
    set_theme_colors(window.tacheThemeColors);
  }

  window.set_theme_colors = set_theme_colors;

	applyPagiOffset();
	initMasonryGrid();
	initMobileMenuTabs();
	initDirectionToggle();
	hidePreloader(); // Call the function to hide preloader
	initColorSwitcherToggle();
	enableStickyOnScroll();
	initThemeColorSwitcher();
	initMegaMenuPreview();
	initSharePopup();
	initShippingPopup();
	handleVariationButtons();
	updateDynamicPrice(); // Initialize dynamic price
	addClassToCurrentCate();
	opentoggle_widget();
	custom_filter();
	addPlaceHolderToSearchField();
	handleChangeQuantityProduct();
	// calculateMegaMenuPosition();
	handleElementorScript();
	handleCompareScript();
	handleWishListScript();

	// init slider for page not elementor template
	if (!$('.elementor-page').length) {
		tech888_swiper_slider();
	}

	$(window).on('resize', function () {
		tech888_swiper_slider();
		initMasonryGrid();
	});
	$(window).on('resize', calculateMegaMenuPosition);
	$('.has-mega-menu').on('mouseenter', calculateMegaMenuPosition);

	$(window).on('t888f_quickview_loaded', function () {
		handleVariationButtons();
	});


});



jQuery(function ($) {
	const S = {
		panel: '.widget-area',
		overlay: '.filter-overlay',
		toggle: '.btn-toggle-filter',
		close: '.btn-close-filter'
	};

	function openFilter() {
		$(S.panel).addClass('show');
		$(S.overlay).addClass('show');
		$('body').addClass('no-scroll');
	}

	function closeFilter() {
		$(S.panel).removeClass('show');
		$(S.overlay).removeClass('show');
		$('body').removeClass('no-scroll');
	}

	if (!$(S.overlay).length) {
		$('body').append('<div class="filter-overlay"></div>');
	}

	$(document)
		.off('click.t888', S.toggle)
		.on('click.t888', S.toggle, function (e) { e.preventDefault(); openFilter(); });

	$(document)
		.off('click.t888c', S.close)
		.on('click.t888c', S.close, function (e) { e.preventDefault(); closeFilter(); });

	$(document)
		.off('click.t888o', S.overlay)
		.on('click.t888o', S.overlay, function (e) { e.preventDefault(); closeFilter(); });

	$(document).on('shop_ajax_content_loaded t888_shop_filtered', function () {
		$('body').removeClass('no-scroll');
	});
});



