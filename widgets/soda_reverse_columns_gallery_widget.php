<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Reverse Columns Gallery Widget
 *
 * @since 2.3.0
 */
class Reverse_Columns_Gallery_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 2.3.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'soda-reverse-columns-gallery';
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
		return __( 'Reverse Columns Gallery', 'soda-addons' );
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
		return 'eicon-gallery-grid';
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
		return [ 'soda-reverse-columns-gallery' ];
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

		// Build post type options
		$post_types = get_post_types( [ 'public' => true ], 'objects' );
		$options = [];
		foreach ( $post_types as $pt_slug => $pt_obj ) {
			if ( 'attachment' === $pt_slug ) {
				continue;
			}
			$options[ $pt_slug ] = $pt_obj->labels->singular_name ?: $pt_slug;
		}

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Post Type', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $options,
				'default' => key( $options ) ?: 'post',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'2' => __( '2 Columns', 'soda-addons' ),
					'3' => __( '3 Columns', 'soda-addons' ),
					'4' => __( '4 Columns', 'soda-addons' ),
				],
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
			]
		);

		$this->add_control(
			'number_of_items',
			[
				'label' => __( 'Number of Items', 'soda-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 50,
				'step' => 1,
				'default' => 10,
				'description' => __( 'Same items will appear in all columns', 'soda-addons' ),
			]
		);

		$this->add_control(
			'reverse_odd_columns',
			[
				'label' => __( 'Reverse Odd Columns', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'soda-addons' ),
				'label_off' => __( 'No', 'soda-addons' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => __( 'Reverse odd (1st, 3rd, ...) columns', 'soda-addons' ),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'date' => __( 'Date', 'soda-addons' ),
					'title' => __( 'Title', 'soda-addons' ),
					'rand' => __( 'Random', 'soda-addons' ),
					'menu_order' => __( 'Menu Order', 'soda-addons' ),
					'modified' => __( 'Last Modified', 'soda-addons' ),
					'ID' => __( 'Post ID', 'soda-addons' ),
				],
				'default' => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'DESC' => __( 'Descending', 'soda-addons' ),
					'ASC' => __( 'Ascending', 'soda-addons' ),
				],
				'default' => 'DESC',
				'condition' => [
					'orderby!' => 'rand',
				],
			]
		);

		$this->add_control(
			'column_ordering',
			[
				'label' => __( 'Column Ordering', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'same' => __( 'Same (All Columns Identical)', 'soda-addons' ),
					'random_per_column' => __( 'Random Order Per Column', 'soda-addons' ),
					'reverse_per_column' => __( 'Reverse Order Per Column', 'soda-addons' ),
				],
				'default' => 'same',
				'description' => __( 'Same: All columns show items in identical order from top to bottom. Random: Each column shuffles items differently. Reverse: Each column shows items in reverse order.', 'soda-addons' ),
			]
		);

		$this->end_controls_section();

		// Layout Section
		$this->start_controls_section(
			'layout_section',
			[
				'label' => __( 'Layout', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => __( 'Column Gap', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery' => '--soda-grid-col-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => __( 'Row Gap', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery' => '--soda-grid-row-gap: {{SIZE}}{{UNIT}}; --soda-item-row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'label' => __( 'Padding', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => 20,
					'right' => 20,
					'bottom' => 20,
					'left' => 20,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Title Section
		$this->start_controls_section(
			'title_section',
			[
				'label' => __( 'Title', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'soda-addons' ),
				'label_off' => __( 'Hide', 'soda-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'title_position',
			[
				'label' => __( 'Title Position', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'above' => __( 'Above Image', 'soda-addons' ),
					'below' => __( 'Below Image', 'soda-addons' ),
					'overlay' => __( 'Overlay', 'soda-addons' ),
				],
				'default' => 'below',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'title_tag',
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
				],
				'default' => 'h3',
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Image Style Section
		$this->start_controls_section(
			'image_style_section',
			[
				'label' => __( 'Image Style', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => __( 'Image Width', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-item img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_aspect_ratio',
			[
				'label' => __( 'Aspect Ratio', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '1/1.5',
				'description' => __( 'E.g. 1/1.5, 3/2, 16/9', 'soda-addons' ),
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-item img' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_object_fit',
			[
				'label' => __( 'Object Fit', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'cover' => __( 'Cover', 'soda-addons' ),
					'contain' => __( 'Contain', 'soda-addons' ),
					'fill' => __( 'Fill', 'soda-addons' ),
					'none' => __( 'None', 'soda-addons' ),
				],
				'default' => 'cover',
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-item img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_object_position',
			[
				'label' => __( 'Object Position', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'center',
				'description' => __( 'E.g. center, top left, bottom right', 'soda-addons' ),
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-item img' => 'object-position: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' => [
					'top' => 12,
					'right' => 12,
					'bottom' => 12,
					'left' => 12,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hover_zoom',
			[
				'label' => __( 'Hover Zoom', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'soda-addons' ),
				'label_off' => __( 'No', 'soda-addons' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'hover_zoom_scale',
			[
				'label' => __( 'Zoom Scale', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 1.0,
						'max' => 1.6,
						'step' => 0.01,
					],
				],
				'default' => [
					'size' => 1.08,
				],
				'condition' => [
					'hover_zoom' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-item' => '--soda-zoom-scale: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();

		// Title Style Section
		$this->start_controls_section(
			'title_style_section',
			[
				'label' => __( 'Title Style', 'soda-addons' ),
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
				'label' => __( 'Typography', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-reverse-columns-gallery .soda-image-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-image-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_align',
			[
				'label' => __( 'Alignment', 'soda-addons' ),
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
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-image-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'soda-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-reverse-columns-gallery .soda-image-title' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 2.3.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$post_type = sanitize_text_field( $settings['post_type'] );
		$columns = max( 1, (int) $settings['columns'] );
		$number_of_items = max( 1, (int) $settings['number_of_items'] );
		$reverse_odd = ( 'yes' === $settings['reverse_odd_columns'] );
		$orderby = ! empty( $settings['orderby'] ) ? $settings['orderby'] : 'date';
		$order = ! empty( $settings['order'] ) ? $settings['order'] : 'DESC';
		$column_ordering = ! empty( $settings['column_ordering'] ) ? $settings['column_ordering'] : 'same';

		$query_args = [
			'post_type' => $post_type,
			'posts_per_page' => $number_of_items,
			'post_status' => 'publish',
			'orderby' => $orderby,
			'order' => $order,
		];

		$q = new \WP_Query( $query_args );
		$posts = $q->posts;

		$show_title = ( 'yes' === $settings['show_title'] );
		$title_tag = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h3';
		$title_position = ! empty( $settings['title_position'] ) ? $settings['title_position'] : 'below';

		$hover_zoom = ( 'yes' === $settings['hover_zoom'] );

		$this->add_render_attribute( 'wrapper', 'class', 'soda-reverse-columns-gallery' );
		$this->add_render_attribute( 'wrapper', 'style', 'grid-template-columns: repeat(' . intval( $columns ) . ', 1fr);' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php
			for ( $i = 0; $i < $columns; $i++ ) {
				$apply_reverse = $reverse_odd && ( 0 === $i % 2 );
				
				// Create column-specific ordering
				$column_posts = $posts;
				if ( 'random_per_column' === $column_ordering ) {
					shuffle( $column_posts );
				} elseif ( 'reverse_per_column' === $column_ordering ) {
					$column_posts = array_reverse( $column_posts );
				}
				
				// When ordering is 'same', apply flex-direction to match visual order with scroll
				$column_class = 'soda-column';
				$inline_style = '';
				if ( 'same' === $column_ordering && $apply_reverse ) {
					$column_class .= ' soda-column-reverse';
					$inline_style = ' style="flex-direction: column;"';
				} elseif ( $apply_reverse ) {
					$column_class .= ' soda-column-reverse';
				}
				
				?>
				<div class="<?php echo esc_attr( $column_class ); ?>"<?php echo $inline_style; ?>>
					<?php
					foreach ( $column_posts as $post ) {
						$img = get_the_post_thumbnail_url( $post->ID, 'large' );
						if ( ! $img ) {
							$attachments = get_attached_media( 'image', $post->ID );
							if ( ! empty( $attachments ) ) {
								$first = reset( $attachments );
								$img = wp_get_attachment_image_url( $first->ID, 'large' );
							}
						}
						if ( $img ) {
							$wrapper_classes = 'soda-item';
							if ( $hover_zoom ) {
								$wrapper_classes .= ' soda-hover-zoom';
							}
							$title = $show_title ? get_the_title( $post->ID ) : '';
							$permalink = get_permalink( $post->ID );
							
							// Get custom field for title color
							$title_color_field = get_post_meta( $post->ID, 'portfolio_title_color', true );
							// Default to 'light' if not set
							$title_color_field = ! empty( $title_color_field ) ? $title_color_field : 'light';
							
							$title_color_class = ' title-' . strtolower( sanitize_html_class( $title_color_field ) );
							$title_color_attr = ' data-title-color="' . esc_attr( $title_color_field ) . '"';
							?>
							<a href="<?php echo esc_url( $permalink ); ?>" class="<?php echo esc_attr( $wrapper_classes ); ?>"<?php echo $title_color_attr; ?>>
								<?php
								if ( $show_title && 'above' === $title_position ) {
									printf( '<%1$s class="soda-image-title%2$s">%3$s</%1$s>', esc_attr( $title_tag ), esc_attr( $title_color_class ), esc_html( $title ) );
								}

								echo '<img src="' . esc_url( $img ) . '" alt="' . esc_attr( get_the_title( $post->ID ) ) . '" />';

								if ( $show_title && 'below' === $title_position ) {
									printf( '<%1$s class="soda-image-title%2$s">%3$s</%1$s>', esc_attr( $title_tag ), esc_attr( $title_color_class ), esc_html( $title ) );
								}

								if ( $show_title && 'overlay' === $title_position ) {
									printf( '<div class="soda-title-overlay"><%1$s class="soda-image-title%2$s">%3$s</%1$s></div>', esc_attr( $title_tag ), esc_attr( $title_color_class ), esc_html( $title ) );
								}
								?>
							</a>
							<?php
						}
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
		wp_reset_postdata();
	}
}
