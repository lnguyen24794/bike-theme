<?php
// Cố lấy từ cả option mới và cũ để đảm bảo tương thích
$tour_gallery = bike_theme_get_option('tour_gallery', array());
if (count($tour_gallery) > 0) :
    ?>

<div class="container-fluid mt-5 py-5 bg-gray swiper-container">
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php foreach($tour_gallery as $index => $gallery_item):
                    $image_url = !empty($gallery_item['image_url']) ? $gallery_item['image_url'] : 'large';
                    if (!empty($image_url)) :
                        ?>
                    <div class="swiper-slide">
                         <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($gallery_item['title']); ?>">
                    </div>
                <?php endif; endforeach; ?>
        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>
</div>



<script>
    jQuery(document).ready(function($){
        const swiper = new Swiper(".swiper", {
            effect: "coverflow",
            rewind: true,
            freeMode: true,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            spaceBetween: 30,
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 3,
                    spaceBetween: 20
                }
            }
        });
    });
</script>
<?php endif; ?>