<div class="item-post-list list-default">
    <div class="post-thumb">
        <a href="<?php echo get_the_permalink(); ?>" class="post-thumb-link default-zoom">
            <?php
            $custom_size = get_theme_mod('blog_list_item_size', '');
            $size = 'post-list2';

            if (!empty($custom_size) && preg_match('/^(\d+)x(\d+)$/', trim($custom_size), $matches)) {
                $width  = (int) $matches[1];
                $height = (int) $matches[2];

                $dynamic_size = "custom_post_list_{$width}x{$height}";
                global $_wp_additional_image_sizes;
                if (!isset($_wp_additional_image_sizes[$dynamic_size])) {
                    add_image_size($dynamic_size, $width, $height, true);
                }

                $size = $dynamic_size;
            }

            if (has_post_thumbnail()) {
                the_post_thumbnail($size, array('class' => 'img-responsive'));
            } else {
                $fallback_custom = get_theme_mod('general_post_thumbnail_default', '');
                if (!empty($fallback_custom)) {
                    echo '<img class="img-responsive" src="' . esc_url($fallback_custom) . '" alt="' . esc_attr(get_the_title()) . '">';
                } else {
                    echo '<img class="img-responsive" src="' . esc_url(get_template_directory_uri() . '/assets/images/470x400.png') . '" alt="' . esc_attr(get_the_title()) . '">';
                }
            }
            ?>

        </a>
    </div>
    <div class="post-info">
        <h4 class="post-title m-0">
            <a class="" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
        </h4>
        <div class="post-meta">
            <span class="date"><?php echo get_the_date('M .j .Y'); ?></span>
            <span class="category"><?php echo get_the_category_list(', '); ?></span>
        </div>
        <div class="post-excerpt">
            <p><?php echo get_the_excerpt(); ?></p>
        </div>
        <div class="read-more-share-wrap d-flex flex-wrap  justify-content-between">
            <a href="<?php echo get_the_permalink(); ?>" class="read-more d-inline-block primary button"><?php esc_html_e('Read More', 'nebon'); ?></a>
        </div>
    </div>
</div>