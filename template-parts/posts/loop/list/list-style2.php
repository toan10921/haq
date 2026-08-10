<div class="item-post-list list-style2">
    <div class="post-thumb">
        <a href="<?php echo get_the_permalink(); ?>" class="post-thumb-link  default-zoom">
            <?php
            $custom_size_raw = get_theme_mod('blog_list_item_size', '');
            $thumb_size = 'post-list';

            if (!empty($custom_size_raw) && preg_match('/^(\d+)x(\d+)$/', trim($custom_size_raw), $m)) {
                $w = (int) $m[1];
                $h = (int) $m[2];
                $dynamic = "custom_post_list_{$w}x{$h}";

                global $_wp_additional_image_sizes;
                if (!isset($_wp_additional_image_sizes[$dynamic])) {
                    add_image_size($dynamic, $w, $h, true);
                }
                $thumb_size = $dynamic;
            }

            if (has_post_thumbnail()) :
                the_post_thumbnail($thumb_size, array('class' => 'img-responsive'));
            else :
                $fallback_custom = get_theme_mod('general_post_thumbnail_default', '');
                if (!empty($fallback_custom)) {
                    echo '<img class="img-responsive" src="' . esc_url($fallback_custom) . '" alt="' . esc_attr(get_the_title()) . '">';
                } else {
                    echo '<img class="img-responsive d-block" src="' . esc_url(get_template_directory_uri() . '/assets/images/1040x563.png') . '" alt="' . esc_attr(get_the_title()) . '">';
                }
            endif;
            ?>
        </a>
    </div>
    <div class="post-info">
        <h3 class="post-title m-0">
            <a class="" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
        </h3>
        <div class="post-meta">
            <span class="date"><?php echo get_the_date('M .j .Y'); ?></span>
            <span class="category"><?php echo get_the_category_list(', '); ?></span>
        </div>
        <div class="post-excerpt">
            <p>
                <?php
                $excerpt = get_the_excerpt();
                $excerpt_trimmed = wp_trim_words($excerpt, '55', '');
                echo rtrim($excerpt_trimmed, ".,;:!?") . '...';
                ?>
            </p>
        </div>
        <div class="read-more-share-wrap d-flex flex-wrap">
            <a href="<?php echo get_the_permalink(); ?>" class="read-more d-inline-block primary button"><?php esc_html_e('Read More', 'nebon'); ?></a>
        </div>
    </div>
</div>