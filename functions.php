<?php
/**
 * TC Riez Océan — bootstrap du thème.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TCRO_VERSION', '1.0.0' );
define( 'TCRO_DIR', get_template_directory() );
define( 'TCRO_URI', get_template_directory_uri() );

require_once TCRO_DIR . '/inc/setup.php';
require_once TCRO_DIR . '/inc/enqueue.php';
require_once TCRO_DIR . '/inc/cpts.php';
require_once TCRO_DIR . '/inc/taxonomies.php';
require_once TCRO_DIR . '/inc/acf-check.php';
require_once TCRO_DIR . '/inc/acf-options.php';
require_once TCRO_DIR . '/inc/acf-fields.php';
require_once TCRO_DIR . '/inc/helpers.php';
require_once TCRO_DIR . '/inc/contact-form.php';
require_once TCRO_DIR . '/inc/seeder.php';
