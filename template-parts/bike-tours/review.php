<div class="tour-reviews mt-4">
    <?php if (comments_open() || get_comments_number()) : ?>
        <?php comments_template(); ?>
    <?php else : ?>
        <div class="alert alert-info">
            <?php esc_html_e('No reviews yet. Be the first to review this tour!', 'bike-theme'); ?>
        </div>
    <?php endif; ?>
</div>