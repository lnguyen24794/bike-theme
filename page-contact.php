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
            <h1 class="mb-5"><?php echo wp_kses_post(sprintf(__('<span class="text-primary text-uppercase">%s</span> %s', 'bike-theme'), __('Contact', 'bike-theme'), __('For Any Query', 'bike-theme'))); ?></h1>
        </div>
        <div class="container">
            <?php the_content(); ?>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="col-md-12">
                    <h4 class=" mb-4"><?php esc_html_e('Our Shop', 'bike-theme'); ?></h4>
                <?php foreach (bike_theme_get_option('contact_address', array()) as $branch) : ?>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i><a  href="<?php echo esc_url($branch['link']); ?>" target="_blank"><?php echo esc_html($branch['name']); ?></a></p>
                    <p class="mb-2"><?php echo esc_html($branch['address']); ?></p>
                    <p class="mb-2"><i class="fa fa-clock me-3"></i><?php echo esc_html($branch['opening_closed']); ?></p>
                <?php endforeach; ?>
                </div>
                <div class="col-md-12 mt-4">
                    <h4 class=" mb-4"><?php esc_html_e('Contact Information', 'bike-theme'); ?></h4>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i><a  href="mailto:<?php echo esc_attr(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?>"><?php echo esc_html(bike_theme_get_option('contact_email', 'info@beebikehub.com')); ?></a></p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i><a  href="tel:<?php echo esc_attr(bike_theme_get_option('contact_phone', '+849854557270')); ?>"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fab fa-whatsapp me-3"></i><a  href="https://api.whatsapp.com/send/?phone=<?php echo esc_attr(bike_theme_get_option('contact_phone', '84985455727')); ?>&text&type=phone_number&app_absent=0"><?php echo esc_html(bike_theme_get_option('whatsapp_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fab fa-telegram me-3"></i><a  href="https://t.me/beebikehub"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                    <p class="mb-2"><i class="fa fab-zalo" style="margin-right: 6px;">Zalo</i><a  href="https://zalo.me/0985455727"><?php echo esc_html(bike_theme_get_option('contact_phone', '+849854557270')); ?></a></p>
                </div>
                <div class="col-md-12 mt-4">
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
            <div class="col-md-8 ">
                <div class="wow fadeInUp bg-primary p-3" data-wow-delay="0.2s">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                    <form id="contact-form" action="" method="post">
                        <?php wp_nonce_field('bike_theme_contact_nonce', 'contact_nonce'); ?>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="<?php esc_attr_e('Your Name', 'bike-theme'); ?>" required>
                                    <label for="name"><?php esc_html_e('Your Name', 'bike-theme'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="<?php esc_attr_e('Your Email', 'bike-theme'); ?>" required>
                                    <label for="email"><?php esc_html_e('Your Email', 'bike-theme'); ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="subject" name="subject" placeholder="<?php esc_attr_e('Subject', 'bike-theme'); ?>" required>
                                    <label for="subject"><?php esc_html_e('Subject', 'bike-theme'); ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="<?php esc_attr_e('Leave a message here', 'bike-theme'); ?>" id="message" name="message" style="height: 150px" required></textarea>
                                    <label for="message"><?php esc_html_e('Message', 'bike-theme'); ?></label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-dark w-100 py-3" type="submit"><?php esc_html_e('Send Message', 'bike-theme'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12 wow fadeIn" data-wow-delay="0.1s">
                <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d245386.29943491388!2d108.03706786319917!3d16.05713670186373!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sBeebikehub!5e0!3m2!1sen!2sus!4v1745850968203!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          
        </div>
    </div>
    <!-- Contact End -->

</main><!-- #main -->

<?php
get_footer();
?> 