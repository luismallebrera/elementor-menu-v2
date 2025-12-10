<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * List Widget
 *
 * Provides a customizable list with optional icons and style controls.
 */
class List_Widget extends Widget_Base {

    public function get_name() {
        return 'soda_list';
    }

    public function get_title() {
        return __('List Widget', 'soda-elementor-addons');
    }

    public function get_icon() {
        return 'eicon-editor-list-ul';
    }

    public function get_categories() {
        return ['soda-addons'];
    }

    public function get_style_depends() {
        return ['soda-list-widget'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('List Items', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'content_source',
            [
                'label' => __('Content Source', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'repeater' => __('Repeater Items', 'soda-elementor-addons'),
                    'text' => __('Pasted List', 'soda-elementor-addons'),
                ],
                'default' => 'repeater',
            ]
        );

        $this->add_control(
            'list_layout',
            [
                'label' => __('Layout', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'vertical' => __('Vertical', 'soda-elementor-addons'),
                    'horizontal' => __('Horizontal', 'soda-elementor-addons'),
                ],
                'default' => 'vertical',
            ]
        );

        $this->add_control(
            'list_type',
            [
                'label' => __('List Type', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'ul' => __('Unordered', 'soda-elementor-addons'),
                    'ol' => __('Ordered', 'soda-elementor-addons'),
                ],
                'default' => 'ul',
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => __('Icon Position', 'soda-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'soda-elementor-addons'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => __('Right', 'soda-elementor-addons'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => false,
            ]
        );

        $this->add_control(
            'list_text_input',
            [
                'label' => __('Pasted List Items', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 8,
                'placeholder' => "<li>Item one</li>\n<li>Item two</li>",
                'description' => __('Paste list items (with or without <li> tags). Each item will be converted into the styled list.', 'soda-elementor-addons'),
                'condition' => [
                    'content_source' => 'text',
                ],
            ]
        );

        $this->add_control(
            'global_icon',
            [
                'label' => __('Default Icon', 'soda-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'solid',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label' => __('Title', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('List item title', 'soda-elementor-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_description',
            [
                'label' => __('Description', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'rows' => 3,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'item_icon',
            [
                'label' => __('Custom Icon', 'soda-elementor-addons'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $repeater->add_control(
            'item_link',
            [
                'label' => __('Link', 'soda-elementor-addons'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://example.com', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'list_items',
            [
                'label' => __('Items', 'soda-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_text' => __('List Item #1', 'soda-elementor-addons'),
                    ],
                    [
                        'item_text' => __('List Item #2', 'soda-elementor-addons'),
                    ],
                    [
                        'item_text' => __('List Item #3', 'soda-elementor-addons'),
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
                'condition' => [
                    'content_source' => 'repeater',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => __('Item Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-alist--vertical .soda-alist__item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .soda-alist--horizontal .soda-alist__item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => __('Icon Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-alist:not(.soda-alist--icon-right) .soda-alist__icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .soda-alist--icon-right .soda-alist__icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_container',
            [
                'label' => __('Container', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => __('Alignment', 'soda-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'prefix_class' => 'soda-alist--align-',
                'toggle' => false,
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => __('Padding', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .soda-alist' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => __('Background Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-alist' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .soda-alist',
            ]
        );

        $this->add_responsive_control(
            'container_border_radius',
            [
                'label' => __('Border Radius', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .soda-alist' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .soda-alist',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => __('Text', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .soda-alist__title',
            ]
        );

        $this->start_controls_tabs('tabs_title_color');

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __('Normal', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __('Hover', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__item-link:hover .soda-alist__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .soda-alist__description',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Description Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => __('Icon', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Size', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 120,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_icon_color');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => __('Normal', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-alist__icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => __('Background', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => __('Hover', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => __('Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__item-link:hover .soda-alist__icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-alist__item-link:hover .soda-alist__icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_background',
            [
                'label' => __('Background', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__item-link:hover .soda-alist__icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'selector' => '{{WRAPPER}} .soda-alist__icon',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label' => __('Border Radius', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .soda-alist__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_box_shadow',
                'selector' => '{{WRAPPER}} .soda-alist__icon',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $content_source = !empty($settings['content_source']) ? $settings['content_source'] : 'repeater';

        if ($content_source === 'text') {
            $items = $this->parse_list_text(!empty($settings['list_text_input']) ? $settings['list_text_input'] : '');
        } else {
            $items = !empty($settings['list_items']) && is_array($settings['list_items']) ? $settings['list_items'] : [];
        }

        if (empty($items)) {
            echo '<div class="soda-alist soda-alist--vertical">' . esc_html__('Add items to the list.', 'soda-elementor-addons') . '</div>';
            return;
        }

        $layout = !empty($settings['list_layout']) && $settings['list_layout'] === 'horizontal' ? 'horizontal' : 'vertical';
        $icon_position = !empty($settings['icon_position']) && $settings['icon_position'] === 'right' ? 'right' : 'left';
        $list_tag = !empty($settings['list_type']) && $settings['list_type'] === 'ol' ? 'ol' : 'ul';

        if (!empty($settings['alignment'])) {
            $alignment_class = 'soda-alist--align-' . $settings['alignment'];
        } else {
            $alignment_class = 'soda-alist--align-left';
        }

        $wrapper_classes = [
            'soda-alist',
            'soda-alist--' . $layout,
            'soda-alist--icon-' . $icon_position,
            $alignment_class,
        ];

        $global_icon = !empty($settings['global_icon']['value']) ? $settings['global_icon'] : null;

        echo '<' . $list_tag . ' class="' . esc_attr(implode(' ', $wrapper_classes)) . '">';

        foreach ($items as $index => $item) {
            if ($content_source === 'text') {
                $item_title = wp_kses_post($item);
                $item_description = '';
                $icon = $global_icon;
                $has_icon = !empty($icon) && !empty($icon['value']);
                $tag = 'div';
                $link_key = 'list-item-' . $this->get_id() . '-' . $index;
                $this->add_render_attribute($link_key, 'class', 'soda-alist__item-link');
            } else {
                $icon = !empty($item['item_icon']['value']) ? $item['item_icon'] : $global_icon;
                $has_icon = !empty($icon) && !empty($icon['value']);
                $link_key = 'list-item-' . $this->get_id() . '-' . $index;
                $tag = 'div';

                if (!empty($item['item_link']['url'])) {
                    $tag = 'a';
                    $this->add_link_attributes($link_key, $item['item_link']);
                }

                $this->add_render_attribute($link_key, 'class', 'soda-alist__item-link');
                $item_title = !empty($item['item_text']) ? esc_html($item['item_text']) : '';
                $item_description = !empty($item['item_description']) ? esc_html($item['item_description']) : '';
            }

            echo '<li class="soda-alist__item">';
            echo '<' . $tag . ' ' . $this->get_render_attribute_string($link_key) . '>';

            if ($has_icon) {
                echo '<span class="soda-alist__icon">';
                Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']);
                echo '</span>';
            }

            echo '<span class="soda-alist__text">';

            if (!empty($item_title)) {
                echo '<span class="soda-alist__title">' . $item_title . '</span>';
            }

            if (!empty($item_description)) {
                echo '<span class="soda-alist__description">' . $item_description . '</span>';
            }

            echo '</span>';
            echo '</' . $tag . '>';
            echo '</li>';
        }

        echo '</' . $list_tag . '>';
    }

    /**
     * Parse pasted list text into individual items.
     */
    private function parse_list_text($text) {
        $items = [];

        if (empty($text)) {
            return $items;
        }

        if (preg_match_all('/<li\b[^>]*>(.*?)<\/li>/is', $text, $matches)) {
            foreach ($matches[1] as $content) {
                $content = trim($content);
                if ($content !== '') {
                    $items[] = $content;
                }
            }
        } else {
            $lines = preg_split('/\r\n|\r|\n/', $text);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }

                $line = preg_replace('/^\s*[-*+•]\s*/u', '', $line);
                $line = preg_replace('/^\s*\d+\.\s+/', '', $line);
                $line = preg_replace('/^\s*\d+\)\s+/', '', $line);
                $line = trim($line);

                if ($line !== '') {
                    $items[] = sanitize_text_field($line);
                }
            }
        }

        return $items;
    }
}
