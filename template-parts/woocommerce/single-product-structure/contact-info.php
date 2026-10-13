<?php
defined('ABSPATH') || exit;

if (!is_product()) {
    return;
}

$content = get_theme_mod('product_contact_info', t888f_get_product_contact_info_default());
$content = trim((string) $content);
if ($content === '') {
    return;
}
?>
<div class="t888-product-contact-info">
    <?php echo wp_kses_post(do_shortcode(wpautop($content))); ?>
</div>
