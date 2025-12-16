<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Icons_Manager;

if (!defined('ABSPATH')) {
    exit;
}

class Fullscreen_Toggle extends Widget_Base {

    public function get_name() {
        return 'soda_fullscreen_toggle';
    }

    public function get_title() {
        return esc_html__('Fullscreen Toggle', 'soda-elementor-addons');
    }

    public function get_icon() {
        return 'eicon-device-laptop';
    }

    public function get_categories() {
        return ['soda-addons'];
    }

    public function get_script_depends() {
        return ['soda-fullscreen-toggle'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'enter_label',
            [
                'label' => esc_html__('Enter Text', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Enter fullscreen', 'soda-elementor-addons'),
                'placeholder' => esc_html__('Enter fullscreen', 'soda-elementor-addons'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'exit_label',
            [
                'label' => esc_html__('Exit Text', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Exit fullscreen', 'soda-elementor-addons'),
                'placeholder' => esc_html__('Exit fullscreen', 'soda-elementor-addons'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'display_mode',
            [
                'label' => esc_html__('Display', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'text' => esc_html__('Text only', 'soda-elementor-addons'),
                    'icon' => esc_html__('Icon only', 'soda-elementor-addons'),
                    'both' => esc_html__('Icon & Text', 'soda-elementor-addons'),
                ],
                'default' => 'text',
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__('Icon', 'soda-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-expand',
                    'library' => 'solid',
                ],
                'condition' => [
                    'display_mode!' => 'text',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle' => 'text-align: {{VALUE}};',
                ],
                'default' => 'center',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .soda-fullscreen-toggle__button',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '12',
                    'right' => '24',
                    'bottom' => '12',
                    'left' => '24',
                    'unit' => 'px',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .soda-fullscreen-toggle__button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .soda-fullscreen-toggle__button',
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 96,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 6,
                        'step' => 0.1,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .soda-fullscreen-toggle__icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_mode!' => 'text',
                    'button_icon[value]!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__icon + .soda-fullscreen-toggle__label' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'display_mode' => 'both',
                    'button_icon[value]!' => '',
                ],
            ]
        );

        $this->start_controls_tabs('button_tabs');

        $this->start_controls_tab(
            'button_tab_normal',
            [
                'label' => esc_html__('Normal', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_tab_hover',
            [
                'label' => esc_html__('Hover', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__button:hover, {{WRAPPER}} .soda-fullscreen-toggle__button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color_hover',
            [
                'label' => esc_html__('Background Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__button:hover, {{WRAPPER}} .soda-fullscreen-toggle__button:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-fullscreen-toggle__button:hover, {{WRAPPER}} .soda-fullscreen-toggle__button:focus' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $enter_label = $settings['enter_label'] !== '' ? $settings['enter_label'] : esc_html__('Enter fullscreen', 'soda-elementor-addons');
        $exit_label = $settings['exit_label'] !== '' ? $settings['exit_label'] : esc_html__('Exit fullscreen', 'soda-elementor-addons');
        $display_mode = isset($settings['display_mode']) ? $settings['display_mode'] : 'text';
        $allowed_modes = ['text', 'icon', 'both'];

        if (!in_array($display_mode, $allowed_modes, true)) {
            $display_mode = 'text';
        }

        $icon_settings = isset($settings['button_icon']) && is_array($settings['button_icon']) ? $settings['button_icon'] : [];
        $has_icon = !empty($icon_settings['value']);
        $show_icon = $display_mode !== 'text' && $has_icon;
        $show_label = $display_mode !== 'icon';

        $this->add_render_attribute('wrapper', 'class', 'soda-fullscreen-toggle');
        $this->add_render_attribute('button', 'class', 'soda-fullscreen-toggle__button');
        $this->add_render_attribute('button', 'class', $show_icon ? 'has-icon' : 'no-icon');
        $this->add_render_attribute('button', 'class', $show_label ? 'has-label' : 'no-label');
        $this->add_render_attribute('button', 'class', 'display-' . $display_mode);
        $this->add_render_attribute('button', 'type', 'button');
        $this->add_render_attribute('button', 'data-enter-text', $enter_label);
        $this->add_render_attribute('button', 'data-exit-text', $exit_label);
        $this->add_render_attribute('button', 'data-display', $display_mode);
        $this->add_render_attribute('button', 'aria-pressed', 'false');
        $this->add_render_attribute('button', 'aria-controls', 'document');
        $this->add_render_attribute('button', 'aria-label', $enter_label);

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <button <?php echo $this->get_render_attribute_string('button'); ?>>
                <?php if ($show_icon) : ?>
                    <span class="soda-fullscreen-toggle__icon" aria-hidden="true">
                        <?php Icons_Manager::render_icon($icon_settings, ['aria-hidden' => 'true']); ?>
                    </span>
                <?php endif; ?>

                <?php if ($show_label) : ?>
                    <span class="soda-fullscreen-toggle__label"><?php echo esc_html($enter_label); ?></span>
                <?php endif; ?>
            </button>
        </div>
        <?php
    }
}
