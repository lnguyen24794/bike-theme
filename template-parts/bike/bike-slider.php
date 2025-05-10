 <?php if (!empty($bike_gallery)) :
    $gallery_ids_array = is_array($bike_gallery) ? $bike_gallery : explode(',', $bike_gallery);
?>
<div class="container-fluid pt-2 mt-3 pb-2 bg-light">   
    <div class="owl-carousel bike-slider">
        <?php foreach($gallery_ids_array as $image_id):
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
            $('.bike-slider').owlCarousel({
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