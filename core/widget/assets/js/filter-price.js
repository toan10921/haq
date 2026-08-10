jQuery(document).ready(function ($) {
    // this script only works when not in ajax mode
    if ($('#products-ajax-wrapper').length) return;
    let minInput = $("#price-min");
    let maxInput = $("#price-max");
    let maxLimit = $("#price-max-limit").val();
    let minValue = $("#price-min-value");
    let maxValue = $("#price-max-value");
    let filterButton = $("#apply-price-filter");

    let currentMin = parseInt(minInput.val());
    let currentMax = parseInt(maxInput.val());

    $("#price-range").slider({
        range: true,
        min: 0,
        max: parseInt(maxLimit),
        values: [currentMin, currentMax],
        slide: function (event, ui) {
            minValue.text(ui.values[0]);
            maxValue.text(ui.values[1]);
            minInput.val(ui.values[0]);
            maxInput.val(ui.values[1]);
        }
    });

    filterButton.on("click", function () {
        let minPrice = minInput.val();
        let maxPrice = maxInput.val();
        let url = new URL(window.location.href);
        url.searchParams.set("min_price", minPrice);
        url.searchParams.set("max_price", maxPrice);
        window.location.href = url.toString();
    });
});
