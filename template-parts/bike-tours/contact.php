<div class="tour-contact">
    <?php if (!empty($contact_info)) : ?>
        <?php echo wp_kses_post($contact_info); ?>
    <?php else : ?>
        <div class="contact-details">
            <h4><?php esc_html_e('Contact Information', 'bike-theme'); ?></h4>
            <p><?php esc_html_e('For questions about this tour or to make a reservation, please contact us:', 'bike-theme'); ?></p>
            
            <div class="mt-4">
                <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><a class="text-light" href="<?php echo esc_url(bike_theme_get_option('address_link', '#')); ?>" target="_blank"><?php echo esc_html(bike_theme_get_option('contact_address', '123 Street, New York, USA')); ?></a></p>
                <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><a class="text-light" href="tel:<?php echo esc_attr(bike_theme_get_option('contact_phone', '+849854557270')); ?>"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                <p class="mb-2"><i class="fab fa-whatsapp me-3"></i><a class="text-light" href="https://api.whatsapp.com/send/?phone=<?php echo esc_attr(bike_theme_get_option('contact_phone', '84985455727')); ?>&text&type=phone_number&app_absent=0"><?php echo esc_html(bike_theme_get_option('whatsapp_phone', '+849854557270')); ?></a></p>
                <p class="mb-2"><i class="fa fa-envelope me-3"></i><a class="text-light" href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="mt-4">
        <a href="#tour-booking-form" class="btn btn-primary py-3 px-5"><?php esc_html_e('Book Now', 'bike-theme'); ?></a>
    </div>
</div>