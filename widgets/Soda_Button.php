<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;

if (!defined('ABSPATH')) exit;

class Soda_Button extends Widget_Base {

	public function get_name() {
		return 'soda-core-button';
	}

	public function get_title() {
		return esc_html__('Soda Button', 'soda-elementor-addons');
	}

	public function get_icon() {
		return 'eicon-button';
	}

	public function get_categories() {
		return ['soda-addons'];
	}

	public function get_style_depends() {
		return ['soda-button'];
	}

	protected function register_controls() {
		// General Section
		$this->start_controls_section(
			'basic',
			[
				'label' => esc_html__('General', 'soda-elementor-addons')
			]
		);

		$this->add_control(
			'button_title',
			[
				'label'   => esc_html__('Button Title', 'soda-elementor-addons'),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__('Click Here', 'soda-elementor-addons'),
				'dynamic' => ['active' => true],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__('Link', 'soda-elementor-addons'),
				'type'        => Controls_Manager::URL,
				'default'     => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
				'dynamic' => ['active' => true],
			]
		);

		$this->add_control(
			'button_size_elementor',
			[
				'label'   => esc_html__('Button Size', 'soda-elementor-addons'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'mini'   => esc_html__('Mini', 'soda-elementor-addons'),
					'small'  => esc_html__('Small', 'soda-elementor-addons'),
					'normal' => esc_html__('Normal', 'soda-elementor-addons'),
					'large'  => esc_html__('Large', 'soda-elementor-addons'),
					'custom' => esc_html__('Custom', 'soda-elementor-addons'),
				],
				'default' => 'normal',
			]
		);

		$this->add_responsive_control(
			'padding_size',
			[
				'label'      => esc_html__('Padding', 'soda-elementor-addons'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px'],
				'selectors'  => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type6' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type5 .soda_module_button__container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type2 .soda_module_button__container .soda_module_button__cover.front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type2 .soda_module_button__container .soda_module_button__cover.back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type1.btn_icon_position_left' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type1.btn_icon_position_left:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} calc({{LEFT}}{{UNIT}} + 15px);',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type1.btn_icon_position_right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .hover_type1.btn_icon_position_right:hover' => 'padding: {{TOP}}{{UNIT}} calc({{RIGHT}}{{UNIT}} + 15px) {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.size_custom .button_size_elementor_custom:not(.hover_type5)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'top'    => '0',
					'right'  => '0',
					'bottom' => '0',
					'left'   => '0',
				],
				'condition'  => [
					'button_size_elementor' => 'custom',
				],
			]
		);

		$this->add_control(
			'button_alignment',
			[
				'label'   => esc_html__('Alignment', 'soda-elementor-addons'),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__('Left', 'soda-elementor-addons'),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__('Center', 'soda-elementor-addons'),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__('Right', 'soda-elementor-addons'),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .soda_module_button_elementor' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_border_rounded',
			[
				'label'        => esc_html__('Rounded Corners', 'soda-elementor-addons'),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__('Yes', 'soda-elementor-addons'),
				'label_off'    => esc_html__('No', 'soda-elementor-addons'),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->end_controls_section();

		// Icon Section
		$this->start_controls_section(
			'icon_section',
			[
				'label' => esc_html__('Icon', 'soda-elementor-addons')
			]
		);

		$this->add_control(
			'btn_icon',
			[
				'label'   => esc_html__('Icon Type', 'soda-elementor-addons'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'    => esc_html__('None', 'soda-elementor-addons'),
					'icon'    => esc_html__('Icon', 'soda-elementor-addons'),
					'default' => esc_html__('Default Arrow', 'soda-elementor-addons'),
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'     => esc_html__('Icon', 'soda-elementor-addons'),
				'type'      => Controls_Manager::ICONS,
				'default'   => [
					'value'   => 'fas fa-arrow-right',
					'library' => 'fa-solid',
				],
				'condition' => [
					'btn_icon' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'   => esc_html__('Icon Position', 'soda-elementor-addons'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'  => esc_html__('Left', 'soda-elementor-addons'),
					'right' => esc_html__('Right', 'soda-elementor-addons'),
				],
				'default'   => 'left',
				'condition' => [
					'btn_icon!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'      => esc_html__('Icon Spacing', 'soda-elementor-addons'),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'size' => 8,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .btn_icon_position_left .elementor_btn_icon_container'  => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .btn_icon_position_right .elementor_btn_icon_container' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'btn_icon!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'icon_height',
			[
				'label'      => esc_html__('Icon Size', 'soda-elementor-addons'),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 1,
					'unit' => 'em',
				],
				'range'      => [
					'px'  => [
						'min'  => 8,
						'max'  => 64,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0.1,
						'max'  => 5,
						'step' => 0.1,
					],
					'rem' => [
						'min'  => 0.1,
						'max'  => 5,
						'step' => 0.1,
					],
				],
				'size_units' => ['px', 'em', 'rem'],
				'condition'  => [
					'btn_icon' => 'icon',
				],
				'selectors'  => [
					'{{WRAPPER}} .elementor_btn_icon_container' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_lh',
			[
				'label'      => esc_html__('Icon Line Height', 'soda-elementor-addons'),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 1,
					'unit' => 'em',
				],
				'range'      => [
					'px'  => [
						'min'  => 8,
						'max'  => 64,
						'step' => 1,
					],
					'em'  => [
						'min'  => 0.1,
						'max'  => 5,
						'step' => 0.1,
					],
					'rem' => [
						'min'  => 0.1,
						'max'  => 5,
						'step' => 0.1,
					],
				],
				'size_units' => ['px', 'em', 'rem'],
				'condition'  => [
					'btn_icon' => 'icon',
				],
				'selectors'  => [
					'{{WRAPPER}} .elementor_btn_icon_container' => 'line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_rotate',
			[
				'label'      => esc_html__('Icon Rotate', 'soda-elementor-addons'),
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 0,
				],
				'range'      => [
					'px' => [
						'min'  => -360,
						'max'  => 360,
						'step' => 1,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .elementor_btn_icon_container' => 'display: inline-block; transform: rotate({{SIZE}}deg);',
				],
				'condition'  => [
					'btn_icon!' => 'none',
				],
			]
		);

		$this->end_controls_section();

		// Hover Effect Section
		$this->start_controls_section(
			'hover_section',
			[
				'label' => esc_html__('Hover Effects', 'soda-elementor-addons')
			]
		);

		$this->add_control(
			'button_hover',
			[
				'label'   => esc_html__('Hover Effect', 'soda-elementor-addons'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'  => esc_html__('None', 'soda-elementor-addons'),
					'type1' => esc_html__('Slide', 'soda-elementor-addons'),
					'type2' => esc_html__('Flip', 'soda-elementor-addons'),
					'type3' => esc_html__('Sweep', 'soda-elementor-addons'),
					'type4' => esc_html__('Bounce', 'soda-elementor-addons'),
					'type5' => esc_html__('Fill', 'soda-elementor-addons'),
					'type6' => esc_html__('Reveal', 'soda-elementor-addons'),
				],
				'default' => 'none',
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__('Style', 'soda-elementor-addons'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}}.elementor-widget-soda-core-button .elementor_soda_btn_text',
			]
		);

		// Border Style Control
		$this->add_control(
			'btn_border_style',
			[
				'label'   => esc_html__('Border Style', 'soda-elementor-addons'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'none'   => esc_html__('None', 'soda-elementor-addons'),
					'solid'  => esc_html__('Solid', 'soda-elementor-addons'),
					'double' => esc_html__('Double', 'soda-elementor-addons'),
					'dotted' => esc_html__('Dotted', 'soda-elementor-addons'),
					'dashed' => esc_html__('Dashed', 'soda-elementor-addons'),
					'groove' => esc_html__('Groove', 'soda-elementor-addons'),
				],
				'default'   => 'solid',
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor:not(.hover_type2) a' => 'border-style: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type2 .soda_module_button__container span.soda_module_button__cover' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_border_rounded',
			[
				'label'     => esc_html__('Border Rounded', 'soda-elementor-addons'),
				'type'      => Controls_Manager::SWITCHER,

			]
		);

		$this->add_control(
			'btn_border_radius',
			[
				'label'   => esc_html__('Border Radius', 'soda-elementor-addons'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'unset' => esc_html__('None', 'soda-elementor-addons'),
					'1px'   => esc_html__('1px', 'soda-elementor-addons'),
					'2px'   => esc_html__('2px', 'soda-elementor-addons'),
					'3px'   => esc_html__('3px', 'soda-elementor-addons'),
					'4px'   => esc_html__('4px', 'soda-elementor-addons'),
					'5px'   => esc_html__('5px', 'soda-elementor-addons'),
					'10px'  => esc_html__('10px', 'soda-elementor-addons'),
					'15px'  => esc_html__('15px', 'soda-elementor-addons'),
					'20px'  => esc_html__('20px', 'soda-elementor-addons'),
					'25px'  => esc_html__('25px', 'soda-elementor-addons'),
					'30px'  => esc_html__('30px', 'soda-elementor-addons'),
					'35px'  => esc_html__('35px', 'soda-elementor-addons'),
					'40px'  => esc_html__('40px', 'soda-elementor-addons'),
					'45px'  => esc_html__('45px', 'soda-elementor-addons'),
					'50px'  => esc_html__('50px', 'soda-elementor-addons'),
				],
				'default'   => 'unset',
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.rounded a' => 'border-radius: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.rounded .hover_type2 .soda_module_button__container .soda_module_button__cover' => 'border-radius: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type4 .soda_module_button__cover:before' => 'border-radius: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type4 .soda_module_button__cover:after' => 'border-radius: {{VALUE}};',
				],
		
			]
		);

		$this->add_control(
			'btn_border_width',
			[
				'label'   => esc_html__('Border Width', 'soda-elementor-addons'),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'0'    => esc_html__('None', 'soda-elementor-addons'),
					'1px'  => esc_html__('1px', 'soda-elementor-addons'),
					'2px'  => esc_html__('2px', 'soda-elementor-addons'),
					'3px'  => esc_html__('3px', 'soda-elementor-addons'),
					'4px'  => esc_html__('4px', 'soda-elementor-addons'),
					'5px'  => esc_html__('5px', 'soda-elementor-addons'),
					'6px'  => esc_html__('6px', 'soda-elementor-addons'),
					'7px'  => esc_html__('7px', 'soda-elementor-addons'),
					'8px'  => esc_html__('8px', 'soda-elementor-addons'),
					'9px'  => esc_html__('9px', 'soda-elementor-addons'),
					'10px' => esc_html__('10px', 'soda-elementor-addons'),
				],
				'default'   => '1px',
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor a' => 'border-width: {{VALUE}} !important;',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor a.hover_type2 .soda_module_button__container .soda_module_button__cover' => 'border-width: {{VALUE}} !important;',
				],
				'condition' => [
					'btn_border_style!' => 'none',
				],
			]
		);

		$this->start_controls_tabs('style_tabs');

		// Normal State
		$this->start_controls_tab(
			'normal_tab',
			[
				'label' => esc_html__('Normal', 'soda-elementor-addons'),
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__('Icon Color', 'soda-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.button_icon_icon:not(.hover_type2) .elementor_soda_btn_icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .elementor-widget-soda-addon-advanced-button .soda_module_button_elementor.button_icon_icon a.hover_type2 .soda_module_button__cover.front .elementor_btn_icon_container .elementor_soda_btn_icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .icon_svg_btn' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_icon_default' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_title_color',
			[
				'label'     => esc_html__('Text Color', 'soda-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .elementor_soda_btn_text' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type2 .soda_module_button__container .soda_module_button__cover.front' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type4 .soda_module_button__container .soda_module_button__cover.front .elementor_soda_btn_text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_background_color',
				'label'    => esc_html__('Background', 'soda-elementor-addons'),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor:not(.hover_type2):not(.hover_type4):not(.hover_type5) a, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type2 .soda_module_button__container span.soda_module_button__cover.front, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type4 .soda_module_button__cover:before, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type5 .soda_module_button__container .soda_module_button__cover.front:before, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type5 .soda_module_button__container .soda_module_button__cover.front:after, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type6',
			]
		);

		$this->add_control(
			'border_color',
			[
				'label'     => esc_html__('Border Color', 'soda-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor:not(.hover_type2) a' => 'border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type2 .soda_module_button__container span.soda_module_button__cover.front' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'btn_border_style!' => 'none',
				],
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'hover_tab',
			[
				'label' => esc_html__('Hover', 'soda-elementor-addons'),
			]
		);

		$this->add_control(
			'icon_color_hover',
			[
				'label'     => esc_html__('Icon Color', 'soda-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor.button_icon_icon:not(.hover_type2) a:hover .elementor_soda_btn_icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type2 .soda_module_button__container span.soda_module_button__cover.back .elementor_btn_icon_container .elementor_soda_btn_icon' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button a:hover .icon_svg_btn' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button a:hover .soda_icon_default' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_title_color_hover',
			[
				'label'     => esc_html__('Text Color', 'soda-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button a:not(.hover_type2):hover .elementor_soda_btn_text' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type2 .soda_module_button__container .soda_module_button__cover.back .elementor_soda_btn_text' => 'color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type4:hover .soda_module_button__container .soda_module_button__cover.front .elementor_soda_btn_text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'button_background_color_hover',
				'label'    => esc_html__('Background', 'soda-elementor-addons'),
				'types'    => ['classic', 'gradient'],
				'selector' => '{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor:not(.hover_type2):not(.hover_type3):not(.hover_type4):not(.hover_type5):not(.hover_type6) a:hover, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type2 .soda_module_button__container span.soda_module_button__cover.back, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type3:after, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type4:hover .soda_module_button__cover:after, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type5 .soda_module_button__container .soda_module_button__cover.back:before, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type5 .soda_module_button__container .soda_module_button__cover.back:after, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type6:hover:before, {{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type6:hover:after',
			]
		);

		$this->add_control(
			'border_color_hover',
			[
				'label'     => esc_html__('Border Color', 'soda-elementor-addons'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor:not(.hover_type2) a:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}}.elementor-widget-soda-core-button .soda_module_button_elementor .hover_type2 .soda_module_button__container span.soda_module_button__cover.back' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'btn_border_style!' => 'none',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		// Set defaults for settings that might not be set
		$button_alignment = isset($settings['button_alignment']) ? $settings['button_alignment'] : 'center';

		$this->add_render_attribute('wrapper', 'class', [
			'soda_module_button_elementor',
			'size_' . $settings['button_size_elementor'],
			'button_icon_' . $settings['btn_icon'],
			'alignment_' . $button_alignment,
			'hover_' . $settings['button_hover'],
		]);

		if ($settings['btn_border_rounded'] === 'yes') {
			$this->add_render_attribute('wrapper', 'class', 'rounded');
		}

		$this->add_render_attribute('button', 'class', [
			'hover_' . $settings['button_hover'],
			'button_size_elementor_' . $settings['button_size_elementor'],
			'btn_icon_position_' . $settings['icon_position'],
		]);

		if (!empty($settings['link']['url'])) {
			$this->add_link_attributes('button', $settings['link']);
		}

		// Build icon HTML
		$icon_html = '';
		if ($settings['btn_icon'] === 'icon' && !empty($settings['button_icon']['value'])) {
			ob_start();
			\Elementor\Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']);
			$icon_html = '<span class="elementor_btn_icon_container">' . ob_get_clean() . '</span>';
		} elseif ($settings['btn_icon'] === 'default') {
			$icon_html = '<span class="elementor_btn_icon_container"><span class="elementor_soda_btn_icon soda_icon_default"></span></span>';
		}

		// Build text HTML
		$text_html = '';
		if (!empty($settings['button_title'])) {
			$text_html = '<span class="elementor_soda_btn_text">' . esc_html($settings['button_title']) . '</span>';
		}

		// Combine icon and text based on position
		if ($settings['icon_position'] === 'left') {
			$content = $icon_html . $text_html;
		} else {
			$content = $text_html . $icon_html;
		}

		?>
		<div <?php $this->print_render_attribute_string('wrapper'); ?>>
			<a <?php $this->print_render_attribute_string('button'); ?>>
				<span class="soda_module_button__container">
					<?php if ($settings['button_hover'] === 'type5') { ?>
						<?php echo $content; ?>
						<span class="soda_module_button__cover front"></span>
						<span class="soda_module_button__cover back"></span>
					<?php } else { ?>
						<span class="soda_module_button__cover front"><?php echo $content; ?></span>
						<?php if ($settings['button_hover'] === 'type2') { ?>
							<span class="soda_module_button__cover back"><?php echo $content; ?></span>
						<?php } ?>
					<?php } ?>
				</span>
			</a>
		</div>
		<?php
	}
}
