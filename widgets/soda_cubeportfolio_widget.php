<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) exit;

class CubePortfolio_Widget extends Widget_Base {
            public function get_name() { return 'soda_cubeportfolio'; }
            public function get_title() { return esc_html__('Soda CubePortfolio', 'soda-elementor-addons'); }
            public function get_icon() { return 'eicon-gallery-grid'; }
            public function get_categories() { return ['soda-addons']; }
            public function get_style_depends() { 
                return ['cubeportfolio-css', 'cubeportfolio-filters-toggle-css'];
            }
            public function get_script_depends() { 
                return ['cubeportfolio-js']; 
            }            private function get_portfolio_posts() {
                $posts = get_posts([
                    'post_type' => 'portfolio',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                ]);
                
                $options = [];
                foreach ($posts as $post) {
                    $options[$post->ID] = $post->post_title;
                }
                return $options;
            }

            protected function register_controls() {
                // Layout Section
                $this->start_controls_section('section_layout', [
                    'label' => esc_html__('Layout', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]);
                $this->add_control('portfolio_layout', [
                    'label' => esc_html__('Layout', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'grid',
                    'options' => [
                        'grid' => esc_html__('Grid', 'cubeportfolio-elementor-widget'),
                        'masonry' => esc_html__('Masonry', 'cubeportfolio-elementor-widget'),
                        'landscape' => esc_html__('Landscape', 'cubeportfolio-elementor-widget'),
                        'mosaic' => esc_html__('Mosaic', 'cubeportfolio-elementor-widget'),
                    ],
                ]);
                // Breakpoints Configuration
                $this->add_control('breakpoints_heading', [
                    'label' => esc_html__('Breakpoints Configuration', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]);
                $this->add_control('widescreen_breakpoint', [
                    'label' => esc_html__('Widescreen Breakpoint (px)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 1920,
                    'min' => 1200,
                ]);
                $this->add_control('desktop_breakpoint', [
                    'label' => esc_html__('Desktop Breakpoint (px)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 1440,
                    'min' => 1200,
                ]);
                $this->add_control('laptop_breakpoint', [
                    'label' => esc_html__('Laptop Breakpoint (px)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 1200,
                    'min' => 1024,
                ]);
                $this->add_control('tablet_breakpoint', [
                    'label' => esc_html__('Tablet Breakpoint (px)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 1024,
                    'min' => 768,
                ]);
                $this->add_control('mobile_extra_breakpoint', [
                    'label' => esc_html__('Mobile Extra Breakpoint (px)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 880,
                    'min' => 480,
                ]);
                $this->add_control('mobile_breakpoint', [
                    'label' => esc_html__('Mobile Breakpoint (px)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 767,
                    'min' => 320,
                ]);
                
                // Columns Configuration
                $this->add_control('columns_heading', [
                    'label' => esc_html__('Columns Configuration', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]);
                $this->add_control('columns_widescreen', [
                    'label' => esc_html__('Columns Widescreen', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '5',
                    'options' => [
                        '1' => '1', '2' => '2', '3' => '3', '4' => '4',
                        '5' => '5', '6' => '6', '7' => '7', '8' => '8',
                    ],
                ]);
                $this->add_control('columns_desktop', [
                    'label' => esc_html__('Columns Desktop', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '4',
                    'options' => [
                        '1' => '1', '2' => '2', '3' => '3', '4' => '4',
                        '5' => '5', '6' => '6', '7' => '7', '8' => '8',
                    ],
                ]);
                $this->add_control('columns_laptop', [
                    'label' => esc_html__('Columns Laptop', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => [
                        '1' => '1', '2' => '2', '3' => '3', '4' => '4',
                        '5' => '5', '6' => '6', '7' => '7', '8' => '8',
                    ],
                ]);
                $this->add_control('columns_tablet', [
                    'label' => esc_html__('Columns Tablet', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => [
                        '1' => '1', '2' => '2', '3' => '3', '4' => '4',
                        '5' => '5', '6' => '6', '7' => '7', '8' => '8',
                    ],
                ]);
                $this->add_control('columns_mobile_extra', [
                    'label' => esc_html__('Columns Mobile Extra', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '2',
                    'options' => [
                        '1' => '1', '2' => '2', '3' => '3', '4' => '4',
                    ],
                ]);
                $this->add_control('columns_mobile', [
                    'label' => esc_html__('Columns Mobile', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '1',
                    'options' => [
                        '1' => '1', '2' => '2', '3' => '3', '4' => '4',
                    ],
                ]);
                $this->end_controls_section();

                // Mosaic pattern for user
                $this->start_controls_section('section_mosaic_pattern', [
                    'label' => esc_html__('Mosaic Pattern', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                    'condition' => ['portfolio_layout' => 'mosaic'],
                ]);
                $repeater = new \Elementor\Repeater();
                $repeater->add_control('cell_width', [
                    'label' => esc_html__('Cell Width', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 12,
                    'default' => 1,
                ]);
                $repeater->add_control('cell_height', [
                    'label' => esc_html__('Cell Height', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 12,
                    'default' => 1,
                ]);
                $this->add_control('mosaic_pattern', [
                    'label' => esc_html__('Mosaic Grid Cells', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::REPEATER,
                    'fields' => $repeater->get_controls(),
                    'default' => [
                        [ 'cell_width' => 4, 'cell_height' => 2 ],
                        [ 'cell_width' => 1, 'cell_height' => 1 ],
                        [ 'cell_width' => 1, 'cell_height' => 1 ],
                        [ 'cell_width' => 2, 'cell_height' => 1 ],
                    ],
                    'title_field' => 'Cell: {cell_width} x {cell_height}',
                    'condition' => ['portfolio_layout' => 'mosaic'],
                ]);
                $this->end_controls_section();

                // Query Section
                $this->start_controls_section('section_query', [
                    'label' => esc_html__('Query', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]);

                $this->add_control('posts_per_page', [
                    'label' => esc_html__('Posts Per Page', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'default' => 12,
                    'min' => 1,
                    'max' => 100,
                ]);

                $this->add_control('orderby', [
                    'label' => esc_html__('Order By', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'date',
                    'options' => [
                        'date' => esc_html__('Date', 'cubeportfolio-elementor-widget'),
                        'title' => esc_html__('Title', 'cubeportfolio-elementor-widget'),
                        'menu_order' => esc_html__('Menu Order', 'cubeportfolio-elementor-widget'),
                        'rand' => esc_html__('Random', 'cubeportfolio-elementor-widget'),
                        'ID' => esc_html__('ID', 'cubeportfolio-elementor-widget'),
                    ],
                ]);

                $this->add_control('order', [
                    'label' => esc_html__('Order', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'DESC',
                    'options' => [
                        'DESC' => esc_html__('Descending', 'cubeportfolio-elementor-widget'),
                        'ASC' => esc_html__('Ascending', 'cubeportfolio-elementor-widget'),
                    ],
                ]);

                $this->add_control('query_type', [
                    'label' => esc_html__('Query Type', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'all',
                    'options' => [
                        'all' => esc_html__('All Posts', 'cubeportfolio-elementor-widget'),
                        'categories' => esc_html__('By Categories', 'cubeportfolio-elementor-widget'),
                        'manual' => esc_html__('Manual Selection', 'cubeportfolio-elementor-widget'),
                    ],
                ]);

                $categories = get_terms([
                    'taxonomy' => 'portfolio_category',
                    'hide_empty' => false,
                ]);
                $category_options = [];
                if (!empty($categories) && !is_wp_error($categories)) {
                    foreach ($categories as $cat) {
                        $category_options[$cat->term_id] = $cat->name;
                    }
                }

                $this->add_control('selected_categories', [
                    'label' => esc_html__('Select Categories', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $category_options,
                    'condition' => ['query_type' => 'categories'],
                ]);

                $this->add_control('selected_posts', [
                    'label' => esc_html__('Select Posts', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $this->get_portfolio_posts(),
                    'condition' => ['query_type' => 'manual'],
                ]);

                $this->add_control('exclude_posts', [
                    'label' => esc_html__('Exclude Posts', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT2,
                    'multiple' => true,
                    'options' => $this->get_portfolio_posts(),
                    'condition' => ['query_type!' => 'manual'],
                ]);

                $this->end_controls_section();

                // Thumbnail Appearance Section
                $this->start_controls_section('section_thumbnail_appearance', [
                    'label' => esc_html__('Thumbnail Appearance', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]);
                $this->add_control('show_title', [
                    'label' => esc_html__('Show Title', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'cubeportfolio-elementor-widget'),
                    'label_off' => esc_html__('No', 'cubeportfolio-elementor-widget'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]);
                $this->add_control('show_subtitle', [
                    'label' => esc_html__('Show Sub Title', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'cubeportfolio-elementor-widget'),
                    'label_off' => esc_html__('No', 'cubeportfolio-elementor-widget'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                ]);
                $this->add_control('content_position', [
                    'label' => esc_html__( 'Content position', 'cubeportfolio-elementor-widget' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'content-under-img',
                    'options' => [
                        'content-under-img' => esc_html__( 'Content Under Image', 'cubeportfolio-elementor-widget' ),
                        'content-overlay'   => esc_html__( 'Content Overlay', 'cubeportfolio-elementor-widget' ),
                    ],
                ]);
                $this->add_control('overlay_caption_animation', [
                    'label' => esc_html__( 'Hover Effect', 'cubeportfolio-elementor-widget' ),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => '',
                    'options' => [
                        'pushTop' => esc_html__('Push Top', 'cubeportfolio-elementor-widget'),
                        'pushDown' => esc_html__('Push Down', 'cubeportfolio-elementor-widget'),
                        'revealBottom' => esc_html__('Reveal Bottom', 'cubeportfolio-elementor-widget'),
                        'revealTop' => esc_html__('Reveal Top', 'cubeportfolio-elementor-widget'),
                        'revealLeft' => esc_html__('Reveal Left', 'cubeportfolio-elementor-widget'),
                        'moveRight' => esc_html__('Move Right', 'cubeportfolio-elementor-widget'),
                        'overlayBottom' => esc_html__('Overlay Bottom', 'cubeportfolio-elementor-widget'),
                        'overlayBottomPush' => esc_html__('Overlay Push', 'cubeportfolio-elementor-widget'),
                        'overlayBottomReveal' => esc_html__('Overlay Reveal', 'cubeportfolio-elementor-widget'),
                        'overlayBottomAlong' => esc_html__('Overlay Along', 'cubeportfolio-elementor-widget'),
                        'overlayRightAlong' => esc_html__('Overlay Right', 'cubeportfolio-elementor-widget'),
                        'minimal' => esc_html__('Minimal', 'cubeportfolio-elementor-widget'),
                        'fadeIn' => esc_html__('Fade In', 'cubeportfolio-elementor-widget'),
                        'zoom' => esc_html__('Zoom', 'cubeportfolio-elementor-widget'),
                        'opacity' => esc_html__('Opacity', 'cubeportfolio-elementor-widget'),
                        '' => esc_html__('Default Style', 'cubeportfolio-elementor-widget'),
                    ],
                    'condition' => [ 'content_position' => 'content-overlay' ],
                ]);
                $this->add_control('under_image_caption_animation', [
                    'label' => esc_html__('Hover Effect', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'zoom',
                    'options' => [
                        'zoom' => esc_html__('Zoom', 'cubeportfolio-elementor-widget'),
                    ],
                    'condition' => [ 'content_position' => 'content-under-img' ],
                ]);
                $this->add_control('content_alignment', [
                    'label' => esc_html__('Content alignment', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'default' => 'center',
                    'options' => [
                        'left'      => ['title' => esc_html__('Left', 'cubeportfolio-elementor-widget'), 'icon' => 'eicon-text-align-left'],
                        'center'    => ['title' => esc_html__('Center', 'cubeportfolio-elementor-widget'), 'icon' => 'eicon-text-align-center'],
                        'right'     => ['title' => esc_html__('Right', 'cubeportfolio-elementor-widget'), 'icon' => 'eicon-text-align-right'],
                        'justified' => ['title' => esc_html__('Justified', 'cubeportfolio-elementor-widget'), 'icon' => 'eicon-text-align-justify'],
                    ],
                    'condition' => [ 'overlay_caption_animation!' => 'ribbon-effect' ],
                ]);
                $this->add_responsive_control('horizontal_space', [
                    'label' => esc_html__('Rows Gap', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => ['size' => 30],
                    'range' => ['px' => ['min' => 0, 'max' => 100]],
                ]);
                $this->add_responsive_control('vertical_space', [
                    'label' => esc_html__('Columns Gap', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => ['size' => 30],
                    'range' => ['px' => ['min' => 0, 'max' => 100]],
                ]);
                $this->add_control('show_filter_toggle', [
                    'label' => esc_html__('Show Toggle Filter Button', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Yes', 'cubeportfolio-elementor-widget'),
                    'label_off' => esc_html__('No', 'cubeportfolio-elementor-widget'),
                    'return_value' => 'yes',
                    'default' => '',
                ]);
                // Hidden control for toggle button base styles
                $this->add_control('toggle_button_base_styles', [
                    'type' => \Elementor\Controls_Manager::HIDDEN,
                    'default' => 'yes',
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn' => 'position: fixed; bottom: 10px; left: 50%; transform: translateX(-50%); z-index: 9999; border: none; cursor: pointer; transition: all 0.3s ease; min-width: 200px;',
                    ],
                    'condition' => ['show_filter_toggle' => 'yes'],
                ]);
                // Hidden control for filters wrapper base styles
                $this->add_control('filters_wrapper_base_styles', [
                    'type' => \Elementor\Controls_Manager::HIDDEN,
                    'default' => 'yes',
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filters-wrapper' => 'position: fixed; bottom: 5px; left: 50%; transform: translateX(-50%); z-index: 9998; overflow: hidden; max-height: 0; visibility: hidden; background-color: transparent;',
                        '{{WRAPPER}} .cbp-filters-wrapper::before' => 'content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: red;',
                        '{{WRAPPER}} .cbp-filters-wrapper .cbp-l-filters-button' => 'display: flex; flex-direction: column; gap: 5px;',
                        '{{WRAPPER}} .cbp-filters-wrapper.active' => 'visibility: visible;',
                    ],
                    'condition' => ['show_filter_toggle' => 'yes'],
                ]);
                $this->add_control('filter_toggle_text', [
                    'label' => esc_html__('Button Text', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__('Filtros', 'cubeportfolio-elementor-widget'),
                    'condition' => ['show_filter_toggle' => 'yes'],
                ]);
                $this->add_control('filter_toggle_text_close', [
                    'label' => esc_html__('Button Text (Close)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__('Cerrar', 'cubeportfolio-elementor-widget'),
                    'condition' => ['show_filter_toggle' => 'yes'],
                ]);
                $this->add_responsive_control('filters_panel_max_height', [
                    'label' => esc_html__('Panel Max Height', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', 'vh', '%'],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 1000,
                            'step' => 10,
                        ],
                        'vh' => [
                            'min' => 10,
                            'max' => 100,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 10,
                            'max' => 100,
                            'step' => 1,
                        ],
                    ],
                    'default' => [
                        'unit' => 'vh',
                        'size' => 100,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filters-wrapper' => 'max-height: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .cbp-filters-wrapper.active' => 'max-height: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => ['show_filter_toggle' => 'yes'],
                ]);
                $this->end_controls_section();

                // Animation Section
                $this->start_controls_section('layout_animation_section', [
                    'label' => esc_html__('Animation', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                ]);
                $this->add_control('filters_animation', [
                    'label' => esc_html__('Filters Animation', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SELECT,
                    'default' => 'fadeOut',
                    'options' => [
                        '3dflip' => esc_html__('3D Flip', 'cubeportfolio-elementor-widget'),
                        'bounceBottom' => esc_html__('Bounce Bottom', 'cubeportfolio-elementor-widget'),
                        'bounceLeft' => esc_html__('Bounce Left', 'cubeportfolio-elementor-widget'),
                        'bounceTop' => esc_html__('Bounce Top', 'cubeportfolio-elementor-widget'),
                        'fadeOut' => esc_html__('Fade Out', 'cubeportfolio-elementor-widget'),
                        'fadeOutTop' => esc_html__('Fade Out Top', 'cubeportfolio-elementor-widget'),
                        'flipOut' => esc_html__('Flip Out', 'cubeportfolio-elementor-widget'),
                        'quicksand' => esc_html__('Quicksand', 'cubeportfolio-elementor-widget'),
                        'scaleSides' => esc_html__('Scale Sides', 'cubeportfolio-elementor-widget'),
                        'skew' => esc_html__('Skew', 'cubeportfolio-elementor-widget'),
                        'slideDelay' => esc_html__('Slide Delay', 'cubeportfolio-elementor-widget'),
                        'slideLeft' => esc_html__('Slide Left', 'cubeportfolio-elementor-widget'),
                        'unfold' => esc_html__('Unfold', 'cubeportfolio-elementor-widget'),
                    ],
                ]);
                $this->end_controls_section();

                // Toggle Button Style Section
                $this->start_controls_section('section_toggle_button_style', [
                    'label' => esc_html__('Toggle Button - Style', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'condition' => ['show_filter_toggle' => 'yes'],
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => 'toggle_button_typography',
                        'selector' => '{{WRAPPER}} .cbp-filter-toggle-btn',
                    ]
                );
                $this->add_control('toggle_button_bg_color', [
                    'label' => esc_html__('Background Color', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#333',
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('toggle_button_text_color', [
                    'label' => esc_html__('Text Color', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->add_responsive_control('toggle_button_padding', [
                    'label' => esc_html__('Padding', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'default' => [
                        'top' => '12',
                        'right' => '24',
                        'bottom' => '12',
                        'left' => '24',
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]);
                $this->add_responsive_control('toggle_button_border_radius', [
                    'label' => esc_html__('Border Radius', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'default' => [
                        'top' => '4',
                        'right' => '4',
                        'bottom' => '4',
                        'left' => '4',
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]);
                $this->add_responsive_control('toggle_button_width', [
                    'label' => esc_html__('Width', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', '%', 'vw'],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 1000,
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
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn' => 'width: {{SIZE}}{{UNIT}}; min-width: auto;',
                    ],
                ]);
                $this->add_control('toggle_button_backdrop_blur', [
                    'label' => esc_html__('Backdrop Blur', 'cubeportfolio-elementor-widget'),
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
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                    ],
                ]);
                $this->add_control('toggle_button_hover_heading', [
                    'label' => esc_html__('Hover', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::HEADING,
                    'separator' => 'before',
                ]);
                $this->add_control('toggle_button_hover_bg_color', [
                    'label' => esc_html__('Background Color (Hover)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#555',
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn:hover' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('toggle_button_hover_text_color', [
                    'label' => esc_html__('Text Color (Hover)', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filter-toggle-btn:hover' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->end_controls_section();

                // Filters Panel Style Section
                $this->start_controls_section('section_filters_panel_style', [
                    'label' => esc_html__('Filters Panel - Style', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    'condition' => ['show_filter_toggle' => 'yes'],
                ]);
                $this->add_control('filters_panel_bg_color', [
                    'label' => esc_html__('Background Color', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#fff',
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filters-wrapper::before' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->add_responsive_control('filters_panel_padding', [
                    'label' => esc_html__('Padding', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%', 'em'],
                    'default' => [
                        'top' => '15',
                        'right' => '15',
                        'bottom' => '15',
                        'left' => '15',
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filters-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]);
                $this->add_responsive_control('filters_panel_border_radius', [
                    'label' => esc_html__('Border Radius', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'default' => [
                        'top' => '4',
                        'right' => '4',
                        'bottom' => '4',
                        'left' => '4',
                        'unit' => 'px',
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filters-wrapper::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]);
                $this->add_responsive_control('filters_panel_width', [
                    'label' => esc_html__('Width', 'cubeportfolio-elementor-widget'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'size_units' => ['px', '%', 'vw'],
                    'range' => [
                        'px' => [
                            'min' => 100,
                            'max' => 1000,
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
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filters-wrapper' => 'width: {{SIZE}}{{UNIT}}; min-width: auto;',
                    ],
                ]);
                $this->add_control('filters_panel_backdrop_blur', [
                    'label' => esc_html__('Backdrop Blur', 'cubeportfolio-elementor-widget'),
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
                        'size' => 0,
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-filters-wrapper::before' => 'backdrop-filter: blur({{SIZE}}{{UNIT}}); -webkit-backdrop-filter: blur({{SIZE}}{{UNIT}});',
                    ],
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Box_Shadow::get_type(),
                    [
                        'name' => 'filters_panel_box_shadow',
                        'label' => esc_html__('Box Shadow', 'cubeportfolio-elementor-widget'),
                        'selector' => '{{WRAPPER}} .cbp-filters-wrapper::before',
                    ]
                );
                $this->end_controls_section();

                // NUEVA SECCION: Estilos para filtro del menú
                $this->start_controls_section('section_filters_style', [
                    'label' => esc_html__('Filtros - Estilos', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => 'filters_typography',
                        'selector' => '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item',
                    ]
                );
                $this->add_control('filters_color', [
                    'label'     => esc_html__('Text Color', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('filters_bg_color', [
                    'label'     => esc_html__('Background Color', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Border::get_type(),
                    [
                        'name' => 'filters_border',
                        'selector' => '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item',
                    ]
                );
                $this->add_responsive_control('filters_padding', [
                    'label'     => esc_html__('Padding', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units'=> ['px', '%', 'em'],
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]);
                $this->add_control('filters_hover_color', [
                    'label'     => esc_html__('Color texto (Hover)', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item:hover' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('filters_hover_bg_color', [
                    'label'     => esc_html__('Fondo (Hover)', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item:hover' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('filters_active_color', [
                    'label'     => esc_html__('Color texto (Activo)', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item-active' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->add_control('filters_active_bg_color', [
                    'label'     => esc_html__('Fondo (Activo)', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-filters-button .cbp-filter-item-active' => 'background-color: {{VALUE}};',
                    ],
                ]);
                $this->end_controls_section();

                // Title Style Section
                $this->start_controls_section('section_title_style', [
                    'label' => esc_html__('Title Style', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => 'title_typography',
                        'selector' => '{{WRAPPER}} .cbp-l-grid-projects-title',
                    ]
                );
                $this->add_control('title_color', [
                    'label'     => esc_html__('Color', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-grid-projects-title' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .cbp-l-grid-projects-title a' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->end_controls_section();

                // Subtitle Style Section
                $this->start_controls_section('section_subtitle_style', [
                    'label' => esc_html__('Subtitle Style', 'cubeportfolio-elementor-widget'),
                    'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                ]);
                $this->add_group_control(
                    \Elementor\Group_Control_Typography::get_type(),
                    [
                        'name' => 'subtitle_typography',
                        'selector' => '{{WRAPPER}} .cbp-l-grid-projects-desc',
                    ]
                );
                $this->add_control('subtitle_color', [
                    'label'     => esc_html__('Color', 'cubeportfolio-elementor-widget'),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .cbp-l-grid-projects-desc' => 'color: {{VALUE}};',
                    ],
                ]);
                $this->end_controls_section();
            }

            protected function render() {
                try {
                    $settings = $this->get_settings_for_display();
                    $widget_id = 'cubeportfolio-' . $this->get_id();
                    
                    // Check if we're in Elementor editor
                    $is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();

                // Get Categories - with error handling
                $categories = [];
                if (taxonomy_exists('portfolio_category')) {
                    $categories = get_terms([
                        'taxonomy' => 'portfolio_category',
                        'hide_empty' => true,
                    ]);
                    if (is_wp_error($categories)) {
                        $categories = [];
                    }
                }
                
                // Add class if toggle is enabled
                $container_classes = ['cubeportfolio-widget-container'];
                if (!empty($settings['show_filter_toggle']) && $settings['show_filter_toggle'] === 'yes') {
                    $container_classes[] = 'has-filter-toggle';
                }
                
                echo '<div class="' . esc_attr(implode(' ', $container_classes)) . '">';
                
                // Botón toggle si está activado
                if (!empty($settings['show_filter_toggle']) && $settings['show_filter_toggle'] === 'yes') {
                    $toggle_text = !empty($settings['filter_toggle_text']) ? esc_html($settings['filter_toggle_text']) : esc_html__('Filtros', 'cubeportfolio-elementor-widget');
                    $toggle_text_close = !empty($settings['filter_toggle_text_close']) ? esc_html($settings['filter_toggle_text_close']) : esc_html__('Cerrar', 'cubeportfolio-elementor-widget');
                    echo '<button class="cbp-filter-toggle-btn" data-target="filters-' . esc_attr($widget_id) . '" data-text-open="' . esc_attr($toggle_text) . '" data-text-close="' . esc_attr($toggle_text_close) . '">' . $toggle_text . '</button>';
                }
                
                if (!empty($categories) && !is_wp_error($categories)) {
                    $wrapper_class = !empty($settings['show_filter_toggle']) && $settings['show_filter_toggle'] === 'yes' ? 'cbp-filters-wrapper' : '';
                    echo '<div id="filters-wrapper-' . esc_attr($widget_id) . '" class="' . esc_attr($wrapper_class) . '">';
                    echo '<div id="filters-' . esc_attr($widget_id) . '" class="cbp-l-filters-button">';
                    echo '<div data-filter="*" class="cbp-filter-item-active cbp-filter-item">' . esc_html__('All', 'cubeportfolio-elementor-widget') . '<div class="cbp-filter-counter"></div></div>';
                    foreach ($categories as $cat) {
                        echo '<div data-filter=".' . esc_attr($cat->slug) . '" class="cbp-filter-item">';
                        echo esc_html($cat->name) . '<div class="cbp-filter-counter"></div></div>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
                echo '<div id="' . esc_attr($widget_id) . '" class="cubeportfolio-elementor-widget">';

                // QUERY OBJECT FIX (Your fatal error)
                $args = [
                    'post_type' => 'portfolio',
                    'posts_per_page' => isset($settings['posts_per_page']) ? intval($settings['posts_per_page']) : 12,
                    'post_status' => 'publish',
                    'orderby' => isset($settings['orderby']) ? sanitize_text_field($settings['orderby']) : 'date',
                    'order' => isset($settings['order']) ? sanitize_text_field($settings['order']) : 'DESC',
                ];

                // Handle query type
                $query_type = isset($settings['query_type']) ? $settings['query_type'] : 'all';
                
                if ($query_type === 'categories' && !empty($settings['selected_categories'])) {
                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'portfolio_category',
                            'field' => 'term_id',
                            'terms' => $settings['selected_categories'],
                        ],
                    ];
                } elseif ($query_type === 'manual' && !empty($settings['selected_posts'])) {
                    $args['post__in'] = $settings['selected_posts'];
                    $args['orderby'] = 'post__in';
                }

                // Handle excluded posts
                if (!empty($settings['exclude_posts']) && $query_type !== 'manual') {
                    $args['post__not_in'] = $settings['exclude_posts'];
                }

                $query = new \WP_Query($args);

                // Build Mosaic cells (for both attributes and JS)
                $mosaic_cells = [];
                $max_width = 1;
                if ($settings['portfolio_layout'] === 'mosaic' && !empty($settings['mosaic_pattern'])) {
                    foreach ($settings['mosaic_pattern'] as $cell) {
                        $w = !empty($cell['cell_width']) ? intval($cell['cell_width']) : 1;
                        $h = !empty($cell['cell_height']) ? intval($cell['cell_height']) : 1;
                        if ($w > $max_width) $max_width = $w;
                        $mosaic_cells[] = [ 'width' => $w, 'height' => $h ];
                    }
                }

                // Output items, giving each mosaic cell the right attributes
                $item_index = 0;
                $pattern_count = count($mosaic_cells);

                // Determine hover class based on content position and animation
                $hover_class = '';
                if ($settings['content_position'] === 'content-overlay' && !empty($settings['overlay_caption_animation'])) {
                    $hover_class = 'cbp-caption-' . $settings['overlay_caption_animation'];
                } elseif ($settings['content_position'] === 'content-under-img' && !empty($settings['under_image_caption_animation'])) {
                    $hover_class = 'cbp-caption-' . $settings['under_image_caption_animation'];
                }

                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        $item_terms = get_the_terms(get_the_ID(), 'portfolio_category');
                        $desc_names = [];
                        $slug_classes = [];
                        if ($item_terms && !is_wp_error($item_terms)) {
                            foreach ($item_terms as $term) {
                                $desc_names[] = $term->name;
                                $slug_classes[] = $term->slug;
                            }
                        }
                        // Assign mosaic cell for this item (cycle pattern if not enough)
                        $cell = ['width' => 1, 'height' => 1];
                        if ($settings['portfolio_layout'] === 'mosaic' && $pattern_count) {
                            $cell = $mosaic_cells[$item_index % $pattern_count];
                        }
                        ?>
                        <div class="cbp-item <?php echo esc_attr(implode(' ', $slug_classes)); ?>"
                            <?php if ($settings['portfolio_layout'] === 'mosaic') : ?>
                                data-cbp-mosaic-width="<?php echo esc_attr($cell['width']); ?>"
                                data-cbp-mosaic-height="<?php echo esc_attr($cell['height']); ?>"
                            <?php endif; ?>
                        >
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="cbp-caption <?php echo $hover_class; ?>" target="_blank">
                                    <div class="cbp-caption-defaultWrap">
                                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>">
                                    </div>
                                    <div class="cbp-caption-activeWrap">
                                        <?php if ($settings['content_position'] === 'content-overlay'): ?>
                                            <?php if (!empty($settings['show_title']) && $settings['show_title'] == 'yes'): ?>
                                                <div class="cbp-l-grid-projects-title"><?php the_title(); ?></div>
                                            <?php endif; ?>
                                            <?php if (!empty($desc_names) && !empty($settings['show_subtitle']) && $settings['show_subtitle'] == 'yes'): ?>
                                                <div class="cbp-l-grid-projects-desc"><?php echo esc_html(implode(' / ', $desc_names)); ?></div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <?php if ($settings['content_position'] === 'content-under-img'): ?>
                                    <?php if (!empty($settings['show_title']) && $settings['show_title'] == 'yes'): ?>
                                        <div class="cbp-l-grid-projects-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></div>
                                    <?php endif; ?>
                                    <?php if (!empty($desc_names) && !empty($settings['show_subtitle']) && $settings['show_subtitle'] == 'yes'): ?>
                                        <div class="cbp-l-grid-projects-desc"><?php echo esc_html(implode(' / ', $desc_names)); ?></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                        </div>
                        <?php
                        ++$item_index;
                    endwhile;
                    wp_reset_postdata();
                else:
                    if ($query) {
                        echo '<p>' . esc_html__('No portfolio items found.', 'cubeportfolio-elementor-widget') . '</p>';
                    }
                endif;
                echo '</div></div>';

                $horizontal_gap = isset($settings['horizontal_space']['size']) ? intval($settings['horizontal_space']['size']) : 20;
                $vertical_gap = isset($settings['vertical_space']['size']) ? intval($settings['vertical_space']['size']) : 20;

                $scroll_offset = isset($settings['scroll_offset']) ? intval($settings['scroll_offset']) : 0;
                
                // Get breakpoints configuration
                $bp_widescreen = !empty($settings['widescreen_breakpoint']) ? intval($settings['widescreen_breakpoint']) : 1920;
                $bp_desktop = !empty($settings['desktop_breakpoint']) ? intval($settings['desktop_breakpoint']) : 1440;
                $bp_laptop = !empty($settings['laptop_breakpoint']) ? intval($settings['laptop_breakpoint']) : 1200;
                $bp_tablet = !empty($settings['tablet_breakpoint']) ? intval($settings['tablet_breakpoint']) : 1024;
                $bp_mobile_extra = !empty($settings['mobile_extra_breakpoint']) ? intval($settings['mobile_extra_breakpoint']) : 880;
                $bp_mobile = !empty($settings['mobile_breakpoint']) ? intval($settings['mobile_breakpoint']) : 767;
                
                // Get columns for each breakpoint
                $cols_widescreen = !empty($settings['columns_widescreen']) ? intval($settings['columns_widescreen']) : 5;
                $cols_desktop = !empty($settings['columns_desktop']) ? intval($settings['columns_desktop']) : 4;
                $cols_laptop = !empty($settings['columns_laptop']) ? intval($settings['columns_laptop']) : 3;
                $cols_tablet = !empty($settings['columns_tablet']) ? intval($settings['columns_tablet']) : 3;
                $cols_mobile_extra = !empty($settings['columns_mobile_extra']) ? intval($settings['columns_mobile_extra']) : 2;
                $cols_mobile = !empty($settings['columns_mobile']) ? intval($settings['columns_mobile']) : 1;
                
                // For mosaic, use max_width for the largest breakpoint
                if ($settings['portfolio_layout'] === 'mosaic' && $max_width) {
                    $cols_widescreen = $max_width;
                }
                ?>
                <script>
                jQuery(document).ready(function($){
                    // Check if cubeportfolio is loaded
                    if (typeof $.fn.cubeportfolio === 'undefined') {
                        console.error('CubePortfolio plugin is not loaded. Please check if jquery.cubeportfolio.min.js is loaded correctly.');
                        return;
                    }
                    
                    // Toggle para filtros
                    var $toggleBtn = $('.cbp-filter-toggle-btn[data-target="filters-<?php echo esc_js($widget_id); ?>"]');
                    var $filtersWrapper = $('#filters-wrapper-<?php echo esc_js($widget_id); ?>');
                    
                    $toggleBtn.on('click', function() {
                        var $btn = $(this);
                        $filtersWrapper.toggleClass('active');
                        
                        // Cambiar texto del botón
                        if ($filtersWrapper.hasClass('active')) {
                            $btn.text($btn.data('text-close'));
                        } else {
                            $btn.text($btn.data('text-open'));
                        }
                        
                        // Scroll suave hacia el grid al abrir
                        if ($filtersWrapper.hasClass('active')) {
                            setTimeout(function() {
                                var $grid = $('#<?php echo esc_js($widget_id); ?>');
                                var offset = $grid.offset().top - 100;
                                
                                // Check if Lenis is available
                                if (window.lenis) {
                                    window.lenis.scrollTo(offset, { duration: 0.6 });
                                } else {
                                    $('html, body').animate({
                                        scrollTop: offset
                                    }, 600);
                                }
                            }, 100);
                        }
                    });
                    
                    // Cerrar panel al hacer click en un filtro
                    $('#filters-<?php echo esc_js($widget_id); ?> .cbp-filter-item').on('click', function() {
                        $filtersWrapper.removeClass('active');
                        $toggleBtn.text($toggleBtn.data('text-open'));
                    });
                    
                    // Initialize CubePortfolio with error handling
                    try {
                        $('#<?php echo esc_js($widget_id); ?>').cubeportfolio({
                            filters: '#filters-<?php echo esc_js($widget_id); ?>',
                            layoutMode: '<?php echo esc_js($settings['portfolio_layout']); ?>',
                            defaultFilter: '*',
                            animationType: '<?php echo esc_js($settings['filters_animation']); ?>',
                            gapHorizontal: <?php echo $horizontal_gap; ?>,
                            gapVertical: <?php echo $vertical_gap; ?>,
                            gridAdjustment: 'responsive',
                        <?php if ($settings['content_position'] === 'content-overlay' && !empty($settings['overlay_caption_animation'])): ?>
                        caption: '<?php echo esc_js($settings['overlay_caption_animation']); ?>',
                        <?php elseif ($settings['content_position'] === 'content-under-img' && !empty($settings['under_image_caption_animation'])): ?>
                        caption: '<?php echo esc_js($settings['under_image_caption_animation']); ?>',
                        <?php endif; ?>
                        <?php if ($settings['portfolio_layout'] === 'mosaic' && !empty($mosaic_cells)): ?>
                        mosaic: <?php echo json_encode($mosaic_cells); ?>,
                        <?php endif; ?>
                        mediaQueries: [
                            { width: <?php echo $bp_widescreen; ?>, cols: <?php echo $cols_widescreen; ?> },
                            { width: <?php echo $bp_desktop; ?>, cols: <?php echo $cols_desktop; ?> },
                            { width: <?php echo $bp_laptop; ?>, cols: <?php echo $cols_laptop; ?> },
                            { width: <?php echo $bp_tablet; ?>, cols: <?php echo $cols_tablet; ?> },
                            { width: <?php echo $bp_mobile_extra; ?>, cols: <?php echo $cols_mobile_extra; ?> },
                            { width: <?php echo $bp_mobile; ?>, cols: <?php echo $cols_mobile; ?> }
                        ],
                        plugins: {
                            loadMore: {
                                element: '',
                                action: 'click',
                                loadItems: 3,
                            }
                        },
                        displayType: 'fadeInToTop',
                        displayTypeSpeed: 100
                        });
                        
                        // Show container after a short delay to ensure layout is calculated
                        setTimeout(function() {
                            $('#<?php echo esc_js($widget_id); ?>').css('opacity', '1');
                        }, 100);
                        
                    } catch (error) {
                        console.error('Error initializing CubePortfolio:', error);
                        // Show container anyway to prevent invisible content
                        $('#<?php echo esc_js($widget_id); ?>').css('opacity', '1');
                    }
                });
                </script>
                <?php
                } catch (\Exception $e) {
                    // Log error and show user-friendly message
                    if ($is_editor) {
                        echo '<div style="padding: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin: 10px 0;">';
                        echo '<strong>⚠️ Widget Error</strong><br>';
                        echo 'Error: ' . esc_html($e->getMessage());
                        echo '</div>';
                    }
                    error_log('CubePortfolio Widget Error: ' . $e->getMessage());
                }
        }
}