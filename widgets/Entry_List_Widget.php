<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Entry List Widget
 *
 * @since 2.4.0
 */
class Entry_List_Widget extends Widget_Base {

	/**
	 * Get widget name.
	 */
	public function get_name() {
		return 'soda-entry-list';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Entry List', 'soda-addons' );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-list';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories() {
		return [ 'soda-addons' ];
	}

	/**
	 * Get widget keywords.
	 */
	public function get_keywords() {
		return [ 'post', 'entry', 'list', 'blog', 'archive', 'query' ];
	}

	/**
	 * Register controls.
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
			'post_type',
			[
				'label' => __( 'Post Type', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => $this->get_post_types_options(),
				'default' => 'post',
			]
		);

		$this->add_control(
			'query_id',
			[
				'label' => __( 'Query ID', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'description' => __( 'Use this ID to customize the query via the elementor/query/{$query_id} filter.', 'soda-addons' ),
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Entries to Show', 'soda-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5,
				'frontend_available' => true,
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
				'placeholder' => __( 'Leave empty to use post type label', 'soda-addons' ),
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
			'link_entries',
			[
				'label' => __( 'Link Entries', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'description' => __( 'Link each entry to its single post.', 'soda-addons' ),
			]
		);

		$this->add_control(
			'link_type',
			[
				'label' => __( 'Link Type', 'soda-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'permalink' => __( 'Post Permalink', 'soda-addons' ),
					'popup_query' => __( 'Popup Anchor (Query String)', 'soda-addons' ),
					'popup_action' => __( 'Elementor Popup Action', 'soda-addons' ),
				],
				'default' => 'permalink',
				'condition' => [
					'link_entries' => 'yes',
				],
			]
		);

		$this->add_control(
			'popup_anchor',
			[
				'label' => __( 'Popup Anchor', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '#popup-7468',
				'description' => __( 'Anchor that triggers the popup (example: #popup-7468).', 'soda-addons' ),
				'condition' => [
					'link_entries' => 'yes',
					'link_type' => 'popup_query',
				],
			]
		);

		$this->add_control(
			'popup_query_param',
			[
				'label' => __( 'Query Parameter', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'municipio_id',
				'description' => __( 'Parameter name that receives the current entry ID.', 'soda-addons' ),
				'condition' => [
					'link_entries' => 'yes',
					'link_type' => 'popup_query',
				],
			]
		);

		$this->add_control(
			'popup_action_id',
			[
				'label' => __( 'Popup ID', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '7468',
				'description' => __( 'Template ID of the Elementor popup to open.', 'soda-addons' ),
				'condition' => [
					'link_entries' => 'yes',
					'link_type' => 'popup_action',
				],
			]
		);

		$this->add_control(
			'popup_action_param_key',
			[
				'label' => __( 'Action Parameter Key', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'post',
				'description' => __( 'Key that receives the current entry ID in the action URL.', 'soda-addons' ),
				'condition' => [
					'link_entries' => 'yes',
					'link_type' => 'popup_action',
				],
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label' => __( 'Label HTML Tag', 'soda-addons' ),
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
					'{{WRAPPER}} .soda-entry-list__items' => 'display: flex; flex-direction: {{VALUE}}; flex-wrap: wrap;',
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
						'title' => __( 'Start', 'soda-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'soda-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => __( 'End', 'soda-addons' ),
						'icon' => 'eicon-text-align-right',
					],
					'space-between' => [
						'title' => __( 'Justify', 'soda-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'flex-start',
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__items' => 'justify-content: {{VALUE}}; align-items: {{VALUE}};',
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
					'px' => [ 'min' => 0, 'max' => 100, 'step' => 1 ],
					'em' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
					'rem' => [ 'min' => 0, 'max' => 10, 'step' => 0.1 ],
				],
				'default' => [ 'unit' => 'px', 'size' => 8 ],
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__items' => 'gap: {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .soda-entry-list__label',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__label' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .soda-entry-list__label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .soda-entry-list__item',
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
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__item' => 'color: {{VALUE}};',
					'{{WRAPPER}} .soda-entry-list__item a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'items_background',
				'label' => __( 'Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-entry-list__item',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'items_border',
				'label' => __( 'Border', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-entry-list__item',
			]
		);

		$this->add_responsive_control(
			'items_border_radius',
			[
				'label' => __( 'Border Radius', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .soda-entry-list__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__item:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .soda-entry-list__item a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'items_background_hover',
				'label' => __( 'Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-entry-list__item:hover',
			]
		);

		$this->add_control(
			'items_border_color_hover',
			[
				'label' => __( 'Border Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__item:hover' => 'border-color: {{VALUE}};',
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
					's' => [ 'min' => 0, 'max' => 3, 'step' => 0.1 ],
					'ms' => [ 'min' => 0, 'max' => 3000, 'step' => 100 ],
				],
				'default' => [ 'unit' => 's', 'size' => 0.3 ],
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__item' => 'transition: all {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .soda-entry-list__item a' => 'transition: color {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .soda-entry-list__separator',
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .soda-entry-list__separator' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Get post types options.
	 */
	private function get_post_types_options() {
		$post_types = get_post_types( [ 'public' => true ], 'objects' );
		$options = [];

		foreach ( $post_types as $post_type ) {
			$options[ $post_type->name ] = $post_type->labels->singular_name;
		}

		return $options;
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$post_type = $settings['post_type'];
		$query_id = ! empty( $settings['query_id'] ) ? sanitize_key( $settings['query_id'] ) : '';
		$posts_per_page = isset( $settings['posts_per_page'] ) ? (int) $settings['posts_per_page'] : 5;
		if ( 0 === $posts_per_page ) {
			$posts_per_page = -1; // Allow showing all entries when set to zero
		}
		$show_label = $settings['show_label'] === 'yes';
		$label_text = ! empty( $settings['label_text'] ) ? $settings['label_text'] : '';
		$separator = $settings['separator'];
		$link_entries = $settings['link_entries'] === 'yes';
		$html_tag = $settings['html_tag'];
		$link_type = isset( $settings['link_type'] ) ? $settings['link_type'] : 'permalink';
		$popup_anchor = isset( $settings['popup_anchor'] ) ? $settings['popup_anchor'] : '';
		$popup_query_param = isset( $settings['popup_query_param'] ) ? $settings['popup_query_param'] : '';
		$popup_action_id = isset( $settings['popup_action_id'] ) ? $settings['popup_action_id'] : '';
		$popup_action_param_key = isset( $settings['popup_action_param_key'] ) ? $settings['popup_action_param_key'] : 'post';

		$args = [
			'post_type' => $post_type,
			'posts_per_page' => $posts_per_page,
			'ignore_sticky_posts' => true,
			'post_status' => 'publish',
			'no_found_rows' => true,
		];

		$query = new \WP_Query();
		foreach ( $args as $key => $value ) {
			$query->set( $key, $value );
		}

		if ( $query_id ) {
			$query->set( 'query_id', $query_id );
			do_action_ref_array( 'elementor/query/' . $query_id, [ &$query, $this ] );
		}

		$query->query( $query->query_vars );

		if ( ! $query->have_posts() ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="soda-entry-list__message">' . __( 'No entries found for this query.', 'soda-addons' ) . '</div>';
			}
			return;
		}

		$post_type_object = get_post_type_object( $post_type );
		if ( empty( $label_text ) && $post_type_object ) {
			$label_text = $post_type_object->labels->name;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'soda-entry-list' );

		if ( $query_id ) {
			$this->add_render_attribute( 'wrapper', 'data-query-id', $query_id );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $show_label && ! empty( $label_text ) ) : ?>
				<<?php echo esc_attr( $html_tag ); ?> class="soda-entry-list__label">
					<?php echo esc_html( $label_text ); ?>
				</<?php echo esc_attr( $html_tag ); ?>>
			<?php endif; ?>

			<div class="soda-entry-list__items">
				<?php
				$posts_count = $query->post_count;
				$counter = 0;

				while ( $query->have_posts() ) :
					$query->the_post();
					$counter++;
					?>
					<span class="soda-entry-list__item">
						<?php if ( $link_entries ) : ?>
							<?php
							$post_id = get_the_ID();
							$link_url = '';
							if ( 'popup_query' === $link_type ) {
								$anchor = ! empty( $popup_anchor ) ? $popup_anchor : '#popup';
								$param = sanitize_key( $popup_query_param );
								if ( empty( $param ) ) {
									$param = 'municipio_id';
								}
								$separator = strpos( $anchor, '?' ) === false ? '?' : '&';
								$link_url = $anchor . $separator . rawurlencode( $param ) . '=' . absint( $post_id );
							} elseif ( 'popup_action' === $link_type ) {
								$popup_id_clean = preg_replace( '/[^0-9]/', '', $popup_action_id );
								$param_key = sanitize_key( $popup_action_param_key );
								if ( empty( $param_key ) ) {
									$param_key = 'post';
								}
								if ( ! empty( $popup_id_clean ) ) {
									$link_url = sprintf(
										'#elementor-action:popup=%s&%s=%d',
										rawurlencode( $popup_id_clean ),
										rawurlencode( $param_key ),
										absint( $post_id )
									);
								}
							}

							if ( empty( $link_url ) ) {
								$link_url = get_permalink( $post_id );
							}
							?>
							<a href="<?php echo esc_attr( $link_url ); ?>">
								<?php echo esc_html( get_the_title() ); ?>
							</a>
						<?php else : ?>
							<?php echo esc_html( get_the_title() ); ?>
						<?php endif; ?>
					</span>
					<?php if ( $counter < $posts_count && ! empty( $separator ) ) : ?>
						<span class="soda-entry-list__separator"><?php echo esc_html( $separator ); ?></span>
					<?php endif; ?>
				<?php endwhile; ?>
			</div>
		</div>
		<?php

		wp_reset_postdata();
	}
}
