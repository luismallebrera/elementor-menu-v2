<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Taxonomy List Widget
 *
 * @since 2.3.0
 */
class Taxonomy_List_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * @since 2.3.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'soda-taxonomy-list';
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
		return __( 'Taxonomy List', 'soda-addons' );
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
		return 'eicon-bullet-list';
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
	 * Get widget keywords.
	 *
	 * @since 2.3.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'taxonomy', 'category', 'tag', 'terms', 'list', 'custom post type' ];
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
			'taxonomy',
			[
				'label' => __( 'Taxonomy', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_taxonomies_options(),
				'default' => 'category',
				'description' => __( 'Select the taxonomy to display. Supports custom taxonomies.', 'soda-addons' ),
			]
		);

		$this->add_control(
			'selected_terms',
			[
				'label' => __( 'Select Terms', 'soda-addons' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => $this->get_terms_options_for_select(),
				'description' => __( 'Choose specific terms to display. Leave empty to include all terms for the selected taxonomy.', 'soda-addons' ),
				'default' => [],
			]
		);

		$this->add_control(
			'display_mode',
			[
				'label' => __( 'Display Mode', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'current_post' => __( 'Related to Current Post', 'soda-addons' ),
					'all_terms' => __( 'All Terms', 'soda-addons' ),
				],
				'default' => 'current_post',
				'description' => __( 'Choose whether to display terms from the current post or all available terms in the taxonomy.', 'soda-addons' ),
			]
		);

		$this->add_control(
			'show_label',
			[
				'label' => __( 'Show Label', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'label_text',
			[
				'label' => __( 'Label Text', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => __( 'Leave empty to use taxonomy name', 'soda-addons' ),
				'condition' => [
					'show_label' => 'yes',
				],
			]
		);

		$this->add_control(
			'separator',
			[
				'label' => __( 'Separator', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => ', ',
				'placeholder' => ', ',
			]
		);

		$this->add_control(
			'link_terms',
			[
				'label' => __( 'Link Terms', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'description' => __( 'Add links to term archive pages', 'soda-addons' ),
			]
		);

		$this->add_control(
			'disable_empty_terms',
			[
				'label' => __( 'Disable Empty Terms', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'description' => __( 'Display empty terms without a link and mark them as disabled.', 'soda-addons' ),
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
				'default' => 'div',
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
			'direction',
			[
				'label' => __( 'Direction', 'soda-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'row' => [
						'title' => __( 'Horizontal', 'soda-addons' ),
						'icon' => 'eicon-navigation-horizontal',
					],
					'column' => [
						'title' => __( 'Vertical', 'soda-addons' ),
						'icon' => 'eicon-navigation-vertical',
					],
				],
				'default' => 'row',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__items' => 'display: flex; flex-direction: {{VALUE}}; flex-wrap: wrap;',
				],
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => __( 'Alignment', 'soda-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'soda-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'soda-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'soda-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => __( 'Justified', 'soda-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__items' => 'justify-content: {{VALUE}}; align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => __( 'Gap Between Items', 'soda-addons' ),
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
					'size' => 8,
				],
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__items' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Label Style Section
		$this->start_controls_section(
			'label_style_section',
			[
				'label' => __( 'Label Style', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_label' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Typography', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-taxonomy-list__label',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_margin',
			[
				'label' => __( 'Margin', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Items Style Section
		$this->start_controls_section(
			'items_style_section',
			[
				'label' => __( 'Items Style', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'items_typography',
				'label' => __( 'Typography', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-taxonomy-list__item',
			]
		);

		$this->start_controls_tabs( 'items_style_tabs' );

		// Normal State
		$this->start_controls_tab(
			'items_normal_tab',
			[
				'label' => __( 'Normal', 'soda-addons' ),
			]
		);

		$this->add_control(
			'items_color',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .soda-taxonomy-list__item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'items_background',
				'label' => __( 'Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-taxonomy-list__item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'items_border',
				'label' => __( 'Border', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-taxonomy-list__item',
			]
		);

		$this->add_responsive_control(
			'items_border_radius',
			[
				'label' => __( 'Border Radius', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'items_padding',
			[
				'label' => __( 'Padding', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'items_hover_tab',
			[
				'label' => __( 'Hover', 'soda-addons' ),
			]
		);

		$this->add_control(
			'items_color_hover',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__item:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .soda-taxonomy-list__item a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'items_background_hover',
				'label' => __( 'Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-taxonomy-list__item:hover',
			]
		);

		$this->add_control(
			'items_border_color_hover',
			[
				'label' => __( 'Border Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Active State
		$this->start_controls_tab(
			'items_active_tab',
			[
				'label' => __( 'Active', 'soda-addons' ),
			]
		);

		$this->add_control(
			'items_color_active',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__item.is-active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .soda-taxonomy-list__item.is-active a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'items_background_active',
				'label' => __( 'Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-taxonomy-list__item.is-active',
			]
		);

		$this->add_control(
			'items_border_color_active',
			[
				'label' => __( 'Border Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__item.is-active' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'items_transition',
			[
				'label' => __( 'Transition Duration', 'soda-addons' ),
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
					'{{WRAPPER}} .soda-taxonomy-list__item' => 'transition: all {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .soda-taxonomy-list__item a' => 'transition: color {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Separator Style Section
		$this->start_controls_section(
			'separator_style_section',
			[
				'label' => __( 'Separator Style', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'separator_typography',
				'label' => __( 'Typography', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-taxonomy-list__separator',
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .soda-taxonomy-list__separator' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get available taxonomies options.
	 *
	 * @since 2.3.0
	 * @access private
	 *
	 * @return array Taxonomies options.
	 */
	private function get_taxonomies_options() {
		$taxonomies = get_taxonomies( [ 'public' => true ], 'objects' );
		$options = [];

		foreach ( $taxonomies as $taxonomy ) {
			$options[ $taxonomy->name ] = $taxonomy->label;
		}

		return $options;
	}

	/**
	 * Get term options formatted for the select control.
	 *
	 * @since 2.3.0
	 * @access private
	 *
	 * @return array
	 */
	private function get_terms_options_for_select() {
		$options = [];
		$taxonomies = $this->get_taxonomies_options();

		foreach ( $taxonomies as $taxonomy => $label ) {
			$terms = get_terms( [
				'taxonomy' => $taxonomy,
				'hide_empty' => false,
			] );

			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				continue;
			}

			foreach ( $terms as $term ) {
				$key = $taxonomy . '|' . $term->term_id;
				$options[ $key ] = sprintf( '%s: %s', $label, $term->name );
			}
		}

		return $options;
	}

	/**
	 * Normalize selected term control values.
	 *
	 * @since 2.3.0
	 * @access private
	 *
	 * @param array $selected_terms Selected control values.
	 * @param string $expected_taxonomy Current taxonomy.
	 *
	 * @return array
	 */
	private function normalize_selected_term_ids( $selected_terms, $expected_taxonomy ) {
		$normalized = [];

		foreach ( (array) $selected_terms as $selected_term ) {
			if ( is_numeric( $selected_term ) ) {
				$normalized[] = (int) $selected_term;
				continue;
			}

			if ( is_string( $selected_term ) && strpos( $selected_term, '|' ) !== false ) {
				list( $taxonomy, $term_id ) = explode( '|', $selected_term );
				if ( $taxonomy === $expected_taxonomy && is_numeric( $term_id ) ) {
					$normalized[] = (int) $term_id;
				}
			}
		}

		return array_values( array_unique( $normalized ) );
	}

	/**
	 * Render widget output on the frontend.
	 *
	 * @since 2.3.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$taxonomy = $settings['taxonomy'];
		$display_mode = isset( $settings['display_mode'] ) ? $settings['display_mode'] : 'current_post';
		$show_label = $settings['show_label'] === 'yes';
		$label_text = ! empty( $settings['label_text'] ) ? $settings['label_text'] : '';
		$separator = $settings['separator'];
		$link_terms = $settings['link_terms'] === 'yes';
		$disable_empty_terms = isset( $settings['disable_empty_terms'] ) ? ( 'yes' === $settings['disable_empty_terms'] ) : true;
		$html_tag = $settings['html_tag'];

		if ( ! in_array( $display_mode, [ 'current_post', 'all_terms' ], true ) ) {
			$display_mode = 'current_post';
		}

		$terms = [];

		if ( 'all_terms' === $display_mode ) {
			$terms = get_terms( [
				'taxonomy' => $taxonomy,
				'hide_empty' => false,
			] );

			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					echo '<div class="soda-taxonomy-list__message">' . __( 'No terms found for this taxonomy.', 'soda-addons' ) . '</div>';
				}
				return;
			}
		} else {
			$post_id = get_the_ID();
			if ( ! $post_id ) {
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					echo '<div class="soda-taxonomy-list__message">' . __( 'This widget displays taxonomies from the current post. Please view it on a single post page.', 'soda-addons' ) . '</div>';
				}
				return;
			}

			$terms = get_the_terms( $post_id, $taxonomy );

			if ( is_wp_error( $terms ) || empty( $terms ) ) {
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					echo '<div class="soda-taxonomy-list__message">' . __( 'No terms found for this taxonomy on the current post.', 'soda-addons' ) . '</div>';
				}
				return;
			}
		}

		$selected_term_ids = $this->normalize_selected_term_ids(
			isset( $settings['selected_terms'] ) ? $settings['selected_terms'] : [],
			$taxonomy
		);

		if ( ! empty( $selected_term_ids ) ) {
			$selection_order = array_flip( $selected_term_ids );
			$terms = array_values( array_filter( $terms, function( $term ) use ( $selected_term_ids ) {
				return in_array( (int) $term->term_id, $selected_term_ids, true );
			} ) );

			if ( empty( $terms ) ) {
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					echo '<div class="soda-taxonomy-list__message">' . __( 'None of the selected terms are available for this taxonomy.', 'soda-addons' ) . '</div>';
				}
				return;
			}

			usort( $terms, function( $a, $b ) use ( $selection_order ) {
				$a_id = (int) $a->term_id;
				$b_id = (int) $b->term_id;
				$a_pos = isset( $selection_order[ $a_id ] ) ? $selection_order[ $a_id ] : PHP_INT_MAX;
				$b_pos = isset( $selection_order[ $b_id ] ) ? $selection_order[ $b_id ] : PHP_INT_MAX;
				if ( $a_pos === $b_pos ) {
					return strcasecmp( $a->name, $b->name );
				}
				return ( $a_pos < $b_pos ) ? -1 : 1;
			} );
		}

		// Get taxonomy object for label
		$taxonomy_obj = get_taxonomy( $taxonomy );
		if ( empty( $label_text ) && $taxonomy_obj ) {
			$label_text = $taxonomy_obj->labels->name;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'soda-taxonomy-list' );

		$active_term_id = 0;
		$queried_object = get_queried_object();
		if ( $queried_object instanceof \WP_Term && $queried_object->taxonomy === $taxonomy ) {
			$active_term_id = (int) $queried_object->term_id;
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $show_label && ! empty( $label_text ) ) : ?>
				<<?php echo esc_attr( $html_tag ); ?> class="soda-taxonomy-list__label">
					<?php echo esc_html( $label_text ); ?>
				</<?php echo esc_attr( $html_tag ); ?>>
			<?php endif; ?>

			<div class="soda-taxonomy-list__items">
				<?php
				$terms_count = count( $terms );
				$counter = 0;
				
				foreach ( $terms as $term ) :
					$term_id = (int) $term->term_id;
					$term_has_posts = ( isset( $term->count ) && (int) $term->count > 0 );
					$is_disabled = $disable_empty_terms && ! $term_has_posts;
					$is_active = ( $active_term_id && $term_id === $active_term_id );
					$item_classes = [ 'soda-taxonomy-list__item' ];
					if ( $is_active ) {
						$item_classes[] = 'is-active';
					}
					if ( $is_disabled ) {
						$item_classes[] = 'is-disabled';
					}
					$item_class_attr = implode( ' ', array_map( 'sanitize_html_class', $item_classes ) );
					$item_extra_attr = $is_disabled ? ' aria-disabled="true"' : '';
					$term_name = $term->name;
					$term_url = get_term_link( $term );
					$counter++;
					?>
					<span class="<?php echo esc_attr( $item_class_attr ); ?>"<?php echo $item_extra_attr; ?>>
						<?php if ( $link_terms && ! $is_disabled && ! is_wp_error( $term_url ) ) : ?>
							<a href="<?php echo esc_url( $term_url ); ?>"<?php echo $is_active ? ' aria-current="page"' : ''; ?>>
								<?php echo esc_html( $term_name ); ?>
							</a>
						<?php else : ?>
							<?php echo esc_html( $term_name ); ?>
						<?php endif; ?>
					</span>
					<?php if ( $counter < $terms_count && ! empty( $separator ) ) : ?>
						<span class="soda-taxonomy-list__separator"><?php echo esc_html( $separator ); ?></span>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}
