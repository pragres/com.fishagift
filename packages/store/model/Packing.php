<?php

/**
 * Packing
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
class Packing {
	
	/**
	 * Rreturn a filtered list of papers
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
	static public function getPapersBy($field = null, $value = null, $maxcount = null, $offset = null, $lang = null, $nolang = null, $over_where = null){
		framework::connect();
		
		if (is_string($value))
			$value = mysql_real_escape_string($value);
		
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
		
		$sql .= "
        SELECT
            paper.Id as ID,

            (SELECT paper_texts.Name as NAME
            FROM   paper_texts
            WHERE  paper_texts.Id = paper.Id
            AND (paper_texts.Language = '{$lang}' OR paper_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
            AND paper_texts.Name is not null
            AND paper_texts.Name <> ''
            ORDER BY (paper_texts.Language = '$nolang') + 0 DESC
            LIMIT 1) as NAME,

            (SELECT paper_texts.Description as DESCRIPTION
            FROM   paper_texts
            WHERE  paper_texts.Id = paper.Id
            AND (paper_texts.Language = '{$lang}' OR paper_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
            AND paper_texts.Description is not null
            AND paper_texts.Description <> ''
            ORDER BY (paper_texts.Language = '$nolang') + 0 DESC
            LIMIT 1) as DESCRIPTION,

            paper.Color1 as COLOR1,
            paper.Color2 as COLOR2,
            paper.Occasion as OCCASION,
            paper.Image as IMAGE,
            paper.Status as STATUS,
            
            (SELECT occasion_texts.Name as OCCASIONNAME
            FROM occasion_texts
            WHERE occasion_texts.Id = paper.Occasion
            AND (occasion_texts.Language = '$lang' OR '$lang' = '' OR '$lang' = 'all')
            LIMIT 1)
            AS OCCASIONNAME

        FROM paper
        WHERE
            (NOT EXISTS (SELECT Id
                          FROM paper_texts
                          WHERE paper_texts.Id = paper.Id AND paper_texts.Language = '$nolang'
                          AND  (Name <> '' AND Name IS NOT NULL)
                              +(Description <> '' AND Description IS NOT NULL) = 2)
              OR '$nolang' = '')
             AND ({$where}) ";
		
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
			}
		
		if (isset($r[0]))
			return $r;
		
		return array();
	}
	
	/**
	 * Return the count of papers
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @return bigint
	 */
	static public function getCountOfPapers(){
		$r = framework::query("SELECT count(*) as TOTAL from paper;");
		return $r[0]['TOTAL'];
	}
	
	/**
	 * Return the count of ornaments
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @return bigint
	 */
	static public function getCountOfOrnaments(){
		$r = framework::query("SELECT count(*) as TOTAL from ornament;");
		return $r[0]['TOTAL'];
	}
	
	/**
	 * Return the count of bags
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @return bigint
	 */
	static public function getCountOfBags(){
		$r = framework::query("SELECT count(*) as TOTAL from bag;");
		return $r[0]['TOTAL'];
	}
	
	/**
	 * Return a list of papers
	 *
	 * @author rafa
	 * @return array
	 * @param integer $maxcount
	 */
	static public function getPapers($maxcount = null, $offset = null, $lang = null){
		return self::getPapersBy(null, null, $maxcount, $offset, $lang);
	}
	
	/**
	 * Return a list of papers filtered by their language
	 *
	 *
	 *
	 *
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
	static function getPapersByLanguage($language, $maxcount = null, $offset = null){
		return self::getPapersBy(null, null, $maxcount, $offset, $language, null, 'NAME IS NOT NULL');
	}
	
	/**
	 * Return a list of active papers filtered by their language
	 *
	 *
	 *
	 *
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
	static function getActivePapersByLang($language, $maxcount = null, $offset = null){
		return self::getPapersBy("paper.Status", "Active", $maxcount, $offset, $language, null, 'NAME IS NOT NULL');
	}
	
	/**
	 * Return a list of bags filtered by their language
	 *
	 *
	 *
	 *
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
	static function getBagsByLanguage($language, $maxcount = null, $offset = null){
		return self::getBagsBy(null, null, $maxcount, $offset, $language, null, 'NAME IS NOT NULL');
	}
	
	/**
	 * Return a list of active bags filtered by their language
	 *
	 *
	 *
	 *
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
	static function getActiveBagsByLang($language, $maxcount = null, $offset = null){
		return self::getBagsBy("bag.Status", "Active", $maxcount, $offset, $language, null, 'NAME IS NOT NULL');
	}
	
	/**
	 * Return a list of ornaments filtered by their language
	 *
	 *
	 *
	 *
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
	static function getOrnamentsByLanguage($language, $maxcount = null, $offset = null){
		return self::getOrnamentsBy(null, null, $maxcount, $offset, $language, null, 'NAME IS NOT NULL');
	}
	
	/**
	 * Return a list of active ornaments filtered by their language
	 *
	 *
	 *
	 *
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
	static function getActiveOrnamentsByLang($language, $maxcount = null, $offset = null){
		return self::getOrnamentsBy("ornament.Status", "Active", $maxcount, $offset, $language, null, 'NAME IS NOT NULL');
	}
	
	/**
	 * Return a paper
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer id
	 *       
	 * @return array
	 */
	static function getPaperById($id){
		return self::getPapersBy("paper.Id", $id * 1, 1, 0);
	}
	
	/**
	 * Return the paper's texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param string $lang
	 * @param int $maxcount
	 * @param int $offset
	 *
	 * @return array
	 */
	static function getPaperTexts($id, $lang = null, $maxcount = null, $offset = null){
		
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
            Name as NAME,
            Description as DESCRIPTION,
            Language as LANGUAGE
        FROM paper_texts
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
	 * Return the ornament's texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param string $lang
	 * @param int $maxcount
	 * @param int $offset
	 *
	 * @return array
	 */
	static function getOrnamentTexts($id, $lang = null, $maxcount = null, $offset = null){
		
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
            Name as NAME,
            Description as DESCRIPTION,
            Language as LANGUAGE
        FROM ornament_texts
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
	 * Return a list of languages without translations for the paper
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @return array
	 */
	static public function getMissingTranslationsOfPaper($id){
		$id = $id * 1;
		
		// Preparing SQL query
		$sql = "
        SELECT
            language.Code AS CODE,
            language.Name as NAME
        FROM language
        WHERE NOT EXISTS (
            SELECT * FROM paper_texts
            WHERE paper_texts.Language = language.Code and paper_texts.Id = $id);";
		
		// Executing the query
		$r = framework::query($sql);
		
		// Return the result
		if (isset($r[0]))
			return $r;
		
		return array();
	}
	
	/**
	 * Return the count of paper texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param string $lang
	 *
	 * @return integer
	 */
	static public function getCountOfPaperTexts($id = null, $lang = null){
		$sql = "SELECT sum(Name <> '' AND Name IS NOT NULL)
                     + sum(Description <> '' AND Description IS NOT NULL) AS TOTAL
                FROM paper_texts
                WHERE TRUE ";
		$sql .= is_null($id) ? "" : " AND Id = $id";
		$sql .= is_null($lang) ? "" : " AND Language = '$lang';";
		$r = framework::query($sql);
		return $r[0]['TOTAL'];
	}
	
	/**
	 * Return the count of ornament texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param string $lang
	 *
	 * @return integer
	 */
	static public function getCountOfOrnamentTexts($id = null, $lang = null){
		$sql = "SELECT sum(Name <> '' AND Name IS NOT NULL)
                     + sum(Description <> '' AND Description IS NOT NULL) AS TOTAL
                FROM ornament_texts
                WHERE TRUE ";
		$sql .= is_null($id) ? "" : " AND Id = $id";
		$sql .= is_null($lang) ? "" : " AND Language = '$lang';";
		$r = framework::query($sql);
		return $r[0]['TOTAL'];
	}
	
	/**
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * Return the translation progress for a paper (or all)
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 *
	 * @return array
	 */
	static public function getPaperTranslationProgress($id = null, $lang = null){
		
		// Calculate the count of languages
		$r = framework::query("SELECT count(*) as TOTAL from language;");
		$langs = $r[0]['TOTAL'];
		
		$litems = self::getCountOfPapers();
		
		// Calculate the count of items and item texts
		if (is_null($id) && is_null($lang))
			$total = $litems * $langs;
		elseif (is_null($id))
			$total = $litems;
		else
			$total = $langs;
		
		$part = self::getCountOfPaperTexts($id, $lang);
		
		if ($total == 0)
			$percent = 0;
		else
			$percent = number_format($part / ($total * 2) * 100, 2);
			
			// Return results
		return array(
				"TOTAL" => $total * 2,
				"PART" => $part,
				"PERCENT" => $percent
		);
	}
	
	/**
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * Return the translation progress for an ornament (or all)
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 *
	 * @return array
	 */
	static public function getOrnamentTranslationProgress($id = null, $lang = null){
		
		// Calculate the count of languages
		$r = framework::query("SELECT count(*) as TOTAL from language;");
		$langs = $r[0]['TOTAL'];
		
		$litems = self::getCountOfOrnaments();
		
		// Calculate the count of items and item texts
		if (is_null($id) && is_null($lang))
			$total = $litems * $langs;
		elseif (is_null($id))
			$total = $litems;
		else
			$total = $langs;
		
		$part = self::getCountOfOrnamentTexts($id, $lang);
		
		if ($total == 0)
			$percent = 0;
		else
			$percent = number_format($part / ($total * 2) * 100, 2);
			
			// Return results
		return array(
				"TOTAL" => $total * 2,
				"PART" => $part,
				"PERCENT" => $percent
		);
	}
	
	/**
	 * Return the bag's texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param string $lang
	 * @param int $maxcount
	 * @param int $offset
	 *
	 * @return array
	 */
	static function getBagTexts($id, $lang = null, $maxcount = null, $offset = null){
		
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
            Name as NAME,
            Language as LANGUAGE
        FROM bag_texts
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
	 * Return a list of languages without translations for the bag
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @return array
	 */
	static public function getMissingTranslationsOfBag($id){
		$id = $id * 1;
		
		// Preparing SQL query
		$sql = "
        SELECT
            language.Code AS CODE,
            language.Name as NAME
        FROM language
        WHERE NOT EXISTS (
            SELECT * FROM bag_texts
            WHERE paper_texts.Language = language.Code and bag_texts.Id = $id);";
		
		// Executing the query
		$r = framework::query($sql);
		
		// Return the result
		if (isset($r[0]))
			return $r;
		
		return array();
	}
	
	/**
	 * Return the count of bag texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id The identifier
	 * @param string $language The language
	 * @return integer
	 */
	static public function getCountOfBagTexts($id = null, $lang = null){
		$sql = "SELECT count(*) as TOTAL from bag_texts WHERE TRUE";
		$sql .= is_null($id) ? "" : " AND Id = $id ";
		$sql .= is_null($lang) ? "" : " AND Language = '$lang';";
		$r = framework::query($sql);
		return $r[0]['TOTAL'];
	}
	
	/**
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * Return the translation progress for a bag (or all)
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 *
	 * @return array
	 */
	static public function getBagTranslationProgress($id = null, $lang = null){
		
		// Calculate the count of languages
		$r = framework::query("SELECT count(*) as TOTAL from language;");
		$langs = $r[0]['TOTAL'];
		
		$litems = self::getCountOfBags();
		
		// Calculate the count of items and item texts
		if (is_null($id) && is_null($lang))
			$total = $litems * $langs;
		elseif (is_null($id))
			$total = $litems;
		else
			$total = $langs;
		
		$part = self::getCountOfBagTexts($id, $lang);
		
		if ($total == 0)
			$percent = 0;
		else
			$percent = number_format($part / $total * 100, 2);
			
			// Return results
		return array(
				"TOTAL" => $total,
				"PART" => $part,
				"PERCENT" => $percent
		);
	}
	
	/**
	 * Add or update the paper texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $Id
	 * @param string $Language
	 * @param array $data
	 */
	static public function setPaperTexts($Id, $Language, $data){
		$fields = array(
				'Name' => 'NAME',
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
			$item = self::getPaperById($Id);
		
		if (! is_null($item)) {
			$c = self::getCountOfPaperTexts($Id, $Language);
			$i = 0;
			if ($c < 1) {
				
				framework::query("DELETE FROM paper_texts WHERE Id = $Id AND Language = '$Language';");
				
				// Insert the new translation
				$sql = "
                INSERT INTO paper_texts
                    (Id, Language, Name, Description)
                VALUES ($Id, '$Language', '$Name', '$Description');";
				$i = 1;
			} else {
				// Update the translation
				
				if (trim($Name) == '') {
					$sql = "DELETE FROM paper_texts WHERE Id = $Id AND Language = '$Language';";
					$i = 1;
				} else {
					$sql = "UPDATE paper_texts SET ";
					
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
	 * Add or update the ornament texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $Id
	 * @param string $Language
	 * @param array $data
	 */
	static public function setOrnamentTexts($Id, $Language, $data){
		$fields = array(
				'Name' => 'NAME',
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
			$item = self::getOrnamentById($Id);
		
		if (! is_null($item)) {
			$c = self::getCountOfOrnamentTexts($Id, $Language);
			$i = 0;
			if ($c < 1) {
				
				framework::query("DELETE FROM ornament_texts WHERE Id = $Id AND Language = '$Language';");
				
				// Insert the new translation
				$sql = "
                INSERT INTO ornament_texts
                    (Id, Language, Name, Description)
                VALUES ($Id, '$Language', '$Name', '$Description');";
				$i = 1;
			} else {
				// Update the translation
				
				if (trim($Name) == '') {
					$sql = "DELETE FROM ornament_texts WHERE Id = $Id AND Language = '$Language';";
					$i = 1;
				} else {
					$sql = "UPDATE ornament_texts SET ";
					
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
	 * Add a new paper
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $Color1
	 * @param string $Color2
	 * @param integer $Occasion
	 * @param string $Image
	 * @param string $Name
	 * @param string $Description
	 * @param string $Status
	 */
	static function addPaper($Color1, $Color2, $Occasion, $Image, $Name, $Description, $Status, $lang = 'en'){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Checking arguments
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
		
		framework::query("
        INSERT INTO paper
            (Color1, Color2, Occasion, Image, Status)
        VALUES ('$Color1', '$Color2', '$Occasion', '$Image', '$Status');");
		
		framework::query("
        INSERT INTO paper_texts
            (Id, Language, Name, Description)
        VALUES (LAST_INSERT_ID(), '$lang', '$Name', '$Description');");
	}
	
	/**
	 * Remove a paper
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 */
	static function delPaper($id){
		return framework::query("DELETE FROM paper where Id = " . ($id * 1) . ";");
	}
	
	/**
	 * Delete an paper translation
	 *
	 * @param integer $id
	 * @param string $lang
	 *
	 * @return boolean
	 */
	static public function delPaperText($id, $lang){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the values
		$id = $id * 1;
		$lang = substr(mysql_real_escape_string($lang), 0, 2);
		
		// Protect the default language
		if ($lang == 'en')
			return false;
			
			// Delete the text
		framework::query("DELETE FROM paper_texts WHERE Id = $id AND Language = '$lang';");
		
		return true;
	}
	
	/**
	 * Delete an bag translation
	 *
	 * @param integer $id
	 * @param string $lang
	 *
	 * @return boolean
	 */
	static public function delBagText($id, $lang){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the values
		$id = $id * 1;
		$lang = substr(mysql_real_escape_string($lang), 0, 2);
		
		// Protect the default language
		if ($lang == 'en')
			return false;
			
			// Delete the text
		framework::query("DELETE FROM bag_texts WHERE Id = $id AND Language = '$lang';");
		
		return true;
	}
	
	/**
	 * Return a filtered list of paper bags
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 *        
	 * @param string $field
	 * @param string $value
	 * @param string $maxcount
	 * @param string $offset
	 * @param string $lang
	 *
	 * @return array
	 */
	static function getBagsBy($field = null, $value = null, $maxcount = null, $offset = null, $lang = null, $nolang = null, $over_where = null){
		
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
		
		// Preparing the SQL query
		$sql .= "
        SELECT
            bag.Id as ID,
            
           (SELECT bag_texts.Name as NAME
             FROM   bag_texts
             WHERE  bag_texts.Id = bag.Id
             AND (bag_texts.Language = '{$lang}' OR bag_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
             AND bag_texts.Name is not null
             AND bag_texts.Name <> ''
             ORDER BY (bag_texts.Language = '$nolang') + 0 DESC
             LIMIT 1) as NAME,

            bag.Color1 as COLOR1,
            bag.Color2 as COLOR2,
            bag.Occasion as OCCASION,
            bag.Width as WIDTH,
            bag.Height as HEIGHT,
            bag.Base as BASE,
            bag.Status as STATUS,
            bag.Stock as STOCK,
            bag.Image1 as IMAGE1,
            bag.Image2 as IMAGE2,
            bag.Image3 as IMAGE3,

             (SELECT occasion_texts.Name as OCCASIONNAME
            FROM occasion_texts
            WHERE occasion_texts.Id = bag.Occasion
            AND (occasion_texts.Language = '$lang' OR '$lang' = '' OR '$lang' = 'all')
             LIMIT 1)
            AS OCCASIONNAME

        FROM bag
         WHERE 
             (NOT EXISTS (SELECT Id
                          FROM bag_texts
                          WHERE bag_texts.Id = bag.Id AND bag_texts.Language = '$nolang'
                          AND  (Name <> '' AND Name IS NOT NULL) + 0 = 1)
              OR '$nolang' = '')
             AND ({$where}) ";
		
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
		
		// Execute the SQL
		$r = framework::query($sql);
		
		// Return the results
		if ($maxcount == 1)
			if (isset($r[0])) {
				if (isset($r[0]['ID']))
					if ($r[0]['ID'] == $value)
						return $r[0];
			}
		
		if (isset($r[0]))
			return $r;
		
		return array();
	}
	
	/**
	 * Return a list of paper bags
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa
	 * @version 1.0
	 *         
	 * @param integer $maxcount
	 *
	 * @return array
	 */
	static function getBags($maxcount = null, $offset = null, $lang = null){
		return self::getBagsBy(null, null, $maxcount, $offset, $lang);
	}
	
	/**
	 * Return a list of bags without translations
	 *
	 *
	 *
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
	static public function getBagsWithoutTranslation($maxcount = null, $offset = null, $lang = null){
		return self::getBagsBy(null, null, $maxcount, $offset, null, $lang);
	}
	
	/**
	 * Return a list of papers without translations
	 *
	 *
	 *
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
	static public function getPapersWithoutTranslation($maxcount = null, $offset = null, $lang = null){
		return self::getPapersBy(null, null, $maxcount, $offset, null, $lang);
	}
	
	/**
	 * Return a list of ornaments without translations
	 *
	 *
	 *
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
	static public function getOrnamentsWithoutTranslation($maxcount = null, $offset = null, $lang = null){
		return self::getOrnamentsBy(null, null, $maxcount, $offset, null, $lang);
	}
	
	/**
	 * Return a paper bag
	 *
	 * @author rafa
	 * @version 1.0
	 * @param integer $id
	 * @return array
	 */
	static function getBagById($id){
		return self::getBagsBy("bag.Id", $id * 1, 1, 0);
	}
	
	/**
	 * Add a new paper bag
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $Name
	 * @param string $Color1
	 * @param string $Color2
	 * @param integer $Occasion
	 * @param float $Width
	 * @param float $Height
	 * @param float $Base
	 * @param string $Status
	 * @param integer $Stock
	 * @param string $Image1
	 * @param string $Image2
	 * @param string $Image3
	 */
	static function addBag($Name, $Color1, $Color2, $Occasion, $Width, $Height, $Base, $Status, $Stock, $Image1, $Image2, $Image3, $lang = 'en'){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Checking arguments
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
		
		// Insert the bag
		$sql = "
        INSERT INTO bag
                (Color1, Color2, Occasion, Width, Height, Base, 
                Status, Stock, Image1, Image2, Image3)
        VALUES ('$Color1', '$Color2', '$Occasion', '$Width', '$Height', '$Base',
                '$Status', '$Stock','$Image1','$Image2','$Image3');";
		
		framework::query($sql);
		
		// Insert the texts
		self::setBagTexts('LAST_INSERT_ID()', $lang, array(
				'NAME' => $Name
		));
	}
	
	/**
	 * Add or update the bag texts
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $Id
	 * @param string $Language
	 * @param array $data
	 */
	static public function setBagTexts($Id, $Language, $data){
		$fields = array(
				'Name' => 'NAME'
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
			$item = self::getBagById($Id);
		
		if (! is_null($item)) {
			
			// Checking if the item and the translation exists
			$c = self::getCountOfBagTexts($Id, $Language);
			
			$i = 0;
			if ($c < 1) {
				if (trim($Name) != '') {
					// Insert the new translation
					$sql = "
                    INSERT INTO bag_texts
                        (Id, Language, Name)
                    VALUES ($Id, '$Language', '$Name');";
					$i = 1;
				}
			} else {
				// Update the translation
				if (trim($Name) != '') {
					$sql = "UPDATE bag_texts SET ";
					
					foreach ( $fields as $field => $dataindex ) {
						if (isset($data[$dataindex])) {
							if ($i > 0)
								$sql .= ",";
							$i ++;
							$sql .= $field . " = '{$data[$dataindex]}'";
						}
					}
					
					$sql .= " WHERE Id = $Id AND Language = '$Language';";
				} else {
					$sql = "DELETE FROM bag_texts  WHERE Id = $Id AND Language = '$Language';";
					$i = 1;
				}
			}
			
			if ($i > 0)
				framework::query($sql);
		}
	}
	
	/**
	 * Update a paper bag
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param array $data
	 */
	static function setBag($id, $data, $lang = 'en'){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the values
		foreach ( $data as $key => $value ) {
			if (is_string($data[$key])) {
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}
		
		// Update the bag
		$fields = array(
				'Color1' => 'COLOR1',
				'Color2' => 'COLOR2',
				'Occasion' => 'OCCASION',
				'Width' => 'WIDTH',
				'Height' => 'HEIGHT',
				'Base' => 'BASE',
				'Status' => 'STATUS',
				'Stock' => 'STOCK',
				'Image1' => 'IMAGE1',
				'Image2' => 'IMAGE2',
				'Image3' => 'IMAGE3'
		);
		
		$sql = "UPDATE bag SET ";
		$i = 0;
		foreach ( $fields as $field => $dataindex ) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
					$sql .= ",";
				$i ++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}
		
		$sql .= " WHERE id = " . ($id * 1) . ";";
		
		if ($i > 0)
			framework::query($sql);
			
			// Update the texts
		
		$fields = array(
				'Name' => 'NAME'
		);
		
		$sql = "UPDATE  bag_texts SET ";
		$i = 0;
		foreach ( $fields as $field => $dataindex ) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
					$sql .= ",";
				$i ++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}
		
		$sql .= " WHERE id = " . ($id * 1) . ";";
		
		if ($i > 0)
			framework::query($sql);
	}
	
	/**
	 * Update a paper
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 * @param array $data
	 */
	static public function setPaper($id, $data){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the values
		foreach ( $data as $key => $value ) {
			if (is_string($data[$key])) {
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}
		
		// Update the paper
		$fields = array(
				'Color1' => 'COLOR1',
				'Color2' => 'COLOR2',
				'Occasion' => 'OCCASION',
				'Status' => 'STATUS',
				'Image' => 'IMAGE'
		);
		
		$sql = "UPDATE paper SET ";
		
		$i = 0;
		foreach ( $fields as $field => $dataindex ) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
					$sql .= ",";
				$i ++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}
		
		$sql .= " WHERE Id = " . ($id * 1) . ";";
		
		if ($i > 0)
			framework::query($sql);
			
			// Update the texts
		
		$fields = array(
				'Name' => 'NAME',
				'Description' => 'DESCRIPTION'
		);
		
		$sql = "UPDATE paper_texts SET ";
		
		$i = 0;
		foreach ( $fields as $field => $dataindex ) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
					$sql .= ",";
				$i ++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}
		
		$sql .= " WHERE id = " . ($id * 1) . ";";
		
		if ($i > 0)
			framework::query($sql);
	}
	
	/**
	 * Remove a paper bag
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 */
	static public function delBag($id){
		framework::query("DELETE FROM bag WHERE Id = " . ($id * 1) . ";");
	}
	
	/**
	 * Rreturn a filtered list of ornaments
	 *
	 *
	 *
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
	 * @return array
	 */
	static public function getOrnamentsBy($field = null, $value = null, $maxcount = null, $offset = null, $lang = null, $nolang = null, $over_where = null){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the value
		
		if (is_string($value))
			$value = mysql_real_escape_string($value);
		
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
		
		// Preparing the SQL query
		
		$sql = "";
		if (! is_null($over_where)) {
			$sql .= "SELECT query.* FROM (";
		}
		
		$sql .= "
        SELECT
            ornament.Id as ID,
            ornament.Occasion as OCCASION,
            ornament.Image as IMAGE,
            ornament.Stock as STOCK,
            ornament.Status as STATUS,

            (SELECT ornament_texts.Name as NAME
            FROM   ornament_texts
            WHERE  ornament_texts.Id = ornament.Id
            AND (ornament_texts.Language = '{$lang}' OR ornament_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
            AND ornament_texts.Name is not null
            AND ornament_texts.Name <> ''
            ORDER BY (ornament_texts.Language = '$nolang') + 0 DESC
            LIMIT 1) as NAME,

            (SELECT ornament_texts.Description as DESCRIPTION
            FROM   ornament_texts
            WHERE  ornament_texts.Id = ornament.Id
            AND (ornament_texts.Language = '{$lang}' OR ornament_texts.Language = '{$nolang}' OR '{$lang}' = '' OR '{$lang}' = 'all')
            AND ornament_texts.Description is not null
            AND ornament_texts.Description <> ''
            ORDER BY (ornament_texts.Language = '$nolang') + 0 DESC
            LIMIT 1) as DESCRIPTION,

            (SELECT occasion_texts.Name as OCCASIONNAME
            FROM occasion_texts
            WHERE occasion_texts.Id = ornament.Occasion
            AND (occasion_texts.Language = '$lang' OR '$lang' = '' OR '$lang' = 'all')
            LIMIT 1)
            AS OCCASIONNAME

        FROM ornament
        WHERE
        (NOT EXISTS (SELECT Id
                      FROM ornament_texts
                      WHERE ornament_texts.Id = ornament.Id AND ornament_texts.Language = '$nolang'
                      AND  (Name <> '' AND Name IS NOT NULL)
                          +(Description <> '' AND Description IS NOT NULL) = 2)
          OR '$nolang' = '')
         AND ({$where}) ";
		
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
		
		// Execute the SQL
		$r = framework::query($sql);
		
		// Return the results
		if ($maxcount == 1)
			if (isset($r[0])) {
				if (isset($r[0]['ID']))
					if ($r[0]['ID'] == $value)
						return $r[0];
			} else
				return null;
		
		return $r;
	}
	
	/**
	 * Return a list of ornaments/decorations
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer maxcount
	 *       
	 * @return array
	 */
	static function getOrnaments($maxcount = null, $offset = null, $lang = null){
		return self::getOrnamentsBy(null, null, $maxcount, $offset, $lang);
	}
	
	/**
	 * Return a ornament
	 *
	 * To insert a Ornament into the shopping car on the server side
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @example $ornament = Packing::getOrnamentById(3);
	 *         
	 * @param integer $id
	 *
	 * @return array
	 */
	static function getOrnamentById($id){
		return self::getOrnamentsBy("ornament.Id", $id * 1, 1, 0);
	}
	
	/**
	 * Add a new ornament
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param string $Name
	 * @param string $Description
	 * @param string $Occasion
	 * @param string $Image
	 * @param integer $Stock
	 * @param string $Status
	 */
	static function addOrnament($Name, $Description, $Occasion, $Image, $Stock, $Status, $lang = 'en'){
		
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
		
		// Insert the ornament
		framework::query("
        INSERT INTO ornament
               (Occasion, Image, Stock, Status)
        VALUES ('$Occasion', '$Image', '$Stock', '$Status');");
		
		// Insert the texts
		framework::query("
        INSERT INTO ornament_texts
                (Id, Language, Name, Description)
        VALUES (LAST_INSERT_ID(), '$lang', '$Name', '$Description');");
	}
	
	/**
	 * Update an ornament
	 *
	 *
	 *
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id The ornament ID
	 * @param array $data Associative array with ornament data
	 * @param string $lang Language
	 */
	static function setOrnament($id, $data, $lang = 'en'){
		
		// Connect to database (mysql_real_escape_string need this connection)
		framework::connect();
		
		// Escape the values
		foreach ( $data as $key => $value ) {
			if (is_string($data[$key])) {
				$data[$key] = mysql_real_escape_string($value);
				$data[$key] = utf8_encode($data[$key]);
			}
		}
		
		// Update the ornament
		$fields = array(
				'Occasion' => 'OCCASION',
				'Status' => 'STATUS',
				'Image' => 'IMAGE',
				'Stock' => 'STOCK',
				'Status' => 'STATUS'
		);
		
		$sql = "UPDATE ornament SET ";
		$i = 0;
		foreach ( $fields as $field => $dataindex ) {
			if (isset($data[$dataindex])) {
				if ($i > 0)
					$sql .= ",";
				$i ++;
				$sql .= $field . " = '{$data[$dataindex]}'";
			}
		}
		
		$sql .= " WHERE id = $id;";
		
		if ($i > 0)
			framework::query($sql);
		
		self::setOrnamentTexts($id, $lang, $data);
	}
	
	/**
	 * Remove an ornament
	 *
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *         
	 * @param integer $id
	 */
	static function delOrnament($id){
		framework::query("DELETE FROM ornament WHERE Id = " . ($id * 1) . ";");
	}
}