<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

?>

<div class="wrap">

    <div id="icon-themes" class="icon32"></div>
    <h2>Remove WCPay subscriptions</h2>

	<?php $active_tab = ( isset( $_GET['tab'] ) ) ? sanitize_text_field( $_GET['tab'] ) : 'delete-options'; ?>

    <h2 class="nav-tab-wrapper">
        <a href="?page=remove-wcpay-subs&tab=remove_subscriptions"
           class="nav-tab <?php echo 'delete-options' === $active_tab ? 'nav-tab-active' : ''; ?>">
            Remove subscriptions
        </a>

    </h2>

	<?php if ( isset( $_GET['error'] ) && $_GET['error'] === 'unauthenticated' ): ?>
        <h3>You need administrator priviliges to run this plugin.</h3>
	<?php else: ?>

			<?php include( 'tab-remove-subscriptions.php' ); ?>

	<?php endif; ?>

</div>

