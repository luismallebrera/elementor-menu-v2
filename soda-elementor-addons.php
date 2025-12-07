<?php
/**
 * Plugin Name:       Soda Elementor Addons
 * Plugin URI:        https://github.com/luismallebrera/elementor-menu-v2
 * Description:       Collection of custom Elementor widgets including menu, galleries, and more
 * Version:           2.3.0
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Soda Studio
 * Author URI:        https://sodastudio.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       soda-elementor-addons
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Soda Elementor Addons Class
 */
final class Elementor_Menu_Widget_V2 {

    const VERSION = '2.3.0';
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';
    const MINIMUM_PHP_VERSION = '7.0';

    private static $_instance = null;

    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_main_plugin']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Register widget
        add_action('elementor/widgets/register', [$this, 'register_widgets']);

        // Register custom category
        add_action('elementor/elements/categories_registered', [$this, 'register_category']);

        // Register widget styles
        add_action('elementor/frontend/after_enqueue_styles', [$this, 'widget_styles']);

        // Register widget scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'widget_scripts']);

        // Load custom icons
        $this->load_custom_icons();

        // Load parallax background feature
        $this->load_parallax_background();

        // Load liquid glass module
        $this->load_liquid_glass();

        // Register custom image sizes
        add_action('after_setup_theme', [$this, 'register_custom_image_sizes']);

        // Auto-resize featured images for noticias CPT
        add_action('added_post_meta', [$this, 'resize_noticias_featured_image_on_set'], 10, 4);
        add_action('updated_post_meta', [$this, 'resize_noticias_featured_image_on_set'], 10, 4);

        $this->register_municipio_shortcodes();
    }

    public function load_custom_icons() {
        require_once(__DIR__ . '/modules/soda-addons-icons/icons-manager.php');
    }

    public function load_parallax_background() {
        require_once(__DIR__ . '/modules/parallax-background.php');
    }

    public function load_liquid_glass() {
        require_once(__DIR__ . '/modules/liquid-glass/liquid-glass.php');
        new \Elementor\Soda_Liquid_Glass();
    }

    public function register_category($elements_manager) {
        $elements_manager->add_category(
            'soda-addons',
            [
                'title' => __('Soda Addons', 'soda-elementor-addons'),
                'icon'  => 'fa fa-plug',
            ]
        );
    }

    public function admin_notice_missing_main_plugin() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(
            esc_html__('"%%1$s" requires "%%2$s" to be installed and activated.', 'soda-elementor-addons'),
            '<strong>' . esc_html__('Soda Elementor Addons', 'soda-elementor-addons') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'soda-elementor-addons') . '</strong>'
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(
            esc_html__('"%%1$s" requires "%%2$s" version %%3$s or greater.', 'soda-elementor-addons'),
            '<strong>' . esc_html__('Soda Elementor Addons', 'soda-elementor-addons') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'soda-elementor-addons') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(
            esc_html__('"%%1$s" requires "%%2$s" version %%3$s or greater.', 'soda-elementor-addons'),
            '<strong>' . esc_html__('Soda Elementor Addons', 'soda-elementor-addons') . '</strong>',
            '<strong>' . esc_html__('PHP', 'soda-elementor-addons') . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    public function register_widgets($widgets_manager) {
        // Auto-load all widgets from the widgets directory
        $widgets_dir = __DIR__ . '/widgets/';
        
        if (is_dir($widgets_dir)) {
            $widget_files = glob($widgets_dir . '*.php');
            
            foreach ($widget_files as $widget_file) {
                require_once($widget_file);
                
                $filename = basename($widget_file, '.php');
                
                // Handle menu-toggle-widget-v2.php (legacy naming without namespace)
                if ($filename === 'menu-toggle-widget-v2') {
                    if (class_exists('Elementor_Menu_Toggle_Widget_V2')) {
                        $widgets_manager->register(new \Elementor_Menu_Toggle_Widget_V2());
                    }
                    continue;
                }
                
                // All other widgets use SodaAddons\Widgets namespace
                $class_name = 'SodaAddons\Widgets\\' . $filename;
                
                if (class_exists($class_name)) {
                    $widgets_manager->register(new $class_name());
                }
            }
        }
    }

    public function widget_styles() {
        // Menu widget style
        wp_enqueue_style(
            'elementor-menu-widget-v2',
            plugins_url('assets/css/menu-widget-v2.css', __FILE__),
            [],
            self::VERSION
        );

        // CubePortfolio
        wp_register_style(
            'cubeportfolio-css',
            plugins_url('assets/css/cubeportfolio.min.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'cubeportfolio-filters-toggle-css',
            plugins_url('assets/css/filters-toggle.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-arrow-button',
            plugins_url('assets/css/arrow-button.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-reverse-columns-gallery',
            plugins_url('assets/css/reverse-columns-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'frontend-widgets',
            plugins_url('assets/css/frontend-widgets.min.css', __FILE__),
            [],
            self::VERSION
        );

        // Widget-specific styles
        wp_register_style(
            'soda-moving-gallery',
            plugins_url('assets/css/moving-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-pinned-gallery',
            plugins_url('assets/css/pinned-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-zoom-gallery',
            plugins_url('assets/css/zoom-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-horizontal-gallery',
            plugins_url('assets/css/horizontal-gallery.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-portfolio-grid',
            plugins_url('assets/css/portfolio-grid.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-magazine-grid',
            plugins_url('assets/css/magazine-grid.css', __FILE__),
            [],
            self::VERSION
        );

        wp_register_style(
            'soda-breadcrumbs',
            plugins_url('assets/css/breadcrumbs.css', __FILE__),
            [],
            self::VERSION
        );

        // Liquid Glass
        wp_register_style(
            'soda-liquid-glass',
            plugins_url('assets/css/liquid-glass.css', __FILE__),
            [],
            self::VERSION
        );

        // Soda Button
        wp_register_style(
            'soda-button',
            plugins_url('assets/css/soda-button.css', __FILE__),
            [],
            self::VERSION
        );
    }

    public function widget_scripts() {
        // Menu widget script
        wp_register_script(
            'elementor-menu-widget-v2',
            plugins_url('assets/js/menu-widget-v2.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        // GSAP and plugins
        wp_register_script(
            'soda-gsap',
            plugins_url('assets/js/gsap.min.js', __FILE__),
            [],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-scrollTrigger',
            plugins_url('assets/js/ScrollTrigger.min.js', __FILE__),
            ['soda-gsap'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-flip',
            plugins_url('assets/js/Flip.min.js', __FILE__),
            ['soda-gsap'],
            self::VERSION,
            true
        );

        // Isotope and related
        wp_register_script(
            'imagesloaded',
            plugins_url('assets/js/imagesloaded.pkgd.min.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        wp_register_script(
            'isotope',
            plugins_url('assets/js/isotope.pkgd.min.js', __FILE__),
            ['jquery', 'imagesloaded'],
            self::VERSION,
            true
        );

        wp_register_script(
            'packery-mode',
            plugins_url('assets/js/packery-mode.pkgd.min.js', __FILE__),
            ['isotope'],
            self::VERSION,
            true
        );

        // CubePortfolio
        wp_register_script(
            'cubeportfolio-js',
            plugins_url('assets/js/jquery.cubeportfolio.min.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        // Widget-specific scripts
        wp_register_script(
            'soda-moving-gallery',
            plugins_url('assets/js/moving-gallery.js', __FILE__),
            ['jquery', 'soda-gsap'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-pinned-gallery',
            plugins_url('assets/js/pinned-gallery.js', __FILE__),
            ['jquery', 'soda-gsap'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-zoom-gallery',
            plugins_url('assets/js/zoom-gallery.js', __FILE__),
            ['jquery', 'soda-gsap', 'soda-flip'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-horizontal-gallery',
            plugins_url('assets/js/horizontal-gallery.js', __FILE__),
            ['jquery', 'soda-gsap', 'soda-scrollTrigger'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-lottie-widget',
            plugins_url('assets/js/lottie-player.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-portfolio-grid',
            plugins_url('assets/js/portfolio-grid.js', __FILE__),
            ['jquery', 'isotope'],
            self::VERSION,
            true
        );

        wp_register_script(
            'soda-magazine-grid',
            plugins_url('assets/js/magazine-grid.js', __FILE__),
            ['jquery'],
            self::VERSION,
            true
        );

        wp_register_script(
            'isotope-grid',
            plugins_url('assets/js/isotope-grid.js', __FILE__),
            ['jquery', 'isotope'],
            self::VERSION,
            true
        );

        // Liquid Glass
        wp_register_script(
            'soda-liquid-glass',
            plugins_url('assets/js/liquid-glass.js', __FILE__),
            ['elementor-frontend'],
            self::VERSION,
            true
        );
    }

    /**
     * Register custom image sizes
     */
    public function register_custom_image_sizes() {
        // Add custom image size for noticias CPT
        add_image_size('noticias-featured', 850, 467, true);
    }

    /**
     * Resize featured images for noticias custom post type when set
     */
    public function resize_noticias_featured_image_on_set($meta_id, $post_id, $meta_key, $meta_value) {
        // Only process _thumbnail_id meta key (featured image)
        if ($meta_key !== '_thumbnail_id') {
            return;
        }

        // Check if this is a 'noticias' post
        $post = get_post($post_id);
        if (!$post || $post->post_type !== 'noticias') {
            return;
        }

        // Get the attachment ID (featured image)
        $attachment_id = intval($meta_value);
        if (!$attachment_id) {
            return;
        }

        // Check if we've already processed this image for this post (prevent infinite loops)
        $processed_key = '_noticias_image_processed_' . $attachment_id;
        if (get_post_meta($post_id, $processed_key, true)) {
            return;
        }

        // Mark as processing
        update_post_meta($post_id, $processed_key, '1');

        // Check if this is an image
        if (!wp_attachment_is_image($attachment_id)) {
            return;
        }

        // Get the image file path
        $file_path = get_attached_file($attachment_id);
        if (!$file_path || !file_exists($file_path)) {
            return;
        }

        // Load WordPress image editor
        $image_editor = wp_get_image_editor($file_path);
        if (is_wp_error($image_editor)) {
            return;
        }

        // Get current image dimensions
        $image_size = $image_editor->get_size();
        $current_width = $image_size['width'];
        $current_height = $image_size['height'];

        // Target dimensions
        $target_width = 850;
        $target_height = 467;

        // Check if already at target size
        if ($current_width === $target_width && $current_height === $target_height) {
            return;
        }

        // Calculate aspect ratios
        $current_ratio = $current_width / $current_height;
        $target_ratio = $target_width / $target_height;

        // Resize and crop to exact dimensions
        // First, resize so the smallest side matches the target while maintaining aspect ratio
        if ($current_ratio > $target_ratio) {
            // Image is wider - scale by height, then crop width
            $resize_width = round($target_height * $current_ratio);
            $resize_height = $target_height;
        } else {
            // Image is taller - scale by width, then crop height
            $resize_width = $target_width;
            $resize_height = round($target_width / $current_ratio);
        }

        // Resize first
        $resize_result = $image_editor->resize($resize_width, $resize_height, false);
        
        if (is_wp_error($resize_result)) {
            delete_post_meta($post_id, $processed_key);
            return;
        }

        // Now crop to exact dimensions from center
        $crop_x = max(0, round(($resize_width - $target_width) / 2));
        $crop_y = max(0, round(($resize_height - $target_height) / 2));
        
        $crop_result = $image_editor->crop($crop_x, $crop_y, $target_width, $target_height);
        
        if (is_wp_error($crop_result)) {
            delete_post_meta($post_id, $processed_key);
            return;
        }

        // Save the resized and cropped image (overwrite original)
        $saved = $image_editor->save($file_path);
        
        if (!is_wp_error($saved)) {
            // Convert to WebP format
            $this->convert_to_webp($file_path, $attachment_id);
            
            // Regenerate metadata with new dimensions
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $metadata = wp_generate_attachment_metadata($attachment_id, $file_path);
            wp_update_attachment_metadata($attachment_id, $metadata);
            
            // Clear any cached sizes
            clean_attachment_cache($attachment_id);
        } else {
            // If save failed, remove the processed flag so it can retry
            delete_post_meta($post_id, $processed_key);
        }
    }

    /**
     * Convert image to WebP format
     */
    private function convert_to_webp($original_file, $attachment_id) {
        // Check if GD or Imagick supports WebP
        if (!function_exists('imagewebp') && !extension_loaded('imagick')) {
            return false;
        }

        // Get file info
        $path_info = pathinfo($original_file);
        $webp_file = $path_info['dirname'] . '/' . $path_info['filename'] . '.webp';

        // Load the image editor
        $image_editor = wp_get_image_editor($original_file);
        if (is_wp_error($image_editor)) {
            return false;
        }

        // Set output format to WebP
        $image_editor->set_mime_type('image/webp');
        
        // Set WebP quality to 70%
        $image_editor->set_quality(70);
        
        // Save as WebP with 70% quality
        $saved = $image_editor->save($webp_file, 'image/webp');
        
        if (!is_wp_error($saved)) {
            // Update attachment to point to WebP file
            update_attached_file($attachment_id, $webp_file);
            
            // Update post mime type
            wp_update_post([
                'ID' => $attachment_id,
                'post_mime_type' => 'image/webp'
            ]);
            
            // Delete the original file to save space
            if (file_exists($original_file) && $original_file !== $webp_file) {
                @unlink($original_file);
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Register shortcodes to expose municipio related data inside popups.
     */
    private function register_municipio_shortcodes() {
        add_shortcode('municipio_galgdr_name', [$this, 'shortcode_municipio_galgdr_name']);
        add_shortcode('municipio_provincia_name', [$this, 'shortcode_municipio_provincia_name']);
    }

    /**
     * Resolve the municipio ID from shortcode attributes, query string, or current post.
     *
     * @param array $atts Shortcode attributes.
     * @return int
     */
    private function resolve_municipio_context_id($atts) {
        if (isset($atts['id'])) {
            return absint($atts['id']);
        }

        if (isset($_GET['municipio_id'])) {
            return absint(wp_unslash($_GET['municipio_id']));
        }

        $queried = get_queried_object();
        if ($queried instanceof \WP_Post && $queried->post_type === 'municipio') {
            return (int) $queried->ID;
        }

        return 0;
    }

    /**
     * Attempt to resolve a taxonomy term name using its ID.
     *
     * @param int $term_id Term identifier.
     * @return string
     */
    private function resolve_term_name($term_id) {
        $term_id = absint($term_id);
        if (!$term_id) {
            return '';
        }

        $taxonomies = get_taxonomies([], 'names');
        foreach ($taxonomies as $taxonomy) {
            $term = get_term_by('id', $term_id, $taxonomy);
            if ($term && ! is_wp_error($term)) {
                return $term->name;
            }
        }

        return '';
    }

    /**
     * Shortcode callback that renders the GAL/GDR name linked to a municipio.
     *
     * @param array $atts Shortcode attributes.
     * @return string
     */
    public function shortcode_municipio_galgdr_name($atts = []) {
        $municipio_id = $this->resolve_municipio_context_id($atts);
        if (!$municipio_id) {
            return '';
        }

        $gal_id = get_post_meta($municipio_id, '_municipio_galgdr_asociado', true);
        if (empty($gal_id)) {
            return '';
        }

        $name = '';

        if (is_numeric($gal_id)) {
            $related_post = get_post((int) $gal_id);
            if ($related_post instanceof \WP_Post) {
                $name = $related_post->post_title;
            }
            if ($name === '') {
                $name = $this->resolve_term_name((int) $gal_id);
            }
        }

        if ($name === '' && is_string($gal_id)) {
            $name = $gal_id;
        }

        return $name !== '' ? esc_html($name) : '';
    }

    /**
     * Shortcode callback that renders the provincia name linked to a municipio.
     *
     * @param array $atts Shortcode attributes.
     * @return string
     */
    public function shortcode_municipio_provincia_name($atts = []) {
        $municipio_id = $this->resolve_municipio_context_id($atts);
        if (!$municipio_id) {
            return '';
        }

        $province_id = get_post_meta($municipio_id, '_municipio_provincia', true);
        if (empty($province_id)) {
            return '';
        }

        $name = '';

        if (is_numeric($province_id)) {
            $related_post = get_post((int) $province_id);
            if ($related_post instanceof \WP_Post) {
                $name = $related_post->post_title;
            }
            if ($name === '') {
                $name = $this->resolve_term_name((int) $province_id);
            }
        }

        if ($name === '' && is_string($province_id)) {
            $name = $province_id;
        }

        return $name !== '' ? esc_html($name) : '';
    }
}

Elementor_Menu_Widget_V2::instance();
