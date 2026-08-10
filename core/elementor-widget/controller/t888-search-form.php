<?php

namespace Elementor;

class T888_Search_Form extends T888_Widget_Base
{

    public function __construct(array $data = [], array $args = null)
    {
        parent::__construct($data, $args);
    }


    public function get_name()
    {
        return 't888-search-form';
    }

    public function get_title()
    {
        return __('Search Form', 'nebon');
    }

    public function get_icon()
    {
        return 'eicon-search';
    }

    public function get_categories()
    {
        return ['t888-elements'];
    }

    public function get_script_depends()
    {
        return [];
    }

    public function get_style_depends()
    {
        return [];
    }

    protected function _register_controls()
    {
        $this->start_controls_section('section_content', [
            'label' => __('Search Form Content', 'nebon'),
        ]);

        $this->add_control('style', [
            'label' => __('Style', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'style1',
            'options' => [
                'style1' => __('Style 1 (Default) - Icon Header 1', 'nebon'),

                    'style2' => __('Style 2 - Inline Red Border (Like screenshot)', 'nebon'),

                'style3' => __('Style 3 (Home 2)', 'nebon')

            ],
        ]);

        $this->add_control('placeholder', [
            'label' => __('Placeholder Text', 'nebon'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => __('What are you searching for ?', 'nebon'),
        ]);

        $this->add_control('post_type', [
            'label' => __('Search Objects', 'nebon'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'product',
            'options' => [
                'post' => __('Posts', 'nebon'),
                'product' => __('Products', 'nebon'),
                // Add more options as needed
            ],
        ]);

        $this->add_control('show_categories', [
            'label' => __('Show Categories', 'nebon'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
        ]);

        $this->add_control('ajax_search', [
            'label' => __('Enable Ajax Search', 'nebon'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'default' => 'yes',
            'label_on' => __('Yes', 'nebon'),
            'label_off' => __('No', 'nebon'),
        ]);

        $this->end_controls_section();
    }

    public function getObjectCategories($post_type = 'post')
{
    $taxonomy = ($post_type === 'product') ? 'product_cat' : 'category';
    $terms = get_terms([
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'orderby'    => 'name',
        'order'      => 'ASC',
    ]);
    return (!is_wp_error($terms) && !empty($terms)) ? $terms : [];
}


protected function render()
{
    parent::render();

    $settings = $this->get_settings_for_display();

    $style           = $settings['style'] ?? 'style1';
    $show_categories = $settings['show_categories'] ?? 'yes';
    $ajax_search     = $settings['ajax_search'] ?? 'yes';

    $raw        = isset($settings['placeholder']) ? (string) $settings['placeholder'] : '';
    $placeholder= (trim($raw) !== '') ? $raw : __('What are you searching for?', 'nebon');

    $post_type  = $settings['post_type'] ?? 'post';

    $categories = ($show_categories === 'yes') ? $this->getObjectCategories($post_type) : [];


    if (!did_action('t888_search_panel_injected')) {
        add_action('wp_footer', function () use ($style, $placeholder, $post_type, $categories, $ajax_search, $show_categories) {            do_action('t888_search_panel_injected'); // đánh dấu đã in

            ?>
            <div id="t888-search-panel" class="t888-search-root <?php echo esc_attr($style); ?>" aria-hidden="true">
                <div class="t888-search-overlay"></div>

                <div class="t888-search-content overlay overlay-genie"
                     data-steps="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z;m 698.9986,728.03569 41.23353,0 -3.41953,77.8735 -34.98557,0 z;m 687.08153,513.78234 53.1506,0 C 738.0505,683.9161 737.86917,503.34193 737.27015,806 l -35.90067,0 c -7.82727,-276.34892 -2.06916,-72.79261 -14.28795,-292.21766 z;m 403.87105,257.94772 566.31246,2.93091 C 923.38284,513.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 455.17312,480.07689 403.87105,257.94772 z;M 51.871052,165.94772 1362.1835,168.87863 C 1171.3828,653.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 31.173122,513.78234 51.871052,165.94772 z;m 52,26 1364,4 c -12.8007,666.9037 -273.2644,483.78234 -322.7299,776 l -633.90062,0 C 359.32034,432.49318 -6.6979288,733.83462 52,26 z;m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z">

                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"
                         viewBox="0 0 1440 806" preserveAspectRatio="none">
                        <path class="overlay-path" d="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z" />
                    </svg>

                    <form class="search-form <?php echo esc_attr($ajax_search === 'yes' ? 'search-ajax' : ''); ?>"
                          action="<?php echo esc_url(home_url('/')); ?>">

                        <a href="javascript:void(0)" class="overlay-close js-overlay-close">
                            <i class="las la-times"></i>
                        </a>

                        <input name="s" type="text"
                               placeholder="<?php echo esc_attr($placeholder); ?>"
                               autocomplete="off"
                               class="input-search fw-normal title14" />

                        <?php if ($show_categories === 'yes' && !empty($categories)) : ?>
                            <div class="custom-dropdown custom-dropdown-categories">
                                <div class="custom-dropdown-toggle-search position-relative">
                                    <?php esc_html_e('All Categories', 'nebon'); ?>
                                </div>
                                <ul class="custom-dropdown-menu-categories">
                                    <?php foreach ($categories as $category): ?>
                                        <li>
                                            <a data-category="<?php echo esc_attr($category->slug); ?>" href="#" class="title13">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <select name="category" class="form-select d-none">
                                <option value=""><?php esc_html_e('All Categories', 'nebon'); ?></option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo esc_attr($category->slug); ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>

                        <input type="hidden" name="post_type" value="<?php echo esc_attr($post_type); ?>" />
                        <button type="submit" class="btn btn-primary btn-search title24 secondary d-flex align-items-center justify-content-end">
                            <i class="las la-search"></i>
                        </button>

                        <div class="list-search-results"
                             data-search_min_length="<?php echo esc_attr__('Please enter at least 3 characters.', 'nebon'); ?>">
                            <p class="text-center m-0">
                                <?php echo esc_html__('Please enter key search to display results.', 'nebon'); ?>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }, 99);
    }

    tech888f_get_template_elementor_widget('t888-search-form', $style, $settings, true);
}

}
