<?php

namespace TFB4WC;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Test_Products {

	protected static $instance = null;

	public static function init(): ?Test_Products {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/* when the class is constructed. */
	public function __construct() {

		add_action( 'wp_ajax_validate_facebook_product', array( $this, 'validate_facebook_product' ) );
	}


	public function validate_facebook_product() {

		if ( ! current_user_can( 'manage_options' ) ) {
			header( 'Location:' . $_SERVER["HTTP_REFERER"] . '&error=unauthenticated' );
			exit();
		}

		if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'ajax-nonce' ) ) {
			die( 'Cheatin\' huh?' );
			exit();
		}

		if ( ! function_exists( 'woocommerce_subscriptions' ) ) {
			die( 'WooCommerce Subscriptions needs to be active for this to run. Please go back and activate the extension. <a href="' . $_SERVER["HTTP_REFERER"] . '">Go back</a>' );
		}

		$product_id = ( isset( $_REQUEST['product_id'] ) ) ? sanitize_text_field( $_REQUEST['product_id'] ) : '';

		if ( empty( $product_id ) ) {
			echo json_encode( array( 'message' => 'No product ID provided' ) );
			exit();
		}

		echo json_encode( array( 'message' => 'Starting test...' ) );
		flush();
		ob_flush();

		$instance = new \WC_Facebookcommerce_Integration();
		$product  = wc_get_product( $product_id );

		if ( ! empty( $product ) ) {
			$logger = new Validate_Product( $instance, $product );
			$logger->ajax_validate_and_log();
		} else {
			echo json_encode( array( 'message' =>'The ID ' . $product_id . ' does not belong to a product'));
			flush();
			ob_flush();
		}

	}

}
