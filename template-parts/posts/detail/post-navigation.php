<?php if (get_theme_mod('show_navigation_post', 'on') === 'on') : ?>
    <?php
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    ?>

    <?php if (!empty($prev_post) || !empty($next_post)) : ?>
        <div class="post-navigation d-flex justify-content-between align-items-center">
            <?php if (!empty($prev_post)) : ?>
                <div class="prev-post text-start">
                    <a href="<?php echo get_permalink($prev_post->ID); ?>" class="post-nav-link d-block">
                        <span class="label text-uppercase">
                            <i class="las la-angle-left"></i>
                            <?php _e('Previous Post', 'nebon'); ?>
                        </span>
                        <span class="navigation-title-post">
                            <?php echo esc_html(get_the_title($prev_post->ID)); ?>
                        </span>
                    </a>
                </div>
            <?php else : ?>
                <div></div>
            <?php endif; ?>

            <?php if (!empty($next_post)) : ?>
                <div class="next-post text-end">
                    <a href="<?php echo get_permalink($next_post->ID); ?>" class="post-nav-link d-block">
                        <span class="label text-uppercase">
                            <?php _e('Next Post', 'nebon'); ?>
                            <i class="las la-angle-right"></i>
                        </span>
                        <span class="navigation-title-post">
                            <?php echo esc_html(get_the_title($next_post->ID)); ?>
                        </span>
                    </a>
                </div>
            <?php else : ?>
                <div></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>