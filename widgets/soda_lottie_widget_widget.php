<?php
namespace SodaAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class Lottie_Widget extends Widget_Base {

  public function get_name() {
		return 'soda-lottie-widget'; // unique slug (keep stable)
	}

	public function get_title() {
		return __( 'Soda Lottie Widget', 'soda-elementor-addons' );
	}

	public function get_icon() {
		return 'eicon-animation';
	}

	public function get_categories() {
		return [ 'soda-addons' ];
	}

	public function get_script_depends() {
		// Ensure these are registered in Plugin::register_scripts().
		return [ 'soda-lottie-widget' ];
	}



    protected function _register_controls() {

        // Lottie Controls
        $this->start_controls_section(
            'section_lottie',
            [
                'label' => __( 'Lottie', 'soda-lottie-widget' ),
            ]
        );

        $this->add_control(
            'lottie_file',
            [
                'label' => __( 'Lottie JSON File', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'application/json',
            ]
        );

        $this->add_responsive_control(
            'lottie_size',
            [
                'label' => __( 'Size', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 600,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 200,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lottie-widget-lottie lottie-player' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'play_on_viewport',
            [
                'label' => __( 'Play on Viewport', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Title & Description Controls
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'soda-lottie-widget' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Default Title', 'soda-lottie-widget' ),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __( 'Description', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Default Description', 'soda-lottie-widget' ),
            ]
        );

        $this->add_responsive_control(
            'layout',
            [
                'label' => __( 'Layout', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'vertical',
                'options' => [
                    'vertical' => __( 'Vertical', 'soda-lottie-widget' ),
                    'horizontal' => __( 'Horizontal', 'soda-lottie-widget' ),
                ],
                'tablet_default' => 'horizontal',
                'mobile_default' => 'vertical',
            ]
        );

        $this->add_control(
            'vertical_alignment',
            [
                'label' => __( 'Vertical Alignment', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center',
                'options' => [
                    'top' => __( 'Top', 'soda-lottie-widget' ),
                    'center' => __( 'Center', 'soda-lottie-widget' ),
                    'bottom' => __( 'Bottom', 'soda-lottie-widget' ),
                ],
                'condition' => [
                    'layout' => 'horizontal',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Controls
        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Style', 'soda-lottie-widget' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => __( 'Alignment', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'soda-lottie-widget' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'soda-lottie-widget' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'soda-lottie-widget' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Title Color', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lottie-widget-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .lottie-widget-title',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Description Color', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .lottie-widget-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .lottie-widget-description',
            ]
        );

        $this->add_responsive_control(
            'lottie_spacing',
            [
                'label' => __( 'Lottie Spacing', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lottie-widget-lottie' => '--lottie-spacing: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => __( 'Title Spacing', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lottie-widget-title' => '--title-spacing: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_spacing',
            [
                'label' => __( 'Description Spacing', 'soda-lottie-widget' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'tablet_default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'mobile_default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .lottie-widget-description' => '--description-spacing: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout_class = $settings['layout'];
        $alignment = isset($settings['alignment']) ? $settings['alignment'] : 'center';
        $vertical_alignment = isset($settings['vertical_alignment']) ? $settings['vertical_alignment'] : 'center';
        ?>

        <div class="lottie-widget lottie-widget-align-<?php echo $alignment; ?> lottie-widget-<?php echo $layout_class; ?> lottie-widget-valign-<?php echo $vertical_alignment; ?>" style="display: flex; align-items: <?php echo $layout_class == 'horizontal' ? ($vertical_alignment == 'top' ? 'flex-start' : ($vertical_alignment == 'bottom' ? 'flex-end' : 'center')) : $alignment; ?>; flex-direction: <?php echo $layout_class == 'horizontal' ? 'row' : 'column'; ?>;">
            <?php if ( $settings['lottie_file']['url'] ) : ?>
                <div class="lottie-widget-lottie">
                    <lottie-player
                        src="<?php echo esc_url( $settings['lottie_file']['url'] ); ?>"
                        background="transparent"
                        speed="1"
                        loop
                        <?php echo $settings['play_on_viewport'] ? 'autoplay' : ''; ?>>
                    </lottie-player>
                </div>
            <?php endif; ?>

            <div class="lottie-widget-text">
                <?php if ( $settings['title'] ) : ?>
                    <h2 class="lottie-widget-title" style="margin-top: 0px !important;"><?php echo esc_html( $settings['title'] ); ?></h2>
                <?php endif; ?>

                <?php if ( $settings['description'] ) : ?>
                    <p class="lottie-widget-description" style="margin-top: 0px !important;"><?php echo esc_html( $settings['description'] ); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <style>
            .lottie-widget {
                display: flex;
            }

            .lottie-widget-vertical {
                flex-direction: column;
            }

            .lottie-widget-horizontal {
                flex-direction: row;
            }

            .lottie-widget-horizontal .lottie-widget-lottie {
                margin-right: var(--lottie-spacing, 20px);
            }

            .lottie-widget-horizontal .lottie-widget-text {
                flex: 1;
            }

            .lottie-widget-lottie {
                margin-bottom: var(--lottie-spacing, 20px);
            }

            .lottie-widget-title {
                margin-bottom: var(--title-spacing, 20px) !important;
            }

            .lottie-widget-description {
                margin-bottom: var(--description-spacing, 20px) !important;
            }

            .lottie-widget-align-left {
                justify-content: flex-start;
            }

            .lottie-widget-align-center {
                justify-content: center;
            }

            .lottie-widget-align-right {
                justify-content: flex-end;
            }

            @media (max-width: 1024px) {
                .lottie-widget {
                    flex-direction: var(--layout-tablet, column) !important;
                }

                .lottie-widget-horizontal.tablet .lottie-widget-lottie {
                    margin-right: 0 !important;
                    margin-bottom: var(--lottie-spacing, 20px) !important;
                }

                .lottie-widget-horizontal.tablet .lottie-widget-text {
                    text-align: center !important;
                    margin-left: 0 !important;
                }
            }

            @media (max-width: 767px) {
                .lottie-widget {
                    flex-direction: var(--layout-mobile, column) !important;
                }

                .lottie-widget-horizontal.mobile .lottie-widget-lottie {
                    margin-right: 0 !important;
                    margin-bottom: var(--lottie-spacing, 20px) !important;
                }

                .lottie-widget-horizontal.mobile .lottie-widget-text {
                    text-align: center !important;
                    margin-left: 0 !important;
                }
            }
        </style>

        <?php
    }
}
