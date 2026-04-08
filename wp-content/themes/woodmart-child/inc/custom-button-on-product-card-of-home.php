<?php
add_action('woocommerce_after_shop_loop_item', 'rs_add_custom_view_details_button', 20);
function rs_add_custom_view_details_button()
{
    global $product;

    echo '<div class="my-button-wrapper">
            <a href="' . esc_url(get_permalink($product->get_id())) . '" class="my-button">
                View Details
            </a>
          </div>';
}
