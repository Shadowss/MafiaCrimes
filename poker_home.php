<?php    
$special_page = '<link rel="stylesheet" href="css/poker.css" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="js/lobby.php"></script>
<style type="text/css">
<!--
.style1 {
	font-size: large;
	font-weight: bold;
}
.style5 {font-size: 11px}
-->
</style>
';
$menuhide=1;
$userStatsHide=1;

include "globals.php";
if($ir['jail'] or $ir['hospital']) { print "This page cannot be accessed while in jail or hospital.";

$h->endpage(); 
exit; 
}




require('poker_includes/gen_inc.php'); 
require('poker_includes/inc_index.php');

?>
<center>
<table width="654" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#1B1B1B">
  <tr> 
    <td width="650" class="fieldsethead" valign="top" height="100%">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr>
          <td bgcolor="#333333"><b><font size="3"><i>
            <? echo HOME; ?>
            </i> </font></b></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td class="fieldsetheadcontent"><p>Welcome to Mafia Crimes poker.</p>
          <p> Setup by request, put online due to demand. N2KMaster brings you another classic site. We have multiple tables available including Sit and Go and Tourney Style.</p>
          <p>Drop by have a game, bring your friends and most importantly HAVE FUN!  </p></td>
        </tr>
      </table>    </td>
  </tr>
</table>
<span class="smllfontpink"><strong>Game Menu</strong></span>
<table width="180" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#1B1B1B">
  <tr>
    <td width="355" valign="top" bgcolor="#333333"><table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td>
        </td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="1" width="98%" class="smllfontpink" align="center" height="55">
          <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_home.php')" class="hand">
            <td><center><? echo MENU_HOME; ?></center> </td>
          </tr>
          <? if ($valid == true){ ?>
          <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_lobby.php')" class="hand">
            <td><center><? echo MENU_LOBBY; ?> </center></td>
          </tr>
          <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_rankings.php')" class="hand">
            <td><center><? echo MENU_RANKINGS; ?></center> </td>
          </tr>
          <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_myplayer.php')" class="hand">
            <td><center><? echo MENU_MYPLAYER; ?></center> </td>
          </tr>
          <? } ?>
          <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_rules.php')" class="hand">
            <td><center><? echo MENU_RULES; ?></center> </td>
          </tr>
          <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_faq.php')" class="hand">
            <td><center><? echo MENU_FAQ; ?></center> </td>
          </tr>
          <? if ($ADMIN == true){ ?>
          <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_admin.php')" class="hand">
            <td><Center><? echo MENU_ADMIN; ?> </Center></td>
          </tr>
          <? } ?>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
  <span class="smllfontpink style1"><span class="style5">Current Leader Board</span></span>
<table width="180" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="#1B1B1B">
  <tr>
    <td width="355" valign="top" bgcolor="#333333"><table width="100%" border="0" cellspacing="0" cellpadding="1">
      <tr>
        <td>
        </td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="1" width="98%" class="smllfontpink" align="center" height="55">
          <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('poker_home.php')" class="hand">
            <td><center><? require('poker_includes/scores.php'); ?>
            </center> </td>
          </tr>
 
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</center>
<?

$h->endpage();
?>

