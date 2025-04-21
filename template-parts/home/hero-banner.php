<div class="container-fluid p-0 mb-5">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner" >
            <?php
            // Get all slides from options
            $slides = bike_theme_get_option('slides', array());

            $active_slides = 0;
            $found_active = false;

            foreach ($slides as $index => $slide) :
                // Skip inactive slides
                if (empty($slide['active'])) {
                    continue;
                }

                $active_slides++;

                // Set image URL (use default if empty)
                $image_url = !empty($slide['image_url']) ? $slide['image_url'] : get_template_directory_uri() . '/assets/images/bikes/hero-' . ($index % 3 + 1) . '.jpg';

                // Get text values with defaults
                $subtitle = !empty($slide['subtitle']) ? $slide['subtitle'] : '';
                $title = !empty($slide['title']) ? $slide['title'] : '';
                $btn1_text = !empty($slide['btn1_text']) ? $slide['btn1_text'] : '';
                $btn1_url = !empty($slide['btn1_url']) ? $slide['btn1_url'] : '';
                $btn2_text = !empty($slide['btn2_text']) ? $slide['btn2_text'] : '';
                $btn2_url = !empty($slide['btn2_url']) ? $slide['btn2_url'] : '';
                $slogan = !empty($slide['slogan']) ? $slide['slogan'] : '';

                // Set first active slide as active
                $is_active = false;
                if (!$found_active) {
                    $is_active = true;
                    $found_active = true;
                }
                ?>
                <div class="carousel-item <?php echo $is_active ? 'active' : ''; ?>" style="height: 100vh !important;">
                    <img class="w-100" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center" style="height: 100vh !important;">
                        <div class="p-3" style="max-width: 700px; padding-top: 200px !important;">
                            <?php if (!empty($title)) : ?>
                                <h1 class="hero-title text-white mb-4 animated slideInDown"><?php echo esc_html($title); ?></h1>
                            <?php endif; ?>
                            <?php if (!empty($subtitle)) : ?>
                                <p class=" text-white text-size-medium mb-3 animated slideInDown"><?php echo esc_html($subtitle); ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($btn1_text)) : ?>
                            <a href="<?php echo esc_url($btn1_url); ?>" class="btn btn-primary py-md-2 px-md-4 me-3 animated slideInLeft"><?php echo esc_html($btn1_text); ?></a>
                            <?php endif; ?>
                            <?php if (!empty($btn2_text)) : ?>
                            <a href="<?php echo esc_url($btn2_url); ?>" class="btn btn-light py-md-2 px-md-4 animated slideInRight"><?php echo esc_html($btn2_text); ?></a>
                            <?php endif; ?>
                          
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>
    </div>
</div>