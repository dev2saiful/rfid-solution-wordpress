<?php
add_filter('the_title', function ($title, $post_id) {

    if (
        ! is_admin() &&
        get_post_type($post_id) === 'portfolio' &&
        has_excerpt($post_id)
    ) {
        $excerpt = wp_trim_words(get_the_excerpt($post_id), 18);
        $title .= '<span class="wd-portfolio-excerpt">' . esc_html($excerpt) . '</span>';
    }

    return $title;
}, 10, 2);
