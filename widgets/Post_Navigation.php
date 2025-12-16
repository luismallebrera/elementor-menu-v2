<?php
namespace SodaAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Post_Navigation extends Widget_Base {

    public function get_name() {
        return 'soda-post-navigation';
    }

    public function get_title() {
        return __( 'Post Navigation', 'soda-addons' );
    }

    public function get_icon() {
        return 'soda soda-logo soda-post-navigation';
    }

    public function get_categories() {
        return [ 'soda-addons' ];
    }

    public function get_keywords() {
        return [ 'post', 'navigation', 'next', 'previous', 'links' ];
    }

    public function get_style_depends() {
        return [ 'soda-post-navigation' ];
    }

    protected function register_controls() {
        $soda_primary_color = get_option( 'soda_primary_color_option', '#7a56ff' );

        $this->start_controls_section(
            'soda_post_navigation_section',
            [
                'label' => __( 'Post Navigation', 'soda-addons' ),
            ]
        );

        $this->add_control(
            'soda_post_nav_item_feature_image',
            [
                'label'        => __( 'Show Featured Image', 'soda-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Show', 'soda-addons' ),
                'label_off'    => __( 'Hide', 'soda-addons' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'soda_post_nav_enable_label',
            [
                'label'     => __( 'Label', 'soda-addons' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Enable', 'soda-addons' ),
                'label_off' => __( 'Disable', 'soda-addons' ),
                'default'   => 'no',
            ]
        );

        $this->add_control(
            'soda_post_nav_prev_label',
            [
                'label'     => __( 'Previous Label', 'soda-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Previous', 'soda-addons' ),
                'condition' => [
                    'soda_post_nav_enable_label' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'soda_post_nav_next_label',
            [
                'label'     => __( 'Next Label', 'soda-addons' ),
                'type'      => Controls_Manager::TEXT,
                'default'   => __( 'Next', 'soda-addons' ),
                'condition' => [
                    'soda_post_nav_enable_label' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'soda_post_nav_enable_title',
            [
                'label'     => __( 'Post Title', 'soda-addons' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Enable', 'soda-addons' ),
                'label_off' => __( 'Disable', 'soda-addons' ),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'soda_post_nav_enable_arrow',
            [
                'label'     => __( 'Arrows', 'soda-addons' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'Enable', 'soda-addons' ),
                'label_off' => __( 'Disable', 'soda-addons' ),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'soda_post_nav_prev_icon',
            [
                'label'       => __( 'Previous Icon', 'soda-addons' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-arrow-left',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'soda_post_nav_enable_arrow' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'soda_post_nav_next_icon',
            [
                'label'       => __( 'Next Icon', 'soda-addons' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition'   => [
                    'soda_post_nav_enable_arrow' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'soda_post_nav_stay_current_cat',
            [
                'label'     => __( 'Stay in Current Category', 'soda-addons' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __( 'True', 'soda-addons' ),
                'label_off' => __( 'False', 'soda-addons' ),
                'default'   => 'no',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'soda_post_navigation_each_item_style',
            [
                'label' => __( 'Item', 'soda-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'soda_post_nav_prev_item_margin',
            [
                'label'      => __( 'Margin', 'soda-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'isLinked' => true,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-post-nav-each-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'soda_post_nav_item_border',
                'selector' => '{{WRAPPER}} .soda-post-nav-prev, {{WRAPPER}} .soda-post-nav-next',
            ]
        );

        $this->add_responsive_control(
            'soda_post_nav_item_border_radius',
            [
                'label'      => __( 'Border Radius', 'soda-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'      => '30',
                    'right'    => '30',
                    'bottom'   => '30',
                    'left'     => '30',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-post-nav-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .soda-post-nav-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .soda-post-nav-prev::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .soda-post-nav-next::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'soda_post_nav_item_shadow',
                'selector' => '{{WRAPPER}} .soda-post-nav-prev, {{WRAPPER}} .soda-post-nav-next',
            ]
        );

        $this->start_controls_tabs( 'soda_post_nav_item_style_tabs' );

        $this->start_controls_tab( 'soda_post_nav_prev_item', [ 'label' => __( 'Previous', 'soda-addons' ) ] );

        $this->add_responsive_control(
            'soda_post_navigation_item_width',
            [
                'label'      => __( 'Width', 'soda-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'size' => 340,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-post-nav-each-item' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'soda_post_navigation_item_height',
            [
                'label'      => __( 'Height', 'soda-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'size' => 120,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-post-nav-each-item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'soda_post_nav_prev_item_padding',
            [
                'label'      => __( 'Padding', 'soda-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-post-nav-prev a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'soda_post_nav_item_bg_prev',
                'label'     => __( 'Background', 'soda-addons' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .soda-post-nav-prev',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color'      => [
                        'default' => $soda_primary_color,
                    ],
                ],
                'condition' => [
                    'soda_post_nav_item_feature_image!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'soda_post_nav_item_bg_overlay_prev',
            [
                'label'     => __( 'Overlay Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-prev::before' => 'background: {{VALUE}}; transition: all 0.5s;',
                ],
            ]
        );

        $this->add_control(
            'soda_post_nav_item_bg_overlay_prev_hover',
            [
                'label'     => __( 'Overlay Color Hover', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-prev.link-item:hover::before' => 'background: {{VALUE}}; transition: all 0.5s;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'soda_post_nav_next_item', [ 'label' => __( 'Next', 'soda-addons' ) ] );

        $this->add_responsive_control(
            'soda_post_nav_next_item_padding',
            [
                'label'      => __( 'Padding', 'soda-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default'    => [
                    'top'      => '10',
                    'right'    => '20',
                    'bottom'   => '10',
                    'left'     => '20',
                    'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-post-nav-next a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'soda_post_nav_item_bg_next',
                'label'     => __( 'Background', 'soda-addons' ),
                'types'     => [ 'classic', 'gradient' ],
                'selector'  => '{{WRAPPER}} .soda-post-nav-next',
                'fields_options' => [
                    'background' => [
                        'default' => 'classic',
                    ],
                    'color'      => [
                        'default' => $soda_primary_color,
                    ],
                ],
                'condition' => [
                    'soda_post_nav_item_feature_image!' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'soda_post_nav_item_bg_overlay_next',
            [
                'label'     => __( 'Overlay Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-next::before' => 'background: {{VALUE}}; transition: all 0.5s;',
                ],
            ]
        );

        $this->add_control(
            'soda_post_nav_item_bg_overlay_next_hover',
            [
                'label'     => __( 'Overlay Color Hover', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-next.link-item:hover::before' => 'background: {{VALUE}}; transition: all 0.5s;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'soda_post_navigation_label_style',
            [
                'label'     => __( 'Label', 'soda-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'soda_post_nav_enable_label' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'soda_post_navigation_label_typography',
                'selector' => '{{WRAPPER}} .soda-post-nav-prev-label, {{WRAPPER}} .soda-post-nav-next-label',
            ]
        );

        $this->start_controls_tabs( 'soda_post_nav_label_style_tabs' );

        $this->start_controls_tab( 'soda_post_nav_label_normal', [ 'label' => __( 'Normal', 'soda-addons' ) ] );

        $this->add_control(
            'soda_post_nav_label_normal_color',
            [
                'label'     => __( 'Text Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-prev-label' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-post-nav-next-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'soda_post_nav_label_hover', [ 'label' => __( 'Hover', 'soda-addons' ) ] );

        $this->add_control(
            'soda_post_nav_label_hover_color',
            [
                'label'     => __( 'Text Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-prev-label:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-post-nav-next-label:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'soda_post_navigation_title_style',
            [
                'label'     => __( 'Title', 'soda-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'soda_post_nav_enable_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'soda_post_navigation_title_typography',
                'selector' => '{{WRAPPER}} .soda-post-nav-prev-title, {{WRAPPER}} .soda-post-nav-next-title',
            ]
        );

        $this->start_controls_tabs( 'soda_post_nav_title_style_tabs' );

        $this->start_controls_tab( 'soda_post_nav_title_normal', [ 'label' => __( 'Normal', 'soda-addons' ) ] );

        $this->add_control(
            'soda_post_nav_title_normal_color',
            [
                'label'     => __( 'Text Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-prev-title' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-post-nav-next-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'soda_post_nav_title_hover', [ 'label' => __( 'Hover', 'soda-addons' ) ] );

        $this->add_control(
            'soda_post_nav_title_hover_color',
            [
                'label'     => __( 'Text Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-prev-title:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-post-nav-next-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'soda_post_navigation_arrow_style',
            [
                'label'     => __( 'Arrow', 'soda-addons' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'soda_post_nav_enable_arrow' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'soda_post_navigation_arrow_size',
            [
                'label'      => __( 'Size', 'soda-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default'    => [
                    'size' => 13,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-post-nav-prev-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .soda-post-nav-next-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'soda_post_navigation_arrow_spacing',
            [
                'label'      => __( 'Spacing', 'soda-addons' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'default'    => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-post-nav-prev-arrow' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .soda-post-nav-next-arrow' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'soda_post_nav_arrow_style_tabs' );

        $this->start_controls_tab( 'soda_post_nav_arrow_normal', [ 'label' => __( 'Normal', 'soda-addons' ) ] );

        $this->add_control(
            'soda_post_nav_arrow_normal_color',
            [
                'label'     => __( 'Text Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-prev-arrow' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-post-nav-next-arrow' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'soda_post_nav_arrow_hover', [ 'label' => __( 'Hover', 'soda-addons' ) ] );

        $this->add_control(
            'soda_post_nav_arrow_hover_color',
            [
                'label'     => __( 'Text Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-post-nav-prev-arrow:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-post-nav-next-arrow:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render() {
        $settings     = $this->get_settings_for_display();
        $prev_post    = get_previous_post( $settings['soda_post_nav_stay_current_cat'] === 'yes' );
        $next_post    = get_next_post( $settings['soda_post_nav_stay_current_cat'] === 'yes' );

        if ( ! $prev_post && ! $next_post ) {
            return;
        }

        $prev_label = '';
        $next_label = '';

        if ( 'yes' === $settings['soda_post_nav_enable_label'] ) {
            $prev_label = '<span class="soda-post-nav-prev-label">' . esc_html( $settings['soda_post_nav_prev_label'] ) . '</span>';
            $next_label = '<span class="soda-post-nav-next-label">' . esc_html( $settings['soda_post_nav_next_label'] ) . '</span>';
        }

        $prev_title = '';
        $next_title = '';

        if ( 'yes' === $settings['soda_post_nav_enable_title'] ) {
            $prev_title = '<span class="soda-post-nav-prev-title">%title</span>';
            $next_title = '<span class="soda-post-nav-next-title">%title</span>';
        }

        $prev_arrow = '';
        $next_arrow = '';

        if ( 'yes' === $settings['soda_post_nav_enable_arrow'] ) {
            if ( ! empty( $settings['soda_post_nav_prev_icon']['value'] ) ) {
                ob_start();
                Icons_Manager::render_icon( $settings['soda_post_nav_prev_icon'], [ 'aria-hidden' => 'true' ] );
                $prev_arrow = '<span class="soda-post-nav-prev-arrow">' . ob_get_clean() . '</span>';
            }

            if ( ! empty( $settings['soda_post_nav_next_icon']['value'] ) ) {
                ob_start();
                Icons_Manager::render_icon( $settings['soda_post_nav_next_icon'], [ 'aria-hidden' => 'true' ] );
                $next_arrow = '<span class="soda-post-nav-next-arrow">' . ob_get_clean() . '</span>';
            }
        }

        $show_featured = isset( $settings['soda_post_nav_item_feature_image'] ) && 'yes' === $settings['soda_post_nav_item_feature_image'];
        $prev_thumb    = $prev_post ? get_the_post_thumbnail_url( $prev_post->ID ) : '';
        $next_thumb    = $next_post ? get_the_post_thumbnail_url( $next_post->ID ) : '';
        ?>
        <div class="soda-post-navigation-wrapper">
            <?php if ( $prev_post ) : ?>
                <div class="soda-post-nav-each-item">
                    <div class="soda-post-nav-prev jarallax link-item"<?php echo $show_featured && $prev_thumb ? ' style="background-image: url(' . esc_url( $prev_thumb ) . '); background-size: cover; background-repeat: no-repeat; background-position: center;"' : ''; ?>>
                        <?php previous_post_link( '%link', $prev_arrow . '<span class="soda-post-nav-prev-link link-item">' . $prev_label . $prev_title . '</span>', $settings['soda_post_nav_stay_current_cat'] === 'yes' ); ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( $next_post ) : ?>
                <div class="soda-post-nav-each-item">
                    <div class="soda-post-nav-next jarallax link-item"<?php echo $show_featured && $next_thumb ? ' style="background-image: url(' . esc_url( $next_thumb ) . '); background-size: cover; background-repeat: no-repeat; background-position: center;"' : ''; ?>>
                        <?php next_post_link( '%link', '<span class="soda-post-nav-next-link link-item">' . $next_label . $next_title . '</span>' . $next_arrow, $settings['soda_post_nav_stay_current_cat'] === 'yes' ); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }
}
