<?php

/**
 * Card
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
class Card {

	/**
	 * Return a list of cards
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param mixed $field
	 * @param mixed $value
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static public function getCardsBy($field = null, $value = null, $maxcount = null, $offset = null) {

		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();

		// Escape the value
		if (is_string($value))
		$value = mysql_real_escape_string($value);

		// Preparing the SQL filter
		$where = 'TRUE ';
		if (is_array($field)) {
			foreach ($field as $key => $v) {
				if (is_numeric($key)) {
					$key = $v;
					$v = $value;
				}
				$where .=" AND $key = '$v' ";
			}
		} else {
			$where = "$field = '$value' ";
		}

		// Preparing the SQL sentence
		$sql = "
        SELECT
            card.Id as ID,
            card.Title as TITLE,
            card.Color1 as COLOR1,
            card.Color2 as COLOR2,
            card.Image1 as IMAGE1,
            card.Image2 as IMAGE2,
            card.Image3 as IMAGE3,
            card.Occasion as OCCASION,
            card.DefaultText as DEFAULTTEXT,
            card.Stock as STOCK,
            card.Status as STATUS,
            card.Language as LANGUAGE,
            (SELECT Name FROM language WHERE language.Code = card.Language) as LANGUAGENAME,
            (SELECT Name FROM occasion_texts WHERE occasion_texts.Id = card.Occasion AND occasion_texts.Language = card.Language) as OCCASIONNAME
        FROM card
        " . (is_null($field) ? "" : " WHERE $where ") . "
        " . (is_null($maxcount) ? "" : "LIMIT " . (is_null($offset) ? "" : "$offset,") . " $maxcount");

		// Execute the SQL
		$r = framework::query($sql);

		// If limit = 1, return the the first entity
		if ($maxcount == 1)
		if (isset($r[0])) {
			if (isset($r[0]['ID']))
			if ($r[0]['ID'] * 1 == $value * 1)
			return $r[0];
		} else
		return null;

		// Return the results ...
		if (isset($r[0]))
		return $r;

		// ... or empty array
		return array();
	}

	/**
	 * Return the count of cards
	 *
	 * @return bigint
	 */
	static function getCountOfCards() {
		$r = framework::query("SELECT count(*) as TOTAL from card;");
		return $r[0]['TOTAL'];
	}

	/**
	 * Return the count of card messages
	 *
	 * @return bigint
	 */
	static function getCountOfCardMessages() {
		$r = framework::query("SELECT count(*) as TOTAL from card_message;");
		return $r[0]['TOTAL'];
	}

	/**
	 * Return a card by their id
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $id
	 *
	 * @return array
	 */
	static function getCardById($id) {
		return self::getCardsBy("card.Id", $id * 1, 1, 0);
	}

	/**
	 * Return a list of cards
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static function getCards($maxcount = null, $offset = null) {
		return self::getCardsBy(null, null, $maxcount, $offset);
	}

	/**
	 * Return a list of cards filtered by their language
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param string $language
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static function getCardsByLanguage($language, $maxcount = null, $offset = null) {
		return self::getCardsBy("card.Language", $language, $maxcount, $offset);
	}

	/**
	 * Return a list of active cards filtered by their language
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param string $language
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static function getActiveCardsByLang($language, $maxcount = null, $offset = null) {
		return self::getCardsBy(array(
	    "card.Language" => $language,
	    "card.Status" => "Active"), null, $maxcount, $offset);
	}

	/**
	 * return a list of cards filtered by their occasion
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $occasion
	 * @param string $language
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static function getCardsByOcassion($occasion, $language, $maxcount = null, $offset = null) {
		return self::getCardsBy(array(
	    "card.Occasion" => $occasion * 1,
	    "card.Language" => $language
		), null, $maxcount, $offset);
	}

	/**
	 * Return a filtered list of card messages
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param mixed $field
	 * @param mixed $value
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static public function getCardMessagesBy($field = null, $value = null, $maxcount = null, $offset = null) {

		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();

		// Escape the value
		if (is_string($value))
		$value = mysql_real_escape_string($value);

		// Preparing the SQL filter
		$where = 'TRUE ';
		if (is_array($field)) {
			foreach ($field as $key => $v) {
				if (is_numeric($key)) {
					$key = $v;
					$v = $value;
				}
				$where .=" AND $key = '$v' ";
			}
		} else {
			$where = "$field = '$value' ";
		}

		// Preparing the SQL
		$sql = "
        SELECT
            card_message.Id as ID,
            card_message.Occasion as OCCASION,
            card_message.Language as LANGUAGE,
            card_message.Text as TEXT,
            (SELECT occasion_texts.Name as OCCASIONNAME
            FROM occasion_texts
            WHERE occasion_texts.Id = card_message.Occasion
            AND (occasion_texts.Language = card_message.Language) LIMIT 1)
            AS OCCASIONNAME
        FROM card_message
        " . (is_null($field) ? "" : " WHERE $where ") . "
        " . (is_null($maxcount) ? "" : "LIMIT " . (is_null($offset) ? "" : "$offset,") . " $maxcount");

		// Execute de SQL
		$r = framework::query($sql);

		/// If limit = 1, return the the first entity
		if ($maxcount == 1)
		if (isset($r[0])) {
			if (isset($r[0]['ID']))
			if ($r[0]['ID'] == $value)
			return $r[0];
		} else
		return null;

		// Return the results ...
		if (isset($r[0]))
		return $r;

		// ... or null
		return null;
	}

	/**
	 * Return a list of card messages
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $maxcount
	 * @param integer $offset
	 *
	 * @return array
	 */
	static public function getCardMessages($maxcount = null, $offset = null) {
		return self::getCardMessagesBy(null, null, $maxcount, $offset);
	}

	/**
	 * Return a card message
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $id
	 *
	 * @return array
	 */
	static public function getCardMessageById($id) {
		return self::getCardMessagesBy("card_message.Id", $id * 1, 1, 0);
	}

	/**
	 * Return a random card message
	 *
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $occasion
	 * @param string $language
	 *
	 * @return string
	 */
	static public function generateCardMessage($occasion = null, $language = null) {

		$filter = array();

		if (!is_null($occasion) && $occasion != 0)
		$filter["card_message.Occasion"] = $occasion * 1;
		if (!is_null($language))
		$filter["card_message.Language"] = $language;

		$r = self::getCardMessagesBy($filter);

		if (!isset($r[0]))
		return "";

		$i = mt_rand(0, count($r) - 1);

		return $r[$i]['TEXT'];
	}

	/**
	 * Update a card message
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $id
	 * @param array $data
	 */
	static public function setCardMessage($id, $data) {

		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();

		// Escape fields
		foreach ($data as $key => $value) {
			if (is_string($data[$key])){
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}

		$fields = array(
	    'Occasion' => 'OCCASION',
	    'Text' => 'TEXT',
	    'Language' => 'LANGUAGE');

		// Preparing the SQL
		$sql = "UPDATE card_message SET ";
		$i = 0;
		foreach ($fields as $field => $dataindex) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
				$sql .= ",";
				$i++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}

		$sql .= ' WHERE id = ' . ($id * 1) . ';';

		// Execute the SQL
		framework::query($sql);
	}

	/**
	 * Add a card
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param string $Title
	 * @param string $Color1
	 * @param string $Color2
	 * @param string $Image1
	 * @param string $Image2
	 * @param string $Image3
	 * @param integer $Occasion
	 * @param string $DefaultText
	 * @param integer $Stock
	 * @param string $Status
	 * @param string $Language
	 */
	static public function addCard($Title, $Color1, $Color2, $Image1, $Image2, $Image3, $Occasion, $DefaultText, $Stock, $Status, $Language) {

		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();

		// Checking the arguments
		$args = get_defined_vars();

		foreach ($args as $var => $val) {
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

		// Preparing the SQL query
		$sql = "
        INSERT INTO card
            (Title, Color1, Color2, Image1, Image2, Image3,
            Occasion, DefaultText, Stock, Status, Language)
	VALUES 
            ('$Title','$Color1', '$Color2', '$Image1', '$Image2', '$Image3',
            '$Occasion', '$DefaultText', '$Stock', '$Status', '$Language');";

		// Execute the SQL
		framework::query($sql);
	}

	/**
	 * Update a card
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $id
	 * @param array $data
	 */
	static public function setCard($id, $data) {

		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();

		// Escape the values
		foreach ($data as $key => $value) {
			if (is_string($data[$key])){
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}

		$fields = array(
	    'Title' => 'TITLE',
	    'Color1' => 'COLOR1',
	    'Color2' => 'COLOR2',
	    'Occasion' => 'OCCASION',
	    'Status' => 'STATUS',
	    'Stock' => 'STOCK',
	    'Image1' => 'IMAGE1',
	    'Image2' => 'IMAGE2',
	    'Image3' => 'IMAGE3',
	    'DefaultText' => 'DEFAULTTEXT',
	    'Language' => 'LANGUAGE');

		// Preparing the SQL query
		$sql = "UPDATE card SET ";

		$i = 0;
		foreach ($fields as $field => $dataindex) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
				$sql .= ",";
				$i++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}

		$sql .= ' WHERE Id = ' . ($id * 1) . ';';

		// Execute the SQL
		if ($i > 0)
		framework::query($sql);
	}

	/**
	 * Remove a card
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $id
	 */
	static public function delCardById($id) {
		framework::query('DELETE FROM card WHERE Id = ' . ($id * 1) . ';');
	}

	/**
	 * Remove a card message
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param integer $id
	 */
	static public function delCardMessage($id) {
		framework::query("DELETE FROM card_message WHERE Id = " . ($id * 1) . ";");
	}

	/**
	 * Add a card message
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @param string $text
	 * @param integer $occasion
	 * @param string $language
	 */
	static function addCardMessage($text, $occasion, $language) {

		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();

		// Checking the arguments
		$args = get_defined_vars();

		foreach ($args as $var => $val) {
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

		// Preparing the SQL query
		$sql = "
        INSERT INTO card_message
            (Occasion, Language, Text)
        VALUES ('$occasion','$language','$text');";

		// Execute the SQL
		framework::query($sql);
	}

}