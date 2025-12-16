<?php
namespace SodaAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Back_Button_Widget extends Widget_Base {

    public function get_name() {
        return 'soda-back-button';
    }

    public function get_title() {
        return __( 'Back Button', 'soda-addons' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return [ 'soda-addons' ];
    }

    public function get_keywords() {
        return [ 'back', 'button', 'navigation', 'history', 'soda' ];
    }

    public function get_style_depends() {
        return [ 'soda-back-button' ];
    }

    public function get_script_depends() {
        return [ 'soda-back-button' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'soda-addons' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => __( 'Text', 'soda-addons' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Volver', 'soda-addons' ),
                'placeholder' => __( 'Back', 'soda-addons' ),
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label'        => __( 'Show Icon', 'soda-addons' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'soda-addons' ),
                'label_off'    => __( 'No', 'soda-addons' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label'     => __( 'Icon', 'soda-addons' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-left',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label'   => __( 'Icon Position', 'soda-addons' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'left'  => __( 'Left', 'soda-addons' ),
                    'right' => __( 'Right', 'soda-addons' ),
                ],
                'default'   => 'left',
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'fallback_url',
            [
                'label'       => __( 'Fallback URL', 'soda-addons' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => __( 'https://example.com', 'soda-addons' ),
                'description' => __( 'Used if no previous history is available.', 'soda-addons' ),
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => __( 'Alignment', 'soda-addons' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => __( 'Left', 'soda-addons' ),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title' => __( 'Center', 'soda-addons' ),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __( 'Right', 'soda-addons' ),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-back-button-wrapper' => 'justify-content: {{VALUE}};',
                ],
                'default'   => 'flex-start',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => __( 'Button', 'soda-addons' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .soda-back-button',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'soda-addons' ),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label'     => __( 'Text Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-back-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_background',
                'selector' => '{{WRAPPER}} .soda-back-button',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'soda-addons' ),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label'     => __( 'Text Color', 'soda-addons' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-back-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_hover_background',
                'selector' => '{{WRAPPER}} .soda-back-button:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'selector' => '{{WRAPPER}} .soda-back-button',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label'      => __( 'Border Radius', 'soda-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-back-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __( 'Padding', 'soda-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-back-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label'      => __( 'Margin', 'soda-addons' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .soda-back-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $button_text = ! empty( $settings['button_text'] ) ? $settings['button_text'] : __( 'Volver', 'soda-addons' );
        $classes     = [ 'soda-back-button' ];

        if ( 'yes' === $settings['show_icon'] && isset( $settings['icon_position'] ) && 'right' === $settings['icon_position'] ) {
            $classes[] = 'soda-back-button--icon-right';
        }

        $fallback = '';
        if ( ! empty( $settings['fallback_url']['url'] ) ) {
            $fallback = $settings['fallback_url']['url'];
        }

        $icon_markup = '';
        if ( 'yes' === $settings['show_icon'] && ! empty( $settings['button_icon']['value'] ) ) {
            ob_start();
            Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
            $icon_markup = '<span class="soda-back-button__icon">' . ob_get_clean() . '</span>';
        }

        $label_markup = '<span class="soda-back-button__label">' . esc_html( $button_text ) . '</span>';

        if ( 'yes' === $settings['show_icon'] && 'right' === $settings['icon_position'] ) {
            $content = $label_markup . $icon_markup;
        } else {
            $content = $icon_markup . $label_markup;
        }
        ?>
        <div class="soda-back-button-wrapper" style="display:flex;">
            <a
                class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
                href="#"
                data-fallback="<?php echo esc_url( $fallback ); ?>"
                role="button"
            >
                <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </a>
        </div>
        <?php
    }
}
