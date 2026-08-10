<?php
if ( defined('THEME_SKIP_BLOCK_FEATURES') && THEME_SKIP_BLOCK_FEATURES ) return;

// example register block, use for future development
add_action('init', function () {
    if ( function_exists('register_block_style') ) {
        register_block_style('core/paragraph', [
            'name'         => 'theme-muted',
            'label'        => __('Muted text', 'nebon'),
            'inline_style' => '.is-style-theme-muted{opacity:.85;}',
        ]);
    }

    
    if ( function_exists('register_block_pattern_category') ) {
        register_block_pattern_category('theme', ['label' => __('Theme Patterns', 'nebon')]);
    }
    if ( function_exists('register_block_pattern') ) {
        register_block_pattern('theme/paragraph-muted', [
            'title'      => __('Paragraph (muted)', 'nebon'),
            'categories' => ['theme'],
            'content'    =>
                '<!-- wp:paragraph {"className":"is-style-theme-muted"} -->' .
                '<p>' . esc_html__('Your text here…', 'nebon') . '</p>' .
                '<!-- /wp:paragraph -->',
        ]);
    }
});