<? 
require('poker_includes/gen_inc.php'); 
require('poker_includes/inc_lobby.php'); 
?>
<html>
<head>
<title><? echo TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/poker.css" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="js/lobby.php"></script>
</head>

<body bgcolor="#000000" text="#CCCCCC" onLoad="games();">
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
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('index.php')" class="hand"> 
                <td> 
                  <? echo MENU_HOME; ?>
                </td>
              </tr>
              <? if (($valid == false) && (MEMMOD == 0)){ ?>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('login.php')" class="hand"> 
                <td> 
                  <? echo MENU_LOGIN; ?>
                </td>
              </tr>
              <? } ?>
              <? if ($valid == false){ ?>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('create.php')" class="hand"> 
                <td> 
                  <? echo MENU_CREATE; ?>
                </td>
              </tr>
              <? } ?>
              <? if ($valid == true){ ?>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('lobby.php')" class="hand"> 
                <td> 
                  <? echo MENU_LOBBY; ?>
                </td>
              </tr>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('rankings.php')" class="hand"> 
                <td> 
                  <? echo MENU_RANKINGS; ?>
                </td>
              </tr>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('myplayer.php')" class="hand"> 
                <td> 
                  <? echo MENU_MYPLAYER; ?>
                </td>
              </tr>
              <? } ?>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('rules.php')" class="hand"> 
                <td> 
                  <? echo MENU_RULES; ?>
                </td>
              </tr>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('faq.php')" class="hand"> 
                <td> 
                  <? echo MENU_FAQ; ?>
                </td>
              </tr>
              <? if ($ADMIN == true){ ?>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('admin.php')" class="hand"> 
                <td> 
                  <? echo MENU_ADMIN; ?>
                </td>
              </tr>
              <? } ?>
              <? if (($valid == true) && (MEMMOD != 1)){ ?>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('index.php?action=logout')" class="hand"> 
                <td>
                  <? echo MENU_LOGOUT; ?>
                </td>
                <? } ?>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td width="650" class="fieldsethead">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td bgcolor="#333333"><b><font size="3"><i><? echo LOBBY; ?></i></font></b></td>
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
?>
        <? } ?>
    </td>
  </tr>
</table>
<p>&nbsp; </p>
</body>
</html>
