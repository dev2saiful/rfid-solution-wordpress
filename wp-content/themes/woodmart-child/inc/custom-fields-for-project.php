<?php

/**
 * Add Custom Fields to Woodmart Projects
 */
add_action('add_meta_boxes', 'rs_project_custom_fields');
function rs_project_custom_fields()
{
    add_meta_box(
        'rs_project_metabox',
        __('Project Extra Details', 'woodmart'),
        'rs_project_metabox_callback',
        'portfolio', // Woodmart project post type
        'side', // Position: Right column
        'high' // Priority
    );
}

function rs_project_metabox_callback($post)
{
    // Add nonce for security
    wp_nonce_field('rs_project_save_meta', 'rs_project_meta_nonce');

    // Define fields here to make it future-proof
    $fields = [
        'rs_project_location' => 'Location',
        // 'rs_project_client' => 'Client Name', // Future fields example
    ];

    foreach ($fields as $id => $label) {
        $value = get_post_meta($post->ID, $id, true);
        echo '<p><strong>' . esc_html($label) . '</strong></p>';
        echo '<input type="text" id="' . esc_attr($id) . '" name="' . esc_attr($id) . '" value="' . esc_attr($value) . '"
    style="width:100%;" />';
    }
}

add_action('save_post', 'rs_project_save_meta');
function rs_project_save_meta($post_id)
{
    if (! isset($_POST['rs_project_meta_nonce']) || ! wp_verify_nonce(
        $_POST['rs_project_meta_nonce'],
        'rs_project_save_meta'
    )) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (! current_user_can('edit_post', $post_id)) return;

    $fields = ['rs_project_location']; // Add future field IDs to this array

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
