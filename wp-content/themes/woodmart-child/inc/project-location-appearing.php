<?php

/**
 * Shortcode to display Project Location
 * Usage: [project_location]
 * Class: my-location-container
 */
add_shortcode('project_location', function () {
    if (is_singular('portfolio')) {
        $location = get_post_meta(get_the_ID(), 'rs_project_location', true);
        if (! empty($location)) {
            return '<span class="rs-location-text">' . esc_html($location) . '</span>';
        }
    }
    return '';
});
