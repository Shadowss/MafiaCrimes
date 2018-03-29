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
poker_menu_start(FAQ);
?>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="4">
        <tr> 
          <td class="smllfontwhite" colspan="2"><b><font color="#FFCC33">How do 
            I change my avatar?</font></b></td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2">In the main lobby screen click 
            the edit character link to change your avatar or upload a custom avatar. 
            Custom avatars must be in jpg image format and less than 250kb in 
            size.</td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2"><b><font color="#FFCC33">What 
            is the Move Timer?</font></b></td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2">The move timer ensures that smooth 
            table play continues by auto folding or dealing hands if a player 
            does not take their turn within the time limit set by the site administrator. 
            If a player repeatedly fails to take their turn they will be kicked 
            off the table and any money left in their pot will be added back on 
            to their total bankroll.</td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2"><b><font color="#FFCC33">Why did 
            I get kicked from a game?</font></b></td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2">Players are automatically kicked 
            if they repeadedly fail to take their turn and the game has to auto 
            move them or if they lose connection from the table for more than 
            the allowed time. The lengths of time are variable as they are set 
            by the site administrator.</td>
        </tr>
        <tr>
          <td class="smllfontwhite" colspan="2"><b><font color="#FFCC33">My player 
            is broke, what now?</font></b></td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2">If the site administrator has 
            enabled the option, you can renew your initial game credits by clicking 
            the renew button on your &quot;My Player&quot; page.</td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2"><b><font color="#FFCC33">How can 
            I get my own copy of PHP Poker?</font></b></td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2"> 
            <p>PHP Poker can be purchased in two ways. You can hire your own poker 
              table for a small annual fee or purchase the full package to install 
              on your own website. For information about PHP Poker, please visit 
              our website.<br>
              <a href="http://www.phppoker.net" target="_blank" class="smllfontwhite">http://www.phppoker.net</a></p>
          </td>
        </tr>
        <tr> 
          <td class="smllfontwhite" colspan="2">&nbsp;</td>
        </tr>
      </table>
      </td>
  </tr>
<?
poker_menu_end();
$h->endpage();
?>
