<?php
if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();

        $product = wc_get_product(get_the_ID());
        if (!$product || !$product->is_visible()) continue;

        global $post;
        $post = get_post($product->get_id());
        setup_postdata($post);

        ob_start();
?>
        <div class="product-item">
            <?php
            t888f_get_template(
                $template_view,
                $slug,
                ['product' => $product],
                true
            );
            ?>
        </div>
<?php
        echo ob_get_clean();

    endwhile;
    wp_reset_postdata();
endif;
