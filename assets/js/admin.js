/**
 * Admin JS for Bike Theme
 * Handles media uploads and slide management
 */
jQuery(document).ready(function($) {
    // ----- COMMON SETUP -----
    
    // Initialize color picker
    if ($.fn.wpColorPicker) {
        $('.bike-theme-color-field').wpColorPicker();
    }
    
    // ----- MEDIA UPLOADER HANDLERS -----
    
    /**
     * Generic function to create a media uploader for any element
     * @param {jQuery} button - The upload button element
     */
    function createMediaUploader(button) {
        // Get container and input elements
        var container = button.closest('.bike-media-upload');
        var idInput = container.find('.bike-media-id');
        var urlInput = container.find('.bike-media-url');
        var preview = container.find('.bike-media-preview');
        var removeButton = button.siblings('.bike-media-remove-btn, .bike-media-remove-button');
        
        // Find the right classes for remove button based on parent context
        if (removeButton.length === 0) {
            removeButton = container.find('.bike-media-remove-btn, .bike-media-remove-button');
        }
        
        // Create a unique media frame
        var mediaFrame = wp.media({
            title: 'Select Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });
        
        // Handle selection
        mediaFrame.on('select', function() {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            
            // Update hidden inputs
            idInput.val(attachment.id);
            urlInput.val(attachment.url);
            
            // Update preview
            var maxWidth = preview.hasClass('small') ? '150px' : '300px';
            preview.html('<img src="' + attachment.url + '" alt="" style="max-width: ' + maxWidth + ';">');
            
            // Show remove button
            removeButton.removeClass('hidden');
            
            // Close the frame - important!
            mediaFrame.close();
        });
        
        // Open the uploader
        mediaFrame.open();
        
        return mediaFrame;
    }
    
    /**
     * Handle image removal
     * @param {jQuery} button - The remove button element
     */
    function handleImageRemoval(button) {
        // Get container and input elements
        var container = button.closest('.bike-media-upload');
        var idInput = container.find('.bike-media-id');
        var urlInput = container.find('.bike-media-url');
        var preview = container.find('.bike-media-preview');
        
        // Clear the inputs
        idInput.val('');
        urlInput.val('');
        
        // Clear the preview
        preview.html('');
        
        // Hide the remove button
        button.addClass('hidden');
    }
    
    // Delegation for all media upload buttons
    $(document).on('click', '.bike-media-upload-btn, .bike-media-upload-button', function(e) {
        e.preventDefault();
        createMediaUploader($(this));
    });
    
    // Delegation for all media remove buttons
    $(document).on('click', '.bike-media-remove-btn, .bike-media-remove-button', function(e) {
        e.preventDefault();
        handleImageRemoval($(this));
    });
    
    // Initialize all existing images on page load
    $('.bike-media-upload').each(function() {
        var container = $(this);
        var uploadButton = container.find('.bike-media-upload-btn, .bike-media-upload-button');
        var removeButton = container.find('.bike-media-remove-btn, .bike-media-remove-button');
        
        // Ensure event handlers are properly initialized
        uploadButton.off('click').on('click', function(e) {
            e.preventDefault();
            createMediaUploader($(this));
        });
        
        removeButton.off('click').on('click', function(e) {
            e.preventDefault();
            handleImageRemoval($(this));
        });
    });
    
    // ----- SLIDE MANAGEMENT -----
    
    // Toggle slide content (for all slide types)
    $(document).on('click', '.slide-toggle', function(e) {
        e.preventDefault();
        $(this).closest('.bike-slide-item').find('.slide-content').slideToggle();
    });
    
    // Remove slide (for all slide types)
    $(document).on('click', '.slide-remove', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to remove this item?')) {
            var slideItem = $(this).closest('.bike-slide-item');
            slideItem.find('.slide-delete-field').val('yes');
            slideItem.slideUp();
        }
    });
    
    // ----- ABOUT SLIDES -----
    
    // Initialize About Slides section
    var aboutSlidesSection = {
        container: $('#bike-about-slides-container'),
        template: $('#about-slide-template'),
        addButton: $('#add-about-slide-button'),
        slideCount: 0,
        
        init: function() {
            // Set initial count
            this.slideCount = this.container.find('.bike-slide-item').length;
            
            // Add button handler
            this.addButton.on('click', this.addNewSlide.bind(this));
            
            // Make sortable
            this.initSortable();
        },
        
        addNewSlide: function(e) {
            if (e) e.preventDefault();
            
            // Get template
            var templateHtml = this.template.html();
            if (!templateHtml) {
                console.error('About slide template not found');
                return;
            }
            
            // Create new slide
            var newSlide = templateHtml
                .replace(/\{\{index\}\}/g, this.slideCount)
                .replace(/\{\{number\}\}/g, this.slideCount + 1);
            
            // Add to container
            this.container.append(newSlide);
            
            // Initialize media uploader for new slide
            var newSlideElem = this.container.find('.bike-slide-item').last();
            
            // Initialize upload and remove buttons in the new slide
            var uploadBtn = newSlideElem.find('.bike-media-upload-btn, .bike-media-upload-button');
            var removeBtn = newSlideElem.find('.bike-media-remove-btn, .bike-media-remove-button');
            
            uploadBtn.off('click').on('click', function(e) {
                e.preventDefault();
                createMediaUploader($(this));
            });
            
            removeBtn.off('click').on('click', function(e) {
                e.preventDefault();
                handleImageRemoval($(this));
            });
            
            // Increment counter
            this.slideCount++;
        },
        
        initSortable: function() {
            if ($.fn.sortable) {
                this.container.sortable({
                    handle: 'h3',
                    cursor: 'move',
                    update: function(event, ui) {
                        // Update slide numbers
                        $(this).find('.bike-slide-item').each(function(index) {
                            $(this).find('.slide-number').text(index + 1);
                        });
                    }
                });
            }
        }
    };
    
    // ----- HERO SLIDES -----
    
    // Initialize Hero Slides section
    var heroSlidesSection = {
        container: $('#bike-hero-slides-container'),
        template: $('#hero-slide-template'),
        addButton: $('#add-hero-slide-button'),
        slideCount: 0,
        
        init: function() {
            // Set initial count
            this.slideCount = this.container.find('.bike-slide-item').length;
            
            // Add button handler
            this.addButton.on('click', this.addNewSlide.bind(this));
            
            // Make sortable
            this.initSortable();
        },
        
        addNewSlide: function(e) {
            if (e) e.preventDefault();
            
            // Get template
            var templateHtml = this.template.html();
            if (!templateHtml) {
                console.error('Hero slide template not found');
                return;
            }
            
            // Create new slide
            var newSlide = templateHtml
                .replace(/\{\{index\}\}/g, this.slideCount)
                .replace(/\{\{number\}\}/g, this.slideCount + 1);
            
            // Add to container
            this.container.append(newSlide);
            
            // Initialize media uploader for new slide
            var newSlideElem = this.container.find('.bike-slide-item').last();
            
            // Initialize upload and remove buttons in the new slide
            var uploadBtn = newSlideElem.find('.bike-media-upload-btn, .bike-media-upload-button');
            var removeBtn = newSlideElem.find('.bike-media-remove-btn, .bike-media-remove-button');
            
            uploadBtn.off('click').on('click', function(e) {
                e.preventDefault();
                createMediaUploader($(this));
            });
            
            removeBtn.off('click').on('click', function(e) {
                e.preventDefault();
                handleImageRemoval($(this));
            });
            
            // Increment counter
            this.slideCount++;
        },
        
        initSortable: function() {
            if ($.fn.sortable) {
                this.container.sortable({
                    handle: 'h3',
                    cursor: 'move',
                    update: function(event, ui) {
                        // Update slide numbers
                        $(this).find('.bike-slide-item').each(function(index) {
                            $(this).find('.slide-number').text(index + 1);
                        });
                    }
                });
            }
        }
    };
    
    // ----- TOUR GALLERY SECTION -----
    
    var tourGallerySection = {
        container: $('#bike-tour-gallery-container'),
        uploadButton: $('#tour-gallery-upload-button'),
        
        init: function() {
            if (this.uploadButton.length) {
                this.uploadButton.on('click', this.openMediaUploader.bind(this));
            }
        },
        
        openMediaUploader: function(e) {
            e.preventDefault();
            
            var self = this;
            
            // Create the media uploader
            var galleryFrame = wp.media({
                title: bikeThemeAdmin.i18n.selectGalleryImages || 'Select Gallery Images',
                button: {
                    text: bikeThemeAdmin.i18n.addToGallery || 'Add to Gallery'
                },
                multiple: true,
                library: { type: 'image' }
            });
            
            // Handle selection
            galleryFrame.on('select', function() {
                var selection = galleryFrame.state().get('selection');
                var imageIndex = self.container.find('.gallery-item').length;
                
                selection.map(function(attachment) {
                    var attachmentData = attachment.toJSON();
                    // Add gallery item
                    self.addGalleryItem(attachmentData, imageIndex++);
                });
                
                // Close the frame
                galleryFrame.close();
            });
            
            // Open the uploader
            galleryFrame.open();
        },
        
        addGalleryItem: function(attachment, index) {
            // Implementation depends on your gallery structure
            // This is a basic example
            var template = 
                '<div class="gallery-item" data-id="' + attachment.id + '">' +
                    '<img src="' + attachment.url + '" alt="">' +
                    '<div class="gallery-item-actions">' +
                        '<a href="#" class="gallery-item-remove" title="Remove Image">' +
                            '<span class="dashicons dashicons-trash"></span>' +
                        '</a>' +
                    '</div>' +
                    '<input type="hidden" name="bike_theme_options[tour_gallery][' + index + '][image_id]" value="' + attachment.id + '">' +
                    '<input type="hidden" name="bike_theme_options[tour_gallery][' + index + '][image_url]" value="' + attachment.url + '">' +
                    '<input type="hidden" name="bike_theme_options[tour_gallery][' + index + '][delete]" class="gallery-delete-field" value="no">' +
                '</div>';
            
            this.container.append(template);
        }
    };
    
    // Initialize all sections if they exist
    if (aboutSlidesSection.container.length) aboutSlidesSection.init();
    if (heroSlidesSection.container.length) heroSlidesSection.init();
    if (tourGallerySection.container.length) tourGallerySection.init();
}); 