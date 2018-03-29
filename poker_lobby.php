<? 
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
require('poker_includes/inc_lobby.php');
poker_menu_start(LOBBY);
?>

        </tr>
      </table>
      
    </td>
  </tr>
   <tr> 
    <td width="650" valign="top"> 
     <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr class="fieldsetheadlink"> 
          <td width="120"><b><? echo TABLE_HEADING_NAME; ?></b></td>
          <td align="center" width="50"><b><? echo TABLE_HEADING_PLAYERS; ?></b></td>
          <td align="center" width="80"><b><? echo TABLE_HEADING_TYPE; ?></b></td>
          <td align="center" width="90"><b><? echo TABLE_HEADING_BUYIN; ?></b></td>
          <td align="center" width="90"><b><? echo TABLE_HEADING_SMALL_BLINDS; ?></b></td>
          <td align="center" width="90"><b><? echo TABLE_HEADING_BIG_BLINDS; ?></b></td>
          <td align="center" width="80"><b><? echo TABLE_HEADING_STATUS; ?></b></td>
        </tr>
        
      </table>
      <div id="gamelist" style="border : solid 0px   padding : 1px; width : 100%; height : 365px; overflow : auto; ">
 </div ><br><?
$tableq = mysql_query("select p1name, p2name,p3name,p4name,p5name,p6name,p7name,p8name,p9name,p10name,tablename,tablelimit,tabletype,hand,tablelow from ".DB_POKER." order by tablelimit asc ");
while($tabler = mysql_fetch_array($tableq)){ 
$i = 1;
$x=0;
while($i < 11){
if($tabler['p'.$i.'name'] != '') $x++;
$i++;
}
$tableplayers = $x.'/10';
$tablestatus = (($tabler['hand'] == '')? 'New Game' : 'Playing');
$tabletype = (($tabler['tabletype'] == 't')? 'Tournament' : 'Sit \'n Go');
} 
?>
    </td>
  </tr>
<script>
$(document).ready(function(){
games();
});
</script>
<?

poker_menu_end();
$h->endpage();
?>
