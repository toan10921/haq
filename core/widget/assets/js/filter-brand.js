jQuery(document).ready(function($) {
    $(".brand-filter-checkbox").on("change", function() {
        // this script only works when not in ajax mode
        if ($('#products-ajax-wrapper').length) return;
        let selectedBrands = $(".brand-filter-checkbox:checked").map(function() {
            return $(this).val();
        }).get();

        let urlParams = new URLSearchParams(window.location.search);
        if (selectedBrands.length > 0) {
            urlParams.set("brand", selectedBrands.join(","));
        } else {
            urlParams.delete("brand");
        }

        window.location.search = urlParams.toString();
    });
});
