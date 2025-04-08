jQuery(document).ready(function($) {
    // Gallery image switching
    $('.thumbnail-item').on('click', function() {
        const newImageSrc = $(this).find('img').attr('src');
        $('.bike-main-image img').attr('src', newImageSrc);
        $('.thumbnail-item').removeClass('active');
        $(this).addClass('active');
    });

    // Initialize first thumbnail as active
    $('.thumbnail-item:first').addClass('active');

    // Image zoom effect
    $('.bike-main-image').on('mousemove', function(e) {
        const $img = $(this).find('img');
        const bounds = this.getBoundingClientRect();
        const x = e.clientX - bounds.left;
        const y = e.clientY - bounds.top;
        const xPercent = x / bounds.width;
        const yPercent = y / bounds.height;
        
        $img.css('transform-origin', `${xPercent * 100}% ${yPercent * 100}%`);
    }).on('mouseenter', function() {
        $(this).find('img').css('transform', 'scale(1.5)');
    }).on('mouseleave', function() {
        $(this).find('img').css('transform', 'none');
    });

    // Smooth scroll to tabs
    $('.nav-tabs .nav-link').on('click', function(e) {
        e.preventDefault();
        const target = $(this).attr('href');;
    });

    // Initialize 360 viewer
    let viewer360;
    $('#view360Modal').on('shown.bs.modal', function() {
        if (!viewer360) {
            // Initialize 360 viewer here
            // This is a placeholder - you'll need to implement actual 360 viewer
            $('#bike360Viewer').html('<div class="text-center p-5">360° viewer would be initialized here</div>');
        }
    });

    // Handle Buy Now button
    $('.btn-buy').on('click', function() {
        // Add to cart functionality
        // This is a placeholder - implement actual cart functionality
        alert('Product added to cart!');
    });

    // Handle Contact button
    $('.btn-contact').on('click', function() {
        // Open contact form or chat
        // This is a placeholder - implement actual contact functionality
        alert('Opening contact form...');
    });

    // Handle social share buttons
    $('.social-share a').on('click', function(e) {
        e.preventDefault();
        const platform = $(this).attr('class');
        const url = window.location.href;
        const title = $('.bike-title').text();
        
        let shareUrl;
        switch(platform) {
            case 'facebook':
                shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                break;
            case 'twitter':
                shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                break;
            case 'instagram':
                // Instagram doesn't have a direct share URL
                alert('Copy link to share on Instagram');
                return;
        }
        
        window.open(shareUrl, '_blank', 'width=600,height=400');
    });

    // Download specifications PDF
    $('.btn-download-specs').on('click', function(e) {
        e.preventDefault();
        // This is a placeholder - implement actual PDF download
        alert('Downloading specifications PDF...');
    });

    // Handle chat with expert
    $('.btn-chat').on('click', function() {
        // This is a placeholder - implement actual chat functionality
        alert('Opening chat with expert...');
    });
}); 