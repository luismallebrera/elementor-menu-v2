<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Horizontal_Gallery extends Widget_Base {
	public function get_name() { return 'soda_horizontal_gallery'; }
	public function get_title() { return __( 'Soda Horizontal Gallery', 'soda-elementor-addons' ); }
	public function get_icon() { return 'eicon-horizontal-in-bold'; }
	public function get_categories() { return [ 'soda-addons' ]; }
	public function get_script_depends() { return [ 'soda-horizontal-gallery' ]; }
	public function get_style_depends() { return [ 'soda-horizontal-gallery' ]; }
    /**
  	 * Register Scrolling Panels widget controls.
  	 *
  	 * Adds different input fields to allow the user to change and customize the widget settings.
  	 *
  	 * @since 1.0.0
  	 * @access protected
  	 */
  	protected function register_controls() {

  		$this->start_controls_section(
  			'content_section',
  			[
  				'label' => __( 'Content', 'soda-horizontal-gallery' ),
  				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
  			]
  		);

  		$this->add_control(
  			'gallery',
  			[
  				'label' => __( 'Add Images To Gallery', 'soda-horizontal-gallery' ),
  				'type' => \Elementor\Controls_Manager::GALLERY,
  				'default' => [],
  			]
  		);

  		$this->end_controls_section();

  	}

  	/**
  	 * Render Scrolling Panels widget output on the frontend.
  	 *
  	 * Written in PHP and used to generate the final HTML.
  	 *
  	 * @since 1.0.0
  	 * @access protected
  	 */
  	protected function render() {

  		$settings = $this->get_settings_for_display();

  		echo '<div class="panels">';
      echo '<div class="sticky-element half-height">';
  		echo '<div class="panels-container">';
  		echo '<div class="panel-flex">';
  		foreach ( $settings['gallery'] as $image ) {

  			$image_alt = get_post_meta( $image['id'], '_wp_attachment_image_alt', TRUE );

  			echo '<div class="panel">';
  			echo '<img class="image" src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image_alt ) . '" />';
  			echo '</div>';

  		}
  		echo '</div>';
  		echo '</div>';
  		echo '</div>';
  		echo '</div>';

  	}
}
