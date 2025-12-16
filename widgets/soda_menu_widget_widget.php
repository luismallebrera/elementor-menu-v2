<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Elementor_Menu_Toggle_Widget_V2 extends \Elementor\Widget_Base {

    public function get_name() {
        return 'menu_toggle_v2';
    }

    public function get_title() {
        return esc_html__('Soda Menu', 'elementor-menu-widget-v2');
    }

    public function get_icon() {
        return 'eicon-header';
    }

    public function get_categories() {
        return ['soda-addons'];
    }

    public function get_keywords() {
        return ['menu', 'navigation', 'toggle', 'hamburger'];
    }

    public function get_script_depends() {
        return ['elementor-menu-widget-v2'];
    }

    public function get_style_depends() {
        return ['elementor-menu-widget-v2'];
    }

    protected function register_controls() {
        
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_logo',
            [
                'label' => esc_html__('Show Logo', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('Hide', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'logo_image',
            [
                'label' => esc_html__('Logo Image', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'show_logo' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'logo_link',
            [
                'label' => esc_html__('Logo Link', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-menu-widget-v2'),
                'default' => [
                    'url' => home_url('/'),
                ],
                'condition' => [
                    'show_logo' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'enable_sticky_logo',
            [
                'label' => esc_html__('Enable Sticky Logo', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('No', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'show_logo' => 'yes',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sticky_logo_image',
            [
                'label' => esc_html__('Sticky Logo', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'show_logo' => 'yes',
                    'enable_sticky_logo' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'menu_open_text',
            [
                'label' => esc_html__('Open Text', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('MENU', 'elementor-menu-widget-v2'),
                'placeholder' => esc_html__('Type open text here', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_control(
            'menu_close_text',
            [
                'label' => esc_html__('Close Text', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('CERRAR', 'elementor-menu-widget-v2'),
                'placeholder' => esc_html__('Type close text here', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_control(
            'show_text',
            [
                'label' => esc_html__('Show Text', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('Hide', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_hamburger',
            [
                'label' => esc_html__('Show Hamburger Icon', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('Hide', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'menu_heading',
            [
                'label' => esc_html__('WordPress Menu', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $menus = wp_get_nav_menus();
        $menu_options = [];
        foreach ($menus as $menu) {
            $menu_options[$menu->term_id] = $menu->name;
        }

        $this->add_control(
            'menu_type',
            [
                'label' => esc_html__('Menu Type', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'toggle' => esc_html__('Toggle Menu (Vertical)', 'elementor-menu-widget-v2'),
                    'horizontal' => esc_html__('Horizontal Menu', 'elementor-menu-widget-v2'),
                    'toggle-on-scroll' => esc_html__('Toggle on Scroll', 'elementor-menu-widget-v2'),
                ],
                'default' => 'toggle',
            ]
        );

        $this->add_control(
            'menu_id',
            [
                'label' => esc_html__('Select Toggle Menu', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $menu_options,
                'default' => !empty($menu_options) ? array_key_first($menu_options) : '',
                'description' => esc_html__('Select a WordPress menu for toggle display', 'elementor-menu-widget-v2'),
                'condition' => [
                    'menu_type' => 'toggle',
                ],
            ]
        );

        $this->add_control(
            'horizontal_menu_id',
            [
                'label' => esc_html__('Select Horizontal Menu', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $menu_options,
                'default' => !empty($menu_options) ? array_key_first($menu_options) : '',
                'description' => esc_html__('Select a WordPress menu for horizontal display', 'elementor-menu-widget-v2'),
                'condition' => [
                    'menu_type' => ['horizontal', 'toggle-on-scroll'],
                ],
            ]
        );

        $this->add_control(
            'layout_type',
            [
                'label' => esc_html__('Layout', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'logo-left-nav-center-button-right' => esc_html__('Logo Left | Nav Center | Button Right', 'elementor-menu-widget-v2'),
                    'logo-left-nav-right-button-right' => esc_html__('Logo Left | Nav Right | Button Right', 'elementor-menu-widget-v2'),
                ],
                'default' => 'logo-left-nav-center-button-right',
                'condition' => [
                    'menu_type' => ['horizontal', 'toggle-on-scroll'],
                ],
            ]
        );

        $this->add_control(
            'scroll_offset',
            [
                'label' => esc_html__('Scroll Offset', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'description' => esc_html__('Scroll distance (in pixels) before switching to toggle menu', 'elementor-menu-widget-v2'),
                'condition' => [
                    'menu_type' => 'toggle-on-scroll',
                ],
            ]
        );

        $this->add_control(
            'enable_sticky_menu',
            [
                'label' => esc_html__('Enable Sticky on Scroll', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('No', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Add sticky class when scrolling down', 'elementor-menu-widget-v2'),
                'condition' => [
                    'menu_type' => 'horizontal',
                ],
            ]
        );

        $this->add_control(
            'sticky_scroll_offset',
            [
                'label' => esc_html__('Sticky Scroll Offset', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'description' => esc_html__('Scroll distance (in pixels) before adding sticky class', 'elementor-menu-widget-v2'),
                'condition' => [
                    'menu_type' => 'horizontal',
                    'enable_sticky_menu' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'enable_mobile_toggle',
            [
                'label' => esc_html__('Enable Mobile Toggle', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('No', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Show toggle menu instead of horizontal menu on mobile devices', 'elementor-menu-widget-v2'),
                'condition' => [
                    'menu_type' => ['horizontal', 'toggle-on-scroll'],
                ],
            ]
        );

        $this->add_responsive_control(
            'mobile_breakpoint',
            [
                'label' => esc_html__('Mobile Breakpoint', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 320,
                        'max' => 1920,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 768,
                ],
                'condition' => [
                    'menu_type' => ['horizontal', 'toggle-on-scroll'],
                    'enable_mobile_toggle' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Main Container Style Section
        $this->start_controls_section(
            'container_style_section',
            [
                'label' => esc_html__('Main Container', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'container_position',
            [
                'label' => esc_html__('Position', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'relative' => esc_html__('Relative', 'elementor-menu-widget-v2'),
                    'fixed' => esc_html__('Fixed', 'elementor-menu-widget-v2'),
                    'sticky' => esc_html__('Sticky', 'elementor-menu-widget-v2'),
                ],
                'default' => 'relative',
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'position: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_top',
            [
                'label' => esc_html__('Top', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'container_position' => ['fixed', 'sticky'],
                ],
            ]
        );

        $this->add_responsive_control(
            'container_left',
            [
                'label' => esc_html__('Left', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'container_position' => ['fixed', 'sticky'],
                ],
            ]
        );

        $this->add_control(
            'container_z_index',
            [
                'label' => esc_html__('Z-Index', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 999,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'z-index: {{VALUE}};',
                ],
                'condition' => [
                    'container_position' => ['fixed', 'sticky'],
                ],
            ]
        );

        $this->start_controls_tabs('tabs_container_style');

        // Normal State Tab
        $this->start_controls_tab(
            'tab_container_normal',
            [
                'label' => esc_html__('Normal', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_width',
            [
                'label' => esc_html__('Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_max_width',
            [
                'label' => esc_html__('Max Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_height',
            [
                'label' => esc_html__('Height', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_vertical_align',
            [
                'label' => esc_html__('Vertical Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_horizontal_align',
            [
                'label' => esc_html__('Horizontal Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'default' => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container',
            ]
        );

        $this->end_controls_tab();

        // Sticky State Tab
        $this->start_controls_tab(
            'tab_container_sticky',
            [
                'label' => esc_html__('Sticky', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_control(
            'container_background_sticky',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_width_sticky',
            [
                'label' => esc_html__('Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_max_width_sticky',
            [
                'label' => esc_html__('Max Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_height_sticky',
            [
                'label' => esc_html__('Height', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_vertical_align_sticky',
            [
                'label' => esc_html__('Vertical Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_horizontal_align_sticky',
            [
                'label' => esc_html__('Horizontal Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_padding_sticky',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border_sticky',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container.sticky',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius_sticky',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow_sticky',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container.sticky',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'main_container_heading',
            [
                'label' => esc_html__('Inner Container', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('tabs_main_container_style');

        // Normal State Tab
        $this->start_controls_tab(
            'tab_main_container_normal',
            [
                'label' => esc_html__('Normal', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_responsive_control(
            'main_container_width',
            [
                'label' => esc_html__('Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-main-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'main_container_max_width',
            [
                'label' => esc_html__('Max Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1200,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-main-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'main_container_alignment',
            [
                'label' => esc_html__('Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'default' => 'space-between',
                'selectors' => [
                    '{{WRAPPER}} .menu-main-container' => 'justify-content: {{VALUE}}; display: flex; align-items: center;',
                ],
            ]
        );

        $this->add_responsive_control(
            'main_container_padding',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .menu-main-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'main_container_background',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-main-container' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'main_container_backdrop_blur',
            [
                'label' => esc_html__('Backdrop Blur', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-main-container' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'main_container_border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-main-container',
            ]
        );

        $this->add_responsive_control(
            'main_container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-main-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'main_container_box_shadow',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-main-container',
            ]
        );

        $this->end_controls_tab();

        // Sticky State Tab
        $this->start_controls_tab(
            'tab_main_container_sticky',
            [
                'label' => esc_html__('Sticky', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_responsive_control(
            'main_container_width_sticky',
            [
                'label' => esc_html__('Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'main_container_max_width_sticky',
            [
                'label' => esc_html__('Max Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'main_container_alignment_sticky',
            [
                'label' => esc_html__('Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container' => 'justify-content: {{VALUE}}; display: flex; align-items: center;',
                ],
            ]
        );

        $this->add_responsive_control(
            'main_container_padding_sticky',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'main_container_background_sticky',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container' => 'background-color: {{VALUE}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'main_container_backdrop_blur_sticky',
            [
                'label' => esc_html__('Backdrop Blur', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'main_container_border_sticky',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container',
            ]
        );

        $this->add_responsive_control(
            'main_container_border_radius_sticky',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'main_container_box_shadow_sticky',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container.sticky .menu-main-container',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Main Menu Style Section
        $this->start_controls_section(
            'horizontal_menu_section',
            [
                'label' => esc_html__('Main Menu', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu_type' => ['horizontal', 'toggle-on-scroll'],
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'horizontal_menu_typography',
                'selector' => '{{WRAPPER}} .horizontal-menu-nav .menu > li > a',
            ]
        );

        $this->add_control(
            'horizontal_submenu_indicator_icon',
            [
                'label' => esc_html__('Submenu Indicator', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-down',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'chevron-down',
                        'angle-down',
                        'caret-down',
                        'plus',
                    ],
                ],
                'label_block' => false,
                'skin' => 'inline',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'horizontal_submenu_indicator_size',
            [
                'label' => esc_html__('Submenu Indicator Size', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 30,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0.5,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 0.75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu .sub-arrow' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .horizontal-menu-nav .menu .sub-arrow i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .horizontal-menu-nav .menu .sub-arrow svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_horizontal_menu_item_style' );

        $this->start_controls_tab(
            'tab_horizontal_menu_item_normal',
            [
                'label' => esc_html__( 'Normal', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'horizontal_menu_item_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > a' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'horizontal_submenu_indicator_color_normal',
            [
                'label' => esc_html__('Submenu Indicator Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu .sub-arrow' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .horizontal-menu-nav .menu .sub-arrow i' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .horizontal-menu-nav .menu .sub-arrow svg' => 'fill: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'horizontal_nav_menu_divider_color_normal',
            [
                'label' => esc_html__( 'Divider Color', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}' => '--e-horizontal-nav-menu-divider-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_horizontal_menu_item_hover',
            [
                'label' => esc_html__( 'Hover', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'horizontal_menu_item_color_hover',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > a:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'horizontal_submenu_indicator_color_hover',
            [
                'label' => esc_html__('Submenu Indicator Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > a:hover .sub-arrow' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > a:hover .sub-arrow i' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > a:hover .sub-arrow svg' => 'fill: {{VALUE}} !important',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_horizontal_menu_item_sticky',
            [
                'label' => esc_html__( 'Sticky', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'horizontal_menu_item_color_sticky',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav .menu > li > a' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'horizontal_submenu_indicator_color_sticky',
            [
                'label' => esc_html__('Submenu Indicator Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav .menu .sub-arrow' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav .menu .sub-arrow i' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav .menu .sub-arrow svg' => 'fill: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_control(
            'horizontal_nav_menu_divider_color_sticky',
            [
                'label' => esc_html__( 'Divider Color', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky' => '--e-horizontal-nav-menu-divider-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'horizontal_menu_item_color_sticky_hover',
            [
                'label' => esc_html__('Text Color on Hover', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav .menu > li > a:hover' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'horizontal_submenu_indicator_color_sticky_hover',
            [
                'label' => esc_html__('Submenu Indicator Color on Hover', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav .menu > li > a:hover .sub-arrow' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav .menu > li > a:hover .sub-arrow i' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav .menu > li > a:hover .sub-arrow svg' => 'fill: {{VALUE}} !important',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'horizontal_nav_menu_divider',
            [
                'label' => esc_html__( 'Divider', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_off' => esc_html__( 'Off', 'elementor-menu-widget-v2' ),
                'label_on' => esc_html__( 'On', 'elementor-menu-widget-v2' ),
                'selectors' => [
                    '{{WRAPPER}}' => '--e-horizontal-nav-menu-divider-content: "";',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'horizontal_nav_menu_divider_style',
            [
                'label' => esc_html__( 'Style', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__( 'Solid', 'elementor-menu-widget-v2' ),
                    'double' => esc_html__( 'Double', 'elementor-menu-widget-v2' ),
                    'dotted' => esc_html__( 'Dotted', 'elementor-menu-widget-v2' ),
                    'dashed' => esc_html__( 'Dashed', 'elementor-menu-widget-v2' ),
                ],
                'default' => 'solid',
                'condition' => [
                    'horizontal_nav_menu_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--e-horizontal-nav-menu-divider-style: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'horizontal_nav_menu_divider_weight',
            [
                'label' => esc_html__( 'Width', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                    'em' => [
                        'max' => 2,
                    ],
                    'rem' => [
                        'max' => 2,
                    ],
                ],
                'condition' => [
                    'horizontal_nav_menu_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--e-horizontal-nav-menu-divider-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'horizontal_nav_menu_divider_height',
            [
                'label' => esc_html__( 'Height', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'em' => [
                        'max' => 10,
                    ],
                    'rem' => [
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'horizontal_nav_menu_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--e-horizontal-nav-menu-divider-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_nav_menu_divider_rotation',
            [
                'label' => esc_html__( 'Rotation', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'deg', 'turn' ],
                'range' => [
                    'deg' => [
                        'min' => 0,
                        'max' => 360,
                    ],
                    'turn' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'deg',
                    'size' => 0,
                ],
                'condition' => [
                    'horizontal_nav_menu_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}}' => '--e-horizontal-nav-menu-divider-rotation: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'hr_horizontal',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );

        $this->add_responsive_control(
            'horizontal_padding_horizontal_menu_item',
            [
                'label' => esc_html__( 'Horizontal Padding', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                    'rem' => [
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_padding_vertical_menu_item',
            [
                'label' => esc_html__( 'Vertical Padding', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                    'rem' => [
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_menu_space_between',
            [
                'label' => esc_html__( 'Space Between', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                    'em' => [
                        'max' => 10,
                    ],
                    'rem' => [
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav > .menu > li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_border_radius_menu_item',
            [
                'label' => esc_html__( 'Border Radius', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > a' => 'border-radius: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_menu_alignment',
            [
                'label' => esc_html__('Menu Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'horizontal_menu_nav_heading',
            [
                'label' => esc_html__('Menu Container', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('tabs_horizontal_menu_nav_style');

        // Normal State Tab
        $this->start_controls_tab(
            'tab_horizontal_menu_nav_normal',
            [
                'label' => esc_html__('Normal', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_responsive_control(
            'horizontal_menu_nav_padding',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'horizontal_menu_nav_background',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'horizontal_menu_nav_backdrop_blur',
            [
                'label' => esc_html__('Backdrop Blur', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'horizontal_menu_nav_border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .horizontal-menu-nav',
            ]
        );

        $this->add_responsive_control(
            'horizontal_menu_nav_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'horizontal_menu_nav_box_shadow',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .horizontal-menu-nav',
            ]
        );

        $this->end_controls_tab();

        // Sticky State Tab
        $this->start_controls_tab(
            'tab_horizontal_menu_nav_sticky',
            [
                'label' => esc_html__('Sticky', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_responsive_control(
            'horizontal_menu_nav_padding_sticky',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'horizontal_menu_nav_background_sticky',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'horizontal_menu_nav_backdrop_blur_sticky',
            [
                'label' => esc_html__('Backdrop Blur', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'horizontal_menu_nav_border_sticky',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav',
            ]
        );

        $this->add_responsive_control(
            'horizontal_menu_nav_border_radius_sticky',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'horizontal_menu_nav_box_shadow_sticky',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container.sticky .horizontal-menu-nav',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Action Button Section
        $this->start_controls_section(
            'action_button_section',
            [
                'label' => esc_html__('Action Button', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'menu_type' => ['horizontal', 'toggle-on-scroll'],
                ],
            ]
        );

        $this->add_control(
            'enable_action_button',
            [
                'label' => esc_html__('Enable Action Button', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('No', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Add a separate action button with custom styling', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_control(
            'action_button_text',
            [
                'label' => esc_html__('Button Text', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Get Started', 'elementor-menu-widget-v2'),
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_link',
            [
                'label' => esc_html__('Link', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-menu-widget-v2'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_behavior',
            [
                'label' => esc_html__('Button Behavior', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'link' => esc_html__('Direct Link', 'elementor-menu-widget-v2'),
                    'panel' => esc_html__('Open Panel', 'elementor-menu-widget-v2'),
                ],
                'default' => 'link',
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'panel_item_text',
            [
                'label' => esc_html__('Text', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Item', 'elementor-menu-widget-v2'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'panel_item_link',
            [
                'label' => esc_html__('Link', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-menu-widget-v2'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_control(
            'action_button_panel_items',
            [
                'label' => esc_html__('Panel Items', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'panel_item_text' => esc_html__('Item 1', 'elementor-menu-widget-v2'),
                        'panel_item_link' => ['url' => '#'],
                    ],
                    [
                        'panel_item_text' => esc_html__('Item 2', 'elementor-menu-widget-v2'),
                        'panel_item_link' => ['url' => '#'],
                    ],
                ],
                'title_field' => '{{{ panel_item_text }}}',
                'condition' => [
                    'enable_action_button' => 'yes',
                    'action_button_behavior' => 'panel',
                ],
            ]
        );

        $this->add_control(
            'action_button_icon',
            [
                'label' => esc_html__('Icon', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'label_block' => false,
                'skin' => 'inline',
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_icon_position',
            [
                'label' => esc_html__('Icon Position', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'before' => esc_html__('Before', 'elementor-menu-widget-v2'),
                    'after' => esc_html__('After', 'elementor-menu-widget-v2'),
                ],
                'default' => 'before',
                'condition' => [
                    'enable_action_button' => 'yes',
                    'action_button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'action_button_icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .action-button-wrapper .action-button .action-button-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .action-button-wrapper .action-button .action-button-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                    'action_button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'action_button_typography',
                'selector' => '{{WRAPPER}} .action-button-wrapper .action-button',
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_action_button_style');

        $this->start_controls_tab(
            'tab_action_button_normal',
            [
                'label' => esc_html__('Normal', 'elementor-menu-widget-v2'),
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .action-button-wrapper .action-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .action-button-wrapper .action-button i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .action-button-wrapper .action-button svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_background_color',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .action-button-wrapper .action-button' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_action_button_hover',
            [
                'label' => esc_html__('Hover', 'elementor-menu-widget-v2'),
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .action-button-wrapper .action-button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .action-button-wrapper .action-button:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .action-button-wrapper .action-button:hover svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_background_color_hover',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .action-button-wrapper .action-button:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_action_button_sticky',
            [
                'label' => esc_html__('Sticky', 'elementor-menu-widget-v2'),
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_text_color_sticky',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .action-button-wrapper .action-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .menu-widget-container.sticky .action-button-wrapper .action-button i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .menu-widget-container.sticky .action-button-wrapper .action-button svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'action_button_background_color_sticky',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .action-button-wrapper .action-button' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'action_button_padding',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .action-button-wrapper .action-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'action_button_border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .action-button-wrapper .action-button',
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'action_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .action-button-wrapper .action-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'action_button_box_shadow',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .action-button-wrapper .action-button',
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'action_button_spacing',
            [
                'label' => esc_html__('Spacing Right', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .action-button-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'enable_action_button' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Action Button Panel Style Section
        $this->start_controls_section(
            'action_button_panel_section',
            [
                'label' => esc_html__('Action Button Panel', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_action_button' => 'yes',
                    'action_button_behavior' => 'panel',
                ],
            ]
        );

        $this->add_responsive_control(
            'panel_width',
            [
                'label' => esc_html__('Panel Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 500,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 250,
                ],
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'panel_top_distance',
            [
                'label' => esc_html__('Distance from Button', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel' => 'top: calc(100% + {{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'panel_background',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'panel_border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .action-button-panel',
            ]
        );

        $this->add_responsive_control(
            'panel_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'panel_box_shadow',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .action-button-panel',
            ]
        );

        $this->add_responsive_control(
            'panel_padding',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel-menu ul' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'panel_items_heading',
            [
                'label' => esc_html__('Panel Items', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'panel_item_typography',
                'selector' => '{{WRAPPER}} .action-button-panel-menu ul li a',
            ]
        );

        $this->start_controls_tabs('tabs_panel_item_style');

        $this->start_controls_tab(
            'tab_panel_item_normal',
            [
                'label' => esc_html__('Normal', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_control(
            'panel_item_text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel-menu ul li a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'panel_item_background',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel-menu ul li a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_panel_item_hover',
            [
                'label' => esc_html__('Hover', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_control(
            'panel_item_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel-menu ul li a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'panel_item_background_hover',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel-menu ul li a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'panel_item_padding',
            [
                'label' => esc_html__('Item Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel-menu ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'panel_item_spacing',
            [
                'label' => esc_html__('Space Between Items', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel-menu ul li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'panel_item_border',
                'label' => esc_html__('Item Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .action-button-panel-menu ul li a',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'panel_item_border_radius',
            [
                'label' => esc_html__('Item Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .action-button-panel-menu ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Logo Style Section
        $this->start_controls_section(
            'logo_style_section',
            [
                'label' => esc_html__('Logo', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_logo' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_alignment',
            [
                'label' => esc_html__('Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .menu-logo' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_logo_size_style');

        // Normal State Tab
        $this->start_controls_tab(
            'tab_logo_size_normal',
            [
                'label' => esc_html__('Normal', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => esc_html__('Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-logo img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_max_width',
            [
                'label' => esc_html__('Max Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Sticky State Tab
        $this->start_controls_tab(
            'tab_logo_size_sticky',
            [
                'label' => esc_html__('Sticky', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_responsive_control(
            'logo_width_sticky',
            [
                'label' => esc_html__('Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-logo img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_max_width_sticky',
            [
                'label' => esc_html__('Max Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->start_controls_tabs('tabs_logo_style');

        // Normal State Tab
        $this->start_controls_tab(
            'tab_logo_normal',
            [
                'label' => esc_html__('Normal', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_responsive_control(
            'logo_padding',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .menu-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'logo_background',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-logo' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'logo_backdrop_blur',
            [
                'label' => esc_html__('Backdrop Blur', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-logo' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'logo_border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-logo',
            ]
        );

        $this->add_responsive_control(
            'logo_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'logo_box_shadow',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-logo',
            ]
        );

        $this->end_controls_tab();

        // Sticky State Tab
        $this->start_controls_tab(
            'tab_logo_sticky',
            [
                'label' => esc_html__('Sticky', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_responsive_control(
            'logo_padding_sticky',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'logo_background_sticky',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-logo' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'logo_backdrop_blur_sticky',
            [
                'label' => esc_html__('Backdrop Blur', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-logo' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'logo_border_sticky',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container.sticky .menu-logo',
            ]
        );

        $this->add_responsive_control(
            'logo_border_radius_sticky',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-widget-container.sticky .menu-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'logo_box_shadow_sticky',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-widget-container.sticky .menu-logo',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Submenu/Dropdown Style Section
        $this->start_controls_section(
            'submenu_style_section',
            [
                'label' => esc_html__('Main Menu Dropdown', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'dropdown_description',
            [
                'raw' => esc_html__( 'On desktop (main menu), this affects the submenu dropdown. On mobile and toggle menu, this affects submenu items.', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $this->start_controls_tabs( 'tabs_dropdown_item_style' );

        $this->start_controls_tab(
            'tab_dropdown_item_normal',
            [
                'label' => esc_html__( 'Normal', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'submenu_text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu a' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_background_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dropdown_item_hover',
            [
                'label' => esc_html__( 'Hover', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'submenu_hover_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu a:hover,
                    {{WRAPPER}} .horizontal-menu-nav .sub-menu a:focus' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_background_hover_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu a:hover,
                    {{WRAPPER}} .horizontal-menu-nav .sub-menu a:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dropdown_item_active',
            [
                'label' => esc_html__( 'Active', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'submenu_active_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu li.current-menu-item > a' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'submenu_background_active_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu li.current-menu-item > a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'submenu_typography',
                'selector' => '{{WRAPPER}} .horizontal-menu-nav .sub-menu a',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_border',
                'selector' => '{{WRAPPER}} .horizontal-menu-nav .sub-menu',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'dropdown_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'dropdown_box_shadow',
                'selector' => '{{WRAPPER}} .horizontal-menu-nav .sub-menu',
            ]
        );

        $this->add_responsive_control(
            'submenu_padding_horizontal',
            [
                'label' => esc_html__( 'Horizontal Padding', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'vw' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'submenu_padding_vertical',
            [
                'label' => esc_html__( 'Vertical Padding', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                    'rem' => [
                        'max' => 5,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'submenu_padding_left',
            [
                'label' => esc_html__('Submenu Indent', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_dropdown_divider',
            [
                'label' => esc_html__( 'Divider', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_divider',
                'selector' => '{{WRAPPER}} .horizontal-menu-nav .sub-menu li:not(:last-child)',
                'exclude' => [ 'width' ],
                'fields_options' => [
                    'border' => [
                        'selectors' => [
                            '{{WRAPPER}} .horizontal-menu-nav .sub-menu li:not(:last-child)' => 'border-bottom-style: {{VALUE}};',
                        ],
                    ],
                    'color' => [
                        'selectors' => [
                            '{{WRAPPER}} .horizontal-menu-nav .sub-menu li:not(:last-child)' => 'border-bottom-color: {{VALUE}};',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'dropdown_divider_width',
            [
                'label' => esc_html__( 'Border Width', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                    'rem' => [
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .sub-menu li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'dropdown_divider_border!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'dropdown_top_distance',
            [
                'label' => esc_html__( 'Distance', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => -10,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => -10,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .horizontal-menu-nav .menu > li > .sub-menu' => 'margin-top: {{SIZE}}{{UNIT}} !important',
                ],
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // Mobile Menu Container Style Section
        $this->start_controls_section(
            'menu_container_section',
            [
                'label' => esc_html__('Mobile Menu Container', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'menu_type',
                            'operator' => '===',
                            'value' => 'toggle',
                        ],
                        [
                            'name' => 'menu_type',
                            'operator' => '===',
                            'value' => 'toggle-on-scroll',
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'menu_type',
                                    'operator' => '===',
                                    'value' => 'horizontal',
                                ],
                                [
                                    'name' => 'enable_mobile_toggle',
                                    'operator' => '===',
                                    'value' => 'yes',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_container_width',
            [
                'label' => esc_html__('Container Width', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 600,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_container_height',
            [
                'label' => esc_html__('Container Height', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_container_vertical_align',
            [
                'label' => esc_html__('Vertical Alignment', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'elementor-menu-widget-v2'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .menu-container' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_animation_type',
            [
                'label' => esc_html__('Background Animation', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'scale-top' => esc_html__('Scale from Top (Y)', 'elementor-menu-widget-v2'),
                    'scale-corner' => esc_html__('Scale from Corner (X & Y)', 'elementor-menu-widget-v2'),
                    'scale-right' => esc_html__('Scale from Right (X)', 'elementor-menu-widget-v2'),
                ],
                'default' => 'scale-top',
            ]
        );

        $this->add_control(
            'menu_container_background',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .menu-container:before' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'backdrop_filter_blur',
            [
                'label' => esc_html__('Backdrop Blur', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container:before' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'menu_container_before_box_shadow',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-container:before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_container_border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-container:before',
            ]
        );

        $this->add_responsive_control(
            'menu_container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-container:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_container_padding',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_container_top_offset',
            [
                'label' => esc_html__('Top Offset', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container' => 'top: calc(100% + {{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_container_right_offset',
            [
                'label' => esc_html__('Right Offset', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Mobile Menu Items Style Section
        $this->start_controls_section(
            'menu_items_section',
            [
                'label' => esc_html__('Mobile Menu', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'menu_type',
                            'operator' => '===',
                            'value' => 'toggle',
                        ],
                        [
                            'name' => 'menu_type',
                            'operator' => '===',
                            'value' => 'toggle-on-scroll',
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'menu_type',
                                    'operator' => '===',
                                    'value' => 'horizontal',
                                ],
                                [
                                    'name' => 'enable_mobile_toggle',
                                    'operator' => '===',
                                    'value' => 'yes',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'menu_item_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .menu-container .menu a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'menu_item_typography',
                'selector' => '{{WRAPPER}} .menu-container .menu a',
            ]
        );

        $this->add_control(
            'mobile_submenu_indicator_icon',
            [
                'label' => esc_html__('Submenu Indicator', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-down',
                    'library' => 'fa-solid',
                ],
                'recommended' => [
                    'fa-solid' => [
                        'chevron-down',
                        'angle-down',
                        'caret-down',
                        'plus',
                    ],
                ],
                'label_block' => false,
                'skin' => 'inline',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'mobile_submenu_indicator_color',
            [
                'label' => esc_html__('Submenu Indicator Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-container .menu .sub-arrow' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .menu-container .menu .sub-arrow i' => 'color: {{VALUE}} !important',
                    '{{WRAPPER}} .menu-container .menu .sub-arrow svg' => 'fill: {{VALUE}} !important',
                ],
            ]
        );

        $this->add_responsive_control(
            'mobile_submenu_indicator_size',
            [
                'label' => esc_html__('Submenu Indicator Size', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 30,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0.5,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'em',
                    'size' => 0.75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .menu .sub-arrow' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .menu-container .menu .sub-arrow i' => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .menu-container .menu .sub-arrow svg' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_item_spacing',
            [
                'label' => esc_html__('Item Spacing', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .menu li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'menu_item_hover_color',
            [
                'label' => esc_html__('Hover Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-container .menu a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'menu_item_padding',
            [
                'label' => esc_html__('Item Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .menu a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'menu_item_border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .menu-container .menu a',
            ]
        );

        $this->add_responsive_control(
            'menu_item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .menu a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Mobile Menu Dropdown Style Section
        $this->start_controls_section(
            'mobile_submenu_style_section',
            [
                'label' => esc_html__('Mobile Menu Dropdown', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'menu_type',
                            'operator' => '===',
                            'value' => 'toggle',
                        ],
                        [
                            'name' => 'menu_type',
                            'operator' => '===',
                            'value' => 'toggle-on-scroll',
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'menu_type',
                                    'operator' => '===',
                                    'value' => 'horizontal',
                                ],
                                [
                                    'name' => 'enable_mobile_toggle',
                                    'operator' => '===',
                                    'value' => 'yes',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_mobile_dropdown_item_style' );

        $this->start_controls_tab(
            'tab_mobile_dropdown_item_normal',
            [
                'label' => esc_html__( 'Normal', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'mobile_submenu_text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu a' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_submenu_background_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_mobile_dropdown_item_hover',
            [
                'label' => esc_html__( 'Hover', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'mobile_submenu_hover_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu a:hover,
                    {{WRAPPER}} .menu-container .sub-menu a:focus' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_submenu_background_hover_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu a:hover,
                    {{WRAPPER}} .menu-container .sub-menu a:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_mobile_dropdown_item_active',
            [
                'label' => esc_html__( 'Active', 'elementor-menu-widget-v2' ),
            ]
        );

        $this->add_control(
            'mobile_submenu_active_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu li.current-menu-item > a' => 'color: {{VALUE}}; fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'mobile_submenu_background_active_color',
            [
                'label' => esc_html__( 'Background Color', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu li.current-menu-item > a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'mobile_submenu_typography',
                'selector' => '{{WRAPPER}} .menu-container .sub-menu a',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mobile_dropdown_border',
                'selector' => '{{WRAPPER}} .menu-container .sub-menu',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mobile_dropdown_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .menu-container .sub-menu li:first-child a' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{RIGHT}}{{UNIT}};',
                    '{{WRAPPER}} .menu-container .sub-menu li:last-child a' => 'border-bottom-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'mobile_dropdown_box_shadow',
                'selector' => '{{WRAPPER}} .menu-container .sub-menu',
            ]
        );

        $this->add_responsive_control(
            'mobile_submenu_padding_horizontal',
            [
                'label' => esc_html__( 'Horizontal Padding', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'vw' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu a' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'mobile_submenu_padding_vertical',
            [
                'label' => esc_html__( 'Vertical Padding', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                    'rem' => [
                        'max' => 5,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu a' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'mobile_submenu_padding_left',
            [
                'label' => esc_html__('Submenu Indent', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu' => 'padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_mobile_dropdown_divider',
            [
                'label' => esc_html__( 'Divider', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'mobile_dropdown_divider',
                'selector' => '{{WRAPPER}} .menu-container .sub-menu li:not(:last-child)',
                'exclude' => [ 'width' ],
            ]
        );

        $this->add_control(
            'mobile_dropdown_divider_width',
            [
                'label' => esc_html__( 'Border Width', 'elementor-menu-widget-v2' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                    'em' => [
                        'max' => 5,
                    ],
                    'rem' => [
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-container .sub-menu li:not(:last-child)' => 'border-bottom-width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'mobile_dropdown_divider_border!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Toggle Button', 'elementor-menu-widget-v2'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'menu_type',
                            'operator' => '===',
                            'value' => 'toggle',
                        ],
                        [
                            'name' => 'menu_type',
                            'operator' => '===',
                            'value' => 'toggle-on-scroll',
                        ],
                        [
                            'relation' => 'and',
                            'terms' => [
                                [
                                    'name' => 'menu_type',
                                    'operator' => '===',
                                    'value' => 'horizontal',
                                ],
                                [
                                    'name' => 'enable_mobile_toggle',
                                    'operator' => '===',
                                    'value' => 'yes',
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'enable_hover_open',
            [
                'label' => esc_html__('Open on Hover', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-menu-widget-v2'),
                'label_off' => esc_html__('No', 'elementor-menu-widget-v2'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Open menu on hover instead of click', 'elementor-menu-widget-v2'),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .menu-text',
            ]
        );

        $this->add_control(
            'hamburger_color',
            [
                'label' => esc_html__('Hamburger Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hamburger .line' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'hamburger_size',
            [
                'label' => esc_html__('Hamburger Size', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 60,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hamburger' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'spacing',
            [
                'label' => esc_html__('Spacing Between Text and Icon', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .menu-text-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_heading',
            [
                'label' => esc_html__('Background & Border', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-navigation-toggle' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'toggle_backdrop_blur',
            [
                'label' => esc_html__('Backdrop Blur', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .site-navigation-toggle' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => esc_html__('Border', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .site-navigation-toggle',
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .site-navigation-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .site-navigation-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'toggle_box_shadow',
                'label' => esc_html__('Box Shadow', 'elementor-menu-widget-v2'),
                'selector' => '{{WRAPPER}} .site-navigation-toggle',
            ]
        );

        $this->add_control(
            'hover_heading',
            [
                'label' => esc_html__('Hover State', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'hover_background_color',
            [
                'label' => esc_html__('Hover Background Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-navigation-toggle:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_border_color',
            [
                'label' => esc_html__('Hover Border Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-navigation-toggle:hover' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_text_color',
            [
                'label' => esc_html__('Hover Text Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-navigation-toggle:hover .menu-text' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hover_hamburger_color',
            [
                'label' => esc_html__('Hover Hamburger Color', 'elementor-menu-widget-v2'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .site-navigation-toggle:hover .hamburger .line' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $show_text = $settings['show_text'] === 'yes';
        $show_hamburger = $settings['show_hamburger'] === 'yes';
        $show_logo = $settings['show_logo'] === 'yes';
        $menu_type = $settings['menu_type'];
        $container_position = !empty($settings['container_position']) ? $settings['container_position'] : 'relative';
        $position_class = 'position-' . esc_attr($container_position);
        $enable_mobile_toggle = isset($settings['enable_mobile_toggle']) && $settings['enable_mobile_toggle'] === 'yes';
        $mobile_breakpoint = !empty($settings['mobile_breakpoint']['size']) ? $settings['mobile_breakpoint']['size'] : 768;
        $scroll_offset = !empty($settings['scroll_offset']['size']) ? $settings['scroll_offset']['size'] : 200;
        $enable_sticky_menu = isset($settings['enable_sticky_menu']) && $settings['enable_sticky_menu'] === 'yes';
        $sticky_scroll_offset = !empty($settings['sticky_scroll_offset']['size']) ? $settings['sticky_scroll_offset']['size'] : 100;
        
        // Add inline style for custom breakpoint (horizontal with mobile toggle)
        if ($enable_mobile_toggle && $menu_type === 'horizontal') {
            $layout_type = !empty($settings['layout_type']) ? $settings['layout_type'] : 'logo-left-nav-center-button-right';
            echo '<style>
                @media (max-width: ' . esc_attr($mobile_breakpoint) . 'px) {
                    .elementor-element-' . $this->get_id() . ' .horizontal-menu-nav.hide-on-mobile {
                        display: none !important;
                    }
                    .elementor-element-' . $this->get_id() . ' .site-navigation-toggle-holder.show-on-mobile {
                        display: inline-block !important;
                    }
                    /* Mobile layout adjustments */
                    .elementor-element-' . $this->get_id() . ' .menu-main-container {
                        display: flex !important;
                        align-items: center !important;
                    }
                    .elementor-element-' . $this->get_id() . ' .menu-logo {
                        margin-right: auto !important;
                    }
                    .elementor-element-' . $this->get_id() . ' .action-button-wrapper {
                        margin-left: auto !important;
                    }
                    .elementor-element-' . $this->get_id() . ' .site-navigation-toggle-holder.show-on-mobile {
                        margin-left: 0 !important;
                    }
                }
                @media (min-width: ' . ($mobile_breakpoint + 1) . 'px) {
                    .elementor-element-' . $this->get_id() . ' .horizontal-menu-nav.hide-on-mobile {
                        display: flex !important;
                    }
                    .elementor-element-' . $this->get_id() . ' .site-navigation-toggle-holder.show-on-mobile {
                        display: none !important;
                    }
                }
            </style>';
        }
        
        // Data attributes for scroll offset
        $data_attrs = '';
        if ($menu_type === 'toggle-on-scroll') {
            $data_attrs = ' data-scroll-offset="' . esc_attr($scroll_offset) . '"';
        } elseif ($menu_type === 'horizontal' && $enable_sticky_menu) {
            $data_attrs = ' data-sticky-offset="' . esc_attr($sticky_scroll_offset) . '"';
        }
        
        // Menu type class
        $menu_type_class = 'menu-type-' . esc_attr($menu_type);
        
        // Layout class
        $layout_type = !empty($settings['layout_type']) ? $settings['layout_type'] : 'logo-left-nav-center-button-right';
        $layout_class = 'layout-' . esc_attr($layout_type);
        ?>
        <div class="menu-widget-container <?php echo esc_attr($position_class); ?> <?php echo esc_attr($menu_type_class); ?> <?php echo esc_attr($layout_class); ?>"<?php echo $data_attrs; ?>>
            <div class="menu-main-container">
                <?php if ($show_logo && !empty($settings['logo_image']['url'])) : 
                    $enable_sticky_logo = isset($settings['enable_sticky_logo']) && $settings['enable_sticky_logo'] === 'yes';
                    $has_sticky_logo = $enable_sticky_logo && !empty($settings['sticky_logo_image']['url']);
                ?>
                    <div class="menu-logo">
                        <?php 
                        // Normal logo
                        $logo_class = $has_sticky_logo ? 'logo-normal' : '';
                        $logo_html = '<img src="' . esc_url($settings['logo_image']['url']) . '" alt="Logo" class="' . esc_attr($logo_class) . '">';
                        
                        // Sticky logo
                        if ($has_sticky_logo) {
                            $logo_html .= '<img src="' . esc_url($settings['sticky_logo_image']['url']) . '" alt="Logo" class="logo-sticky">';
                        }
                    
                        if (!empty($settings['logo_link']['url'])) {
                            $this->add_link_attributes('logo_link', $settings['logo_link']);
                            $logo_html = '<a ' . $this->get_render_attribute_string('logo_link') . '>' . $logo_html . '</a>';
                        }
                        
                        echo $logo_html;
                        ?>
                </div>
            <?php endif; ?>
            
            <?php 
            $enable_mobile_toggle = isset($settings['enable_mobile_toggle']) && $settings['enable_mobile_toggle'] === 'yes';
            $mobile_breakpoint = !empty($settings['mobile_breakpoint']['size']) ? $settings['mobile_breakpoint']['size'] : 768;
            
            if (($menu_type === 'horizontal' || $menu_type === 'toggle-on-scroll') && !empty($settings['horizontal_menu_id'])) : 
                // Get submenu indicator icon for horizontal menu
                $submenu_icon = '';
                if (!empty($settings['horizontal_submenu_indicator_icon']['value'])) {
                    ob_start();
                    \Elementor\Icons_Manager::render_icon($settings['horizontal_submenu_indicator_icon'], ['aria-hidden' => 'true']);
                    $submenu_icon = ob_get_clean();
                }
                
                // Get mobile submenu indicator icon
                $mobile_submenu_icon = '';
                if (!empty($settings['mobile_submenu_indicator_icon']['value'])) {
                    ob_start();
                    \Elementor\Icons_Manager::render_icon($settings['mobile_submenu_indicator_icon'], ['aria-hidden' => 'true']);
                    $mobile_submenu_icon = ob_get_clean();
                }
                
                // Classes for horizontal menu
                $horizontal_classes = [];
                if ($menu_type === 'horizontal' && $enable_mobile_toggle) {
                    $horizontal_classes[] = 'hide-on-mobile';
                } elseif ($menu_type === 'toggle-on-scroll') {
                    $horizontal_classes[] = 'scroll-show';
                }
                
                // Check if action button is enabled
                $enable_action_button = isset($settings['enable_action_button']) && $settings['enable_action_button'] === 'yes';
                $action_button_data = $enable_action_button ? ' data-action-button="yes"' : '';
                
                // Add icon data if action button is enabled
                if ($enable_action_button && !empty($settings['action_button_icon']['value'])) {
                    $icon_data = htmlspecialchars(json_encode($settings['action_button_icon']), ENT_QUOTES, 'UTF-8');
                    $action_button_data .= ' data-action-icon="' . $icon_data . '"';
                    $action_button_data .= ' data-action-icon-position="' . esc_attr($settings['action_button_icon_position'] ?? 'before') . '"';
                }
            ?>
                <nav class="horizontal-menu-nav <?php echo implode(' ', $horizontal_classes); ?>" data-submenu-icon="<?php echo esc_attr($submenu_icon); ?>"<?php echo $action_button_data; ?>>
                    <?php
                    wp_nav_menu([
                        'menu' => $settings['horizontal_menu_id'],
                        'container' => false,
                        'menu_class' => 'menu',
                        'fallback_cb' => false,
                    ]);
                    ?>
                </nav>
                
                <?php 
                // Show toggle button for horizontal with mobile toggle OR toggle-on-scroll
                if (($menu_type === 'horizontal' && $enable_mobile_toggle) || $menu_type === 'toggle-on-scroll') : 
                    $enable_hover_open = isset($settings['enable_hover_open']) && $settings['enable_hover_open'] === 'yes';
                    
                    // Classes for toggle holder
                    $toggle_classes = [];
                    if ($menu_type === 'horizontal' && $enable_mobile_toggle) {
                        $toggle_classes[] = 'show-on-mobile';
                    } elseif ($menu_type === 'toggle-on-scroll') {
                        $toggle_classes[] = 'scroll-hide';
                    }
                ?>
                    <div class="site-navigation-toggle-holder <?php echo implode(' ', $toggle_classes); ?>" data-hover-open="<?php echo $enable_hover_open ? 'yes' : 'no'; ?>">
                        <div class="site-navigation-toggle menu-toggle" role="button" tabindex="0" aria-label="Menu" aria-controls="primary-menu" aria-expanded="false">
                            <?php if ($show_text) : ?>
                                <span class="menu-text-wrapper">
                                    <span class="menu-text menu-text-open"><?php echo esc_html($settings['menu_open_text']); ?></span>
                                    <span class="menu-text menu-text-close"><?php echo esc_html($settings['menu_close_text']); ?></span>
                                </span>
                            <?php endif; ?>
                            <?php if ($show_hamburger) : ?>
                                <div class="hamburger" id="hamburger-2">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="menu-container animation-<?php echo esc_attr($settings['background_animation_type']); ?>" data-submenu-icon="<?php echo esc_attr($mobile_submenu_icon); ?>">
                            <?php
                            wp_nav_menu([
                                'menu' => $settings['horizontal_menu_id'],
                                'container' => 'nav',
                                'container_class' => 'vertical-menu',
                                'menu_class' => 'menu',
                                'fallback_cb' => false,
                            ]);
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php
                // Render action button as separate element after toggle
                if ($enable_action_button) :
                    $button_text = $settings['action_button_text'] ?? 'Get Started';
                    $button_behavior = $settings['action_button_behavior'] ?? 'link';
                    $button_link = ($button_behavior === 'link') ? ($settings['action_button_link']['url'] ?? '#') : '#';
                    $button_target = !empty($settings['action_button_link']['is_external']) ? ' target="_blank"' : '';
                    $button_nofollow = !empty($settings['action_button_link']['nofollow']) ? ' rel="nofollow"' : '';
                    $icon_position = $settings['action_button_icon_position'] ?? 'before';
                    $has_icon = !empty($settings['action_button_icon']['value']);
                    $data_behavior = $button_behavior === 'panel' ? ' data-behavior="panel"' : '';
                ?>
                    <div class="action-button-wrapper">
                        <a href="<?php echo esc_url($button_link); ?>" class="action-button"<?php echo $button_target . $button_nofollow . $data_behavior; ?>>
                            <?php if ($has_icon && $icon_position === 'before') : ?>
                                <span class="action-button-icon-before">
                                    <?php \Elementor\Icons_Manager::render_icon($settings['action_button_icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                            <?php endif; ?>
                            <span><?php echo esc_html($button_text); ?></span>
                            <?php if ($has_icon && $icon_position === 'after') : ?>
                                <span class="action-button-icon-after">
                                    <?php \Elementor\Icons_Manager::render_icon($settings['action_button_icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        
                        <?php if ($button_behavior === 'panel' && !empty($settings['action_button_panel_items'])) : ?>
                            <div class="action-button-panel">
                                <nav class="action-button-panel-menu">
                                    <ul>
                                        <?php foreach ($settings['action_button_panel_items'] as $item) : 
                                            $item_link = $item['panel_item_link']['url'] ?? '#';
                                            $item_target = !empty($item['panel_item_link']['is_external']) ? ' target="_blank"' : '';
                                            $item_nofollow = !empty($item['panel_item_link']['nofollow']) ? ' rel="nofollow"' : '';
                                        ?>
                                            <li>
                                                <a href="<?php echo esc_url($item_link); ?>"<?php echo $item_target . $item_nofollow; ?>>
                                                    <?php echo esc_html($item['panel_item_text']); ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </nav>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else : 
                $enable_hover_open = isset($settings['enable_hover_open']) && $settings['enable_hover_open'] === 'yes';
            ?>
                <div class="site-navigation-toggle-holder" data-hover-open="<?php echo $enable_hover_open ? 'yes' : 'no'; ?>">
                    <div class="site-navigation-toggle menu-toggle" role="button" tabindex="0" aria-label="Menu" aria-controls="primary-menu" aria-expanded="false">
                        <?php if ($show_text) : ?>
                            <span class="menu-text-wrapper">
                                <span class="menu-text menu-text-open"><?php echo esc_html($settings['menu_open_text']); ?></span>
                                <span class="menu-text menu-text-close"><?php echo esc_html($settings['menu_close_text']); ?></span>
                            </span>
                        <?php endif; ?>
                        <?php if ($show_hamburger) : ?>
                            <div class="hamburger" id="hamburger-2">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($settings['menu_id']) : 
                        // Get mobile submenu indicator icon
                        $mobile_submenu_icon = '';
                        if (!empty($settings['mobile_submenu_indicator_icon']['value'])) {
                            ob_start();
                            \Elementor\Icons_Manager::render_icon($settings['mobile_submenu_indicator_icon'], ['aria-hidden' => 'true']);
                            $mobile_submenu_icon = ob_get_clean();
                        }
                    ?>
                        <div class="menu-container animation-<?php echo esc_attr($settings['background_animation_type']); ?>" data-submenu-icon="<?php echo esc_attr($mobile_submenu_icon); ?>">
                            <?php
                            wp_nav_menu([
                                'menu' => $settings['menu_id'],
                                'container' => 'nav',
                                'container_class' => 'vertical-menu',
                                'menu_class' => 'menu',
                                'fallback_cb' => false,
                            ]);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var showText = settings.show_text === 'yes';
        var showHamburger = settings.show_hamburger === 'yes';
        var showLogo = settings.show_logo === 'yes';
        var menuType = settings.menu_type;
        #>
        <div class="menu-widget-container">
            <# if (showLogo && settings.logo_image.url) { 
                var enableStickyLogo = settings.enable_sticky_logo === 'yes';
                var hasStickyLogo = enableStickyLogo && settings.sticky_logo_image.url;
            #>
                <div class="menu-logo">
                    <# if (settings.logo_link.url) { #>
                        <a href="{{{ settings.logo_link.url }}}">
                            <img src="{{{ settings.logo_image.url }}}" alt="Logo" class="<# if (hasStickyLogo) { #>logo-normal<# } #>">
                            <# if (hasStickyLogo) { #>
                                <img src="{{{ settings.sticky_logo_image.url }}}" alt="Logo" class="logo-sticky">
                            <# } #>
                        </a>
                    <# } else { #>
                        <img src="{{{ settings.logo_image.url }}}" alt="Logo" class="<# if (hasStickyLogo) { #>logo-normal<# } #>">
                        <# if (hasStickyLogo) { #>
                            <img src="{{{ settings.sticky_logo_image.url }}}" alt="Logo" class="logo-sticky">
                        <# } #>
                    <# } #>
                </div>
            <# } #>
            
            <# if (menuType === 'horizontal' && settings.horizontal_menu_id) { #>
                <nav class="horizontal-menu-nav">
                    <p style="padding: 10px; text-align: center; color: #999;">
                        Horizontal menu preview available on frontend
                    </p>
                </nav>
            <# } else if (menuType === 'toggle-on-scroll' && settings.horizontal_menu_id) { #>
                <nav class="horizontal-menu-nav scroll-hide">
                    <p style="padding: 10px; text-align: center; color: #999;">
                        Horizontal menu (shows before scroll) - preview available on frontend
                    </p>
                </nav>
                <div class="site-navigation-toggle-holder scroll-show">
                    <div class="site-navigation-toggle menu-toggle" role="button" tabindex="0" aria-label="Menu" aria-controls="primary-menu" aria-expanded="false">
                        <# if (showText) { #>
                            <span class="menu-text-wrapper">
                                <span class="menu-text menu-text-open">{{{ settings.menu_open_text }}}</span>
                                <span class="menu-text menu-text-close">{{{ settings.menu_close_text }}}</span>
                            </span>
                        <# } #>
                        <# if (showHamburger) { #>
                            <div class="hamburger" id="hamburger-2">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        <# } #>
                    </div>
                    <div class="menu-container">
                        <p style="padding: 10px; text-align: center; color: #999;">
                            Toggle menu (shows after scroll) - preview available on frontend
                        </p>
                    </div>
                </div>
            <# } else { #>
                <div class="site-navigation-toggle-holder">
                    <div class="site-navigation-toggle menu-toggle" role="button" tabindex="0" aria-label="Menu" aria-controls="primary-menu" aria-expanded="false">
                        <# if (showText) { #>
                            <span class="menu-text-wrapper">
                                <span class="menu-text menu-text-open">{{{ settings.menu_open_text }}}</span>
                                <span class="menu-text menu-text-close">{{{ settings.menu_close_text }}}</span>
                            </span>
                        <# } #>
                        <# if (showHamburger) { #>
                            <div class="hamburger" id="hamburger-2">
                                <span class="line"></span>
                                <span class="line"></span>
                                <span class="line"></span>
                            </div>
                        <# } #>
                    </div>
                    <# if (settings.menu_id) { #>
                        <div class="menu-container animation-{{{ settings.background_animation_type }}}">
                            <p style="padding: 20px; text-align: center; color: #999;">
                                Toggle menu preview available on frontend
                            </p>
                        </div>
                    <# } #>
                </div>
            <# } #>
        </div>
        <?php
    }
}
