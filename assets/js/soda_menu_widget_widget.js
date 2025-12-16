(function($) {
    'use strict';

    /**
     * Menu Toggle Widget Handler
     */
    var MenuToggleHandler = function($scope, $) {
        var $toggle = $scope.find('.site-navigation-toggle');
        var $toggleHolder = $scope.find('.site-navigation-toggle-holder');
        var $menuContainer = $scope.find('.menu-container');
        var $horizontalMenu = $scope.find('.horizontal-menu-nav');
        var hoverOpenEnabled = $toggleHolder.data('hover-open') === 'yes';
        var hoverTimeout;
        
        // Get submenu indicator icons from data attributes
        var mobileSubmenuIcon = $menuContainer.data('submenu-icon') || '<i class="fas fa-chevron-down"></i>';
        var horizontalSubmenuIcon = $horizontalMenu.data('submenu-icon') || '<i class="fas fa-chevron-down"></i>';

        // Handle action button panel
        var $actionButton = $scope.find('.action-button[data-behavior="panel"]');
        var $actionPanel = $scope.find('.action-button-panel');
        
        if ($actionButton.length && $actionPanel.length) {
            // Toggle panel on button click
            $actionButton.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var isActive = $actionPanel.hasClass('active');
                
                // Close all other panels first
                $('.action-button-panel').removeClass('active');
                $('.action-button[data-behavior="panel"]').removeClass('active');
                
                // Toggle current panel
                if (!isActive) {
                    $actionPanel.addClass('active');
                    $(this).addClass('active');
                }
            });
            
            // Close panel when clicking outside
            $(document).on('click.actionPanel', function(e) {
                if (!$(e.target).closest('.action-button-wrapper').length) {
                    $actionPanel.removeClass('active');
                    $actionButton.removeClass('active');
                }
            });
            
            // Close panel on ESC key
            $(document).on('keydown.actionPanel', function(e) {
                if (e.key === 'Escape' || e.keyCode === 27) {
                    $actionPanel.removeClass('active');
                    $actionButton.removeClass('active');
                }
            });
        }

        // Add submenu arrows and classes for toggle menu
        if ($menuContainer.length) {
            $menuContainer.find('.menu li').each(function() {
                if ($(this).find('> .sub-menu').length) {
                    $(this).addClass('menu-item-has-children');
                    if (!$(this).find('> a .sub-arrow').length) {
                        $(this).find('> a').append('<span class="sub-arrow">' + mobileSubmenuIcon + '</span>');
                    }
                }
            });
        }

        // Add submenu arrows and classes for horizontal menu
        if ($horizontalMenu.length) {
            $horizontalMenu.find('.menu li').each(function() {
                if ($(this).find('> .sub-menu').length) {
                    $(this).addClass('menu-item-has-children');
                    if (!$(this).find('> a .sub-arrow').length) {
                        $(this).find('> a').append('<span class="sub-arrow">' + horizontalSubmenuIcon + '</span>');
                    }
                }
            });
            
            // Action button is now rendered directly from PHP
            // No need to convert the last menu item
        }
        
        if (!$toggle.length) {
            return;
        }

        // Hover functionality
        if (hoverOpenEnabled) {
            $toggleHolder.on('mouseenter', function() {
                clearTimeout(hoverTimeout);
                if (!$toggle.hasClass('toggled')) {
                    openMenu($toggle);
                }
            });

            $toggleHolder.on('mouseleave', function() {
                hoverTimeout = setTimeout(function() {
                    if ($toggle.hasClass('toggled')) {
                        closeMenu($toggle);
                    }
                }, 300);
            });

            $menuContainer.on('mouseenter', function() {
                clearTimeout(hoverTimeout);
            });

            $menuContainer.on('mouseleave', function() {
                hoverTimeout = setTimeout(function() {
                    if ($toggle.hasClass('toggled')) {
                        closeMenu($toggle);
                    }
                }, 300);
            });
        }

        // Toggle menu on click
        $toggle.on('click', function(e) {
            e.preventDefault();
            toggleMenu($(this));
        });

        // Toggle menu on Enter or Space key
        $toggle.on('keydown', function(e) {
            if (e.keyCode === 13 || e.keyCode === 32) { // Enter or Space
                e.preventDefault();
                toggleMenu($(this));
            }
        });

        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if (!$scope[0].contains(e.target) && $toggle.hasClass('toggled')) {
                closeMenu($toggle);
            }
        });

        // Prevent menu container clicks from closing
        $menuContainer.on('click', function(e) {
            e.stopPropagation();
        });

        // Handle submenu toggle
        $menuContainer.find('.menu-item-has-children > a').on('click', function(e) {
            var $link = $(this);
            var $menuItem = $link.parent();
            
            // Check if click was on arrow
            if ($(e.target).closest('.sub-arrow').length) {
                e.preventDefault();
                $menuItem.toggleClass('submenu-open');
                return false;
            }
            
            // If link is just #, prevent default and toggle submenu
            if ($link.attr('href') === '#' || $link.attr('href') === '') {
                e.preventDefault();
                $menuItem.toggleClass('submenu-open');
                return false;
            }
        });

        // Function to open menu
        function openMenu($element) {
            $element.addClass('toggled');
            $element.attr('aria-expanded', 'true');
        }

        // Function to close menu
        function closeMenu($element) {
            $element.removeClass('toggled');
            $element.attr('aria-expanded', 'false');
            // Close all submenus
            $menuContainer.find('.menu-item-has-children').removeClass('submenu-open');
        }

        // Function to toggle menu
        function toggleMenu($element) {
            var isToggled = $element.hasClass('toggled');
            
            if (isToggled) {
                closeMenu($element);
                
                // Trigger custom event for menu close
                $(document).trigger('menuToggleClose');
            } else {
                openMenu($element);
                
                // Trigger custom event for menu open
                $(document).trigger('menuToggleOpen');
            }
        }
    };

    // Initialize widget on Elementor frontend
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/menu_toggle_v2.default', MenuToggleHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/menu_toggle_v2.default', ScrollToggleHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/menu_toggle_v2.default', StickyMenuHandler);
    });

    /**
     * Sticky Menu Handler for horizontal menu
     */
    var StickyMenuHandler = function($scope, $) {
        var $widget = $scope;
        var $container = $widget.find('.menu-widget-container');
        var stickyOffset = $container.data('sticky-offset') || 100;
        var isSticky = false;

        // Check if sticky is enabled
        if (!stickyOffset || stickyOffset === 0) {
            return;
        }

        // Handle scroll events
        $(window).on('scroll', function() {
            var scrollTop = $(window).scrollTop();
            
            if (scrollTop > stickyOffset && !isSticky) {
                isSticky = true;
                $container.addClass('sticky');
            } else if (scrollTop <= stickyOffset && isSticky) {
                isSticky = false;
                $container.removeClass('sticky');
            }
        });

        // Trigger initial check
        $(window).trigger('scroll');
    };

    /**
     * Scroll Toggle Handler for toggle-on-scroll menu type
     */
    var ScrollToggleHandler = function($scope, $) {
        var $widget = $scope;
        var scrollOffset = $widget.data('scroll-offset') || 200;
        var isScrolled = false;

        // Check if this is a toggle-on-scroll widget
        var hasScrollToggle = $widget.find('.site-navigation-toggle-holder.scroll-hide').length > 0 ||
                              $widget.find('.horizontal-menu-nav.scroll-show').length > 0;
        
        if (!hasScrollToggle) {
            return;
        }


        // Handle scroll events
        $(window).on('scroll', function() {
            var scrollTop = $(window).scrollTop();
            
            if (scrollTop > scrollOffset && !isScrolled) {
                isScrolled = true;
                 
                   
                // Toggle classes for horizontal menu and toggle holder
                $widget.find('.site-navigation-toggle-holder').removeClass('scroll-hide').addClass('scroll-show');
                $widget.find('.horizontal-menu-nav').removeClass('scroll-show').addClass('scroll-hide');
                
               
                
                
            } else if (scrollTop <= scrollOffset && isScrolled) {
                isScrolled = false;
                
                // Toggle classes back
                $widget.find('.site-navigation-toggle-holder').removeClass('scroll-show').addClass('scroll-hide');
                $widget.find('.horizontal-menu-nav').removeClass('scroll-hide').addClass('scroll-show');
               
                // Close toggle menu if open when returning to top
                var $toggle = $widget.find('.site-navigation-toggle');
                if ($toggle.hasClass('toggled')) {
                    $toggle.removeClass('toggled');
                    $toggle.attr('aria-expanded', 'false');
                    $widget.find('.menu-item-has-children').removeClass('submenu-open');
                }
            }
        });

        // Trigger initial check
        $(window).trigger('scroll');
    };

})(jQuery);

