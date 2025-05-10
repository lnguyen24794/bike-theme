<?php
/**
 * The template for displaying single bike posts
 *
 * @package Bike_Theme
 */

get_header();
wp_enqueue_style('bike-theme-single-bike', get_template_directory_uri() . '/assets/css/single-bike.css', array(), BIKE_THEME_VERSION);
wp_enqueue_script('bike-theme-single-bike', get_template_directory_uri() . '/assets/js/single-bike.js', array('jquery'), '', true);
wp_enqueue_style('bike-theme-tour-single', get_template_directory_uri() . '/assets/css/tour-single.css', array(), BIKE_THEME_VERSION);

?>

<main id="primary" class="site-main">
    <?php while (have_posts()) : the_post();
        // Get bike meta data
        $bike_price = get_post_meta(get_the_ID(), '_bike_price', true);
        $bike_gallery = get_post_meta(get_the_ID(), '_bike_gallery', true);
        $bike_accessories = get_post_meta(get_the_ID(), '_bike_accessories', true);
        $bike_how_to_book = get_post_meta(get_the_ID(), '_bike_how_to_book', true);
        $bike_conditions = get_post_meta(get_the_ID(), '_bike_conditions', true);
        $bike_reviews = get_post_meta(get_the_ID(), '_bike_reviews', true);
        $bike_contact = get_post_meta(get_the_ID(), '_bike_contact', true);
        ?>
        <!-- Top Section -->
        <?php include(get_template_directory() . '/template-parts/bike/bike-slider.php'); ?>
        <div class="container-xxl">
            <div class="row">
                <div class="col-md-12">
                   <?php the_content(); ?>
                </div>
            </div>
        </div>
        <!-- Bike Tabs Navigation -->
        <div class="tour-tabs animated" id="tourTabWrapper">
            <div class="container-xxl">
                <ul class="nav nav-tabs d-flex justify-content-start py-2" id="tourTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-uppercase active" id="price-tab" data-bs-toggle="tab" data-bs-target="#price" type="button" role="tab" aria-controls="price" aria-selected="true">
                            <?php esc_html_e('Price', 'bike-theme'); ?>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-uppercase" id="accessories-tab" data-bs-toggle="tab" data-bs-target="#accessories" type="button" role="tab" aria-controls="accessories" aria-selected="false">
                            <?php esc_html_e('Accessories', 'bike-theme'); ?>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-uppercase" id="conditions-tab" data-bs-toggle="tab" data-bs-target="#conditions" type="button" role="tab" aria-controls="conditions" aria-selected="false">
                            <?php esc_html_e('Conditions', 'bike-theme'); ?>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-uppercase" id="how-to-book-tab" data-bs-toggle="tab" data-bs-target="#how-to-book" type="button" role="tab" aria-controls="how-to-book" aria-selected="false">
                            <?php esc_html_e('How to Book', 'bike-theme'); ?>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link text-uppercase" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                            <?php esc_html_e('Reviews', 'bike-theme'); ?>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content Section -->
        <section class="bike-main-content py-0" id="tour-detail">
            <div class="container-xxl">
                <!-- Tab Content -->
                <div class="tab-content px-0 py-3" style="border: none; min-height: 100vh;" id="tourTabContent">
                    <!-- Bike Price Tab -->
                    <div class="tab-pane fade show active" id="price" role="tabpanel" aria-labelledby="price-tab">
                        <?php include(get_template_directory() . '/template-parts/bike/bike-price.php'); ?>
                    </div>

                    <!-- Accessories Tab -->
                    <div class="tab-pane fade" id="accessories" role="tabpanel" aria-labelledby="accessories-tab">
                        <?php include(get_template_directory() . '/template-parts/bike/bike-accessories.php'); ?>
                    </div>

                    <!-- Conditions Tab -->
                    <div class="tab-pane fade" id="conditions" role="tabpanel" aria-labelledby="conditions-tab">
                        <?php include(get_template_directory() . '/template-parts/bike/bike-conditions.php'); ?>
                    </div>

                     <!-- How to Book Tab -->
                     <div class="tab-pane fade" id="how-to-book" role="tabpanel" aria-labelledby="how-to-book-tab">
                        <?php include(get_template_directory() . '/template-parts/bike/bike-how-to-book.php'); ?>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <?php include(get_template_directory() . '/template-parts/bike/bike-review.php'); ?>
                    </div>
                </div>

                <?php include(get_template_directory() . '/template-parts/bike/bike-contact.php'); ?>
            </div>
        </section>
      
        
        <?php endwhile; ?>
        <script>
            $(document).ready(function() {
                $('#tourTab .nav-link').click(function() {
                    var $this = $(this);
                    window.scrollTo({
                        top: $('#tour-detail').offset().top - 150,
                        behavior: 'smooth'
                    });
                });
            });
        </script>
    
</main>

<?php
get_footer();
