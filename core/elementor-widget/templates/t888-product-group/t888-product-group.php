<?php if (!isset($products) || empty($products)) return; ?>

<div class="t888-product-group style1">

    <div class="product-group-left">

        <?php foreach ($products as $product) :
            $image_id = $product->get_image_id();
            $image_url = wp_get_attachment_image_url($image_id, 'medium_large');

        ?>
            <div class="product-box">
                <div class="product-image">
                    <div class="product-img">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
                    </div>

                    <div class="product-hover-trigger"></div>

                    <div class="product-hover-info">
                        <a href="<?php echo esc_url(get_permalink($product->get_id())); ?>" class="product-hover-link">
                            <div class="name"><?php echo esc_html($product->get_name()); ?></div>
                            <div class="price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                        </a>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <div class="product-group-right">
        <div class="routine-title">
            <?php echo esc_html($title); ?>
        </div>
        <h3 class="group-heading">
            <?php echo esc_html($heading); ?>
        </h3>

        <?php foreach ($products as $product) :
            $image_id = $product->get_image_id();
            $image_url = wp_get_attachment_image_url($image_id, 'medium_large');
            $permalink = get_permalink($product->get_id());
        ?>
            <div class="group-item d-flex ">
                <div class="item-thumb">
                    <a href="<?php echo esc_url($permalink); ?>" class="item-thumb-inner">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
            </a>
                </div>
                <div class="item-content">
                    <a href="<?php echo esc_url($permalink); ?>" class="product-name">
                <?php echo esc_html($product->get_name()); ?>
            </a>
                    <div class="price">
                        <?php echo wp_kses_post($product->get_price_html()); ?>
                    </div>
                    <div class="actions d-flex">
                        <?php
                        $GLOBALS['product'] = wc_get_product($product->get_id());
                        woocommerce_template_loop_add_to_cart();

                        do_action('t888f_custom_add_wishlist_compare_buttons', $product->get_id(), $product);
                        ?>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>

        <?php
        $product_ids = array_map(function ($p) {
            return $p->get_id();
        }, $products);
        ?>

        <div class="add-set-to-cart button">
            <button type="button" class="btn add-set-to-cart-btn" 
                data-products='<?php echo json_encode($product_ids); ?>'>
                <?php echo __('Add Set to Cart', 'nebon'); ?>
            </button>
        </div>


    </div>

</div>