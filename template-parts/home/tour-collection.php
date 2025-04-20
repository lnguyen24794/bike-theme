<?php 
    // Get all destinations
    $tour_categories = get_terms(array(
        'taxonomy' => 'tour_category',
        'hide_empty' => false,
        'parent' => 0, // Get only top-level destinations
        'orderby' => 'name',
        'order' => 'ASC',
        'number' => 6 // Limit to 6 destinations
    ));
?>
 <?php if (!empty($tour_categories)) :
?>
<style>
    .tour-collection-item img {
        height: 200px;
        object-fit: cover;
    }
    .tour-collection-item .card-body {
       position:relative;
       overflow:hidden;
    }
    .tour-collection-item .card:hover img {
        transform: scale(1.2);
        transition: all 0.55s ease;
    }
    .tour-collection-item .card-title-wrapper {
        position:absolute;
        width:100%;
        height:100%;
        background:rgba(0,0,0,0.3);
        top: 0px;
        left: 0px;
    }
    .tour-collection-item .card-title-wrapper h5 {
        color: var(--primary-color);
        font-size:2rem;
        font-weight:bold;
        text-align:center;
    }
    
</style>
<div class="container-fluid pt-5 tour-collection">   
    <div class="row">
        <?php foreach($tour_categories as $key => $tour_category):
            if (!empty($tour_category)) :
                $image_id = get_term_meta($tour_category->term_id, 'tour_category_image', true);
                $image_url = wp_get_attachment_url($image_id);
                ?>
                <div class="col-md-4 tour-collection-item">
                    <a href="<?php echo get_term_link($tour_category); ?>">
                        <div class="card shadow">
                            <div class="card-body p-0 ">
                                <img src="<?php echo esc_url($image_url); ?>" class="card-img-top" alt="<?php echo esc_attr($tour_category->name); ?>">
                                <div class="card-title-wrapper d-flex align-items-center justify-content-center">
                                    <h5 class="card-title"><?php echo esc_html($tour_category->name); ?></h5>
                                </div>
                            </div>  
                        </div>
                    </a>
                </div>
                <?php 
            endif;
        endforeach; ?>
    </div>
</div>
<?php endif; ?>