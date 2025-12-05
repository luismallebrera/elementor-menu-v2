<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pinned_Gallery extends Widget_Base {
	public function get_name() { return 'soda_pinned_gallery'; }
	public function get_title() { return __( 'Soda Pinned Gallery', 'soda-elementor-addons' ); }
	public function get_icon() { return '	eicon-accordion'; }
	public function get_categories() { return [ 'soda-addons' ]; }
	public function get_script_depends() { return [ 'soda-pinned-gallery' ]; }
	public function get_style_depends() { return [ 'soda-pinned-gallery' ]; }

	protected function register_controls() {
			$this->start_controls_section(
					'content_section',
					[
							'label' => __( 'Content', 'soda-pinned-gallery' ),
							'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
					]
			);

			$this->add_control(
					'gallery',
					[
							'label'   => __( 'Add Images To Gallery', 'soda-pinned-gallery' ),
							'type'    => \Elementor\Controls_Manager::GALLERY,
							'dynamic' => ['active' => true,],
							'default' => [],

					]
			);

			$this->end_controls_section();
	}

	protected function render() {
			$settings = $this->get_settings_for_display();

			echo '<div class="pinned-gallery">';
			if ( !empty( $settings['gallery'] ) ) {
					foreach ( $settings['gallery'] as $image ) {
							$image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', true );

							echo '<div class="pinned-image">';
							echo '<div class="pinned-image-container">';
							echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image_alt ) . '" />';
							echo '</div>';
							echo '</div>';
					}
			}
			echo '</div>';
	}
}
