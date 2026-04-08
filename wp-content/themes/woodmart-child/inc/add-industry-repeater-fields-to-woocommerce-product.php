<?php
/*------------------------------------
  1. Register Meta Box
------------------------------------*/
add_action('add_meta_boxes', 'rs_register_industry_metabox');
function rs_register_industry_metabox()
{
    add_meta_box(
        'rs_product_industries',
        'Industries',
        'rs_render_industry_metabox',
        'product',
        'normal',
        'high'
    );
}

/*------------------------------------
  2. Render Meta Box UI
------------------------------------*/
function rs_render_industry_metabox($post)
{

    wp_nonce_field('rs_industry_nonce', 'rs_industry_nonce_field');

    $industries = get_post_meta($post->ID, '_rs_industries', true);
    if (! is_array($industries)) {
        $industries = [];
    }
?>

    <style>
        .rs-industry-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .rs-industry-item {
            border: 1px solid #ddd;
            padding: 12px;
            background: #fafafa;
        }

        .rs-industry-item img {
            max-width: 100%;
            display: block;
            margin-bottom: 8px;
        }

        .rs-upload-btn {
            margin-bottom: 10px;
        }
    </style>

    <div class="rs-industry-grid">
        <?php for ($i = 0; $i < 6; $i++) :

            $image = $industries[$i]['image'] ?? '';
            $name  = $industries[$i]['name'] ?? '';
            $desc  = $industries[$i]['desc'] ?? '';
        ?>
            <div class="rs-industry-item">

                <?php if ($image) : ?>
                    <img src="<?php echo esc_url(wp_get_attachment_url($image)); ?>">
                <?php endif; ?>

                <input type="hidden" name="rs_industries[<?php echo $i; ?>][image]" value="<?php echo esc_attr($image); ?>"
                    class="rs-image-id">

                <button type="button" class="button rs-upload-btn">
                    Add Image
                </button>

                <p><strong>Name</strong></p>
                <input type="text" name="rs_industries[<?php echo $i; ?>][name]" value="<?php echo esc_attr($name); ?>"
                    style="width:100%;">

                <p><strong>Description</strong></p>
                <textarea rows="3" name="rs_industries[<?php echo $i; ?>][desc]"
                    style="width:100%;"><?php echo esc_textarea($desc); ?></textarea>

            </div>
        <?php endfor; ?>
    </div>
<?php
}

/*------------------------------------
  3. Save Meta Box Data
------------------------------------*/
add_action('save_post_product', 'rs_save_industry_metabox_data');
function rs_save_industry_metabox_data($post_id)
{

    if (
        ! isset($_POST['rs_industry_nonce_field']) ||
        ! wp_verify_nonce($_POST['rs_industry_nonce_field'], 'rs_industry_nonce')
    ) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_product', $post_id)) {
        return;
    }

    if (isset($_POST['rs_industries']) && is_array($_POST['rs_industries'])) {

        $clean = [];

        foreach ($_POST['rs_industries'] as $industry) {
            $clean[] = [
                'image' => absint($industry['image'] ?? ''),
                'name'  => sanitize_text_field($industry['name'] ?? ''),
                'desc'  => sanitize_textarea_field($industry['desc'] ?? ''),
            ];
        }

        update_post_meta($post_id, '_rs_industries', $clean);
    }
}

/*------------------------------------
  4. Media Uploader
------------------------------------*/
add_action('admin_footer', 'rs_industry_media_script');
function rs_industry_media_script()
{
?>
    <script>
        jQuery(function($) {
            let frame;

            $('.rs-upload-btn').on('click', function(e) {
                e.preventDefault();

                let button = $(this);
                let input = button.prev('.rs-image-id');

                if (frame) frame.open();

                frame = wp.media({
                    title: 'Select Industry Image',
                    button: {
                        text: 'Use this image'
                    },
                    multiple: false
                });

                frame.on('select', function() {
                    let attachment = frame.state().get('selection').first().toJSON();
                    input.val(attachment.id);

                    button.siblings('img').remove();
                    button.before('<img src="' + attachment.url + '">');
                });

                frame.open();
            });
        });
    </script>
<?php
}
