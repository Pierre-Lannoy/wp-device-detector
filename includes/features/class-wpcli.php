<?php
/**
 * WP-CLI for Device Detector.
 *
 * Adds WP-CLI commands to Device Detector
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   2.0.0
 */

namespace PODeviceDetector\Plugin\Feature;

use PODeviceDetector\System\Environment;
use PODeviceDetector\System\Option;
use PODeviceDetector\Plugin\Feature\Analytics;
use PODeviceDetector\System\Markdown;
use UDD\DeviceDetector;
use PODeviceDetector\API\Device;
use Spyc;

/**
 * Manages Device Detector, get details on its engine and get analytics about devices accessing your site.
 *
 * @package Features
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   2.0.0
 */
class Wpcli {

	/**
	 * List of exit codes.
	 *
	 * @since    2.0.0
	 * @var array $exit_codes Exit codes.
	 */
	private $exit_codes = [
		0   => 'operation successful.',
		1   => 'unrecognized setting.',
		2   => 'unrecognized action.',
		3   => 'analytics are disabled.',
		4   => 'unknown item.',
		255 => 'unknown error.',
	];

	/**
	 * Write ids as clean stdout.
	 *
	 * @param   array   $ids   The ids.
	 * @param   string  $field  Optional. The field to output.
	 * @since   2.0.0
	 */
	private function write_ids( $ids, $field = '' ) {
		$result = '';
		$last   = end( $ids );
		foreach ( $ids as $key => $id ) {
			if ( '' === $field ) {
				$result .= $key;
			} else {
				$result .= $id[$field];
			}
			if ( $id !== $last ) {
				$result .= ' ';
			}
		}
		// phpcs:ignore
		fwrite( STDOUT, $result );
	}

	/**
	 * Write an error.
	 *
	 * @param   integer  $code      Optional. The error code.
	 * @param   boolean  $stdout    Optional. Clean stdout output.
	 * @since   2.0.0
	 */
	private function error( $code = 255, $stdout = false ) {
		$msg = '[' . PODD_PRODUCT_NAME . '] ' . ucfirst( $this->exit_codes[ $code ] );
		if ( \WP_CLI\Utils\isPiped() ) {
			// phpcs:ignore
			fwrite( STDOUT, '' );
			// phpcs:ignore
			exit( $code );
		} elseif ( $stdout ) {
			// phpcs:ignore
			fwrite( STDERR, $msg );
			// phpcs:ignore
			exit( $code );
		} else {
			\WP_CLI::error( $msg );
		}
	}

	/**
	 * Write a warning.
	 *
	 * @param   string   $msg       The message.
	 * @param   string   $result    Optional. The result.
	 * @param   boolean  $stdout    Optional. Clean stdout output.
	 * @since   2.0.0
	 */
	private function warning( $msg, $result = '', $stdout = false ) {
		$msg = '[' . PODD_PRODUCT_NAME . '] ' . ucfirst( $msg );
		if ( \WP_CLI\Utils\isPiped() || $stdout ) {
			// phpcs:ignore
			fwrite( STDOUT, $result );
		} else {
			\WP_CLI::warning( $msg );
		}
	}

	/**
	 * Write a success.
	 *
	 * @param   string   $msg       The message.
	 * @param   string   $result    Optional. The result.
	 * @param   boolean  $stdout    Optional. Clean stdout output.
	 * @since   2.0.0
	 */
	private function success( $msg, $result = '', $stdout = false ) {
		$msg = '[' . PODD_PRODUCT_NAME . '] ' . ucfirst( $msg );
		if ( \WP_CLI\Utils\isPiped() || $stdout ) {
			// phpcs:ignore
			fwrite( STDOUT, $result );
		} else {
			\WP_CLI::success( $msg );
		}
	}

	/**
	 * Write a wimple line.
	 *
	 * @param   string   $msg       The message.
	 * @param   string   $result    Optional. The result.
	 * @param   boolean  $stdout    Optional. Clean stdout output.
	 * @since   2.0.0
	 */
	private function line( $msg, $result = '', $stdout = false ) {
		if ( \WP_CLI\Utils\isPiped() || $stdout ) {
			// phpcs:ignore
			fwrite( STDOUT, $result );
		} else {
			\WP_CLI::line( $msg );
		}
	}

	/**
	 * Write a wimple log line.
	 *
	 * @param   string   $msg       The message.
	 * @param   boolean  $stdout    Optional. Clean stdout output.
	 * @since   2.0.0
	 */
	private function log( $msg, $stdout = false ) {
		if ( ! \WP_CLI\Utils\isPiped() && ! $stdout ) {
			\WP_CLI::log( $msg );
		}
	}

	/**
	 * Get params from command line.
	 *
	 * @param   array   $args   The command line parameters.
	 * @return  array The true parameters.
	 * @since   2.0.0
	 */
	private function get_params( $args ) {
		$result = '';
		if ( array_key_exists( 'settings', $args ) ) {
			$result = \json_decode( $args['settings'], true );
		}
		if ( ! $result || ! is_array( $result ) ) {
			$result = [];
		}
		return $result;
	}

	/**
	 * Get Device Detector details and operation modes.
	 *
	 * ## EXAMPLES
	 *
	 * wp device status
	 *
	 *
	 *     === For other examples and recipes, visit https://github.com/Pierre-Lannoy/wp-device-detector/blob/master/WP-CLI.md ===
	 *
	 */
	public function status( $args, $assoc_args ) {
		\WP_CLI::line( sprintf( '%s is running with UDD engine v%s.', Environment::plugin_version_text(), DeviceDetector::VERSION ) );
		if ( Option::network_get( 'analytics' ) ) {
			\WP_CLI::line( 'Analytics: enabled.' );
		} else {
			\WP_CLI::line( 'Analytics: disabled.' );
		}
		if ( \DecaLog\Engine::isDecalogActivated() ) {
			\WP_CLI::line( 'Logging support: ' . \DecaLog\Engine::getVersionString() . '.');
		} else {
			\WP_CLI::line( 'Logging support: no.' );
		}
	}

	/**
	 * Modify Device Detector main settings.
	 *
	 * ## OPTIONS
	 *
	 * <enable|disable>
	 * : The action to take.
	 *
	 * <analytics|metrics>
	 * : The setting to change.
	 *
	 * [--yes]
	 * : Answer yes to the confirmation message, if any.
	 *
	 * [--stdout]
	 * : Use clean STDOUT output to use results in scripts. Unnecessary when piping commands because piping is detected by Device Detector.
	 *
	 * ## EXAMPLES
	 *
	 * wp device settings disable analytics --yes
	 *
	 *
	 *     === For other examples and recipes, visit https://github.com/Pierre-Lannoy/wp-device-detector/blob/master/WP-CLI.md ===
	 *
	 */
	public function settings( $args, $assoc_args ) {
		$stdout  = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		$action  = isset( $args[0] ) ? (string) $args[0] : '';
		$setting = isset( $args[1] ) ? (string) $args[1] : '';
		switch ( $action ) {
			case 'enable':
				switch ( $setting ) {
					case 'analytics':
						Option::network_set( 'analytics', true );
						$this->success( 'analytics are now activated.', '', $stdout );
						break;
					default:
						$this->error( 1, $stdout );
				}
				break;
			case 'disable':
				switch ( $setting ) {
					case 'analytics':
						\WP_CLI::confirm( 'Are you sure you want to deactivate analytics?', $assoc_args );
						Option::network_set( 'analytics', false );
						$this->success( 'analytics are now deactivated.', '', $stdout );
						break;
					default:
						$this->error( 1, $stdout );
				}
				break;
			default:
				$this->error( 2, $stdout );
		}
	}

	/**
	 * Get devices details for a specific User-Agent.
	 *
	 * <ua>
	 * : The user-agent.
	 *
	 * [--format=<format>]
	 * : Set the output format. Note if json or yaml is chosen: full metadata is outputted too.
	 * ---
	 * default: table
	 * options:
	 *  - table
	 *  - json
	 *  - csv
	 *  - yaml
	 * ---
	 *
	 * [--stdout]
	 * : Use clean STDOUT output to use results in scripts. Unnecessary when piping commands because piping is detected by Device Detector.
	 *
	 * ## EXAMPLES
	 *
	 * wp device describe 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_3_1 like Mac OS X) AppleWebKit/603.1.30 (KHTML, like Gecko)'
	 *
	 *
	 *    === For other examples and recipes, visit https://github.com/Pierre-Lannoy/wp-device-detector/blob/master/WP-CLI.md ===
	 *
	 */
	public function describe( $args, $assoc_args ) {
		$stdout = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		$ua     = isset( $args[0] ) ? (string) $args[0] : '';
		$format = \WP_CLI\Utils\get_flag_value( $assoc_args, 'format', 'table' );
		$device = Device::get( $ua );
		if ( 'yaml' === $format ) {
			$details = Spyc::YAMLDump( $device->get_as_full_array(), true, true, true );
			$this->line( $details, $details, $stdout );
		} elseif ( 'json' === $format ) {
			$details = wp_json_encode( $device->get_as_full_array() );
			$this->line( $details, $details, $stdout );
		} else {
			$details = $device->get_as_array();
			if ( 'table' === $format ) {
				$result = [];
				foreach ( $details as $key => $d ) {
					$item          = [];
					$item['key']   = $key;
					$item['value'] = $d;
					$result[]      = $item;
				}
				$detail  = [ 'key', 'value' ];
				$details = $result;
			} elseif ( 'csv' === $format ) {
				$result   = [];
				$result[] = $details;
				$detail   = array_keys( $details );
				$details  = $result;
			}
			\WP_CLI\Utils\format_items( $assoc_args['format'], $details, $detail );
		}
	}

	/**
	 * Get detection engine details.
	 *
	 * ## OPTIONS
	 *
	 * <version|info|class|device|client|os|browser|engine|library|player|app|pim|reader|brand|bot>
	 * : The item to get information about.
	 *
	 * [--format=<format>]
	 * : Set the output format. Note if json or yaml is chosen: full metadata is outputted too.
	 * ---
	 * default: table
	 * options:
	 *  - table
	 *  - json
	 *  - yaml
	 *  - count
	 *  - ids
	 * ---
	 *
	 * [--stdout]
	 * : Use clean STDOUT output to use results in scripts. Unnecessary when piping commands because piping is detected by Device Detector.
	 *
	 * ## EXAMPLES
	 *
	 * wp device db list browser
	 *
	 *
	 *    === For other examples and recipes, visit https://github.com/Pierre-Lannoy/wp-device-detector/blob/master/WP-CLI.md ===
	 *
	 */
	public function engine( $args, $assoc_args ) {
		$stdout = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		$format = \WP_CLI\Utils\get_flag_value( $assoc_args, 'format', 'table' );
		$item   = isset( $args[0] ) ? (string) $args[0] : '';
		if ( in_array( $item, [ 'version', 'info', 'class', 'device', 'client', 'os', 'browser', 'engine', 'library', 'player', 'app', 'pim', 'reader', 'brand', 'bot' ], true ) ) {
			switch ( $item ) {
				case 'info':
					$line = 'UDD - Universal Device Detector - is a free OSS from Matomo. https://matomo.org';
					$this->line( $line, $line, $stdout );
					break;
				case 'version':
					$version = sprintf( 'UDD engine v%s', DeviceDetector::VERSION );
					$this->line( $version, $version, $stdout );
					break;
				default:
					$detail = Detector::get_identifier_array( $item );
					if ( 'yaml' === $format ) {
						$details = Spyc::YAMLDump( $detail, true, true, true );
						$this->line( $details, $details, $stdout );
					} elseif ( 'json' === $format ) {
						$details = wp_json_encode( $detail );
						$this->line( $details, $details, $stdout );
					} else {
						$details = [];
						foreach ( $detail as $d ) {
							$a = [];
							if ( 'ids' === $format ) {
								$a[ $item ] = '"' . $d . '"';
							} else {
								$a[ $item ] = $d;
							}
							$details[] = $a;
						}
						if ( 'ids' === $format ) {
							$this->write_ids( $details, $item );
						} else {
							\WP_CLI\Utils\format_items( $assoc_args['format'], $details, [ $item ] );
						}
					}
			}
		} else {
			$this->error( 4, $stdout );
		}
	}

	/**
	 * Get devices analytics for today.
	 *
	 * ## OPTIONS
	 *
	 * [--site=<site_id>]
	 * : The site for which to display analytics. May be 0 (all network) or an integer site id. Only useful with multisite environments.
	 * ---
	 * default: 0
	 * ---
	 *
	 * [--format=<format>]
	 * : Set the output format. Note if json is chosen: full metadata is outputted too.
	 * ---
	 * default: table
	 * options:
	 *  - table
	 *  - json
	 *  - csv
	 *  - yaml
	 *  - count
	 * ---
	 *
	 * [--stdout]
	 * : Use clean STDOUT output to use results in scripts. Unnecessary when piping commands because piping is detected by Device Detector.
	 *
	 * ## EXAMPLES
	 *
	 * wp device analytics
	 *
	 *
	 *    === For other examples and recipes, visit https://github.com/Pierre-Lannoy/wp-device-detector/blob/master/WP-CLI.md ===
	 *
	 */
	public function analytics( $args, $assoc_args ) {
		$stdout = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		$site   = (int) \WP_CLI\Utils\get_flag_value( $assoc_args, 'site', 0 );
		$format = \WP_CLI\Utils\get_flag_value( $assoc_args, 'format', 'table' );
		if ( ! Option::network_get( 'analytics' ) ) {
			$this->error( 3, $stdout );
		}
		$analytics = Analytics::get_status_kpi_collection( [ 'site_id' => $site ] );
		$result    = [];
		if ( array_key_exists( 'data', $analytics ) ) {
			foreach ( $analytics['data'] as $kpi ) {
				$item                = [];
				$item['kpi']         = $kpi['name'];
				$item['description'] = $kpi['description'];
				$item['value']       = $kpi['value']['human'];
				if ( array_key_exists( 'ratio', $kpi ) && isset( $kpi['ratio'] ) ) {
					$item['ratio'] = $kpi['ratio']['percent'] . '%';
				} else {
					$item['ratio'] = '-';
				}
				$item['variation'] = ( 0 < $kpi['variation']['percent'] ? '+' : '' ) . (string) $kpi['variation']['percent'] . '%';
				$result[]          = $item;
			}
		}
		if ( 'json' === $format ) {
			$detail = wp_json_encode( $analytics );
			$this->line( $detail, $detail, $stdout );
		} elseif ( 'yaml' === $format ) {
			unset( $analytics['assets'] );
			$detail = Spyc::YAMLDump( $analytics, true, true, true );
			$this->line( $detail, $detail, $stdout );
		} else {
			\WP_CLI\Utils\format_items( $assoc_args['format'], $result, [ 'kpi', 'description', 'value', 'ratio', 'variation' ] );
		}
	}

	/**
	 * Get information on exit codes.
	 *
	 * ## OPTIONS
	 *
	 * <list>
	 * : The action to take.
	 * ---
	 * options:
	 *  - list
	 * ---
	 *
	 * [--format=<format>]
	 * : Allows overriding the output of the command when listing exit codes.
	 * ---
	 * default: table
	 * options:
	 *  - table
	 *  - json
	 *  - csv
	 *  - yaml
	 *  - ids
	 *  - count
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 * Lists available exit codes:
	 * + wp device exitcode list
	 * + wp device exitcode list --format=json
	 *
	 *
	 *   === For other examples and recipes, visit https://github.com/Pierre-Lannoy/wp-device-detector/blob/master/WP-CLI.md ===
	 *
	 */
	public function exitcode( $args, $assoc_args ) {
		$stdout = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		$format = \WP_CLI\Utils\get_flag_value( $assoc_args, 'format', 'table' );
		$action = isset( $args[0] ) ? $args[0] : 'list';
		$codes  = [];
		foreach ( $this->exit_codes as $key => $msg ) {
			$codes[ $key ] = [ 'code' => $key, 'meaning' => ucfirst( $msg ) ];
		}
		switch ( $action ) {
			case 'list':
				if ( 'ids' === $format ) {
					$this->write_ids( $codes );
				} else {
					\WP_CLI\Utils\format_items( $format, $codes, [ 'code', 'meaning' ] );
				}
				break;
		}
	}

	/**
	 * Get the WP-CLI help file.
	 *
	 * @param   array $attributes  'style' => 'markdown', 'html'.
	 *                             'mode'  => 'raw', 'clean'.
	 * @return  string  The output of the shortcode, ready to print.
	 * @since 1.0.0
	 */
	public static function sc_get_helpfile( $attributes ) {
		$md = new Markdown();
		return $md->get_shortcode(  'WP-CLI.md', $attributes  );
	}

}

add_shortcode( 'podd-wpcli', [ 'PODeviceDetector\Plugin\Feature\Wpcli', 'sc_get_helpfile' ] );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	\WP_CLI::add_command( 'device', 'PODeviceDetector\Plugin\Feature\Wpcli' );

}