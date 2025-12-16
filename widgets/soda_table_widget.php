<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit;
}

class Table_Widget extends Widget_Base {

    public function get_name() {
        return 'soda-table';
    }

    public function get_title() {
        return esc_html__('Soda Table', 'soda-elementor-addons');
    }

    public function get_icon() {
        return 'eicon-table';
    }

    public function get_categories() {
        return ['soda-addons'];
    }

    public function get_style_depends() {
        return ['soda-table'];
    }

    protected function register_controls() {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    private function register_content_controls() {
        $this->start_controls_section(
            'table_content',
            [
                'label' => esc_html__('Table Content', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'caption',
            [
                'label' => esc_html__('Caption', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'placeholder' => esc_html__('Add a caption for the table', 'soda-elementor-addons'),
            ]
        );

        $columns_repeater = new Repeater();
        $columns_repeater->add_control(
            'column_label',
            [
                'label' => esc_html__('Header Label', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Column Title', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'soda-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $columns_repeater->get_controls(),
                'title_field' => '{{{ column_label }}}',
                'default' => [
                    ['column_label' => esc_html__('Column 1', 'soda-elementor-addons')],
                    ['column_label' => esc_html__('Column 2', 'soda-elementor-addons')],
                    ['column_label' => esc_html__('Column 3', 'soda-elementor-addons')],
                ],
            ]
        );

        $this->add_control(
            'show_header',
            [
                'label' => esc_html__('Show Header', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'soda-elementor-addons'),
                'label_off' => esc_html__('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $rows_repeater = new Repeater();
        $rows_repeater->add_control(
            'row_cells',
            [
                'label' => esc_html__('Cells', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
                'placeholder' => esc_html__('Cell 1 | Cell 2 | Cell 3', 'soda-elementor-addons'),
                'default' => esc_html__('Cell 1 | Cell 2 | Cell 3', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => esc_html__('Rows', 'soda-elementor-addons'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $rows_repeater->get_controls(),
                'title_field' => '{{{ row_cells }}}',
                'default' => [
                    ['row_cells' => esc_html__('Row 1 cell 1 | Row 1 cell 2 | Row 1 cell 3', 'soda-elementor-addons')],
                    ['row_cells' => esc_html__('Row 2 cell 1 | Row 2 cell 2 | Row 2 cell 3', 'soda-elementor-addons')],
                ],
            ]
        );

        $this->add_control(
            'zebra_stripes',
            [
                'label' => esc_html__('Zebra Stripes', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'soda-elementor-addons'),
                'label_off' => esc_html__('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'stack_on_mobile',
            [
                'label' => esc_html__('Horizontal Scroll on Mobile', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'help' => esc_html__('Wrap the table in a scrollable container on smaller devices.', 'soda-elementor-addons'),
                'label_on' => esc_html__('Yes', 'soda-elementor-addons'),
                'label_off' => esc_html__('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'empty_message',
            [
                'label' => esc_html__('Empty State Message', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('No data available.', 'soda-elementor-addons'),
            ]
        );

        $this->end_controls_section();
    }

    private function register_style_controls() {
        $this->start_controls_section(
            'header_style',
            [
                'label' => esc_html__('Header', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'header_typography',
                'selector' => '{{WRAPPER}} .soda-table thead th',
            ]
        );

        $this->add_control(
            'header_text_color',
            [
                'label' => esc_html__('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-table thead th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'header_background_color',
            [
                'label' => esc_html__('Background Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-table thead th' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_padding',
            [
                'label' => esc_html__('Padding', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .soda-table thead th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'body_style',
            [
                'label' => esc_html__('Body', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'body_typography',
                'selector' => '{{WRAPPER}} .soda-table tbody td',
            ]
        );

        $this->add_control(
            'body_text_color',
            [
                'label' => esc_html__('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-table tbody td' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'body_background_color',
            [
                'label' => esc_html__('Row Background', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-table tbody td' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'zebra_background_color',
            [
                'label' => esc_html__('Zebra Background', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'zebra_stripes' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-table.has-zebra tbody tr:nth-child(even) td' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'body_padding',
            [
                'label' => esc_html__('Padding', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .soda-table tbody td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'table_style',
            [
                'label' => esc_html__('Table', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'table_border',
                'selector' => '{{WRAPPER}} .soda-table',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'table_shadow',
                'selector' => '{{WRAPPER}} .soda-table',
            ]
        );

        $this->add_responsive_control(
            'table_border_radius',
            [
                'label' => esc_html__('Border Radius', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .soda-table' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'table_alignment',
            [
                'label' => esc_html__('Alignment', 'soda-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .soda-table-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $column_labels = [];
        if (!empty($settings['columns']) && is_array($settings['columns'])) {
            foreach ($settings['columns'] as $column) {
                $column_labels[] = isset($column['column_label']) ? $column['column_label'] : '';
            }
            $column_labels = array_filter($column_labels, static function ($label) {
                return $label !== '';
            });
        }

        $rows = [];
        if (!empty($settings['rows']) && is_array($settings['rows'])) {
            foreach ($settings['rows'] as $row) {
                $raw = isset($row['row_cells']) ? $row['row_cells'] : '';
                if ($raw === '') {
                    continue;
                }
                $cells = array_map('trim', explode('|', $raw));
                $rows[] = $cells;
            }
        }

        $column_count = count($column_labels);
        if ($column_count === 0) {
            foreach ($rows as $cells) {
                $column_count = max($column_count, count($cells));
            }
        }

        if ($column_count === 0) {
            if (!empty($settings['empty_message'])) {
                echo '<div class="soda-table-empty">' . esc_html($settings['empty_message']) . '</div>';
            }
            return;
        }

        $table_classes = ['soda-table'];
        if (!empty($settings['zebra_stripes']) && $settings['zebra_stripes'] === 'yes') {
            $table_classes[] = 'has-zebra';
        }

        $wrapper_classes = ['soda-table-wrapper'];
        if (!empty($settings['stack_on_mobile']) && $settings['stack_on_mobile'] === 'yes') {
            $wrapper_classes[] = 'has-scroll';
        }

        // Render wrapper to keep alignment controls working.
        printf('<div class="%s">', esc_attr(implode(' ', $wrapper_classes)));

        if (!empty($settings['caption'])) {
            printf('<span class="soda-table-caption">%s</span>', wp_kses_post($settings['caption']));
        }

        printf('<table class="%s">', esc_attr(implode(' ', $table_classes)));

        if (!empty($settings['show_header']) && $settings['show_header'] === 'yes' && !empty($column_labels)) {
            echo '<thead><tr>';
            foreach ($column_labels as $label) {
                echo '<th>' . esc_html($label) . '</th>';
            }
            echo '</tr></thead>';
        }

        if (!empty($rows)) {
            echo '<tbody>';
            foreach ($rows as $cells) {
                echo '<tr>';
                for ($i = 0; $i < $column_count; $i++) {
                    $cell_value = isset($cells[$i]) ? $cells[$i] : '';
                    echo '<td>' . esc_html($cell_value) . '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
        }

        echo '</table>';
        echo '</div>';
    }
}
