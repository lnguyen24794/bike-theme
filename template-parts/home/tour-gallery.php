<?php 
    // Cố lấy từ cả option mới và cũ để đảm bảo tương thích
    $tour_gallery = bike_theme_get_option('tour_gallery', array());
    
    // Nếu không có trong options mới, thử lấy từ options cũ
    if (empty($tour_gallery)) {
        $tour_gallery = get_option('bike_theme_tour_gallery', array());
    }
    
    if (!empty($tour_gallery)) :
?>
<style>
    .about-slider .owl-item {
        transform: scale(0.8);
        transition: all 0.55s ease;
    }
    .about-slider .owl-item.active.center {
        transform: scaleY(1.2);
    }
    .about-slider .owl-item.active:not(.center) {
        transform: scale(0.8);
    }
    
    /* Thêm CSS cho grid layout */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        grid-gap: 15px;
        margin-bottom: 20px;
    }
    
    .gallery-grid-item {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        height: 250px;
    }
    
    .gallery-grid-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .gallery-grid-item:hover img {
        transform: scale(1.05);
    }
    
    /* CSS cho nút All Photos */
    .all-photos-btn {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        border-radius: 30px;
        padding: 5px 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        z-index: 10;
        transition: all 0.55s;
        border: 1px solid white;
    }
    
    .all-photos-btn:hover {
        background-color: rgba(0, 0, 0, 0.9);
    }
    
    .photos-icon {
        display: inline-block;
        margin-right: 5px;
    }
    
    /* CSS cho modal */
    .photos-modal {
        display: none;
        position: fixed;
        top: 0px;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.9);
        z-index: 9999;
        overflow: hidden;
        padding: 30px;
    }
    
    .modal-close {
        position: absolute;
        top: 50px;
        right: 50px;
        color: white;
        font-size: 20px;
        cursor: pointer;
        z-index: 10000;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 0px 15px;
        border-radius: 10px;
    }
    .tour-gallery .item-gallery:nth-child(1) {
        height: 630px;
        padding-left: 0px;
        padding-bottom: 0px;
    }
    .tour-gallery .item-gallery {
        width: 33.3333%;
        float: left;
        height: 315px;
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
        padding-top: 5px;
        overflow: hidden;
    }
    .tour-gallery .item-gallery:nth-child(1), .tour-gallery .item-gallery:nth-child(2), .tour-gallery .item-gallery:nth-child(3) {
        padding-top: 0px;
    }
    .tour-gallery .item-gallery img {
        object-fit: cover;
        height: 100% !important;
        width: 100% !important;
    }

    .tour-gallery img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    .tour-gallery img:hover {
        transform: scale(1.1);
        transition: all 0.7s ease;
    }

    .style-masonry {
        margin-top: 40px;
        clear: both;
        display: inline-block;
        width: 100%;
        overflow: hidden;
        border-radius: 20px;
    }
</style>

<div class="container-fluid pb-4">
    <!-- Grid Gallery Layout -->
    <div class="position-relative style-masonry">
       <div class="tour-gallery ">
        <?php 
        $count = 0;
        $max_display = 5; // Số lượng ảnh hiển thị ban đầu
        
        foreach($tour_gallery as $index => $gallery_item):
            $image_url = !empty($gallery_item['image_url']) ? $gallery_item['image_url'] : '';
            if (!empty($image_url)) {
                $count++;
                
                if ($count <= $max_display) :
        ?>
            <a href="<?php echo esc_url($image_url); ?>" class="gallery-lightbox item-gallery">
                <?php 
                echo wp_get_attachment_image($gallery_item['image_id'], 'large', false, array(
                    'class' => 'img-fluid',
                    'alt' => __('Tour Gallery Image', 'bike-theme'),
                )); 
                ?>
            </a>
        <?php 
                endif;
            }
        endforeach; 
        ?>

       </div>
        <!-- All Photos Button -->
        <button class="all-photos-btn" id="allPhotosBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="photos-icon" viewBox="0 0 16 16">
                <path d="M4 0h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zm0 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H4z"/>
                <path d="M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                <path d="M14 14H2v-3.828a.5.5 0 0 1 .5-.5h1.4l1.8-2.246a.5.5 0 0 1 .78 0L8.62 10l2.76-3.246a.5.5 0 0 1 .76-.054L14 9.672V14z"/>
            </svg>
            All photos
        </button>
    </div>
    
    <!-- Modal for Slider -->
    <div id="photosModal" class="photos-modal">
        <span class="modal-close" id="modalClose">&times;</span>
        
        <div class="owl-carousel about-slider relative">
            <?php foreach($tour_gallery as $index => $gallery_item):
                $image_url = !empty($gallery_item['image_url']) ? $gallery_item['image_url'] : '';
                if (!empty($image_url)) :
            ?>
                <div class="gallery-item" style="height: 85vh;">
                    <?php 
                    echo wp_get_attachment_image($gallery_item['image_id'], 'large', false, array(
                        'class' => 'img-fluid shadow rounded',
                        'alt' => __('Tour Gallery Image', 'bike-theme'),
                        'style' => 'width: 100%; height: 100%; object-fit: contain;'
                    )); 
                    ?>
                </div>
            <?php 
                endif;
            endforeach; ?>
        </div>
    </div>

    <script>
        jQuery(document).ready(function($){
            // Khởi tạo Owl Carousel khi modal hiển thị
            function initializeSlider() {
                $('.about-slider').owlCarousel({
                    loop: true,
                    margin: 20,
                    nav: true,
                    dots: true,
                    center: true,
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
                            items:1
                        },
                        992:{
                            items:1
                        }
                    }
                });
            }
            
            // Button click event to show modal
            $('#allPhotosBtn').on('click', function() {
                $('#photosModal').fadeIn();
                initializeSlider();
            });
            
            // Close modal
            $('#modalClose').on('click', function() {
                $('#photosModal').fadeOut();
            });
            
            // Close modal when clicking outside the slider
            $(document).on('click', function(e) {
                if($(e.target).is('#photosModal')) {
                    $('#photosModal').fadeOut();
                }
            });
        });
    </script>
</div>
<div style="clear: both;"></div>
<?php endif; ?>