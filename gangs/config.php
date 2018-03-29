<?php


if (!defined('GANG_MODULE')) {
	// Don't die() because we can toss control back to the including file. :O
	// But if this file is accessed directly, this counts as a die().
	return; 
}

//select gangID as gang_id, gangNAME as name, gangDESC as description,
//gangPREF as prefix, gangSUFF as suffix, gangMONEY as money, gangCRYSTALS as crystals,
//gangRESPECT as respect, gangPRESIDENT as president, gangVICEPRES as vice_president,
//gangCAPACITY as capacity, gangCRIME as crime, gangCHOURS as crime_hours, gangAMENT as announcement

class GangVars {
	
	/**
	 * Singular uppercase name for gangs
	 * s = singular
	 * p = plural
	 * u = uppercase
	 * l = lowercase
	 *
	 * @var string
	 */
	var $name_su = 'Gang';
	
	/**
	 * Plural uppercase name for gangs
	 *
	 * @var string
	 */
	var $name_pu = 'Gangs';
	
	/**
	 * Singular lowercase name for gangs
	 *
	 * @var string
	 */
	var $name_sl = 'gang';
	
	/**
	 * Plural lowercase name for gangs
	 *
	 * @var string
	 */
	var $name_pl = 'gangs';
	
	/**
	 * Singular uppercase name for gang wars
	 * s = singular
	 * p = plural
	 * u = uppercase
	 * l = lowercase
	 *
	 * @var string
	 */
	var $war_su = 'War';
	
	/**
	 * Plural uppercase name for gang wars
	 *
	 * @var string
	 */
	var $war_pu = 'Wars';
	
	/**
	 * Singular lowercase name for gang wars
	 *
	 * @var string
	 */
	var $war_sl = 'war';
	
	/**
	 * Plural lowercase name for gang wars
	 *
	 * @var string
	 */
	var $war_pl = 'wars';
	
	/**
	 * How much money does it cost to start a new gang?
	 *
	 * @var int
	 */
	var $new_gang_price = 5000;
	
	/**
	 * The cost for each increase in gang capacity.
	 *
	 * @var int
	 */
	var $upgrade_price = 5000;
	
	/**
	 * Which users table field is the "money" charged
	 * for creating a gang taken from?
	 * 
	 * The default is to take from the user's money.
	 *
	 * @var string
	 */
	var $new_gang_db_field = 'money';
	
	var $new_gang_money_prefix = '$';
	
	/**
	 * By default, all gang names can contain letters
	 * and numbers. If you want any other characters
	 * to be allowed, add them to the string below.
	 * 
	 * This field defaults to space, underscore and exclamation mark.
	 *
	 * @var string
	 */
	var $gang_name_allowable_special_characters = ' _!';
	
	/**
	 * The gang prefix (tag) can only be letters and numbers.
	 * This field determines what the max number of characters
	 * the tag can be.
	 *
	 * @var string
	 */
	var $gang_prefix_max_length = 3;
	
	var $pres = 'President';
	
	var $vice_pres = 'Vice President';
	
	/**
	 * The maximum number of applications a person can have pending.
	 *
	 * @var integer
	 */
	var $max_apps = 3;
	
	/**
	 * Color used for table header backgrounds
	 *
	 * @var string
	 */
	var $color_bg = '#727843';
	
	/**
	 * Color used for the tabs border and pagination link borders
	 *
	 * @var string
	 */
	var $color_border = '#d2ae04';
	
	var $money_name = 'Money';
	
	var $crystals_name = 'Crystals';
	
	/**
	 * An array of all tabs that will be shown to users.
	 * The format is:
	 * action => label
	 * 
	 * A corresponding action must be listed in the $this->actions array.
	 *
	 * @var array
	 */
	var $tabs = array();
	
	/**
	 * An array of all functions that can be loaded.
	 * The format is:
	 * action => function_name
	 *
	 * @var array
	 */
	var $actions = array();
	
	/**
	 * An array of links for the "my gang" page.
	 * The format is:
	 * link => array('label' => label, 'order' => number)
	 *
	 * @var array
	 */
	var $links_mygang = array();
	
	/**
	 * An array of links for the "gang staff" page.
	 * The format is:
	 * link => array('label' => label, 'order' => number)
	 *
	 * @var array
	 */
	var $links_staff = array();
	
	/**
	 * The userid of the player accessing the page.
	 *
	 * @var int
	 */
	var $userid;
	
	/**
	 * The array of user data for the player accessing the page.
	 *
	 * @var array
	 */
	var $ir;
	
	/**
	 * The mysql connection identifier.
	 *
	 * @var resource
	 */
	var $c;
	
	/**
	 * The mysql connection object. (mccode version 2 only)
	 *
	 * @var unknown_type
	 */
	var $db;
	
	/**
	 * An enumerated list of types of pages (public | private)
	 * The private page is otherwise known as "my gang page"
	 * And the public page contains all publicly accessible gang information
	 * like the list of gangs, applying to gangs, etc.
	 *
	 * @var stdClass
	 */
	var $page_values;
	
	/**
	 * This stores a valud from the enumerated $this->page_values field
	 * and determines if you are viewing the public or private gang pages.
	 *
	 * @var int
	 */
	var $page = 0;
	
	/**
	 * This is the gang data for the player accessing the page.
	 *
	 * @var array
	 */
	var $data;
	
	function GangVars() {
		global $userid, $ir, $c, $db, $gangdata;
		$has_userid = false;
		$has_db_con = false;
		if (intval($userid) > 0) {
			$this->userid = intval($userid);
			$has_userid = true;
		}
		
		if (is_array($ir)) {
			$this->ir = $ir;
		}
		
		if (is_resource($c)) {
			$this->c = $c;
			$has_db_con = true;
		}
		
		if (is_object($db)) {
			$this->db = $db;
		}
		
		$this->data = $gangdata;
		
		$this->page_values = new stdClass();
		$this->page_values->public = 0;
		$this->page_values->private = 1;
	}
	
	function setPage($value) {
		if (isset($this->page_values->$value)) {
			$this->page = $this->page_values->$value;
		}
		return $this;
	}
	
	function get_gang_name_allowable_special_characters() {
		return str_split($this->gang_name_allowable_special_characters);
	}
	
	function check_gang_name_allowable_special_characters($name) {
		return ctype_alnum(str_replace($this->get_gang_name_allowable_special_characters(), '', $name));
	}
	
	function escape($string) {
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		$string = mysql_real_escape_string(trim($string));
		return $string;
	}
	
	function clean($string) {
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		$string = mysql_real_escape_string(htmlentities(trim($string)));
		return $string;
	}
	
	function clean_br($string) {
		if (get_magic_quotes_gpc()) {
			$string = stripslashes($string);
		}
		$string = mysql_real_escape_string(nl2br(htmlentities(trim($string))));
		return $string;
	}
	
}

/**
 * Take money from a user atomically and securely.
 *
 * @param int $userid
 * @param int $amount
 * @param string $field
 * @return bool
 */
function gang_take_money($userid, $amount, $field = 'money') {
	$q_get = sprintf('select `%s` from users where userid = %d', $field, $userid);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		return false;
	}
	list($money) = mysql_fetch_row($q_get);
	if ($money < $amount) {
		return false;
	}
	$q_take = sprintf('update users set `%1$s` = `%1$s` - "%2$.0f"
		where userid = %3$d and `%1$s` = "%4$.0f"', $field, $amount, $userid, $money);
	mysql_query($q_take);
	return mysql_affected_rows() > 0;
	
}

/**
 * Give a user money atomically and securely.
 *
 * @param int $userid
 * @param int $amount
 * @param string $field
 * @return bool
 */
function gang_give_money($userid, $amount, $field = 'money') {
	$q_get = sprintf('select `%s` from users where userid = %d', $field, $userid);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		return false;
	}
	list($money) = mysql_fetch_row($q_get);
	$q_take = sprintf('update users set `%1$s` = `%1$s` + "%2$.0f"
		where userid = %3$d and `%1$s` = "%4$.0f"', $field, $amount, $userid, $money);
	mysql_query($q_take);
	return mysql_affected_rows() > 0;
	
}

/**
 * Make multiple attempts to take money from a user (in cases where there is
 * a high likely hood of failure -- rare...)
 *
 * @param int $userid
 * @param int $amount
 * @param string $field
 * @param int $num_attempts
 * @return bool
 */
function gang_take_money_loop($userid, $amount, $field = 'money', $num_attempts = 5) {
	for ($x = 1; $x <= $num_attempts; $x++) {
		$result = gang_take_money($userid, $amount, $field);
		if ($result) {
			break;
		}
	}
	return $result;
}

/**
 * Make multiple attempts to give money to a user (in cases where there is
 * a high likely hood of failure -- rare...)
 *
 * @param int $userid
 * @param int $amount
 * @param string $field
 * @param int $num_attempts
 * @return bool
 */
function gang_give_money_loop($userid, $amount, $field = 'money', $num_attempts = 5) {
	for ($x = 1; $x <= $num_attempts; $x++) {
		$result = gang_give_money($userid, $amount, $field);
		if ($result) {
			break;
		}
	}
	return $result;
}

/**
 * Take money from the gang atomically and securely.
 *
 * @param int $gang_id
 * @param int $amount
 * @param string $field
 * @return bool
 */
function gang_take_gang_money($gang_id, $amount, $field = 'gangMONEY') {
	$q_get = sprintf('select `%s` from gangs where gangID = %d', $field, $gang_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		return false;
	}
	list($money) = mysql_fetch_row($q_get);
	if ($money < $amount) {
		return false;
	}
	$q_take = sprintf('update gangs set `%1$s` = `%1$s` - "%2$.0f"
		where gangID = %3$d and `%1$s` = "%4$.0f"', $field, $amount, $gang_id, $money);
	mysql_query($q_take);
	return mysql_affected_rows() > 0;
}

/**
 * Give money to the gang atomically and securely.
 *
 * @param int $gang_id
 * @param int $amount
 * @param string $field
 * @return bool
 */
function gang_give_gang_money($gang_id, $amount, $field = 'gangMONEY') {
	$q_get = sprintf('select `%s` from gangs where gangID = %d', $field, $gang_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		return false;
	}
	list($money) = mysql_fetch_row($q_get);
	$q_take = sprintf('update gangs set `%1$s` = `%1$s` + "%2$.0f"
		where gangID = %3$d and `%1$s` = "%4$.0f"', $field, $amount, $gang_id, $money);
	mysql_query($q_take);
	return mysql_affected_rows() > 0;
	
}

function gang_get_profile_link($userid, $name, $show_id = false) {
	if(!$userid) {
		return 'N/A';
	}
	if ($show_id) {
		return sprintf('<a href="viewuser.php?u=%d">%s</a> [%d]', $userid, $name, $userid);
	} else {
		return sprintf('<a href="viewuser.php?u=%d">%s</a>', $userid, $name);
	}
	
}

function gang_get_gang_link($gang_id, $name) {
	return sprintf('<a href="gangs.php?action=gang_view&gang_id=%d">%s</a>', $gang_id, $name);
}

function _gang_delete($gang_id) {
	$gang_id = intval($gang_id);
	mysql_query(sprintf('delete from applications where appGANG = %d', $gang_id));
	mysql_query(sprintf('delete from gangevents where gevGANG = %d', $gang_id));
	mysql_query(sprintf('delete from gangforums_replies where gfr_gangid = %d', $gang_id));
	mysql_query(sprintf('delete from gangforums_topics where gft_gangid = %d', $gang_id));
	mysql_query(sprintf('delete from gangwars where %d in (warDECLARER, warDECLARED)', $gang_id));
	mysql_query(sprintf('delete from surrenders where %d in (surWHO, surTO)', $gang_id));
	mysql_query(sprintf('delete from gangs where gangID = %d', $gang_id));
	return mysql_affected_rows() > 0;
}

function _gang_auto_clear_user($userid, $gang_id, $show_output = true) {
	$q_check = sprintf('select gangID from gangs where gangID = %d', intval($gang_id));
	$q_check = mysql_query($q_check);
	if (!$q_check or mysql_num_rows($q_check) < 1) {
		mysql_query(sprintf('update users set gang = 0 where userid = %d and gang = %d', intval($userid), intval($gang_id)));
		if ($show_output) {
			echo "<h3>You have been removed from your gang.</h3>";
		}
	}
}

function gang_go_back($url, $timeout = 3000) {
	$seconds = round($timeout / 1000, 2);
	$seconds = $seconds == 1 ? '1 second' : $seconds . ' seconds';
	echo <<<EOT
<script>
setTimeout('window.location.assign("$url");', $timeout);
</script>
<p style="text-align: center; margin: none; padding: none"><a href="$url">Click here if your browser does not redirect you in $seconds.</a></p>
EOT;
}

function gang_new_event($gang_id, $text, $clean_or_escape = 'clean') {
	global $gvars;
	// gevID, gevGANG, gevTIME, gevTEXT <<< gangevents
	if ($clean_or_escape === 'clean') {
		$text = $gvars->clean($text);
	} else {
		$text = $gvars->escape($text);
	}
	$q_set = sprintf('insert into gangevents (gevGANG, gevTIME, gevTEXT)
		values (%d, unix_timestamp(), "%s")', intval($gang_id), $text);
	mysql_query($q_set);
	return mysql_affected_rows();
}

function gang_time_format($stamp) {
	return date('M d, H:i:s', $stamp);
}

function gang_money_format($amount) {
	return '$' . number_format($amount);
}


