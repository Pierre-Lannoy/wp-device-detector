<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Plugin
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

namespace PODeviceDetector\Plugin;

use PODeviceDetector\Plugin\Feature\Analytics;
use PODeviceDetector\Plugin\Feature\AnalyticsFactory;
use PODeviceDetector\System\Assets;
use PODeviceDetector\System\Environment;
use PODeviceDetector\System\Logger;
use PODeviceDetector\System\Role;
use PODeviceDetector\System\Option;
use PODeviceDetector\System\Form;
use PODeviceDetector\System\Blog;
use PODeviceDetector\System\Date;
use PODeviceDetector\System\Timezone;
use PODeviceDetector\Plugin\Feature\CSSModifier;
use PerfOpsOne\AdminMenus;

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Plugin
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */
class Device_Detector_Admin {

	/**
	 * The assets manager that's responsible for handling all assets of the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Assets    $assets    The plugin assets manager.
	 */
	protected $assets;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->assets = new Assets();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		$this->assets->register_style( PODD_ASSETS_ID, PODD_ADMIN_URL, 'css/device-detector.min.css' );
		$this->assets->register_style( 'podd-daterangepicker', PODD_ADMIN_URL, 'css/daterangepicker.min.css' );
		$this->assets->register_style( 'podd-switchery', PODD_ADMIN_URL, 'css/switchery.min.css' );
		$this->assets->register_style( 'podd-tooltip', PODD_ADMIN_URL, 'css/tooltip.min.css' );
		$this->assets->register_style( 'podd-chartist', PODD_ADMIN_URL, 'css/chartist.min.css' );
		$this->assets->register_style( 'podd-chartist-tooltip', PODD_ADMIN_URL, 'css/chartist-plugin-tooltip.min.css' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		$this->assets->register_script( PODD_ASSETS_ID, PODD_ADMIN_URL, 'js/device-detector.min.js', [ 'jquery' ] );
		$this->assets->register_script( 'podd-moment-with-locale', PODD_ADMIN_URL, 'js/moment-with-locales.min.js', [ 'jquery' ] );
		$this->assets->register_script( 'podd-daterangepicker', PODD_ADMIN_URL, 'js/daterangepicker.min.js', [ 'jquery' ] );
		$this->assets->register_script( 'podd-switchery', PODD_ADMIN_URL, 'js/switchery.min.js', [ 'jquery' ] );
		$this->assets->register_script( 'podd-chartist', PODD_ADMIN_URL, 'js/chartist.min.js', [ 'jquery' ] );
		$this->assets->register_script( 'podd-chartist-tooltip', PODD_ADMIN_URL, 'js/chartist-plugin-tooltip.min.js', [ 'podd-chartist' ] );
	}

	/**
	 * Init PerfOps admin menus.
	 *
	 * @param array $perfops    The already declared menus.
	 * @return array    The completed menus array.
	 * @since 1.0.0
	 */
	public function init_perfops_admin_menus( $perfops ) {
		if ( Role::SUPER_ADMIN === Role::admin_type() || Role::SINGLE_ADMIN === Role::admin_type() || Role::LOCAL_ADMIN === Role::admin_type() ) {
			$perfops['settings'][] = [
				'name'          => PODD_PRODUCT_NAME,
				'description'   => '',
				'icon_callback' => [ \PODeviceDetector\Plugin\Core::class, 'get_base64_logo' ],
				'slug'          => 'podd-settings',
				/* translators: as in the sentence "Device Detector Settings" or "WordPress Settings" */
				'page_title'    => sprintf( esc_html__( '%s Settings', 'device-detector' ), PODD_PRODUCT_NAME ),
				'menu_title'    => PODD_PRODUCT_NAME,
				'capability'    => 'manage_options',
				'callback'      => [ $this, 'get_settings_page' ],
				'position'      => 50,
				'plugin'        => PODD_SLUG,
				'version'       => PODD_VERSION,
				'activated'     => true,
				'remedy'        => '',
				'statistics'    => [ '\PODeviceDetector\System\Statistics', 'sc_get_raw' ],
			];
			$perfops['analytics'][] = [
				'name'          => esc_html__( 'Devices', 'device-detector' ),
				/* translators: as in the sentence "Find out the detail of devices accessing your network." or "Find out the detail of devices accessing your website." */
				'description'   => sprintf( esc_html__( 'Find out the detail of devices accessing your %s.', 'device-detector' ), Environment::is_wordpress_multisite() ? esc_html__( 'network', 'device-detector' ) : esc_html__( 'website', 'device-detector' ) ),
				'icon_callback' => [ \PODeviceDetector\Plugin\Core::class, 'get_base64_logo' ],
				'slug'          => 'podd-viewer',
				/* translators: as in the sentence "DecaLog Viewer" */
				'page_title'    => esc_html__( 'Devices Analytics', 'device-detector' ),
				'menu_title'    => esc_html__( 'Devices', 'device-detector' ),
				'capability'    => 'manage_options',
				'callback'      => [ $this, 'get_viewer_page' ],
				'position'      => 50,
				'plugin'        => PODD_SLUG,
				'activated'     => true,
				'remedy'        => '',
			];
		}
		$perfops['tools'][] = [
			'name'          => esc_html__( 'Devices', 'device-detector' ),
			'description'   => esc_html__( 'Test user-agent strings to see devices details.', 'device-detector' ),
			'icon_callback' => [ \PODeviceDetector\Plugin\Core::class, 'get_base64_logo' ],
			'slug'          => 'podd-viewer',
			'page_title'    => esc_html__( 'Devices Test', 'device-detector' ),
			'menu_title'    => esc_html__( 'Devices', 'device-detector' ),
			'capability'    => 'manage_options',
			'callback'      => [ $this, 'get_tools_page' ],
			'position'      => 50,
			'plugin'        => PODD_SLUG,
			'activated'     => true,
			'remedy'        => '',
		];
		return $perfops;
	}

	/**
	 * Set the items in the settings menu.
	 *
	 * @since 1.0.0
	 */
	public function init_admin_menus() {
		add_filter( 'init_perfops_admin_menus', [ $this, 'init_perfops_admin_menus' ] );
		AdminMenus::initialize();
	}

	/**
	 * Get actions links for myblogs_blog_actions hook.
	 *
	 * @param string $actions   The HTML site link markup.
	 * @param object $user_blog An object containing the site data.
	 * @return string   The action string.
	 * @since 1.2.0
	 */
	public function blog_action( $actions, $user_blog ) {
		if ( Role::SUPER_ADMIN === Role::admin_type() || Role::LOCAL_ADMIN === Role::admin_type() ) {
			$actions .= " | <a href='" . esc_url( admin_url( 'admin.php?page=podd-viewer&site=' . $user_blog->userblog_id ) ) . "'>" . __( 'Devices', 'device-detector' ) . '</a>';
		}
		return $actions;
	}

	/**
	 * Get actions for manage_sites_action_links hook.
	 *
	 * @param string[] $actions  An array of action links to be displayed.
	 * @param int      $blog_id  The site ID.
	 * @param string   $blogname Site path, formatted depending on whether it is a sub-domain
	 *                           or subdirectory multisite installation.
	 * @return array   The actions.
	 * @since 1.2.0
	 */
	public function site_action( $actions, $blog_id, $blogname ) {
		if ( Role::SUPER_ADMIN === Role::admin_type() || Role::LOCAL_ADMIN === Role::admin_type() ) {
			$actions['devices'] = "<a href='" . esc_url( admin_url( 'admin.php?page=podd-viewer&site=' . $blog_id ) ) . "' rel='bookmark'>" . __( 'Devices', 'device-detector' ) . '</a>';
		}
		return $actions;
	}

	/**
	 * Initializes settings sections.
	 *
	 * @since 1.0.0
	 */
	public function init_settings_sections() {
		add_settings_section( 'podd_plugin_features_section', esc_html__( 'Plugin Features', 'device-detector' ), [ $this, 'plugin_features_section_callback' ], 'podd_plugin_features_section' );
		add_settings_section( 'podd_plugin_options_section', esc_html__( 'Plugin options', 'device-detector' ), [ $this, 'plugin_options_section_callback' ], 'podd_plugin_options_section' );
		add_settings_section( 'podd_plugin_core_section', '', [ $this, 'plugin_core_section_callback' ], 'podd_plugin_core_section' );
		add_settings_section( 'podd_plugin_css_section', '', [ $this, 'plugin_css_section_callback' ], 'podd_plugin_css_section' );
	}

	/**
	 * Add links in the "Actions" column on the plugins view page.
	 *
	 * @param string[] $actions     An array of plugin action links. By default this can include 'activate',
	 *                              'deactivate', and 'delete'.
	 * @param string   $plugin_file Path to the plugin file relative to the plugins directory.
	 * @param array    $plugin_data An array of plugin data. See `get_plugin_data()`.
	 * @param string   $context     The plugin context. By default this can include 'all', 'active', 'inactive',
	 *                              'recently_activated', 'upgrade', 'mustuse', 'dropins', and 'search'.
	 * @return array Extended list of links to print in the "Actions" column on the Plugins page.
	 * @since 1.0.0
	 */
	public function add_actions_links( $actions, $plugin_file, $plugin_data, $context ) {
		$actions[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'admin.php?page=podd-settings' ) ), esc_html__( 'Settings', 'device-detector' ) );
		$actions[] = sprintf( '<a href="%s">%s</a>', esc_url( admin_url( 'admin.php?page=podd-viewer' ) ), esc_html__( 'Statistics', 'device-detector' ) );
		return $actions;
	}

	/**
	 * Add links in the "Description" column on the plugins view page.
	 *
	 * @param array  $links List of links to print in the "Description" column on the Plugins page.
	 * @param string $file Path to the plugin file relative to the plugins directory.
	 * @return array Extended list of links to print in the "Description" column on the Plugins page.
	 * @since 1.0.0
	 */
	public function add_row_meta( $links, $file ) {
		if ( 0 === strpos( $file, PODD_SLUG . '/' ) ) {
			$links[] = '<a href="https://wordpress.org/support/plugin/' . PODD_SLUG . '/">' . __( 'Support', 'device-detector' ) . '</a>';
			$links[] = '<a href="https://github.com/Pierre-Lannoy/wp-device-detector">' . __( 'GitHub repository', 'device-detector' ) . '</a>';
		}
		return $links;
	}

	/**
	 * Get the content of the viewer page.
	 *
	 * @since 1.0.0
	 */
	public function get_viewer_page() {
		$analytics = AnalyticsFactory::get_analytics();
		include PODD_ADMIN_DIR . 'partials/device-detector-admin-view-analytics.php';
	}

	/**
	 * Get the content of the viewer page.
	 *
	 * @since 1.0.0
	 */
	public function get_tools_page() {
		include PODD_ADMIN_DIR . 'partials/device-detector-admin-tools.php';
	}

	/**
	 * Get the content of the settings page.
	 *
	 * @since 1.0.0
	 */
	public function get_settings_page() {
		if ( ! ( $tab = filter_input( INPUT_GET, 'tab' ) ) ) {
			$tab = filter_input( INPUT_POST, 'tab' );
		}
		if ( ! ( $action = filter_input( INPUT_GET, 'action' ) ) ) {
			$action = filter_input( INPUT_POST, 'action' );
		}
		if ( $action && $tab ) {
			switch ( $tab ) {
				case 'misc':
					switch ( $action ) {
						case 'do-save':
							if ( Role::SUPER_ADMIN === Role::admin_type() || Role::SINGLE_ADMIN === Role::admin_type() ) {
								if ( ! empty( $_POST ) && array_key_exists( 'submit', $_POST ) ) {
									$this->save_options();
								} elseif ( ! empty( $_POST ) && array_key_exists( 'reset-to-defaults', $_POST ) ) {
									$this->reset_options();
								}
							}
							break;
					}
					break;
				case 'core':
					switch ( $action ) {
						case 'do-save':
							$this->save_core_options();
							break;
					}
					break;
				case 'css':
					switch ( $action ) {
						case 'do-save':
							$this->save_css_options();
							break;
					}
					break;
			}
		}
		include PODD_ADMIN_DIR . 'partials/device-detector-admin-settings-main.php';
	}

	/**
	 * Save the core plugin options.
	 *
	 * @since 1.0.0
	 */
	private function save_core_options() {
		if ( ! empty( $_POST ) ) {
			if ( array_key_exists( '_wpnonce', $_POST ) && wp_verify_nonce( $_POST['_wpnonce'], 'podd-plugin-options' ) ) {
				Option::site_set( 'wp_is_mobile', array_key_exists( 'podd_plugin_core_wp_is_mobile', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_core_wp_is_mobile' ) : false );
				$message = esc_html__( 'Plugin settings have been saved.', 'device-detector' );
				$code    = 0;
				add_settings_error( 'podd_no_error', $code, $message, 'updated' );
				Logger::info( 'Plugin settings updated.', $code );
			} else {
				$message = esc_html__( 'Plugin settings have not been saved. Please try again.', 'device-detector' );
				$code    = 2;
				add_settings_error( 'podd_nonce_error', $code, $message, 'error' );
				Logger::warning( 'Plugin settings not updated.', $code );
			}
		}
	}

	/**
	 * Save the css plugin options.
	 *
	 * @since 1.0.0
	 */
	private function save_css_options() {
		if ( ! empty( $_POST ) ) {
			if ( array_key_exists( '_wpnonce', $_POST ) && wp_verify_nonce( $_POST['_wpnonce'], 'podd-plugin-options' ) ) {
				Option::site_set( 'css_class', array_key_exists( 'podd_plugin_css_class', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_css_class' ) : false );
				Option::site_set( 'css_device', array_key_exists( 'podd_plugin_css_device', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_css_device' ) : false );
				Option::site_set( 'css_client', array_key_exists( 'podd_plugin_css_client', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_css_client' ) : false );
				Option::site_set( 'css_os', array_key_exists( 'podd_plugin_css_os', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_css_os' ) : false );
				Option::site_set( 'css_brand', array_key_exists( 'podd_plugin_css_brand', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_css_brand' ) : false );
				Option::site_set( 'css_bot', array_key_exists( 'podd_plugin_css_bot', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_css_bot' ) : false );
				Option::site_set( 'css_capability', array_key_exists( 'podd_plugin_css_capability', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_css_capability' ) : false );
				$message = esc_html__( 'Plugin settings have been saved.', 'device-detector' );
				$code    = 0;
				add_settings_error( 'podd_no_error', $code, $message, 'updated' );
				Logger::info( 'Plugin settings updated.', $code );
			} else {
				$message = esc_html__( 'Plugin settings have not been saved. Please try again.', 'device-detector' );
				$code    = 2;
				add_settings_error( 'podd_nonce_error', $code, $message, 'error' );
				Logger::warning( 'Plugin settings not updated.', $code );
			}
		}
	}

	/**
	 * Save the plugin options.
	 *
	 * @since 1.0.0
	 */
	private function save_options() {
		if ( ! empty( $_POST ) ) {
			if ( array_key_exists( '_wpnonce', $_POST ) && wp_verify_nonce( $_POST['_wpnonce'], 'podd-plugin-options' ) ) {
				Option::network_set( 'use_cdn', array_key_exists( 'podd_plugin_options_usecdn', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_options_usecdn' ) : false );
				Option::network_set( 'download_favicons', array_key_exists( 'podd_plugin_options_favicons', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_options_favicons' ) : false );
				Option::network_set( 'display_nag', array_key_exists( 'podd_plugin_options_nag', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_options_nag' ) : false );
				Option::network_set( 'analytics', array_key_exists( 'podd_plugin_features_analytics', $_POST ) ? (bool) filter_input( INPUT_POST, 'podd_plugin_features_analytics' ) : false );
				Option::network_set( 'history', array_key_exists( 'podd_plugin_features_history', $_POST ) ? (string) filter_input( INPUT_POST, 'podd_plugin_features_history', FILTER_SANITIZE_NUMBER_INT ) : Option::network_get( 'history' ) );
				$message = esc_html__( 'Plugin settings have been saved.', 'device-detector' );
				$code    = 0;
				add_settings_error( 'podd_no_error', $code, $message, 'updated' );
				Logger::info( 'Plugin settings updated.', $code );
			} else {
				$message = esc_html__( 'Plugin settings have not been saved. Please try again.', 'device-detector' );
				$code    = 2;
				add_settings_error( 'podd_nonce_error', $code, $message, 'error' );
				Logger::warning( 'Plugin settings not updated.', $code );
			}
		}
	}

	/**
	 * Reset the plugin options.
	 *
	 * @since 1.0.0
	 */
	private function reset_options() {
		if ( ! empty( $_POST ) ) {
			if ( array_key_exists( '_wpnonce', $_POST ) && wp_verify_nonce( $_POST['_wpnonce'], 'podd-plugin-options' ) ) {
				Option::reset_to_defaults();
				$message = esc_html__( 'Plugin settings have been reset to defaults.', 'device-detector' );
				$code    = 0;
				add_settings_error( 'podd_no_error', $code, $message, 'updated' );
				Logger::info( 'Plugin settings reset to defaults.', $code );
			} else {
				$message = esc_html__( 'Plugin settings have not been reset to defaults. Please try again.', 'device-detector' );
				$code    = 2;
				add_settings_error( 'podd_nonce_error', $code, $message, 'error' );
				Logger::warning( 'Plugin settings not reset to defaults.', $code );
			}
		}
	}

	/**
	 * Callback for plugin options section.
	 *
	 * @since 1.0.0
	 */
	public function plugin_options_section_callback() {
		$form = new Form();
		add_settings_field(
			'podd_plugin_options_favicons',
			__( 'Favicons', 'device-detector' ),
			[ $form, 'echo_field_checkbox' ],
			'podd_plugin_options_section',
			'podd_plugin_options_section',
			[
				'text'        => esc_html__( 'Download and display', 'device-detector' ),
				'id'          => 'podd_plugin_options_favicons',
				'checked'     => Option::network_get( 'download_favicons' ),
				'description' => esc_html__( 'If checked, Device Detector will download favicons of websites to display them in reports.', 'device-detector' ) . '<br/>' . esc_html__( 'Note: This feature uses the (free) Google Favicon Service.', 'device-detector' ),
				'full_width'  => false,
				'enabled'     => true,
			]
		);
		register_setting( 'podd_plugin_options_section', 'podd_plugin_options_favicons' );
		if ( defined( 'DECALOG_VERSION' ) ) {
			$help  = '<img style="width:16px;vertical-align:text-bottom;" src="' . \Feather\Icons::get_base64( 'thumbs-up', 'none', '#00C800' ) . '" />&nbsp;';
			$help .= sprintf( esc_html__('Your site is currently using %s.', 'device-detector' ), '<em>DecaLog v' . DECALOG_VERSION .'</em>' );
		} else {
			$help  = '<img style="width:16px;vertical-align:text-bottom;" src="' . \Feather\Icons::get_base64( 'alert-triangle', 'none', '#FF8C00' ) . '" />&nbsp;';
			$help .= sprintf( esc_html__('Your site does not use any logging plugin. To log all events triggered in Device Detector, I recommend you to install the excellent (and free) %s. But it is not mandatory.', 'device-detector' ), '<a href="https://wordpress.org/plugins/decalog/">DecaLog</a>' );
		}
		add_settings_field(
			'podd_plugin_options_logger',
			esc_html__( 'Logging', 'device-detector' ),
			[ $form, 'echo_field_simple_text' ],
			'podd_plugin_options_section',
			'podd_plugin_options_section',
			[
				'text' => $help
			]
		);
		register_setting( 'podd_plugin_options_section', 'podd_plugin_options_logger' );
		add_settings_field(
			'podd_plugin_options_usecdn',
			esc_html__( 'Resources', 'device-detector' ),
			[ $form, 'echo_field_checkbox' ],
			'podd_plugin_options_section',
			'podd_plugin_options_section',
			[
				'text'        => esc_html__( 'Use public CDN', 'device-detector' ),
				'id'          => 'podd_plugin_options_usecdn',
				'checked'     => Option::network_get( 'use_cdn' ),
				'description' => esc_html__( 'If checked, Device Detector will use a public CDN (jsDelivr) to serve scripts and stylesheets.', 'device-detector' ),
				'full_width'  => false,
				'enabled'     => true,
			]
		);
		register_setting( 'podd_plugin_options_section', 'podd_plugin_options_usecdn' );
		add_settings_field(
			'podd_plugin_options_nag',
			esc_html__( 'Admin notices', 'device-detector' ),
			[ $form, 'echo_field_checkbox' ],
			'podd_plugin_options_section',
			'podd_plugin_options_section',
			[
				'text'        => esc_html__( 'Display', 'device-detector' ),
				'id'          => 'podd_plugin_options_nag',
				'checked'     => Option::network_get( 'display_nag' ),
				'description' => esc_html__( 'Allows Device Detector to display admin notices throughout the admin dashboard.', 'device-detector' ) . '<br/>' . esc_html__( 'Note: Device Detector respects DISABLE_NAG_NOTICES flag.', 'device-detector' ),
				'full_width'  => false,
				'enabled'     => true,
			]
		);
		register_setting( 'podd_plugin_options_section', 'podd_plugin_options_nag' );
	}

	/**
	 * Get the available history retentions.
	 *
	 * @return array An array containing the history modes.
	 * @since  1.0.0
	 */
	protected function get_retentions_array() {
		$result = [];
		for ( $i = 1; $i < 7; $i++ ) {
			// phpcs:ignore
			$result[] = [ (int) ( 30 * $i ), esc_html( sprintf( _n( '%d month', '%d months', $i, 'device-detector' ), $i ) ) ];
		}
		for ( $i = 1; $i < 7; $i++ ) {
			// phpcs:ignore
			$result[] = [ (int) ( 365 * $i ), esc_html( sprintf( _n( '%d year', '%d years', $i, 'device-detector' ), $i ) ) ];
		}
		return $result;
	}

	/**
	 * Callback for plugin features section.
	 *
	 * @since 1.0.0
	 */
	public function plugin_features_section_callback() {
		$form = new Form();
		add_settings_field(
			'podd_plugin_features_analytics',
			esc_html__( 'Analytics', 'device-detector' ),
			[ $form, 'echo_field_checkbox' ],
			'podd_plugin_features_section',
			'podd_plugin_features_section',
			[
				'text'        => esc_html__( 'Activated', 'device-detector' ),
				'id'          => 'podd_plugin_features_analytics',
				'checked'     => Option::network_get( 'analytics' ),
				'description' => esc_html__( 'If checked, Device Detector will store statistics about detected devices.', 'device-detector' ),
				'full_width'  => false,
				'enabled'     => true,
			]
		);
		register_setting( 'podd_plugin_features_section', 'podd_plugin_features_analytics' );
		add_settings_field(
			'podd_plugin_features_history',
			esc_html__( 'Historical data', 'device-detector' ),
			[ $form, 'echo_field_select' ],
			'podd_plugin_features_section',
			'podd_plugin_features_section',
			[
				'list'        => $this->get_retentions_array(),
				'id'          => 'podd_plugin_features_history',
				'value'       => Option::network_get( 'history' ),
				'description' => esc_html__( 'Maximum age of data to keep for statistics.', 'device-detector' ),
				'full_width'  => false,
				'enabled'     => true,
			]
		);
		register_setting( 'podd_plugin_features_section', 'podd_plugin_features_history' );
	}

	/**
	 * Callback for plugin core modification section.
	 *
	 * @since 1.0.0
	 */
	public function plugin_core_section_callback() {
		$form = new Form();
		add_settings_field(
			'podd_plugin_core_wp_is_mobile',
			esc_html__( 'Improvements', 'device-detector' ),
			[ $form, 'echo_field_checkbox' ],
			'podd_plugin_core_section',
			'podd_plugin_core_section',
			[
				'text'        => esc_html__( 'Mobile detection', 'device-detector' ),
				'id'          => 'podd_plugin_core_wp_is_mobile',
				'checked'     => Option::site_get( 'wp_is_mobile' ),
				'description' => sprintf( esc_html__( 'If checked, the standard %s function will be improved by Device Detector.', 'device-detector' ), '<code>wp_is_mobile()</code>' ),
				'full_width'  => false,
				'enabled'     => true,
			]
		);
		register_setting( 'podd_plugin_core_section', 'podd_plugin_core_wp_is_mobile' );
	}

	/**
	 * Callback for plugin css modification section.
	 *
	 * @since 1.0.0
	 */
	public function plugin_css_section_callback() {
		$form = new Form();
		foreach ( CSSModifier::$specifiers as $spec ) {
			add_settings_field(
				'podd_plugin_css_' . $spec,
				'class' === $spec ? esc_html__( 'Body classes', 'device-detector' ) : '',
				[ $form, 'echo_field_checkbox' ],
				'podd_plugin_css_section',
				'podd_plugin_css_section',
				[
					'text'        => CSSModifier::get_label( $spec ),
					'id'          => 'podd_plugin_css_' . $spec,
					'checked'     => Option::site_get( 'css_' . $spec ),
					'description' => CSSModifier::get_description( $spec ),
					'more'        => CSSModifier::get_example( $spec ),
					'full_width'  => false,
					'enabled'     => true,
				]
			);
			register_setting( 'podd_plugin_css_section', 'podd_plugin_css_' . $spec );
		}
		$current = [];
		foreach ( CSSModifier::get_current_classes() as $item ) {
			$current[] = '<code style="font-size: x-small">' . $item . '</code>';
		}
		if ( 0 < count( $current ) ) {
			$current = sprintf( esc_html__('Based on these settings, the classes for this current session would be: %s.', 'device-detector' ), implode( ' ', $current ) );
		} else {
			$current = esc_html__( 'Based on these settings, no classes will be added to the body.', 'device-detector' );
		}
		add_settings_field(
			'podd_plugin_css_current',
			'',
			[ $form, 'echo_field_simple_text' ],
			'podd_plugin_css_section',
			'podd_plugin_css_section',
			[
				'text' => $current,
			]
		);
		register_setting( 'podd_plugin_css_section', 'podd_plugin_css_current' );
	}

}
