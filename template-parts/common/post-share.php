<?php
$socials = get_theme_mod('list_share_social', []);

$social_data = array(
    'facebook' => [
        'link' => 'https://www.facebook.com/sharer/sharer.php?u=' . esc_url(get_the_permalink()),
        'icon' => 'lab la-facebook-f'
    ],
    'pinterest' => [
        'link' => 'https://pinterest.com/pin/create/button/?url=' . esc_url(get_the_permalink()) . '&media=' . esc_url(get_the_post_thumbnail_url(get_the_ID())) . '&description=' . esc_html(get_the_title()),
        'icon' => 'lab la-pinterest-p'
    ],
    'instagram' => [
        'link' => 'https://www.instagram.com/',
        'icon' => 'lab la-instagram'
    ],

    // 'tiktok' => [
    //     'link' => 'https://www.tiktok.com/share?url=' . esc_url(get_the_permalink()),
    //     'icon' => 'fa-brands fa-tiktok'
    // ],
    'youtube' => [
        'link' => 'https://www.youtube.com/',
        'icon' => 'lab la-youtube'
    ],
    'twitter' => [
        'link' => 'https://twitter.com/intent/tweet?text=' . esc_html(get_the_title()) . '&url=' . esc_url(get_the_permalink()),
        'icon' => 'lab la-twitter'
    ],
    'linkedin' => [
        'link' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . esc_url(get_the_permalink()) . '&title=' . esc_html(get_the_title()),
        'icon' => 'lab la-linkedin-in'
    ],

    'whatsapp' => [
        'link' => 'https://api.whatsapp.com/send?text=' . esc_url(get_the_permalink()),
        'icon' => 'lab la-whatsapp'
    ],
    'telegram' => [
        'link' => 'https://telegram.me/share/url?url=' . esc_url(get_the_permalink()) . '&text=' . esc_html(get_the_title()),
        'icon' => 'lab la-telegram'
    ],
    'email' => [
        'link' => 'mailto:?subject=' . esc_html(get_the_title()) . '&body=' . esc_url(get_the_permalink()),
        'icon' => 'las la-envelope'
    ],
);
?>
<div class="post-share">
    <h4 class="post-share-title">
        <?php echo __('Share', 'nebon'); ?>
    </h4>

    <ul class="list-social m-0 p-0 list-none d-flex flex-wrap align-items-center">
        <?php
        if (is_array($socials) && !empty($socials)) {
            foreach ($socials as $social) {
                if (isset($social_data[$social])) {
                    echo '<li>
                            <a class="d-flex justify-content-center align-items-center" href="' . esc_url($social_data[$social]['link']) . '" target="_blank">
                                <i class="' . esc_attr($social_data[$social]['icon']) . '"></i>
                            </a>
                          </li>';
                }
            }
        }
        ?>
    </ul>
</div>