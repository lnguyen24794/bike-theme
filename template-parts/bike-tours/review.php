<div class="w-100 py-3">
    <div class="wow fadeInUp" data-wow-delay="0.1s">
        <h3 id="reviews" class="border-bottom text-size-medium mb-0 text-primary text-uppercase"><?php esc_html_e('Reviews', 'bike-theme'); ?></h3>
    </div>
    <div class="pb-3">
        <div class="tour-media mt-4 wp-editor-content">
            <?php if (!empty($bike_reviews)) :
                $review_ids_array = is_array($bike_reviews) ? $bike_reviews : explode(',', $bike_reviews);
                ?>
                <div class="row gallery-container">
                    <?php foreach ($review_ids_array as $image_id) :
                        if (!empty($image_id)) :
                            $full_image_url = wp_get_attachment_image_url($image_id, 'full');
                            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                            if ($full_image_url) :
                                ?>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="gallery-item" style="aspect-ratio: 1/1; overflow: hidden;">
                                <a href="<?php echo esc_url($full_image_url); ?>" class="gallery-lightbox">
                                    <?php echo wp_get_attachment_image($image_id, 'large', false, array(
                                        'class' => 'img-fluid rounded',
                                        'style' => 'width: 100%; height: 100%; object-fit: fill;'
                                    )); ?>
                                </a>
                            </div>
                        </div>
                    <?php
                            endif;
                        endif;
                    endforeach;
                ?>
                </div>
            <?php endif; ?>
            <?php if (empty($bike_reviews)) : ?>
                <div class="alert alert-info">
                    <?php esc_html_e('No gallery images or videos are available for this tour.', 'bike-theme'); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="tour-review-info wp-editor-content">
            <?php echo wp_kses_post($tour_review_info); ?>
        </div>
    </div>
</div>