<div class="tour-contact mt-4">
    <?php if (!empty($contact_info)) : ?>
        <?php echo wp_kses_post($contact_info); ?>
    <?php endif; ?>
</div>