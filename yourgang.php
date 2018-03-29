<?php
include "globals.php"; 
if (!function_exists('array_diff_key')) {
	function array_diff_key() {
		$arrs = func_get_args();
		$result = array_shift($arrs);
		foreach ($arrs as $array) {
			foreach ($result as $key => $v) {
				if (array_key_exists($key, $array)) {
					unset($result[$key]);
				}
			}
		}
		return $result;
	}
}
if (!function_exists(array_fill_keys)) {
	function array_fill_keys($keys, $value) {
		return array_combine($keys,array_fill(0,count($keys),$value));
	}
}


######################
# END OF HEADER CODE #
######################

/* --------------------------------------\
	Make sure to retain this query:     */
$gq=mysql_query("SELECT g.* FROM gangs g WHERE g.gangID={$ir['gang']}");
$gangdata=mysql_fetch_array($gq);
/*	Make sure to retain the above query  \
----------------------------------------*/

//error_reporting(E_ALL);

define('GANG_MODULE', true, true);

// gangID, gangNAME, gangDESC, gangPREF, gangSUFF, gangMONEY, gangCRYSTALS, gangRESPECT, gangPRESIDENT, gangVICEPRES, gangCAPACITY, gangCRIME, gangCHOURS, gangAMENT

include('./gangs/config.php');
$gvars = new GangVars();
$gvars->setPage('private');
include('./gangs/content.php');
$h->endpage();