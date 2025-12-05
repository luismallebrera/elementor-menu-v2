<?php
namespace SodaAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Moving_Gallery extends Widget_Base {
	public function get_name() {
		return 'soda_moving_gallery'; // unique slug (keep stable)
	}

	public function get_title() {
		return __( 'Soda Moving Gallery', 'soda-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'soda-addons' ];
	}

	public function get_script_depends() {
		// Ensure these are registered in Plugin::register_scripts().
		return [ 'soda-moving-gallery' ];
	}

	public function get_style_depends() {
		return [ 'soda-moving-gallery' ];
	}

	protected function register_controls() {
			$this->start_controls_section(
					'content_section',
					[
							'label' => __( 'Content', 'soda-moving-gallery' ),
							'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
					]
			);

			$this->add_control(
					'gallery',
					[
							'label'   => __( 'Add Images To Gallery', 'soda-moving-gallery' ),
							'type'    => \Elementor\Controls_Manager::GALLERY,
							'default' => [],
					]
			);

			$this->add_control(
					'direction',
					[
							'label'   => __( 'Direction', 'soda-moving-gallery' ),
							'type'    => \Elementor\Controls_Manager::SELECT,
							'default' => 'fw-gallery',
							'options' => [
									'fw-gallery' => __( 'Forward', 'soda-moving-gallery' ),
									'bw-gallery' => __( 'Backward', 'soda-moving-gallery' ),
							],
					]
			);

			$this->add_control(
					'randomize',
					[
							'label'        => __( 'Randomize gallery images size?', 'soda-moving-gallery' ),
							'type'         => \Elementor\Controls_Manager::SWITCHER,
							'label_on'     => __( 'Yes', 'soda-moving-gallery' ),
							'label_off'    => __( 'No', 'soda-moving-gallery' ),
							'return_value' => 'yes',
							'default'      => 'no',
					]
			);

			$this->end_controls_section();
	}

	protected function render() {
			$settings = $this->get_settings_for_display();

			echo '<div class="moving-gallery ' . esc_attr( $settings['direction'] );
			if( $settings['randomize'] === 'yes' ){
					echo ' random-sizes';
			}
			echo '">';
			echo '<ul class="wrapper-gallery">';
			if ( !empty( $settings['gallery'] ) ) {
					foreach ( $settings['gallery'] as $image ) {
							$image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', true );
							echo '<li>';
							echo '<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image_alt ) . '" />';
							echo '</li>';
					}
			}
			echo '</ul>';
			echo '</div>';
	}
}
