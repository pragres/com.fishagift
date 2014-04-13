<?php

include_once framework::resolve('orm/ShippingMethod.php');

/**
 * Model to calculate the best shipping configuration for the user
 * */
class Shipping {
	static $express = NULL;
	static $priority = NULL;

	/**
	 * Load the flat rates for shipping provided by USPS for express and priority
	 * 
	 * @author salvi
	 * */
	static function loadShippingMethods(){
		$speed = new ShippingSpeed(1,1,'1D');
		self::$express = Array(
			new ShippingMethod("Flat Rate Envelope", 19.95, $speed, new PackageDimension(13.625, 9.5)),
			new ShippingMethod("Medium Flat Rate Box", 39.95, $speed, new PackageDimension(11, 8.5, 5.5)),
			new ShippingMethod("Flat Rate Box", 39.95, $speed, new PackageDimension(13.625, 11.875, 3.375)),
		);

		$speed = new ShippingSpeed(2,3,'2D');
		self::$priority = Array(
			new ShippingMethod("Flat Rate Envelope", 5.60, $speed, new PackageDimension(13.625, 9.5)),
			new ShippingMethod("Small Flat Rate Box", 5.80, $speed, new PackageDimension(8.625, 5.375, 1.625)),
			new ShippingMethod("Medium Flat Rate Box", 12.35, $speed, new PackageDimension(11, 8.5, 5.5)),
			new ShippingMethod("Medium Flat Rate Box", 12.35, $speed, new PackageDimension(13.625, 11.875, 3.375)),
			new ShippingMethod("Large Flat Rate Box", 16.85, $speed, new PackageDimension(12, 12, 5.5)),
			new ShippingMethod("Large Flat Rate Box", 16.85, $speed, new PackageDimension(23.6875, 11.75, 3))
		);
	}

	/**
	 * Returns the cheapest shipping based on the object dimensions 
	 * 
	 * @author salvi
	 * @param float $width
	 * @param float $height
	 * @param float $base
	 * @return Array of ShippingMethod
	 */
	static function getBestShippingOptions($width, $height, $base) {
		self::loadShippingMethods();
		$results = Array();

		// calculate cheapest price for express
		foreach (self::$express as $method){
			if($method->dimensions->isPackageFit($width, $height, $base)){
				$results[] = $method;
				break; 
			}
		}

		// calculate cheapest price for priority
		foreach (self::$priority as $method){
			if($method->dimensions->isPackageFit($width, $height, $base)){
				$results[] = $method;
				break; 
			}
		}

		return $results;		
	}

}