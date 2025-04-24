<?php
/**
 * The template for displaying the footer
 *
 * @package Bike_Theme
 */
?>

    </div><!-- #page -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4"><?php esc_html_e('About Us', 'bike-theme'); ?></h4>
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php else : ?>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><a href="<?php echo esc_url(bike_theme_get_option('address_link', '#')); ?>" target="_blank"><?php echo esc_html(bike_theme_get_option('contact_address', '123 Street, New York, USA')); ?></a></p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><a href="tel:<?php echo esc_attr(bike_theme_get_option('contact_phone', '+849854557270')); ?>"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                        <p class="mb-2"><i class="fab fa-whatsapp me-3"></i><a href="https://api.whatsapp.com/send/?phone=<?php echo esc_attr(bike_theme_get_option('contact_phone', '84985455727')); ?>&text&type=phone_number&app_absent=0"><?php echo esc_html(bike_theme_get_option('whatsapp_phone', '+849854557270')); ?></a></p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i><a href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
                        <div class="d-flex pt-2">
                            <?php if ($twitter = bike_theme_get_option('twitter')) : ?>
                                <a class="btn btn-outline-light btn-social" href="<?php echo esc_url($twitter); ?>"><i class="fab fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if ($facebook = bike_theme_get_option('facebook')) : ?>
                                <a class="btn btn-outline-light btn-social" href="<?php echo esc_url($facebook); ?>"><i class="fab fa-facebook-f"></i></a>
                            <?php endif; ?>
                            <?php if ($youtube = bike_theme_get_option('youtube')) : ?>
                                <a class="btn btn-outline-light btn-social" href="<?php echo esc_url($youtube); ?>"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                            <?php if ($linkedin = bike_theme_get_option('linkedin')) : ?>
                                <a class="btn btn-outline-light btn-social" href="<?php echo esc_url($linkedin); ?>"><i class="fab fa-linkedin-in"></i></a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4"><?php esc_html_e('Company', 'bike-theme'); ?></h4>
                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <?php dynamic_sidebar('footer-2'); ?>
                    <?php else : ?>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/about-us')); ?>"><?php esc_html_e('About Us', 'bike-theme'); ?></a>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact Us', 'bike-theme'); ?></a>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php esc_html_e('Privacy Policy', 'bike-theme'); ?></a>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>"><?php esc_html_e('Terms & Condition', 'bike-theme'); ?></a>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/support')); ?>"><?php esc_html_e('Support', 'bike-theme'); ?></a>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4"><?php esc_html_e('Services', 'bike-theme'); ?></h4>
                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <?php dynamic_sidebar('footer-3'); ?>
                    <?php else : ?>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/bike-repair')); ?>"><?php esc_html_e('Bike Repair', 'bike-theme'); ?></a>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/bike-rental')); ?>"><?php esc_html_e('Bike Rental', 'bike-theme'); ?></a>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/custom-builds')); ?>"><?php esc_html_e('Custom Builds', 'bike-theme'); ?></a>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/bike-accessories')); ?>"><?php esc_html_e('Bike Accessories', 'bike-theme'); ?></a>
                        <a class="btn btn-link" href="<?php echo esc_url(home_url('/guided-tours')); ?>"><?php esc_html_e('Guided Tours', 'bike-theme'); ?></a>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4"><?php esc_html_e('Fanpage', 'bike-theme'); ?></h4>
                    <div>
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FBeeBike.BikeTours.and.BikeRentals%2F&tabs&width=340&height=70&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=2174410252844536" width="340" height="70" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <?php echo wp_kses_post(bike_theme_get_option('copyright', '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All Rights Reserved.')); ?>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a>
                            <a href="#"><?php esc_html_e('Cookies', 'bike-theme'); ?></a>
                            <a href="#"><?php esc_html_e('Help', 'bike-theme'); ?></a>
                            <a href="#"><?php esc_html_e('FAQs', 'bike-theme'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

</div><!-- /.container-xxl -->
<script>
    let tourTab = document.getElementById('tourTab');
    if(tourTab){
        const top = $('#tourTab').offset().top - 100;
        window.addEventListener('scroll', function() {
            console.log(top);
            if(window.scrollY > top){
                document.getElementById('scrollHeader').classList.add('d-none');
            }
           
            if(window.scrollY > top){
                document.getElementById('tourTabWrapper').classList.add('tab-fixed', 'fadeInDown');
            }else{
                document.getElementById('tourTabWrapper').classList.remove('tab-fixed', 'fadeInDown');
            }
        });
    }
jQuery(document).ready(function($) {
    // Initialize lightbox for gallery images
    $('.gallery-lightbox').on('click', function(e) {
        e.preventDefault();
        
        var imageUrl = $(this).attr('href');
        var imageTitle = $(this).find('img').attr('alt') || '';
        
        // Create lightbox elements
        var lightbox = $('<div class="lightbox-overlay"></div>');
        var lightboxContent = $('<div class="lightbox-content"></div>');
        var lightboxClose = $('<button class="lightbox-close">&times;</button>');
        var lightboxImage = $('<img src="' + imageUrl + '" alt="' + imageTitle + '">');
        var lightboxCaption = '';
        
        if (imageTitle) {
            lightboxCaption = $('<div class="lightbox-caption">' + imageTitle + '</div>');
        }
        
        // Append elements
        lightboxContent.append(lightboxClose, lightboxImage, lightboxCaption);
        lightbox.append(lightboxContent);
        $('body').append(lightbox);
        
        // Add styles
        $('<style>')
            .prop('type', 'text/css')
            .html('\
                .lightbox-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; display: flex; align-items: center; justify-content: center; }\
                .lightbox-content { position: relative; max-width: 90%; max-height: 90%; }\
                .lightbox-content img { max-width: 100%; max-height: 90vh; display: block; }\
                .lightbox-close { position: absolute; top: -40px; right: 0; color: #fff; background: transparent; border: none; font-size: 1.4rem; cursor: pointer; }\
                .lightbox-caption { position: absolute; bottom: -30px; left: 0; color: #fff; padding: 5px; }\
            ')
            .appendTo('head');
        
        // Close on button click or overlay click
        lightboxClose.add(lightbox).on('click', function() {
            lightbox.remove();
        });
        
        // Prevent closing when clicking on the image
        lightboxContent.on('click', function(e) {
            e.stopPropagation();
        });
        
        // Close on ESC key
        $(document).on('keydown.lightbox', function(e) {
            if (e.keyCode === 27) { // ESC key
                lightbox.remove();
                $(document).off('keydown.lightbox');
            }
        });
    });
    
    // Handle tab navigation from URL
    var hash = window.location.hash;
    if (hash) {
        var tab = hash.replace('#', '');
        // Check if this is a valid tab
        var $tab = $('#' + tab + '-tab');
        if ($tab.length) {
            $tab.tab('show');
        }
    }
    
    // Update URL when tab changes
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        var id = $(e.target).attr('aria-controls');
        window.location.hash = id;
    });
});
</script>
<?php wp_footer(); ?>

</body>
</html> 