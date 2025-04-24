<?php
/**
 * The template for displaying bike tour archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Bike_Theme
 */

get_header();
wp_enqueue_style('bike-theme-tour-archive', get_template_directory_uri() . '/assets/css/tour-archive.css', array(), BIKE_THEME_VERSION);
?>

<main id="primary" class="site-main">
    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0" style="background-image: url(<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bikes/tour-banner.jpg);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown"><?php esc_html_e('Our Bike Tours', 'bike-theme'); ?></h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center text-uppercase">
                        <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page"><?php esc_html_e('Bike Tours', 'bike-theme'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Tours Start -->
    <div class="container-xxl py-5">
            <!-- Destinations Grid Start -->
            <div class="row g-4">
                <?php
                // Get all destinations
                $destinations = get_terms(array(
                    'taxonomy' => 'destination',
                    'hide_empty' => false,
                    'parent' => 0,
                    'orderby' => 'name',
                    'order' => 'ASC'
                ));

if (!empty($destinations) && !is_wp_error($destinations)) :
    foreach ($destinations as $destination) :
        // Get destination image
        $image_id = get_term_meta($destination->term_id, 'destination_image', true);
        $image_url = wp_get_attachment_url($image_id);
        if (!$image_url) {
            $image_url = get_template_directory_uri() . '/assets/images/bikes/destination-default.jpg';
        }

        // Get tours count
        $tours_count = $destination->count;

        // Get category counts for this destination
        $category_counts = bike_theme_count_tours_by_category_in_destination($destination->term_id);
        ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="destination-folder">
                        <div class="folder-header">
                            <div class="folder-icon">
                                <i class="fas fa-map-marker-alt text-primary"></i>
                            </div>
                            <div class="folder-info">
                                <a href="<?php echo esc_url(get_term_link($destination)); ?>">
                                    <h2 class="folder-title"><?php echo esc_html($destination->name); ?></h2>
                                    <span class="tour-count"><?php printf(esc_html(_n('%s Tour', '%s Tours', $tours_count, 'bike-theme')), number_format_i18n($tours_count)); ?></span>
                                </a>
                            </div>
                        </div>
                        <div class="folder-content p-3">
                            <div class="folder-image">
                                <a href="<?php echo esc_url(get_term_link($destination)); ?>">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($destination->name); ?>" class="img-fluid rounded">
                                </a>
                            </div>
                            <div class="folder-categories">
                                <?php if (!empty($category_counts)) : ?>
                                    <?php foreach ($category_counts as $cat_id => $data) : ?>
                                        <div class="category-badge">
                                            <span class="badge bg-primary">
                                                <?php echo esc_html($data['category']->name); ?>
                                                <span class="count">(<?php echo esc_html($data['count']); ?>)</span>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="folder-description">
                                <?php echo wp_trim_words($destination->description, 20, '...'); ?>
                            </div>
                            <div class="folder-actions">
                                <a href="<?php echo esc_url(get_term_link($destination)); ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-2"></i><?php esc_html_e('View Tours', 'bike-theme'); ?>
                                </a>
                                <a href="/booking" class="btn btn-sm btn-dark">
                                    <i class="fas fa-calendar-alt me-2"></i><?php esc_html_e('Book Now', 'bike-theme'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
    endforeach;
endif;
?>
            </div>
            <!-- Destinations Grid End -->
    </div>
    <!-- Tours End -->
</main>

<?php
get_footer();
?> 