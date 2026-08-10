jQuery(document).ready(function($) {
    $('.t888-video-wrapper').each(function() {
        var $wrapper = $(this),
            $overlay = $wrapper.find('.t888-video-overlay'),
            $frame   = $wrapper.find('.t888-video-frame');

        var videoType    = t888VideoSettings.videoType,
            youtubeID    = t888VideoSettings.youtubeID,
            videoURL     = t888VideoSettings.uploadedVideo,
            autoplay     = t888VideoSettings.autoplay,
            mute         = t888VideoSettings.mute,
            loop         = t888VideoSettings.loop,
            controls     = t888VideoSettings.controls;

        if ($overlay.length) {
            $overlay.on('click', function() {
                var $player;

                if (videoType === 'youtube') {
                    var src = "https://www.youtube.com/embed/" + youtubeID +
                        "?autoplay=1&mute=" + mute + "&loop=" + loop ;

                    $player = $('<iframe>', {
                        src: src,
                        frameborder: 0,
                        allowfullscreen: true,
                        allow: "autoplay; encrypted-media",
                        css: {
                            width: '100%',
                            height: '100%',
                            position: 'absolute',
                            top: 0,
                            left: 0
                        }
                    });

                } else if (videoType === 'upload') {
                    $player = $('<video>', {
                        src: videoURL,
                        autoplay: autoplay ? true : false,
                        muted: mute ? true : false,
                        loop: loop ? true : false,
                        
                        css: {
                            width: '100%',
                            height: '100%',
                            objectFit: 'cover',
                            position: 'absolute',
                            top: 0,
                            left: 0
                        }
                    });

                }

                $overlay.hide();
                $frame.css('display', 'block').append($player);
            });
        }
    });
});
