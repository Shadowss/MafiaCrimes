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
require('poker_includes/inc_myplayer.php');
poker_menu_start(MY_PLAYER);

?>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td class="fieldsetheadcontent">
            <? if($bad_msgs != ''){ ?>
            <table width="492" border="0" cellspacing="0" cellpadding="4" bgcolor="#330000" align="center">
              <tr> 
                <td align="center" class="smllfont" width="492"> <b> 
                  <? echo $bad_msgs; ?>
                  </b></td>
              </tr>
            </table>
            <br>
            <? } ?>
            <? if($message != ''){ ?>
            <table width="492" border="0" cellspacing="0" cellpadding="4" bgcolor="#330000" align="center">
              <tr> 
                <td align="center" class="smllfont" width="492"> <b> 
                  <? echo $message; ?>
                  </b></td>
              </tr>
            </table>
            <br>
            <? } ?>
            <table width="100%" cellspacing="0" cellpadding="2">
              <tr> 
                <td> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="smllfontwhite" bgcolor="#333333">
                    <tr> 
                      <td width="19%" nowrap class="fieldsetheadcontent"><b><font color="#FFCC33"> 
                        <? echo PLAYER_PROFILE; ?>
                        </font></b></td>
                      <td width="18%" nowrap>&nbsp;</td>
                      <td width="22%" nowrap>&nbsp;</td>
                      <td width="19%" nowrap>&nbsp;</td>
                      <td width="22%" nowrap>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td rowspan="5" align="center" width="19%"> 
                        <?echo display_ava_profile($plyrname); ?>
                      </td>
                      <td width="18%" align="right" nowrap>&nbsp;</td>
                      <td width="22%" align="left" nowrap>&nbsp;</td>
                      <td width="19%" align="right" nowrap>&nbsp;</td>
                      <td width="22%" align="left" nowrap>&nbsp;</td>
                    </tr>
                    <tr> 
                      <td width="18%" align="right" nowrap>
                        <? echo STATS_PLAYER_NAME; ?>
                      </td>
                      <td width="22%" align="left" nowrap> <b> 
                        <? echo $plyrname; ?>
                        </b></td>
                      <td width="19%" align="right" nowrap>
                        <? echo STATS_PLAYER_RANKING; ?>
                      </td>
                      <td width="22%" align="left" nowrap><b> 
                        <? echo $rank; ?>
                        </b></td>
                    </tr>
                    <tr> 
                      <td width="18%" align="right" nowrap>
                        <? echo STATS_PLAYER_CREATED; ?>
                      </td>
                      <td width="22%" align="left" nowrap><b> 
                        <? echo $created; ?>
                        </b></td>
                      <td width="19%" align="right" nowrap>
                        <? echo STATS_PLAYER_BANKROLL; ?>
                      </td>
                      <td width="22%" align="left" nowrap><b> 
                        <? echo money($winnings); ?>
                        </b></td>
                    </tr>
                    <tr> 
                      <td width="18%" align="right" nowrap>
                        <? echo STATS_PLAYER_LOGIN; ?>
                      </td>
                      <td width="22%" align="left" nowrap><b> 
                        <? echo $lastlogin; ?>
                        </b></td>
                      <td width="19%" align="right" nowrap>
                        <? echo STATS_PLAYER_GAMES_PLAYED; ?>
                      </td>
                      <td width="22%" align="left" nowrap><b> 
                        <? echo $gamesplayed; ?>
                        </b></td>
                    </tr>
                    <tr> 
                      <td width="18%" align="right" nowrap>&nbsp;</td>
                      <td width="22%" align="left" nowrap>&nbsp;</td>
                      <td width="19%" align="right" nowrap>&nbsp;</td>
                      <td width="22%" align="left" nowrap>&nbsp;</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <? if((RENEW == 1) && ($winnings == 0) && (($gID == '') || ($gID == 0)) && ($action != 'credit')){ ?>
            <table width="100%" cellspacing="0" cellpadding="2">
              <tr> 
                <td> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="smllfontwhite" bgcolor="#333333">
                    <tr> 
                      <td nowrap class="fieldsetheadcontent"><b><font color="#FFCC33"><? echo PLAYER_IS_BROKE; ?></font></b></td>
                    </tr>
                    <tr> 
                      <td align="center"> 
                        <form name="form2" method="post" action="">
                          <input type="hidden" name="action" value="renew">
                          <input type="submit" name="Submit" value="<? echo BUTTON_STATS_PLAYER_CREDIT; ?>" class="betbuttons">
                        </form>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <? } ?>
            <table width="100%" cellspacing="0" cellpadding="2" align="center">
              <tr> 
                <td> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="3" class="smllfontwhite" bgcolor="#333333">
                    <tr> 
                      <td nowrap class="fieldsetheadcontent" colspan="2"><b><font color="#FFCC33"><? echo PLAYER_STATS; ?></font></b></td>
                      <td nowrap colspan="2" width="49%">&nbsp;</td>
                    </tr>
                    <tr> 
                      <td colspan="2" nowrap>&nbsp;</td>
                      <td colspan="2" nowrap width="49%">&nbsp;</td>
                    </tr>
                    <tr valign="top"> 
                      <td colspan="2" nowrap><b><fieldset><legend>&nbsp;<span class="fieldsethead"><? echo STATS_GAME; ?> &nbsp;</span>&nbsp;</legend> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                          <tr> 
                            <td align="center"> 
                              <div id="preview" width="44" height="50"> 
                                <table border="0" cellspacing="0" cellpadding="3" class="smllfontwhite">
                                  <tr> 
                                    <td> 
                                      <font color="#999999"><? echo STATS_PLAYER_GAMES_PLAYED; ?>
                                      </font> </td>
                                    <td><b> <font color="#FFFFFF"> 
                                      <? echo $gamesplayed; ?>
                                      </font></b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_TOURNAMENTS_PLAYED; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> 
                                      <? echo $tournamentsplayed; ?>
                                      </font></b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_TOURNAMENTS_WON; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> 
                                      <? echo $tournamentswon; ?>
                                      </font></b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_TOURNAMENTS_RATIO; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> 
                                      <? echo $tperc; ?>
                                      </font></b></td>
                                  </tr>
                                </table>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </fieldset></b></td>
                      <td colspan="2" nowrap width="49%"><b><fieldset><legend>&nbsp;<span class="fieldsethead"><? echo STATS_HAND; ?> &nbsp;</span>&nbsp;</legend> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                          <tr> 
                            <td align="center"> 
                              <div id="preview" width="44" height="50"> 
                                <table border="0" cellspacing="0" cellpadding="3" class="smllfontwhite">
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_HANDS_PLAYED; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> 
                                      <? echo $handsplayed; ?>
                                      </font></b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_HANDS_WON; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> 
                                      <? echo $handswon; ?>
                                      </font></b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_HAND_RATIO; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> 
                                      <? echo $handsperc; ?>
                                      </font></b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">&nbsp; </font></td>
                                    <td><b></b></td>
                                  </tr>
                                </table>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </fieldset></b></td>
                    </tr>
                    <tr valign="top"> 
                      <td colspan="2" nowrap>&nbsp;</td>
                      <td colspan="2" nowrap width="49%">&nbsp;</td>
                    </tr>
                    <tr valign="top"> 
                      <td colspan="2" nowrap><b><fieldset><legend>&nbsp;<span class="fieldsethead"><? echo STATS_MOVE; ?>&nbsp;</span>&nbsp;</legend> 
                        <table width="100%" border="0" cellspacing="0" cellpadding="5">
                          <tr> 
                            <td align="center"> 
                              <div id="preview" width="44" height="50"> 
                                <table border="0" cellspacing="0" cellpadding="3" class="smllfontwhite">
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_FOLD_RATIO; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> </font> 
                                      <? echo $foldperc; ?>
                                      </b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_CHECK_RATIO; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> </font> 
                                      <? echo $checkperc; ?>
                                      </b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_CALL_RATIO; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> </font> 
                                      <? echo $callperc; ?>
                                      </b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_RAISE_RATIO; ?>
                                      </font></td>
                                    <td><b> 
                                      <? echo $raiseperc; ?>
                                      </b></td>
                                  </tr>
                                  <tr> 
                                    <td><font color="#999999">
                                      <? echo STATS_PLAYER_ALLIN_RATIO; ?>
                                      </font></td>
                                    <td><b> <font color="#FFFFFF"> </font> 
                                      <? echo $allinperc; ?>
                                      </b></td>
                                  </tr>
                                </table>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </fieldset></b></td>
                      <td colspan="2" nowrap width="49%"><b><fieldset><legend>&nbsp;<span class="fieldsethead"><? echo STATS_FOLD; ?> &nbsp;</span>&nbsp;</legend> 
                        <table border="0" cellspacing="0" cellpadding="5" width="100%">
                          <tr> 
                            <td align="center"> 
                              <div id="preview" width="44" height="50"> 
                                <table border="0" cellspacing="0" cellpadding="3" class="smllfontwhite">
                                  <tr> 
                                    <td width="54%" nowrap><font color="#999999">
                                      <? echo STATS_PLAYER_FOLD_PREFLOP; ?>
                                      </font></td>
                                    <td width="46%" nowrap><b> <font color="#FFFFFF"> 
                                      </font> 
                                      <? echo $foldpfperc; ?>
                                      </b></td>
                                  </tr>
                                  <tr> 
                                    <td width="54%" nowrap><font color="#999999">
                                      <? echo STATS_PLAYER_FOLD_FLOP; ?>
                                      </font></td>
                                    <td width="46%" nowrap><b> <font color="#FFFFFF"> 
                                      </font> 
                                      <? echo $foldfperc; ?>
                                      </b></td>
                                  </tr>
                                  <tr> 
                                    <td width="54%" nowrap><font color="#999999">
                                      <? echo STATS_PLAYER_FOLD_TURN; ?>
                                      </font></td>
                                    <td width="46%" nowrap><b> <font color="#FFFFFF"> 
                                      </font> 
                                      <? echo $foldtperc; ?>
                                      </b></td>
                                  </tr>
                                  <tr>
                                    <td width="54%" nowrap><font color="#999999">
                                      <? echo STATS_PLAYER_FOLD_RIVER; ?>
                                      </font></td>
                                    <td width="46%" nowrap><b> 
                                      <? echo $foldrperc; ?>
                                      </b></td>
                                  </tr>
                                  <tr> 
                                    <td width="54%"><font color="#999999"> &nbsp;</font></td>
                                    <td width="46%"><b> <font color="#FFFFFF"> 
                                      </font> </b></td>
                                  </tr>
                                </table>
                              </div>
                            </td>
                          </tr>
                        </table>
                        </fieldset></b></td>
                    </tr>
                    <tr> 
                      <td colspan="2" nowrap>&nbsp;</td>
                      <td colspan="2" nowrap width="49%">&nbsp;</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
<?

poker_menu_end();
$h->endpage();
?>
