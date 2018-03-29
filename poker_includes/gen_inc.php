<? 
require_once('configure.php');
require_once( str_replace('//','/',dirname(__FILE__).'/') .'../config.php');
$host = $_CONFIG['hostname'];
$ln = $_CONFIG['username'];
$pw = $_CONFIG['password'];
$db = $_CONFIG['database'];
mysql_connect("$host", "$ln", "$pw") or die("Unable to connect to database");
mysql_select_db("$db") or die("Unable to select database");
require('tables.php');
require('settings.php');
session_start();
$plyrname = addslashes($_SESSION['playername']);
$SGUID = addslashes($_SESSION['SGUID']);
$valid = false;
$ADMIN = false;
$gID = '';
//print_r ($_SESSION);


if (($plyrname != '') && ($SGUID != '')) {
    $idq = mysql_query("select GUID, banned, gID, vID from " . DB_PLAYERS . " where username = '" . $plyrname . "' and GUID = '" . $SGUID . "' ");
    $idr = mysql_fetch_array($idq);
    $gID = $idr['gID'];
    $gameID = $idr['vID'];
    if ((mysql_num_rows($idq) == 1) && ($idr['banned'] != 1)) $valid = true;
    $siteadmin = ADMIN_USERS;
    if ($plyrname != '') {
        $time = time();
        $admins = array();
        $adminraw = explode(',', $siteadmin);
        $i = 0;
        while ($adminraw[$i] != '') {
            $admins[$i] = $adminraw[$i];
            $i++;
        } 
        if (in_array($plyrname, $admins)) $ADMIN = true;
    } 
} 
require('poker_inc.php');
require('poker_language.php');
if (($_SESSION[SESSNAME] != '') && (MEMMOD == 1) && ($plyrname == '')) {
    $time = time();
    $sessname = addslashes($_SESSION[SESSNAME]);

    $usrq = mysql_query("select username from " . DB_PLAYERS . " where sessname = '" . $sessname . "' ");
    if (mysql_num_rows($usrq) == 1) {
        $usrr = mysql_fetch_array($usrq);
        $usr = $usrr['username'];
        $GUID = randomcode(32);
        $_SESSION['playername'] = $usr;
        $_SESSION['SGUID'] = $GUID;
        $ip = $_SERVER['REMOTE_ADDR'];
        $result = mysql_query("update " . DB_PLAYERS . " set ipaddress = '" . $ip . "', lastlogin = '" . $time . "' , GUID = '" . $GUID . "' where username = '" . $usr . "' ");
        $valid = true;
    } 
} 
$time = time();
$tq = mysql_query("select waitimer from " . DB_PLAYERS . " where username = '" . $plyrname . "' ");
$tr = mysql_fetch_array($tq);
$waitimer = $tr['waitimer'];
if ($waitimer > $time) header('Location sitout.php');

function poker_menu_start($title=""){
	global $valid, $ADMIN;
	if(!$valid){
		header("Location:login.php");
		die();
	}	
?>
<center>
<table width="772" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#1B1B1B">
  <tr> 
    <td rowspan="2" valign="top" bgcolor="#333333"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr> 
          <td> 
            <? require('poker_includes/scores.php'); ?>
          </td>
        </tr>
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="1" width="98%" class="smllfontpink" align="center" height="55">
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_home.php')" class="hand"> 
                <td> 
                  <? echo MENU_HOME; ?>
                </td>
              </tr>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_lobby.php')" class="hand"> 
                <td> 
                  <? echo MENU_LOBBY; ?>
                </td>
              </tr>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_rankings.php')" class="hand"> 
                <td> 
                  <? echo MENU_RANKINGS; ?>
                </td>
              </tr>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_myplayer.php')" class="hand"> 
                <td> 
                  <? echo MENU_MYPLAYER; ?>
                </td>
              </tr>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_rules.php')" class="hand"> 
                <td> 
                  <? echo MENU_RULES; ?>
                </td>
              </tr>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_faq.php')" class="hand"> 
                <td> 
                  <? echo MENU_FAQ; ?>
                </td>
              </tr>
              <? if ($ADMIN == true){ ?>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_admin.php')" class="hand"> 
                <td> 
                  <? echo MENU_ADMIN; ?>
                </td>
              </tr>
              <? } ?>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td width="650" class="fieldsethead">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td bgcolor="#333333"><b><font size="3"><i><? echo $title; ?></i></font></b></td>
<?

}

function poker_menu_end(){
?>
</table>
</center>
<?

}


?>