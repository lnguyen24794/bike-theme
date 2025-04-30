jQuery(document).ready(function($) {
    // Change from form submit to button click
    $('.submit-button').on('click', function(e) {
        e.preventDefault();
        
        var $button = $(this);
        var $form = $button.closest('form');
        var $responseDiv = $('.booking-response');

        // Validate form
        if (!$form[0].checkValidity()) {
            $form[0].reportValidity();
            return;
        }

        // Disable button and show loading state
        $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' + bike_booking.submitting_text);

        // Get form data
        var formData = new FormData($form[0]);
        formData.append('action', 'bike_theme_process_booking');
        formData.append('csrf_token', bike_booking.csrf_token);

        // Send Ajax request
        $.ajax({
            url: bike_booking.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $responseDiv.html('<div class="alert alert-success">' + response.data.message + '</div>');
                    
                    // Reset form
                    $form[0].reset();
                    
                    // Update price calculation if exists
                    if (typeof updatePriceDisplay === 'function') {
                        updatePriceDisplay();
                    }

                    // Reset rider details
                    updateRiderDetails();

                    // Refresh CSRF token
                    bike_booking.csrf_token = response.data.new_csrf_token;

                    // Scroll to response message
                    $('html, body').animate({
                        scrollTop: $responseDiv.offset().top - 100
                    }, 500);
                } else {
                    // Show error message
                    var errorHtml = '<div class="alert alert-danger"><ul class="mb-0">';
                    if (Array.isArray(response.data)) {
                        response.data.forEach(function(error) {
                            errorHtml += '<li>' + error + '</li>';
                        });
                    } else {
                        errorHtml += '<li>' + response.data.message + '</li>';
                    }
                    errorHtml += '</ul></div>';
                    $responseDiv.html(errorHtml);

                    // Scroll to error message
                    $('html, body').animate({
                        scrollTop: $responseDiv.offset().top - 100
                    }, 500);
                }
            },
            error: function() {
                // Show error message
                $responseDiv.html('<div class="alert alert-danger">' + bike_booking.error_message + '</div>');
                
                // Scroll to error message
                $('html, body').animate({
                    scrollTop: $responseDiv.offset().top - 100
                }, 500);
            },
            complete: function() {
                // Re-enable button
                $button.prop('disabled', false).text(bike_booking.submit_text);
            }
        });
    });
}); 