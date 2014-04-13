<?php

include_once framework::resolve('orm/PackageDimension.php');
include_once framework::resolve('orm/ShippingSpeed.php');

/**
 * Defines a type of shipping
 *
 * @author Salvi
 * */
class ShippingMethod{
	public $name;
	public $price;
	public $speed;
	public $dimensions;
	public $carrier;

	/**
	 * Create a new shipping method
	 * 
	 * @author Salvi
	 * @param String $name
	 * @param ShippingSpeed $speed
	 * @param PackageDimension $dimensions
	 * @param String $carrier, USPS by default
	 * */
	function __construct($name, $price, $speed, $dimensions, $carrier='USPS'){
		$this->name = $name;
		$this->price = $price;
		$this->speed = $speed;
		$this->dimensions = $dimensions;
		$this->carrier = $carrier;
	}

}
