<?php

namespace WCPay_Subs;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Data_Actions {

	protected static $instance = null;

	public static function init(): ?Data_Actions {

		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/* when the class is constructed. */
	public function __construct() {

		//add_action( 'admin_post_delete_facebook_product_data', array( $this, 'delete_product_data' ) );
		add_action( 'admin_post_remove_single_subscription', array( $this, 'remove_single_subscription' ) );
	}

	/**
	 * Delete orphaned
	 *
	 * @return void
	 */
	public function delete_all_orphaned_data() {

		//$wpnonce = $_REQUEST['_wpnonce'];
		//$this->do_security_checks( $wpnonce );

		echo '<pre>';
		echo 'Deleting data...<br>';

		/**
		 * Provide a back link
		 */
		echo $this->get_backlink();
		exit();
	}

	/**
	 * Delete orphaned products from catalogue using a manually supplied Facebook retailer ID.
	 *
	 * @return void
	 */
	public function remove_single_subscription() {

		$wpnonce = $_REQUEST['_wpnonce'];
		$this->do_security_checks( $wpnonce );

		$subscription_id = ( isset( $_REQUEST['subscription_id'] ) ) ? sanitize_text_field( $_REQUEST['subscription_id'] ) : '';

		echo '<pre>';
		echo 'Deleting data...<br>';

		/**
		 * todo handle returned empty content_id
		 */
		if ( empty( $subscription_id ) ) {
			echo 'Subscription id is required...<br>';
			echo $this->get_backlink();
			exit();
		}

		$args = array(
			'id' => $subscription_id,
			'post_type' => 'shop_subscription',
		);

		$subscription = new \WP_Query( $args );


		if( ! $subscription->have_posts() ){
			echo 'Cannot find a valid subscription.<br>';
			echo $this->get_backlink();
			//exit();
		}

		$wcpay_id = get_post_meta(  $subscription_id, '_wcpay_subscription_id', true );

		if( empty( $wcpay_id ) ){
			echo 'There is no _wcpay_subscription_id for this subscription.<br>';
			echo $this->get_backlink();
			exit();
		}else{
			echo 'The _wcpay_subscription_id for this subscription is '. $wcpay_id  . '.<br>';

		}

		delete_post_meta(  $subscription_id, '_wcpay_subscription_id' );
		echo $this->get_backlink();

		exit();
	}

	/**
	 * Returns an HTML link to the http_referrer
	 *
	 * @return string
	 */
	private function get_backlink() {
		return '<a href="' . $_SERVER["HTTP_REFERER"] . '">Go back</a><br>';
	}

	/**
	 * Returns the total number of products on the site, in case we need
	 * a handbrake later
	 *
	 * @return int
	 */
	private function count_subscriptions() {

		$args = array(
			'post_type'      => '',
			'fields'         => 'ids',
			'posts_per_page' => 1
		);

		$products = new \WP_Query( $args );

		return $products->found_posts;
	}

	/**
	 * Do nonce checks, because DRY.
	 *
	 * @return void
	 */
	function do_security_checks( $wpnonce ) {

		/*
		 * Check user caps
		 */
		if ( ! current_user_can( 'manage_options' ) ) {
			header( 'Location:' . $_SERVER["HTTP_REFERER"] . '?error=unauthenticated' );
			exit();
		}

		/*
		 * Check nonce
		 */
		if ( ! wp_verify_nonce( $wpnonce, 'remove_subs' ) ) {
			die( 'Cheatin\' huh?' );
		}

	}

}