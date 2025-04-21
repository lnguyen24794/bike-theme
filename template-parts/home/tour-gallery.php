<?php 
    // Cố lấy từ cả option mới và cũ để đảm bảo tương thích
    $tour_gallery = bike_theme_get_option('tour_gallery', array());
    if (count($tour_gallery) > 0) :
?>

<div class="container-fluid pb-4">
    <!-- Grid Gallery Layout -->
    <div class="gallery-slide owl-carousel">
        <?php foreach($tour_gallery as $index => $gallery_item):
            $image_url = !empty($gallery_item['image_url']) ? $gallery_item['image_url'] : '';
            if (!empty($image_url)) :
        ?>
            <div class="gallery-item" style="height: 300px;">
                <a href="<?php echo esc_url($image_url); ?>" class="gallery-lightbox">
                    <?php echo wp_get_attachment_image($gallery_item['image_id'], 'full', false, array(
                        'class' => 'img-fluid rounded box-shadow',
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
            $('.gallery-slide').owlCarousel({
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