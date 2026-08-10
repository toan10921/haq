<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package tech888-core
 */
// if ( is_home() && !is_front_page() ) {
//     require get_template_directory() . '/archive.php';
//     return;
// }
get_header();
$sidebar_pos = get_theme_mod('sidebar_blog_position', 'left');
$sidebar = get_theme_mod('sidebar_blog' , 'no_sidebar');
?>
<?php do_action('t888f_before_main_content'); ?>
<section id="main-content" class="main-page-default blog-page  <?php echo t888f_get_main_class_sidebar($sidebar_pos); ?>">
    <div class="container">
        <div class="row">
            <?php
            if ($sidebar_pos == 'left'):
                if (is_active_sidebar('blog-sidebar')) : ?>
                    <div class="col-3 left-sidebar col-left">
                        <aside id="secondary" class="widget-area">
                            <?php dynamic_sidebar('blog-sidebar'); ?>
                        </aside>
                    </div>
            <?php endif;
            endif;
            ?>
            <div class="<?php echo t888f_get_sibling_class_sidebar($sidebar_pos); ?>">
                <?php
                ?>
                <div class="blog-wrap blog-list">
                    <?php if (have_posts()) : ?>
                        <div class="posts-wrap">
                            <?php
                            while (have_posts()) : the_post(); ?>

                                <?php t888f_get_template('posts/loop/list/list', 'default', array(), true); ?>

                            <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                        <?php
                                  tech888f_paging_nav(false,'style2',true);
                        ?>

                    <?php else : ?>

                        <?php echo t888f_get_template('posts/content', 'none'); ?>

                    <?php endif; ?>

                </div>
            </div>
            <?php
            if ($sidebar_pos == 'right'):
                if (is_active_sidebar('blog-sidebar')) : ?>
                    <div class="col-3 right-sidebar col-right">
                        <aside id="secondary" class="widget-area">
                            <?php dynamic_sidebar('blog-sidebar'); ?>
                        </aside>
                    </div>
            <?php endif;
            endif;
            ?>
        </div>
    </div>
</section>
<?php do_action('t888f_after_main_content'); ?>
<?php
get_footer();
