<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Magazine Grid Widget
 * 
 * Displays posts and custom post types in a customizable magazine-style grid layout
 * with individual control over column span and row span for each item.
 */
class Magazine_Grid extends Widget_Base {

    public function get_name() {
        return 'soda_magazine_grid';
    }

    public function get_title() {
        return __('Magazine Grid', 'soda-elementor-addons');
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return ['soda-addons'];
    }

    public function get_script_depends() {
        return ['soda-magazine-grid'];
    }

    public function get_style_depends() {
        return ['soda-magazine-grid'];
    }

    protected function register_controls() {
        
        // ========== CONTENT SOURCE SECTION ==========
        $this->start_controls_section(
            'section_content_source',
            [
                'label' => __('Content Source', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_source',
            [
                'label' => __('Source', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'posts' => __('Posts', 'soda-elementor-addons'),
                    'custom' => __('Custom Items', 'soda-elementor-addons'),
                ],
                'default' => 'posts',
            ]
        );

        $this->end_controls_section();

        // ========== CUSTOM ITEMS SECTION ==========
        $this->start_controls_section(
            'section_custom_items',
            [
                'label' => __('Custom Items', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'content_source' => 'custom',
                ],
            ]
        );

        $custom_repeater = new Repeater();

        $custom_repeater->add_control(
            'item_image',
            [
                'label' => __('Image', 'soda-elementor-addons'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $custom_repeater->add_control(
            'item_title',
            [
                'label' => __('Title', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Item Title', 'soda-elementor-addons'),
                'label_block' => true,
            ]
        );

        $custom_repeater->add_control(
            'item_link',
            [
                'label' => __('Link', 'soda-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'soda-elementor-addons'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $custom_repeater->add_control(
            'show_button',
            [
                'label' => __('Show Button', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $custom_repeater->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Read More', 'soda-elementor-addons'),
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $custom_repeater->add_control(
            'button_icon',
            [
                'label' => __('Button Icon', 'soda-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $custom_repeater->add_control(
            'button_icon_position',
            [
                'label' => __('Icon Position', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'before' => __('Before', 'soda-elementor-addons'),
                    'after' => __('After', 'soda-elementor-addons'),
                ],
                'default' => 'after',
                'condition' => [
                    'show_button' => 'yes',
                ],
            ]
        );

        $custom_repeater->add_control(
            'item_excerpt',
            [
                'label' => __('Excerpt', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => '',
            ]
        );

        $custom_repeater->add_control(
            'column_span',
            [
                'label' => __('Column Span', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 12,
            ]
        );

        $custom_repeater->add_control(
            'column_span_laptop',
            [
                'label' => __('Column Span (Laptop)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'description' => __('Leave empty to inherit the desktop span.', 'soda-elementor-addons'),
            ]
        );

        $custom_repeater->add_control(
            'column_span_tablet',
            [
                'label' => __('Column Span (Tablet)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'description' => __('Leave empty to inherit the desktop span.', 'soda-elementor-addons'),
            ]
        );

        $custom_repeater->add_control(
            'column_span_mobile_extra',
            [
                'label' => __('Column Span (Mobile Extra)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'description' => __('Leave empty to inherit the tablet span (or desktop if tablet is empty).', 'soda-elementor-addons'),
            ]
        );

        $custom_repeater->add_control(
            'column_span_mobile',
            [
                'label' => __('Column Span (Mobile)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'description' => __('Leave empty to inherit the mobile extra span (or tablet if both are empty).', 'soda-elementor-addons'),
            ]
        );

        $custom_repeater->add_control(
            'row_span',
            [
                'label' => __('Row Span', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 10,
            ]
        );

        $custom_repeater->add_control(
            'row_span_laptop',
            [
                'label' => __('Row Span (Laptop)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'description' => __('Leave empty to inherit the desktop span.', 'soda-elementor-addons'),
            ]
        );

        $custom_repeater->add_control(
            'row_span_tablet',
            [
                'label' => __('Row Span (Tablet)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'description' => __('Leave empty to inherit the desktop span.', 'soda-elementor-addons'),
            ]
        );

        $custom_repeater->add_control(
            'row_span_mobile_extra',
            [
                'label' => __('Row Span (Mobile Extra)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'description' => __('Leave empty to inherit the tablet span (or desktop if tablet is empty).', 'soda-elementor-addons'),
            ]
        );

        $custom_repeater->add_control(
            'row_span_mobile',
            [
                'label' => __('Row Span (Mobile)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'description' => __('Leave empty to inherit the mobile extra span (or tablet if both are empty).', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'custom_items',
            [
                'label' => __('Items', 'soda-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $custom_repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => __('Item #1', 'soda-elementor-addons'),
                        'column_span' => 2,
                        'row_span' => 2,
                    ],
                    [
                        'item_title' => __('Item #2', 'soda-elementor-addons'),
                        'column_span' => 1,
                        'row_span' => 1,
                    ],
                    [
                        'item_title' => __('Item #3', 'soda-elementor-addons'),
                        'column_span' => 1,
                        'row_span' => 1,
                    ],
                    [
                        'item_title' => __('Item #4', 'soda-elementor-addons'),
                        'column_span' => 1,
                        'row_span' => 1,
                    ],
                    [
                        'item_title' => __('Item #5', 'soda-elementor-addons'),
                        'column_span' => 1,
                        'row_span' => 1,
                    ],
                    [
                        'item_title' => __('Item #6', 'soda-elementor-addons'),
                        'column_span' => 1,
                        'row_span' => 1,
                    ],
                ],
                'title_field' => '{{{ item_title }}} - Col: {{{ column_span }}} | Row: {{{ row_span }}}',
            ]
        );

        $this->end_controls_section();

        // ========== GRID SETTINGS FOR CUSTOM ITEMS ==========
        $this->start_controls_section(
            'section_custom_grid_settings',
            [
                'label' => __('Grid Settings', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'content_source' => 'custom',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_grid_columns',
            [
                'label' => __('Grid Columns', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'tablet_default' => 3,
                'mobile_default' => 2,
                'min' => 1,
                'max' => 12,
                'selectors' => [
                    '{{WRAPPER}} .post-magazine-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_grid_gap',
            [
                'label' => __('Grid Gap', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-magazine-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_auto_rows',
            [
                'label' => __('Row Height', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-magazine-grid' => 'grid-auto-rows: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        
        // ========== QUERY SECTION ==========
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'content_source' => 'posts',
                ],
            ]
        );

        $this->add_control(
            'post_type',
            [
                'label' => __('Post Type', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_post_types(),
                'default' => 'post',
            ]
        );

        $this->add_control(
            'manual_post_ids',
            [
                'label' => __('Manual Selection', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => $this->get_manual_posts_options(),
                'condition' => [
                    'post_type' => 'manual',
                ],
                'description' => __('Choose specific posts to display. The selection order is preserved on the front end.', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 100,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => __('Order By', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'date' => __('Date', 'soda-elementor-addons'),
                    'title' => __('Title', 'soda-elementor-addons'),
                    'modified' => __('Modified', 'soda-elementor-addons'),
                    'rand' => __('Random', 'soda-elementor-addons'),
                    'menu_order' => __('Menu Order', 'soda-elementor-addons'),
                ],
                'default' => 'date',
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ASC' => __('Ascending', 'soda-elementor-addons'),
                    'DESC' => __('Descending', 'soda-elementor-addons'),
                ],
                'default' => 'DESC',
            ]
        );

        $this->add_control(
            'include_terms',
            [
                'label' => __('Include Terms', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => $this->get_terms_options(),
                'condition' => [
                    'post_type!' => 'manual',
                ],
                'description' => __('Posts must match at least one of the selected terms.', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'exclude_terms',
            [
                'label' => __('Exclude Terms', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'label_block' => true,
                'options' => $this->get_terms_options(),
                'condition' => [
                    'post_type!' => 'manual',
                ],
                'description' => __('Exclude posts assigned to any of the selected terms.', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'exclude_current',
            [
                'label' => __('Exclude Current Post', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'only_featured_image',
            [
                'label' => __('Only Posts with Featured Image', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Show only posts that have a featured image set', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'hide_empty_title',
            [
                'label' => __('Hide Posts Without Title', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => __('Hide posts with default titles like "Sin título", "Untitled", "(no title)", etc.', 'soda-elementor-addons'),
            ]
        );

        $this->end_controls_section();

        // ========== GRID LAYOUT SECTION ==========
        $this->start_controls_section(
            'section_grid_layout',
            [
                'label' => __('Grid Layout', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'content_source' => 'posts',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_columns',
            [
                'label' => __('Grid Columns', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
                'tablet_default' => 3,
                'mobile_default' => 2,
                'min' => 1,
                'max' => 12,
                'selectors' => [
                    '{{WRAPPER}} .post-magazine-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => __('Grid Gap', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-magazine-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'auto_rows',
            [
                'label' => __('Row Height', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-magazine-grid' => 'grid-auto-rows: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'column_span',
            [
                'label' => __('Column Span', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 12,
            ]
        );

        $repeater->add_control(
            'column_span_laptop',
            [
                'label' => __('Column Span (Laptop)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'description' => __('Leave empty to inherit the desktop span.', 'soda-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'column_span_tablet',
            [
                'label' => __('Column Span (Tablet)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'description' => __('Leave empty to inherit the desktop span.', 'soda-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'column_span_mobile_extra',
            [
                'label' => __('Column Span (Mobile Extra)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'description' => __('Leave empty to inherit the tablet span (or desktop if tablet is empty).', 'soda-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'column_span_mobile',
            [
                'label' => __('Column Span (Mobile)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 12,
                'description' => __('Leave empty to inherit the mobile extra span (or tablet if both are empty).', 'soda-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'row_span',
            [
                'label' => __('Row Span', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 10,
            ]
        );

        $repeater->add_control(
            'row_span_laptop',
            [
                'label' => __('Row Span (Laptop)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'description' => __('Leave empty to inherit the desktop span.', 'soda-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'row_span_tablet',
            [
                'label' => __('Row Span (Tablet)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'description' => __('Leave empty to inherit the desktop span.', 'soda-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'row_span_mobile_extra',
            [
                'label' => __('Row Span (Mobile Extra)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'description' => __('Leave empty to inherit the tablet span (or desktop if tablet is empty).', 'soda-elementor-addons'),
            ]
        );

        $repeater->add_control(
            'row_span_mobile',
            [
                'label' => __('Row Span (Mobile)', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 10,
                'description' => __('Leave empty to inherit the mobile extra span (or tablet if both are empty).', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'grid_items',
            [
                'label' => __('Grid Items Layout', 'soda-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['column_span' => 2, 'row_span' => 2],
                    ['column_span' => 1, 'row_span' => 1],
                    ['column_span' => 1, 'row_span' => 1],
                    ['column_span' => 1, 'row_span' => 1],
                    ['column_span' => 1, 'row_span' => 1],
                    ['column_span' => 1, 'row_span' => 1],
                ],
                'title_field' => 'Col: {{{ column_span }}} | Row: {{{ row_span }}}',
                'description' => __('Define column and row span for each post item. Pattern repeats if there are more posts than defined items.', 'soda-elementor-addons'),
            ]
        );

        $this->end_controls_section();

        // ========== CONTENT SETTINGS SECTION ==========
        $this->start_controls_section(
            'section_content_settings',
            [
                'label' => __('Content Settings', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label' => __('Show Image', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'large',
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => __('Title HTML Tag', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                ],
                'default' => 'h3',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_source',
            [
                'label' => __('Title Source', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'post_title' => __('Default Post Title', 'soda-elementor-addons'),
                    'custom_field' => __('Custom Field', 'soda-elementor-addons'),
                ],
                'default' => 'post_title',
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'custom_title_field',
            [
                'label' => __('Custom Field Key', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '_slider_titulo_slider',
                'description' => __('Enter the meta key to use when pulling the title from a custom field. The widget falls back to the default title if the field is empty.', 'soda-elementor-addons'),
                'condition' => [
                    'show_title' => 'yes',
                    'title_source' => 'custom_field',
                ],
            ]
        );

        $this->add_control(
            'title_word_limit',
            [
                'label' => __('Title Word Limit', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 50,
                'description' => __('Limit the number of words displayed in the title. Leave empty or set to 0 to show the full title.', 'soda-elementor-addons'),
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'title_trim_suffix',
            [
                'label' => __('Trim Suffix', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '...',
                'description' => __('Text appended to the title when it is trimmed.', 'soda-elementor-addons'),
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'link_source',
            [
                'label' => __('Link Source', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'permalink' => __('Default Permalink', 'soda-elementor-addons'),
                    'custom_field' => __('Custom Field', 'soda-elementor-addons'),
                ],
                'default' => 'permalink',
                'condition' => [
                    'content_source' => 'posts',
                ],
            ]
        );

        $this->add_control(
            'custom_link_field',
            [
                'label' => __('Link Field Key', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '_slider_url_link',
                'description' => __('Meta key used to fetch the URL when Link Source is set to Custom Field. Falls back to the permalink if empty or invalid.', 'soda-elementor-addons'),
                'condition' => [
                    'content_source' => 'posts',
                    'link_source' => 'custom_field',
                ],
            ]
        );

        $this->add_control(
            'click_entire_item',
            [
                'label' => __('Make Entire Item Clickable', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Show Excerpt', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt Length', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'min' => 5,
                'max' => 100,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_meta',
            [
                'label' => __('Show Meta Data', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'meta_items',
            [
                'label' => __('Meta Items', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'date' => __('Date', 'soda-elementor-addons'),
                    'author' => __('Author', 'soda-elementor-addons'),
                    'category' => __('Category', 'soda-elementor-addons'),
                    'comments' => __('Comments', 'soda-elementor-addons'),
                ],
                'default' => ['date'],
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'content_position',
            [
                'label' => __('Content Position', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'overlay' => __('Overlay', 'soda-elementor-addons'),
                    'below' => __('Below Image', 'soda-elementor-addons'),
                ],
                'default' => 'overlay',
            ]
        );

        $this->add_control(
            'content_alignment',
            [
                'label' => __('Content Alignment', 'soda-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Top', 'soda-elementor-addons'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => __('Center', 'soda-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => __('Bottom', 'soda-elementor-addons'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'flex-end',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-content' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'content_position' => 'overlay',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: GRID ITEM ==========
        $this->start_controls_section(
            'section_style_item',
            [
                'label' => __('Grid Item', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_border_radius',
            [
                'label' => __('Border Radius', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .ue-grid-item-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .ue-grid-item',
            ]
        );

        $this->add_control(
            'item_hover_effect',
            [
                'label' => __('Hover Effect', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => __('None', 'soda-elementor-addons'),
                    'zoom' => __('Zoom In', 'soda-elementor-addons'),
                    'zoom-out' => __('Zoom Out', 'soda-elementor-addons'),
                    'slide-up' => __('Slide Up', 'soda-elementor-addons'),
                ],
                'default' => 'zoom',
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: IMAGE ==========
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Image', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image_overlay_color',
            [
                'label' => __('Overlay Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.3)',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-image-overlay::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'image_overlay_hover_color',
            [
                'label' => __('Overlay Hover Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.5)',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item:hover .ue-grid-item-image-overlay::before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: CONTENT ==========
        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __('Content', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => __('Padding', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_background',
            [
                'label' => __('Background', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-content' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'content_position' => 'below',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: TITLE ==========
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __('Title', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .ue-grid-item-title .ue-grid-item-title-text',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-title .ue-grid-item-title-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Hover Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-title .ue-grid-item-title-text:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __('Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: META ==========
        $this->start_controls_section(
            'section_style_meta',
            [
                'label' => __('Meta Data', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_meta' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .ue-grid-item-meta-data',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => __('Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-meta-data' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_spacing',
            [
                'label' => __('Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-meta-data' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: EXCERPT ==========
        $this->start_controls_section(
            'section_style_excerpt',
            [
                'label' => __('Excerpt', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'excerpt_typography',
                'selector' => '{{WRAPPER}} .ue-grid-item-excerpt',
            ]
        );

        $this->add_control(
            'excerpt_color',
            [
                'label' => __('Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: BUTTON ==========
        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __('Button', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'content_source' => 'custom',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .ue-grid-item-button',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 10,
                    'right' => 20,
                    'bottom' => 10,
                    'left' => 20,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_spacing',
            [
                'label' => __('Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_icon_spacing',
            [
                'label' => __('Icon Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 30,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button .button-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ue-grid-item-button .button-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('button_style_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'button_style_normal',
            [
                'label' => __('Normal', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => __('Background', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .ue-grid-item-button',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'button_style_hover',
            [
                'label' => __('Hover', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background',
            [
                'label' => __('Background', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __('Border Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .ue-grid-item-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .ue-grid-item-button',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get available post types
     */
    private function get_post_types() {
        $post_types = get_post_types(['public' => true], 'objects');
        $options = [];
        
        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->label;
        }

        $options['manual'] = __('Manual Selection', 'soda-elementor-addons');
        
        return $options;
    }

    /**
     * Get options for manual post selection control.
     */
    private function get_manual_posts_options() {
        $options = [];
        $post_types = get_post_types(['public' => true], 'objects');
        $limit = apply_filters('soda_magazine_grid_manual_selection_limit', 200);

        foreach ($post_types as $post_type => $object) {
            $posts = get_posts([
                'post_type' => $post_type,
                'posts_per_page' => $limit,
                'post_status' => 'publish',
                'orderby' => 'date',
                'order' => 'DESC',
                'suppress_filters' => false,
            ]);

            if (empty($posts)) {
                continue;
            }

            foreach ($posts as $post) {
                $title = trim($post->post_title);
                if ($title === '') {
                    $title = sprintf(__('(ID %d) Untitled', 'soda-elementor-addons'), $post->ID);
                }

                $options[$post->ID] = sprintf('%s (%s)', $title, $object->labels->singular_name);
            }
        }

        return $options;
    }

    /**
     * Get available taxonomy terms for include/exclude controls.
     */
    private function get_terms_options() {
        $options = [];
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        $limit = apply_filters('soda_magazine_grid_term_selection_limit', 200);

        foreach ($taxonomies as $taxonomy => $object) {
            $terms = get_terms([
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
                'number' => $limit,
            ]);

            if (is_wp_error($terms) || empty($terms)) {
                continue;
            }

            foreach ($terms as $term) {
                $label = sprintf('%s (%s)', $term->name, $object->labels->singular_name);
                $options[$term->term_id] = $label;
            }
        }

        return $options;
    }

    /**
     * Group selected term IDs by taxonomy.
     */
    private function group_terms_by_taxonomy($term_ids) {
        $grouped = [];

        if (empty($term_ids) || !is_array($term_ids)) {
            return $grouped;
        }

        foreach ($term_ids as $term_id) {
            $term = get_term($term_id);

            if ($term instanceof \WP_Term) {
                $grouped[$term->taxonomy][] = (int) $term->term_id;
            }
        }

        return $grouped;
    }

    /**
     * Normalize manual selection IDs preserving the order selected in the control.
     */
    private function get_manual_post_ids($settings) {
        $manual_ids = [];

        if (!empty($settings['manual_post_ids']) && is_array($settings['manual_post_ids'])) {
            foreach ($settings['manual_post_ids'] as $id) {
                $id = absint($id);
                if ($id && !in_array($id, $manual_ids, true)) {
                    $manual_ids[] = $id;
                }
            }
        }

        if ($settings['exclude_current'] === 'yes' && is_singular()) {
            $current_id = get_the_ID();
            $manual_ids = array_values(array_filter(
                $manual_ids,
                static function ($id) use ($current_id) {
                    return $id !== $current_id;
                }
            ));
        }

        return $manual_ids;
    }

    /**
     * Determine which title should be displayed for the current post.
     */
    private function resolve_post_title($post_id, $settings) {
        $title = get_the_title($post_id);

        if (!empty($settings['title_source']) && $settings['title_source'] === 'custom_field') {
            $meta_key = !empty($settings['custom_title_field']) ? $settings['custom_title_field'] : '_slider_titulo_slider';

            if (!empty($meta_key)) {
                $meta_value = get_post_meta($post_id, $meta_key, true);

                if (is_array($meta_value)) {
                    $meta_value = implode(' ', array_filter(array_map('trim', $meta_value)));
                }

                if (is_string($meta_value)) {
                    $meta_value = trim($meta_value);

                    if ($meta_value !== '') {
                        $title = $meta_value;
                    }
                }
            }
        }

        /**
         * Allow developers to filter the resolved title before output.
         */
        return apply_filters('soda_magazine_grid_resolved_title', $title, $post_id, $settings);
    }

    /**
     * Determine which link should be used for the current post.
     */
    private function resolve_post_link($post_id, $settings) {
        $link = get_permalink($post_id);

        if (!empty($settings['link_source']) && $settings['link_source'] === 'custom_field') {
            $meta_key = !empty($settings['custom_link_field']) ? $settings['custom_link_field'] : '_slider_url_link';

            if (!empty($meta_key)) {
                $meta_value = get_post_meta($post_id, $meta_key, true);

                if (is_array($meta_value)) {
                    $meta_value = array_filter(array_map('trim', $meta_value));
                    $meta_value = reset($meta_value);
                }

                if (is_string($meta_value)) {
                    $meta_value = trim($meta_value);
                }

                if (!empty($meta_value)) {
                    $sanitized = esc_url_raw($meta_value);

                    if (!empty($sanitized)) {
                        $link = $sanitized;
                    }
                }
            }
        }

        /**
         * Allow developers to filter the resolved link before output.
         */
        return apply_filters('soda_magazine_grid_resolved_link', $link, $post_id, $settings);
    }

    /**
     * Build inline style string for grid span values across responsive breakpoints.
     */
    private function build_grid_span_style($layout) {
        if (!is_array($layout)) {
            $layout = [];
        }

        $col_desktop = isset($layout['column_span']) ? max(1, (int) $layout['column_span']) : 1;
        $row_desktop = isset($layout['row_span']) ? max(1, (int) $layout['row_span']) : 1;

        $col_laptop = isset($layout['column_span_laptop']) ? max(0, (int) $layout['column_span_laptop']) : 0;
        $row_laptop = isset($layout['row_span_laptop']) ? max(0, (int) $layout['row_span_laptop']) : 0;

        $col_tablet = isset($layout['column_span_tablet']) ? max(0, (int) $layout['column_span_tablet']) : 0;
        $row_tablet = isset($layout['row_span_tablet']) ? max(0, (int) $layout['row_span_tablet']) : 0;

        $col_mobile_extra = isset($layout['column_span_mobile_extra']) ? max(0, (int) $layout['column_span_mobile_extra']) : 0;
        $row_mobile_extra = isset($layout['row_span_mobile_extra']) ? max(0, (int) $layout['row_span_mobile_extra']) : 0;

        $col_mobile = isset($layout['column_span_mobile']) ? max(0, (int) $layout['column_span_mobile']) : 0;
        $row_mobile = isset($layout['row_span_mobile']) ? max(0, (int) $layout['row_span_mobile']) : 0;

        $style_parts = [
            sprintf('grid-column: span %d', $col_desktop),
            sprintf('grid-row: span %d', $row_desktop),
            sprintf('--ue-col-span-desktop: %d', $col_desktop),
            sprintf('--ue-row-span-desktop: %d', $row_desktop),
        ];

        if ($col_laptop > 0) {
            $style_parts[] = sprintf('--ue-col-span-laptop: %d', $col_laptop);
        }

        if ($row_laptop > 0) {
            $style_parts[] = sprintf('--ue-row-span-laptop: %d', $row_laptop);
        }

        if ($col_tablet > 0) {
            $style_parts[] = sprintf('--ue-col-span-tablet: %d', $col_tablet);
        }

        if ($row_tablet > 0) {
            $style_parts[] = sprintf('--ue-row-span-tablet: %d', $row_tablet);
        }

        if ($col_mobile_extra > 0) {
            $style_parts[] = sprintf('--ue-col-span-mobile-extra: %d', $col_mobile_extra);
        }

        if ($row_mobile_extra > 0) {
            $style_parts[] = sprintf('--ue-row-span-mobile-extra: %d', $row_mobile_extra);
        }

        if ($col_mobile > 0) {
            $style_parts[] = sprintf('--ue-col-span-mobile: %d', $col_mobile);
        }

        if ($row_mobile > 0) {
            $style_parts[] = sprintf('--ue-row-span-mobile: %d', $row_mobile);
        }

        return implode('; ', $style_parts) . ';';
    }

    /**
     * Optionally trim the title using the provided settings.
     */
    private function trim_title_text($title, $settings) {
        if (!is_string($title)) {
            $title = (string) $title;
        }

        $limit = isset($settings['title_word_limit']) ? (int) $settings['title_word_limit'] : 0;

        if ($limit > 0) {
            $suffix = isset($settings['title_trim_suffix']) ? $settings['title_trim_suffix'] : '...';
            $suffix = is_string($suffix) && $suffix !== '' ? $suffix : '...';

            $plain_title = trim(wp_strip_all_tags($title));

            if ($plain_title === '') {
                return '';
            }

            $title = wp_trim_words($plain_title, $limit, $suffix);
        }

        return $title;
    }

    /**
     * Get custom excerpt
     */
    private function get_excerpt($length = 20) {
        $excerpt = get_the_excerpt();
        
        if (empty($excerpt)) {
            $excerpt = get_the_content();
        }
        
        $excerpt = strip_tags($excerpt);
        $excerpt = wp_trim_words($excerpt, $length, '...');
        
        return $excerpt;
    }

    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if ($settings['content_source'] === 'custom') {
            $this->render_custom_items($settings);
        } else {
            $this->render_posts($settings);
        }
    }

    /**
     * Render custom items
     */
    private function render_custom_items($settings) {
        $custom_items = $settings['custom_items'];
        
        if (empty($custom_items)) {
            echo '<p>' . __('No items added.', 'soda-elementor-addons') . '</p>';
            return;
        }
        
        $widget_id = $this->get_id();
        $content_position_class = $settings['content_position'] === 'overlay' ? 'ue-layout-cover' : 'ue-layout-below';
        $hover_effect_class = 'hover-' . $settings['item_hover_effect'];
        
        ?>
        <div id="uc_post_magazine_grid_elementor_<?php echo esc_attr($widget_id); ?>" 
             class="post-magazine-grid <?php echo esc_attr($content_position_class); ?> <?php echo esc_attr($hover_effect_class); ?> ue-items-wrapper"
             data-hover-effect="<?php echo esc_attr($settings['item_hover_effect']); ?>">
            
            <?php
            $click_entire_item = !empty($settings['click_entire_item']) && $settings['click_entire_item'] === 'yes';

            foreach ($custom_items as $index => $item) :
                $grid_style = $this->build_grid_span_style($item);
                $link_url = !empty($item['item_link']['url']) ? $item['item_link']['url'] : '';
                $link_target_attr = !empty($item['item_link']['is_external']) ? ' target="_blank"' : '';
                $link_rel_attr = !empty($item['item_link']['nofollow']) ? ' rel="nofollow"' : '';
                $has_link = !empty($link_url);
                $is_full_clickable = $click_entire_item && $has_link;
                $wrapper_tag = $is_full_clickable ? 'a' : 'div';

                $raw_title = isset($item['item_title']) ? $item['item_title'] : '';
                $display_title = $this->trim_title_text($raw_title, $settings);
                $normalized_title = trim(wp_strip_all_tags($display_title));
                ?>

                <<?php echo $wrapper_tag; ?> class="ue-grid-item<?php echo $is_full_clickable ? ' ue-grid-item--clickable' : ''; ?>" style="<?php echo esc_attr($grid_style); ?>"<?php
                    if ($is_full_clickable) {
                        echo ' href="' . esc_url($link_url) . '"' . $link_target_attr . $link_rel_attr;
                        if ($normalized_title !== '') {
                            echo ' aria-label="' . esc_attr($normalized_title) . '"';
                        }
                    }
                ?>>

                    <?php if ($settings['show_image'] === 'yes' && !empty($item['item_image']['url'])) : ?>
                        <div class="ue-grid-item-image">
                            <?php
                            $image_url = $item['item_image']['url'];
                            $image_id = $item['item_image']['id'];

                            if ($image_id) {
                                $image_size = $settings['image_size_size'];
                                if ($image_size === 'custom') {
                                    $image_size = [
                                        $settings['image_size_custom_dimension']['width'],
                                        $settings['image_size_custom_dimension']['height']
                                    ];
                                }
                                echo wp_get_attachment_image($image_id, $image_size, false, [
                                    'loading' => $index === 0 ? false : 'lazy',
                                    'decoding' => 'async',
                                ]);
                            } else {
                                echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($item['item_title']) . '" ' . ($index === 0 ? '' : 'loading="lazy"') . ' decoding="async">';
                            }
                            ?>
                            <?php if ($has_link && !$is_full_clickable) : ?>
                                <a class="ue-grid-item-image-overlay" href="<?php echo esc_url($link_url); ?>"<?php echo $link_target_attr . $link_rel_attr; ?>></a>
                            <?php else : ?>
                                <span class="ue-grid-item-image-overlay" aria-hidden="true"></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="ue-grid-item-content">

                        <?php if ($settings['show_title'] === 'yes' && $normalized_title !== '') : ?>
                            <<?php echo esc_attr($settings['title_tag']); ?> class="ue-grid-item-title">
                                <?php if ($has_link && !$is_full_clickable) : ?>
                                    <a href="<?php echo esc_url($link_url); ?>"<?php echo $link_target_attr . $link_rel_attr; ?> class="ue-grid-item-title-text"><?php echo esc_html($display_title); ?></a>
                                <?php else : ?>
                                    <span class="ue-grid-item-title-text"><?php echo esc_html($display_title); ?></span>
                                <?php endif; ?>
                            </<?php echo esc_attr($settings['title_tag']); ?>>
                        <?php endif; ?>

                        <?php if ($settings['show_excerpt'] === 'yes' && !empty($item['item_excerpt'])) : ?>
                            <div class="ue-grid-item-excerpt">
                                <?php echo esc_html($item['item_excerpt']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($item['show_button']) && $item['show_button'] === 'yes') : ?>
                            <?php if ($has_link && !$is_full_clickable) : ?>
                                <a href="<?php echo esc_url($link_url); ?>"<?php echo $link_target_attr . $link_rel_attr; ?> class="ue-grid-item-button">
                                    <?php
                                    if (!empty($item['button_icon']['value']) && $item['button_icon_position'] === 'before') {
                                        echo '<span class="button-icon button-icon-before">';
                                        \Elementor\Icons_Manager::render_icon($item['button_icon'], ['aria-hidden' => 'true']);
                                        echo '</span>';
                                    }

                                    if (!empty($item['button_text'])) {
                                        echo '<span class="button-text">' . esc_html($item['button_text']) . '</span>';
                                    }

                                    if (!empty($item['button_icon']['value']) && $item['button_icon_position'] === 'after') {
                                        echo '<span class="button-icon button-icon-after">';
                                        \Elementor\Icons_Manager::render_icon($item['button_icon'], ['aria-hidden' => 'true']);
                                        echo '</span>';
                                    }
                                    ?>
                                </a>
                            <?php else : ?>
                                <span class="ue-grid-item-button ue-grid-item-button--static">
                                    <?php
                                    if (!empty($item['button_icon']['value']) && $item['button_icon_position'] === 'before') {
                                        echo '<span class="button-icon button-icon-before">';
                                        \Elementor\Icons_Manager::render_icon($item['button_icon'], ['aria-hidden' => 'true']);
                                        echo '</span>';
                                    }

                                    if (!empty($item['button_text'])) {
                                        echo '<span class="button-text">' . esc_html($item['button_text']) . '</span>';
                                    }

                                    if (!empty($item['button_icon']['value']) && $item['button_icon_position'] === 'after') {
                                        echo '<span class="button-icon button-icon-after">';
                                        \Elementor\Icons_Manager::render_icon($item['button_icon'], ['aria-hidden' => 'true']);
                                        echo '</span>';
                                    }
                                    ?>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>

                </<?php echo $wrapper_tag; ?>>

            <?php endforeach; ?>
            
        </div>
        <?php
    }

    /**
     * Render posts from query
     */
    private function render_posts($settings) {
        $is_manual = isset($settings['post_type']) && $settings['post_type'] === 'manual';
        $manual_ids = [];

        if ($is_manual) {
            $manual_ids = $this->get_manual_post_ids($settings);

            if (empty($manual_ids)) {
                echo '<p>' . __('Select at least one post to display.', 'soda-elementor-addons') . '</p>';
                return;
            }

            $requested_posts = !empty($settings['posts_per_page']) ? max(1, (int) $settings['posts_per_page']) : count($manual_ids);
            $manual_limit = min($requested_posts, count($manual_ids));

            $manual_order_by = !empty($settings['order_by']) ? $settings['order_by'] : 'date';
            $manual_order = !empty($settings['order']) ? $settings['order'] : 'DESC';

            $args = [
                'post_type' => 'any',
                'post__in' => $manual_ids,
                'posts_per_page' => $manual_limit,
                'post_status' => 'publish',
                'orderby' => $manual_order_by,
                'order' => $manual_order,
            ];

            if ($manual_order_by === 'rand') {
                unset($args['order']);
            }

            if ($settings['only_featured_image'] === 'yes') {
                $args['meta_query'] = [
                    [
                        'key' => '_thumbnail_id',
                        'compare' => 'EXISTS',
                    ],
                ];
            }

            $max_items = $manual_limit;
        } else {
            // Query args
            // Request more posts than needed to account for filtering
            $requested_posts = max(1, (int) $settings['posts_per_page']);
            $query_posts = ($settings['hide_empty_title'] === 'yes' || $settings['only_featured_image'] === 'yes')
                ? $requested_posts * 3
                : $requested_posts;

            $args = [
                'post_type' => $settings['post_type'],
                'posts_per_page' => $query_posts,
                'orderby' => $settings['order_by'],
                'order' => $settings['order'],
                'post_status' => 'publish',
            ];

            // Exclude current post
            if ($settings['exclude_current'] === 'yes' && is_singular()) {
                $args['post__not_in'] = [get_the_ID()];
            }

            // Only posts with featured image (pre-filter in query)
            if ($settings['only_featured_image'] === 'yes') {
                $args['meta_query'] = [
                    [
                        'key' => '_thumbnail_id',
                        'compare' => 'EXISTS',
                    ],
                ];
            }

            $include_terms = $this->group_terms_by_taxonomy(!empty($settings['include_terms']) ? $settings['include_terms'] : []);
            $exclude_terms = $this->group_terms_by_taxonomy(!empty($settings['exclude_terms']) ? $settings['exclude_terms'] : []);

            if (!empty($include_terms) || !empty($exclude_terms)) {
                $tax_query = [];

                foreach ($include_terms as $taxonomy => $term_ids) {
                    $tax_query[] = [
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => array_map('absint', $term_ids),
                        'operator' => 'IN',
                    ];
                }

                foreach ($exclude_terms as $taxonomy => $term_ids) {
                    $tax_query[] = [
                        'taxonomy' => $taxonomy,
                        'field' => 'term_id',
                        'terms' => array_map('absint', $term_ids),
                        'operator' => 'NOT IN',
                    ];
                }

                if (count($tax_query) > 1) {
                    $tax_query['relation'] = 'AND';
                }

                $args['tax_query'] = $tax_query;
            }

            $max_items = $requested_posts;
        }

        $query = new \WP_Query($args);

        if (!$query->have_posts()) {
            echo '<p>' . __('No posts found.', 'soda-elementor-addons') . '</p>';
            return;
        }
        
        // Get grid items layout
        $grid_items = $settings['grid_items'];
        $grid_items_count = count($grid_items);
        
        $widget_id = $this->get_id();
        $content_position_class = $settings['content_position'] === 'overlay' ? 'ue-layout-cover' : 'ue-layout-below';
        $hover_effect_class = 'hover-' . $settings['item_hover_effect'];
        
        ?>
        <div id="uc_post_magazine_grid_elementor_<?php echo esc_attr($widget_id); ?>" 
             class="post-magazine-grid <?php echo esc_attr($content_position_class); ?> <?php echo esc_attr($hover_effect_class); ?> ue-items-wrapper"
             data-hover-effect="<?php echo esc_attr($settings['item_hover_effect']); ?>">
            
            <?php
            $counter = 0;
            $displayed_items = 0;
        
            
            while ($query->have_posts() && $displayed_items < $max_items) {
                $query->the_post();
                
                // Skip posts without featured image if option is enabled
                if ($settings['show_image'] === 'yes' && $settings['only_featured_image'] === 'yes' && !has_post_thumbnail()) {
                    continue;
                }
                
                $raw_title = $this->resolve_post_title(get_the_ID(), $settings);
                $raw_normalized_title = trim(wp_strip_all_tags($raw_title));

                // Skip posts with empty/default titles if option is enabled
                if ($settings['hide_empty_title'] === 'yes') {
                    $empty_titles = ['sin título', 'sin titulo', 'untitled', '(no title)', 'auto draft', ''];

                    if ($raw_normalized_title === '' || in_array(strtolower($raw_normalized_title), $empty_titles, true)) {
                        continue;
                    }
                }

                $display_title = $this->trim_title_text($raw_title, $settings);
                $normalized_title = trim(wp_strip_all_tags($display_title));

                $resolved_link = $this->resolve_post_link(get_the_ID(), $settings);
                $has_link = !empty($resolved_link);
                $click_entire_item = !empty($settings['click_entire_item']) && $settings['click_entire_item'] === 'yes';
                $is_full_clickable = $click_entire_item && $has_link;
                $wrapper_tag = $is_full_clickable ? 'a' : 'div';
                
                // Get current grid item layout (cycle through if more posts than defined items)
                $current_layout = $grid_items[$displayed_items % $grid_items_count];
                $grid_style = $this->build_grid_span_style($current_layout);
                
                ?>
                <<?php echo $wrapper_tag; ?> class="ue-grid-item<?php echo $is_full_clickable ? ' ue-grid-item--clickable' : ''; ?>" style="<?php echo esc_attr($grid_style); ?>"<?php
                    if ($is_full_clickable) {
                        echo ' href="' . esc_url($resolved_link) . '"';
                        if ($normalized_title !== '') {
                            echo ' aria-label="' . esc_attr($normalized_title) . '"';
                        }
                    }
                ?>>
                    
                    <?php if ($settings['show_image'] === 'yes' && has_post_thumbnail()) : ?>
                        <div class="ue-grid-item-image">
                            <?php
                            $image_size = $settings['image_size_size'];
                            if ($image_size === 'custom') {
                                $image_size = [
                                    $settings['image_size_custom_dimension']['width'],
                                    $settings['image_size_custom_dimension']['height']
                                ];
                            }
                            
                            echo get_the_post_thumbnail(get_the_ID(), $image_size, [
                                'loading' => $counter === 0 ? false : 'lazy',
                                'decoding' => 'async',
                            ]);
                            ?>
                            <?php if ($has_link && !$is_full_clickable) : ?>
                                <a class="ue-grid-item-image-overlay" href="<?php echo esc_url($resolved_link); ?>"></a>
                            <?php else : ?>
                                <span class="ue-grid-item-image-overlay" aria-hidden="true"></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="ue-grid-item-content">
                        
                        <?php if ($settings['show_meta'] === 'yes' && !empty($settings['meta_items'])) : ?>
                            <div class="ue-grid-item-meta-data">
                                <?php
                                foreach ($settings['meta_items'] as $meta_item) {
                                    switch ($meta_item) {
                                        case 'date':
                                            echo '<span class="meta-date">' . get_the_date() . '</span>';
                                            break;
                                        case 'author':
                                            echo '<span class="meta-author">' . get_the_author() . '</span>';
                                            break;
                                        case 'category':
                                            $categories = get_the_category();
                                            if (!empty($categories)) {
                                                echo '<span class="meta-category">' . esc_html($categories[0]->name) . '</span>';
                                            }
                                            break;
                                        case 'comments':
                                            echo '<span class="meta-comments">' . get_comments_number() . ' ' . __('Comments', 'soda-elementor-addons') . '</span>';
                                            break;
                                    }
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($settings['show_title'] === 'yes' && $normalized_title !== '') : ?>
                            <<?php echo esc_attr($settings['title_tag']); ?> class="ue-grid-item-title">
                                <?php if ($has_link && !$is_full_clickable) : ?>
                                    <a href="<?php echo esc_url($resolved_link); ?>" class="ue-grid-item-title-text"><?php echo esc_html($display_title); ?></a>
                                <?php else : ?>
                                    <span class="ue-grid-item-title-text"><?php echo esc_html($display_title); ?></span>
                                <?php endif; ?>
                            </<?php echo esc_attr($settings['title_tag']); ?>>
                        <?php endif; ?>
                        
                        <?php if ($settings['show_excerpt'] === 'yes') : ?>
                            <div class="ue-grid-item-excerpt">
                                <?php echo esc_html($this->get_excerpt($settings['excerpt_length'])); ?>
                            </div>
                        <?php endif; ?>
                        
                    </div>
                    
                </<?php echo $wrapper_tag; ?>>
                <?php
                $displayed_items++;
            }
            wp_reset_postdata();
            ?>
            
        </div>
        <?php
    }
}
