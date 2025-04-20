<?php
/**
 * Template Name: Contact Page
 *
 * @package Bike_Theme
 */

get_header();
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main id="primary" class="site-main">

    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(<?php echo esc_url($featured_image); ?>);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown"><?php the_title(); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page"><?php the_title(); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title text-center text-primary text-uppercase"><?php esc_html_e('Contact Us', 'bike-theme'); ?></h6>
            <h1 class="mb-5"><?php echo wp_kses_post(sprintf(__('<span class="text-primary text-uppercase">%s</span> %s', 'bike-theme'), __('Contact', 'bike-theme'), __('For Any Query', 'bike-theme'))); ?></h1>
        </div>
        <div class="row g-4">
            <div class="col-12">
                <div class="row gy-4">
                    <div class="col-md-4">
                        <h6 class="section-title text-start text-primary text-uppercase"><?php esc_html_e('Sales', 'bike-theme'); ?></h6>
                        <p><i class="fa fa-envelope-open text-primary me-2"></i><a href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="section-title text-start text-primary text-uppercase"><?php esc_html_e('Service', 'bike-theme'); ?></h6>
                        <p><i class="fa fa-envelope-open text-primary me-2"></i><a href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="section-title text-start text-primary text-uppercase"><?php esc_html_e('General', 'bike-theme'); ?></h6>
                        <p><i class="fa fa-envelope-open text-primary me-2"></i><a href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1917.0985752873369!2d108.245189!3d16.055256!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142173a7147582d%3A0xa536f5fc9eab63cd!2sBee%20Bike%20-%20Bike%20Tours%20and%20Bike%20Rentals!5e0!3m2!1sen!2s!4v1745131690485!5m2!1sen!2s" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-md-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                    <form id="contact-form" action="" method="post">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="<?php esc_attr_e('Your Name', 'bike-theme'); ?>">
                                    <label for="name"><?php esc_html_e('Your Name', 'bike-theme'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="<?php esc_attr_e('Your Email', 'bike-theme'); ?>">
                                    <label for="email"><?php esc_html_e('Your Email', 'bike-theme'); ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="<?php esc_attr_e('Subject', 'bike-theme'); ?>">
                                    <label for="subject"><?php esc_html_e('Subject', 'bike-theme'); ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="<?php esc_attr_e('Leave a message here', 'bike-theme'); ?>" id="message" name="message" style="height: 150px"></textarea>
                                    <label for="message"><?php esc_html_e('Message', 'bike-theme'); ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit"><?php esc_html_e('Send Message', 'bike-theme'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

</main><!-- #main -->

<?php
get_footer();
?> 