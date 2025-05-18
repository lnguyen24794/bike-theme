<?php
/**
 * The template for displaying destination taxonomy archives
 *
 * @package Bike_Theme
 */

get_header();
wp_enqueue_style('bike-theme-tour-archive', get_template_directory_uri() . '/assets/css/tour-archive.css', array(), BIKE_THEME_VERSION);
// Get current destination term
$term = get_queried_object();

// Get destination image
$image_id = get_term_meta($term->term_id, 'destination_image', true);
$image_url = wp_get_attachment_url($image_id);
if (!$image_url) {
    $image_url = get_template_directory_uri() . '/assets/images/bikes/destination-default.jpg';
}

// Get category counts for this destination
$category_counts = bike_theme_count_tours_by_category_in_destination($term->term_id);

$tour_category = get_query_var('tour_category');
?>

<main id="primary" class="site-main">
    <!-- Destination Header Banner -->
    <div class="container-fluid page-header mb-2 py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?php echo esc_url($image_url); ?>') center center no-repeat; background-size: cover;">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown"><?php echo esc_html($term->name); ?></h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a class="text-white" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'bike-theme'); ?></a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="<?php echo esc_url(get_post_type_archive_link('bike_tour')); ?>"><?php esc_html_e('Tours', 'bike-theme'); ?></a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page"><?php echo esc_html($term->name); ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Destination Header Banner End -->

    <!-- Destination Information -->
    <div class="container-xxl py-5">
        <div class="row">
            <div class="col-lg-9">
                <!-- Tours List Start -->
                <div class="row g-4">
                    <?php
                    // Set up custom query with filters
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'bike_tour',
    'posts_per_page' => 9,
    'paged' => $paged,
    'tax_query' => array(
        array(
            'taxonomy' => 'destination',
            'field' => 'term_id',
            'terms' => $term->term_id,
        ),
    ),
);
// Add meta query if filters are active
$meta_query = array();
// Duration filter
if (isset($_GET['duration']) && !empty($_GET['duration'])) {
    switch ($_GET['duration']) {
        case '1-3':
            $meta_query[] = array(
                'key' => '_tour_duration',
                'value' => array(1, 3),
                'type' => 'numeric',
                'compare' => 'BETWEEN'
            );
            break;
        case '4-7':
            $meta_query[] = array(
                'key' => '_tour_duration',
                'value' => array(4, 7),
                'type' => 'numeric',
                'compare' => 'BETWEEN'
            );
            break;
        case '8+':
            $meta_query[] = array(
                'key' => '_tour_duration',
                'value' => 8,
                'type' => 'numeric',
                'compare' => '>='
            );
            break;
    }
}

// Difficulty filter
if (isset($_GET['difficulty']) && !empty($_GET['difficulty'])) {
    $meta_query[] = array(
        'key' => '_tour_difficulty',
        'value' => sanitize_text_field($_GET['difficulty']),
        'compare' => '='
    );
}

if (!empty($tour_category)) {
    $args['tax_query'][] = array(
        'taxonomy' => 'tour_category',
        'field' => 'slug',
        'terms' => $tour_category,
    );
}

if (!empty($meta_query)) {
    $args['meta_query'] = $meta_query;
}

$tour_query = new WP_Query($args);

if ($tour_query->have_posts()) :
    while ($tour_query->have_posts()) : $tour_query->the_post();
        $duration = bike_theme_get_tour_duration(get_the_ID());
        $distance = get_post_meta(get_the_ID(), '_tour_distance', true);
        $difficulty = get_post_meta(get_the_ID(), '_tour_difficulty', true);
        $price = bike_theme_get_tour_price(get_the_ID());
        $flexible_pricing = get_post_meta(get_the_ID(), '_tour_flexible_pricing_enabled', true) === '1';
        ?>
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="tour-item shadow rounded h-100">
                                <div class="position-relative">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                                        </a>
                                    <?php else : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <img class="img-fluid" height="200" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/placeholder-tour.jpg" alt="<?php the_title_attribute(); ?>">
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="p-3 mt-2 a pb-0">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h5 class="mb-0"><a href="<?php the_permalink(); ?>" class="text-dark"><?php the_title(); ?></a></h5>
                                    </div>
                                    <div class="facts p-0 mb-3">
                                        <div class="style touring" style="text-transform: capitalize;"> <?php echo esc_html($difficulty); ?></div>
                                        <div class="duration"><?php echo esc_html($duration); ?> </div>
                                        <div class="destination"><?php echo esc_html($distance); ?> km</div>
                                        <div class="price">From <?php echo bike_theme_format_price($price); ?></div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-sm btn-primary w-50 rounded py-2 px-2" href="<?php the_permalink(); ?>"><?php esc_html_e('View Details', 'bike-theme'); ?></a>
                                        <a class="btn btn-sm btn-dark w-50 rounded py-2 px-2" href="<?php echo esc_url(get_permalink(get_option('bike_theme_booking_page'))); ?>?tour=<?php the_ID(); ?>"><?php esc_html_e('Book Now', 'bike-theme'); ?></a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        <?php
                            endwhile;
                        wp_reset_postdata();
                        else :
                            ?>
                        <div class="col-12 text-center">
                            <h3><?php esc_html_e('No bike tours found.', 'bike-theme'); ?></h3>
                            <p><?php esc_html_e('Please try different filter options or check back later.', 'bike-theme'); ?></p>
                        </div>
                    <?php
endif;
?>
                </div>
                <!-- Tours List End -->

                <!-- Pagination -->
                <div class="row mt-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            <?php
                            $big = 999999999; // Need an unlikely integer
                            echo paginate_links(array(
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $tour_query->max_num_pages,
                                'prev_text' => '<i class="fa fa-angle-left"></i>',
                                'next_text' => '<i class="fa fa-angle-right"></i>',
                                'type' => 'list',
                                'end_size' => 4,
                                'mid_size' => 4
                            ));
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h4 class="mb-3"><?php esc_html_e('Need Assistance?', 'bike-theme'); ?></h4>
                        <p><?php esc_html_e('Contact our tour experts for personalized tour recommendations or special requirements.', 'bike-theme'); ?></p>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-phone-alt text-primary me-2"></i>
                            <p class="mb-0"><a href="tel:<?php echo bike_theme_get_option('contact_phone', '+84985455727'); ?>"><?php echo bike_theme_get_option('contact_phone', '+84985455727'); ?></a></p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa fa-envelope-open text-primary me-2"></i>
                            <p class="mb-0"><a href="mailto:<?php echo bike_theme_get_option('contact_email', 'info@beebikehub.com'); ?>"><?php echo bike_theme_get_option('contact_email', 'info@beebikehub.com'); ?></a></p>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h4 class="mb-3"><?php esc_html_e('Other Destinations', 'bike-theme'); ?></h4>
                        <div class="destination-category-list">
                            <div class="destination-categories">
                            <ul class="list-unstyled">
                            <?php
                                // Get other destinations
                                $other_destinations = get_terms(array(
                                    'taxonomy' => 'destination',
                                    'hide_empty' => false,
                                    'exclude' => array($term->term_id),
                                    'number' => 6
                                ));

                                if (!empty($other_destinations) && !is_wp_error($other_destinations)) :
                                    foreach ($other_destinations as $other_destination) :
                                        $other_image_id = get_term_meta($other_destination->term_id, 'destination_image', true);
                                        $other_image_url = wp_get_attachment_url($other_image_id);
                                        if (!$other_image_url) {
                                            $other_image_url = get_template_directory_uri() . '/assets/images/bikes/destination-default.jpg';
                                        }
                                        ?>
                                                            
                                        <li>
                                            <a href="/destination/<?php echo esc_attr($other_destination->slug); ?>">
                                                <?php echo esc_html($other_destination->name); ?> <span class="badge bg-primary rounded-pill"><?php echo esc_html($other_destination->count); ?></span>
                                            </a>
                                        </li>
                                    
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Destination Information End -->
</main>

<?php
get_footer();
?> 