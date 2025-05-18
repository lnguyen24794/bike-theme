 <?php if (!empty($bike_gallery)) :
    $gallery_ids_array = is_array($bike_gallery) ? $bike_gallery : explode(',', $bike_gallery);
?>
<div class="container-fluid pt-2 mt-3 pb-2 bg-light">   

    <div class="swiper">
        <div class="swiper-wrapper">
            <?php foreach($gallery_ids_array as $index => $gallery_item):
                    $full_image_url = wp_get_attachment_image_url($gallery_item, 'full');
                    $image_alt = get_post_meta($gallery_item, '_wp_attachment_image_alt', true);
                    if (!empty($full_image_url)) :
                        ?>
                    <div class="swiper-slide">
                         <img src="<?php echo esc_url($full_image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    </div>
                <?php endif; endforeach; ?>
        </div>

        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>

    </div>
</div>

<script>
    jQuery(document).ready(function($){
        var swiper = new Swiper(".swiper", {
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