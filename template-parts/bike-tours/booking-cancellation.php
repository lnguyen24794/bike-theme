<div class="w-100 py-3">
    <div class="wow fadeInUp" data-wow-delay="0.1s">
        <h3 class="border-bottom text-size-medium mb-0 text-primary text-uppercase"><?php esc_html_e('Booking & Cancellation', 'bike-theme'); ?></h3>
    </div>
    <div class="pb-3">
        <div class="booking-cancellation mt-4">
            <div class="mb-4">
                <h4><?php esc_html_e('Booking Terms', 'bike-theme'); ?></h4>
                <?php if (!empty($booking_terms)) : ?>
                    <?php echo wp_kses_post($booking_terms); ?>
                <?php else : ?>
                    <p><?php esc_html_e('Please contact us for detailed information about booking terms and conditions.', 'bike-theme'); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="mt-4">
                <h4><?php esc_html_e('Cancellation Policy', 'bike-theme'); ?></h4>
                <?php if (!empty($cancellation_policy)) : ?>
                    <?php echo wp_kses_post($cancellation_policy); ?>
                <?php else : ?>
                    <p><?php esc_html_e('Please contact us for detailed information about our cancellation policy.', 'bike-theme'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>