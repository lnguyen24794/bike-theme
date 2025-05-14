<!-- Reviews Tab -->
<div class="w-100 py-3">
        <div class="wow fadeInUp">
        <h3 class="border-bottom text-size-medium mb-0 text-primary text-uppercase"><?php esc_html_e('Reviews', 'bike-theme'); ?></h3>
    </div>
    <div class="pb-3">
        <?php if (!empty($bike_reviews)) :
            $review_ids_array = is_array($bike_reviews) ? $bike_reviews : explode(',', $bike_reviews);
        ?>
        <div class="container-fluid pt-2 mt-3 pb-2 bg-light">   
            <div class="owl-carousel tour-review-slider">
                <?php foreach($review_ids_array as $image_id):
                    if (!empty($image_id)) :
                        $full_image_url = wp_get_attachment_image_url($image_id, 'full');
                        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                        if ($full_image_url) :
                ?>
                    <div class="gallery-item" style="height: 300px;">
                        <a href="<?php echo esc_url($full_image_url); ?>" class="gallery-lightbox">
                            <?php echo wp_get_attachment_image($image_id, 'large', false, array(
                                'class' => 'img-fluid rounded box-shadow',
                                'style' => 'width: 100%; height: 100%; object-fit: cover;'
                            )); ?>
                        </a>
                    </div>
                    <?php 
                    endif;
                endif;
            endforeach; ?>
            </div>

            <script>
                jQuery(document).ready(function($){
                    $('.tour-review-slider').owlCarousel({
                    loop: true,
                        margin: 50,
                        nav: true,
                        dots: true,
                        autoplay: false,
                        autoplayTimeout: 3000,
                        autoplayHoverPause: true,
                        stagePadding: 50,
                        autoWidth:true,
                        center: true,
                        navText: [
                            "<i class='fa fa-chevron-left'></i>",
                            "<i class='fa fa-chevron-right'></i>"
                        ],
                        responsive:{
                            0:{
                                items:1
                            },
                            768:{
                                items:2
                            },
                            992:{
                                items:3
                            }
                        }
                    });
                });
            </script>
        </div>
        <?php endif; ?>
    </div>
</div>
<!-- Reviews Tab End -->