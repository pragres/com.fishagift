<?php

/**
 * Shopping carts
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
class ShoppingCart {
	
	/* Default shopping cart structure */
	static $default = array(
			"item" => "",
			"paper" => "",
			// "bag" => "",
			// "card" => "",
			// "ornament" => array(),
			"shipping" => array(
					"price" => null,
					"method" => null,
					"carrier" => null
			),
			"price" => "" // not counting the shipping
		);
	
	/**
	 * Return true if the user had selected an item and wrapping paper, false otherwise
	 *
	 * @author salvi <salvi.pascual@pragres.com>
	 * @version 1.0
	 * @return boolean
	 */
	static function isReadyToCheckout(){
		$shopping_cart = framework::session_get('shopping_cart');
		
		$item = $shopping_cart['item'];
		$paper = $shopping_cart['paper'];
		
		return ($item != "" && $paper != "");
	}
	
	/**
	 * Blank the shopping cart in the session.
	 * It can be use to create a brand new shopping card
	 *
	 * @author salvi <salvi.pascual@gmail.com>
	 * @version 1.0
	 */
	static function clearShoppingCart(){
		$shopping_cart = self::$default;
		$shopping_cart['shipping'] = array(
				"price" => 0,
				"method" => "",
				"carrier" => ""
		);
		
		framework::session_set('shopping_cart', $shopping_cart);
		
		$user = framework::session_get("user");
		
		if ($user !== false)
			framework::query("DELETE FROM shopping_cart WHERE User = '{$user['EMAIL']};");
	}
	
	/**
	 * Blank the shipping details of a shopping cart.
	 * Can be use to create a brand new shipping details
	 *
	 * @author salvi <salvi.pascual@gmail.com>
	 * @version 1.0
	 */
	static function clearShippingDetails(){
		$shippingDetails = Array(
				"price" => 0,
				"method" => "",
				"carrier" => ""
		);
		
		$shopping_cart = framework::session_get('shopping_cart');
		
		$shopping_cart['shipping'] = $shippingDetails;
		
		framework::session_set('shopping_cart', $shopping_cart);
		
		self::save();
	}
	
	/**
	 * Add a new product to the shopping cart
	 *
	 * @author salvi <salvi.pascual@gmail.com>
	 * @version 1.0
	 * @param string $id
	 * @param enum $type (item,paper,card,bag,ornament)
	 * @param float $price
	 */
	static function addToShoppingCart($id, $type, $price){
		framework::log("Add to shopping cart: id = $id type = $type price = $price");
		
		// loading cart from session variblae
		$shopping_cart = framework::session_get('shopping_cart');
		
		if ($type == "ornament") { // adding an ornament
			$ornaments = $shopping_cart['ornament'];
			array_push($ornaments, $id);
			$shopping_cart['ornament'] = $ornaments;
		} else { // adding any other type
			$shopping_cart[$type] = $id;
		}
		
		if (! isset($shopping_cart['price']))
			$shopping_cart['price'] = 0;
			
			// updating the price
		$shopping_cart['price'] = floatval($price) + floatval($shopping_cart['price']);
		
		// updating the cart in the session varible
		framework::session_set('shopping_cart', $shopping_cart);
		
		self::save();
	}
	
	/**
	 * Load the last shopping cart of user
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @return array
	 */
	static public function load(){
		$sc = array();
		
		$user = framework::session_get("user");
		
		if (isset($user['EMAIL'])) {
			$email = $user['EMAIL'];
			
			framework::log("Loading shopping cart of $email");
			
			$r = framework::query("SELECT LastShoppingCart FROM shopping_cart WHERE User = '$email';");
			if (isset($r[0])) {
				if (isset($r[0]['LastShoppingCart'])) {
					$sc = unserialize($r[0]['LastShoppingCart']);
				}
			}
		}
		
		// Checking the integrity and completation of the last shopping cart
		include_once framework::resolve('packages/store/model/Items.php');
		// include_once framework::resolve('packages/store/model/Card.php');
		include_once framework::resolve('packages/store/model/Packing.php');
		
		$sc = array_merge_recursive(self::$default, $sc);
		
		$item = Items::getItemById(intval($sc['item']));
		// $card = Card::getCardById(intval($sc['card']));
		$paper = Packing::getPaperById(intval($sc['paper']));
		// $bag = Packing::getBagById(intval($sc['bag']));
		
		if (is_null($item) /*|| is_null($card)*/ && is_null($paper) /* || is_null($bag)*/)
			self::clearShoppingCart();
			
			/*
		 * if (isset($sc['ornaments'])) foreach ( $sc['ornaments'] as $o ) { $ornament = Packing::getOrnamentById($o); if (is_null($ornament)) { self::clearShoppingCart(); break; } }
		 */
		
		return self::getShoppingCart();
	}
	
	/**
	 * Insert/Update a shopping cart into DB
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param array $data
	 */
	static public function save(){
		$user = framework::session_get("user");
		
		if (isset($user['EMAIL'])) {
			$email = $user['EMAIL'];
			
			$data = serialize(self::getShoppingCart());
			
			framework::log("Loading the last shopping cart of $email");
			$last = self::load();
			
			if (! empty($last)) {
				$sql = "UPDATE shopping_cart SET LastShoppingCart = '$data' WHERE User = '$email';";
			} else
				$sql = "INSERT INTO shopping_cart (User, LastReminderDate, LastShoppingCart) VALUES ('$email', '" . date("Y-m-d") . "','$data');";
			
			framework::log("Saving shopping cart of $email");
			
			framework::query($sql);
		}
	}
	
	/**
	 * Removes a product from the shopping cart
	 *
	 * @author salvi <salvi.pascual@gmail.com>
	 * @param string $id
	 * @param enum $type Object type (item, paper, card, bag, ornament)
	 * @param float $price
	 */
	static function deleteFromShoppingCart($id, $type, $price){
		// loading cart from session variblae
		$shopping_cart = framework::session_get('shopping_cart');
		// removing an ornament
		/*
		 * if ($type == "ornament") { $ornaments = $shopping_cart['ornament']; $key = array_search($id, $ornaments); unset($ornaments[$key]); $shopping_cart['ornament'] = $ornaments; // removing any other type } else {
		 */
		$shopping_cart[$type] = "";
		// }
		
		// updating the price
		$shopping_cart['price'] = floatval($shopping_cart['price']) - floatval($price);
		
		// updating the cart in the session varible
		framework::session_set('shopping_cart', $shopping_cart);
		
		self::save();
	}
	
	/**
	 * Return all the items from the shopping cart
	 *
	 * @author salvi <salvi.pascual@gmail.com>
	 * @version 1.0
	 * @return array Associative array with the keys: item, paper, bag, ornaments, price
	 */
	static function getShoppingCart($detailed = false){
		$sc = framework::session_get("shopping_cart");
		
		if ($detailed) {
			include_once framework::resolve('packages/store/model/Items.php');
			// include_once framework::resolve('packages/store/model/Card.php');
			include_once framework::resolve('packages/store/model/Packing.php');
			
			if (isset($sc['item']))
				$sc['item'] = Items::getItemById($sc['item']);
			else
				$sc['item'] = null;
			
			if (isset($sc['paper']))
				$sc['paper'] = Packing::getPaperById($sc['paper']);
			else
				$sc['paper'] = null;
			
			/*
			 * $sc['bag'] = Packing::getBagById($sc['bag']); $sc['card'] = Card::getCardById($sc['card']); $ornaments = array(); foreach ($sc['ornaments'] as $ornm ) { $ornaments[] = src::getOrnamentById($ornm); } $sc['ornaments'] = $ornaments;
			 */
		}
		
		if (! isset($sc['shipping']))
			$sc['shipping'] = self::$default['shipping'];
		
		return $sc;
	}
	
	/**
	 * Updates the price and method for shipping, for in case the user refresh the page he/she can see the shipping choosed
	 *
	 * @author salvi <salvi.pascual@gmail.com>
	 * @version 1.0
	 * @param float $price
	 * @param string $shippingMethod
	 * @param string $carrier
	 */
	static function setShippingDetails($price, $shippingMethod, $carrier){
		
		// loading cart from session varible
		$shopping_cart = framework::session_get('shopping_cart');
		
		// creating shippingDetails structure
		$shippingDetails = Array(
				"price" => $price,
				"method" => $shippingMethod,
				"carrier" => $carrier
		);
		
		// adding the shipping
		$shopping_cart['shipping'] = $shippingDetails;
		
		// updating the cart in the session varible
		framework::session_set('shopping_cart', $shopping_cart);
		
		// save current shopping cart
		self::save();
	}
}