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
 * WP-CLI for Device Detector.
 *
 * Defines methods and properties for WP-CLI commands.
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
	private static $exit_codes = [
		0   => 'operation successful.',
		1   => 'unrecognized setting.',
		2   => 'unrecognized action.',
		3   => 'analytics are disabled.',
		255 => 'unknown error.',
	];

	/**
	 * Write ids as clean stdout.
	 *
	 * @param   array   $ids   The ids.
	 * @param   string  $field  Optional. The field to output.
	 * @since   2.0.0
	 */
	private static function write_ids( $ids, $field = '' ) {
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
	private static function error( $code = 255, $stdout = false ) {
		if ( \WP_CLI\Utils\isPiped() ) {
			// phpcs:ignore
			fwrite( STDOUT, '' );
			// phpcs:ignore
			exit( $code );
		} elseif ( $stdout ) {
			// phpcs:ignore
			fwrite( STDERR, ucfirst( self::$exit_codes[ $code ] ) );
			// phpcs:ignore
			exit( $code );
		} else {
			\WP_CLI::error( self::$exit_codes[ $code ] );
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
	private static function warning( $msg, $result = '', $stdout = false ) {
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
	private static function success( $msg, $result = '', $stdout = false ) {
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
	private static function line( $msg, $result = '', $stdout = false ) {
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
	private static function log( $msg, $stdout = false ) {
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
	private static function get_params( $args ) {
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
	public static function status( $args, $assoc_args ) {
		\WP_CLI::line( sprintf( '%s is running with UDD engine v%s.', Environment::plugin_version_text(), DeviceDetector::VERSION ) );
		if ( Option::network_get( 'analytics' ) ) {
			\WP_CLI::line( 'Analytics: enabled.' );
		} else {
			\WP_CLI::line( 'Analytics: disabled.' );
		}
		if ( defined( 'DECALOG_VERSION' ) ) {
			\WP_CLI::line( 'Logging support: yes (DecaLog v' . DECALOG_VERSION . ').');
		} else {
			\WP_CLI::line( 'Logging support: no.' );
		}
	}

	/**
	 * Modify Device Detector main settings.
	 *
	 * <enable|disable>
	 * : The action to take.
	 *
	 * <analytics>
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
	public static function settings( $args, $assoc_args ) {
		$stdout  = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		$action  = isset( $args[0] ) ? (string) $args[0] : '';
		$setting = isset( $args[1] ) ? (string) $args[1] : '';
		switch ( $action ) {
			case 'enable':
				switch ( $setting ) {
					case 'analytics':
						Option::network_set( 'analytics', true );
						self::success( 'analytics are now activated.', '', $stdout );
						break;
					default:
						self::error( 1, $stdout );
				}
				break;
			case 'disable':
				switch ( $setting ) {
					case 'analytics':
						\WP_CLI::confirm( 'Are you sure you want to deactivate analytics?', $assoc_args );
						Option::network_set( 'analytics', false );
						self::success( 'analytics are now deactivated.', '', $stdout );
						break;
					default:
						self::error( 1, $stdout );
				}
				break;
			default:
				self::error( 2, $stdout );
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
	public static function describe( $args, $assoc_args ) {
		$stdout = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		$ua     = isset( $args[0] ) ? (string) $args[0] : '';
		$format = \WP_CLI\Utils\get_flag_value( $assoc_args, 'format', 'table' );
		$device = Device::get( $ua );
		if ( 'yaml' === $format ) {
			$details = Spyc::YAMLDump( $device->get_as_full_array(), true, true, true );
			self::line( $details, $details, $stdout );
		} elseif ( 'json' === $format ) {
			$details = wp_json_encode( $device->get_as_full_array() );
			self::line( $details, $details, $stdout );
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
	 * Get devices analytics for today.
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
	public static function analytics( $args, $assoc_args ) {
		$stdout = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		if ( ! Option::network_get( 'analytics' ) ) {
			self::error( 3, $stdout );
		}
		$analytics = Analytics::get_status_kpi_collection();
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
		$format = \WP_CLI\Utils\get_flag_value( $assoc_args, 'format', 'table' );
		if ( 'json' === $format ) {
			self::line( wp_json_encode( $analytics ), wp_json_encode( $analytics ), $stdout );
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
	 *   === For other examples and recipes, visit https://github.com/Pierre-Lannoy/wp-traffic/blob/master/WP-CLI.md ===
	 *
	 */
	public static function exitcode( $args, $assoc_args ) {
		$stdout = \WP_CLI\Utils\get_flag_value( $assoc_args, 'stdout', false );
		$format = \WP_CLI\Utils\get_flag_value( $assoc_args, 'format', 'table' );
		$action = isset( $args[0] ) ? $args[0] : 'list';
		$codes  = [];
		foreach ( self::$exit_codes as $key => $msg ) {
			$codes[ $key ] = [ 'code' => $key, 'meaning' => ucfirst( $msg ) ];
		}
		switch ( $action ) {
			case 'list':
				if ( 'ids' === $format ) {
					self::write_ids( $codes );
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
	\WP_CLI::add_command( 'device status', [ Wpcli::class, 'status' ] );
	\WP_CLI::add_command( 'device settings', [ Wpcli::class, 'settings' ] );
	\WP_CLI::add_command( 'device exitcode', [ Wpcli::class, 'exitcode' ] );
	\WP_CLI::add_command( 'device describe', [ Wpcli::class, 'describe' ] );

	\WP_CLI::add_command( 'device analytics', [ Wpcli::class, 'analytics' ] );

}