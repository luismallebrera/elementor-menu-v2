<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Zoom_Gallery extends Widget_Base {
	public function get_name() { return 'soda_zoom_gallery'; }
	public function get_title() { return __( 'Soda Zoom Gallery', 'soda-elementor-addons' ); }
	public function get_icon() { return 'eicon-zoom-in-bold'; }
	public function get_categories() { return [ 'soda-addons' ]; }
	public function get_script_depends() { return [ 'soda-zoom-gallery' ]; }
	public function get_style_depends() { return [ 'soda-zoom-gallery' ]; }

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'soda-zoom-gallery' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'gallery',
			[
				'label' => __( 'Add Images To Gallery', 'soda-zoom-gallery' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'zoom_slide_no',
			[
				'label' => __( 'Zoomed slide number', 'soda-zoom-gallery' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 1
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'label' => __( 'Aspect Ratio', 'soda-zoom-gallery' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0.4,
				'max' => 1,
				'step' => 0.1,
				'default' => 0.4
			]
		);
		$this->add_control(
		'gallery_width',
		[
				'label' => __( 'Gallery Width (px or %)', 'soda-zoom-gallery' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '100%',
				'description' => 'Set the width of the gallery, e.g., 800px or 80%.',
		]
	);
		$this->end_controls_section();
	}





	protected function render() {
		$settings = $this->get_settings_for_display();
		$gallery_width = !empty($settings['gallery_width']) ? $settings['gallery_width'] : '100%';
		echo '<div class="zoom-gallery" style="width:' . esc_attr($gallery_width) . ';">';
		echo '<ul class="zoom-wrapper-gallery" data-heightratio="' . esc_attr( $settings['aspect_ratio'] ) . '">';
		$zoom_slide_no = $settings['zoom_slide_no'];
		$counter = 1;
		foreach ( $settings['gallery'] as $image ) {
			$image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', TRUE );
			$li_class = ($zoom_slide_no == $counter) ? 'zoom-center' : '';
			echo '<li class="' . esc_attr($li_class) . '">';
			echo '<div class="zoom-img-wrapper">';
			echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image_alt ) . '" />';
			echo '</div>';
			echo '</li>';
			$counter++;
		}
		echo '</ul>';
		echo '<div class="zoom-wrapper-thumb"></div>';
		echo '</div>';
	}
}
