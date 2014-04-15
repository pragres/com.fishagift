<?php

/**
 * Fish a Gift
 *
 * Login control (submit)
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */

// including the models
include_once framework::resolve('packages/base/model/Security.php');

// varibales from the URL
$email = framework::getValue('email');
$password = framework::getValue('password');

framework::log("Login $email / $password ");

$returnTo = framework::getValue('returnTo') == "" ? "store/home" : framework::getValue('returnTo');

// redirecting to home if session is started
$isSessionStarted = Security::isSessionStarted();
if ($isSessionStarted) {
	header("Location: " . framework::link_to('store/home'));
	exit();
}

// login user in
$user = Security::getUser($email);

framework::log("User = " . serialize($user));

if (is_null($user)) {
	// email not exist
	framework::log("Login error: $email not exists $email ");
	framework::redirect("base/login", "&error=emailNoExist&returnTo=$returnTo");
} else {
	if ($user['PASSWORD'] == md5($password)) {
		// everyting is fine, log user in
		framework::session_set("user", $user);
		
		if (isset($user['LANGUAGE']))
			framework::session_set('language', $user['LANGUAGE']);
		
		framework::log("Login successfull for $email");
		
		header("Location: " . framework::link_to($returnTo));
	} else {
		// wrong password
		framework::log("Login error: $email type a wrong password!");
		
		framework::redirect('base/login', "&error=wrongCredentials&returnTo=$returnTo");
	}
}