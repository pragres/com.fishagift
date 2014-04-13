<?php

/**
 * A trace definition to create the user trace
 *
 * @author Salvi
 * */
class Trace{
	private $originator;
	private $location;
	private $timestamp;

	/**
	 * Construct the actual trace and poppulate its values from the system
	 *
	 * @author Salvi
	 * */
	function __construct(){
		$email = "UNKNOWN";
		if(framework::session_exists('user')) {
			$email = framework::session_get('user');
			$email = $email['EMAIL'];
		}

		$this->originator = $email;
		$this->location = framework::getValue('package') .'/'. framework::getValue('page');
		$this->timestamp = date("Y-m-d H:i:s");
	}

	/**
	 * Get the package/page map referent to a location on the website
	 *
	 * @author Salvi
	 * */
	public function getLocation(){
		return $this->location;
	}

	/**
	 * Get the package part for the trace
	 *
	 * @author Salvi
	 * */
	public function getPackage(){
		$arrLocation = explode("/", $this->getLocation());
		return $arrLocation[0];
	}

	/**
	 * Get the page part for the trace
	 *
	 * @author Salvi
	 * */
	public function getPage(){
		$arrLocation = explode("/", $this->getLocation());
		return $arrLocation[1];
	}

	/**
	 * Preatty print a trace to string for debbugin purposes. Shows values inside an HTML table
	 *
	 * @author Salvi
	 * */
	public function __toString(){
		$tbl = '<tr><th>originator</th><th>location</th><th>timestamp</th></tr>'."\n";
		$tbl .= "<tr><td>{$this->originator}</td><td>{$this->location}</td><td>{$this->timestamp}</td></tr>\n";
		return "<table border='1' class='trace'>$tbl</table>\n";
	}
}