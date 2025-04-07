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

                            <div class="col-lg-4">
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

<style>
    .tour-itinerary {
        padding: 2rem 0;
    }

    .itinerary-timeline {
        position: relative;
    }

    .itinerary-day-container {
        position: relative;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .timeline-marker {
        position: absolute;
        left: -50px;
        top: 0;
    }

    .day-number {
        width: 40px;
        height: 40px;
        background: #007bff;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .day-title {
        color: #333;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .content-formatted {
        line-height: 1.6;
        color: #444;
    }

    .content-formatted p {
        margin-bottom: 1rem;
    }

    .content-formatted img {
        max-width: 100%;
        height: auto;
        margin: 1rem 0;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .detail-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .detail-icon {
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .detail-icon i {
        color: #007bff;
        font-size: 1.2rem;
    }

    .detail-content h5 {
        margin: 0 0 0.5rem 0;
        color: #666;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-content p {
        margin: 0;
        color: #333;
        font-weight: 500;
    }

    .meals-included {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .meal-item {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #fff;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #666;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .additional-details {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e9ecef;
    }

    .additional-details h5 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #333;
        margin-bottom: 1rem;
    }

    .details-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .details-list li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.5rem;
        color: #666;
    }

    .details-list li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: #007bff;
    }

    @media (max-width: 768px) {
        .itinerary-timeline {
            padding-left: 30px;
        }

        .timeline-marker {
            left: -30px;
        }

        .day-number {
            width: 30px;
            height: 30px;
            font-size: 1rem;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }
    }
</style>