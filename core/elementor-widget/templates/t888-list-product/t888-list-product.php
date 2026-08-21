<?php
if ($query->have_posts()) :
    $backup = $GLOBALS['wp_query'];
    $GLOBALS['wp_query'] = $query;
?>
    <div class="products <?php echo esc_attr($view); ?> <?php echo esc_attr( $view === 'grid' ? 'shop-layout-' . $columns . '-cols' : '' ); ?> gap-<?php echo esc_attr($gap); ?>">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="product-item">
                <?php
                t888f_get_template(
                    $template_view,
                    $slug,
                    [
                        'animation_class' => $animation_class,
                        'compact_card' => !empty($use_shop_card),
                    ],
                    true
                );
                ?>
            </div>
        <?php endwhile; ?>
    </div>

<?php
    $GLOBALS['wp_query'] = $backup;
     wp_reset_postdata();
else :
    echo '<p>' . __('No product found.', 'nebon') . '</p>';
endif;
?>
<?php if (($pagination_type = $pagination_type ?? '') === 'pagination') : ?>
    <?php
    tech888f_paging_nav($query, 'style2', true);
    ?>
<?php elseif ( ($pagination_type ?? '') === 'loadmore' && (int) $query->max_num_pages > (int) $paged ) : ?>
  <div class="t888-list-loadmore-wrap"
       data-max-pages="<?php echo (int) $query->max_num_pages; ?>"
       data-current-page="<?php echo (int) $paged; ?>">
    <button class="t888-list-loadmore-btn button"
            data-ajax-url="<?php echo esc_url( admin_url('admin-ajax.php') ); ?>"
            data-query-vars='<?php echo wp_json_encode( $args, JSON_UNESCAPED_UNICODE ); ?>'
            data-template-view="<?php echo esc_attr( $template_view ); ?>"
            data-style="<?php echo esc_attr( $view ); ?>"
            data-slug="<?php echo esc_attr( $slug ); ?>">
      <?php esc_html_e( 'Load More', 'nebon' ); ?>
    </button>
  </div>
<?php endif; ?>
