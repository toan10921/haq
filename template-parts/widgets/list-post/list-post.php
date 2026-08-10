<?php
extract($data);
$post_size = 'post-thumbnail-widget';

echo apply_filters('tech888f_output_content', $args['before_widget'] ?? '');

?>
<div class="widget widget-content widget-latest-post">
    <?php
    if (!empty($title)) :
        echo apply_filters('tech888f_output_content', $args['before_title'] ?? '') . esc_html($title) . apply_filters('tech888f_output_content', $args['after_title'] ?? '');
    endif;
    if ($post_query->have_posts()) :
        echo '<div class="list-wg-posts">';
        while ($post_query->have_posts()) :
            $post_query->the_post();
    ?>
            <div class="item-wg-post d-flex">
                <div class="post-thumb">
                    <a href="<?php echo get_the_permalink(); ?>" class="post-thumb-link default-zoom">
                        <?php
                        if (has_post_thumbnail()) :
                            the_post_thumbnail($post_size, array('class' => 'img-responsive'));
                        else:
                            echo '<img class="d-block" src="' . get_template_directory_uri() . '/assets/images/100x100.png" alt="' . get_the_title() . '">';
                        endif;
                        ?>
                    </a>
                </div>
                <div class="post-info">
                <h6 class="title-post"><a class="" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h6>
                <span class="date"><?php echo get_the_date('M .j .Y'); ?></span>
                    
                </div>
            </div>
    <?php
        endwhile;
        echo '</div>';
    endif;
    ?>
</div>
<?php
wp_reset_postdata();
echo apply_filters('tech888f_output_content', $args['after_widget'] ?? '');
