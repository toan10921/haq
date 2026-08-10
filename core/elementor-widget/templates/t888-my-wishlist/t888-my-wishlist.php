<?php
$count = function_exists('yith_wcwl_count_products') ? yith_wcwl_count_products() : 0;
?>

<div class="t888-my-wishlist <?php echo esc_attr($style); ?>">
  <a href="<?php echo esc_url(home_url('/my-wishlist')); ?>" class="heart position-relative">
    <i class="lar la-heart title24"></i>
    <span class="wishlist-count"><?php echo esc_html($count); ?></span>
  </a>
</div>