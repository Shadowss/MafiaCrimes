<?php
// Ensure php 4 compatibility:
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

session_start();
require "global_func.php";
if($_SESSION['loggedin']==0) { header("Location: login.php");exit; }
$userid=$_SESSION['userid'];
require "header.php";
$h = new headers;
$h->startheaders();
include "mysql.php";
global $c;
$is=mysql_query("SELECT u.*,us.* FROM users u
	LEFT JOIN userstats us ON u.userid=us.userid
	WHERE u.userid=$userid",$c) or die(mysql_error());
$ir=mysql_fetch_array($is);
check_level();
$fm=money_formatter($ir['money']);
$lv=date('F j, Y, g:i a',$ir['laston']);
$h->userdata($ir,$lv,$fm);
$h->menuarea();
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