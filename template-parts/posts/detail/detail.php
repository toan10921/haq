<div class="content-single-blog <?php echo (is_sticky()) ? 'sticky' : '' ?>">
    <div class="content-post-default ">
        <div class="single-post-default-wrap clearfix">
            <div class="single-post-info">
                <?php
                $short_description = get_post_meta(get_the_ID(), 'short_description', true);
                if (!empty($short_description)) : ?>
                    <div class="short-description-post">
                        <?php echo wp_kses_post($short_description); ?>
                    </div>
                <?php endif; ?>
                <div class="post-meta">
                    <span class="date"><?php echo get_the_date('M .j .Y'); ?></span>
                    <span class="category"><?php echo get_the_category_list(', '); ?></span>
                </div>
                <?php
                // display post thumbnail
                t888f_get_template('posts/detail/format-media', '', [
                    'hide_thumbnail' => $hide_thumbnail,
                ], true);
                ?>
                <div class="detail-content-wrap">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
</div>