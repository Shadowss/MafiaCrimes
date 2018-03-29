<?php     

/**************************************************************************************************
| Software Name        : Mafia Game Scripts Online Mafia Game
| Software Author      : Mafia Game Scripts
| Software Version     : Version 2.3.1 Build 2301
| Website              : http://www.mafiagamescript.net/
| E-mail               : support@mafiagamescript.net
|**************************************************************************************************
| The source files are subject to the Mafia Game Script End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Mafia Game Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Mafia Game Script . All rights reserved.
|**************************************************************************************************/

class headers {
function startheaders() {  
global $ir, $set,$special_page,$lang;
global $_CONFIG;
define("MONO_ON", 1);
$db=new database;
$db->configure($_CONFIG['hostname'],
$_CONFIG['username'],
$_CONFIG['password'],
$_CONFIG['database'],
$_CONFIG['persistent']);
$db->connect();
$c=$db->connection_id;
$set=array();
$settq=$db->query("SELECT * FROM settings");
while($r=$db->fetch_row($settq))
{
$set[$r['conf_name']]=$r['conf_value'];
}
$q=$db->query("SELECT userid FROM users");
$membs=$db->num_rows($q);
$q=$db->query("SELECT userid FROM users WHERE bankmoney>-1");
$banks=$db->num_rows($q);
$q=$db->query("SELECT userid FROM users WHERE gender='Male'");
$male=$db->num_rows($q);
$q=$db->query("SELECT userid FROM users WHERE gender='Female'");
$fem=$db->num_rows($q);
$money=money_formatter($ir['money']);
$crystals=money_formatter($ir['crystals'],'');
$cn=0;
// Users Online , Counts Users Online In Last 15 minutes                                                                           
$q=$db->query("SELECT * FROM users WHERE laston>unix_timestamp()-15*60 ORDER BY laston DESC");
$online=$db->num_rows($q);
$ec=$ir['new_events'];
$mc=$ir['new_mail'];

$ids_checkpost=urldecode($_SERVER['QUERY_STRING']);
if(eregi("[\'|'/'\''<'>'*'~'`']",$ids_checkpost) || strstr($ids_checkpost,'union') || strstr($ids_checkpost,'java') || strstr($ids_checkpost,'script') || strstr($ids_checkpost,'substring(') || strstr($ids_checkpost,'ord()')){

$passed=0;
echo "<center> <font color=red> Hack attempt <br/>!!! WARNING !!! <br/>

Malicious Code Detected! The staff has been notified.</font></center>"; 
event_add(1,"  <a href='viewuser.php?u={$ir['userid']}'>  <font color=red> ".$ir['username']."</font> </a>  <b> Tried to use [".$_SERVER['SCRIPT_NAME']."{$ids_checkpost}].. ",$c); 
$h->endpage();
exit;

} 
if($special_page == "inventory_v2")
	$js_head =      '<link rel="stylesheet" href="http://mafiacorruption.com/js/inventory.css" type="text/css" media="print, projection, screen">        
		        <script src="js/jquery-1.js" type="text/javascript"></script>
		        <script src="js/ui_002.js" type="text/javascript"></script>
		        <script src="js/ui.js" type="text/javascript"></script>
		        <script type="text/javascript">
		            $(function() {
		                $("#rotate > ul").tabs({ fx: { opacity: "toggle" } }).tabs("rotate", 0);
		            });
		        </script>
		        <link rel="stylesheet" href="css/styleold.css" type="text/css" />
      		         <link rel="stylesheet" href="css/stylenew.css" type="text/css" />
      		         <link rel="stylesheet" href="http://mafiacorruption.com/css/inventory.css" type="text/css" />';
else
	$js_head = 	'<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		        <script src="http://www.sunsean.com/idTabs/jquery.idTabs.min.js" type="text/javascript"></script>
		        <link rel="stylesheet" href="css/styleold.css" type="text/css" />
      		         <link rel="stylesheet" href="css/stylenew.css" type="text/css" />
';

echo <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">

#dhtmltooltip{
	position: absolute;
	visibility:hidden;
	padding:4px 8px;
	color: #666666;
	text-shadow: white 0px 1px 0px;
	background: #ffdd00;
	background-image: -webkit-gradient(linear, left top, left bottom, from(rgb(255,255,255)), to(rgb(255,224,0)));
	background-image: -moz-linear-gradient(top, rgb(255,255,255), rgb(255,224,0));
	font: 100% Arial, Helvetica, sans-serif;
	font-weight: bold;
	border: 1px solid orange;
	max-width: 240px;
	min-width: 30px;
	border-radius: 8px;
	-moz-border-radius: 8px;	
	-khtml-border-radius: 8px;
	-webkit-border-radius: 8px;
	box-shadow: rgba(40,20,0,.66) 0px 0px 8px;
	-moz-box-shadow: rgba(40,20,0,.66) 0px 0px 8px;
	-webkit-box-shadow: rgba(40,20,0,.66) 0px 0px 8px;
	user-select: none;
	-moz-user-select: none;
	-khtml-user-select: none;
	-webkit-user-select: none;
	z-index: 100;
}

</style>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$set['game_name']} - Massive Multiplayer Online Role Playing Game </title>
<meta name="keywords" content="RPG, Online Games, Online Mafia Game" />
<meta name="description" content=" {$set['game_name']} - Online Mafia Game " />
<meta name="author" content="Mafia Game Scripts " />
<meta name="copyright" content="Copyright {$_SERVER['HTTP_HOST']} " />
<link rel="SHORTCUT ICON" href="favicon.ico" />
		         <script src="js/jquery-1.js" type="text/javascript"></script>
		        <script src="http://www.sunsean.com/idTabs/jquery.idTabs.min.js" type="text/javascript"></script>
		        <link rel="stylesheet" href="css/styleold.css" type="text/css" />
      		         <link rel="stylesheet" href="css/stylenew.css" type="text/css" />
		         {$special_page}

	<script type="text/javascript">
	function AjaxUpdateUserStats(){
		$.getJSON("ajax.php", { do: "userStats" },function(data2){
			UpdateUserStats(data2);
   		});
	}
	function UpdateUserStats(user){
		var enperc=Math.floor(user.energy/user.maxenergy*100);
		var wiperc=Math.floor(user.will/user.maxwill*100);
		var experc=Math.floor( user.exp/user.exp_needed*100);
		var brperc=Math.floor(user.brave/user.maxbrave*100);
		var hpperc=Math.floor(user.hp/user.maxhp*100);
		$("#energyBar").width(enperc+"%");
		$("#willBar").width(wiperc+"%");
		$("#braveBar").width(brperc+"%");
		$("#expBar").width(experc+"%");
		$("#hpBar").width(hpperc+"%");
		$("#energyAmount").html(enperc);
		$("#willAmount").html(wiperc);
		$("#braveAmount").html(user.brave);
		$("#braveMaxAmount").html(user.maxbrave);
		$("#expAmount").html(experc);
		$("#hpAmount").html(hpperc);
		$("#user_money").html(user.moneyFormat);
		$("#user_level").html(user.level);
		$("#user_crystals").html(user.crystalsFormat);
	}
	</script>
	<script type="text/javascript" src="js/ncode_imageresizer.js"></script>
	<script type="text/javascript" src="js/header.js"></script>
	<style type="text/css">
		.boston a{
		background:url(images/boston.jpg) no-repeat;
	}
	.boston a:hover{
		background:url(images/boston_hover.jpg) no-repeat;
	}
	</style>
</head>
<body id="sub" class="yui-skin-sam">





<div id="dhtmltooltip"></div>

<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

var offsetxpoint=10 //Customize x offset of tooltip
var offsetypoint=15 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}

document.onmousemove=positiontip

</script>








<div id="invimgtemp" style="display:none;position:absolute;top:0px;left:0px;z-index:5000;height:81px;width:82px;margin:0;padding-top:6px;">&nbsp;</div>
<div id="invactions" style="display:none;position:absolute;top:0px;left:0px;z-index:3000;height:50px;width:250px;background:#000;border:1px solid #F7C942;padding:10px;">&nbsp;</div>
<div id="pagecontainer">
<!-- Header Part Starts -->
<div class="headerpart">

<div class="onlinegame"></div>
<div class="toplist">

</div>
</div>



<!-- //Header Part End -->  

<!-- Inner Page Top Starts -->

<div class="innertopbg">
<div class="toprow1">
<div class="toprow1_col1">
<div class="logo"><a href="index.php"><img src="images/logo.jpg" alt="Logo"/></a></div>
<div class="needbtn"></div>        
<div class="top_leftbtn">
<div class="leftbtn1"> 



</div>
<div class="leftbtn2"> 

</div>

</div>
</div>
<div class="toprow1_col2">
<div class="tot_txt">{$lang(_TOTAL_MOBSTERS)}:&nbsp;&nbsp;<span>$membs</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$lang(_ONLINE_NOW)}: <span>$online</span></div>
<div class="messagepart">
<div class="message_txt"><a href="mailbox.php" style="color:#fff;"><span>($mc)</span> {$lang(_MESSAGES)}</a></div>

<div class="event_txt"><a href="events.php" style="color:#fff;"><span>($ec)</span> {$lang(_EVENTS)}</a></div> </div>  <br/>
<div class="messagepart" id="points_money">
<div class="point_txt">{$lang(_CRYSTALS)}:&nbsp;<span> $crystals </span><br/></div>
<div class="gold_txt">{$lang(_MONEY)}:&nbsp;<span>$money</span></div>

</div>              
</div>
</div>
<!-- Menu Part Starts -->
<div class="toprow2">
<div><img src="images/menu_left.jpg" alt="" /></div>
<div class="menu_md">
<ul>
<li class="ihome_active"><a href="index.php"></a></li>

<li class="gym"><a href="gym.php">&nbsp;</a></li>
<li class="news"><a href="newspaper.php">&nbsp;</a></li>
<li class="forum"><a href="forums.php">&nbsp;</a></li>
<li class="boston"><a href="explore.php">&nbsp;</a></li>
<li class="protect"><a href="bodyguard.php">&nbsp;</a></li>
<li class="logout"><a href="logout.php">&nbsp;</a></li>                            
</ul>                        
</div>
<div><img src="images/menu_right.jpg" alt="" /></div>
</div>            
<!-- //Menu Part End -->

</div>  

<!-- //Inner Page Top End -->


<div class="toprow2">
<div><img src="images/menu_left.jpg" alt="" /></div>
<div class="menu_md">


<br/>


<h2 class="headerpart1a"><span class='text2 title4'>Support {$set['game_name']} <a href='donator.php'>Donate</a> | <a href='willpotion.php'>Will Potion</a></span></h2>



</div><div><img src="images/menu_right.jpg" alt="" /></div>
</div>  </div><br/> 
<br/> <br/><br/>    

<div class="gymbg">
<div id="centercontainer">

<div id="centermaincontainer">

<!-- Center Part Starts -->
                    <div class="icenterpart"><div class="icolumn1">



EOF;
}
function userdata($ir,$lv,$fm,$cm,$dosessh=1)
{
global $db,$c,$userid, $set,$userStatsHide;
$IP = $_SERVER['REMOTE_ADDR'];
$IP=addslashes($IP);
$IP=mysql_real_escape_string($IP);
$IP=strip_tags($IP);
$db->query("UPDATE users SET laston=unix_timestamp(),lastip='$IP' WHERE userid=$userid");
$_GET['ID'] = abs(@intval($_GET['ID']));
$_GET['reply'] = abs(@intval($_GET['reply']));


if(!$ir['email'])
{
global $domain;
die ("<body>Your account may be broken. Please mail help@{$domain} stating your username and player ID.");
}
if($dosessh && ($_SESSION['attacking'] || $ir['attacking']))
{
print "<CENTER><P><b><font color=red>You lost all your EXP for running from the fight.</font></b></P></CENTER> <br/><br/>";
$db->query("UPDATE users SET exp=0,attacking=0 WHERE userid=$userid");
$_SESSION['attacking']=0;
}
$enperc=(int) ($ir['energy']/$ir['maxenergy']*100);
$wiperc=(int) ($ir['will']/$ir['maxwill']*100);
$experc=(int) ( $ir['exp']/$ir['exp_needed']*100);
$brperc=(int) ($ir['brave']/$ir['maxbrave']*100);
$hpperc=(int) ($ir['hp']/$ir['maxhp']*100);
$enopp=100-$enperc;
$wiopp=100-$wiperc;
$exopp=100-$experc;
$bropp=100-$brperc;
$hpopp=100-$hpperc;
$d="";
$u=$ir['username'];
if($ir['donatordays']) { $u = "<font color=green>{$ir['username']}</font>";$d="<img src='donator.gif' alt='Donator: {$ir['donatordays']} Days Left' title='Donator: {$ir['donatordays']} Days Left' />"; }

$gn=""; 
global $staffpage;

$bgcolor = 'FFFFFF';     

include "travellingglobals.php";

if($ir['fedjail'])
{
$q=$db->query("SELECT * FROM fedjail WHERE fed_userid=$userid");
$r=$db->fetch_row($q);
die(" <br /><br /><br /><br /><br /> <CENTER><P> <b><font color=red size=+1>"._FED_JAIL1." {$set['game_name']} "._FED_JAIL2." {$r['fed_days']} "._DAY."(s).<br /> <br />
"._REASON.": {$r['fed_reason']}</font></b> </P></CENTER> </body></html>"); 
}



if(file_exists('ipbans/'.$IP))
{
die("<br /><br /><br /><br /><br /><CENTER><P><b><font color=red size=+1>Your IP has been banned from {$set['game_name']}, there is no way around this.</font></b></P></CENTER></body></html>");
}

?><!-- Begin Main Content -->     
<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">    
 <tr valign="top">
  <td width="181">
   <table width="181" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td class="text2 height:40px;">
      <table width="181" border="0" cellspacing="0" cellpadding="0">
      </table>
     </td>
    </tr>
   </table>
<?
if(!$userStatsHide){
?>
<div class="profilepart" id="profilepart">
	<div class="profiletxt"><p><img src="images/profile_txt.jpg" alt="" /></p></div>
	<div class="profile_mid">
		<div class="profile_con">
			<div class="gunimg"><img alt="User Pic" src="<?=htmlspecialchars($ir['display_pic']);?>" width="75" height="75" /></div>
			<div class="guntxt">
				<b><a href="viewuser.php?u=<?=$ir['userid'];?>"> <?=$gn.$u;?> </a> <?=$d;?> </b><br/>
				<span><?=_CLASS;?>:</span> <?=$GLOBALS['settings']['CLASS_NAME'][$ir['class']];?><br/>
				<span><?=_MONEY;?>:</span> <span id="user_money" style="color:#FFFFFF;"><?=$fm;?></span><br/>
				<span><?=_LEVEL;?>:</span> <span id="user_level" style="color:#FFFFFF;"><?=$ir['level'];?></span> <br/>
				<span><?=_CRYSTALS?>:</span> <span id="user_crystals" style="color:#FFFFFF;"><?=$cm;?></span> <br/>

			</div>
		</div>                    
		<div class="energypart">
			<div class="energytxt"><?=_ENERGY;?>:</div>
			<div class="energyrate"><span id="energyAmount"><?=$enperc;?></span>%</div>
			<div class="energyimg" style="background: transparent url(images/exp_img.jpg) scroll repeat-x 0 0; height:15px; text-align: left; width: 94px; padding: 0px;white-space: nowrap;"><img id="energyBar" alt="" src="images/energy_img.jpg" style="padding-top:1px;width:<?=$enperc;?>%;"  height="15px" border="0" /></div>
		</div>		
		<div class="energypart">
			<div class="energytxt"><?=_WILL;?>:</div>
			<div class="energyrate"><span id="willAmount"><?=$wiperc;?></span>%</div>
			<div class="energyimg" style="background: transparent url(images/exp_img.jpg) scroll repeat-x 0 0; height:15px; text-align: left; width: 94px; padding: 0px;white-space: nowrap;"><img id="willBar" alt="" src="images/energy_img.jpg" style="padding-top:1px;width:<?=$wiperc;?>%;"  height="15px" border="0" /></div>
		</div>		
		<div class="energypart">
			<div class="energytxt"><?=_BRAVE;?>:</div>
			<div class="energyrate"><span id="braveAmount"><?=$ir['brave'];?></span>/<span id="braveMaxAmount"><?=$ir['maxbrave'];?></span></div>
			<div class="energyimg" style="background: transparent url(images/exp_img.jpg) scroll repeat-x 0 0; height:15px; text-align: left; width: 94px; padding: 0px;white-space: nowrap;"><img id="braveBar" alt="" src="images/energy_img.jpg" style="padding-top:1px;width:<?=$brperc;?>%;" height="15px" border="0" /></div>
		</div>
		<div class="energypart">
			<div class="energytxt"><?=_EXP;?>:</div>
			<div class="energyrate"><span id="expAmount"><?=$experc;?></span>%</div>
			<div class="energyimg" style="background: transparent url(images/exp_img.jpg) scroll repeat-x 0 0; height:15px; text-align: left; width: 94px; padding: 0px;white-space: nowrap;"><img id="expBar" alt="" src="images/energy_img.jpg" style="padding-top:1px;width:<?=$experc;?>%;" height="15px" border="0" /></div>
		</div>
		<div class="energypart">
			<div class="energytxt"><?=_HEALTH;?>:</div>
			<div class="energyrate"><span id="hpAmount"><?=$hpperc;?></span>%</div>
			<div class="energyimg" style="background: transparent url(images/exp_img.jpg) scroll repeat-x 0 0; height:15px; text-align: left; width: 94px; padding: 0px;white-space: nowrap;"><img id="hpBar" alt="" src="images/energy_img.jpg" style="padding-top:1px;width:<?=$hpperc;?>%;" height="15px" border="0" /></div>
		</div>		
	</div>
</div>
<div><img src="images/profile_btm.gif" alt="" /></div>    
<?}
}

function menuarea()
{
if(!$menuhide)
include "mainmenu.php";
global $ir,$c;
$bgcolor = '000000';
print '</td><td width="2" class="linegrad" bgcolor="#'.$bgcolor.'">&nbsp;</td><td width="80%"  bgcolor="#'.$bgcolor.'" valign="top"><center>';

if($ir['hospital'])
{
print "<font color='red'><b>"._NOTE.":</b></font> "._CURRENTLY_IN." "._HOSPITAL." "._FOR." {$ir['hospital']} "._MINUTES.".<br/><br />";
}
if($ir['jail'])
{
print "<font color='red'><b>"._NOTE.":</b></font> "._CURRENTLY_IN." "._JAIL." "._FOR." {$ir['jail']} "._MINUTES.".<br/><br />";
}

if($ir['traveltime'] > 0)
{
print "<font color = 'red' /><b>"._TRAVELLING." <b>{$ir['traveltime']} "._MINUTES."</b>.</font><br /><br />";
} 

if($ir['bguard'] >0)
{
print "<font color='green'><b>"._NOTE.":</b></font>"._BODYGUARD_PROTECT1."  {$ir['bguard']} "._BODYGUARD_PROTECT2.".<br/><br/>";
}

print("<div id='ajaxResponseContainer'></div>");
}
function smenuarea()
{
include "smenu.php";
global $ir,$c;
$bgcolor = '000000';
print '</td><td width="2" class="linegrad" bgcolor="#'.$bgcolor.'"> &nbsp; </td><td width="80%"  bgcolor="#'.$bgcolor.'" valign="top"><center>';
}
function endpage()
{
global $db;



include "footer.php";


}    
} 
?>
