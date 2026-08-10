<?php
$guide_files = get_post_meta(get_the_ID(), 'product_guide', true);
$guide_url = '';

if (!empty($guide_files)) {
    if (is_array($guide_files)) {
        $guide_url = wp_get_attachment_url($guide_files[0]);
    } else {
        $guide_url = wp_get_attachment_url($guide_files);
    }
}
?>

<div class="product-guide">
    <?php if (get_theme_mod('show_user_guide', 'on') === 'on') :
        $guide_class = $guide_url ? '' : ' disabled';
        $guide_target = $guide_url ? '_blank' : '_self';
        $guide_rel = $guide_url ? 'rel="noopener"' : 'onclick="return false;"';
        ?>
        <div class="guide-wrapper">
            <a href="<?php echo esc_url($guide_url ? $guide_url : '#'); ?>"
                class="guide<?php echo esc_attr($guide_class); ?>"
                target="<?php echo esc_attr($guide_target); ?>"
                <?php echo esc_attr($guide_rel); ?>>
                <i class="las la-file-alt"></i>
                <span><?php echo esc_html( get_theme_mod('show_user_guide_label', __('User guide', 'nebon')) ); ?></span>
            </a>
        </div>
    <?php endif; ?>
    <?php if (get_theme_mod('show_shipping', 'on') === 'on') : ?>
        <div class="guide-wrapper">
            <a href="#" class="shipping">
                <i class="las la-shipping-fast"></i> <span><?php echo esc_html( get_theme_mod('show_shipping_label', __('Free Shipping', 'nebon')) ); ?></span>
            </a>
        </div>
    <?php endif; ?>
    <?php if (get_theme_mod('show_share', 'on') === 'on') : ?>
        <div class="guide-wrapper">
            <a href="#" class="share">
                <i class="las la-share-alt-square"></i> <span><?php echo esc_html( get_theme_mod('show_share_label', __('Share', 'nebon')) ); ?></span>
            </a>
            <div class="share-popup" id="sharePopup">
                <div class="share-title">Share on:</div>
                <a href="https://wa.me/?text=Check%20this%20out%20<?php echo urlencode(get_permalink()); ?>" target="_blank">
                    <i class="lab la-whatsapp"></i> Whatsapp
                </a>
                <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank">
                    <i class="lab la-pinterest"></i> Pinterest
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank">
                    <i class="lab la-facebook-f"></i> Facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>" target="_blank">
                    <i class="lab la-twitter"></i> Twitter
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank">
                    <i class="lab la-linkedin-in"></i> Linkedin
                </a>
                <a href="mailto:?subject=Check this out&body=<?php echo urlencode(get_permalink()); ?>">
                    <i class="las la-envelope"></i> Email
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php
if (get_theme_mod('show_shipping', 'on') === 'on') {
    t888f_get_template('woocommerce/single-product-structure/popup-shipping', '', array(), true);

}
?>
