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
        <div class="container py-3">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-light mb-4"><?php esc_html_e('Our Shops', 'bike-theme'); ?></h4>
                    <?php foreach (bike_theme_get_option('contact_address', array()) as $branch) : ?>
                        <p class="mb-2">
                            <p class="text-light" ><a href="<?php echo esc_url($branch['link']); ?>" target="_blank">
                                <h5 class="mb-0"><?php echo esc_html($branch['name']); ?></h5>
                            </a></p>
                            <p class="text-light"><i class="fa fa-map-marker-alt me-3"></i><?php echo esc_html($branch['address']); ?></p>
                            <p class="text-light"><i class="fa fa-clock me-3"></i><?php echo esc_html($branch['opening_closed']); ?></p>
                        </p>
                    <?php endforeach; ?>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-light mb-4"><?php esc_html_e('Contact Information', 'bike-theme'); ?></h4>
                    <p class="mb-2"><i class="fa fa-envelope me-4"></i><a class="text-light" href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-4"></i><a class="text-light" href="tel:<?php echo esc_attr(bike_theme_get_option('contact_phone', '+849854557270')); ?>"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fab fa-whatsapp me-4"></i><a class="text-light" href="https://api.whatsapp.com/send/?phone=84985455727&text&type=phone_number&app_absent=0"><?php echo esc_html(bike_theme_get_option('whatsapp_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fab fa-telegram me-4"></i><a class="text-light" href="https://t.me/beebikehub"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fa fab-zalo" style="margin-right: 6px;">Zalo</i><a class="text-light" href="https://zalo.me/0985455727"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                </div> 
               
             
                <div class="col-lg-4 col-md-6">
                    <h4 class="text-light mb-4"><?php esc_html_e('Follow Us', 'bike-theme'); ?></h4>
                    <div>
                        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FBeeBikeHub&tabs&width=340&height=130&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="100%" height="130" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </div>
                    <div class="d-inline-flex align-items-center">
                        <?php if (bike_theme_get_option('facebook')) : ?>
                        <a class="me-3 text-light" href="<?php echo esc_url(bike_theme_get_option('facebook')); ?>" target="_blank"><i class="fab fa-facebook"></i></a>
                        <?php endif; ?>
                        
                        <?php if (bike_theme_get_option('google_link')) : ?>
                        <a class="me-3 text-light" href="<?php echo esc_url(bike_theme_get_option('google_link')); ?>" target="_blank"><i class="fab fa-google"></i></a>
                        <?php endif; ?>

                        <?php if (bike_theme_get_option('tripadvisor')) : ?>
                        <a class="me-3 text-light" href="<?php echo esc_url(bike_theme_get_option('tripadvisor')); ?>" target="_blank"><i class="fab fa-tripadvisor"></i></a>
                        <?php endif; ?>
                        
                        <?php if (bike_theme_get_option('youtube')) : ?>
                        <a class="me-3 text-light" href="<?php echo esc_url(bike_theme_get_option('youtube')); ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                        
                        <?php if (bike_theme_get_option('instagram')) : ?>
                        <a class="me-3 text-light" href="<?php echo esc_url(bike_theme_get_option('instagram')); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
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
        const top = $('#tourTab').offset().top - 50;
        window.addEventListener('scroll', function() {
            if(window.scrollY > top){
                document.getElementById('scrollHeader').classList.add('d-none');
            }else{
                document.getElementById('scrollHeader').classList.remove('d-none');
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

    // Function to check if element or its parents have wp-editor-content class
    function isWpEditorContent(element) {
        while (element) {
            if (element.classList && element.classList.contains('wp-editor-content')) {
                return true;
            }
            element = element.parentElement;
        }
        return false;
    }

    // Add CSS to prevent text selection only for wp-editor-content
    document.head.insertAdjacentHTML('beforeend', `
        <style>
            .wp-editor-content {
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
        </style>
    `);

    // Disable right click on wp-editor-content
    document.addEventListener('contextmenu', function(e) {
        if (isWpEditorContent(e.target)) {
            e.preventDefault();
            return false;
        }
    });

    // Disable copy on wp-editor-content
    document.addEventListener('copy', function(e) {
        if (isWpEditorContent(e.target)) {
            e.preventDefault();
            return false;
        }
    });

    // Disable cut on wp-editor-content
    document.addEventListener('cut', function(e) {
        if (isWpEditorContent(e.target)) {
            e.preventDefault();
            return false;
        }
    });

    // Disable paste on wp-editor-content
    document.addEventListener('paste', function(e) {
        if (isWpEditorContent(e.target)) {
            e.preventDefault();
            return false;
        }
    });

    // Disable text selection on wp-editor-content
    document.addEventListener('selectstart', function(e) {
        if (isWpEditorContent(e.target)) {
            e.preventDefault();
            return false;
        }
    });

    // Disable drag on wp-editor-content
    document.addEventListener('dragstart', function(e) {
        if (isWpEditorContent(e.target)) {
            e.preventDefault();
            return false;
        }
    });
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/671f951c4304e3196ad97fde/1ib9lsv0d';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php wp_footer(); ?>

</body>
</html> 