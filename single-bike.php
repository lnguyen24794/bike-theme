<?php
/**
 * The template for displaying single bike posts
 *
 * @package Bike_Theme
 */

get_header();
wp_enqueue_style('bike-theme-single-bike', get_template_directory_uri() . '/assets/css/single-bike.css', array(), '1.0.0');
wp_enqueue_script('bike-theme-single-bike', get_template_directory_uri() . '/assets/js/single-bike.js', array('jquery'), '1.0.0', true);
?>

<main id="primary" class="site-main">
    <?php while (have_posts()) : the_post(); 
        // Get bike meta data
        $price = get_post_meta(get_the_ID(), 'bike_price', true);
        $sale_price = get_post_meta(get_the_ID(), 'bike_sale_price', true);
        $brand = get_post_meta(get_the_ID(), 'bike_brand', true);
        $rating = get_post_meta(get_the_ID(), 'bike_rating', true);
        $rating_count = get_post_meta(get_the_ID(), 'bike_rating_count', true);
        $gallery_images = get_post_meta(get_the_ID(), 'bike_gallery', true);
        $specifications = get_post_meta(get_the_ID(), 'bike_specifications', true);
        $included_accessories = get_post_meta(get_the_ID(), 'bike_included_accessories', true);
        $stock_quantity = get_post_meta(get_the_ID(), 'bike_stock_quantity', true);
    ?>
        <!-- Top Section -->
        <section class="bike-top-section">
            <div class="container">
                <div class="row">
                    <!-- Image Gallery Section -->
                    <div class="col-lg-7">
                        <div class="bike-gallery">
                            <div class="bike-main-image">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('full', array('class' => 'img-fluid')); ?>
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-bike.jpg" alt="<?php the_title_attribute(); ?>" class="img-fluid">
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($gallery_images)) : ?>
                            <div class="bike-thumbnails">
                                <?php foreach ($gallery_images as $image) : ?>
                                    <div class="thumbnail-item">
                                        <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>" class="img-fluid">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Product Info Section -->
                    <div class="col-lg-5">
                        <div class="bike-info">
                            <?php if (!empty($brand)) : ?>
                                <div class="bike-brand"><?php echo esc_html($brand); ?></div>
                            <?php endif; ?>
                            
                            <h1 class="bike-title"><?php the_title(); ?></h1>
                            
                            <?php if (!empty($rating)) : ?>
                            <div class="bike-rating">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                        <i class="fas fa-star<?php echo $i <= $rating ? '' : '-o'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-text">
                                    <?php printf(
                                        esc_html__('%1$s/5 - %2$s reviews', 'bike-theme'),
                                        number_format($rating, 1),
                                        $rating_count
                                    ); ?>
                                </span>
                            </div>
                            <?php endif; ?>

                            <div class="bike-price">
                                <?php if (!empty($sale_price)) : ?>
                                    <span class="original-price"><?php echo number_format($price, 2, ',', '.'); ?> $ / hour</span>
                                    <span class="sale-price"><?php echo number_format($sale_price, 2, ',', '.'); ?> $ / hour</span>
                                <?php elseif (!empty($price)) : ?>
                                    <span class="current-price"><?php echo number_format($price, 2, ',', '.'); ?> $ / hour</span>
                                <?php endif; ?>
                            </div>

                            <div class="bike-actions">
                                <a href="/contact" class="btn btn-outline-primary btn-contact">
                                    <i class="fas fa-phone"></i> <?php esc_html_e('Contact Us', 'bike-theme'); ?>
                                </a>
                            </div>

                            <?php if (!empty($stock_quantity)) : ?>
                            <div class="bike-stock">
                                <i class="fas fa-box"></i> <?php printf(esc_html__('Only %s left in stock', 'bike-theme'), $stock_quantity); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content Section -->
        <section class="bike-main-content">
            <div class="container">
                <!-- Navigation Tabs -->
                <ul class="nav nav-tabs" id="bikeTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab">
                            <?php esc_html_e('Overview', 'bike-theme'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="specs-tab" data-bs-toggle="tab" href="#specs" role="tab">
                            <?php esc_html_e('Specifications', 'bike-theme'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab">
                            <?php esc_html_e('Reviews', 'bike-theme'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="accessories-tab" data-bs-toggle="tab" href="#accessories" role="tab">
                            <?php esc_html_e('Accessories', 'bike-theme'); ?>
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="bikeTabContent">
                    <!-- Overview Tab -->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <div class="bike-overview">
                            <?php the_content(); ?>
                            
                            <?php if (!empty($specifications)) : ?>
                            <div class="bike-highlights">
                                <h3><?php esc_html_e('Key Features', 'bike-theme'); ?></h3>
                                <ul>
                                    <?php foreach ($specifications as $key => $value) : ?>
                                        <li><strong><?php echo esc_html($key); ?>:</strong> <?php echo esc_html($value); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    <div class="tab-pane fade" id="specs" role="tabpanel">
                        <?php if (!empty($specifications)) : ?>
                        <div class="bike-specifications">
                            <table class="table">
                                <tbody>
                                    <?php foreach ($specifications as $key => $value) : ?>
                                    <tr>
                                        <th><?php echo esc_html($key); ?></th>
                                        <td><?php echo esc_html($value); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <a href="#" class="btn btn-outline-primary btn-download-specs">
                                <i class="fas fa-download"></i> <?php esc_html_e('Download PDF Specifications', 'bike-theme'); ?>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Reviews Tab -->
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="bike-reviews">
                            <?php 
                            // If comments are open or we have at least one comment, load up the comment template.
                            if (comments_open() || get_comments_number()) :
                                comments_template();
                            endif;
                            ?>
                        </div>
                    </div>

                    <!-- Accessories Tab -->
                    <div class="tab-pane fade" id="accessories" role="tabpanel">
                        <?php if (!empty($included_accessories)) : ?>
                        <div class="bike-accessories">
                            <div class="row">
                                <?php foreach ($included_accessories as $accessory) : ?>
                                <div class="col-md-4 col-sm-6">
                                    <div class="accessory-item">
                                        <img src="<?php echo esc_url($accessory['image']); ?>" alt="<?php echo esc_attr($accessory['name']); ?>" class="img-fluid">
                                        <h4><?php echo esc_html($accessory['name']); ?></h4>
                                        <p><?php echo esc_html($accessory['description']); ?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Additional Section -->
        <section class="bike-additional">
            <div class="container">
                <!-- Related Products -->
                <?php
                $related_bikes = get_posts(array(
                    'post_type' => 'bike',
                    'posts_per_page' => 4,
                    'post__not_in' => array(get_the_ID()),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'bike_category',
                            'field' => 'term_id',
                            'terms' => wp_get_post_terms(get_the_ID(), 'bike_category', array('fields' => 'ids')),
                        ),
                    ),
                ));

                if ($related_bikes) :
                ?>
                <div class="related-bikes">
                    <h3><?php esc_html_e('Related Bikes', 'bike-theme'); ?></h3>
                    <div class="row">
                        <?php foreach ($related_bikes as $related_bike) : ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="related-bike-item">
                                <?php if (has_post_thumbnail($related_bike->ID)) : ?>
                                    <img src="<?php echo get_the_post_thumbnail_url($related_bike->ID, 'medium'); ?>" alt="<?php echo esc_attr($related_bike->post_title); ?>" class="img-fluid">
                                <?php endif; ?>
                                <h4><?php echo esc_html($related_bike->post_title); ?></h4>
                                <?php 
                                $related_price = get_post_meta($related_bike->ID, 'bike_price', true);
                                if (!empty($related_price)) :
                                ?>
                                <div class="price"><?php echo number_format($related_price, 0, ',', '.'); ?> VNĐ</div>
                                <?php endif; ?>
                                <a href="<?php echo get_permalink($related_bike->ID); ?>" class="btn btn-outline-primary btn-sm">
                                    <?php esc_html_e('View Details', 'bike-theme'); ?>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- FAQ Section -->
                <div class="bike-faq">
                    <h3><?php esc_html_e('Frequently Asked Questions', 'bike-theme'); ?></h3>
                    <div class="accordion" id="faqAccordion">
                        <?php
                        $faqs = array(
                            array(
                                'question' => __('Does this bike come with warranty?', 'bike-theme'),
                                'answer' => __('Yes, all Bike Rentals come with a 2-year manufacturer warranty.', 'bike-theme')
                            ),
                            array(
                                'question' => __('Do you offer home delivery?', 'bike-theme'),
                                'answer' => __('Yes, we offer free delivery within city limits and paid delivery to other locations.', 'bike-theme')
                            ),
                            array(
                                'question' => __('How do I choose the right size?', 'bike-theme'),
                                'answer' => __('You can use our size guide or visit our store for a professional fitting session.', 'bike-theme')
                            )
                        );

                        foreach ($faqs as $index => $faq) :
                        ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?php echo $index === 0 ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?php echo $index; ?>">
                                    <?php echo esc_html($faq['question']); ?>
                                </button>
                            </h2>
                            <div id="faq<?php echo $index; ?>" class="accordion-collapse collapse <?php echo $index === 0 ? 'show' : ''; ?>">
                                <div class="accordion-body">
                                    <?php echo esc_html($faq['answer']); ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bottom Section -->
        <section class="bike-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="bottom-cta">
                            <a href="/contact" class="btn btn-primary btn-lg btn-buy">
                                <i class="fas fa-phone"></i> <?php esc_html_e('Contact Now', 'bike-theme'); ?>
                            </a>
                            <?php if (!empty($stock_quantity) && $stock_quantity < 10) : ?>
                            <div class="stock-warning">
                                <?php printf(esc_html__('Only %s left in stock!', 'bike-theme'), $stock_quantity); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bottom-support text-end">
                            <button class="btn btn-outline-primary btn-chat">
                                <i class="fas fa-comments"></i> <?php esc_html_e('Chat with Expert', 'bike-theme'); ?>
                            </button>
                            <div class="social-share">
                                <span><?php esc_html_e('Share:', 'bike-theme'); ?></span>
                                <a href="#" class="facebook"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <?php endwhile; ?>
</main>

<?php
get_footer();
