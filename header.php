<?php
/**
 * The header for our theme
 *
 * @package Bike_Theme
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="<?php echo get_bloginfo('description'); ?>" name="description">
    <meta content="<?php echo esc_attr(bike_theme_get_option('meta_keywords', 'bikes, cycling, bicycle')); ?>" name="keywords">
    
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
<?php wp_head();
wp_enqueue_style('home-header', get_template_directory_uri() . '/assets/css/home.css', array(), BIKE_THEME_VERSION); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="container-fluid bg-white p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only"><?php esc_html_e('Loading...', 'bike-theme'); ?></span>
        </div>
    </div>
    <!-- Spinner End -->
    <div class="container-fluid px-0 home-header animated fadeInDown <?php echo (is_front_page()) ? ' hide-mobile' : 'd-none'; ?>" id="mainHeader">
        <div class="text-center" style="padding-top: 25px;">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                <?php if (has_custom_logo()) :
                    $custom_logo_id = get_theme_mod('custom_logo');
                    $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                    ?>
                    <img width="115px" height="115px" src="<?php echo esc_url($logo[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="img-fluid custom-logo" style="max-height: 100px;">
                <?php else : ?>
                    <h1 class="m-0 text-primary text-uppercase"><?php echo get_bloginfo('name'); ?></h1>
                <?php endif; ?>
            </a>
        </div>
        <div class="text-center">
            <?php
            wp_nav_menu(array(
                'theme_location'  => 'primary',
                'depth'           => 2,
                'container'       => 'nav',
                'container_class' => 'navbar navbar-expand-lg navbar-dark home-header-nav',
                'container_id'    => 'primary-navigation',
                'menu_class'      => 'navbar-nav mx-auto',
                'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
                'walker'          => new WP_Bootstrap_Navwalker()
            ));
            ?>
        </div>
    </div>

    <div class="container-fluid bg-primary px-0 animated fadeInDown <?php echo (is_front_page()) ? 'd-none' : ''; ?> show-mobile" id="scrollHeader">
        <div class="row gx-0">
            <div class="col-lg-3 bg-primary d-none d-lg-block">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <?php if (has_custom_logo()) :
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                        $secondary_logo = bike_theme_get_option('secondary_logo');
                        ?>
                        <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="img-fluid custom-logo" style="max-height: 100px;">
                    <?php else : ?>
                        <h1 class="m-0 text-primary text-uppercase"><?php echo get_bloginfo('name'); ?></h1>
                    <?php endif; ?>
                    <img src="<?php echo esc_url($secondary_logo); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="img-fluid custom-logo" style="max-height: 100px; width: 225px;">
                </a>
            </div>
            <div class="col-lg-9">
                <div class="row gx-0 bg-dark text-white d-none d-lg-flex border-radius-bottom-left-15 header-contact-info">
                    <div class="col-lg-7 px-5 text-start align-items-center justify-content-center pt-1">
                        <div class="d-inline-flex align-items-center me-4">
                            <i class="fa fa-envelope text-primary me-2"></i>
                            <p class="mb-0"><a class="text-white" href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
                        </div>
                        <div class="d-inline-flex align-items-center">
                            <i class="fab fa-whatsapp text-primary me-2"></i>
                            <p class="mb-0"><a class="text-white" href="https://api.whatsapp.com/send/?phone=<?php echo esc_attr(bike_theme_get_option('contact_phone', '84985455727')); ?>&text&type=phone_number&app_absent=0"><?php echo esc_html(bike_theme_get_option('whatsapp_phone', '+84985455727')); ?></a></p>
                        </div>
                    </div>
                    <div class="col-lg-5 px-5 text-end">
                        <div class="d-inline-flex align-items-center">
                            <a class="me-3" href="#">FOLLOW US</a>
                            <?php if (bike_theme_get_option('facebook')) : ?>
                            <a class="me-3" href="<?php echo esc_url(bike_theme_get_option('facebook')); ?>"><i class="fab fa-facebook"></i></a>
                            <?php endif; ?>
                            
                            <?php if (bike_theme_get_option('address_link')) : ?>
                            <a class="me-3" href="<?php echo esc_url(bike_theme_get_option('address_link')); ?>"><i class="fab fa-google"></i></a>
                            <?php endif; ?>
                            
                            <?php if (bike_theme_get_option('youtube')) : ?>
                            <a class="me-3" href="<?php echo esc_url(bike_theme_get_option('youtube')); ?>"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                            
                            <?php if (bike_theme_get_option('instagram')) : ?>
                            <a class="me-3" href="<?php echo esc_url(bike_theme_get_option('instagram')); ?>"><i class="fab fa-instagram"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <nav class="navbar navbar-expand-lg bg-primary navbar-dark p-2 px-lg-0 pb-lg-0 pt-lg-2 animated" id="mobileNavbar">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="navbar-brand d-block d-lg-none">
                        <?php if (has_custom_logo()) :
                            $custom_logo_id = get_theme_mod('custom_logo');
                            $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
                            $secondary_logo = bike_theme_get_option('secondary_logo');
                            ?>
                            <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="img-fluid custom-logo-mobile" style="max-height: 40px;">
                            <img src="<?php echo $secondary_logo; ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="img-fluid custom-logo-mobile" style="max-height: 40px; width: 225px;">
                        <?php else : ?>
                            <h1 class="m-0 text-primary text-uppercase"><?php bloginfo('name'); ?></h1>
                        <?php endif; ?>
                    </a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <?php
                            wp_nav_menu(array(
                                'theme_location'    => 'primary',
                                'depth'             => 2,
                                'container'         => false,
                                'menu_class'        => 'navbar-nav mr-auto py-0',
                                'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
                                'walker'            => new WP_Bootstrap_Navwalker()
                            ));
                        ?>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <script>
         if(window.innerWidth <= 992){
            var scrollHeader = document.getElementById('scrollHeader');
            scrollHeader.classList.remove('d-none');
         }
        window.addEventListener('scroll', function() {
            var isFrontPage = <?php echo is_front_page() ? 1 : 0; ?>;
            var header = document.getElementById('mainHeader');
            var scrollHeader = document.getElementById('scrollHeader');
            if(window.innerWidth > 992){
               
                if (window.scrollY > 50) {
                    if(isFrontPage){
                        header.classList.add('d-none');
                        scrollHeader.classList.remove('d-none');
                    }
                    scrollHeader.classList.add('header-sticky', 'fadeInDown');
                } else {
                    if(isFrontPage){
                        scrollHeader.classList.add('d-none');
                        header.classList.remove('d-none');
                    }
                    scrollHeader.classList.remove('header-sticky', 'fadeInDown');
                }
            } else {
                if (window.scrollY > 100) {
                    scrollHeader.classList.add('tab-fixed', 'fadeInDown');
                }else {
                    scrollHeader.classList.remove('tab-fixed', 'fadeInDown');
                }
            }
        });
    </script>
</div>

<?php wp_footer(); ?>
</body>
</html> 