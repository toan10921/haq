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
?>

<?php do_action('t888f_before_main_content'); ?>

<section id="main" class="single-main">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="single-post-layout single-post-layout--<?php echo esc_attr($has_sidebar ? $sidebar_position : 'no-sidebar'); ?>">
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

      <?php if ($has_sidebar): ?>
        <aside id="secondary" class="single-post-sidebar widget-area" aria-label="<?php esc_attr_e('Blog sidebar', 'nebon'); ?>">
          <?php dynamic_sidebar($sidebar_item); ?>
        </aside>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php do_action('t888f_after_main_content'); ?>
<?php get_footer(); ?>
