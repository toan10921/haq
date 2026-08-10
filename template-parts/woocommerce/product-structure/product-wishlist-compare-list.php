  <div class="custom-extra-buttons">

      <?php
        do_action('t888f_yith_wishlist_button', array(
            'class' => 'yith-wcwl-add-to-wishlist-button',
            'title' => esc_html__('Add to Wishlist', 'nebon'),
            'product_id' => get_the_ID(),
            'button_text' => esc_html__('Add to Wishlist', 'nebon')
        ));
        ?>

      <?php
        do_action('t888f_yith_compare_button', array(
            'class' => 'yith-compare-button',
            'title' => esc_html__('Compare', 'nebon'),
            'product_id' => get_the_ID(),
            'button_text' => esc_html__('Compare', 'nebon')
        ));
        ?>
  </div>