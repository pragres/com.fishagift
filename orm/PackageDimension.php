<?php

/**
 * Basic class to control the dimensions of a package
 * Required by ShippingMethod
 *
 * @author Salvi
 * */
class PackageDimension{
	private $isEnvelop = false;

	public $width;
	public $height;
	public $base;

	/**
	 * Creates a new dimensions object. Use two arguments for envelops, three for parcels
	 *
	 * @author Salvi
	 * @param float $width
	 * @param float $height
	 * @param float $base, not required for envelops
	 * */
	public function __construct($width, $height, $base=false){
		$this->width = $width;
		$this->height = $height;
		$this->base = $base;

		// in case is an envelop
		if(!$base){
			$this->isEnvelop = true;
			$this->base = 5.125;
		}
	}

	/**
	 * Checks if the package is an envelop, else is a package
	 * 
	 * @author Salvi
	 * @return boolean, true if is envelop, false if is parcel
	 * */
	function isEnvelop(){
		return $this->isEnvelop;
	}
	
	
	/**
	 * Checks if a item fits on this package
	 * I know the name of the function is gramatically wrong, but I wanted to preserve the "is" part
	 * 
	 * @author Salvi
	 * @param float $width
	 * @param float $height
	 * @param float $base
	 * @return boolean
	 * */
	function isPackageFit($width, $height, $base){
		return $width < $this->width && 
			   $height < $this->height && 
			   $base < $this->base;
	}
}
