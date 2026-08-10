jQuery(document).ready(function($) {
    // listen for reply link click
    $(document).on('click', '.comment-reply-link', function() {
        console.log('Reply link clicked');
        $('.leave-comments').addClass('d-none');

        // get current li
        var $li = $(this).closest('li');
        $li.addClass('replying');

        // remove replying class from other li
        $li.siblings().removeClass('replying');
    });

    // listen for cancel reply link click
    $(document).on('click', '#cancel-comment-reply-link', function() {
        console.log('Cancel reply link clicked');
        $('.leave-comments').removeClass('d-none');
        $('li').removeClass('replying');
    });
});