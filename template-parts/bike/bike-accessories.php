<div class="w-100 py-3">
    <div class="wow fadeInUp" data-wow-delay="0.1s">
        <h3 id="accessories" class="border-bottom text-size-medium mb-0 text-primary text-uppercase"><?php esc_html_e('Accessories', 'bike-theme'); ?></h3>
    </div>
    <div class="pb-3">
        <div class="tour-contact wp-editor-content mt-4">
            <?php if (!empty($bike_accessories)) : ?>
                <?php echo wp_kses_post($bike_accessories); ?>
            <?php endif; ?>
        </div>
    </div>
</div>