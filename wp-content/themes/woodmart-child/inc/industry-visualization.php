<?php
add_shortcode('product_industries', 'rs_render_product_industries');
function rs_render_product_industries()
{

    if (! is_product()) return '';

    $industries = get_post_meta(get_the_ID(), '_rs_industries', true);
    if (empty($industries) || ! is_array($industries)) return '';

    ob_start();
?>
    <div class="rs-industries-grid">
        <?php foreach ($industries as $industry) :

            if (empty($industry['image']) || empty($industry['name'])) continue;

            $img = wp_get_attachment_image_url($industry['image'], 'large');
        ?>
            <div class="rs-industry-card">
                <div class="rs-industry-image">
                    <img src="<?php echo esc_url($img); ?>" alt="">
                </div>

                <div class="rs-industry-content">
                    <h4><?php echo esc_html($industry['name']); ?></h4>
                    <?php if (! empty($industry['desc'])) : ?>
                        <p><?php echo esc_html($industry['desc']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php
    return ob_get_clean();
}
