<?php

/**
 * Controls the speed of a package
 * 
 * @author Salvi
 * */
class ShippingSpeed{
	private $fromXDays;
	private $toYDays;

	public $speed;

	/**
	 * Creates a new shipping speed
	 * 
	 * @author Salvi
	 * @param Number $fromXDays, minimal number of days that the package will take to arrive 
	 * @param Number $toYDays, maximun number of days that the package will take to arrive
	 * @param String $code, Code to define the speed, used to internationalize the speed message [1D | 2D | 1W | 2W]
	 * */
	function __construct($fromXDays, $toYDays, $code=NULL){
		$this->fromXDays = $fromXDays;
		$this->toYDays = $toYDays;
		$this->speed = $code;
	}

	/**
	 * Predicts when the package will be received by the client
	 * 
	 * @author Salvi
	 * @return Date
	 * */
	function predictExpectedDelivery(){
		return date('m-d-Y');
	}
}