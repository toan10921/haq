<?php

/**
 * Default template for search page.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package tech888-core
 */
namespace T888Core;

class ArchivePage
{
    private static $instance = null;

    private $sidebar_pos;
    private $sidebar;
    private $style;
    private $blog_list_item_style;
    private $blog_list_item_size;
    private $blog_grid_item_style;
    private $blog_grid_display_style;
    private $blog_grid_columns;
    private $blog_grid_item_size;
    private $blog_grid_excerpt_length;
    private $posts_per_page;
    private $blog_show_number_filter;
    private $blog_show_type_filter;
    // slug of the current style
    private $slug;
    // args for the current style
    private $args;

    private function __construct()
    {
        $this->sidebar_pos = get_theme_mod('sidebar_blog_position', 'left');
        $this->sidebar = get_theme_mod('sidebar_blog', 'no_sidebar');
        $this->style = get_theme_mod('blog_default_style', 'list');
        $this->blog_list_item_style = get_theme_mod('blog_list_item_style', 'default');
        $this->blog_list_item_size = get_theme_mod('blog_list_item_size', '');
        $this->blog_grid_item_style = get_theme_mod('blog_grid_item_style', 'default');
        $this->blog_grid_display_style = get_theme_mod('blog_grid_display_style', 'default');
        $this->blog_grid_columns = get_theme_mod('blog_grid_columns', '2');
        $this->blog_grid_item_size = get_theme_mod('blog_grid_item_size', '');
        $this->blog_grid_excerpt_length = get_theme_mod('blog_grid_excerpt_length', 28);
        $this->posts_per_page = get_option('posts_per_page', 10);
        $this->blog_show_number_filter = get_theme_mod('blog_show_number_filter', 'off');
        $this->blog_show_type_filter = get_theme_mod('blog_show_type_filter', 'off');
        // get the current style and its args
        $this->get_curent_data_style();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ArchivePage();
        }
        return self::$instance;
    }

    public function get_curent_data_style()
    {
        
        switch ($this->style) {
            case 'list':
            default:
                $this->slug = $this->blog_list_item_style;
                $this->args = array(
                    'size' => $this->blog_list_item_size
                );
                break;
            case 'grid':
                $this->slug = $this->blog_grid_item_style;
                $this->args = array(
                    'display_style' => $this->blog_grid_display_style,
                    'columns' => $this->blog_grid_columns,
                    'size' => $this->blog_grid_item_size,
                    'excerpt_length' => $this->blog_grid_excerpt_length
                );
                break;
        }
    }

    public function render()
    {
        get_header();
?>
        <?php do_action('t888f_before_main_content'); ?>
        <section id="main-content" class="main-page-default blog-page <?php echo t888f_get_main_class_sidebar($this->sidebar_pos); ?>">
            <div class="container">
                <div class="row">
                    <?php
                    t888f_get_side_bar($this->sidebar_pos, 'blog-sidebar', 'left');
                    ?>
                    <div class="<?php echo t888f_get_sibling_class_sidebar($this->sidebar_pos); ?>">
                    <div class="blog-wrap blog-<?php echo esc_attr($this->style); ?>">
                            <?php if (have_posts()) : ?>
                                <?php 
                                $columns = ($this->style === 'grid') ? 'grid-columns-' . esc_attr($this->blog_grid_columns) : '';
                            ?>
                            <div class="posts-wrap <?php echo esc_attr($columns); ?>">
                                    <?php
                                    while (have_posts()) : the_post(); ?>
                                        <?php t888f_get_template("posts/loop/{$this->style}/{$this->style}", $this->slug , $this->args, true); ?>
                                    <?php
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                </div>
                                <?php
                                tech888f_paging_nav(false, 'style2', true);
                                ?>
                            <?php else : ?>
                                <?php echo t888f_get_template('posts/content', 'none'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                    t888f_get_side_bar($this->sidebar_pos, 'blog-sidebar', 'right');
                    ?>
                </div>
            </div>
        </section>
        <?php do_action('t888f_after_main_content'); ?>
<?php
        get_footer();
    }
}

// Instantiate and render the archive page
ArchivePage::getInstance()->render();
