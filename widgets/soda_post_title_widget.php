<?php
namespace SodaAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Post_Title_Widget extends Widget_Base {

	public function get_name() {
		return 'soda-post-title';
	}

	public function get_title() {
		return __( 'Post Title', 'soda-addons' );
	}

	public function get_icon() {
		return 'eicon-post-title';
	}

	public function get_categories() {
		return [ 'soda-addons' ];
	}

	public function get_keywords() {
		return [ 'title', 'heading', 'post', 'entry', 'soda' ];
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
				'default' => 'h2',
			]
		);

		$this->add_control(
			'enable_word_limit',
			[
				'label' => __( 'Limit Words', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => '',
			]
		);

		$this->add_control(
			'word_limit',
			[
				'label' => __( 'Word Limit', 'soda-addons' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 10,
				'condition' => [ 'enable_word_limit' => 'yes' ],
				'min' => 1,
			]
		);

		$this->add_control(
			'word_limit_ellipsis',
			[
				'label' => __( 'Ellipsis', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '...',
				'condition' => [ 'enable_word_limit' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'alignment',
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
					'justify' => [
						'title' => __( 'Justified', 'soda-addons' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .soda-post-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'heading_style',
			[
				'label' => __( 'Title', 'soda-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'soda-addons' ),
				'global' => [ 'default' => Global_Typography::TYPOGRAPHY_PRIMARY ],
				'selector' => '{{WRAPPER}} .soda-post-title__heading',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'soda-addons' ),
				'type' => Controls_Manager::COLOR,
				'global' => [ 'default' => Global_Colors::COLOR_TEXT ],
				'selectors' => [
					'{{WRAPPER}} .soda-post-title__heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'title_background',
				'label' => __( 'Background', 'soda-addons' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .soda-post-title__heading',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'label' => __( 'Border', 'soda-addons' ),
				'selector' => '{{WRAPPER}} .soda-post-title__heading',
			]
		);

		$this->add_responsive_control(
			'title_border_radius',
			[
				'label' => __( 'Border Radius', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-post-title__heading' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => __( 'Padding', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-post-title__heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Margin', 'soda-addons' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .soda-post-title__heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$post_id = get_the_ID();

		if ( ! $post_id ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="soda-post-title__message">' . esc_html__( 'Post title will appear on single post templates.', 'soda-addons' ) . '</div>';
			}
			return;
		}

		$title = get_the_title( $post_id );
		if ( '' === $title ) {
			return;
		}

		if ( 'yes' === $settings['enable_word_limit'] && ! empty( $settings['word_limit'] ) ) {
			$title = $this->maybe_limit_words(
				wp_strip_all_tags( $title ),
				(int) $settings['word_limit'],
				isset( $settings['word_limit_ellipsis'] ) ? $settings['word_limit_ellipsis'] : '...'
			);
		}

		$tag = isset( $settings['html_tag'] ) ? $settings['html_tag'] : 'h2';
		$tag = in_array( $tag, [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'div', 'span', 'p' ], true ) ? $tag : 'h2';

		$this->add_render_attribute( 'wrapper', 'class', 'soda-post-title' );
		$this->add_render_attribute( 'heading', 'class', 'soda-post-title__heading' );

		$heading_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $tag, $this->get_render_attribute_string( 'heading' ), esc_html( $title ) );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php echo $heading_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
		<?php
	}

	private function maybe_limit_words( $text, $limit, $ellipsis ) {
		$limit = max( 1, (int) $limit );
		$words = preg_split( '/\s+/', trim( $text ) );
		if ( ! $words ) {
			return $text;
		}

		if ( count( $words ) <= $limit ) {
			return $text;
		}

		$trimmed = array_slice( $words, 0, $limit );
		$ellipsis = (string) $ellipsis;
		return implode( ' ', $trimmed ) . ( '' !== $ellipsis ? $ellipsis : '' );
	}
}
