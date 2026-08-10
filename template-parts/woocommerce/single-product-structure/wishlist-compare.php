<?php
$pid = isset($product_id) && $product_id ? (int) $product_id
      : ( isset($product) && $product ? (int) $product->get_id()
      : ( function(){ global $product; return $product ? (int) $product->get_id() : (int) get_the_ID(); } )() );
?>

<div class="custom-extra-buttons">
  <?php
  do_action('t888f_yith_wishlist_button', [
    'class'       => 'yith-wcwl-add-to-wishlist-button',
    'title'       => esc_html__('Add to Wishlist', 'nebon'),
    'product_id'  => $pid,
    'button_text' => esc_html__('Add to Wishlist', 'nebon'),
  ]);

  do_action('t888f_yith_compare_button', [
    'class'       => 'yith-compare-button',
    'title'       => esc_html__('Compare', 'nebon'),
    'product_id'  => $pid,
    'button_text' => esc_html__('Compare', 'nebon'),
  ]);
  ?>
</div>
