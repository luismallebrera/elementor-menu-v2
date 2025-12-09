<?php
namespace SodaAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Image_Pan_Zoom_Widget extends Widget_Base {

	public function get_name() {
		return 'soda-image-pan-zoom';
	}

	public function get_title() {
		return __( 'Image Pan & Zoom', 'soda-addons' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'soda-addons' ];
	}

	public function get_keywords() {
		return [ 'image', 'map', 'zoom', 'pan', 'interactive' ];
	}

	public function get_script_depends() {
		return [ 'soda-image-pan-zoom' ];
	}

	public function get_style_depends() {
		return [ 'soda-image-pan-zoom' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Image', 'soda-addons' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image',
				'default' => 'full',
				'exclude' => [],
			]
		);

		$this->add_control(
			'enable_controls',
			[
				'label' => __( 'Show Zoom Controls', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'enable_mouse_wheel',
			[
				'label' => __( 'Enable Mouse Wheel Zoom', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'enable_drag',
			[
				'label' => __( 'Enable Drag to Pan', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'initial_zoom',
			[
				'label' => __( 'Initial Zoom', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [],
				'range' => [
					'px' => [
						' min' => 0.5,
						' max' => 3,
						' step' => 0.1,
					],
				],
				'default' => [
					'size' => 1,
				],
			]
		);

		$this->add_control(
			'min_zoom',
			[
				'label' => __( 'Minimum Zoom', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [],
				'range' => [
					'px' => [
						' min' => 0.1,
						' max' => 1,
						' step' => 0.05,
					],
				],
				'default' => [
					'size' => 1,
				],
			]
		);

		$this->add_control(
			'max_zoom',
			[
				'label' => __( 'Maximum Zoom', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [],
				'range' => [
					'px' => [
						' min' => 1,
						' max' => 6,
						' step' => 0.1,
					],
				],
				'default' => [
					'size' => 3,
				],
			]
		);

		$this->add_control(
			'zoom_step',
			[
				'label' => __( 'Zoom Step', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [],
				'range' => [
					'px' => [
						' min' => 0.05,
						' max' => 1,
						' step' => 0.05,
					],
				],
				'default' => [
					'size' => 0.2,
				],
			]
		);

		$this->add_responsive_control(
			'viewport_height',
			[
				'label' => __( 'Viewport Height', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range' => [
					'px' => [
						' min' => 100,
						' max' => 1200,
						' step' => 10,
					],
					'vh' => [
						' min' => 20,
						' max' => 100,
						' step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 400,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-image-pan-zoom__viewport' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'container_style_section',
			[
				'label' => __( 'Container', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'container_background',
				'selector' => '{{WRAPPER}} .soda-image-pan-zoom',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'container_border',
				'selector' => '{{WRAPPER}} .soda-image-pan-zoom',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'container_shadow',
				'selector' => '{{WRAPPER}} .soda-image-pan-zoom',
			]
		);

		$this->add_responsive_control(
			'container_radius',
			[
				'label' => __( 'Border Radius', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-image-pan-zoom' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => __( 'Padding', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-image-pan-zoom' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'controls_style_section',
			[
				'label' => __( 'Zoom Controls', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'enable_controls' => 'yes',
				],
			]
		);

		$this->add_control(
			'controls_alignment',
			[
				'label' => __( 'Alignment', 'soda-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top-left' => [
						'title' => __( 'Top Left', 'soda-addons' ),
						'icon' => 'eicon-h-align-left',
					],
					'top-right' => [
						'title' => __( 'Top Right', 'soda-addons' ),
						'icon' => 'eicon-h-align-right',
					],
					'bottom-left' => [
						'title' => __( 'Bottom Left', 'soda-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
					'bottom-right' => [
						'title' => __( 'Bottom Right', 'soda-addons' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'default' => 'top-right',
			]
		);

		$this->add_responsive_control(
			'controls_offset_x',
			[
				'label' => __( 'Offset X', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						' min' => -100,
						' max' => 100,
						' step' => 1,
					],
				],
				'default' => [
					'size' => 12,
				],
			]
		);

		$this->add_responsive_control(
			'controls_offset_y',
			[
				'label' => __( 'Offset Y', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						' min' => -100,
						' max' => 100,
						' step' => 1,
					],
				],
				'default' => [
					'size' => 12,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'controls_typography',
				'selector' => '{{WRAPPER}} .soda-image-pan-zoom__button',
			]
		);

		$this->add_control(
			'controls_text_color',
			[
				'label' => __( 'Icon Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .soda-image-pan-zoom__button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'controls_background',
				'selector' => '{{WRAPPER}} .soda-image-pan-zoom__button',
			]
		);

		$this->add_control(
			'controls_background_hover',
			[
				'label' => __( 'Background Hover', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .soda-image-pan-zoom__button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'controls_border',
				'selector' => '{{WRAPPER}} .soda-image-pan-zoom__button',
			]
		);

		$this->add_responsive_control(
			'controls_radius',
			[
				'label' => __( 'Border Radius', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-image-pan-zoom__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'controls_padding',
			[
				'label' => __( 'Padding', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-image-pan-zoom__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'controls_gap',
			[
				'label' => __( 'Spacing', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						' min' => 0,
						' max' => 40,
						' step' => 1,
					],
				],
				'default' => [
					'size' => 6,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-image-pan-zoom__controls' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$image_data = isset( $settings['image'] ) ? $settings['image'] : [];
		$image_id = isset( $image_data['id'] ) ? (int) $image_data['id'] : 0;

		$image_url = '';
		if ( $image_id ) {
			$image_url = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image', $settings );
			if ( ! $image_url ) {
				$image_url = wp_get_attachment_image_url( $image_id, 'full' );
			}
		} elseif ( ! empty( $image_data['url'] ) ) {
			$image_url = $image_data['url'];
		}

		if ( ! $image_url ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="soda-image-pan-zoom__message">' . esc_html__( 'Select an image to enable pan and zoom.', 'soda-addons' ) . '</div>';
			}
			return;
		}

		$alt = '';
		if ( $image_id ) {
			$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		}
		if ( '' === $alt && ! empty( $image_data['alt'] ) ) {
			$alt = $image_data['alt'];
		}

		$min_zoom = isset( $settings['min_zoom']['size'] ) ? (float) $settings['min_zoom']['size'] : 1.0;
		$max_zoom = isset( $settings['max_zoom']['size'] ) ? (float) $settings['max_zoom']['size'] : 3.0;
		$initial_zoom = isset( $settings['initial_zoom']['size'] ) ? (float) $settings['initial_zoom']['size'] : 1.0;
		$zoom_step = isset( $settings['zoom_step']['size'] ) ? (float) $settings['zoom_step']['size'] : 0.2;

		if ( $min_zoom <= 0 ) {
			$min_zoom = 0.1;
		}
		if ( $max_zoom <= $min_zoom ) {
			$max_zoom = $min_zoom + 0.5;
		}
		$initial_zoom = min( max( $initial_zoom, $min_zoom ), $max_zoom );
		$zoom_step = max( 0.05, $zoom_step );

		$enable_controls = isset( $settings['enable_controls'] ) ? ( 'yes' === $settings['enable_controls'] ) : true;
		$enable_mouse_wheel = isset( $settings['enable_mouse_wheel'] ) ? ( 'yes' === $settings['enable_mouse_wheel'] ) : true;
		$enable_drag = isset( $settings['enable_drag'] ) ? ( 'yes' === $settings['enable_drag'] ) : true;

		$controls_alignment = isset( $settings['controls_alignment'] ) ? $settings['controls_alignment'] : 'top-right';
		$offset_x = isset( $settings['controls_offset_x']['size'] ) ? (int) $settings['controls_offset_x']['size'] : 12;
		$offset_y = isset( $settings['controls_offset_y']['size'] ) ? (int) $settings['controls_offset_y']['size'] : 12;

		$alignment_class = 'is-controls-' . sanitize_html_class( $controls_alignment );

		$this->add_render_attribute( 'wrapper', 'class', [ 'soda-image-pan-zoom', $alignment_class ] );
		$this->add_render_attribute( 'wrapper', 'data-min-zoom', $min_zoom );
		$this->add_render_attribute( 'wrapper', 'data-max-zoom', $max_zoom );
		$this->add_render_attribute( 'wrapper', 'data-initial-zoom', $initial_zoom );
		$this->add_render_attribute( 'wrapper', 'data-zoom-step', $zoom_step );
		$this->add_render_attribute( 'wrapper', 'data-enable-wheel', $enable_mouse_wheel ? 'true' : 'false' );
		$this->add_render_attribute( 'wrapper', 'data-enable-drag', $enable_drag ? 'true' : 'false' );
		$this->add_render_attribute( 'wrapper', 'tabindex', '0' );

		$controls_styles = sprintf( 'style="%s"', esc_attr( $this->get_controls_position_style( $controls_alignment, $offset_x, $offset_y ) ) );
		$controls_classes = 'soda-image-pan-zoom__controls';
		if ( ! $enable_controls ) {
			$controls_classes .= ' is-hidden';
		}

		$img_attr = [
			'src' => esc_url( $image_url ),
			'alt' => esc_attr( $alt ),
			'draggable' => 'false',
		];

		$img_html = '<img';
		foreach ( $img_attr as $key => $value ) {
			if ( '' === $value && 'alt' === $key ) {
				continue;
			}
			$img_html .= ' ' . $key . '="' . $value . '"';
		}
		$img_html .= ' />';

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div class="soda-image-pan-zoom__viewport">
				<div class="soda-image-pan-zoom__inner">
					<?php echo $img_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			</div>
			<div class="<?php echo esc_attr( $controls_classes ); ?>" <?php echo $controls_styles; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<button type="button" class="soda-image-pan-zoom__button" data-action="zoom-in" aria-label="<?php esc_attr_e( 'Zoom in', 'soda-addons' ); ?>">+</button>
				<button type="button" class="soda-image-pan-zoom__button" data-action="zoom-out" aria-label="<?php esc_attr_e( 'Zoom out', 'soda-addons' ); ?>">-</button>
			</div>
		</div>
		<?php
	}

	private function get_controls_position_style( $alignment, $offset_x, $offset_y ) {
		$top = 'auto';
		$right = 'auto';
		$bottom = 'auto';
		$left = 'auto';

		switch ( $alignment ) {
			case 'top-left':
				$top = $offset_y . 'px';
				$left = $offset_x . 'px';
				break;
			case 'bottom-left':
				$bottom = $offset_y . 'px';
				$left = $offset_x . 'px';
				break;
			case 'bottom-right':
				$bottom = $offset_y . 'px';
				$right = $offset_x . 'px';
				break;
			case 'top-right':
			default:
				$top = $offset_y . 'px';
				$right = $offset_x . 'px';
				break;
		}

		return sprintf( 'top:%s; right:%s; bottom:%s; left:%s;', $top, $right, $bottom, $left );
	}
}
