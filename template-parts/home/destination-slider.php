<?php 
    // Get all destinations
    $destinations = get_terms(array(
        'taxonomy' => 'destination',
        'hide_empty' => false,
        'parent' => 0, // Get only top-level destinations
        'orderby' => 'name',
        'order' => 'ASC',
        'number' => 6 // Limit to 6 destinations
    ));
?>
 <?php if (!empty($destinations)) :
?>
<style>
    .destination-slider .destination-item {
        position: relative;
        overflow:hidden;
        display:block;
        border-radius: 50px;
    }
    .destination-slider .destination-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        height: 200px;
    }
    .destination-slider .destination-slider-title {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 43, .4);
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.5);
        width: 100%;
        height: 100%;
    }
</style>
<div class="container-fluid pt-3 pb-4 destination-slider">   
    <div class="row tour-slider">
        <?php foreach($destinations as $key => $destination):
            if (!empty($destination)) :
                $image_id = get_term_meta($destination->term_id, 'destination_image', true);
                $image_url = wp_get_attachment_url($image_id);
                ?>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                    <a class="destination-item" href="<?php echo get_term_link($destination); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($destination->name); ?>">
                        <div class="destination-slider-title d-flex align-items-center justify-content-center">
                            <h3 class="text-white"><?php echo esc_html($destination->name); ?></h3>
                        </div>
                    </a>
                </div>
            <?php 
            endif;
        endforeach; ?>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a class="destination-item" href="/vietnam-multi-day-tours">
                <?php 
                    $vietnam_multi_day_tours_page = get_page_by_path('vietnam-multi-day-tours');
                    $vietnam_multi_day_tours_image = get_the_post_thumbnail_url($vietnam_multi_day_tours_page->ID, 'full');
                ?>
                <img src="<?php echo esc_url($vietnam_multi_day_tours_image); ?>" 
                    alt="<?php echo esc_attr('Vietnam multi-day tours'); ?>">
                <div class="destination-slider-title d-flex align-items-center justify-content-center">
                    <h3 class="text-white"><?php echo esc_html('Vietnam multi-day tours'); ?></h3>
                </div>
            </a>
        </div>
    </div>

    <script>
        // jQuery(document).ready(function($){
        //     $('.tour-slider').owlCarousel({
        //         loop: true,
        //         margin: 20,
        //         nav: true,
        //         dots: true,
        //         autoplay: false,
        //         autoplayTimeout: 10000,
        //         autoplayHoverPause: true,
        //         navText: [
        //             "<i class='fa fa-chevron-left'></i>",
        //             "<i class='fa fa-chevron-right'></i>"
        //         ],
        //         responsive:{
        //             0:{
        //                 items:1
        //             },
        //             768:{
        //                 items:2
        //             },
        //             992:{
        //                 items:4
        //             }
        //         }
        //     });
        // });
    </script>
</div>
<?php endif; ?>