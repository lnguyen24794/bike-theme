jQuery(document).ready(function($) {
    // Handle image upload
    $('.tour_category_tax_media_button').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var custom_uploader = wp.media({
            title: 'Choose Tour Category Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#tour_category_image').val(attachment.id);
            $('#tour_category_image-wrapper').html('<img src="' + attachment.url + '" style="max-width:100%; height:auto; margin:10px 0;">');
        }).open();
    });

    // Handle image removal
    $('.tour_category_tax_media_remove').click(function(e) {
        e.preventDefault();
        $('#tour_category_image').val('');
        $('#tour_category-image-wrapper').html('');
    });
}); 