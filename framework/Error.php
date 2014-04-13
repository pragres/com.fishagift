<?php
/**
 * A class to handle the user errors and
 * send error information to the email
 *
 * @author Salvi
 *        
 */
class Error {
	static $errors = array();
	
	/**
	 * Creating a handler to throw customized errors
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param integer $errNum
	 * @param string $errStr
	 */
	static function errorHandler($errNum, $errStr, $errFile, $errLine, $errContext){
		self::$errors[] = array(
				"time" => date("Y-m-d h:i:s"),
				"number" => $errNum,
				"message" => $errStr,
				"file" => $errFile,
				"line" => $errLine,
				"context" => $errContext
		);
	}
	
	/**
	 * Send email to admins/programmers with a list of errors
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 */
	static function notifyErrors(){
		if (isset(self::$errors[0])) {
			$body = '';
			
			// create the error message
			ob_start();
			echo "<h1>We are sorry to say it, but errors occurred</h1>";
			echo "<h2>Errors</h2>";
			echo "<table border=2>";
			echo "<tr><th>#</th><th>Time</th><th>Message</th><th>File</th><th>Line</th></tr>";
			
			$i = 0;
			foreach ( self::$errors as $error ) {
				$i ++;
				echo "<tr><td><b>$i</b></td>";
				echo "<td>{$error['time']}</td>";
				echo "<td width=\"400\">{$error['number']} - {$error['message']}</td>";
				echo "<td>{$error['file']}</td>";
				echo "<td>{$error['line']}</td></tr>\n";
				
				$context = array();
				if (! is_null($error['context']['_POST']))
					$context["_POST"] = htmlentities(var_export($error['context']['_POST'], true));
				if (! is_null($error['context']['_GET']))
					$context["_GET"] = htmlentities(var_export($error['context']['_GET'], true));
				
				if (! empty($context)) {
					echo "<tr><td colspan=\"5\"><i>Context:</i><br/>\n ";
					foreach ( $context as $key => $value )
						echo "<b>$key</b> = <span style=\"font-family: Lucida Console;\">$value</span> <br/>\n";
					echo "</td></tr>\n";
				}
			}
			
			echo "</table>\n";
			echo framework::applicationStatusSummary();
			$body = ob_get_clean();
			
			// send error email
			$to = framework::$config['website']['admin_email'];
			
			if (isset(framework::$config['run_mode'])) {
				if (framework::$config['run_mode'] == 'development'){
					framework::log(strip_tags($body)); 
					echo $body;
				}
				return true;
			}
			
			framework::sendEmail($to, count(self::$errors) . " error(s) has occurred", $body);
		}
	}
}