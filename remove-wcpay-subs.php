<?php
/*
Plugin name: Remove WCPay Subs
Plugin URI:
Description: Remove hidden postmeta without the need for database access
Author: nicw
Version: Beta
Author URI:
*/

namespace WCPay_Subs;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( is_admin() ) {
	require_once plugin_dir_path( __FILE__ ) . '/admin/class-menu.php';
	require_once plugin_dir_path( __FILE__ ) . '/admin/class-data-actions.php';
}

//require_once plugin_dir_path( __FILE__ ) . '/tests/test-data.php';


/**
 * Class Remove_WCPay_Subs
 * @package TFB4WC
 */
class Remove_WCPay_Subs {

	/*
	 * Version is a habit
	 */
	public $version = '1';

	protected static $instance = null;

	/**
	 * @return Remove_WCPay_Subs|null
	 */
	public static function init(): ?Remove_WCPay_Subs {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {

		add_action( 'admin_menu', array( 'WCPay_Subs\Menu', 'init' ) );
		//add_action( 'admin_notices', array( $this, 'check_plugins' ) );
		add_action( 'admin_init', array( 'WCPay_Subs\Data_Actions', 'init' ) );

	}

	/**
	 * Add an admin warning about WooCommerce Subscriptions
	 */
	public function check_plugins() {
		?>

        <div class="notice notice-error error-alt">
            <p>If you remove subs, they will break if WooCommerce Subscriptions is not present</p>
        </div>

		<?php

	}

	/**
	 * On plugin deactivation we remove all the options
	 */
	public static function deactivated() {

	}


}

add_action( 'init', array( 'WCPay_Subs\Remove_WCPay_Subs', 'init' ) );
register_deactivation_hook( __FILE__, array( 'WCPay_Subs\Remove_WCPay_Subs', 'deactivated' ) );