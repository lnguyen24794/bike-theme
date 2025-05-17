<?php
/**
 * Handle contact form submissions
 *
 * @package Bike_Theme
 */

// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Process contact form submission
 */
function bike_theme_process_contact_form() {
    if (isset($_POST['email']) && isset($_POST['name']) && isset($_POST['subject']) && isset($_POST['message'])) {
        // Sanitize form data
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $subject = sanitize_text_field($_POST['subject']);
        $message = sanitize_textarea_field($_POST['message']);
        
        // Validate email
        if (!is_email($email)) {
            wp_send_json_error(array(
                'message' => __('Email is not valid, please check again.', 'bike-theme')
            ));
            return;
        }
        
        // Prepare email content
        $to = 'info@beebikehub.com';
        $email_subject = sprintf(__('[Contact Form] %s', 'bike-theme'), $subject);
        
        $email_message = sprintf(
            __('Bạn đã nhận được liên hệ mới từ website %s.', 'bike-theme'),
            get_bloginfo('name')
        ) . "\n\n";
        
        $email_message .= __('Chi tiết thông tin:', 'bike-theme') . "\n";
        $email_message .= __('Họ tên: ', 'bike-theme') . $name . "\n";
        $email_message .= __('Email: ', 'bike-theme') . $email . "\n";
        $email_message .= __('Tiêu đề: ', 'bike-theme') . $subject . "\n";
        $email_message .= __('Nội dung: ', 'bike-theme') . "\n" . $message . "\n";
        
        $headers = array(
            'From: ' . $name . ' <' . $email . '>',
            'Reply-To: ' . $email,
            'Content-Type: text/plain; charset=UTF-8',
        );
        
        // Send email
        $sent = wp_mail($to, $email_subject, $email_message, $headers);
        
        if ($sent) {
            wp_send_json_success(array(
                'message' => __('Thank you for contacting us. We will respond as soon as possible!', 'bike-theme')
            ));
        } else {
            wp_send_json_error(array(
                'message' => __('An error occurred while sending the email. Please try again later.', 'bike-theme')
            ));
        }
    } else {
        wp_send_json_error(array(
            'message' => __('Please fill in all the information.', 'bike-theme')
        ));
    }
    
    exit;
}
add_action('wp_ajax_bike_theme_contact_form', 'bike_theme_process_contact_form');
add_action('wp_ajax_nopriv_bike_theme_contact_form', 'bike_theme_process_contact_form');

/**
 * Enqueue contact form scripts
 */
function bike_theme_enqueue_contact_scripts() {
    if (is_page_template('page-contact.php')) {
        wp_enqueue_script(
            'bike-theme-contact',
            get_template_directory_uri() . '/assets/js/contact-form.js',
            array('jquery'),
            '1.0.0',
            true
        );
        
        wp_localize_script('bike-theme-contact', 'bikeTheme', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bike_theme_contact_nonce'),
            'sending' => __('Sending...', 'bike-theme'),
            'send' => __('Send Message', 'bike-theme')
        ));
    }
}
add_action('wp_enqueue_scripts', 'bike_theme_enqueue_contact_scripts');
