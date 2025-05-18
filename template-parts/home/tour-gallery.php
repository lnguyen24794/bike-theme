<?php
// Cố lấy từ cả option mới và cũ để đảm bảo tương thích
$tour_gallery = bike_theme_get_option('tour_gallery', array());
if (count($tour_gallery) > 0) :
    ?>

<div class="container-fluid mt-5 py-5 bg-gray swiper-container">
   <!-- Slider main container -->
    <div class="swiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <!-- Slides -->
            <?php foreach($tour_gallery as $index => $gallery_item):
                    $image_url = !empty($gallery_item['image_url']) ? $gallery_item['image_url'] : 'large';
                    if (!empty($image_url)) :
                        ?>
                    <div class="swiper-slide">
                         <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($gallery_item['title']); ?>">
                    </div>
                <?php endif; endforeach; ?>
        </div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>
</div>



<script>
    jQuery(document).ready(function($){
        var slidesPerView = 3;
        if (window.innerWidth < 768) {
            slidesPerView = 1;
        }
        const swiper = new Swiper(".swiper", {
            effect: "coverflow",
            rewind: true,
            slidesPerView: slidesPerView,
            freeMode: true,
            loop: true,
            spaceBetween: 30,
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    });
</script>
<?php endif; ?>