<?php

/**
 * FiashAGift administration
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
class Administration {
	
	/**
	 * Based on a zipcode, connects to USPS and returns price of shipping
	 *
	 * @static
	 *
	 *
	 *
	 *
	 * @author rafa
	 * @version 1.0
	 * @param string $zipCode
	 * @param : string $shippingType (2days shipping, one day, etc.)
	 * @return float
	 */
	static function calculateShippingAmount($zipCode, $shippingType){}
	
	/**
	 * Crea a new order
	 *
	 * @static
	 *
	 *
	 *
	 *
	 * @author rafa
	 * @version 1.0
	 * @param array $order
	 */
	static function createNewOrder($order){
		$sc = $order['SHOPPINGCART'];
		
		$sql = "INSERT INTO `order`
        (Tracking, 
        Receiver, ReceiverAddress1, ReceiverAddress2, ReceiverCity, ReceiverZipCode,
        Sender,   SenderAddress1,   SenderAddress2,   SenderCity,   SenderZipCode,
        PaymentMethod, ConfirmationNumber, Status)
        VALUES 
        ('{$order['TRACKING']}', 
         '{$order['RECEIVER']}', '{$order['RECEIVERADDRESS1']}', '{$order['RECEIVERADDRESS2']}', '{$order['RECEIVERCITY']}', '{$order['RECEIVERZIPCODE']}',
         '{$order['SENDER']}',   '{$order['SENDERADDRESS1']}',   '{$order['SENDERADDRESS2']}',   '{$order['SENDERCITY']}',   '{$order['SENDERZIPCODE']}',
         '{$order['PAYMENTMETHOD']}', '{$order['CONFIRMATIONNUMBER']}','Pending');";
		
		framework::query($sql);
		
		$r = framework::query("SELECT LAST_INSERT_ID() as ID;");
		$orderId = $r[0]['ID'];
		
		// Add the product history
		
		$conf = Security::getWebsiteConfigs();
		$price_paper = $conf['price_paper'];
		$price_card = $conf['price_card'];
		$price_bag = $conf['price_bag'];
		$price_ornament = $conf['price_ornament'];
		$tax = $order['TAX'];
		
		$item = $sc['item'];
		
		framework::log("Creating new order ITEM = " . json_encode($item));
		
		include_once framework::resolve("packages/store/model/Packing.php");
		include_once framework::resolve("packages/store/model/Card.php");
		
		$paper = array_merge(array(
				'NAME' => ''
		), empty($sc['paper']) ? array() : Packing::getPaperById($sc['paper']['ID']));
		
		$card = array_merge(array(
				'TITLE' => '',
				'DEFAULTTEXT' => ''
		), empty($sc['card']) ? array() : Card::getCardById($sc['card']));
		
		if (isset($sc['bag']))
			$bag = Packing::getBagById($sc['bag']);
		else
			$bag = '';
		
		$item_dimensions = $item['WIDTH'] . ", " . $item['HEIGHT'] . ", " . $item['BASE'];
		
		if (! empty($bag))
			$bag_dimensions = $bag['WIDTH'] . ", " . $bag['HEIGHT'] . ", " . $bag['BASE'];
		else {
			$bag = array(
					'NAME' => ''
			);
			$bag_dimensions = '';
		}
		
		$cardmessage = 'null';
		$cardmessagestyle = 'null';
		if (isset($sc['CARDMESSAGE']))
			$cardmessage = "'{$sc['CARDMESSAGE']}'";
		if (isset($sc['CARDMESSAGESTYLE']))
			$cardmessagestyle = "'{$sc['CARDMESSAGESTYLE']}'";
		
		$sql = "INSERT INTO product_bought
	    		(`Order`, ItemNameLong,ItemDimensions,ItemPrice,ItemWeight,
	            PaperName,PaperPrice,
	            BagName,BagDimensions,
	            CardTitle,CardMessage,CardMessageStyle,CardDefaultText,Tax, ShippingPrice, Price,
				ItemImage, PaperImage)
	    VALUES (
	    '{$r[0]['ID']}','{$item['NAMELONG']}', '$item_dimensions', '{$item['PRICE']}', '{$item['WEIGHT']}',
	    '{$paper['NAME']}', '$price_paper', '{$bag['NAME']}', '$bag_dimensions',
	    '{$card['TITLE']}','{}',$cardmessage,$cardmessagestyle, $tax, {$order['SHIPPINGPRICE']},{$order['PRICE']},
		'{$item['IMAGE1']}','{$paper['IMAGE']}');";
		
		framework::query($sql);
		
		// Add the ornaments history
		
		if (isset($sc['ornament']))
			if (is_array($sc['ornament']))
				foreach ( $sc['ornament'] as $ornament ) {
					$ornament = Packing::getOrnamentById($id);
					$ornament['NAME'] = mysql_real_escape_string($ornament['NAME']);
					$sql = "INSERT INTO product_bought_ornaments (Product, Ornament) VALUES ('$orderId','{$ornament['NAME']}');";
					framework::query($sql);
				}
		
		return $orderId;
	}
	
	/**
	 * Return a list of orders
	 *
	 * @param string $status
	 * @param integer $maxcount
	 * @return array
	 */
	static function getOrders($status = 'Pending', $maxcount = null, $where = null){
		$sql = "SELECT
	     Transaction as TRANSACTION,
	     Date as DATE,
	     Tracking as TRACKING,
	     Status as STATUS,
	     Sender as SENDER,
	     SenderAddress1 as SENDERADDRESS1,
	     SenderAddress2 as SENDERADDRESS2,
	     SenderCity as SENDERCITY,
	     SenderZipCode as SENDERZIPCODE,
	     Receiver as RECEIVER,
	     ReceiverAddress1 as RECEIVERADDRESS1,
	     ReceiverAddress2 as RECEIVERADDRESS2,
	     ReceiverCity as RECEIVERCITY,
	     ReceiverZipCode as RECEIVERZIPCODE,
	     PaymentMethod as PAYMENTMETHOD,
	     ConfirmationNumber as CONFIRMATIONNUMBER
	    FROM `order` WHERE TRUE
	    " . (is_null($status) ? "" : " AND Status = '$status'") . "
	    " . (is_null($where) ? "" : " AND ($where) ") . "
	    " . (is_null($maxcount) ? "" : "LIMIT $maxcount;
	    ");
		
		return framework::query($sql);
	}
	
	/**
	 * Return an order
	 *
	 * @author rafa
	 * @param integer $transaction
	 */
	static function getOrder($transaction){
		$transaction = $transaction * 1;
		$r = self::getOrders(null, null, "Transaction = '$transaction'");
		
		if (isset($r[0]))
			if (isset($r[0]['TRANSACTION']))
				if ($r[0]['TRANSACTION'] == $transaction)
					return $r[0];
		
		return null;
	}
	
	
	static function setTrackingNumber($transaction, $number){
		
		include_once framework::resolve('packages/email/model/Email.php');
		
		framework::query("UPDATE `order` SET Tracking = '$number', Status = 'Delivered' WHERE Transaction =  $transaction;");
		
		Email::sendTrackingNumber($transaction);
		
	}
	
	/**
	 * Return the details of an order
	 *
	 * @author rafa
	 * @param integer $transaction
	 * @param string $lang
	 * @return array
	 */
	static function getOrderDetails($transaction, $lang = null){
		include_once framework::resolve('packages/base/model/Security.php');
		include_once framework::resolve('packages/store/model/Packing.php');
		include_once framework::resolve('packages/store/model/Card.php');
		include_once framework::resolve('packages/store/model/Items.php');
		include_once framework::resolve('packages/store/model/ShoppingCart.php');
		
		$order = self::getOrder($transaction);
		
		// Datails of sender
		$order['SENDER'] = Security::getUser($order['SENDER']);
		
		// $order['SENDER']['ADDRESS'] = Security::getAddress($order['SENDER']['EMAIL']);
		// $order['SENDER']['CREDITCARD'] = Security::getCreditCard($order['SENDER']['EMAIL']);
		
		$sql = "
	    SELECT
	    ItemNameLong as ITEMNAMELONG,
	    ItemDimensions as ITEMDIMENSIONS,
	    ItemPrice as ITEMPRICE,
	    ItemWeight as ITEMWEIGHT,
	    ItemImage as ITEMIMAGE,
	    PaperName as PAPERNAME,
	    PaperPrice as PAPERPRICE,
	    PaperImage as PAPERIMAGE,
	    BagName as BAGNAME,
	    BagDimensions as BAGDIMENSIONS,
	    CardTitle as CARDTITLE,
	    CardMessage as CARDMESSAGE,
	    CardMessageStyle as CARDMESSAGESTYLE,
	    CardDefaultText as CARDDEFAULTTEXT,
	    Tax as TAX,
	    ShippingPrice as SHIPPINGPRICE,
	    Price as PRICE
	    FROM product_bought
	    WHERE `order` = $transaction";
		
		$order['PRODUCT'] = framework::query($sql);
		if (isset($order['PRODUCT'][0]))
			$order['PRODUCT'] = $order['PRODUCT'][0];
		
		$order['PRODUCT']['ORNAMENTS'] = framework::query("SELECT Ornament as ORNAMENT FROM product_bought_ornaments WHERE Product = $transaction;");
		
		return $order;
	}
	
	/**
	 * Set the status of an order
	 *
	 * @author rafa
	 * @param integer $transaction
	 * @param string $status
	 */
	static function setOrderStatus($transaction, $status){
		$sql = "UPDATE `order` SET status = '$status' WHERE Transaction = $transaction;";
		framework::query($sql);
	}

	/**
	 * Return a list of all images's information (collection, image name, image field, table)
	 * - The collection is the subfolder under /static/images
	 * - The image name is the file name of image
	 * - The image field is the field that store the image name in the table
	 * - The ttable is the name of the table with this images (each collection have a table)
	 *
	 * @return array
	 */
	static function getListOfAllImages(){
		$sql = "select 'bags' as collection, Image1 as image, 'Image1' as field, 'bag' as ttable from bag where image1 is not null and image1 != ''
				union select 'bags' as collection, Image2 as image, 'Image2' as field, 'bag' as ttable from bag where image2 is not null and image2 != ''
				union select 'bags' as collection, Image3 as image, 'Image3' as field, 'bag' as ttable from bag where image3 is not null and image3 != ''
				union select 'ornaments' as collection, Image as image, 'Image' as field, 'ornament' as ttable from ornament where Image is not null and image !=''
				union select 'items' as collection, Image1 as image, 'Image1' as field, 'item' as ttable from item where image1 is not null and image1 != ''
				union select 'items' as collection, Image2 as image, 'Image2' as field, 'item' as ttable from item where image2 is not null and image2 != ''
				union select 'items' as collection, Image3 as image, 'Image3' as field, 'item' as ttable from item where image3 is not null and image3 != ''
				union select 'items' as collection, Image4 as image, 'Image4' as field, 'item' as ttable from item where image4 is not null and image4 != ''
				union select 'items' as collection, Image5 as image, 'Image5' as field, 'item' as ttable from item where image5 is not null and image5 != ''
				union select 'flags' as collection, Image as image, 'Image' as field, 'language' as ttable from language where Image is not null and Image != ''
				union select 'payment_method' as collection, Logo as image, 'Logo' as field, 'payment_method' as ttable from payment_method where Logo is not null and Logo != ''
				union select 'cards' as collection, Image1 as image, 'Image1' as field, 'card' as ttable from card where image1 is not null and image1 != ''
				union select 'cards' as collection, Image2 as image, 'Image2' as field, 'card' as ttable from card where image2 is not null and image2 != ''
				union select 'cards' as collection, Image3 as image, 'Image3' as field, 'card' as ttable from card where image3 is not null and image3 != ''
				union select 'papers' as collection, Image as image, 'Image' as field, 'paper' as ttable from paper where Image is not null and Image != '';
				";
		
		return framework::query($sql);
	}
	
	/**
	 * Clear the not found and unmatched images
	 *
	 * @author rafa
	 * @return array
	 */
	static function clearImages($only_stats = false){
		
		// TODO: Upgrade for multi-server mode
		$images = self::getListOfAllImages();
		
		$collections = array(
				'bags',
				'cards',
				'flags',
				'items',
				'ornaments',
				'papers'
		);
		
		$found = array();
		$not_found = array();
		$not_match = array();
		
		// Search for not found images
		
		if (is_array($images))
			foreach ( $images as $image ) {
				$pathimg = "static/images/" . $image['collection'] . "/" . $image['image'];
				if (! framework::url_exists(framework::resolve($pathimg)))
					$not_found[] = $image;
				else
					$found[$pathimg] = true;
			}
			
			// Search for unmatched images
		foreach ( $collections as $collection ) {
			$dir = scandir("static/images/$collection");
			foreach ( $dir as $entry ) {
				if ($entry != '..' && $entry != ".") {
					$fullentry = 'static/images/' . $collection . '/' . $entry;
					if (! isset($found[$fullentry]))
						$not_match[] = $fullentry;
				}
			}
		}
		
		if (! $only_stats) {
			foreach ( $not_found as $n ) {
				$sql = "UPDATE {$n['ttable']} SET {$n['field']} = null where {$n['field']} = '{$n['image']}'";
				framework::query($sql);
			}
			
			foreach ( $not_match as $n )
				unlink($n);
		}
		
		return array(
				"not_found" => $not_found,
				"not_match" => $not_match,
				"found" => $found
		);
	}
	
	/**
	 * Return the image stats
	 *
	 * @author rafa <rafa@pragres.com>
	 * @return array
	 */
	static function getImagesStats(){
		return self::clearImages(true);
	}

	/**
	 * Get a semi-colon separated list of the emails of all the admins in the website
	 * 
	 * @author salvi
	 * @return String, admin emails divided by ;
	 * */
	static function getAdminsEmails(){
		$admins = framework::query("SELECT Email as EMAIL FROM user WHERE Administrator = 1;");
		$list = array();
		foreach ($admins as $a) array_push($list, $a['EMAIL']);
		return implode($list, ";");
	}
}