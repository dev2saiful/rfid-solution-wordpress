<?php

/**
 * 1. Enqueue Parent Styles and Custom Assets
 */
add_action('wp_enqueue_scripts', 'woodmart_child_enqueue_assets', 20);
function woodmart_child_enqueue_assets()
{
    // Parent style
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Custom CSS
    wp_enqueue_style(
        'woodmart-child-custom-css',
        get_stylesheet_directory_uri() . '/assets/css/custom.css',
        [],
        '1.0'
    );

    // Custom JS
    wp_enqueue_script(
        'woodmart-child-custom-js',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        ['jquery'],
        '1.0',
        true // load in footer
    );
}

/**
 * 2. Automatically include all PHP files in the /inc/ directory
 */
foreach (glob(get_stylesheet_directory() . '/inc/*.php') as $file) {
    require_once $file;
}
