<?php
$image_url       = !empty($image['url']) ? $image['url'] : '';
$link_url        = !empty($link['url']) ? $link['url'] : '';
$link_target     = !empty($link['is_external']) ? '_blank' : '_self';
?>
<div class="image-link-box-item">
    <?php if ($link_url) : ?>
        <a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
        <?php endif; ?>

        <div class="image-wrapper">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
        </div>

        <div class="image-content position-<?php echo esc_attr( $content_position ); ?>">
            <?php if ($title) : ?>
                <h3><?php echo esc_html($title); ?></h3>
            <?php endif; ?>
            <?php if ($sub_title) : ?>
                <p><?php echo esc_html($sub_title); ?></p>
            <?php endif; ?>
            <?php if ($button_text) : ?>
                <span class="link-button"><?php echo esc_html($button_text); ?></span>
            <?php endif; ?>
        </div>

        <?php if ($link_url) : ?>
        </a>
    <?php endif; ?>
</div>