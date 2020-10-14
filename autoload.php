<?php
/**
 * Autoload for Device Detector.
 *
 * @package Bootstrap
 * @author  Pierre Lannoy <https://pierre.lannoy.fr/>.
 * @since   1.0.0
 */

spl_autoload_register(
	function ( $class ) {
		$classname = $class;
		$filepath  = __DIR__ . '/';
		if ( strpos( $classname, 'PODeviceDetector\\' ) === 0 ) {
			while ( strpos( $classname, '\\' ) !== false ) {
				$classname = substr( $classname, strpos( $classname, '\\' ) + 1, 1000 );
			}
			$filename = 'class-' . str_replace( '_', '-', strtolower( $classname ) ) . '.php';
			if ( strpos( $class, 'PODeviceDetector\System\\' ) === 0 ) {
				$filepath = PODD_INCLUDES_DIR . 'system/';
			}
			if ( strpos( $class, 'PODeviceDetector\Plugin\Feature\\' ) === 0 ) {
				$filepath = PODD_INCLUDES_DIR . 'features/';
			} elseif ( strpos( $class, 'PODeviceDetector\Plugin\Integration\\' ) === 0 ) {
				$filepath = PODD_INCLUDES_DIR . 'integrations/';
			} elseif ( strpos( $class, 'PODeviceDetector\Plugin\\' ) === 0 ) {
				$filepath = PODD_INCLUDES_DIR . 'plugin/';
			} elseif ( strpos( $class, 'PODeviceDetector\API\\' ) === 0 ) {
				$filepath = PODD_INCLUDES_DIR . 'api/';
			}
			if ( strpos( $class, 'PODeviceDetector\Library\\' ) === 0 ) {
				$filepath = PODD_VENDOR_DIR;
			}
			if ( strpos( $filename, '-public' ) !== false ) {
				$filepath = PODD_PUBLIC_DIR;
			}
			if ( strpos( $filename, '-admin' ) !== false ) {
				$filepath = PODD_ADMIN_DIR;
			}
			$file = $filepath . $filename;
			if ( file_exists( $file ) ) {
				include_once $file;
			}
		}
	}
);
