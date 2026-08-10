<?php
namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class T888_Short_Post_Info extends T888_Widget_Base {

    public function get_name() {
        return 'short-post-info';
    }

    public function get_title() {
        return __('Short Post Info', 'nebon');
    }

    public function get_icon() {
        return 'eicon-post-info';
    }

    public function get_categories() {
        return ['t888-elements']; 
    }

    protected function render() {
        $short_description = get_post_meta(get_the_ID(), 'short_description', true);
        ?>
        <div class="short-post-info-widget">
            <?php if (!empty($short_description)) : ?>
                <div class="short-description-post">
                    <?php echo wp_kses_post($short_description); ?>
                </div>
            <?php endif; ?>

            <div class="post-meta">
                <span class="date"><?php echo get_the_date('M .j .Y'); ?></span>
                <span class="category"><?php echo get_the_category_list(', '); ?></span>
            </div>
        </div>
        <?php
    }
}
