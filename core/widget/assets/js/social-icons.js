jQuery(document).ready(function ($) {

    $(document).on('focus', '.popover-title', function (e) {
        $(this).parents('.iconpicker-popover').find('.popover-content').show();
    });

    $(document).on('click', '[data-type="iconpicker-item"]', function () {
        let fontAwesomeClass = $(this).attr('class');
        $(this).parents('.iconpicker-popover').find('.popover-title input[type="search"]').val(fontAwesomeClass);
        $(this).parents('.iconpicker-popover').find('.popover-content').hide();
    });

    $(document).on('click', '.remove-item', function () {
        $(this).parents('.iconpicker-popover').remove();
    });

    $(document).on('click', '.btn-add-social' , function () {
        $(document).find('.iconpicker-popover').first().clone().appendTo('.iconpicker-popover-container');
        // set all valeus to empty
        $(document).find('.iconpicker-popover-container .iconpicker-popover:last').find('input').val('');
    });

    $(document).on('keyup', '.iconpicker-search', function () {
        var search = $(this).val().toLowerCase();

        $(this).parents('.iconpicker-popover').find('.iconpicker-items').find('i').each(function () {
            let text = $(this).attr('class').toLowerCase();
            if (text.indexOf(search) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
});
