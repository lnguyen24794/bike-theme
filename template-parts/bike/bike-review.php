<!-- Reviews Tab -->
  <div class="w-100 py-3">
        <div class="wow fadeInUp" data-wow-delay="0.1s">
        <h3 class="border-bottom text-size-medium mb-0 text-primary text-uppercase"><?php esc_html_e('Reviews', 'bike-theme'); ?></h3>
    </div>
    <div class="pb-3">
            <div class="tour-contact mt-4">
            <?php if (!empty($bike_reviews)) : ?>
                <?php echo wp_kses_post($bike_reviews); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Reviews Tab End -->