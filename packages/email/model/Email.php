<?php
class Email {

	/**
	 * Wrap an email in the default template and send it
	 * 
	 * @author salvi
	 * @params String (email) 
	 * @params String
	 * @params String
	 * */
	static function sendEmailDefaultTemplate($to, $subject, $body){
		$lang = framework::session_get('language');
		include_once framework::resolve("packages/email/i18n/$lang/default.php");

		ob_start();
			include framework::resolve("packages/email/view/default.tpl");
			$template = ob_get_contents();
		ob_end_clean();

		framework::sendEmail($to, $subject, $template);
	}

	/**
	 * Send 'registration successfull' message to user
	 *
	 * @author salvi
	 * @param string $to
	 */
	static function sendNewUserRegistrationSuccessfull($to){
		$lang = framework::session_get('language');

		$user = framework::query("SELECT Password as PASSWORD FROM account WHERE User = '$to';");
		$password = $user[0]['PASSWORD'];

		include_once framework::resolve("packages/email/i18n/$lang/registration_successfull.php");
		$subject = $i18n['subject'];

		ob_start();
			include framework::resolve("packages/email/view/registration_successfull.tpl");
			$message = ob_get_contents();
		ob_clean();

		self::sendEmailDefaultTemplate($to, $subject, $message);
		framework::log("New user was registered with username $email");
	}

	/**
	 * Delivers a receipt when a user places an order AND an email alerting the site's admins
	 * 
	 * @author : salvi
	 * @param String, email address
	 * @param String, the id of the order
	 */
	static function sendNewOrderReceiptEmail($to, $orderId){
		$lang = framework::session_get('language');

		require_once framework::resolve("packages/admin/model/Administration.php");
		include_once framework::resolve("packages/base/model/Security.php");
		include_once framework::resolve("packages/email/i18n/$lang/order_receipt.php");

		$user = Security::getUser($to);
		$order = Administration::getOrderDetails($orderId, $lang);
		$conf = Security::getWebsiteConfigs();

		$price_paper = $conf['price_paper'];
		$price_card = $conf['price_card'];
		$price_bag = $conf['price_bag'];
		$price_ornament = $conf['price_ornament'];

		$subject = $i18n['subject'];
		$total = $order['PRODUCT']['ITEMPRICE'] + $order['PRODUCT']['PAPERPRICE'] + $order['PRODUCT']['SHIPPINGPRICE'] + $order['PRODUCT']['TAX'];

		ob_start();
			include framework::resolve("packages/email/view/order_recepit.tpl");
			$message = ob_get_contents();
		ob_end_clean();

		self::sendEmailDefaultTemplate($to, $subject, $message);
		self::alertNewOrderWasCreated();
		framework::log("A new order have been created by $email");
	}

	/**
	 * Send an alert to the administrators whenever a user buys
	 * 
	 * @author salvi
	 * */
	static function alertNewOrderWasCreated(){
		require_once framework::resolve("packages/admin/model/Administration.php");
		$admins = Administration::getAdminsEmails();

		$subject = "Alert! We received a new order";

		ob_start();
			include framework::resolve("packages/email/view/alert_new_order.tpl");
			$message = ob_get_contents();
		ob_end_clean();

		self::sendEmailDefaultTemplate($admins, $subject, $message);
	}

	/**
	 * Sends an email to the user containing the tracking number
	 * 
	 * @author rafa
	 * @param String
	 * */
	static function sendTrackingNumber($orderId){
		require_once framework::resolve("packages/admin/model/Administration.php");
		$order = Administration::getOrderDetails($orderId);
		$email = $order['SENDER']['EMAIL'];
		$user = Security::getUser($email);
		$lang = isset($user['LANGUAGE']) && !empty($user['LANGUAGE']) ? $user['LANGUAGE'] : "en";
		$sender = $order['SENDER']['FULLNAME'];
		$receiver = $order['RECEIVER'];

		include_once framework::resolve("packages/email/i18n/$lang/tracking_number.php");
		$subject = $i18n['tracking-subject'];
		$trackingNumber = $order['CONFIRMATIONNUMBER'];

		ob_start();
			include framework::resolve("packages/email/view/tracking_number.tpl");
			$message = ob_get_contents();
		ob_end_clean();

		self::sendEmailDefaultTemplate($email, $subject, $message);
		framework::log("Sent tracking number to $email");
	}
}