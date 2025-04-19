
 <?php 
    $about_slides = get_option('bike_theme_about_slides', array());
    if (!empty($about_slides)) :
?>
<div class="container-fluid pt-5 pb-4 ">   
    <div class="owl-carousel about-slider relative">
        <?php foreach($about_slides as $index => $slide):
           $image_url = !empty($slide['image_url']) ? $slide['image_url'] : get_template_directory_uri() . '/assets/images/bikes/about-' . ($index + 1) . '.jpg';
            if (!empty($image_url)) :
        ?>
            <div class="gallery-item " style="height: 300px;">
                <a href="<?php echo esc_url($image_url); ?>" class="gallery-lightbox">
                    <?php echo wp_get_attachment_image($slide['image_id'], 'large', false, array(
                        'class' => 'img-fluid shadow rounded',
                        'alt' => $slide['image_alt'] ?? '',
                        'style' => 'width: 100%; height: 100%; object-fit: cover;'
                    )); ?>
                </a>
            </div>
        <?php 
            endif;
        endforeach; ?>
    </div>

    <script>
        jQuery(document).ready(function($){
            $('.about-slider').owlCarousel({
                loop: true,
                margin: 20,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                navText: [
                    "<i class='fa fa-chevron-left'></i>",
                    "<i class='fa fa-chevron-right'></i>"
                ],
                responsive:{
                    0:{
                        items:1
                    },
                    768:{
                        items:3
                    },
                    992:{
                        items:4
                    }
                }
            });
        });
    </script>
</div>
<?php endif; ?>