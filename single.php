<?php

/**
 * The template for displaying all single posts.
 *
 * @package tech888-core
 */


get_header();

$size         = [1200, 800];
$check_thumb  = true;
$check_meta   = true;
$post_id      = get_the_ID();

$global_pos   = get_theme_mod('sidebar_single_post', 'left');           
$global_item  = get_theme_mod('sidebar_select_display', 'blog-sidebar');    

$meta_pos  = get_post_meta($post_id, 'custom_post_sidebar_position', true); 
$meta_item = get_post_meta($post_id, 'custom_post_sidebar_item', true);    

$sidebar_position = ($meta_pos  !== '' ? $meta_pos  : $global_pos);
$sidebar_item     = ($meta_item !== '' ? $meta_item : $global_item);
$sidebar_position = in_array($sidebar_position, ['left', 'right'], true) ? $sidebar_position : 'no_sidebar';
$fullwidth_meta = get_post_meta($post_id, 'custom_post_fullwidth', true);
$is_fullwidth   = ($fullwidth_meta === '1');
$container_class = $is_fullwidth ? 'no-sidebar-fullwidth' : 'container';

$hide_thumbnail   = get_post_meta($post_id, 'custom_post_hide_thumbnail', true) == '1';
$show_share = is_singular('post') && (bool) get_theme_mod('show_share_box', false);
global $wp_registered_sidebars;
$has_sidebar = ($sidebar_position !== 'no_sidebar'
    && !empty($sidebar_item)
    && $sidebar_item !== 'choose_one'
    && isset($wp_registered_sidebars[$sidebar_item]));

$post_rail_html = '';
if (get_post_type($post_id) === 'post') {
    $post_rail_html = (string) t888f_get_template('posts/detail/side-rail', '', ['post_id' => $post_id], false);
}
$show_post_rail = trim($post_rail_html) !== '';

$sidebar_has_widgets = $has_sidebar && is_active_sidebar($sidebar_item);
$layout_classes = ['single-post-layout'];
if ($show_post_rail) {
    $layout_classes[] = 'single-post-layout--rail';
    if ($sidebar_has_widgets && $sidebar_position === 'left') {
        $layout_classes[] = 'single-post-layout--with-left';
    }
} else {
    $layout_classes[] = 'single-post-layout--' . ($has_sidebar ? $sidebar_position : 'no-sidebar');
}
?>

<?php do_action('t888f_before_main_content'); ?>

<section id="main" class="single-main">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="<?php echo esc_attr(implode(' ', $layout_classes)); ?>">
      <?php if ($show_post_rail && $sidebar_has_widgets && $sidebar_position === 'left') : ?>
        <aside id="secondary" class="single-post-sidebar widget-area" aria-label="<?php esc_attr_e('Blog sidebar', 'nebon'); ?>">
          <?php dynamic_sidebar($sidebar_item); ?>
        </aside>
      <?php endif; ?>
      <main class="single-post-content">
        <?php
        $data = [
          'size'           => $size,
          'check_thumb'    => $check_thumb,
          'check_meta'     => $check_meta,
          'hide_thumbnail' => $hide_thumbnail,
        ];

        while (have_posts()) : the_post();
          $post_style = get_post_meta(get_the_ID(), 'custom_post_display_style', true) ?: 'detail';
          t888f_get_template("posts/detail/{$post_style}", get_post_format(), $data, true);

          wp_link_pages([
            'before'      => '<div class="page-links flex-wrap align-items-center">' . esc_html__('Pages:', 'nebon'),
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
          ]);
        endwhile;

        if (has_tag() || $show_share): ?>
          <div class="tags-share-single d-flex flex-wrap justify-content-between align-items-center">
            <?php
            if (has_tag()) {
              t888f_get_template('posts/detail/post-tags', '', [], true);
            }
            if ($show_share) {
              t888f_get_template('common/post-share', '', [], true);
            }
            ?>
          </div>
        <?php endif;

        t888f_get_template('posts/detail/post-navigation', '', [], true);
        t888f_get_template('posts/detail/related', '', [], true);

        if (comments_open() || get_comments_number()) {
          comments_template();
        }
        ?>
      </main>

      <?php if ($show_post_rail) : ?>
        <aside class="single-post-rail" aria-label="<?php esc_attr_e('Sản phẩm nổi bật và bài viết cùng chuyên mục', 'nebon'); ?>">
          <?php echo $post_rail_html; ?>
          <?php if ($sidebar_has_widgets && $sidebar_position !== 'left') : ?>
            <div id="secondary" class="single-post-sidebar widget-area" aria-label="<?php esc_attr_e('Blog sidebar', 'nebon'); ?>">
              <?php dynamic_sidebar($sidebar_item); ?>
            </div>
          <?php endif; ?>
        </aside>
      <?php elseif ($has_sidebar) : ?>
        <aside id="secondary" class="single-post-sidebar widget-area" aria-label="<?php esc_attr_e('Blog sidebar', 'nebon'); ?>">
          <?php dynamic_sidebar($sidebar_item); ?>
        </aside>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php do_action('t888f_after_main_content'); ?>
<?php get_footer(); ?>
