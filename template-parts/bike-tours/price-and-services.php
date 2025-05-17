<div class="w-100 py-3">
    <div class="wow fadeInUp" data-wow-delay="0.1s">
        <h3 id="price-and-services" class="border-bottom text-size-medium mb-0 text-primary text-uppercase"><?php esc_html_e('Price & Services', 'bike-theme'); ?></h3>
    </div>
    <div class="pb-3">
        <div class="price-details mt-4 wp-editor-content">
            <h4><?php esc_html_e('Price Details', 'bike-theme'); ?></h4>
            <div class="price-info wp-editor-content mb-2">
                <?php echo wp_kses_post(get_post_meta(get_the_ID(), '_tour_price_info', true)); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <h4><?php esc_html_e('What\'s Included', 'bike-theme'); ?></h4>
                <?php if (!empty($tour_included)) : ?>
                    <div class="included-services wp-editor-content">
                        <?php echo wp_kses_post($tour_included); ?>
                    </div>
                
                <?php endif; ?>
            </div>
            <div class="col-md-6 mb-4">
                <h4><?php esc_html_e('What\'s Not Included', 'bike-theme'); ?></h4>
                <?php if (!empty($not_included)) : ?>
                    <div class="not-included-services wp-editor-content">
                        <?php echo wp_kses_post($not_included); ?>
                    </div>
                
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>