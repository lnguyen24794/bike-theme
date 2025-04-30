<div class="tour-contact">
    <?php if (!empty($contact_info)) : ?>
        <?php echo wp_kses_post($contact_info); ?>
    <?php else : ?>
        <div class="contact-details">
            <h4><?php esc_html_e('Contact Information', 'bike-theme'); ?></h4>
            <p><?php esc_html_e('For questions about this tour or to make a reservation, please contact us:', 'bike-theme'); ?></p>
            
            <div class="mt-4 row">
                <div class="col-md-4">
                    <h4 class=" mb-4"><?php esc_html_e('Our Shop', 'bike-theme'); ?></h4>
                    <?php foreach (bike_theme_get_option('contact_address', array()) as $branch) : ?>
                        <p class="mb-2">
                            <p ><a href="<?php echo esc_url($branch['link']); ?>" target="_blank">
                                <h5 class="mb-0"><?php echo esc_html($branch['name']); ?></h5>
                            </a></p>
                            <p><i class="fa fa-map-marker-alt me-3"></i><?php echo esc_html($branch['address']); ?></p>
                            <p><i class="fa fa-clock me-3"></i><?php echo esc_html($branch['opening_closed']); ?></p>
                        </p>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-4">
                    <h4 class=" mb-4"><?php esc_html_e('Contact Information', 'bike-theme'); ?></h4>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i><a  href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><a  href="tel:<?php echo esc_attr(bike_theme_get_option('contact_phone', '+849854557270')); ?>"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fab fa-whatsapp me-3"></i><a  href="https://api.whatsapp.com/send/?phone=<?php echo esc_attr(bike_theme_get_option('contact_phone', '84985455727')); ?>&text&type=phone_number&app_absent=0"><?php echo esc_html(bike_theme_get_option('whatsapp_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fab fa-telegram me-3"></i><a  href="https://t.me/beebikehub"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fa fab-zalo" style="margin-right: 6px;">Zalo</i><a  href="https://zalo.me/0985455727"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                </div>
                <div class="col-md-4">
                    <h4 class=" mb-4"><?php esc_html_e('Follow Us', 'bike-theme'); ?></h4>
                    <div class="d-inline-flex align-items-center">
                        <?php if (bike_theme_get_option('facebook')) : ?>
                        <a class="me-3 " href="<?php echo esc_url(bike_theme_get_option('facebook')); ?>"><i class="fab fa-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (bike_theme_get_option('address_link')) : ?>
                        <a class="me-3 " href="<?php echo esc_url(bike_theme_get_option('address_link')); ?>"><i class="fab fa-google"></i></a>
                        <?php endif; ?>
                        <?php if (bike_theme_get_option('youtube')) : ?>
                        <a class="me-3 " href="<?php echo esc_url(bike_theme_get_option('youtube')); ?>"><i class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                        <?php if (bike_theme_get_option('instagram')) : ?>
                        <a class="me-3 " href="<?php echo esc_url(bike_theme_get_option('instagram')); ?>"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="mt-4">
        <a href="#tour-booking-form" class="btn btn-primary py-3 px-5"><?php esc_html_e('Book Now', 'bike-theme'); ?></a>
    </div>
</div>