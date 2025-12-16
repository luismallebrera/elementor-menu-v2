<?php
namespace SodaAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Breadcrumbs Widget
 * 
 * Displays a breadcrumb navigation with customizable styling
 */
class Breadcrumbs extends Widget_Base {

    public function get_name() {
        return 'soda_breadcrumbs';
    }

    public function get_title() {
        return __('Breadcrumbs', 'soda-elementor-addons');
    }

    public function get_icon() {
        return 'eicon-navigation-horizontal';
    }

    public function get_categories() {
        return ['soda-addons'];
    }

    protected function register_controls() {
        
        // ========== CONTENT SECTION ==========
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Breadcrumbs', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_home',
            [
                'label' => __('Show Home', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'home_text',
            [
                'label' => __('Home Text', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Home', 'soda-elementor-addons'),
                'condition' => [
                    'show_home' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'home_icon',
            [
                'label' => __('Home Icon', 'soda-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-home',
                    'library' => 'solid',
                ],
                'condition' => [
                    'show_home' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'custom_link_text',
            [
                'label' => __('Custom Link Text', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., mi-sitio', 'soda-elementor-addons'),
                'description' => __('Add a custom link after Home (e.g., /mi-sitio/)', 'soda-elementor-addons'),
                'condition' => [
                    'show_home' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'custom_link_url',
            [
                'label' => __('Custom Link URL', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('e.g., /mi-sitio/', 'soda-elementor-addons'),
                'description' => __('URL for the custom link', 'soda-elementor-addons'),
                'condition' => [
                    'show_home' => 'yes',
                    'custom_link_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'custom_link_position',
            [
                'label' => __('Custom Link Position', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'after_home' => __('After Home', 'soda-elementor-addons'),
                    'end' => __('End of Trail', 'soda-elementor-addons'),
                ],
                'default' => 'after_home',
                'condition' => [
                    'show_home' => 'yes',
                    'custom_link_text!' => '',
                ],
            ]
        );

        $this->add_control(
            'separator',
            [
                'label' => __('Separator', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '/' => '/',
                    '>' => '>',
                    '»' => '»',
                    '›' => '›',
                    '|' => '|',
                    '-' => '-',
                    '→' => '→',
                    'custom' => __('Custom', 'soda-elementor-addons'),
                ],
                'default' => '/',
            ]
        );

        $this->add_control(
            'separator_custom',
            [
                'label' => __('Custom Separator', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '/',
                'condition' => [
                    'separator' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'separator_icon',
            [
                'label' => __('Separator Icon', 'soda-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'separator' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'shorten_title',
            [
                'label' => __('Shorten Current Page Title', 'soda-elementor-addons'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'soda-elementor-addons'),
                'label_off' => __('No', 'soda-elementor-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'shorten_method',
            [
                'label' => __('Shorten By', 'soda-elementor-addons'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'characters' => __('Characters', 'soda-elementor-addons'),
                    'words' => __('Words', 'soda-elementor-addons'),
                ],
                'default' => 'characters',
                'condition' => [
                    'shorten_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'max_title_length',
            [
                'label' => __('Max Characters', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 50,
                'min' => 10,
                'max' => 200,
                'condition' => [
                    'shorten_title' => 'yes',
                    'shorten_method' => 'characters',
                ],
            ]
        );

        $this->add_control(
            'max_title_words',
            [
                'label' => __('Max Words', 'soda-elementor-addons'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'min' => 1,
                'max' => 100,
                'condition' => [
                    'shorten_title' => 'yes',
                    'shorten_method' => 'words',
                ],
            ]
        );

        $this->add_control(
            'title_suffix',
            [
                'label' => __('Title Suffix', 'soda-elementor-addons'),
                'type' => Controls_Manager::TEXT,
                'default' => '...',
                'condition' => [
                    'shorten_title' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: CONTAINER ==========
        $this->start_controls_section(
            'section_style_container',
            [
                'label' => __('Container', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => __('Alignment', 'soda-elementor-addons'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'soda-elementor-addons'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'container_padding',
            [
                'label' => __('Padding', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'container_background',
            [
                'label' => __('Background Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'container_border_radius',
            [
                'label' => __('Border Radius', 'soda-elementor-addons'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: ITEMS ==========
        $this->start_controls_section(
            'section_style_items',
            [
                'label' => __('Items', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'items_typography',
                'selector' => '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-item',
            ]
        );

        $this->add_responsive_control(
            'items_spacing',
            [
                'label' => __('Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-item' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('items_style_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'items_normal',
            [
                'label' => __('Normal', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'items_color',
            [
                'label' => __('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#555555',
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-item a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'items_hover',
            [
                'label' => __('Hover', 'soda-elementor-addons'),
            ]
        );

        $this->add_control(
            'items_hover_color',
            [
                'label' => __('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-item a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'items_text_shadow',
                'selector' => '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-item a',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: CURRENT PAGE ==========
        $this->start_controls_section(
            'section_style_current',
            [
                'label' => __('Current Page', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'current_typography',
                'selector' => '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-item.current',
            ]
        );

        $this->add_control(
            'current_color',
            [
                'label' => __('Text Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-item.current' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'current_text_shadow',
                'selector' => '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-item.current',
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: SEPARATOR ==========
        $this->start_controls_section(
            'section_style_separator',
            [
                'label' => __('Separator', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'separator_typography',
                'selector' => '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-separator',
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label' => __('Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'default' => '#999999',
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-separator' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'separator_spacing',
            [
                'label' => __('Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-separator' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ========== STYLE: ICONS ==========
        $this->start_controls_section(
            'section_style_icons',
            [
                'label' => __('Icons', 'soda-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Size', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => __('Spacing', 'soda-elementor-addons'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'soda-elementor-addons'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .soda-breadcrumbs .breadcrumb-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Get breadcrumb trail
     */
    private function get_breadcrumb_trail() {
        $trail = [];
        
        // Home
        $trail[] = [
            'title' => get_bloginfo('name'),
            'url' => home_url('/'),
            'is_home' => true,
        ];

        if (is_front_page()) {
            return $trail;
        }

        // Post types
        if (is_singular()) {
            $post = get_queried_object();
            
            // Add post type archive if not post
            if ($post->post_type !== 'post') {
                $post_type_object = get_post_type_object($post->post_type);
                if ($post_type_object && $post_type_object->has_archive) {
                    $trail[] = [
                        'title' => $post_type_object->labels->name,
                        'url' => get_post_type_archive_link($post->post_type),
                    ];
                }
            }
            
            // Add categories for posts
            if ($post->post_type === 'post') {
                $categories = get_the_category($post->ID);
                if (!empty($categories)) {
                    $trail[] = [
                        'title' => $categories[0]->name,
                        'url' => get_category_link($categories[0]->term_id),
                    ];
                }
            }
            
            // Add taxonomies for custom post types
            if ($post->post_type !== 'post' && $post->post_type !== 'page') {
                $taxonomies = get_object_taxonomies($post->post_type);
                if (!empty($taxonomies)) {
                    $terms = get_the_terms($post->ID, $taxonomies[0]);
                    if ($terms && !is_wp_error($terms)) {
                        $trail[] = [
                            'title' => $terms[0]->name,
                            'url' => get_term_link($terms[0]),
                        ];
                    }
                }
            }
            
            // Current page
            $trail[] = [
                'title' => get_the_title(),
                'url' => '',
                'is_current' => true,
            ];
        }
        // Archives
        elseif (is_archive()) {
            if (is_category() || is_tag() || is_tax()) {
                $term = get_queried_object();
                $trail[] = [
                    'title' => $term->name,
                    'url' => '',
                    'is_current' => true,
                ];
            } elseif (is_post_type_archive()) {
                $post_type = get_queried_object();
                $trail[] = [
                    'title' => $post_type->labels->name,
                    'url' => '',
                    'is_current' => true,
                ];
            }
        }
        // Search
        elseif (is_search()) {
            $trail[] = [
                'title' => sprintf(__('Search Results for: %s', 'soda-elementor-addons'), get_search_query()),
                'url' => '',
                'is_current' => true,
            ];
        }
        // 404
        elseif (is_404()) {
            $trail[] = [
                'title' => __('404 Not Found', 'soda-elementor-addons'),
                'url' => '',
                'is_current' => true,
            ];
        }

        return $trail;
    }

    /**
     * Shorten text
     */
    private function shorten_text($text, array $args = []) {
        $defaults = [
            'method' => 'characters',
            'max_characters' => 50,
            'max_words' => 10,
            'suffix' => '...'
        ];

        $options = array_merge($defaults, $args);

        $text = trim(wp_strip_all_tags($text));

        if ($text === '') {
            return $text;
        }

        $charset = get_bloginfo('charset') ?: 'UTF-8';
        $text = html_entity_decode($text, ENT_QUOTES, $charset);

        if ($options['method'] === 'words') {
            $word_limit = max(1, (int) $options['max_words']);
            return wp_trim_words($text, $word_limit, $options['suffix']);
        }

        $max_length = max(0, (int) $options['max_characters']);

        if ($max_length === 0 || mb_strlen($text, 'UTF-8') <= $max_length) {
            return $text;
        }

        $excerpt = wp_html_excerpt($text, $max_length, '');
        $excerpt = trim(preg_replace('/\s+/u', ' ', $excerpt));

        if ($excerpt === '') {
            return mb_substr($text, 0, $max_length, 'UTF-8') . $options['suffix'];
        }

        if (mb_strlen($excerpt, 'UTF-8') < mb_strlen($text, 'UTF-8')) {
            if (!preg_match('/\s$/u', $excerpt)) {
                $last_space = mb_strrpos($excerpt, ' ', 0, 'UTF-8');
                if ($last_space !== false) {
                    $excerpt = mb_substr($excerpt, 0, $last_space, 'UTF-8');
                }
            }

            $excerpt = rtrim($excerpt, " \t\n\r\0\x0B.,;:-_/");

            if ($excerpt === '') {
                $excerpt = mb_substr($text, 0, $max_length, 'UTF-8');
            }

            return $excerpt . $options['suffix'];
        }

        return $excerpt;
    }

    /**
     * Render widget output
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $trail = $this->get_breadcrumb_trail();
        
        if (empty($trail)) {
            return;
        }

        // Get separator
        $separator = $settings['separator'] === 'custom' && !empty($settings['separator_custom']) 
            ? $settings['separator_custom'] 
            : $settings['separator'];
        
        $custom_text = isset($settings['custom_link_text']) ? trim($settings['custom_link_text']) : '';
        $custom_url = $settings['custom_link_url'] ?? '';
        $custom_position = $settings['custom_link_position'] ?? 'after_home';

        $render_trail = [];
        $custom_added = false;

        foreach ($trail as $index => $item) {
            $render_trail[] = $item;

            $should_insert_after_home = (
                !$custom_added &&
                $custom_text !== '' &&
                $custom_position === 'after_home' &&
                !empty($item['is_home']) &&
                $settings['show_home'] === 'yes'
            );

            if ($should_insert_after_home) {
                $render_trail[] = [
                    'title' => $custom_text,
                    'url' => $custom_url,
                    'is_custom' => true,
                ];
                $custom_added = true;
            }
        }

        if ($custom_text !== '' && !$custom_added) {
            $render_trail[] = [
                'title' => $custom_text,
                'url' => $custom_url,
                'is_custom' => true,
            ];
        }

        ?>
        <div class="soda-breadcrumbs">
            <?php
            $count = count($render_trail);
            foreach ($render_trail as $index => $item) :
                $is_last = ($index === $count - 1);
                $is_home = !empty($item['is_home']);
                $is_current = !empty($item['is_current']);

                if ($is_home && $settings['show_home'] !== 'yes') {
                    continue;
                }

                $title = $item['title'];
                if ($is_current && $settings['shorten_title'] === 'yes') {
                    $title = $this->shorten_text(
                        $title,
                        [
                            'method' => $settings['shorten_method'] ?? 'characters',
                            'max_characters' => isset($settings['max_title_length']) ? (int) $settings['max_title_length'] : 50,
                            'max_words' => isset($settings['max_title_words']) ? (int) $settings['max_title_words'] : 10,
                            'suffix' => $settings['title_suffix'] ?? '...'
                        ]
                    );
                }
                ?>

                <span class="breadcrumb-item<?php echo $is_current ? ' current' : ''; ?>">
                    <?php if (!$is_current && !empty($item['url'])) : ?>
                        <a href="<?php echo esc_url($item['url']); ?>">
                            <?php if ($is_home && !empty($settings['home_icon']['value'])) : ?>
                                <span class="breadcrumb-icon">
                                    <?php \Elementor\Icons_Manager::render_icon($settings['home_icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($is_home && !empty($settings['home_text'])) : ?>
                                <?php echo esc_html($settings['home_text']); ?>
                            <?php else : ?>
                                <?php echo esc_html($title); ?>
                            <?php endif; ?>
                        </a>
                    <?php else : ?>
                        <?php echo esc_html($title); ?>
                    <?php endif; ?>
                </span>

                <?php if (!$is_last) : ?>
                    <span class="breadcrumb-separator">
                        <?php if ($settings['separator'] === 'custom' && !empty($settings['separator_icon']['value'])) : ?>
                            <?php \Elementor\Icons_Manager::render_icon($settings['separator_icon'], ['aria-hidden' => 'true']); ?>
                        <?php else : ?>
                            <?php echo esc_html($separator); ?>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
        <?php
    }
}
