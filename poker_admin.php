<? 
require('includes/gen_inc.php'); 
require('includes/inc_admin.php'); 
?>
<html>
<head>
<title><? echo TITLE; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="css/poker.css" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="js/lobby.php"></script>
</head>

<body bgcolor="#000000" text="#CCCCCC" >
<table width="772" border="0" cellspacing="0" cellpadding="2" align="center" bgcolor="#1B1B1B">
  <tr> 
    <td valign="top" bgcolor="#333333"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr> 
          <td> 
            <? require('includes/scores.php'); ?>
          </td>
        </tr>
        <tr> 
          <td> 
            <table border="0" cellspacing="0" cellpadding="1" width="98%" class="smllfontpink" align="center" height="55">
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('index.php')" class="hand"> 
                <td>
                  <? echo MENU_HOME; ?>
                </td>
              </tr>      <? if (($valid == false) && (MEMMOD == 0)){ ?>
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
              <? } ?>              <? if (($valid == true) && (MEMMOD != 1)){ ?>
              <tr onMouseOver="this.bgColor = '#330000'; this.style.color = 'FFFFFF'" onMouseOut="this.bgColor = ''; this.style.color = 'CC9999'" onClick="changeview('index.php?action=logout')" class="hand"> 
                <td><? echo MENU_LOGOUT; ?></td>
              <? } ?>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td width="650" class="fieldsethead" valign="top" height="100%">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td bgcolor="#333333" width="28%"><font size="3"><i> <b> 
            <? echo ADMIN; ?>
            </b></i><b> </b></font></td>
          <td bgcolor="#333333" width="72%" align="right" class="tablesmll"> <font color="#FFFFFF"> 
            <a href="admin.php"> <b> 
            <? echo ADMIN_MANAGE_TABLES; ?>
            </b></a><b> | <a href="admin.php?admin=members"> 
            <? echo ADMIN_MANAGE_MEMBERS; ?>
            </a> | <a href="admin.php?admin=settings"> 
            <? echo ADMIN_MANAGE_SETTINGS; ?>
            </a> | <a href="admin.php?admin=styles"> 
            <? echo ADMIN_MANAGE_STYLES; ?>
            </a></b> </font></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td class="fieldsetheadcontent">
            <table width="99%" border="1" cellspacing="0" cellpadding="2" align="center" bgcolor="#333333" bordercolor="#666666">
              <tr> 
                <td> 
                  <? 
if($adminview == 'settings'){ ?>
                  <table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                    <tr> 
                      <td align="center" valign="middle"> 
                        <div style="border : solid 0px   padding : 1px; width : 100%; height : 550px; overflow : auto; "><font color="#FF0000"> 
                          <? if($_GET['ud'] == 1){ ?>
                          </font> 
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="red" align="center">
                            <tr> 
                              <td align="center" class="smllfont" bgcolor="#660000"> 
                                 <a href="admin.php?admin=members"><font color="#FFFFFF">
                                <? echo ADMIN_SETTINGS_UPDATED; ?>
                                </font></a></td>
                            </tr>
                          </table>
                          <? } ?>
                          &nbsp; 
                          <form name="form2" method="post" action="admin.php?admin=settings">
                            <table border="0" cellspacing="0" cellpadding="5" class="smllfontwhite" align="center" bgcolor="#333333">
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <font color="#FFCC33"> 
                                  <? echo ADMIN_GENERAL; ?>
                                  </font></font></a></b></td>
                                <td colspan="2"></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_TITLE; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <input type="text" name="title" class="fieldsetheadinputs" size="60" maxlength="60" value="<? echo TITLE; ?>">
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_TITLE_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_EMAIL; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="emailmode" class="fieldsetheadinputs">
                                    <option value="0" <? if(EMAILMOD == 0) echo 'selected'; ?>>off</option>
                                    <option value="1" <? if(EMAILMOD == 1) echo 'selected'; ?>>on</option>
                                  </select>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_EMAIL_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_APPROVAL; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="appmode" class="fieldsetheadinputs">
                                    <option value="0" <? if(APPMOD == 0) echo 'selected'; ?>>automatic</option>
                                    <option value="1" <? if(APPMOD == 1) echo 'selected'; ?>>email 
                                    approval</option>
                                    <option value="2" <? if(APPMOD == 2) echo 'selected'; ?>>administrator 
                                    approval</option>
                                  </select>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_APPROVAL_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_IPCHECK; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="ipcheck" class="fieldsetheadinputs">
                                    <option value="0" <? if(IPCHECK == 0) echo 'selected'; ?>>off</option>
                                    <option value="1" <? if(IPCHECK == 1) echo 'selected'; ?>>on</option>
                                  </select>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_IPCHECK_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_LOGIN; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="memmode" class="fieldsetheadinputs">
                                    <option value="0" <? if(MEMMOD == 0) echo 'selected'; ?>>off</option>
                                    <option value="1" <? if(MEMMOD == 1) echo 'selected'; ?>>on</option>
                                  </select>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_LOGIN_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <? if(MEMMOD == 1) { ?>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_SESSNAME; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <input type="text" name="session" size="25" class="fieldsetheadinputs" value="<? echo SESSNAME; ?>">
                                  <? if(SESSNAME == '') echo '  <font color="#FF0000">You must 
                                  enter a session variable!!</font>'; ?>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_SESSNAME_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <? } ?>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_AUTODELETE; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="delete" class="fieldsetheadinputs">
                                    <option value="30" <? if(DELETE == 30) echo 'selected'; ?>>After 
                                    30 days of inactivity</option>
                                    <option value="60" <? if(DELETE == 60) echo 'selected'; ?>>After 
                                    60 days of inactivity</option>
                                    <option value="90"  <? if(DELETE == 90) echo 'selected'; ?>>After 
                                    90 days of inactivity</option>
                                    <option value="180" <? if(DELETE == 180) echo 'selected'; ?>>After 
                                    180 days of inactivity</option>
                                    <option value="never" <? if(DELETE == 'never') echo 'selected'; ?>>Never</option>
                                  </select>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td class="smllfontwhite" nowrap width="156">&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_AUTODELETE_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <tr> 
                                <td class="smllfontwhite" nowrap width="156"><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_STAKESIZE; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="stakesize" class="fieldsetheadinputs">
                                    <option value="tiny" <? if(STAKESIZE == 'tiny') echo 'selected'; ?>>Tiny 
                                    Stakes [$10+]</option>
                                    <option value="low" <? if(STAKESIZE == 'low') echo 'selected'; ?>>Low 
                                    Stakes [$100+]</option>
                                    <option value="med" <? if(STAKESIZE == 'med') echo 'selected'; ?>>Medium 
                                    Stakes [$1000+]</option>
                                    <option value="high" <? if(STAKESIZE == 'high') echo 'selected'; ?>>High 
                                    Rollers [$10k+]</option>
                                  </select>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td class="smllfontwhite" nowrap width="156">&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_STAKESIZE_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <tr> 
                                <td class="smllfontwhite" nowrap width="156"><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_BROKE_BUTTON; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="renew" class="fieldsetheadinputs">
                                    <option value="0" <? if(RENEW == 0) echo 'selected'; ?>>off</option>
                                    <option value="1" <? if(RENEW == 1) echo 'selected'; ?>>on</option>
                                  </select>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td colspan="2"><a href="admin.php?admin=members"><font color="#999999"> 
                                  <? echo ADMIN_SETTINGS_BROKE_BUTTON_HELP; ?>
                                  </font></a></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td align="center"> <font color="#999999"> 
                                  <input type="submit" name="Submit" value="<? echo BUTTON_SAVE_SETTINGS; ?>" class="betbuttons">
                                  </font></td>
                                <td></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td colspan="2"></td>
                              </tr>
                              <tr> 
                                <td class="smllfontwhite" nowrap width="156"> 
                                  <b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <font color="#FFCC33"> 
                                  <? echo ADMIN_TIMER; ?>
                                  </font></font></a><font color="#FFFFFF"> 
                                  <input type="hidden" name="action" value="update">
                                  </font></b></td>
                                <td colspan="2"></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_KICK; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="kick" class="fieldsetheadinputs">
                                    <option value="3" <? if(KICKTIMER == 3) echo 'selected'; ?>>3 
                                    mins</option>
                                    <option value="5" <? if(KICKTIMER == 5) echo 'selected'; ?>>5 
                                    mins</option>
                                    <option value="7" <? if(KICKTIMER == 7) echo 'selected'; ?>>7 
                                    mins</option>
                                    <option value="10" <? if(KICKTIMER == 10) echo 'selected'; ?>>10 
                                    mins</option>
                                    <option value="15" <? if(KICKTIMER == 15) echo 'selected'; ?>>15 
                                    mins</option>
                                  </select>
                                  <? echo ADMIN_SETTINGS_KICK_HELP; ?>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_MOVE; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="move" class="fieldsetheadinputs">
                                    <option value="10" <? if(MOVETIMER == 10) echo 'selected'; ?>>Turbo</option>
                                    <option value="15" <? if(MOVETIMER == 15) echo 'selected'; ?>>Fast</option>
                                    <option value="20" <? if(MOVETIMER == 20) echo 'selected'; ?>>Normal</option>
                                    <option value="27" <? if(MOVETIMER == 27) echo 'selected'; ?>>Slow</option>
                                  </select>
                                  <? echo ADMIN_SETTINGS_MOVE_HELP; ?>
                                  </font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap height="36"><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_SHOWDOWN; ?>
                                  </font></a></b></td>
                                <td colspan="2" height="36"> <font color="#999999"> 
                                  <select name="showdown" class="fieldsetheadinputs">
                                    <option value="3" <? if(SHOWDOWN == 3) echo 'selected'; ?>>3 
                                    secs</option>
                                    <option value="5" <? if(SHOWDOWN == 5) echo 'selected'; ?>>5 
                                    secs</option>
                                    <option value="7" <? if(SHOWDOWN == 7) echo 'selected'; ?>>7 
                                    secs</option>
                                    <option value="10" <? if(SHOWDOWN == 10) echo 'selected'; ?>>10 
                                    secs</option>
                                  </select>
                              <? echo ADMIN_SETTINGS_SHOWDOWN_HELP; ?></font></td>
                              </tr>
                              <tr> 
                                <td width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_SITOUT; ?>
                                  </font></a></b></td>
                                <td colspan="2"> <font color="#999999"> 
                                  <select name="wait" class="fieldsetheadinputs">
                                    <option value="0" <? if(WAITIMER == 0) echo 'selected'; ?>>None</option>
                                    <option value="10" <? if(WAITIMER == 10) echo 'selected'; ?>>10 
                                    secs</option>
                                    <option value="15" <? if(WAITIMER == 15) echo 'selected'; ?>>15 
                                    secs</option>
                                    <option value="20" <? if(WAITIMER == 20) echo 'selected'; ?>>20 
                                    secs</option>
                                    <option value="25" <? if(WAITIMER == 25) echo 'selected'; ?>>25 
                                    secs</option>
                                  </select>
                                  <? echo ADMIN_SETTINGS_SITOUT_HELP; ?>
                              </font></td>
                              </tr>
                              <tr> 
                                <td height="19" width="156" class="smllfontwhite" nowrap><b><a href="admin.php?admin=members"><font color="#FFFFFF"> 
                                  <? echo ADMIN_SETTINGS_DISCONNECT; ?>
                                  </font></a></b></td>
                                <td height="19" colspan="2">      <font color="#999999"> 
                                  <select name="disconnect" class="fieldsetheadinputs">
                                    <option value="15" <? if(DISCONNECT == 15) echo 'selected'; ?>>15 
                                    secs</option>
                                    <option value="30" <? if(DISCONNECT == 30) echo 'selected'; ?>>30 
                                    secs</option>
                                    <option value="60" <? if(DISCONNECT == 60) echo 'selected'; ?>>60 
                                    secs</option>
                                    <option value="90" <? if(DISCONNECT == 90) echo 'selected'; ?>>90 
                                    secs</option>
                                    <option value="120" <? if(DISCONNECT == 120) echo 'selected'; ?>>120 
                                    secs</option>
                                  </select>
                                 <? echo ADMIN_SETTINGS_DISCONNECT_HELP; ?>
                                 </font></td>
                              </tr>
                              <tr> 
                                <td height="19" width="156" class="smllfontwhite" nowrap>&nbsp;</td>
                                <td height="19" width="248" align="center"> <font color="#999999"> 
                                  <input type="submit" name="Submit" value="<? echo BUTTON_SAVE_SETTINGS; ?>" class="betbuttons">
                                  </font></td>
                                <td height="19" width="232"> </td>
                              </tr>
                            </table>
                          </form>
                        </div>
                      </td>
                    </tr>
                  </table>
                  <? }elseif($adminview == 'members'){ ?>
                  <table width="620" border="0" cellspacing="0" cellpadding="2" align="center">
                    <tr> 
                      <td> 
                        <? $dir = (($_GET['dir'] != '')? addslashes($_GET['dir']) : 'asc');
$col = (($_GET['col'] != '')? addslashes($_GET['col']) : DB_PLAYERS.'.username'); 
$oppdir = (($dir == 'asc')? 'desc' : 'asc');
$hrefarray = array();
$colarray = array('".DB_PLAYERS.".username','".DB_STATS.".rank','".DB_PLAYERS.".datecreated','".DB_PLAYERS.".ipaddress','".DB_PLAYERS.".approve','".DB_PLAYERS.".banned');
$i =0;
while($colarray[$i] != ''){
if($col == $colarray[$i]){
$hrefarray[$colarray[$i]] = 'admin.php?col='.$colarray[$i].'&dir='.$oppdir.'&admin=members';
}else{
$hrefarray[$colarray[$i]] = 'admin.php?col='.$colarray[$i].'&dir=asc&admin=members';
}
$i++;
}
?>
                        <? if(EMAILMOD == 0){ ?>
                        <table border="0" cellspacing="0" cellpadding="1" class="smllfontwhite" align="center">
                          <tr> 
                            <td width="130" nowrap class="fieldsetheadcontent"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.username']; ?>"><font color="#FFCC33"> 
                              <? echo ADMIN_MEMBERS_NAME; if(($col == DB_PLAYERS.'.username') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.username') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                              </font> </a></b></td>
                            <td width="50" nowrap align="center"><b><a href="<? echo $hrefarray[DB_STATS.'.rank']; ?>"><font color="#FFCC33"> 
                              <? echo ADMIN_MEMBERS_RANK; if(($col == DB_STATS.'.rank') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_STATS.'.rank') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                              </font> </a></b></td>
                            <td width="80" nowrap align="center"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.datecreated']; ?>"><font color="#FFCC33"> 
                              <? echo ADMIN_MEMBERS_CREATED;  if(($col == DB_PLAYERS.'.datecreated') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.datecreated') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                              </font> </a></b></td>
                            <td nowrap align="center" width="100"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.ipaddress']; ?>"><font color="#FFCC33"> 
                              <? echo ADMIN_MEMBERS_IPADDRESS; if(($col == DB_PLAYERS.'.ipaddress') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.ipaddress') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                              </font></a> </b>
                            <td width="70" nowrap align="center"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.approve']; ?>"><font color="#FFCC33"> 
                              <? echo ADMIN_MEMBERS_APPROVE; if(($col == DB_PLAYERS.'.approve') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.banned') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                              </font> </a></b></td>
                            <td width="50" nowrap align="center"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.banned']; ?>"><font color="#FFCC33"> 
                              <? echo ADMIN_MEMBERS_BAN; if(($col == DB_PLAYERS.'.banned') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.username') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                              </font> </a></b></td>
                            <td width="50" nowrap align="center"><b><font color="#FFCC33"> 
                              <? echo ADMIN_MEMBERS_DELETE; ?>
                              </font></b></td>
                            <td width="50" nowrap align="center"><b><font color="#FFCC33"> 
                              <? echo ADMIN_MEMBERS_RESET_STATS; ?>
                              </font></b></td>
                          </tr>
                        </table>
                        <div style="border : solid 0px   padding : 1px; width : 100%; height : 350px; overflow : auto; "> 
                          <table border="0" cellspacing="0" cellpadding="1" class="smllfontwhite" align="center" bgcolor="#333333">
                            <? 
$plq = mysql_query("select ".DB_PLAYERS.".username, ".DB_PLAYERS.".datecreated, ".DB_PLAYERS.".banned, ".DB_PLAYERS.".ipaddress, ".DB_PLAYERS.".approve, ".DB_STATS.".rank from ".DB_PLAYERS.", ".DB_STATS." where ".DB_PLAYERS.".username = ".DB_STATS.".player order by ".$col." ".$dir);
while($plr = mysql_fetch_array($plq)){
$pname = $plr['username'];
$pban = $plr['banned'];
$pdate = date("m-d-Y",$plr['datecreated']);
$pip = $plr['ipaddress'];
$prank = $plr['rank'];
$papprove = $plr['approve'];
?>
                            <tr> 
                              <td width="130" align="left"> 
                                <? echo $pname; ?>
                              </td>
                              <td width="50" align="center" nowrap> 
                                <? echo $prank; ?>
                              </td>
                              <td width="80" align="center" nowrap> 
                                <? echo $pdate; ?>
                              </td>
                              <td width="100" align="center" nowrap> 
                                <? echo $pip; ?>
                              </td>
                              <td width="70" align="center" nowrap> 
                                <? if($papprove == 1){ ?>
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="approve">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_APPROVE; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                                <? } ?>
                              </td>
                              <td width="50" align="center" nowrap> 
                                <? if($plyrname != $pname){ ?>
                                <? if($pban == 0){ ?>
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="ban">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_BAN; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                                <? }else{ ?>
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="unban">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_UNBAN; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                                <? } ?>
                                <? } ?>
                              </td>
                              <td width="50" align="center" nowrap> 
                                <? if($plyrname != $pname){ ?>
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="delete">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_DELETE; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                                <? } ?>
                              </td>
                              <td width="50" align="center" nowrap> 
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="reset">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_RESET; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                              </td>
                            </tr>
                            <? } ?>
                          </table>
                          <? }else{ ?>
                          <table border="0" cellspacing="0" cellpadding="1" class="smllfontwhite" align="center">
                            <tr> 
                              <td width="100" nowrap class="fieldsetheadcontent"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.username']; ?>"><font color="#FFCC33"> 
                                <? echo ADMIN_MEMBERS_NAME; if(($col == DB_PLAYERS.'.username') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.username') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                                </font></a></b></td>
                              <td width="40" nowrap align="center"><b><a href="<? echo $hrefarray[DB_STATS.'.rank']; ?>"><font color="#FFCC33"> 
                                <? echo ADMIN_MEMBERS_RANK; if(($col == DB_STATS.'.rank') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_STATS.'.rank') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                                </font></a></b></td>
                              <td width="150" nowrap align="center"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.email']; ?>"><font color="#FFCC33"> 
                                <? echo ADMIN_MEMBERS_EMAIL;  if(($col == DB_PLAYERS.'.email') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.email') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                                </font> </a></b></td>
                              <td nowrap align="center" width="90"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.ipaddress']; ?>"><font color="#FFCC33"> 
                                <? echo ADMIN_MEMBERS_IPADDRESS; if(($col == DB_PLAYERS.'.ipaddress') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.ipaddress') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                                </font></a> </b>
                              <td width="60" nowrap align="center"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.approve']; ?>"><font color="#FFCC33"> 
                                <? echo ADMIN_MEMBERS_APPROVE; if(($col == DB_PLAYERS.'.approve') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.banned') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                                </font> </a></b></td>
                              <td width="40" nowrap align="center"><b><a href="<? echo $hrefarray[DB_PLAYERS.'.banned']; ?>"><font color="#FFCC33"> 
                                <? echo ADMIN_MEMBERS_BAN; if(($col == DB_PLAYERS.'.banned') && ($dir == 'asc')){ echo '<img src="images/down.gif" border="0" width="10" height="10">'; }elseif(($col == DB_PLAYERS.'.username') && ($dir == 'desc')){ echo '<img src="images/up.gif" border="0" width="10" height="10">'; } ?>
                                </font> </a></b></td>
                              <td width="50" nowrap align="center"><b><font color="#FFCC33"> 
                                <? echo ADMIN_MEMBERS_DELETE; ?>
                                </font></b></td>
                              <td width="40" nowrap align="center"><b><font color="#FFCC33"> 
                                <? echo ADMIN_MEMBERS_RESET_STATS; ?>
                                </font></b></td>
                            </tr>
                          </table>
                          <table border="0" cellspacing="0" cellpadding="1" class="smllfontwhite" align="center" bgcolor="#333333">
                            <? 
$plq = mysql_query("select ".DB_PLAYERS.".username, ".DB_PLAYERS.".datecreated, ".DB_PLAYERS.".banned, ".DB_PLAYERS.".ipaddress, ".DB_PLAYERS.".approve, ".DB_PLAYERS.".email , ".DB_STATS.".rank from ".DB_PLAYERS.", ".DB_STATS." where ".DB_PLAYERS.".username = ".DB_STATS.".player order by ".$col." ".$dir);
while($plr = mysql_fetch_array($plq)){
$pname = $plr['username'];
$pban = $plr['banned'];
$pdate = date("m-d-Y",$plr['datecreated']);
$pip = $plr['ipaddress'];
$prank = $plr['rank'];
$papprove = $plr['approve'];
$pemail = $plr['email'];
?>
                            <tr> 
                              <td width="100" align="left"> 
                                <? echo $pname; ?>
                              </td>
                              <td width="40" align="center" nowrap> 
                                <? echo $prank; ?>
                              </td>
                              <td width="150" align="center" nowrap> 
                                <? if(strlen($pemail) > 25){
 echo substr($pemail,0,20).'...<img src="images/info.gif" border="0" alt="'.$pemail.'" width="10! height="10">'; 
}else{
 echo $pemail; 
}?>
                              </td>
                              <td width="90" align="center" nowrap> 
                                <? echo $pip; ?>
                              </td>
                              <td width="60" align="center" nowrap> 
                                <? if($papprove == 1){ ?>
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="approve">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_APPROVE; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                                <? } ?>
                              </td>
                              <td width="40" align="center" nowrap> 
                                <? if($plyrname != $pname){ ?>
                                <? if($pban == 0){ ?>
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="ban">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_BAN; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                                <? }else{ ?>
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="unban">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_UNBAN; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                                <? } ?>
                                <? } ?>
                              </td>
                              <td width="50" align="center" nowrap>
                                <? if($plyrname != $pname){ ?>
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="delete">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_DELETE; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                                <? } ?>
                              </td>
                              <td width="40" align="center" nowrap> 
                                <form name="form1" method="post" action="admin.php?admin=members">
                                  <font color="#FFCC33"> 
                                  <input type="hidden" name="action" value="reset">
                                  <input type="hidden" name="player" value="<? echo $pname; ?>">
                                  </font> 
                                  <input type="button" name="Button" value="<? echo BUTTON_RESET; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                                </form>
                              </td>
                            </tr>
                            <? } ?>
                          </table>
                          <? }  ?>
                        </div>
                      </td>
                    </tr>
                  </table>
        <? }elseif($adminview == 'styles'){ ?>
                  <form name="form3" method="post" action="">
                    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="smllfontwhite">
                      <tr> 
                        <td width="26%"><b><font color="#FFCC33"> 
                          <? echo ADMIN_STYLES_INSTALLED; ?>
                          </font></b></td>
                        <td width="45%"><b><font color="#FFCC33"> 
                          <? echo ADMIN_STYLES_PREVIEW; ?>
                          </font></b></td>
                        <td width="29%">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="26%" valign="middle">default style pack</td>
                        <td width="45%" valign="middle"><img src="images/default/preview.jpg" width="112" height="80"></td>
                        <td width="29%">&nbsp;</td>
                      </tr>
                      <? $styq = mysql_query("select style_name from styles");
while($styr = mysql_fetch_array($styq)){
$name = $styr['style_name'];
$sname = $styr['style_name'].' style pack';
$spreview = '<img src="images/'.$name.'/preview.jpg" border="0" width="112" height="80">';
 ?>
                      <tr> 
                        <td width="26%" valign="middle"> 
                          <? echo $sname; ?>
                        </td>
                        <td width="45%" valign="middle"> 
                          <? echo $spreview; ?>
                        </td>
                        <td width="29%">&nbsp;</td>
                      </tr>
                      <? } ?>
                      <tr> 
                        <td width="26%">&nbsp;</td>
                        <td width="45%" align="center"><font color="#FF0000"> 
                          <? echo $msg; ?>
                          </font></td>
                        <td width="29%"></td>
                      </tr>
                      <tr> 
                        <td width="26%"><font color="#FFCC33"> 
                          <? echo ADMIN_STYLES_NEW_NAME; ?>
                          </font></td>
                        <td width="45%"><font color="#FFCC33"> 
                          <? echo ADMIN_STYLES_CODE; ?>
                          </font></td>
                        <td width="29%"> 
                          <input type="hidden" name="action" value="install">
                        </td>
                      </tr>
                      <tr> 
                        <td width="26%"> 
                          <input type="text" name="name" size="25" maxlength="25" class="fieldsetheadinputs">
                        </td>
                        <td width="45%"> 
                          <input type="text" name="lic" size="40" maxlength="40" class="fieldsetheadinputs">
                        </td>
                        <td width="29%"> 
                          <input type="button" name="Button" value="<? echo BUTTON_INSTALL; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                        </td>
                      </tr>
                    </table>
                  </form>
                  <? }else{ ?>
                  <form name="createtable" method="post" action="admin.php">
                    <table border="0" cellspacing="0" cellpadding="3" class="smllfontwhite">
                      <tr> 
                        <td nowrap><b><font color="#FFCC33"> 
                          <? echo ADMIN_TABLES_NAME; ?>
                          </font></b></td>
                        <td align="center" nowrap><b><font color="#FFCC33"> 
                          <? echo ADMIN_TABLES_TYPE; ?>
                          </font></b></td>
                        <td align="center" nowrap><b><font color="#FFCC33"> 
                          <? echo ADMIN_TABLES_MIN; ?>
                          </font></b></td>
                        <td align="center" nowrap><b><font color="#FFCC33"> 
                          <? echo ADMIN_TABLES_MAX; ?>
                          </font></b></td>
                        <td align="center" nowrap><b><font color="#FFCC33"> 
                          <? echo ADMIN_TABLES_STYLE; ?>
                          </font></b></td>
                        <td align="center" nowrap><b><font color="#FFCC33"> 
                          <? echo ADMIN_TABLES_DELETE; ?>
                          </font></b></td>
                      </tr>
                      <?
$tableq = mysql_query("select gameID,tablename,tablelimit ,tabletype, tablelow, tablestyle from ".DB_POKER." order by tablelimit asc ");
while($tabler = mysql_fetch_array($tableq)){ 

$tablename =  stripslashes($tabler['tablename']);
$min = (($tabler['tabletype'] != 't')? money_small($tabler['tablelow']) : 'N/A');
$tablelimit = $tabler['tablelimit'];
$max = money_small($tablelimit);
$gameID = $tabler['gameID'];
$tabletype = (($tabler['tabletype'] == 't')? 'Tournament' : 'Sit \'n Go');
$tablestyle = (($tabler['tablestyle'] == '')? 'default' : $tabler['tablestyle']);

?>
                      <tr> 
                        <td> 
                          <? echo $tablename; ?>
                        </td>
                        <td align="center"> 
                          <? echo $tabletype; ?>
                        </td>
                        <td align="center"> 
                          <? echo $min; ?>
                        </td>
                        <td align="center"> 
                          <? echo $max; ?>
                        </td>
                        <td align="center"> 
                          <? echo $tablestyle; ?>
                        </td>
                        <td align="center"> 
                          <input type="button" name="Button" value="<? echo BUTTON_DELETE; ?>"  onClick="changeview('admin.php?delete=<? echo $gameID; ?>')" class="betbuttons" >
                        </td>
                      </tr>
                      <? } ?>
                      <tr> 
                        <td> 
                          <input type="text" name="tname" class="fieldsetheadinputs" maxlength="25">
                        </td>
                        <td align="center"> 
                          <select name="ttype" class="fieldsetheadinputs">
                            <option value="s"> 
                            <? echo SITNGO; ?>
                            </option>
                            <option value="t"> 
                            <? echo TOURNAMENT; ?>
                            </option>
                          </select>
                        </td>
                        <td align="center"> 
                          <select name="tmin" class="fieldsetheadinputs">
                            <option value="0" selected>
                            <? echo money(0); ?>
                            </option>
                            <option value="1000">
                            <? echo money(1000); ?>
                            </option>
                            <option value="2500">
                            <? echo money(2500); ?>
                            </option>
                            <option value="5000">
                            <? echo money(5000); ?>
                            </option>
                            <option value="10000">
                            <? echo money(10000); ?>
                            </option>
                            <option value="25000">
                            <? echo money(25000); ?>
                            </option>
                            <option value="50000">
                            <? echo money(50000); ?>
                            </option>
                            <option value="100000">
                            <? echo money(100000); ?>
                            </option>
                            <option value="250000">
                            <? echo money(250000); ?>
                            </option>
                            <option value="500000">
                            <? echo money(500000); ?>
                            </option>
                          </select>
                        </td>
                        <td align="center"> 
                          <select name="tmax" class="fieldsetheadinputs">
                            <option value="10000" selected>
                            <? echo money(10000); ?>
                            </option>
                            <option value="25000">
                            <? echo money(25000); ?>
                            </option>
                            <option value="50000">
                            <? echo money(50000); ?>
                            </option>
                            <option value="100000">
                            <? echo money(100000); ?>
                            </option>
                            <option value="250000">
                            <? echo money(250000); ?>
                            </option>
                            <option value="500000">
                            <? echo money(500000); ?>
                            </option>
                            <option value="1000000">
                            <? echo money(1000000); ?>
                            </option>
                          </select>
                          <input type="hidden" name="action" value="createtable">
                        </td>
                        <td align="center"> 
                          <select name="tstyle" class="fieldsetheadinputs">
                            <option selected>default</option>
                            <? $stq = mysql_query("select style_name from styles");
while($str = mysql_fetch_array($stq)){ ?>
                            <option value="<? echo $str['style_name']; ?>">
                            <? echo $str['style_name']; ?>
                            </option>
                            <? } ?>
                          </select>
                        </td>
                        <td align="center"> 
                          <input type="submit" name="Submit" value="<? echo BUTTON_CREATE_TABLE ?>"  class="betbuttons" >
                        </td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                  </form>
                  <? }  ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
