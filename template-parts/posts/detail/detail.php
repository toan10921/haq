<div class="content-single-blog <?php echo (is_sticky()) ? 'sticky' : '' ?>">
    <div class="content-post-default ">
        <div class="single-post-default-wrap clearfix">
            <div class="single-post-info">
                <?php
                // display post thumbnail
                t888f_get_template('posts/detail/format-media', '', [
                    'hide_thumbnail' => $hide_thumbnail,
                ], true);
                ?>

                <div class="post-meta" aria-label="<?php esc_attr_e('Post information', 'nebon'); ?>">
                    <span class="author">
                        <?php esc_html_e('By', 'nebon'); ?>
                        <?php the_author_posts_link(); ?>
                    </span>
                    <span class="date"><?php echo esc_html(get_the_date()); ?></span>
                    <span class="category"><?php echo wp_kses_post(get_the_category_list(', ')); ?></span>
                    <span class="comments">
                        <?php
                        $comments_count = get_comments_number();
                        printf(
                            esc_html(_n('%s Comment', '%s Comments', $comments_count, 'nebon')),
                            esc_html(number_format_i18n($comments_count))
                        );
                        ?>
                    </span>
                </div>

                <h1 class="single-post-title"><?php the_title(); ?></h1>

                <?php
                $short_description = get_post_meta(get_the_ID(), 'short_description', true);
                if (!empty($short_description)) : ?>
                    <div class="short-description-post">
                        <?php echo wp_kses_post($short_description); ?>
                    </div>
                <?php endif; ?>

                <div class="detail-content-wrap">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
