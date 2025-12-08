<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Arrow Button Widget
 *
 * @since 2.3.0
 */
class Arrow_Button_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 2.3.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'soda-arrow-button';
	}

	/**
	 * Get widget title.
	 *
	 * @since 2.3.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Arrow Button', 'soda-addons' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 2.3.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-button';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 2.3.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'soda-addons' ];
	}

	/**
	 * Get style depends.
	 *
	 * @since 2.3.0
	 * @access public
	 *
	 * @return array Style dependencies.
	 */
	public function get_style_depends() {
		return [ 'soda-arrow-button' ];
	}

	/**
	 * Register widget controls.
	 *
	 * @since 2.3.0
	 * @access protected
	 */
	protected function register_controls() {
		
		// Content Section
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'soda-addons' ),
				'placeholder' => __( 'Type your text here', 'soda-addons' ),
			]
		);

		$this->add_control(
			'include_swap_text',
			[
				'label' => __( 'Include Swap Text', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'swap_text',
			[
				'label' => __( 'Swap Text', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Go Now', 'soda-addons' ),
				'placeholder' => __( 'Type your swap text here', 'soda-addons' ),
				'condition' => [ 'include_swap_text' => 'yes' ],
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label' => __( 'HTML Tag', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'span',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'soda-addons' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'soda-addons' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->end_controls_section();

		// Arrow Styles Section
		$this->start_controls_section(
			'arrow_styles',
			[
				'label' => __( 'Arrow Styles', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrow_type',
			[
				'label' => __( 'Arrow Type', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'type1' => __( 'Type 1', 'soda-addons' ),
					'type2' => __( 'Type 2', 'soda-addons' ),
					'type3' => __( 'Type 3', 'soda-addons' ),
					'type4' => __( 'Type 4', 'soda-addons' ),
					'type5' => __( 'Type 5', 'soda-addons' ),
				],
				'default' => 'type1',
			]
		);

		$this->add_control(
			'arrow_position',
			[
				'label' => __( 'Arrow Position', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'row' => __( 'Left', 'soda-addons' ),
					'row-reverse' => __( 'Right', 'soda-addons' ),
				],
				'default' => 'row-reverse',
			]
		);

		$this->add_responsive_control(
			'arrow_size',
			[
				'label' => __( 'Arrow Size', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 200,
						'step' => 1,
					],
					'em' => [
						'min' => 1,
						'max' => 20,
						'step' => 0.1,
					],
					'rem' => [
						'min' => 1,
						'max' => 20,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__circle' => '--dimensions: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_rotation',
			[
				'label' => __( 'Arrow Rotation', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range' => [
					'deg' => [
						'min' => -360,
						'max' => 360,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'deg',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__arrow' => 'rotate: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_weight',
			[
				'label' => __( 'Arrow Weight', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0.5,
						'max' => 5,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 1.5,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__arrow' => 'stroke-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_color',
			[
				'label' => __( 'Arrow Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__circle' => '--fill: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'arrow_background',
				'label' => __( 'Arrow Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-arrow-button__circle',
			]
		);

		$this->add_responsive_control(
			'arrow_padding',
			[
				'label' => __( 'Arrow Padding', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__circle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'arrow_border',
				'label' => __( 'Arrow Border', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-arrow-button__circle',
			]
		);

		$this->add_responsive_control(
			'arrow_border_radius',
			[
				'label' => __( 'Arrow Border Radius', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Arrow Animation Section
		$this->start_controls_section(
			'arrow_animation',
			[
				'label' => __( 'Arrow Animation', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'arrow_scale',
			[
				'label' => __( 'Arrow Scale', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0.5,
						'max' => 2,
						'step' => 0.1,
					],
				],
				'default' => [
					'size' => 1.2,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__circle' => '--scale: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'arrow_distance',
			[
				'label' => __( 'Arrow Distance', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
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
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__circle' => '--arrow-distance: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_duration',
			[
				'label' => __( 'Arrow Duration', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's', 'ms' ],
				'range' => [
					's' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.1,
					],
					'ms' => [
						'min' => 0,
						'max' => 3000,
						'step' => 100,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => 0.3,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__circle' => '--transitionduration: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_ease',
			[
				'label' => __( 'Arrow Easing', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ease' => __( 'Ease', 'soda-addons' ),
					'linear' => __( 'Linear', 'soda-addons' ),
					'ease-in' => __( 'Ease In', 'soda-addons' ),
					'ease-out' => __( 'Ease Out', 'soda-addons' ),
					'ease-in-out' => __( 'Ease In Out', 'soda-addons' ),
					'cubic-bezier(0.68, -0.55, 0.265, 1.55)' => __( 'Back', 'soda-addons' ),
					'cubic-bezier(0.175, 0.885, 0.32, 1.275)' => __( 'Elastic', 'soda-addons' ),
					'cubic-bezier(0.6, -0.28, 0.735, 0.045)' => __( 'Custom 1', 'soda-addons' ),
				],
				'default' => 'ease',
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__circle' => '--ease: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Swap Animation Section
		$this->start_controls_section(
			'swap_animation',
			[
				'label' => __( 'Swap Animation', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'swap_duration',
			[
				'label' => __( 'Swap Duration', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 's', 'ms' ],
				'range' => [
					's' => [
						'min' => 0,
						'max' => 3,
						'step' => 0.1,
					],
					'ms' => [
						'min' => 0,
						'max' => 3000,
						'step' => 100,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => 0.3,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__title' => '--transitiondurationswap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swap_ease',
			[
				'label' => __( 'Swap Easing', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'ease' => __( 'Ease', 'soda-addons' ),
					'linear' => __( 'Linear', 'soda-addons' ),
					'ease-in' => __( 'Ease In', 'soda-addons' ),
					'ease-out' => __( 'Ease Out', 'soda-addons' ),
					'ease-in-out' => __( 'Ease In Out', 'soda-addons' ),
					'cubic-bezier(0.68, -0.55, 0.265, 1.55)' => __( 'Back', 'soda-addons' ),
					'cubic-bezier(0.175, 0.885, 0.32, 1.275)' => __( 'Elastic', 'soda-addons' ),
					'cubic-bezier(0.6, -0.28, 0.735, 0.045)' => __( 'Custom 1', 'soda-addons' ),
				],
				'default' => 'ease',
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__title' => '--easeswap: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Button Style Section
		$this->start_controls_section(
			'button_style',
			[
				'label' => __( 'Button Style', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'button_background',
				'label' => __( 'Button Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-arrow-button, {{WRAPPER}} .soda-arrow-button__anchor',
			]
		);

		$this->add_responsive_control(
			'button_gap',
			[
				'label' => __( 'Button Gap', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
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
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__anchor' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Button Padding', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button, {{WRAPPER}} .soda-arrow-button__anchor' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'label' => __( 'Button Border', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-arrow-button, {{WRAPPER}} .soda-arrow-button__anchor',
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label' => __( 'Button Border Radius', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button, {{WRAPPER}} .soda-arrow-button__anchor' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Label Style Section
		$this->start_controls_section(
			'label_style',
			[
				'label' => __( 'Label Style', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Label Typography', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-arrow-button__title',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Label Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_align',
			[
				'label' => __( 'Label Align', 'soda-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'soda-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'soda-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'soda-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button__title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'label_background',
				'label' => __( 'Label Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-arrow-button_title-wrapper',
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label' => __( 'Label Padding', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-arrow-button_title-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get SVG arrows based on type.
	 *
	 * @since 2.3.0
	 * @access private
	 *
	 * @param string $type Arrow type.
	 * @return string SVG markup with both left and right arrows.
	 */
	private function get_arrow_svg( $type ) {
		$arrows = [
			'type1' => [
				'left' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z"/></svg>',
				'right' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z"/></svg>'
			],
			'type2' => [
				'left' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z"/></svg>',
				'right' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.293 4.707 17.586 11H4v2h13.586l-6.293 6.293 1.414 1.414L21.414 12l-8.707-8.707-1.414 1.414z"/></svg>'
			],
			'type3' => [
				'left' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>',
				'right' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>'
			],
			'type4' => [
				'left' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z"/></svg>',
				'right' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z"/></svg>'
			],
			'type5' => [
				'left' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-left soda-arrow-button__arrow--fancy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" style="fill: none !important"><path d="M0.985771 9.98158L19.9713 9.98162" stroke-miterlimit="10"/><path d="M19.6589 9.97797C15.1624 9.978 11.5176 6.33315 11.5176 1.83661" stroke-miterlimit="10"/><path d="M11.5174 18.1213C11.5175 13.6248 15.1623 9.97997 19.6588 9.97995" stroke-miterlimit="10"/></svg>',
				'right' => '<svg class="soda-arrow-button__arrow soda-arrow-button__arrow-right soda-arrow-button__arrow--fancy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" style="fill: none !important"><path d="M0.985771 9.98158L19.9713 9.98162" stroke-miterlimit="10"/><path d="M19.6589 9.97797C15.1624 9.978 11.5176 6.33315 11.5176 1.83661" stroke-miterlimit="10"/><path d="M11.5174 18.1213C11.5175 13.6248 15.1623 9.97997 19.6588 9.97995" stroke-miterlimit="10"/></svg>'
			]
		];

		return isset( $arrows[ $type ] ) ? $arrows[ $type ]['left'] . $arrows[ $type ]['right'] : $arrows['type1']['left'] . $arrows['type1']['right'];
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 2.3.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$text = isset( $settings['text'] ) ? $settings['text'] : '';
		$swap_text = isset( $settings['swap_text'] ) ? $settings['swap_text'] : '';
		$html_tag = ! empty( $settings['html_tag'] ) ? $settings['html_tag'] : 'div';
		$arrow_type = ! empty( $settings['arrow_type'] ) ? $settings['arrow_type'] : 'type1';
		$arrow_position = ! empty( $settings['arrow_position'] ) ? $settings['arrow_position'] : 'row-reverse';
		$include_swap = $settings['include_swap_text'] === 'yes';
		$link = $settings['link'] ?? [];

		$wrapper_tag = $html_tag;
		$use_link = ( ! empty( $link['url'] ) );

		$this->add_render_attribute( 'wrapper', 'class', 'soda-arrow-button' );
		$this->add_render_attribute( 'wrapper', 'data-swap', $include_swap ? 'enable' : 'disable' );

		if ( $use_link ) {
			$wrapper_tag = 'a';
			$this->add_link_attributes( 'wrapper', $link );
			$this->add_render_attribute( 'wrapper', 'class', 'soda-arrow-button__anchor' );
		}

		$arrow_svg = $this->get_arrow_svg( $arrow_type );

		?>
		<<?php echo esc_attr( $wrapper_tag ); ?> <?php $this->print_render_attribute_string( 'wrapper' ); ?> style="flex-direction: <?php echo esc_attr( $arrow_position ); ?>;">
			<div class='soda-arrow-button__circle'>
				<?php echo $arrow_svg; ?>
			</div>
			<div class='soda-arrow-button_title-wrapper'>
				<div class='soda-arrow-button_title-wrap'>
					<div class='soda-arrow-button__title' data-content="<?php echo esc_attr( $swap_text ); ?>"><?php echo esc_html( $text ); ?></div>
				</div>
			</div>
		</<?php echo esc_attr( $wrapper_tag ); ?>>
		<?php
	}
}
