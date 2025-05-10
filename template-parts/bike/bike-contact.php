<div class="w-100 py-3">
    <div class="wow fadeInUp" data-wow-delay="0.1s">
        <h3 class="border-bottom text-size-medium mb-0 text-primary text-uppercase"><?php esc_html_e('Contact Information', 'bike-theme'); ?></h3>
    </div>
    <div class="pb-3">
            <div class="tour-contact mt-4">
            <?php if (!empty($bike_contact)) : ?>
                <?php echo wp_kses_post($bike_contact); ?>
            <?php endif; ?>
        </div>
    </div>
</div>