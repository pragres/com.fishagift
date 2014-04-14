<?php
class Security {
	
	/**
	 * Return the configurations for the website stored in the database
	 *
	 * @name getWebsiteConfigs
	 * @author salvi
	 * @return Associative array of configurations
	 */
	static function getWebsiteConfigs(){
		return Array(
				"price_paper" => 0,
				"price_card" => 2,
				"price_bag" => 3,
				"price_ornament" => 0.5,
				"tax_amount" => 0.07
		);
	}
	
	/**
	 * Based on a item's price, calculates the taxes to pay.
	 * We should use this function instead of manually calculate for in case the formula changes
	 *
	 * @name getTaxByPrice
	 * @author salvi
	 * @param $price float: numeric value (money) to calculate tax from it
	 * @return float: tax
	 */
	static function getTaxByPrice($price){
		$conf = self::getWebsiteConfigs();
		$tax = $conf['tax_amount'];
		
		return $tax * $price;
	}
	
	/**
	 * Save the error log and create an alert so we can go back, check why the error happened and fix it.
	 * This function should be positioned when exceptions are triggered or in application's end points
	 *
	 * @name logAndAlertError
	 * @author salvi
	 * @param $error String: Error message
	 * @param $type Enum: Error category (GENERAL|STORE|ADMIN|LOW|HIGH)
	 */
	static function logAndAlertError($error, $type = "GENERAL"){
		$page = isset($page) ? $page : "Undefined";
		
		// @TODO saves log into the log table, in the database
	}
	
	/**
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * Return a list of users
	 *
	 * @author rafa
	 * @param integer $offset
	 * @param integer $limit
	 * @return array
	 */
	static function getUsers($limit = null, $offset = 0){
		return framework::query("
        SELECT
            user.Email as EMAIL,
            user.DateRegistered as DATEREGISTERED,
            user.FullName as FULLNAME,
            user.ShippingMethod as SHIPPINGMETHOD,
            user.PaymentMethod as PAYMENTMETHOD,
            user.SaveCreditCardInfo as SAVECREDITCARDINFO,
            user.`Language` as `LANGUAGE`,
            user.`Administrator` as `ADMINISTRATOR`,
            user.SubscribeNews as SUBSCRIBENEWS,
            account.Password as PASSWORD,
            account.Status as STATUS
        FROM user
        INNER JOIN account
        ON user.email = account.user
        " . (is_null($limit) ? "" : "LIMIT $offset, $limit") . ";");
	}
	
	/**
	 * Insert new user in database
	 *
	 * @authos rafa
	 *
	 * @param string $email
	 * @param string $fullname
	 * @param string $language
	 * @param string $password
	 * @param char $sex
	 * @param string $birthdate
	 */
	static function addUser($email, $fullname, $language, $password, $sex, $birthdate){
		framework::connect();
		
		$email = mysql_real_escape_string($email);
		$fullname = mysql_real_escape_string($fullname);
		$password = mysql_real_escape_string($password);
		$sex = mysql_real_escape_string($sex[0]);
		$birthdate = mysql_real_escape_string($birthdate);
		
		framework::query("INSERT INTO user (Email, FullName, Language, Sex, BirthDate) VALUES ('$email','$fullname','$language','$sex','$birthdate');");
		framework::query("INSERT INTO account (User, Password) values ('$email','$password');");
	}
	
	/**
	 * Delete a user
	 *
	 * @author rafa
	 * @param string $email
	 */
	static function delUser($email){
		framework::query("DELETE FROM account WHERE User = '$email';");
		framework::query("DELETE FROM address WHERE User = '$email';");
		framework::query("DELETE FROM user WHERE Email = '$email';");
	}
	
	/**
	 * Return a user
	 *
	 * @author rafa
	 * @param string $email
	 * @return array
	 */
	static function getUser($email){
		framework::connect();
		
		$email = mysql_real_escape_string($email);
		
		$sql = "SELECT
            Email as EMAIL,
            DateRegistered as DATEREGISTERED,
            FullName as FULLNAME,
            SaveCreditCardInfo as SAVECREDITCARDINFO,
            Language as LANGUAGE,
            Administrator as ADMINISTRATOR,
            Sex as SEX,
            BirthDate as BIRTHDATE,
            SubscribeNews as SUBSCRIBENEWS
        FROM `user`
            WHERE Email = '$email';";
		
		$r = framework::query($sql);
		
		$q = framework::query("
        SELECT
            User as USER,
            Password as PASSWORD,
            Status as STATUS
        FROM account
        WHERE User = '$email';");
		
		$a = self::getAddress($email);
		
		$x = self::getCreditCard($email);
		
		$default = array(
				"EMAIL" => $email,
				"DATEREGISTERED" => null,
				"FULLNAME" => null,
				"PAYMENTMETHOD" => null,
				"SAVECREDITCARDINFO" => null,
				"LANGUAGE" => null,
				"ADMINISTRATOR" => null,
				"SEX" => null,
				"BIRTHDATE" => null,
				"PASSWORD" => null,
				"STATUS" => null
		);
		
		if (isset($r[0]))
			if (isset($r[0]['EMAIL']))
				if ($r[0]['EMAIL'] == $email) {
					$r = $r[0];
					
					// Merge the account
					if (isset($q[0]))
						if (isset($q[0]['USER']))
							if ($q[0]['USER'] == $email)
								$r = array_merge($r, $q[0]);
						
						// Merge the address
					$r = array_merge($r, $a);
					
					// Merge the credit card
					$r = array_merge($r, $x);
					
					// Merge the defaults
					$r = array_merge($default, $r);
					
					$r['ADDRESS'] = $a;
					$r['CREDITCARD'] = $x;
					
					return $r;
				}
		
		return null;
	}
	
	/**
	 * : Registers a user, returns false if the email already exist in the database.
	 * Sends email to the user with an autogenerated password
	 *
	 * @name : registerUser
	 *      
	 * @author : salvi
	 * @return : Boolean
	 * @param : email, String
	 */
	static function registerUser($email){
		$r = framework::query("SELECT count(Email) as C from user where Email = '$email';");
		
		if (isset($r[0]))
			if ($r[0]['C'])
				if ($r[0]['C'] * 1 > 0)
					return false;
		
		$password = uniqid();
		framework::query("INSERT INTO `user` (Email) values ('$email');");
		framework::query("INSERT INTO `account` (User, Password) values ('$email','" . md5($password) . "');");
		
		return array(
				"email" => $email,
				"password" => $password
		);
	}
	
	/**
	 * : Checks if the email/password combination is valid.
	 * Returns null if not, else returns a User object so the controller can add it to the session
	 *
	 * @name : login
	 * @author : salvi
	 * @return : User/null
	 * @param : email, String
	 * @param : password String
	 */
	static function login($email, $password){
		$user = self::getUser($email);
		if (! is_null($user)) {
			
			if ($user['PASSWORD'] === md5($password))
				return $user;
		}
		return false;
	}
	
	/**
	 * : Returns teh current user loggued in the session, or null otherwhise
	 *
	 * @name : getCurrentUser
	 * @author : salvi
	 * @return : user session variable
	 */
	static function getCurrentUser(){
		if (! self::isSessionStarted())
			return false;
		$user = framework::session_get('user');
		$userx = self::getUser($user['EMAIL']);
		$user = array_merge($user, $userx);
		return $user;
	}
	
	/**
	 * : Returns true if the session is started, false otherwhise
	 *
	 * @name : isSessionStarted
	 * @author : salvi
	 * @return : Boolean
	 */
	static function isSessionStarted(){
		return framework::session_exists("user");
	}
	
	/**
	 * : Returns true if the session is started and is started by admin, false otherwhise
	 *
	 * @name : isSessionStartedByAdmin
	 * @author : rafa
	 * @return : Boolean
	 */
	static function isSessionStartedByAdmin(){
		if (self::isSessionStarted()) {
			$user = self::getCurrentUser();
			return $user['ADMINISTRATOR'] == '1';
		}
		return false;
	}
	
	/**
	 * : Updates the info of a user in the database
	 *
	 * @name : updateUserInformation
	 * @author : salvi
	 * @param : email, String
	 * @param : user, User
	 */
	static function updateUserInformation($email, $user){
		framework::connect();
		
		$email = mysql_real_escape_string($email);
		
		if (! is_null($user)) {
			$updates = array(
					'user,FullName,FULLNAME',
					'user,ShippingMethod,SHIPPINGMETHOD',
					'user,PaymentMethod,PAYMENTMETHOD',
					'user,SaveCreditCardInfo,SAVECREDITCARDINFO',
					'user,Language,LANGUAGE',
					'user,Administrator,ADMINISTRATOR',
					'user,SubscribeNews,SUBSCRIBENEWS',
					'user,Sex,SEX',
					'credit_card,Name,NAMEONCARD',
					'credit_card,Number,CARDNUMBER*',
					'credit_card,Type,CARDTYPE',
					'credit_card,ExpirationMonth,EXPIRATIONMONTH*',
					'credit_card,ExpirationYear,EXPIRATIONYEAR*',
					'credit_card,SecurityCode,SECURITYCODE*',
					'account,Password,PASSWORD',
					'account,Status,STATUS',
					'address,LineOne,LINEONE',
					'address,LineTwo,LINETWO',
					'address,State,STATE',
					'address,City,CITY',
					'address,ZipCode,ZIPCODE',
					'user,Email,EMAIL'
			);
			
			foreach ( $updates as $update ) {
				$arr = explode(",", $update);
				
				if (strpos($arr[2], '*') !== false) {
					$arr[2] = str_replace('*', '', $arr[2]);
					$user[$arr[2]] = self::encrypt($user[$arr[2]]);
				}
				
				if ($arr[0] != 'user') {
					$r = framework::query("SELECT count(*) as TOTAL FROM {$arr[0]} WHERE User = '$email';");
					if ($r[0]['TOTAL'] < 1) {
						framework::query("INSERT INTO {$arr[0]} (User) VALUES ('$email');");
					}
				}
				
				if (isset($user[$arr[2]])) {
					
					if ($arr[1] == 'Password')
						$arr[2] = md5($arr[2]);
										
					$sql = "UPDATE {$arr[0]} SET {$arr[1]} = '{$user[$arr[2]]}' Where " . ($arr[0] == 'user' ? 'Email' : 'User') . " = '$email';";
					
					framework::query($sql);
				}
			}
			
			$cu = framework::session_get('user');
			
			if ($email == $cu['EMAIL']) {
				
				if (isset($user['EMAIL']))
					$email = $user['EMAIL'];
				
				framework::session_set('user', self::getUser($email));
			}
		}
	}
	static function getEncryptKey(){
		
		// the key should be random binary, use scrypt, bcrypt or PBKDF2 to
		// convert a string into a key
		// key is specified using hexadecimal
		return file_get_contents("key/fag.key");
	}
	public static function encrypt($input){
		$key = self::getEncryptKey();
		$output = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $input, MCRYPT_MODE_CBC, md5(md5($key))));
		return $output;
	}
	public static function decrypt($input){
		$key = self::getEncryptKey();
		$output = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($input), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		return $output;
	}
	
	/**
	 * Return a credit card
	 *
	 * @name getCreditCard
	 *      
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @static
	 *
	 *
	 *
	 * @param string $email
	 * @return array
	 */
	static function getCreditCard($email){
		framework::log("Loading credit card info");
		
		$r = framework::query("
        SELECT
            User as USER,
            Name as NAMEONCARD,
            Type as CARDTYPE,
            Number as CARDNUMBER,
			Number as NUMBER,
			Type as TYPE,
            ExpirationMonth as EXPIRATIONMONTH,
            ExpirationYear as EXPIRATIONYEAR,
            SecurityCode as SECURITYCODE
        FROM credit_card
        WHERE User = '$email';");
		
		if (isset($r[0]))
			if (isset($r[0]['USER']))
				if ($r[0]['USER'] == $email) {
					$cc = $r[0];
					$cc['CARDNUMBER'] = self::decrypt($cc['CARDNUMBER']);
					$cc['NUMBER'] = $cc['CARDNUMBER'];
					$cc['EXPIRATIONMONTH'] = self::decrypt($cc['EXPIRATIONMONTH']);
					$cc['EXPIRATIONYEAR'] = self::decrypt($cc['EXPIRATIONYEAR']);
					$cc['SECURITYCODE'] = self::decrypt($cc['SECURITYCODE']);
					
					// framework::log("Credit card expiration: MONTH = {$cc['EXPIRATIONMONTH']} YEAR = {$cc['EXPIRATIONYEAR']}");
					
					return $cc;
				}
		
		return array(
				"USER" => $email,
				"NAMEONCARD" => null,
				"CARDTYPE" => null,
				"CARDNUMBER" => null,
				"EXPIRATIONMONTH" => null,
				"EXPIRATIONYEAR" => null,
				"SECURITYCODE" => null
		);
	}
	
	/**
	 * : If no credit card exist for the user in the database, creates a new one, else update.
	 * Used in updateUserInformation
	 *
	 * @name saveCreditCard
	 * @author : salvi
	 * @param : email, String
	 * @param : creditCard, CreditCard
	 */
	static function saveCreditCard($email, $creditCard){
		framework::log("Saving credit card info");
		
		$user = self::getUser($email);
		$email = mysql_real_escape_string($email);
		
		$creditCard['CARDNUMBER'] = self::encrypt($creditCard['CARDNUMBER']);
		$creditCard['EXPIRATIONMONTH'] = self::encrypt($creditCard['EXPIRATIONMONTH']);
		$creditCard['EXPIRATIONYEAR'] = self::encrypt($creditCard['EXPIRATIONYEAR']);
		$creditCard['SECURITYCODE'] = self::encrypt($creditCard['SECURITYCODE']);
		
		$r = self::getCreditCard($email);
		
		// Insert the new credit card if not exists
		if (is_null($r)) {
			$sql = "INSERT INTO credit_card (User,Name,Type,Number,ExpirationMonth,ExpirationYear,SecurityCode)
			VALUES ('$email',
			'{$creditCard['NAMEONCARD']}',
			'{$creditCard['CARDTYPE']}',
			'{$creditCard['CARDNUMBER']}',
			'{$creditCard['EXPIRATIONMONTH']}',
			'{$creditCard['EXPIRATIONYEAR']}',
			'{$creditCard['SECURITYCODE']}');";
		} else {
			$sql = "UPDATE credit_card SET
			Name = '{$creditCard['NAMEONCARD']}',
			Type = '{$creditCard['CARDTYPE']}',
			Number = '{$creditCard['CARDNUMBER']}',
			ExpirationMonth = '{$creditCard['EXPIRATIONMONTH']}',
			ExpirationYear = '{$creditCard['EXPIRATIONYEAR']}',
			SecurityCode = '{$creditCard['SECURITYCODE']}'
			WHERE User = '$email';";
		}
		
		framework::query($sql);
	}
	
	/**
	 * Return an address
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param strin $email
	 * @return array
	 */
	static function getAddress($email){
		$r = framework::query("
        SELECT
            User as USER,
            LineOne as LINEONE,
            LineTwo as LINETWO,
            State as STATE,
            City as CITY,
            ZipCode as ZIPCODE
        FROM address
        WHERE User = '$email';");
		
		if (isset($r[0]))
			if (isset($r[0]['USER']))
				if ($r[0]['USER'] == $email)
					return $r[0];
		
		return array(
				"USER" => $email,
				"LINEONE" => null,
				"LINETWO" => null,
				"STATE" => null,
				"CITY" => null,
				"ZIPCODE" => null
		);
	}
	
	/**
	 * : If no address exist for the user in the database, creates a new one, else update.
	 * Used in updateUserInformation
	 *
	 * @name : saveAddress
	 * @author : salvi
	 * @param : email, String
	 * @param : address, Address
	 */
	static function saveAddress($email, $address){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Checking arguments
		$email = mysql_real_escape_string($email);
		
		// Get the address
		$r = self::getAddress($email);
		
		// Insert the new address if not exists
		if (is_null($r)) {
			framework::query("INSERT INTO address (User,LineOne,LineTwo,State,City,ZipCode)
			VALUES ('$email',
			'{$address['LINEONE']}',
			'{$address['LINETWO']}',
			'{$address['STATE']}',
			'{$address['CITY']}',
			'{$address['ZIPCODE']}');");
		} else {
			
			// Update the address
			
			$data = $address;
			
			// Escape the values
			foreach ( $data as $key => $value ) {
				if (is_string($data[$key]))
					$data[$key] = mysql_real_escape_string($value);
			}
			
			$fields = array(
					'LineOne' => 'LINEONE',
					'LineTwo' => 'LINETWO',
					'State' => 'STATE',
					'City' => 'CITY',
					'ZipCode' => 'ZIPCODE'
			);
			
			// Preparing the SQL query
			$sql = "UPDATE address SET ";
			
			$i = 0;
			foreach ( $fields as $field => $dataindex ) {
				if (isset($data[$dataindex])) {
					if ($i > 0)
						$sql .= ",";
					$i ++;
					$sql .= $field . " = '{$data[$dataindex]}'";
				}
			}
			
			$sql .= " WHERE User = '$email';";
			
			// Execute the SQL
			if ($i > 0)
				framework::query($sql);
		}
	}
	
	/**
	 * Return a filtered list of shipping methods
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param string $field
	 * @param mixed $value
	 * @param integer $maxcount
	 * @param integer $offset
	 * @return array
	 */
	static function getShippingMethodBy($field = null, $value = null, $maxcount = null, $offset = null){
		framework::connect();
		
		if (is_string($value))
			$value = mysql_real_escape_string($value);
		
		$where = 'TRUE ';
		if (is_array($field)) {
			foreach ( $field as $key => $v ) {
				if (is_numeric($key)) {
					$key = $v;
					$v = $value;
				}
				$where .= " AND $key = '$v' ";
			}
		} else {
			$where = "$field = '$value' ";
		}
		
		$sql = "
        SELECT
            Id as ID,
            Name as NAME,
            Description as DESCRIPTION
        FROM shipping_method
        " . (is_null($field) ? "" : " WHERE $where ") . "
        " . (is_null($maxcount) ? "" : "LIMIT " . (is_null($offset) ? "" : "$offset,") . " $maxcount");
		
		$r = framework::query($sql);
		
		if ($maxcount == 1)
			if (isset($r[0])) {
				if (isset($r[0]['ID']))
					if ($r[0]['ID'] == $value)
						return $r[0];
			} else
				return null;
		
		return $r;
	}
	
	/**
	 * Return a shipping method
	 *
	 * @author rafa
	 * @param integer $Id
	 * @return array
	 */
	static function getShippingMethod($Id){
		return self::getShippingMethodBy("Id", $Id * 1, 1, 0);
	}
	
	/**
	 * Return the list of shipping methods
	 *
	 * @author rafa
	 * @return array
	 */
	static function getShippingMethods(){
		return self::getShippingMethodBy();
	}
	
	/**
	 * Return a filtered list of payment methods
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param string $field
	 * @param mixed $value
	 * @param integer $maxcount
	 * @param integer $offset
	 * @return array
	 */
	static function getPaymentMethodBy($field = null, $value = null, $maxcount = null, $offset = null, $lang = null, $nolang = null, $over_where = null){
		framework::connect();
		
		if (is_string($value))
			$value = mysql_real_escape_string($value);
		
		$where = ' TRUE ';
		if (! is_null($field)) {
			if (is_array($field)) {
				foreach ( $field as $key => $v ) {
					if (is_numeric($key)) {
						$key = $v;
						$v = $value;
					}
					$where .= " AND $key = '$v' ";
				}
			} else {
				$where = "$field = '$value' ";
			}
		}
		
		$sql = "";
		if (! is_null($over_where)) {
			$sql .= "SELECT query.* FROM (";
		}
		
		$sql .= "
        SELECT
            Id as ID,

            (SELECT payment_method_texts.Name as NAME
            FROM   payment_method_texts
            WHERE  payment_method_texts.Id = payment_method.Id
            AND (payment_method_texts.Language = '{$lang}' OR payment_method_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
            AND payment_method_texts.Name is not null
            AND payment_method_texts.Name <> ''
            ORDER BY (payment_method_texts.Language = '$nolang') + 0 DESC
            LIMIT 1) as NAME,

            (SELECT payment_method_texts.Description as DESCRIPTION
            FROM   payment_method_texts
            WHERE  payment_method_texts.Id = payment_method.Id
            AND (payment_method_texts.Language = '{$lang}' OR payment_method_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
            AND payment_method_texts.Description is not null
            AND payment_method_texts.Description <> ''
            ORDER BY (payment_method_texts.Language = '$nolang') + 0 DESC
            LIMIT 1) as DESCRIPTION,
            Logo as LOGO
        FROM payment_method
	    WHERE
            (NOT EXISTS (SELECT Id
                          FROM payment_method_texts
                          WHERE payment_method_texts.Id = paper.Id AND payment_method_texts.Language = '$nolang'
                          AND  (Name <> '' AND Name IS NOT NULL)
                              +(Description <> '' AND Description IS NOT NULL) = 2)
              OR '$nolang' = '')
             AND ({$where}) ";
		
		if (! is_null($maxcount)) {
			$sql .= " LIMIT ";
			if (is_null($offset)) {
				$sql .= " $maxcount ";
			} else
				$sql .= " $offset,$maxcount";
		}
		
		if (! is_null($over_where)) {
			$sql .= ") as query WHERE $over_where; ";
		}
		
		$r = framework::query($sql);
		
		if ($maxcount == 1)
			if (isset($r[0])) {
				if (isset($r[0]['ID']))
					if ($r[0]['ID'] == $value)
						return $r[0];
			}
		
		if (isset($r[0]))
			return $r;
		
		return array();
	}
	
	/**
	 * Return the list of payment methods
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @return array
	 */
	static function getPaymentMethods(){
		return self::getPaymentMethodBy();
	}
	
	/**
	 * Return a payment method
	 *
	 * @static
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param integer $Id
	 * @return array
	 */
	static function getPaymentMethod($Id){
		return self::getPaymentMethodBy("Id", $Id * 1, 1, 0);
	}
	
	/**
	 * Add a shipping method
	 *
	 * @static
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param string $name
	 * @param string $description
	 */
	static function addShippingMethod($name, $description){
		framework::connect();
		
		$name = mysql_real_escape_string($name);
		$description = mysql_real_escape_string($description);
		
		framework::query("INSERT INTO shippingmethod (Name, Description) VALUES ('$name','$description');");
	}
	
	/**
	 * Add a payment method
	 *
	 * @static
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param string $name
	 * @param string $description
	 * @param string $logo
	 */
	static function addPaymentMethod($name, $description, $logo){
		framework::connect();
		
		$name = mysql_real_escape_string($name);
		$description = mysql_real_escape_string($description);
		
		framework::query("INSERT INTO paymentmethod (Name, Description, Logo) VALUES ('$name','$description','$logo');");
	}
	
	/**
	 * Delete a shipping method
	 *
	 * @author rafa
	 * @param integer $id
	 */
	static function delShippingMethod($id){
		framework::query("DELETE FROM shipping_method WHERE Id = $id;");
	}
	
	/**
	 * Delete a payment methof
	 *
	 * @param integer $id
	 */
	static function delPaymentMethod($id){
		framework::query("DELETE FROM payment_method WHERE Id = $id;");
	}
	
	/**
	 * Update a shipping method information
	 *
	 * : If no Shipping Method exist for the user in the database, creates a new one, else update. Used in updateUserInformation
	 *
	 * @author salvi
	 * @param email, String
	 * @param shippingMethod, ShippingMethod
	 */
	static function saveShippingMethod($email, $shippingMethod){
		$user = self::getUser($email);
		
		$email = mysql_real_escape_string($email);
		
		$r = null;
		if (isset($shippingMethod['ID']))
			$r = self::getShippingMethod($shippingMethod['ID']);
			
			// Insert the new address if not exists
		if (is_null($r)) {
			framework::query("INSERT INTO shipping_method (Id, Name, Description)
			VALUES ('{$shippingMethod['ID']}',
			'{$shippingMethod['NAME']}',
			'{$shippingMethod['DESCRIPTION']}');");
			framework::query("UPDATE user SET shipping_method = LAST_INSERT_ID() WHERE email = '$email';");
		} else
			framework::query("UPDATE user SET shipping_method = '{$shippingMethod['ID']}' WHERE email = '$email';");
	}
	
	/**
	 * Return the data of a language
	 *
	 * @static
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * @author rafa
	 * @version 1.0
	 * @param string $code
	 * @return array
	 */
	static function getLanguage($code){
		$r = framework::query("
        SELECT
            Code as CODE,
            Name as NAME,
            Image as IMAGE
        FROM language
        WHERE Code = '{$code}';");
		
		if (isset($r[0]))
			if (isset($r[0]['ID']))
				if ($r[0]['ID'] == $Id)
					return $r[0];
		return null;
	}
	
	/**
	 * Return the list of languages
	 *
	 * @return array
	 */
	static function getLanguages(){
		$r = framework::query("
        SELECT
            Code as CODE,
            Name as NAME,
            Image as IMAGE,
            Country as COUNTRY
        FROM language;");
		
		if (isset($r[0]))
			return $r;
		return null;
	}
	
	/**
	 * Set the language of user
	 *
	 * @static
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * @author rafa <rafa@pragre.com>
	 * @version 1.0
	 * @param string $email
	 * @param string $language
	 */
	static function saveLanguage($email, $language){
		$user = self::getUser($email);
		$email = mysql_real_escape_string($email);
		
		if (is_array($language))
			if (isset($language['CODE']))
				$language = $language['CODE'];
		
		framework::query("UPDATE user SET language = '{$language}' WHERE email = '$email';");
	}
	
	/**
	 * Save the profile of current user
	 *
	 * @param array $profile
	 */
	static function saveProfile($profile){
		$user = self::getCurrentUser();
		self::updateUserInformation($user['EMAIL'], $profile);
		$user = array_merge($user, $profile);
		framework::session_set('user', $user);
	}
	
	/**
	 * Create a generic filename
	 *
	 * @param string $name
	 * @param string $chars
	 * @return string
	 */
	static function getFileNameFor($name, $chars = ".abcdefghijklmnopqrstuvwxyz1234567890_"){
		$name = strtolower($name);
		
		$newname = "";
		$l = strlen($name);
		for($i = 0; $i < $l; $i ++) {
			if (strpos($chars, $name[$i]) !== false)
				$newname .= $name[$i];
			else
				$newname .= ' ';
		}
		
		$name = $newname;
		while ( strpos($name, "  ") !== false )
			$name = str_replace("  ", " ", $name);
		
		$name = str_replace(" ", "_", $name);
		
		while ( strpos($name, "__") !== false )
			$name = str_replace("__", "_", $name);
		
		return $name;
	}
}