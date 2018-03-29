<? 
require('includes/gen_inc.php'); 
require('includes/inc_rankings.php'); 
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
    <td width="650" class="fieldsethead" valign="top" height="100%">
      <table width="100%" border="0" cellspacing="0" cellpadding="3">
        <tr> 
          <td bgcolor="#333333"><b><font size="3"><i><? echo RANKINGS; ?></i></font></b></td>
        </tr>
      </table>
      <div style="border : solid 0px   padding : 1px; width : 100%; height : 430px; overflow : auto; "> 
        <br>
        <?
$staq = mysql_query("select ".DB_STATS.".winpot, ".DB_STATS.".rank, ".DB_STATS.".player, ".DB_STATS.".gamesplayed, ".DB_STATS.".tournamentsplayed, ".DB_STATS.".tournamentswon, ".DB_PLAYERS.".datecreated, ".DB_PLAYERS.".lastlogin  from ".DB_STATS.", ".DB_PLAYERS." where ".DB_PLAYERS.".username = ".DB_STATS.".player and ".DB_PLAYERS.".banned = '0' order by ".DB_STATS.".winpot desc");
while($star = mysql_fetch_array($staq)){ 
$name = $star['player'];
$win = $star['winpot'];
$rank = $star['rank'];
$tplayed = $star['tournamentsplayed'];
$twon = $star['tournamentswon'];
$played = $star['gamesplayed'];
$created = date("m-d-Y",$star['datecreated']);
$lastlogin = date("m-d-Y",$star['lastlogin']);
 ?>
        <table width="600" border="0" cellspacing="0" cellpadding="2" bgcolor="#000000" align="center">
          <tr> 
            <td> 
              <table width="100%" border="0" cellspacing="0" cellpadding="1" class="smllfontwhite" bgcolor="#333333">
                <tr> 
                  <td rowspan="4" align="center" width="19%" valign="middle"> 
                    <?echo display_ava($name); ?>
                  </td>
                  <td width="18%" align="right" nowrap><? echo STATS_PLAYER_NAME; ?></td>
                  <td width="22%" align="left" nowrap> <b> <font color="#FFCC33"> 
                    <? echo $name; ?>
                    </font></b></td>
                  <td width="26%" align="right" nowrap>
                    <? echo STATS_PLAYER_RANKING; ?>
                  </td>
                  <td width="15%" align="left" nowrap><b> <font color="#FFCC33"> 
                    <? echo $rank; ?>
                    </font></b></td>
                </tr>
                <tr> 
                  <td width="18%" align="right" nowrap>
                    <? echo STATS_PLAYER_BANKROLL; ?>
                  </td>
                  <td width="22%" align="left" nowrap><b> 
                    <? echo money($win); ?>
                    </b></td>
                  <td width="26%" align="right" nowrap>
                    <? echo STATS_PLAYER_GAMES_PLAYED; ?>
                  </td>
                  <td width="15%" align="left" nowrap><b> 
                    <? echo $played; ?>
                    </b></td>
                </tr>
                <tr> 
                  <td width="18%" align="right" nowrap>
                    <? echo STATS_PLAYER_LOGIN; ?>
                  </td>
                  <td width="22%" align="left" nowrap><b> 
                    <? echo $lastlogin; ?>
                    </b></td>
                  <td width="26%" align="right" nowrap>
                    <? echo STATS_PLAYER_TOURNAMENTS_PLAYED; ?>
                  </td>
                  <td width="15%" align="left" nowrap><b>
                    <? echo $tplayed; ?>
                    </b></td>
                </tr>
                <tr> 
                  <td width="18%" align="right" nowrap>
                    <? echo STATS_PLAYER_CREATED; ?>
                  </td>
                  <td width="22%" align="left" nowrap><b> 
                    <? echo $created; ?>
                    </b></td>
                  <td width="26%" align="right" nowrap>
                    <? echo STATS_PLAYER_TOURNAMENTS_WON; ?>
                  </td>
                  <td width="15%" align="left" nowrap><b>
                    <? echo $twon; ?>
                    </b></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <br>
        <?  }   ?>
</div>
</td>
  </tr>
</table>
<p>&nbsp; </p>
</body>
</html>
