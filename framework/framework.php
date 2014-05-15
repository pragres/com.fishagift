<?php
class framework {
	static $config = null;
	static $conn = null;
	
	/**
	 * Query the database
	 * @param : $query, SQL query to the database
	 * @return associative array of cols
	 */
	static public function query($query){
		$conn = self::connect();
		
		$resource = mysql_query($query, $conn);
		
		// Log the query
		self::log($query, "sql.log", "SQL", true, 200);
		
		// for insert, update and delete, return true or false
		if (gettype($resource) == 'boolean')
			return $resource;
			
			// for selects return an associative array
		$arrQuery = array();
		while ( $row = mysql_fetch_array($resource, MYSQL_ASSOC) )
			$arrQuery[] = $row;
		
		return $arrQuery;
	}
	
	/**
	 * resolves a file that may be located in an another node
	 * @param : $path, path to the file starting from the root folder
	 * @return : URL
	 * @throws : Exception if the path is incorrect or non-existing
	 */
	static public function resolve($path){
		// The $path is from the Business Logic Tier
		if (strpos($path, "packages") === 0)
			return $path;
			
			// The $path is from the Static Files Tier
		if (strpos($path, "static") === 0) {
			$path = substr($path, strlen("static/"));
			$node = self::$config;
			return "{$node['cdn']['host']}/$path";
		}
		
		// return the actual path (if exist)
		if (file_exists($path))
			return $path;
			
			// Thrown exception if path was not found
		throw new InvalidArgumentException("Malformed path or nonexistent resource: $path");
	}
	
	/**
	 * links to another page withing the application
	 * @param : $route, page in the form package/pagename
	 * @return : URL
	 */
	static public function link_to($route, $clean = true){
		// accesing global configs
		$node = self::$config;
		
		// generating link
		$route = explode("/", $route);
		$package = $route[0];
		$page = $route[1];
		
		// returning depending if clean=true or false
		if ($clean)
			return "{$node['website']['protocol']}://{$node['website']['appdomain']}/$package/$page";
		else
			return "{$node['website']['protocol']}://{$node['website']['appdomain']}/router.php?package=$package&page=$page";
	}
	
	/**
	 * saves into the global structure a new variable, or updates an existing one
	 * call this function to overwrite the way sessions are called, for future decoupling
	 * @param : $varname, name of the variable to create or update in session
	 * @param : $varvalue, information to store in $varname
	 */
	static public function session_set($varname, $varvalue){
		self::log("Session SET $varname = " . substr(serialize($varvalue), 0, 100));
		$_SESSION[$varname] = $varvalue;
	}
	
	/**
	 * returns a session variable already created with framework::session_set()
	 * call this function to overwrite the way sessions are called, for future decoupling
	 * @param : $varname, name of the variable to load from the session
	 * @return : value of the variable $varname
	 */
	static public function session_get($varname){
		$value = null;
		if (isset($_SESSION[$varname]))
			$value = $_SESSION[$varname];
		
		return $value;
	}
	
	/**
	 * checks if the session variable exist
	 * @param : $varname, name of the variable to check for existance
	 * @return : Boolean
	 */
	static function session_exists($varname){
		return isset($_SESSION[$varname]);
	}
	
	/**
	 * removes a variable from the session
	 * @param : $varname, name of the variable to remove
	 */
	static function session_unset($varname){
		unset($_SESSION[$varname]);
	}
	
	/**
	 * Checks if a URL is valid
	 * @param : $url, valid URL
	 */
	static public function url_exists($url){
		$file_headers = @get_headers($url, 1);
		return ! ($file_headers[0] == 'HTTP/1.1 404 Not Found');
	}
	
	/**
	 * Establishs a connection to the database
	 * @return MySQL Connection
	 *         no need to call this function if using query()
	 */
	static public function connect(){
		if (! self::$conn) {
			
			self::log("Connecting to DB ...");
			
			$host = self::$config['database']['host'];
			$user = self::$config['database']['user'];
			$pass = self::$config['database']['pass'];
			$name = self::$config['database']['name'];
			
			self::$conn = mysql_connect($host, $user, $pass);
			mysql_select_db($name, self::$conn);
		}
		
		return self::$conn;
	}
	
	/**
	 * Closes the connection with the database
	 */
	static public function disconnect(){
		self::log("Disconnecting from DB ...");
		return mysql_close(self::$conn);
	}
	
	/**
	 * Copy a file between two different servers
	 * @param string $from
	 * @param string $to
	 * @return boolean
	 */
	static public function copy($from, $to){
		return copy($from, $to);
	}
	
	/**
	 * Redirection
	 * @param string $path
	 */
	static public function redirect($path, $extra = ""){
		self::log("Redirecting to $path");
		
		if ($extra[0] == '&')
			$extra = substr($extra, 1);
		
		$xpath = self::link_to($path, true) . "/?" . $extra;
		
		$xpath = str_replace("router.php?package=", "", $xpath);
		$xpath = str_replace("&page=", "/", $xpath);
		
		if ($xpath[strlen($xpath) - 1] == '&')
			$xpath = substr($xpath, 0, strlen($xpath) - 1);
		
		if ($xpath[strlen($xpath) - 1] == '?')
			$xpath = substr($xpath, 0, strlen($xpath) - 1);
		
		self::log("Finally, redirecting to $xpath");
		
		header("Location: " . $xpath);
	}
	
	/**
	 * getValue
	 * Search in the query string to return the value of $var.
	 * Try first by GET, and then by POST. Remove all CSS and JS to avoid injections
	 * @author Salvi
	 * @param $var String: Varible to capture from URL
	 * @param $clean Bool: Convert all CSS and JS code to HTML. True by default
	 * @return Value of $var passed from POST or GET or NULL if values does not exist
	 */
	static public function getValue($var, $clean = true){
		if (! isset($_REQUEST[$var]))
			$r = "";
		else
			$r = $clean ? htmlentities($_REQUEST[$var]) : $_REQUEST[$var];
		
		self::log("Get REQUEST $var = " . serialize($r));
		
		return $r;
	}
	
	/**
	 * sendEmail
	 *
	 * Sends an email message in HTML format
	 * @author Salvi
	 * @param String $to
	 * @param String $subject
	 * @param String $body
	 * @return JSON data structure with details
	 */
	static public function sendEmail($to, $subject, $body){
		$config = array();
		$config['api_key'] = "key-208em7uk6c6z-cw1ps4vuwczl7mnzk62";
		$config['api_url'] = "https://api.mailgun.net/v2/fishagift.com/messages";
		
		$message = array();
		$message['from'] = "Fish a Gift <support@fishagift.com>;";
		$message['to'] = $to;
		$message['h:Reply-To'] = "Fish a Gift <support@fishagift.com>;";
		$message['subject'] = html_entity_decode($subject, null, 'UTF-8');
		$message['html'] = $body;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $config['api_url']);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD, "api:{$config['api_key']}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
	
	/**
	 * Logs
	 *
	 * @param string $msg
	 * @param string $file
	 * @param string $level
	 * @param boolean $clear
	 */
	static public function log($msg, $file = "default.log", $level = 'INFO', $clear = false, $truncate = null){
		$user = self::session_get('user');
		
		if (isset($user)) {
			if (! is_null($user)) {
				if (isset($user['ID']))
					$user = $user['ID'];
				elseif (isset($user['USERNAME']))
					$user = $user['USERNAME'];
				elseif (isset($user['EMAIL']))
					$user = $user['EMAIL'];
			} else
				$user = 'Unknown';
		} else
			$user = 'Unknown';
		
		if (isset(self::$config['run_mode']))
			if (self::$config['run_mode'] == 'development') {
				if ($clear) {
					$msg = str_replace("\n", " ", $msg);
					while ( strpos($msg, "  ") !== false )
						$msg = str_replace("  ", " ", $msg);
					
					$msg = trim($msg);
				}
				
				if (! is_null($truncate)) {
					if ($truncate * 1 > 0) {
						$msg = substr($msg, 0, $truncate * 1) . " (...)";
					}
				}
				
				if (file_exists("logs/$file")) {
					if (filesize("logs/$file") >= 1024 * 1024 * 5) {
						file_put_contents("logs/$file", "");
					}
				}
				
				$f = fopen("logs/$file", 'a');
				fputs($f, "[$level] " . date("Y-m-d h:i:s") . " $user - $msg \n");
				fclose($f);
			}
	}
	
	/**
	 * Summarizes the status of the application at the moment is called.
	 * Displays the content of all the internal variables and the params from the URL
	 * Useful for debugging and errors reporting
	 *
	 * @author Salvi
	 * @return String
	 */
	static public function applicationStatusSummary(){
		ob_start();
		// user details
		echo "<h2>User information</h2>";
		if (self::session_exists('user'))
			var_dump(self::session_get('user'));
		else
			echo "User is not logged in";
			
			// shopping cart details
		echo "<h2>Shopping cart</h2>";
		var_dump(self::session_get('shopping_cart'));
		
		// Information subbmitted in the URL
		echo "<h2>Varibles submitted</h2>";
		var_dump($_REQUEST);
		
		// pages visited
		echo "<h2>Pages visited</h2>";
		echo Tracer::returnTraceStackHTML();
		return ob_get_clean();
	}
	
	/**
	 * Get current _GET values as URL query
	 *
	 * @return string
	 */
	static function getCurrentUrlQuery($ignore = ''){
		$ignore = explode(",", $ignore);
		
		framework::log("Get current url query, ignore = " . serialize($ignore));
		
		$url = '';
		
		foreach ( $_GET as $key => $val ) {
			if ($key != 'package' && $key != 'page' && array_search($key, $ignore) === false)
				$url .= $key . '=' . urlencode($val) . '&';
		}
		
		$url = substr($url, 0, strlen($url) - 1);
		
		return $url;
	}
}