<?php
/**
 * The template for displaying single bike posts
 *
 * @package Bike_Theme
 */

get_header();

?>

<main id="primary" class="site-main">
    <?php while (have_posts()) : the_post();
        // Get bike meta data
        $bike_price = get_post_meta(get_the_ID(), '_bike_price', true);
        $bike_gallery = get_post_meta(get_the_ID(), '_bike_gallery', true);
        $bike_accessories = get_post_meta(get_the_ID(), '_bike_accessories', true);
        $bike_how_to_book = get_post_meta(get_the_ID(), '_bike_how_to_book', true);
        $bike_conditions = get_post_meta(get_the_ID(), '_bike_conditions', true);
        $bike_reviews = get_post_meta(get_the_ID(), '_bike_review', true);
        $bike_contact = get_post_meta(get_the_ID(), '_bike_contact', true);
        $bike_review_info = get_post_meta(get_the_ID(), '_bike_review_info', true);
        ?>
        <!-- Top Section -->
        <?php include(get_template_directory() . '/template-parts/bike/bike-slider.php'); ?>
        <div class="container-xxl mt-3">
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
                <div class="tab-content px-0 py-3" style="border: none; " id="tourTabContent">
                    <!-- Bike Price Tab -->
                    <div class="tab-pane fade show active" id="price" role="tabpanel" aria-labelledby="price-tab">
                        <?php include(get_template_directory() . '/template-parts/bike/bike-price.php'); ?>
                        <?php include(get_template_directory() . '/template-parts/bike/bike-accessories.php'); ?>
                        <?php include(get_template_directory() . '/template-parts/bike/bike-conditions.php'); ?>
                        <?php include(get_template_directory() . '/template-parts/bike/bike-how-to-book.php'); ?>
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
                    var target = $this.attr('data-bs-target');
                    window.scrollTo({
                        top: $(target).offset().top - 100,
                        behavior: 'smooth'
                    });
                });
            });
        </script>
    
</main>

<?php
get_footer();
