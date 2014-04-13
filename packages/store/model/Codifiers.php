<?php

/**
 * Codifiers
 *
 * @author rafa <rafa@pragres.com>
 * @version 1.0
 */
class Codifiers {

	/**
	 * Return the list of occasions
	 *
	 * @static
	 * @access public
	 * @author rafa <rafa@pragres.com>
	 * @version 1.0
	 *
	 * @return array
	 */
	static public function getOccasions($lang = 'en') {
		return framework::query("
        SELECT
            occasion.Id as ID,
            occasion_texts.Name as NAME,
            occasion_texts.Description as DESCRIPTION
        FROM occasion
        INNER JOIN occasion_texts
        ON occasion.Id = occasion_texts.Id AND occasion_texts.Language = '$lang';");
	}

	/**
	 * Return the list of states
	 *
	 * @static
	 * @access public
	 * @author Salvi <salvi.pascual@pragres.com>
	 * @review Rafa <rafa@pragres.com>
	 * @version 1.2
	 *
	 * @return array or arrays
	 */
	static public function getStates($country = 'USA') {
		
		$r = framework::query("
				SELECT
					Code as code,
					Name as name
				FROM state
				WHERE country = '$country'");
		
		return $r;
	}
}
