<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>

<h3>Remove WCPay subscriptions</h3>

<!--<form action="<?php /*echo esc_url( admin_url() ); */?>admin-post.php" method="post">


	<?php /*wp_nonce_field( 'remove_subscription' ); */?>
    <input type="hidden" name="action" value="remove_all_subscriptions">

	<?php
/*	echo submit_button(
		$text = "Remove all subscriptions",
		$type = 'button-primary',
		null,
		$wrap = true,
        array( 'style' => 'background: #d63638;border: #d63638;' )
	);
	*/?>

</form>-->



<form action="<?php echo esc_url( admin_url() ); ?>admin-post.php" method="post">

	<?php wp_nonce_field( 'remove_subs' ); ?>
    <input type="hidden" name="action" value="remove_single_subscription">

    <label for="subscription_id"><strong>Subscription ID (post id):</strong></label>
    <input id="subscription_id" type="text" name="subscription_id" />

	<?php
	echo submit_button(
		$text = "Remove a single subscription",
		$type = 'button-primary',
		null,
		$wrap = true,
 array(
            'style' => 'background: #d63638;border: #d63638;',
            'id' => 'remove_single_subscription'
        )
	);


	?>

</form>
