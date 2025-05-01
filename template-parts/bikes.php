<div class="row g-4">
    <?php
        $args = array(
            'post_type' => 'bike',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'ASC',
        );

        $bikes_query = new WP_Query($args);

        if ($bikes_query->have_posts()) :
            while ($bikes_query->have_posts()) : $bikes_query->the_post();
                $bike_price = get_post_meta(get_the_ID(), 'bike_price', true);
                $bike_brand = get_post_meta(get_the_ID(), 'bike_brand', true);
                $bike_type = get_post_meta(get_the_ID(), 'bike_type', true);
                $duration = get_post_meta(get_the_ID(), 'bike_duration', true);
                $is_available = get_post_meta(get_the_ID(), '_bike_available', true);
            ?>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="room-item shadow rounded">
                    <div class="position-relative bike-image">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', array('class' => 'img-fluid')); ?>
                        <?php else : ?>
                            <img class="img-fluid" src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/bikes/bike-default.jpg" alt="<?php the_title_attribute(); ?>">
                        <?php endif; ?>
                        <small style="top: 25px !important; left: -10px !important;" class="position-absolute bike-label bg-primary text-white rounded py-1 px-3 ms-4">
                            <?php if ($is_available !== 'yes') : ?>
                                <?php esc_html_e('Coming Soon', 'bike-theme'); ?>
                            <?php else : ?>
                              
                            <?php endif; ?>
                        </small>
                    </div>
                    <div class="p-3 mt-2 a">
                        <div class="bikes-item mb-2">
                            <h5 class="mb-0"><?php the_title(); ?></h5>
                        </div>
                        <div class="d-flex mb-3">
                            <?php if ($bike_brand) : ?>
                            <small class="border-end me-3 pe-3"><i class="fa fa-tag text-primary me-2"></i><?php echo esc_html($bike_brand); ?></small>
                            <?php endif; ?>
                            <?php if ($bike_type) : ?>
                            <small><i class="fa fa-bicycle text-primary me-2"></i><?php echo esc_html($bike_type); ?></small>
                            <?php endif; ?>
                            <?php if ($duration) : ?>
                            <span><i class="fa fa-clock me-2"></i><?php echo esc_html(bike_theme_get_tour_duration(get_the_ID())); ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="text-body mb-3"><?php echo wp_trim_words(the_excerpt(), 20, '...'); ?></p>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-sm btn-primary rounded py-2 px-4" href="<?php the_permalink(); ?>"><?php esc_html_e('View Details', 'bike-theme'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
    <?php
            endwhile;
wp_reset_postdata();
    ?> <?php endif; ?>
</div>
<div class="text-center mt-5">
    <a href="<?php echo esc_url(get_post_type_archive_link('bike')); ?>" class="btn btn-primary py-3 px-5"><?php esc_html_e('View All Bikes', 'bike-theme'); ?></a>
</div>