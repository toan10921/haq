jQuery(document).ready(function($) {
    function handleMediaUploader(button) {
        var custom_uploader;
        // button.on('click', function(e) {
            // e.preventDefault();
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }
            custom_uploader = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            custom_uploader.on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                var inputField = button.prev('.author-image-url');
                var previewImage = button.siblings('.image-preview-outer').find('.author-image-preview');

                inputField.val(attachment.url);
                previewImage.attr('src', attachment.url).show();
            });
            custom_uploader.open();
        // });
    }

    $(document).on('click', '.author-widget-upload-button', function() {
        handleMediaUploader($(this));
    });
});
