<?php
namespace SodaAddons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Municipio_Search_Widget extends Widget_Base {

	/**
	 * Track whether the frontend search script has been enqueued.
	 *
	 * @var bool
	 */
	private static $search_script_enqueued = false;

	/**
	 * Widget slug.
	 */
	public function get_name() {
		return 'soda-municipio-search';
	}

	/**
	 * Widget title.
	 */
	public function get_title() {
		return __( 'Municipio Search', 'soda-addons' );
	}

	/**
	 * Widget icon.
	 */
	public function get_icon() {
		return 'eicon-search';
	}

	/**
	 * Widget categories.
	 */
	public function get_categories() {
		return [ 'soda-addons' ];
	}

	/**
	 * Widget keywords.
	 */
	public function get_keywords() {
		return [ 'municipio', 'search', 'popup', 'province', 'selector' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'soda-addons' ),
			]
		);

		$province_options = $this->get_province_options();

		$this->add_control(
			'province_label',
			[
				'label' => __( 'Province Label', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Provincia', 'soda-addons' ),
			]
		);

		$this->add_control(
			'province_placeholder',
			[
				'label' => __( 'Province Placeholder', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Selecciona provincia', 'soda-addons' ),
			]
		);

		$this->add_control(
			'provinces',
			[
				'label' => __( 'Provinces', 'soda-addons' ),
				'type' => Controls_Manager::SELECT2,
				'options' => $province_options,
				'multiple' => true,
				'label_block' => true,
				'description' => __( 'Selecciona las provincias disponibles en el buscador. Si lo dejas vacío se mostrarán todas las que existan.', 'soda-addons' ),
			]
		);

		$this->add_control(
			'municipio_label',
			[
				'label' => __( 'Municipality Label', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Municipio', 'soda-addons' ),
			]
		);

		$this->add_control(
			'municipio_placeholder',
			[
				'label' => __( 'Municipality Placeholder', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Selecciona municipio', 'soda-addons' ),
			]
		);

		$this->add_control(
			'no_results_text',
			[
				'label' => __( 'Empty Results Text', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'No hay municipios disponibles.', 'soda-addons' ),
			]
		);

		$this->add_control(
			'error_text',
			[
				'label' => __( 'Error Message', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'No se pudieron cargar los municipios. Inténtalo de nuevo.', 'soda-addons' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'popup_section',
			[
				'label' => __( 'Popup', 'soda-addons' ),
			]
		);

		$this->add_control(
			'popup_anchor',
			[
				'label' => __( 'Popup Anchor', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '#popup-7468',
				'description' => __( 'Anchor del popup de Elementor (ejemplo: #popup-7468).', 'soda-addons' ),
			]
		);

		$this->add_control(
			'popup_query_param',
			[
				'label' => __( 'Query Parameter', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'municipio_id',
				'description' => __( 'Nombre del parámetro que recibirá el ID del municipio.', 'soda-addons' ),
			]
		);

		$this->add_control(
			'popup_dynamic_content',
			[
				'label' => __( 'Actualizar contenido dinámico', 'soda-addons' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'popup_selector_title',
			[
				'label' => __( 'Selector título', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '.popup-municipio-title .elementor-heading-title',
				'condition' => [ 'popup_dynamic_content' => 'yes' ],
			]
		);

		$this->add_control(
			'popup_selector_content',
			[
				'label' => __( 'Selector contenido', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => '.popup-municipio-content',
				'condition' => [ 'popup_dynamic_content' => 'yes' ],
			]
		);

		$this->add_control(
			'popup_selector_excerpt',
			[
				'label' => __( 'Selector extracto', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [ 'popup_dynamic_content' => 'yes' ],
			]
		);

		$this->add_control(
			'popup_selector_featured_image',
			[
				'label' => __( 'Selector imagen destacada', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'condition' => [ 'popup_dynamic_content' => 'yes' ],
			]
		);

		$meta_repeater = new Repeater();
		$meta_repeater->add_control(
			'popup_meta_key',
			[
				'label' => __( 'Meta key', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '_municipio_provincia',
			]
		);
		$meta_repeater->add_control(
			'popup_meta_selector',
			[
				'label' => __( 'Selector CSS', 'soda-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => '.selector-clase',
			]
		);

		$this->add_control(
			'popup_meta_fields',
			[
				'label' => __( 'Campos meta', 'soda-addons' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $meta_repeater->get_controls(),
				'condition' => [ 'popup_dynamic_content' => 'yes' ],
				'title_field' => '{{{ popup_meta_key }}}',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$province_label = ! empty( $settings['province_label'] ) ? $settings['province_label'] : __( 'Provincia', 'soda-addons' );
		$province_placeholder = ! empty( $settings['province_placeholder'] ) ? $settings['province_placeholder'] : __( 'Selecciona provincia', 'soda-addons' );
		$municipio_label = ! empty( $settings['municipio_label'] ) ? $settings['municipio_label'] : __( 'Municipio', 'soda-addons' );
		$municipio_placeholder = ! empty( $settings['municipio_placeholder'] ) ? $settings['municipio_placeholder'] : __( 'Selecciona municipio', 'soda-addons' );
		$no_results_text = ! empty( $settings['no_results_text'] ) ? $settings['no_results_text'] : __( 'No hay municipios disponibles.', 'soda-addons' );
		$error_text = ! empty( $settings['error_text'] ) ? $settings['error_text'] : __( 'No se pudieron cargar los municipios. Inténtalo de nuevo.', 'soda-addons' );

		$selected_provinces = [];
		if ( ! empty( $settings['provinces'] ) && is_array( $settings['provinces'] ) ) {
			$selected_provinces = array_values( array_filter( array_map( 'absint', $settings['provinces'] ) ) );
		}

		$all_provinces = $this->get_province_options();
		$province_options = [];

		if ( ! empty( $selected_provinces ) ) {
			foreach ( $selected_provinces as $province_id ) {
				if ( isset( $all_provinces[ $province_id ] ) ) {
					$province_options[ $province_id ] = $all_provinces[ $province_id ];
				}
			}
		}

		if ( empty( $province_options ) ) {
			$province_options = $all_provinces;
		}

		if ( empty( $province_options ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<div class="soda-municipio-search__notice">' . esc_html__( 'No se encontraron provincias para mostrar.', 'soda-addons' ) . '</div>';
			}
			return;
		}

		$post_type = 'municipio';
		$popup_anchor = isset( $settings['popup_anchor'] ) ? $settings['popup_anchor'] : '#popup-7468';
		$popup_query_param = isset( $settings['popup_query_param'] ) ? $settings['popup_query_param'] : 'municipio_id';
		$popup_dynamic = isset( $settings['popup_dynamic_content'] ) && 'yes' === $settings['popup_dynamic_content'];

		$popup_selectors = [
			'title' => isset( $settings['popup_selector_title'] ) ? trim( $settings['popup_selector_title'] ) : '',
			'content' => isset( $settings['popup_selector_content'] ) ? trim( $settings['popup_selector_content'] ) : '',
			'excerpt' => isset( $settings['popup_selector_excerpt'] ) ? trim( $settings['popup_selector_excerpt'] ) : '',
			'featured_image' => isset( $settings['popup_selector_featured_image'] ) ? trim( $settings['popup_selector_featured_image'] ) : '',
		];
		$popup_selectors = array_filter( $popup_selectors );

		$popup_meta_fields = [];
		if ( ! empty( $settings['popup_meta_fields'] ) && is_array( $settings['popup_meta_fields'] ) ) {
			foreach ( $settings['popup_meta_fields'] as $meta_item ) {
				if ( empty( $meta_item['popup_meta_key'] ) || empty( $meta_item['popup_meta_selector'] ) ) {
					continue;
				}
				$meta_key = sanitize_key( $meta_item['popup_meta_key'] );
				$meta_selector = trim( $meta_item['popup_meta_selector'] );
				if ( empty( $meta_key ) || empty( $meta_selector ) ) {
					continue;
				}
				$popup_meta_fields[ $meta_key ] = $meta_selector;
			}
		}

		$popup_config = null;
		$anchor = ! empty( $popup_anchor ) ? $popup_anchor : '#popup';
		$param = sanitize_key( $popup_query_param );
		if ( empty( $param ) ) {
			$param = 'municipio_id';
		}

		$popup_id_from_anchor = null;
		if ( preg_match( '/([0-9]+)/', $anchor, $matches ) ) {
			$popup_id_from_anchor = (int) $matches[1];
		}

		$popup_config = [
			'widgetId' => $this->get_id(),
			'popupId' => $popup_id_from_anchor,
			'paramKey' => $param,
			'postType' => $post_type,
			'delivery' => 'query',
			'dynamic' => false,
		];

		if ( ! empty( $popup_meta_fields ) ) {
			$popup_config['meta'] = $popup_meta_fields;
			Entry_List_Widget::register_popup_meta_keys( $post_type, array_keys( $popup_meta_fields ) );
		}

		$post_type_object = get_post_type_object( $post_type );
		if ( $popup_dynamic && ( ! empty( $popup_selectors ) || ! empty( $popup_meta_fields ) ) && $post_type_object && ! empty( $post_type_object->show_in_rest ) ) {
			$rest_namespace = ! empty( $post_type_object->rest_namespace ) ? $post_type_object->rest_namespace : 'wp/v2';
			$rest_base = ! empty( $post_type_object->rest_base ) ? $post_type_object->rest_base : $post_type;
			$rest_route = rest_url( trailingslashit( sprintf( '%s/%s', trim( $rest_namespace, '/' ), trim( $rest_base, '/' ) ) ) );

			$popup_config['dynamic'] = true;
			$popup_config['restUrl'] = esc_url_raw( $rest_route );
			$popup_config['selectors'] = $popup_selectors;
		}

		$popup_configuration_script = 'window.SodaEntryListPopupConfig = window.SodaEntryListPopupConfig || {}; window.SodaEntryListPopupConfig["' . esc_js( $this->get_id() ) . '"] = ' . wp_json_encode( $popup_config ) . ';';
		wp_add_inline_script( 'elementor-frontend', $popup_configuration_script, 'after' );
		Entry_List_Widget::enqueue_popup_script();

		$search_config = [
			'widgetId' => $this->get_id(),
			'restUrl' => esc_url_raw( rest_url( 'soda/v1/municipios' ) ),
			'municipioPlaceholder' => $municipio_placeholder,
			'noResultsText' => $no_results_text,
			'errorText' => $error_text,
			'popupWidgetId' => $this->get_id(),
		];

		$search_config_script = 'window.SodaMunicipioSearchConfig = window.SodaMunicipioSearchConfig || {}; window.SodaMunicipioSearchConfig["' . esc_js( $this->get_id() ) . '"] = ' . wp_json_encode( $search_config ) . ';';
		wp_add_inline_script( 'elementor-frontend', $search_config_script, 'after' );

		if ( ! self::$search_script_enqueued ) {
			$script = <<<'JS'
(function(){
	if (window.SodaMunicipioSearchInit) {
		return;
	}

	window.SodaMunicipioSearchInit = true;
	window.SodaMunicipioSearchConfig = window.SodaMunicipioSearchConfig || {};

	function getConfigFromElement(element) {
		var container = element.closest('.soda-municipio-search');
		if (!container) {
			return null;
		}
		var widgetId = container.getAttribute('data-widget-id');
		if (!widgetId) {
			return null;
		}
		var config = window.SodaMunicipioSearchConfig[widgetId] || null;
		return {
			container: container,
			widgetId: widgetId,
			config: config
		};
	}

	function resetMunicipioSelect(select, placeholder) {
		if (!select) {
			return;
		}
		select.innerHTML = '';
		var option = document.createElement('option');
		option.value = '';
		option.textContent = placeholder || '';
		select.appendChild(option);
		select.disabled = true;
	}

	function populateMunicipioSelect(select, items, placeholder) {
		resetMunicipioSelect(select, placeholder);
		if (!select || !Array.isArray(items) || items.length === 0) {
			return;
		}
		select.disabled = false;
		for (var i = 0; i < items.length; i++) {
			var item = items[i];
			if (!item || !item.id) {
				continue;
			}
			var option = document.createElement('option');
			option.value = item.id;
			option.textContent = item.title || '';
			select.appendChild(option);
		}
	}

	function setMessage(container, message) {
		if (!container) {
			return;
		}
		var messageElement = container.querySelector('[data-role="soda-municipio-message"]');
		if (!messageElement) {
			return;
		}
		messageElement.textContent = message || '';
	}

	document.addEventListener('change', function(event){
		if (event.target.matches('.soda-municipio-search__province-select')) {
			handleProvinceChange(event.target);
		} else if (event.target.matches('.soda-municipio-search__municipio-select')) {
			handleMunicipioChange(event.target);
		}
	});

	function handleProvinceChange(select) {
		var context = getConfigFromElement(select);
		if (!context || !context.config) {
			return;
		}

		var municipioSelect = context.container.querySelector('.soda-municipio-search__municipio-select');
		if (!municipioSelect) {
			return;
		}

		setMessage(context.container, '');
		var provinceId = select.value ? parseInt(select.value, 10) : 0;
		resetMunicipioSelect(municipioSelect, context.config.municipioPlaceholder);

		if (!provinceId) {
			return;
		}

		context.container.classList.add('is-loading');

		var endpoint = context.config.restUrl + '?province=' + encodeURIComponent(provinceId);

		fetch(endpoint, { credentials: 'same-origin' })
			.then(function(response){
				if (!response.ok) {
					throw new Error('Request failed');
				}
				return response.json();
			})
			.then(function(data){
				var items = data && Array.isArray(data.items) ? data.items : [];
				if (!items.length) {
					setMessage(context.container, context.config.noResultsText || '');
				}
				populateMunicipioSelect(municipioSelect, items, context.config.municipioPlaceholder);
			})
			.catch(function(){
				setMessage(context.container, context.config.errorText || '');
			})
			.finally(function(){
				context.container.classList.remove('is-loading');
			});
	}

	function handleMunicipioChange(select) {
		var context = getConfigFromElement(select);
		if (!context || !context.config) {
			return;
		}
		var municipioId = select.value ? parseInt(select.value, 10) : 0;
		if (!municipioId) {
			return;
		}
		if (typeof window.SodaEntryListPopupOpen === 'function') {
			window.SodaEntryListPopupOpen(context.config.popupWidgetId, municipioId);
		}
	}
})();
JS;
			wp_add_inline_script( 'elementor-frontend', $script, 'after' );
			self::$search_script_enqueued = true;
		}

		$widget_id_attr = 'soda-municipio-search-' . $this->get_id();

		?>
		<div class="soda-municipio-search" data-widget-id="<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="soda-municipio-search__field">
				<label class="soda-municipio-search__label" for="<?php echo esc_attr( $widget_id_attr . '-province' ); ?>"><?php echo esc_html( $province_label ); ?></label>
				<select id="<?php echo esc_attr( $widget_id_attr . '-province' ); ?>" class="soda-municipio-search__province-select">
					<option value=""><?php echo esc_html( $province_placeholder ); ?></option>
					<?php foreach ( $province_options as $province_id => $province_name ) : ?>
						<option value="<?php echo esc_attr( $province_id ); ?>"><?php echo esc_html( $province_name ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="soda-municipio-search__field">
				<label class="soda-municipio-search__label" for="<?php echo esc_attr( $widget_id_attr . '-municipio' ); ?>"><?php echo esc_html( $municipio_label ); ?></label>
				<select id="<?php echo esc_attr( $widget_id_attr . '-municipio' ); ?>" class="soda-municipio-search__municipio-select" disabled>
					<option value=""><?php echo esc_html( $municipio_placeholder ); ?></option>
				</select>
			</div>
			<div class="soda-municipio-search__feedback" data-role="soda-municipio-message" aria-live="polite"></div>
		</div>
		<?php
	}

	/**
	 * Retrieve available provinces from posts or taxonomy.
	 *
	 * @return array
	 */
	private function get_province_options() {
		$options = [];

		if ( post_type_exists( 'provincia' ) ) {
			$posts = get_posts(
				[
					'post_type' => 'provincia',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'orderby' => 'title',
					'order' => 'ASC',
				]
			);

			foreach ( $posts as $post ) {
				$options[ $post->ID ] = $post->post_title;
			}
		}

		if ( empty( $options ) && taxonomy_exists( 'provincia' ) ) {
			$terms = get_terms(
				[
					'taxonomy' => 'provincia',
					'hide_empty' => false,
				]
			);

			if ( ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$options[ $term->term_id ] = $term->name;
				}
			}
		}

		return $options;
	}
}
