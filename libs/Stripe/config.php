<?php
	require_once('Stripe.php');

	$secret_key = framework::$config["stripe"]["secret_key"];
	$publishable_key = framework::$config["stripe"]["publishable_key"];
	
	$stripe = array(
	  "secret_key"      => $secret_key,
	  "publishable_key" => $publishable_key
	);

	Stripe::setApiKey($stripe['secret_key']);
?>