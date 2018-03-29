<? 
$special_page = '
<script language="JavaScript" type="text/JavaScript" src="js/poker.php"></script>
<link rel="stylesheet" href="css/poker.css" type="text/css">

<style type="text/css">
<!--
.smllwhtarial {  font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #FFFFFF}
-->
</style><script language="JavaScript"><!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//--></script>
<script>
$(document).ready(function(){
push_poker();
MM_preloadImages("images/newpoker_r16_c2_f2.jpg","images/newpoker_r16_c22_f2.jpg");
});
</script>

';
$menuhide=1;
$userStatsHide=1;

include "globals.php";
if($ir['jail'] or $ir['hospital']) { print "This page cannot be accessed while in jail or hospital.";

$h->endpage(); 
exit; 
}
require('poker_includes/gen_inc.php'); 
require('poker_includes/inc_poker.php'); 
?>
<center>
<table width="772" border="0" cellspacing="0" cellpadding="1" align="center" bgcolor="#333333">
  <tr> 
    <td> 
      <table border="0" cellpadding="0" cellspacing="0" width="770" align="center">
        <!-- fwtable fwsrc="newpoker.png" fwbase="poker.jpg" fwstyle="Dreamweaver" fwdocid = "742308039" fwnested="0" -->
        <tr> 
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="13" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="57" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="36" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="52" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="6" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="2" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="85" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="7" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="17" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="2" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="8" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="84" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="26" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="93" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="6" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="13" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="12" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="82" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="11" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="50" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="34" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="59" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="12" height="1" border="0"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="1" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="2" colspan="6" background="images/<? echo $officialstylepack ?>/poker_r1_c1.jpg" class="smllwhtarial">&nbsp; 
            <font color="#FF0000"> <b> 
            <? $lim = (($tablelimit < 10000)? 'No Limit' : money($tablelimit)); echo stripslashes($tablename); ?>
            </b></font></td>
          <td rowspan="3" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r1_c7.jpg" valign="top"> 
            <div id="pinfo2"></div>
            <div id="ptimer2" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td colspan="11" background="images/<? echo $officialstylepack ?>/poker_r1_c10.jpg"></td>
          <td rowspan="3" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r1_c21.jpg" valign="top"> 
            <div id="pinfo3"></div>
            <div id="ptimer3" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td rowspan="2" colspan="4" background="images/<? echo $officialstylepack ?>/poker_r1_c23.jpg" align="right" class="smllwhtarial"> 
            <font color="#FF0000"> 
            <? $ttype = (($tabletype != 't')? SITNGO : TOURNAMENT); $buyin = (($tabletype == 't')? money_small($tablelimit) : money_small($min).'/'.money_small($tablelimit)); echo '<b>'.$ttype.' - '.$buyin.'</b>'; ?>
            </font> &nbsp;</td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="7" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="6" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r2_c10.jpg"></td>
          <td rowspan="3" colspan="6" background="images/<? echo $officialstylepack ?>/poker_r2_c13.jpg" valign="top" class="smllfontwhite"> 
            <? $cq = mysql_query("select * from ".DB_LIVECHAT." where gameID = '".$gameID."' "); $cr = mysql_fetch_array($cq); $i = 1; while($i < 6){ $chat .= $cr['c'.$i]; $i++; } ?>
            <div id="chatbox" > 
              <div id="chatdiv" style="border : solid 0px   padding : 1px; width : 100%; height : 70px; overflow : auto;"> 
                <? echo stripslashes($chat); ?>
              </div>
            </div>
          </td>
          <td rowspan="6" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r2_c19.jpg"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="15" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="13" background="images/<? echo $officialstylepack ?>/poker_r3_c1.jpg"></td>
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r3_c2.jpg" valign="top"> 
            <div id="pinfo1"></div>
            <div id="ptimer1" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td rowspan="5" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r3_c4.jpg"></td>
          <td rowspan="5" background="images/<? echo $officialstylepack ?>/poker_r3_c23.jpg"></td>
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r3_c24.jpg" valign="top"> 
            <div id="pinfo4"></div>
            <div id="ptimer4" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td rowspan="13" background="images/<? echo $officialstylepack ?>/poker_r3_c26.jpg"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="34" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="3" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r4_c7.jpg" align="center" class="smllfontwhite"> 
            <div id="pava2"></div>
          </td>
          <td rowspan="3" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r4_c21.jpg" align="center" class="smllfontwhite"> 
            <div id="pava3"></div>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="22" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="3" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r5_c2.jpg" align="center" class="smllfontwhite"> 
            <div id="pava1"></div>
          </td>
          <td colspan="6" class="smllfontwhite" background="images/<? echo $officialstylepack ?>/poker_r5_c13.jpg"></td>
          <td rowspan="3" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r5_c24.jpg" align="center" class="smllfontwhite"> 
            <div id="pava4"></div>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="10" border="0"></td>
        </tr>
        <tr> 
          <td colspan="6" background="images/<? echo $officialstylepack ?>/poker_r6_c13.jpg" valign="top" class="smllfontwhite" align="center"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr align="center"> 
                <td colspan="2" class="smllwhtarial"><font color="#999999">
                  <? echo DEALER_INFO; ?>
                  </font></td>
              </tr>
              <tr> 
                <td colspan="2" class="dealertxt"> 
                  <div id="dealertxt"></div>
                </td>
              </tr>
              <tr> 
                <td width="34%" class="smllwhtarial"><b>
                  <? echo TABLEPOT; ?>
                  </b></td>
                <td width="66%"> 
                  <div id="tablepot"></div>
                </td>
              </tr>
            </table>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="57" border="0"></td>
        </tr>
        <tr> 
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r7_c7.jpg"></td>
          <td colspan="6" background="images/<? echo $officialstylepack ?>/poker_r7_c13.jpg" class="smllfontwhite" nowrap> 
            <form name="talk" method="post" action="">
              <input type="text" name="talk" id="talk" class="fieldsetheadinputs" size="23" maxlength="80" onKeyPress=" return checkEnter(event)">
              <input type="button" name="Submit" value="<? echo BUTTON_SEND; ?>" class="betbuttons" onClick="push_talk();">
            </form>
          </td>
          <td colspan="2" background="images/<? echo $officialstylepack ?>/poker_r7_c21.jpg"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="22" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="2" background="images/<? echo $officialstylepack ?>/poker_r8_c2.jpg"></td>
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r8_c3.jpg" align="center"> 
            <div id="pos1hand"></div>
            <div id="pbet1" class="tblbet"></div>
          </td>
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r8_c6.jpg" align="center" valign="top"> 
            <div id="pos2hand"></div>
            <div id="pbet2" class="tblbet"></div>
          </td>
          <td colspan="11" background="images/<? echo $officialstylepack ?>/poker_r8_c9.jpg" align="center" valign="bottom"> 
            <table width="250" border="0" cellspacing="0" cellpadding="0">
              <tr align="center"> 
                <td width="50" height="62"> 
                  <div id="card1"></div>
                </td>
                <td width="50" height="62"> 
                  <div id="card2"></div>
                </td>
                <td width="50" height="62"> 
                  <div id="card3"></div>
                </td>
                <td width="50" height="62"> 
                  <div id="card4"></div>
                </td>
                <td width="50" height="62"> 
                  <div id="card5"></div>
                </td>
              </tr>
            </table>
          </td>
          <td colspan="2" background="images/<? echo $officialstylepack ?>/poker_r8_c20.jpg" align="center" valign="top"> 
            <div id="pos3hand"></div>
            <div id="pbet3" class="tblbet"></div>
          </td>
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r8_c22.jpg" align="center"> 
            <div id="pos4hand"></div>
            <div id="pbet4" class="tblbet"></div>
          </td>
          <td rowspan="2" background="images/<? echo $officialstylepack ?>/poker_r8_c25.jpg"> 
            <form name="checkmov" >
              <input type="hidden" name="lastmove" id="lastmove">
              <input type="hidden" name="tomove" id="tomove">
              <input type="hidden" name="hand" id="hand">
            </form>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="106" border="0"></td>
        </tr>
        <tr> 
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r9_c3.jpg" align="center"> 
            <div id="pbet10" class="tblbet"></div>
            <div id="pos10hand"></div>
          </td>
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r9_c9.jpg" align="center" valign="bottom"> 
            <div id="pbet9" class="tblbet"></div>
            <div id="pos9hand"></div>
          </td>
          <td colspan="2" background="images/<? echo $officialstylepack ?>/poker_r9_c9.jpg"></td>
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r9_c11.jpg" align="center" valign="bottom"> 
            <div id="pbet8" class="tblbet"></div>
            <div id="pos8hand"></div>
          </td>
          <td colspan="2" background="images/<? echo $officialstylepack ?>/poker_r9_c14.jpg"></td>
          <td colspan="2" background="images/<? echo $officialstylepack ?>/poker_r9_c16.jpg" align="center" valign="bottom"> 
            <div id="pbet7" class="tblbet"></div>
            <div id="pos7hand"></div>
          </td>
          <td colspan="2" background="images/<? echo $officialstylepack ?>/poker_r9_c9.jpg"></td>
          <td colspan="2" background="images/<? echo $officialstylepack ?>/poker_r9_c9.jpg" align="center" valign="bottom"> 
            <div id="pbet6" class="tblbet"></div>
            <div id="pos6hand"></div>
          </td>
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r9_c22.jpg" align="center"> 
            <div id="pbet5" class="tblbet"></div>
            <div id="pos5hand"></div>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="106" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r10_c2.jpg" align="center" class="smllfontwhite"> 
            <div id="pava10"></div>
          </td>
          <td colspan="20" background="images/<? echo $officialstylepack ?>/poker_r10_c4.jpg" align="center" nowrap> 
            <div id="buttons"></div>
          </td>
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r10_c24.jpg" align="center" class="smllfontwhite"> 
            <div id="pava5"></div>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="21" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="5" background="images/<? echo $officialstylepack ?>/poker_r11_c4.jpg"></td>
          <td rowspan="2" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r11_c5.jpg" align="center" class="smllfontwhite"> 
            <div id="pava9"></div>
          </td>
          <td rowspan="5" colspan="4" background="images/<? echo $officialstylepack ?>/poker_r11_c8.jpg"></td>
          <td rowspan="2" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r11_c12.jpg" align="center" class="smllfontwhite"> 
            <div id="pava8"></div>
          </td>
          <td rowspan="5" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r11_c15.jpg"> 
            <div id="flashObject"></div>
          </td>
          <td rowspan="2" background="images/<? echo $officialstylepack ?>/poker_r11_c17.jpg" align="center" class="smllfontwhite"> 
            <div id="pava7"></div>
          </td>
          <td rowspan="5" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r11_c18.jpg"></td>
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r11_c21.jpg" align="center" class="smllfontwhite"> 
            <div id="pava6"></div>
          </td>
          <td rowspan="5" background="images/<? echo $officialstylepack ?>/poker_r11_c23.jpg"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="68" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r12_c2.jpg" valign="top"> 
            <div id="pinfo10"></div>
            <div id="ptimer10" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r12_c24.jpg" valign="top"> 
            <div id="pinfo5"></div>
            <div id="ptimer5" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="21" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="2" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r13_c5.jpg" valign="top"> 
            <div id="pinfo9"></div>
            <div id="ptimer9" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td rowspan="2" colspan="3" background="images/<? echo $officialstylepack ?>/poker_r13_c12.jpg" valign="top"> 
            <div id="pinfo8"></div>
            <div id="ptimer8" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td rowspan="2" background="images/<? echo $officialstylepack ?>/poker_r13_c17.jpg" valign="top"> 
            <div id="pinfo7"></div>
            <div id="ptimer7" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r13_c21.jpg" valign="top"> 
            <div id="pinfo6"></div>
            <div id="ptimer6" align="left"> 
              <table width="1" height="5">
                <tr> 
                  <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5"></td>
                </tr>
              </table>
            </div>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="35" border="0"></td>
        </tr>
        <tr> 
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r14_c2.jpg" align="center" class="dealertxt"><a href="poker_sitout.php" target="_self"><strong>
            Leave Table
            </strong></a></td>
          <td rowspan="2" colspan="2" background="images/<? echo $officialstylepack ?>/poker_r14_c24.jpg" class="tiny">
            <div id="bankroll"></div>
          </td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="21" border="0"></td>
        </tr>
        <tr> 
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r15_c5.jpg"></td>
          <td colspan="3" background="images/<? echo $officialstylepack ?>/poker_r15_c12.jpg"></td>
          <td background="images/<? echo $officialstylepack ?>/poker_r15_c17.jpg"></td>
          <td colspan="2" background="images/<? echo $officialstylepack ?>/poker_r15_c21.jpg"></td>
          <td><img src="images/<? echo $officialstylepack ?>/spacer.gif" width="1" height="5" border="0"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</center>
<?
$h->endpage();
?>