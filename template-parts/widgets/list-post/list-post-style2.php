<?php
// dd($data);
extract($data);
$size = array(100, 100);
echo apply_filters('tech888f_output_content', $args['before_widget'] ?? '');

?>
<div class="blog-grid">
    <div class="listpost-style2 posts-wrap grid-columns-3">
        <?php
        if (!empty($title)) :
            echo apply_filters('tech888f_output_content', $args['before_title'] ?? '') . esc_html($title) . apply_filters('tech888f_output_content', $args['after_title'] ?? '');
        endif;
        if ($post_query->have_posts()) :
         
            while ($post_query->have_posts()) :
                $post_query->the_post();
        ?>
                <?php
                t888f_get_template('posts/loop/grid/grid', '', [
                    'post' => get_post(),
                ], true);
                ?>

        <?php
            endwhile;
         
        endif;
        ?>
    </div>
</div>
<?php
wp_reset_postdata();
echo apply_filters('tech888f_output_content', $args['after_widget'] ?? '');
