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
$fullwidth_meta = get_post_meta($post_id, 'custom_post_fullwidth', true);
$is_fullwidth   = ($fullwidth_meta === '1');
$container_class = $is_fullwidth ? 'no-sidebar-fullwidth' : 'container';

$hide_thumbnail   = get_post_meta($post_id, 'custom_post_hide_thumbnail', true) == '1';
$show_share = is_singular('post') && (bool) get_theme_mod('show_share_box', false);
$current_post_type = get_post_type();

global $wp_registered_sidebars;
$has_sidebar = ($sidebar_position !== 'no_sidebar'
    && !empty($sidebar_item)
    && $sidebar_item !== 'choose_one'
    && isset($wp_registered_sidebars[$sidebar_item]));
?>

<?php do_action('t888f_before_main_content'); ?>

<section id="main" class="single-main">
  <div class="<?php echo esc_attr($container_class); ?>">
    <div class="row">

      <?php if ($sidebar_position === 'left' && $has_sidebar): ?>
        <div class="col-3 left-sidebar col-left">
          <aside id="secondary" class="widget-area">
            <?php dynamic_sidebar($sidebar_item); ?>
          </aside>
        </div>
        <div class="col-9">
      <?php elseif ($sidebar_position === 'no_sidebar'): ?>
        <div class="col-12">
      <?php elseif ($sidebar_position === 'right' && $has_sidebar): ?>
        <div class="col-9">
      <?php else:  ?>
        <div class="col-12">
      <?php endif; ?>

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
              'before'      => '<div class="page-links page-links flex-wrap flex-wrap-wrap align-items-center">' . esc_html__('Pages:', 'nebon'),
              'after'       => '</div>',
              'link_before' => '<span>',
              'link_after'  => '</span>',
            ]);
          endwhile;
          ?>

          <?php if ($sidebar_position !== 'no_sidebar' && $has_sidebar): ?>
            <?php if (has_tag() || $show_share): ?>
              <div class="tags-share-single d-flex flex-wrap justify-content-between align-items-center">
                <?php
                  if (has_tag())    t888f_get_template('posts/detail/post-tags', '', [], true);
                  if ($show_share)  t888f_get_template('common/post-share', '', [], true);
                ?>
              </div>
            <?php endif;
              t888f_get_template('posts/detail/post-navigation', '', [], true);
              t888f_get_template('posts/detail/related', '', [], true);

              if (comments_open() || get_comments_number()) comments_template();
            ?>
          <?php endif; ?>
        </div>

        <?php if ($sidebar_position === 'right' && $has_sidebar): ?>
          <div class="col-3 right-sidebar col-right">
            <aside id="secondary" class="widget-area">
              <?php dynamic_sidebar($sidebar_item); ?>
            </aside>
          </div>
        <?php endif; ?>

    </div>
  </div>

  <?php if ($sidebar_position === 'no_sidebar' || !$has_sidebar): ?>
    <div class="container">
      <?php if (has_tag() || $show_share): ?>
        <div class="tags-share-single d-flex flex-wrap justify-content-between align-items-center">
          <?php
            if (has_tag())    t888f_get_template('posts/detail/post-tags', '', [], true);
            if ($show_share)  t888f_get_template('common/post-share', '', [], true);
          ?>
        </div>
      <?php endif;
        t888f_get_template('posts/detail/post-navigation', '', [], true);
        t888f_get_template('posts/detail/related', '', [], true);

        if (comments_open() || get_comments_number()) comments_template();
      ?>
    </div>
  <?php endif; ?>
</section>

<?php do_action('t888f_after_main_content'); ?>
<?php get_footer(); ?>
