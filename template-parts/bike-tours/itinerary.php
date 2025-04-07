<div class="tour-itinerary">
    <?php
    $itinerary_data = get_post_meta($post->ID, '_tour_itinerary_data', true);
    if (!empty($itinerary_data) && is_array($itinerary_data)) :
    ?>
        <div class="itinerary-timeline">
            <?php foreach ($itinerary_data as $day_index => $day) : ?>
                <div class="itinerary-day-container">
                    <div class="timeline-marker">
                        <div class="day-number"><?php echo esc_html($day_index + 1); ?></div>
                    </div>
                    
                    <div class="itinerary-day-content">
                        <h3 class="day-title">
                            <?php 
                            printf(
                                esc_html__('Day %d: %s', 'bike-theme'),
                                $day_index + 1,
                                esc_html($day['title'])
                            ); 
                            ?>
                        </h3>
                        
                        <div class="row">
                            <div class="col-lg-8 day-description content-formatted">
                                <?php echo wpautop(wp_kses_post($day['description'])); ?>
                            </div>

                            <div class="col-lg-4 border-left">
                                <div class="itinerary-day-details">
                                    <div class="details-grid">
                                        <?php if (!empty($day['accommodation'])) : ?>
                                            <div class="detail-item accommodation">
                                                <div class="detail-icon">
                                                    <i class="fas fa-hotel"></i>
                                                </div>
                                                <div class="detail-content">
                                                    <h5><?php esc_html_e('Accommodation', 'bike-theme'); ?></h5>
                                                    <p><?php echo esc_html($day['accommodation']); ?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($day['meals'])) : ?>
                                            <div class="detail-item meals">
                                                <div class="detail-icon">
                                                    <i class="fas fa-utensils"></i>
                                                </div>
                                                <div class="detail-content">
                                                    <h5><?php esc_html_e('Meals', 'bike-theme'); ?></h5>
                                                    <div class="meals-included">
                                                        <?php
                                                        $meals_included = array();
                                                        $meal_icons = array(
                                                            'breakfast' => '<i class="fas fa-coffee"></i>',
                                                            'lunch' => '<i class="fas fa-hamburger"></i>',
                                                            'dinner' => '<i class="fas fa-utensils"></i>'
                                                        );
                                                        
                                                        foreach ($day['meals'] as $meal => $included) {
                                                            if ($included) {
                                                                $icon = isset($meal_icons[$meal]) ? $meal_icons[$meal] : '';
                                                                $meals_included[] = sprintf(
                                                                    '<span class="meal-item">%s %s</span>',
                                                                    $icon,
                                                                    ucfirst($meal)
                                                                );
                                                            }
                                                        }
                                                        echo wp_kses_post(implode(' ', $meals_included));
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($day['distance'])) : ?>
                                            <div class="detail-item distance">
                                                <div class="detail-icon">
                                                    <i class="fas fa-road"></i>
                                                </div>
                                                <div class="detail-content">
                                                    <h5><?php esc_html_e('Distance', 'bike-theme'); ?></h5>
                                                    <p><?php printf(esc_html__('%g km', 'bike-theme'), $day['distance']); ?></p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!empty($day['additional_details'])) : ?>
                                        <div class="additional-details">
                                            <h5>
                                                <i class="fas fa-info-circle"></i>
                                                <?php esc_html_e('Additional Information', 'bike-theme'); ?>
                                            </h5>
                                            <ul class="details-list">
                                                <?php foreach ($day['additional_details'] as $detail) : ?>
                                                    <li><?php echo esc_html($detail); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-info">
            <?php esc_html_e('Detailed itinerary information is not available at this moment. Please contact us for more details.', 'bike-theme'); ?>
        </div>
    <?php endif; ?>
</div>