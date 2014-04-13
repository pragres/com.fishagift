<?php

/**
 * Items
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
class Items {
	
	/**
	 * Return a list of items may be filtered
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $field
	 * @param mixed $value
	 * @param integer $maxcount
	 * @param integer $offset
	 * @param string $lang
	 * @param string $nolang
	 * @param string $over_where
	 * @param string @order_by
	 *       
	 * @return array
	 */
	static public function getItemsBy($field = null, $value = null, $maxcount = null, $offset = null, $lang = null, $nolang = null, $over_where = null, $order_by = null){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the value
		if (is_string($value))
			$value = mysql_real_escape_string($value);
			
			// Preparing the SQL filter
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
		
		// Preparing the SQL
		$sql .= "
            SELECT
            item.Id as ID,
        
            (SELECT item_texts.NameShort as NAMESHORT
             FROM   item_texts
             WHERE  item_texts.Id = item.Id
             AND (item_texts.Language = '{$lang}' OR item_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
             AND item_texts.NameShort is not null
             AND item_texts.NameShort <> ''
             ORDER BY (item_texts.Language = '$nolang') + 0 DESC
             LIMIT 1) as NAMESHORT,

            (SELECT item_texts.NameLong as NAMELONG
             FROM   item_texts
             WHERE  item_texts.Id = item.Id
             AND (item_texts.Language = '{$lang}' OR item_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
             AND item_texts.NameLong is not null
             AND item_texts.NameLong <> ''
             ORDER BY (item_texts.Language = '$nolang') + 0 DESC
             LIMIT 1) as NAMELONG,

            (SELECT item_texts.Description as DESCRIPTION
             FROM   item_texts
             WHERE  item_texts.Id = item.Id
             AND (item_texts.Language = '{$lang}' OR item_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
             AND item_texts.Description is not null
             AND item_texts.Description <> ''
             ORDER BY (item_texts.Language = '$nolang') + 0 DESC
             LIMIT 1) as DESCRIPTION,

             item.Image1 as IMAGE1,
             item.Image2 as IMAGE2,
             item.Image3 as IMAGE3,
             item.Image4 as IMAGE4,
             item.Image5 as IMAGE5,
             item.Width as WIDTH,
             item.Height as HEIGHT,
             item.Base as BASE,
             item.Weight as WEIGHT,
             item.Price as PRICE,
             item.Category as CATEGORY,
		     item.TimesAccessed as TIMESACCESSED,
		     item.TimesBought as TIMESBOUGHT,
		     item.Popularity as POPULARITY,
		     item.Stars as STARS,

             (SELECT category_texts.NameShort as CATEGORYNAME
              FROM category_texts
              WHERE category_texts.Id = item.Category
              AND (category_texts.Language = '$lang' OR '$lang' = '' OR '$lang' = 'all')
             LIMIT 1) as CATEGORYNAME,
             
             item.Status as STATUS,
             item.Similars as SIMILARS,
             item.Stock as STOCK
             FROM item_details as item
             WHERE 
             (NOT EXISTS (SELECT Id
                          FROM item_texts
                          WHERE item_texts.Id = item.Id AND item_texts.Language = '$nolang'
                          AND  (NameShort <> '' AND NameShort IS NOT NULL)
                              +(NameLong <> '' AND NameLong IS NOT NULL)
                              +(Description <> '' AND Description IS NOT NULL) = 3)
              OR '$nolang' = '')
             AND ({$where}) ";
		
		if (! is_null($order_by)) {
			$sql .= " ORDER BY $order_by ";
		}
		
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
			} else
				return null;
		
		if (isset($r[0]))
			return $r;
		
		return array();
	}
	
	/**
	 * Return a list of categories may be filtered
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $field
	 * @param mixed $value
	 * @param integer $maxcount
	 * @param integer $offset
	 * @param string $lang
	 *
	 * @return array
	 */
	static public function getCategoriesBy($field = null, $value = null, $maxcount = null, $offset = null, $lang = null, $nolang = null){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the value
		if (is_string($value))
			$value = mysql_real_escape_string($value);
			
			// Preparing the SQL filter
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
		
		// Preparing the SQL
		$sql = "
            SELECT
            category.Id as ID,

            (SELECT category_texts.NameShort as NAMESHORT
             FROM   category_texts
             WHERE  category_texts.Id = category.Id
             AND (category_texts.Language = '{$lang}' OR category_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
             AND category_texts.NameShort is not null
             AND category_texts.NameShort <> ''
             ORDER BY (category_texts.Language = '$nolang') + 0 DESC
             LIMIT 1) as NAMESHORT,

            (SELECT category_texts.NameLong as NAMELONG
             FROM   category_texts
             WHERE  category_texts.Id = category.Id
             AND (category_texts.Language = '{$lang}' OR category_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
             AND category_texts.NameLong is not null
             AND category_texts.NameLong <> ''
             ORDER BY (category_texts.Language = '$nolang') + 0 DESC
             LIMIT 1) as NAMELONG,

            (SELECT category_texts.Description as DESCRIPTION
             FROM   category_texts
             WHERE  category_texts.Id = category.Id
             AND (category_texts.Language = '{$lang}' OR category_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
             AND category_texts.Description is not null
             AND category_texts.Description <> ''
             ORDER BY (category_texts.Language = '$nolang') + 0 DESC
             LIMIT 1) as DESCRIPTION
             FROM category
             WHERE
             (NOT EXISTS (SELECT Id
                          FROM category_texts
                          WHERE category_texts.Id = category.Id AND category_texts.Language = '$nolang'
                          AND  (NameShort <> '' AND NameShort IS NOT NULL)
                              +(NameLong <> '' AND NameLong IS NOT NULL)
                              +(Description <> '' AND Description IS NOT NULL) = 3)
              OR '$nolang' = '')
             AND ({$where}) ";
		
		if (! is_null($maxcount)) {
			$sql .= " LIMIT ";
			if (is_null($offset)) {
				$sql .= " $maxcount ";
			} else
				$sql .= " $offset,$maxcount";
		}
		
		$r = framework::query($sql);
		
		if ($maxcount == 1)
			if (isset($r[0])) {
				if (isset($r[0]['ID']))
					if ($r[0]['ID'] == $value)
						return $r[0];
			} else
				return null;
		
		if (isset($r[0]))
			return $r;
		
		return array();
	}
	
	/**
	 * Return an item
	 * Return an item based on their ID, with their texts in the specific language.
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id The item's Id
	 * @param string $lang Filter by the language
	 *       
	 * @return array An item represented by an array
	 */
	static public function getItemById($id, $lang = null){
		$item = self::getItemsBy("item.Id", $id, 1, 0, $lang);
		if (is_null($item))
			$item = self::getItemsBy("item.Id", $id, 1, 0, null);
		return $item;
	}
	
	/**
	 * Return an item
	 * Return an category based on their ID, with their texts in the specific language.
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id The item's Id
	 * @param string $lang Filter by the language
	 *       
	 * @return array An item represented by an array
	 */
	static public function getCategoryById($id, $lang = null){
		$item = self::getItemsBy("category.Id", $id, 1, 0, $lang);
		if (is_null($item))
			$item = self::getItemsBy("category.Id", $id, 1, 0, null);
		return $item;
	}
	
	/**
	 * Return a list of items filtered by their name
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $name
	 * @param integer $maxcount
	 * @param string $lang
	 *
	 * @return array
	 */
	static function getItemsByName($name, $maxcount = null, $lang = 'en'){
		return self::getItemsBy("item.NameShort", $name, $maxcount, 0, $lang);
	}
	
	/**
	 * Return a list of items filtered by their category
	 *
	 * To select the list of Item divided by type shown in the selling page
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param integer $category
	 * @param integer $maxcount
	 * @return array
	 */
	static function getItemsByCategory($category, $maxcount = null){
		return self::getItemsBy("item.Category", $category, $maxcount);
	}
	
	/**
	 * Return a list of items ordered by their popularity
	 *
	 * @static @public access
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $maxcount
	 *
	 * @return array A list of items
	 */
	static function getItemsByPopularity($maxcount = null, $offset = null, $lang = null){
		return self::getItemsBy("item.Status", "Active", $maxcount, $offset, $lang, null, null, "Popularity DESC");
	}
	
	/**
	 * Return a list of similar items of an item
	 *
	 * To add at the end of the description pages
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param itneger $maxcount
	 *
	 * @return array
	 */
	static public function getSimilarItems($id, $maxcount = 5){
		$item = self::getItemByID($id);
		$similars = $item['SIMILARS'];
		
		$similars = $similars != "" ? explode(",", $similars) : Array();
		$items = Array();
		foreach ( $similars as $simil ) {
			$items[] = self::getItemById($simil);
		}
		return $items;
	}
	
	/**
	 * Return a list of item's texts
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param string $lang
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static public function getItemTexts($id, $lang = null, $maxcount = null, $offset = null){
		
		// Checking arguments
		$id = $id * 1;
		if (! is_null($lang)) {
			$maxcount = 1;
			$offset = 0;
		}
		
		// Preparing SQL query
		$sql = "
        SELECT
            Id as ID,
            NameShort as NAMESHORT,
            NameLong as NAMELONG,
            Description as DESCRIPTION,
            Language as LANGUAGE
        FROM item_texts
        WHERE Id = $id ";
		
		if (! is_null($lang))
			$sql .= " AND Language = '$lang'";
		
		$sql .= (is_null($maxcount) ? "" : "LIMIT " . (is_null($offset) ? "" : "$offset,") . " $maxcount");
		
		// Execute the query
		$r = framework::query($sql);
		
		// Return the results
		if ($maxcount == 1)
			if (isset($r[0])) {
				if (isset($r[0]['ID']))
					if ($r[0]['ID'] == $id)
						return $r[0];
			} else
				return null;
		
		if (isset($r[0]))
			return $r;
		
		return null;
	}
	
	/**
	 * Return a list of category's texts
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param string $lang
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static public function getCategoryTexts($id, $lang = null, $maxcount = null, $offset = null){
		
		// Checking arguments
		$id = $id * 1;
		if (! is_null($lang)) {
			$maxcount = 1;
			$offset = 0;
		}
		
		// Preparing SQL query
		$sql = "
        SELECT
            Id as ID,
            NameShort as NAMESHORT,
            NameLong as NAMELONG,
            Description as DESCRIPTION,
            Language as LANGUAGE
        FROM category_texts
        WHERE Id = $id ";
		
		if (! is_null($lang))
			$sql .= " AND Language = '$lang'";
		
		$sql .= (is_null($maxcount) ? "" : "LIMIT " . (is_null($offset) ? "" : "$offset,") . " $maxcount");
		
		// Execute the query
		$r = framework::query($sql);
		
		// Return the results
		if ($maxcount == 1)
			if (isset($r[0])) {
				if (isset($r[0]['ID']))
					if ($r[0]['ID'] == $id)
						return $r[0];
			} else
				return null;
		
		if (isset($r[0]))
			return $r;
		
		return null;
	}
	
	/**
	 * Return a list of languages without translations for the item
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @return array
	 */
	static public function getMissingTranslationsOfItem($id){
		$id = $id * 1;
		
		// Preparing SQL query
		$sql = "
        SELECT
            language.Code AS CODE,
            language.Name as NAME
        FROM language
        WHERE NOT EXISTS (
            SELECT * FROM item_texts
            WHERE item_texts.Language = language.Code and item_texts.Id = $id);";
		
		// Executing the query
		$r = framework::query($sql);
		
		// Return the result
		if (isset($r[0]))
			return $r;
		
		return array();
	}
	
	/**
	 * Return the count of items
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @return integer
	 */
	static public function getCountOfItems(){
		$r = framework::query("SELECT count(*) as TOTAL from item;");
		return $r[0]['TOTAL'];
	}
	
	/**
	 * Return the count of items
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @return integer
	 */
	static public function getCountOfCategories(){
		$r = framework::query("SELECT count(*) as TOTAL from category;");
		return $r[0]['TOTAL'];
	}
	
	/**
	 * Return the count of item texts
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 *
	 * @return integer
	 */
	static public function getCountOfItemTexts($id = null, $lang = null){
		$sql = "SELECT sum(NameShort <> '' AND NameShort IS NOT NULL)
                     + sum(NameLong <> '' AND NameLong IS NOT NULL)
                     + sum(Description <> '' AND Description IS NOT NULL) AS TOTAL
                FROM item_texts
                WHERE TRUE ";
		$sql .= is_null($id) ? "" : " AND Id = $id";
		$sql .= is_null($lang) ? "" : " AND Language = '$lang';";
		$r = framework::query($sql);
		return $r[0]['TOTAL'];
	}
	
	/**
	 * Return the count of category texts
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 *
	 * @return integer
	 */
	static public function getCountOfCategoryTexts($id = null, $lang = null){
		$sql = "SELECT sum(NameShort <> '' AND NameShort IS NOT NULL)
                     + sum(NameLong <> '' AND NameLong IS NOT NULL)
                     + sum(Description <> '' AND Description IS NOT NULL) AS TOTAL
                FROM category_texts
                WHERE TRUE ";
		$sql .= is_null($id) ? "" : " AND Id = $id";
		$sql .= is_null($lang) ? "" : " AND Language = '$lang';";
		$r = framework::query($sql);
		return $r[0]['TOTAL'];
	}
	
	/**
	 *
	 *
	 * Return the translation progress for an item (or all)
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 *
	 * @return array
	 */
	static public function getItemTranslationProgress($id = null, $lang = null){
		
		// Calculate the count of languages
		$r = framework::query("SELECT count(*) as TOTAL from language;");
		$langs = $r[0]['TOTAL'];
		
		$litems = self::getCountOfItems();
		
		// Calculate the count of items and item texts
		if (is_null($id) && is_null($lang))
			$total = $litems * $langs;
		elseif (is_null($id))
			$total = $litems;
		else
			$total = $langs;
		
		$part = self::getCountOfItemTexts($id, $lang);
		
		if ($total == 0)
			$percent = 0;
		else
			$percent = number_format($part / ($total * 3) * 100, 2);
			
			// Return results
		return array(
				"TOTAL" => $total * 3,
				"PART" => $part,
				"PERCENT" => $percent
		);
	}
	
	/**
	 *
	 *
	 * Return the translation progress for a category (or all)
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 *
	 * @return array
	 */
	static public function getCategoryTranslationProgress($id = null, $lang = null){
		
		// Calculate the count of languages
		$r = framework::query("SELECT count(*) as TOTAL from language;");
		$langs = $r[0]['TOTAL'];
		
		$litems = self::getCountOfCategories();
		
		// Calculate the count of items and item texts
		if (is_null($id) && is_null($lang))
			$total = $litems * $langs;
		elseif (is_null($id))
			$total = $litems;
		else
			$total = $langs;
		
		$part = self::getCountOfCategoryTexts($id, $lang);
		
		if ($total == 0)
			$percent = 0;
		else
			$percent = number_format($part / ($total * 3) * 100, 2);
			
			// Return results
		return array(
				"TOTAL" => $total * 3,
				"PART" => $part,
				"PERCENT" => $percent
		);
	}
	
	/**
	 * Add an item record
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $NameShort
	 * @param string $NameLong
	 * @param string $Description
	 * @param string $Image1
	 * @param string $Image2
	 * @param string $Image3
	 * @param string $Image4
	 * @param string $Image5
	 * @param numeric $Width
	 * @param numeric $Height
	 * @param numeric $Base
	 * @param numeric $Weight
	 * @param numeric $Price
	 * @param integer $Category
	 * @param string $Status
	 * @param string $Similars
	 * @param integer $Stock
	 */
	static function addItem($NameShort, $NameLong, $Description, $Image1, $Image2, $Image3, $Image4, $Image5, $Width, $Height, $Base, $Weight, $Price, $Category, $Status, $Similars, $Stock, $lang = 'en'){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Checking the arguments
		$args = get_defined_vars();
		
		foreach ( $args as $var => $val ) {
			if (is_string($$var))
				$$var = mysql_real_escape_string($$var);
			elseif (is_numeric($$var))
				$$var = $$var * 1;
			elseif (is_numeric(str_replace(",", ".", $$var))) {
				$$var = str_replace(",", ".", $$var);
				$$var = $$var * 1;
			} elseif (is_bool($$var))
				$$var = $$var ? 1 : 0;
		}
		
		// Inserting the item
		$sql = "
        INSERT INTO item
            (Image1,Image2,Image3,Image4,Image5, Width,Height,
            Base,Weight,Price,Category,Status, Similars, Stock)
        VALUES
            ('$Image1','$Image2','$Image3','$Image4','$Image5','$Width','$Height',
            '$Base','$Weight','$Price','$Category','$Status','$Similars','$Stock');";
		
		framework::query($sql);
		
		// Truncate the texts
		$NameShort = trim($NameShort);
		$NameLong = trim($NameLong);
		$Description = trim($Description);
		
		// Checking the texts
		if ($NameShort != '' || $NameLong != '') {
			// Insert the texts
			self::setItemTexts('LAST_INSERT_ID()', $lang, array(
					"NAMESHORT" => $NameShort,
					"NAMELONG" => $NameLong,
					"DESCRIPTION" => $Description
			));
		}
	}
	
	/**
	 * Add or update a translation for item' texts
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $Id
	 * @param string $Language
	 * @param array $data
	 *
	 */
	static public function setItemTexts($Id, $Language, $data){
		$fields = array(
				'NameShort' => 'NAMESHORT',
				'NameLong' => 'NAMELONG',
				'Description' => 'DESCRIPTION'
		);
		
		// Escape the values
		foreach ( $data as $key => $value ) {
			if (is_string($data[$key])) {
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}
		
		// Preparing values
		foreach ( $fields as $key => $value ) {
			if (isset($data[$value]))
				$$key = $data[$value];
			else
				$$key = '';
		}
		
		// Checking if the item exists
		
		if ($Id == 'LAST_INSERT_ID()')
			$item = true;
		else
			$item = self::getItemById($Id);
		
		if (! is_null($item)) {
			$c = self::getCountOfItemTexts($Id, $Language) * 1;
			
			$i = 0;
			if ($c < 1) {
				
				framework::query("DELETE FROM item_texts WHERE Id = $Id AND Language = '$Language';");
				
				if (trim($NameShort) != '' || trim($NameLong) != '') {
					// Insert the new translation
					$sql = "
                        INSERT INTO item_texts
                        (Id, Language, NameShort, NameLong, Description)
                        VALUES ($Id, '$Language', '$NameShort', '$NameLong', '$Description');";
					$i = 1;
				}
			} else {
				
				// Update the translation
				if (trim($NameShort) == '' && trim($NameLong) == '') {
					$sql = "DELETE FROM item_texts WHERE Id = $Id AND Language = '$Language';";
					$i = 1;
				} else {
					$sql = "UPDATE item_texts SET ";
					
					foreach ( $fields as $field => $dataindex ) {
						if (isset($data[$dataindex])) {
							if ($i > 0)
								$sql .= ",";
							$i ++;
							$sql .= $field . " = '{$data[$dataindex]}'";
						}
					}
					
					$sql .= " WHERE Id = $Id AND Language = '$Language';";
				}
			}
			
			if ($i > 0)
				framework::query($sql);
		}
	}
	
	/**
	 * Add or update a translation for category' texts
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $Id
	 * @param string $Language
	 * @param array $data
	 *
	 */
	static public function setCategoryTexts($Id, $Language, $data){
		$fields = array(
				'NameShort' => 'NAMESHORT',
				'NameLong' => 'NAMELONG',
				'Description' => 'DESCRIPTION'
		);
		
		// Escape the values
		foreach ( $data as $key => $value ) {
			if (is_string($data[$key])) {
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}
		
		// Preparing values
		foreach ( $fields as $key => $value ) {
			if (isset($data[$value]))
				$$key = $data[$value];
			else
				$$key = '';
		}
		
		// Checking if the item exists
		
		if ($Id == 'LAST_INSERT_ID()')
			$item = true;
		else
			$item = self::getItemById($Id);
		
		if (! is_null($item)) {
			$c = self::getCountOfCategoryTexts($Id, $Language) * 1;
			
			$i = 0;
			if ($c < 1) {
				
				framework::query("DELETE FROM category_texts WHERE Id = $Id AND Language = '$Language';");
				
				if (trim($NameShort) != '' || trim($NameLong) != '') {
					// Insert the new translation
					$sql = "
                        INSERT INTO category_texts
                        (Id, Language, NameShort, NameLong, Description)
                        VALUES ($Id, '$Language', '$NameShort', '$NameLong', '$Description');";
					$i = 1;
				}
			} else {
				
				// Update the translation
				if (trim($NameShort) == '' && trim($NameLong) == '') {
					$sql = "DELETE FROM category_texts WHERE Id = $Id AND Language = '$Language';";
					$i = 1;
				} else {
					$sql = "UPDATE category_texts SET ";
					
					foreach ( $fields as $field => $dataindex ) {
						if (isset($data[$dataindex])) {
							if ($i > 0)
								$sql .= ",";
							$i ++;
							$sql .= $field . " = '{$data[$dataindex]}'";
						}
					}
					
					$sql .= " WHERE Id = $Id AND Language = '$Language';";
				}
			}
			
			if ($i > 0)
				framework::query($sql);
		}
	}
	
	/**
	 * Update an item
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param array $data Associative
	 * @param string $lang Language
	 */
	static function setItem($id, $data, $lang = 'en'){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the values
		foreach ( $data as $key => $value ) {
			if (is_string($data[$key])) {
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}
		
		$fields = array(
				'Image1' => 'IMAGE1',
				'Image2' => 'IMAGE2',
				'Image3' => 'IMAGE3',
				'Image4' => 'IMAGE4',
				'Image5' => 'IMAGE5',
				'Width' => 'WIDTH',
				'Height' => 'HEIGHT',
				'Base' => 'BASE',
				'Weight' => 'WEIGHT',
				'Price' => 'PRICE',
				'Category' => 'CATEGORY',
				'Status' => 'STATUS',
				'Similars' => 'SIMILARS',
				'Stock' => 'STOCK'
		);
		
		// Update the item
		$sql = "UPDATE item SET ";
		
		$i = 0;
		foreach ( $fields as $field => $dataindex ) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
					$sql .= ",";
				$i ++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}
		
		$sql .= " WHERE Id = $id;";
		
		if ($i > 0)
			framework::query($sql);
			
			// Update the texts
		self::setItemTexts($id, $lang, $data);
	}
	
	/**
	 * Update an item
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param array $data Associative
	 * @param string $lang Language
	 */
	static function setCategory($id, $data, $lang = 'en'){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the values
		foreach ( $data as $key => $value ) {
			if (is_string($data[$key])) {
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}
		
		$fields = array(/* no fields in this moment */);
		
		// Update the item
		$sql = "UPDATE category SET ";
		
		$i = 0;
		foreach ( $fields as $field => $dataindex ) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
					$sql .= ",";
				$i ++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}
		
		$sql .= " WHERE Id = $id;";
		
		if ($i > 0)
			framework::query($sql);
			
			// Update the texts
		self::setCategoryTexts($id, $lang, $data);
	}
	
	/**
	 * Return a list of items
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $maxcount
	 * @param integer $offset
	 * @param string $lang
	 *
	 * @return array
	 */
	static public function getItems($maxcount = null, $offset = null, $lang = null){
		return self::getItemsBy(null, null, $maxcount, $offset, $lang);
	}
	
	/**
	 * Return a list of active items
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $maxcount
	 * @param integer $offset
	 * @param string $lang
	 *
	 * @return array
	 */
	static function getActiveItems($maxcount = null, $offset = null, $lang = null){
		return self::getItemsBy("item.Status", "Active", $maxcount, $offset, $lang);
	}
	
	/**
	 * Return a list of items without translations
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $maxcount
	 * @param integer $offset
	 * @param string $lang
	 *
	 * @return array
	 */
	static public function getItemsWithoutTranslation($maxcount = null, $offset = null, $lang = null){
		return self::getItemsBy(null, null, $maxcount, $offset, null, $lang);
	}
	
	/**
	 * Return a list of categories without translations
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $maxcount
	 * @param integer $offset
	 * @param string $lang
	 *
	 * @return array
	 */
	static public function getCategoriesWithoutTranslation($maxcount = null, $offset = null, $lang = null){
		return self::getCategoriesBy(null, null, $maxcount, $offset, null, $lang);
	}
	
	/**
	 * Delete an item
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $Id The item's ID
	 */
	static public function delItem($id){
		framework::query('DELETE FROM item WHERE Id = ' . ($id * 1) . ';');
	}
	
	/**
	 * Delete an item translation
	 *
	 * @param integer $id
	 * @param string $lang
	 *
	 * @return boolean
	 */
	static public function delItemText($id, $lang){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the values
		$id = $id * 1;
		$lang = substr(mysql_real_escape_string($lang), 0, 2);
		
		// Protect the default language
		if ($lang == 'en')
			return false;
			
			// Delete the text
		framework::query("DELETE FROM item_texts WHERE Id = $id AND Language = '$lang';");
		
		return true;
	}
	
	/**
	 * Return the list of categories
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $lang
	 *
	 * @return array
	 */
	static public function getCategories($maxcount = null, $offset = null, $lang = "en"){
		return self::getCategoriesBy(null, null, $maxcount, $offset, $lang);
	}
	
	/**
	 * Add a category
	 *
	 * @static
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $nameshort
	 * @param string $namelong
	 * @param string $description
	 */
	static public function addCategory($nameshort, $namelong, $description, $lang = 'en'){
		
		// Escape the arguments
		$nameshort = mysql_real_escape_string($nameshort);
		$namelong = mysql_real_escape_string($namelong);
		$description = mysql_real_escape_string($description);
		
		// Insert the category
		framework::query("INSERT INTO category VALUES ();");
		
		// Insert the texts
		framework::query("
        INSERT INTO category_texts
            (Id, Language, NameShort, NameLong, Description)
        VALUES (LAST_INSERT_ID(), '$lang','$nameshort','$namelong','$description');");
	}
	
	/**
	 * Remove a category
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 * @param integer $Id
	 */
	static function delCategory($id){
		framework::query('DELETE FROM category WHERE Id = ' . ($id * 1) . ';');
	}
}
