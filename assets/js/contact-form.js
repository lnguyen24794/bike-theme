/**
 * Contact Form JavaScript
 * 
 * Handle contact form submission via AJAX
 */
(function($) {
    'use strict';

    // Contact form submission
    $(document).ready(function() {
        const contactForm = $('#contact-form');
        
        if (contactForm.length) {
            contactForm.on('submit', function(e) {
                e.preventDefault();
                
                const submitButton = contactForm.find('button[type="submit"]');
                const formData = new FormData(this);
                
                // Add action for WordPress AJAX
                formData.append('action', 'bike_theme_contact_form');
                formData.append('nonce', bikeTheme.nonce);
                
                // Disable button and change text
                submitButton.prop('disabled', true).text(bikeTheme.sending);
                
                // Clear previous messages
                $('.form-message').remove();
                
                $.ajax({
                    url: bikeTheme.ajaxurl,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            contactForm.before('<div class="alert alert-success form-message" role="alert">' + response.data.message + '</div>');
                            // Reset form
                            contactForm[0].reset();
                        } else {
                            // Show error message
                            contactForm.before('<div class="alert alert-danger form-message" role="alert">' + response.data.message + '</div>');
                        }
                    },
                    error: function() {
                        // Show general error message
                        contactForm.before('<div class="alert alert-danger form-message" role="alert">' + 
                            'Đã xảy ra lỗi khi xử lý yêu cầu. Vui lòng thử lại sau.' + '</div>');
                    },
                    complete: function() {
                        // Re-enable button and restore text
                        submitButton.prop('disabled', false).text(bikeTheme.send);
                        
                        // Scroll to message
                        $('html, body').animate({
                            scrollTop: contactForm.offset().top - 100
                        }, 500);
                    }
                });
            });
        }
    });
    
})(jQuery); 