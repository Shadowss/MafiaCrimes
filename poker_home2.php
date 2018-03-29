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
poker_menu_start(HOME);
?>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td class="fieldsetheadcontent">Your welcome page content goes here...</td>
        </tr>
      </table>
    </td>
  </tr>

<?

poker_menu_end();
$h->endpage();
?>
