<?php
global $product;
$thumb_id = get_post_thumbnail_id();
$attachment_ids = $product->get_gallery_image_ids();

if (empty($thumb_id) && empty($attachment_ids)) {
    $default_image = get_template_directory_uri() . '/assets/images/main-item-default.jpg';
}
$main_item_default = get_template_directory_uri() . '/assets/images/main-item-default.jpg';
$gallery_item_default = get_template_directory_uri() . '/assets/images/gallery-item-default.jpg';
$product_id = $product ? $product->get_id() : get_the_ID();
$default_style = get_theme_mod('product_detail_style_general', 'normal');
$detail_style = get_post_meta($product_id, 'product_detail_style', true);
$detail_style = $detail_style ? $detail_style : $default_style;

?>
<div class="product-detail product-detail--compact container">
    <div class="row rs-wrap-summary product-detail__summary">
        <?php if ($detail_style  === 'sticky') : ?>
            <!-- STYLE 2: Vertical Gallery Sticky -->
            <div class="col-6 thumb-gallery product-detail__gallery sticky-gallery" id="sticky-gallery">
                <div class="vertical-gallery-static">
                    <?php
                    $all_attachments = array_merge([$thumb_id], $attachment_ids);
                    if (empty($all_attachments) || !$all_attachments[0]) {
                        echo '<div class="img-wrap no-image"><img src="' . esc_url($main_item_default) . '" alt="Default" /></div>';
                    } else {
                        foreach ($all_attachments as $id) {
                            echo '<div class="img-wrap ' . ($id ? 'has-image' : 'no-image') . '">';
                            echo '<div class="img-inner">';
                            if ($id) {
                                echo '<a data-fancybox="gallery" href="' . esc_url(wp_get_attachment_url($id)) . '">';
                                echo wp_get_attachment_image($id, 'product_detail_sticky762', false, ['class' => 'wp-post-image']);
                                echo '</a>';
                            } else {
                                echo '<img src="' . esc_url($gallery_item_default) . '" alt="Default" class="wp-post-image" />';
                            }
                            echo '</div></div>';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-6 thumb-gallery product-detail__gallery hidden-desktop">
                <?php if (!empty($thumb_id) || !empty($attachment_ids)) : ?>
                    <div class="detail-gallery">
                        <div class="wrap-detail-gallery">
                            <div class="gallery-thumbs-wrapper">
                                <div class="swiper gallery-thumbs detail-vertical-swiper-slider"
                                    data-items="5"
                                    data-perviewdestop="5"
                                    data-previewtable="3"
                                    data-previewmobile="3"

                                    data-loop="false"
                                    data-navigation="true">
                                    <div class="swiper-wrapper">
                                        <?php
                                        $attachment_ids = array_merge([$thumb_id], $attachment_ids);
                                        
                                        foreach ($attachment_ids as $attachment_id) : ?>
                                            <div class="swiper-slide">
                                                <div class="img-wrap <?php echo esc_attr( $attachment_id ? 'has-image' : 'no-image' ); ?>">
                                                    <div class="img-inner">
                                                        <?php echo apply_filters( 'tech888f_output_content', $attachment_id ? wp_get_attachment_image($attachment_id, 'shop_thumbnail', false) : '<img src="' . esc_url($gallery_item_default) . '" alt="Default image" class="wp-post-image" />' ); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endforeach; ?>
                                    </div>
                                </div>
                                <div class="swiper-button-wraper">
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>
                            <div class="main-gallery-wrapper product-detail__media">
                                <div class="main-gallery">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($attachment_ids as $index => $attachment_id) : ?>
                                            <div class="main-image swiper-slide">
                                                <div class="img-wrap <?php echo esc_attr( $attachment_id ? 'has-image' : 'no-image' ); ?>">
                                                    <div class="img-inner">
                                                        <a data-fancybox="gallery" href="<?php echo esc_url( $attachment_id ? wp_get_attachment_url($attachment_id) : $main_item_default ); ?>">
                                                            <?php echo apply_filters( 'tech888f_output_content', $attachment_id ? wp_get_attachment_image($attachment_id, 'product-detail-main', false, ['class' => 'wp-post-image']) : '<img src="' . esc_url($main_item_default) . '" alt="Default image" class="wp-post-image" />' ); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="img-wrap-default">
                        <img src="<?php echo esc_url($default_image); ?>" alt="<?php echo esc_attr(get_the_title($product->get_id())); ?>" class="wp-post-image" />
                    </div>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <div class="col-6 thumb-gallery product-detail__gallery">
                <?php if (!empty($thumb_id) || !empty($attachment_ids)) : ?>
                    <div class="detail-gallery">
                        <div class="wrap-detail-gallery">
                            <div class="gallery-thumbs-wrapper">
                                <div class="swiper gallery-thumbs detail-vertical-swiper-slider"
                                    data-items="5"
                                    data-perviewdestop="5"
                                    data-previewtable="3"
                                    data-previewmobile="3"

                                    data-loop="false"
                                    data-navigation="true">
                                    <div class="swiper-wrapper">
                                        <?php
                                        $attachment_ids = array_merge([$thumb_id], $attachment_ids);

                                        foreach ($attachment_ids as $attachment_id) :
                                            $class_attachment = $attachment_id ? 'has-image' : 'no-image';
                                            $image_attachment = $attachment_id ? wp_get_attachment_image($attachment_id, 'shop_thumbnail') : '<img src="' . esc_url($gallery_item_default) . '" alt="' . esc_attr(get_the_title($product->get_id())) . '" class="wp-post-image" />';
                                        ?>
                                            <div class="swiper-slide">
                                                <div class="img-wrap <?php echo esc_attr($class_attachment); ?>">
                                                    <div class="img-inner">
                                                        <?php echo wp_kses_post($image_attachment); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        endforeach; ?>
                                    </div>
                                </div>
                                <div class="swiper-button-wraper">
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>
                            <div class="main-gallery-wrapper product-detail__media">
                                <div class="main-gallery">
                                    <div class="swiper-wrapper">
                                        <?php foreach ($attachment_ids as $index => $attachment_id) :
                                            $class_attachment = $attachment_id ? 'has-image' : 'no-image';
                                            $image_attachment = $attachment_id ? wp_get_attachment_image($attachment_id, 'product-detail-main') : '<img src="' . esc_url($main_item_default) . '" alt="' . esc_attr(get_the_title($product->get_id())) . '" class="wp-post-image" />';
                                            $image_link = $attachment_id ? wp_get_attachment_url($attachment_id) : $main_item_default;
                                        ?>
                                            <div class="main-image swiper-slide">
                                                <div class="img-wrap <?php echo esc_attr($class_attachment); ?>">
                                                    <div class="img-inner">
                                                        <a data-fancybox="gallery" href="<?php echo esc_url($image_link); ?>">
                                                            <?php echo wp_kses_post($image_attachment); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="img-wrap-default">
                        <img src="<?php echo esc_url($default_image); ?>" alt="Default image" class="wp-post-image" />
                    </div>
                <?php endif; ?>
            </div>
        <?php endif;
        $sticky_class = ($detail_style === 'sticky') ? 'sticky-layout' : '';
        $sticky_id = ($detail_style === 'sticky') ? 'id="sticky-content"' : '';
        ?>
        <div class="col-6 info-content product-detail__content <?php echo esc_attr($sticky_class); ?>" <?php echo esc_attr($sticky_id); ?>>

            <div class="summary entry-summary detail-info product-detail__info">
                <?php
                /**
                 * Hook: woocommerce_single_product_summary.
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked WC_Structured_Data::generate_product_data() - 60
                 */

                do_action('woocommerce_single_product_summary');
                ?>
            </div>
        </div>
    </div>
    <?php
    $sticky_meta = get_post_meta($product->get_id(), 'sticky_add_to_cart', true);
    $sticky_enabled = ($sticky_meta !== '' && $sticky_meta !== null) ? $sticky_meta : get_theme_mod('show_sticky_add_to_cart', 'off');
    if ($sticky_enabled === 'on' && $product && $product->is_type('simple')) :
        global $product;

        if ($product && $product->is_type('simple')) :
    ?>
            <div class="sticky-add-to-cart" style="display: none;">
                <div class="container">
                    <div class="sticky-inner">

                        <div class="product-thumbnail">
                            <?php echo get_the_post_thumbnail($product->get_id(), 'shop_thumbnail'); ?>
                        </div>

                        <div class="product-info">
                            <h3 class="product-title mt-0"><?php echo esc_html($product->get_name()); ?></h3>
                            <div class="product-price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                        </div>

                        <div class="product-action">
                            <form action="<?php echo esc_url(get_permalink()); ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />

                                <?php
                                if ($product->is_sold_individually()) {
                                    echo '<input type="hidden" name="quantity" value="1" />';
                                } else {
                                    do_action('woocommerce_before_add_to_cart_quantity');
                                    woocommerce_quantity_input(array(
                                        'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                                        'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                                        'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                                    ), $product);
                                    do_action('woocommerce_after_add_to_cart_quantity');
                                }
                                ?>

                                <button type="submit" class="button alt">
                                    <?php echo esc_html($product->single_add_to_cart_text()); ?>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
    <?php
        endif;
    endif;
    ?>



</div>
