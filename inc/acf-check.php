<?php
/**
 * Warn admins if ACF Pro is not active.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_notices', function () {
	if ( function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}
	echo '<div class="notice notice-error"><p><strong>TC Riez Océan :</strong> le thème requiert <strong>Advanced Custom Fields Pro</strong> pour fonctionner pleinement. Veuillez installer et activer le plugin.</p></div>';
} );
