/**
 * Magazine Grid Widget JavaScript
 * Handles grid initialization, responsive behavior, and interactions
 */

(function($) {
    'use strict';

    var SodaMagazineGrid = {

        /**
         * Initialize the widget
         */
        init: function() {
            this.bindEvents();
        },

        /**
         * Bind events
         */
        bindEvents: function() {
            $(window).on('elementor/frontend/init', this.onElementorInit.bind(this));
        },

        /**
         * Handle Elementor frontend initialization
         */
        onElementorInit: function() {
            var self = this;

            // Register widget handler
            elementorFrontend.hooks.addAction('frontend/element_ready/soda_magazine_grid.default', function($scope) {
                self.initWidget($scope);
            });
        },

        /**
         * Initialize individual widget instance
         */
        initWidget: function($scope) {
            var $grid = $scope.find('.post-magazine-grid');

            if (!$grid.length) {
                return;
            }

            // Set loading state
            $grid.attr('data-loading', 'true');

            // Initialize grid
            this.setupGrid($grid);

            // Handle responsive behavior
            this.handleResponsive($grid);

            // Setup image lazy loading
            this.setupLazyLoading($grid);

            // Remove loading state after animation
            setTimeout(function() {
                $grid.removeAttr('data-loading');
            }, 1000);
        },

        /**
         * Setup grid structure and behavior
         */
        setupGrid: function($grid) {
            var $items = $grid.find('.ue-grid-item');
            var hoverEffect = $grid.data('hover-effect');

            // Ensure images are loaded before displaying
            this.handleImageLoad($grid);

            // Add hover effect class if not already present
            if (hoverEffect && !$grid.hasClass('hover-' + hoverEffect)) {
                $grid.addClass('hover-' + hoverEffect);
            }

            // Setup item interactions
            $items.each(function() {
                var $item = $(this);
                
                // Add smooth transition to content
                $item.find('.ue-grid-item-content').css({
                    'transition': 'all 0.3s ease'
                });
            });
        },

        /**
         * Handle image loading
         */
        handleImageLoad: function($grid) {
            var $images = $grid.find('img');
            var totalImages = $images.length;
            var loadedImages = 0;

            if (totalImages === 0) {
                return;
            }

            $images.each(function() {
                var $img = $(this);

                // Check if image is already loaded (from cache)
                if (this.complete) {
                    loadedImages++;
                    checkAllLoaded();
                } else {
                    // Wait for image to load
                    $img.on('load', function() {
                        loadedImages++;
                        checkAllLoaded();
                    }).on('error', function() {
                        loadedImages++;
                        checkAllLoaded();
                        console.warn('Failed to load image:', this.src);
                    });
                }
            });

            function checkAllLoaded() {
                if (loadedImages === totalImages) {
                    $grid.addClass('images-loaded');
                }
            }
        },

        /**
         * Handle responsive behavior
         */
        handleResponsive: function($grid) {
            var self = this;
            var resizeTimer;

            function adjustGridOnResize() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    self.adjustGridForViewport($grid);
                }, 250);
            }

            // Initial adjustment
            this.adjustGridForViewport($grid);

            // Adjust on window resize
            $(window).on('resize', adjustGridOnResize);
        },

        /**
         * Adjust grid for current viewport
         */
        adjustGridForViewport: function($grid) {
            var windowWidth = $(window).width();
            var $items = $grid.find('.ue-grid-item');

            // On mobile (767px and below), force single column/row spans
            if (windowWidth <= 767) {
                $items.each(function() {
                    var $item = $(this);
                    // Store original spans as data attributes if not already stored
                    if (!$item.data('original-style')) {
                        $item.data('original-style', $item.attr('style') || '');
                    }
                    // Force single spans on mobile
                    $item.css({
                        'grid-column': 'span 1',
                        'grid-row': 'span 1'
                    });
                });
            } else {
                // Restore original spans on larger screens
                $items.each(function() {
                    var $item = $(this);
                    var originalStyle = $item.data('original-style');
                    if (originalStyle !== undefined) {
                        $item.attr('style', originalStyle);
                    }
                });
            }
        },

        /**
         * Setup lazy loading for images
         */
        setupLazyLoading: function($grid) {
            // Check if Intersection Observer is supported
            if (!('IntersectionObserver' in window)) {
                return;
            }

            var $images = $grid.find('img[loading="lazy"]');

            if ($images.length === 0) {
                return;
            }

            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        
                        // Image is in viewport, ensure it loads
                        if (img.loading) {
                            img.loading = 'eager';
                        }
                        
                        // Add loaded class for any additional effects
                        $(img).addClass('lazy-loaded');
                        
                        // Stop observing this image
                        observer.unobserve(img);
                    }
                });
            }, {
                rootMargin: '50px 0px', // Start loading 50px before entering viewport
                threshold: 0.01
            });

            // Observe all lazy images
            $images.each(function() {
                imageObserver.observe(this);
            });
        },

        /**
         * Utility: Debounce function
         */
        debounce: function(func, wait) {
            var timeout;
            return function() {
                var context = this;
                var args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    func.apply(context, args);
                }, wait);
            };
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        SodaMagazineGrid.init();
    });

    // Expose to global scope for potential external use
    window.SodaMagazineGrid = SodaMagazineGrid;

})(jQuery);
