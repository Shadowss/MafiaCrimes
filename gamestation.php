<?php
include "globals.php";
switch($_GET['action'])
{
case 'blackjack': black_jack(); break;
case 'pacman': pac_man(); break;
case 'ewoks': ewoks(); break;
case 'poker': poker(); break;
default: gamestation_index(); break;
}
function gamestation_index()
{
global $ir,$c,$userid;
print"
 <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><font color=purple> Game Station</font></h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>";
print"
<table width=100% border=3 bordercolor=silver class='table'><tr><th><font color=gold>Game Name</font></th><th><font color=gold>Description</font></th>";
print"<tr><td><a href='gamestation.php?action=blackjack'>Blackjack</a></td><td>Blackjack card game Click on the name to play</td>";
print"<tr><td><a href='gamestation.php?action=pacman'>Pacman</a></td><td>Pacman is back! Click on the name  to play</td>";
print"<tr><td><a href='gamestation.php?action=ewoks'>Ewoks</a></td><td>Blast the crap out the of cute little teddies from Star Wars. Click on the name  to play</td>";
print"<tr><td> <a href='gamestation.php?action=poker'>Poker</a> </td><td>Poker, a card game played by millions. Click on the name  to play</td>";
print"</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";
}
function black_jack()
{
global $ir, $c,$userid;
print "

 <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><font color=purple> <font color=purple>Blackjack</font></font></h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


";
print "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='500' height='500'>
<param name='movie' value='images/blackjack.swf'><param name='quality' value='high'>
<embed src='images/blackjack.swf' width=500 height=500 align='center' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed>
</object></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> <br><br><a href='gamestation.php'>Back to Game Station</a> ";
}
function pac_man()
{
global $ir,$c,$userid;
print "


 <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><font color=purple> <font color=purple>Pac-Man</font</font></h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


";
print"<OBJECT classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0' width='470' height='470'>
               <PARAM name=quality value=high>
               <PARAM name='SRC' value='images/pacman.swf'>
               <EMBED src='images/pacman.swf' width='470' height='470' quality=high pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash'> 
               </EMBED></object><br><br><b>These are the shortcut keys:<br><font color=red>M</font> - Turn music On/Off<br><font color=red>P</font> - Pause/ Unpause the game<br><font color=red>Q</font> - Quit the Game<br> <font color=red>L</font> - Low quality on/ off</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><br><br><a href='gamestation.php'>Back to Game Station</a>";
}

function ewoks()
{
global $ir,$c,$userid;
print "



 <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><font color=purple> <font color=purple>Ewoks</font</font></h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


";
print "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='500' height='500'>
<param name='movie' value='images/ewoks.swf'><param name='quality' value='high'>
<embed src='images/ewoks.swf' width=500 height=500 align='center' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed>
</object></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><br><br><a href='gamestation.php'>Back to Game Station</a>";
}
function poker()
{
global $ir,$c,$userid;
print "


 <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'><font color=purple> <font color=purple>Poker</font</font></h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

";
print "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' width='500' height='500'>
<param name='movie' value='images/poker.swf'><param name='quality' value='high'>
<embed src='images/poker.swf' width=500 height=500 align='center' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'></embed>
</object></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div><br><br><a href='gamestation.php'>Back to Game Station</a>";
}
$h->endpage
?>