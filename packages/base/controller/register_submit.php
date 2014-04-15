<?php

/**
 * Fish a Gift
 * 
 * Register submit control
 * 
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */

// including the models
include_once framework::resolve('packages/base/model/Security.php');
include_once framework::resolve('packages/email/model/Email.php');

// get params from URL
$email = framework::getValue("register");

framework::log("Register user $email");

// register the user
$data = Security::registerUser($email);

if ($data !== false) {
	
	// send email to user with credential
	
	framework::log("Send registration email to $email");
	
	Email::sendNewUserRegistrationSuccessfull($email, $data['password']);
	
	// put values in request
	$_POST['email'] = $email;
	$_POST['password'] = $data['password'];
	$_GET['email'] = $_POST['email'];
	$_GET['password'] = $_POST['password'];
	$_REQUEST['email'] = $_POST['email'];
	$_REQUEST['password'] = $_POST['password'];
	
	framework::log("Registration successfull for $email");
	
	// jump to login submit control
	include_once framework::resolve('packages/base/controller/login_submit.php');
} else {
	
	// Redirect to login page
	framework::log("Register user error");
	framework::redirect("base/login", "&error=userExist");
}