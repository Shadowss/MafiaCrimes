<?php
// Report all PHP errors (see changelog)
error_reporting(E_ALL);
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

$special_page = '<link rel="stylesheet" href="css/attack.css" type="text/css" />
';
$menuhide=1;
$userStatsHide=1;
$atkpage=1;
include "globals.php";

$_GET['ID'] = isset($_GET['ID']) && is_numeric($_GET['ID']) ? abs(@intval($_GET['ID'])) : false;
if(!$_GET['ID']){
	print "<font color=white>Invalid Command, Try Again Later.
		<br><a href='index.php'>> Go Back <</a>";
	die();
}else if($_GET['ID'] == $userid){
	print "<center>Only the crazy attack themselves.
		<br><a href='index.php'>> Go Back <</a>";
	die();
}else if ($ir['hp'] <= 1){
	print "<center>Only the crazy attack when their unconscious.
		<br><a href='index.php'>> Go Back <</a>";
	die();
}else if ($_SESSION['attacklost'] == 1){
	print "<center>Only the losers of all their EXP attack when they've already lost.
		<br><a href='index.php'>> Go Back <</a>";
		$_SESSION['attacklost']=0;
		die();
}
//get player data
$youdata=$ir;
$sql = sprintf("SELECT u.*,us.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.userid=%s", $_GET['ID']);
$q=$db->query($sql);
$odata=$db->fetch_row($q);
$myabbr=($ir['gender']=="Male") ? "his" : "her";
$oabbr=($ir['gender']=="Male") ? "his" : "her";
if($ir['attacking'] && $ir['attacking'] != $_GET['ID']){
	print "<center>Your already in a fight, but some reason cant get back to it...<br />Please wait 1 hour (game time) then you can attack players again.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacklost']=0;
	die();
}
if($odata['hp'] <= 1){
	print "<center>This player is unconscious.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die();
}
$hospit = rand(10,30);
if($odata['hospital']){
	print "<center>This player is in hospital.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die();
}else if($ir['hospital']){
	print "<center>While in hospital you can't attack.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die();
}else if($odata['jail']){
	print "<center>This player is in jail.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die();
}else if($ir['jail']){
	print "<center>While in jail you can't attack.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die();
}else if($odata['travelling']){
	print "<center>That player is travelling.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die();
}else if ($youdata['location'] != $odata['location']){
	print "<center>You can only attack someone in the same location!
		<br><a href='index.php'>> Go Back <</a>";
	die();
}else if ($odata['hp'] < $odata['hp']/2){
	print "<center>You can only attack those who have atleast 50% health !
		<br><a href='index.php'>> Go Back <</a>";
	die();
}else if ($ir['gang'] == $odata['gang'] && $ir['gang'] > 0){
	print "<center>You are in the same gang as {$odata['username']}!<br>Why would you attack someone in your gang?!
		<br><a href='index.php'>> Go Back <</a>";
	die();
}else if ($ir['equip_primary'] == 0){
	print "<center>You need a Primary Weapon to attack...<br><a href='index.php'>> Go Back <</a>";
	
	die();
} 



print "<table width=100%><tr><td colspan=2 align=center>";
if ($ir['energy'] < $ir['maxenergy']/2){
	print "You can only attack someone when you have 50% energy";
	
	die();
}
print "</td></tr>";
if($youdata['hp'] <= 0 || $odata['hp'] <= 0){
	print "</table>";
}else{
	$vars['hpperc']=round($youdata['hp']/$youdata['maxhp']*100);
	$vars['hpopp']=100-$vars['hpperc'];
	$vars2['hpperc']=round($odata['hp']/$odata['maxhp']*100);
	$vars2['hpopp']=100-$vars2['hpperc'];
	$mw=$db->query("SELECT i.* FROM  items i  WHERE i.itmid IN({$ir['equip_primary']}, {$ir['equip_secondary']})");
	//print "<tr><td colspan=2 align='center'>Attack with:<br />";
	if($db->num_rows($mw) > 0){
		while($r=$db->fetch_row($mw)){
			if(!$_GET['nextstep']) { $ns=1; } else { $ns=$_GET['nextstep']+2; }
			if($r['itmid']==$ir['equip_primary']){
			//	print "<b>Primary Weapon:</b> ";
			}
			if($r['itmid']==$ir['equip_secondary']){
			//	print "<b>Secondary Weapon:</b> ";
			}
			//print "<a href='attack.php?nextstep=$ns&amp;ID={$_GET['ID']}&amp;wepid={$r['itmid']}'>{$r['itmname']}</a><br />";
		}
	}else{
		print "You have nothing to fight with.";
		
		die();
	}
	print "</table>";
}
?>




<script>
var youmaxhp = <? echo $youdata['maxhp'];?>;
var omaxhp = <? echo $odata['maxhp'];?>;
var step = 1;
var stop=false;
function attack(id,auto){
	if(stop){
		if(!auto)
			$('#output').prepend("<table><tr><th>Impossible!</th></tr><tr><td>You ran away from the fight!</td></tr></table>");
		return false;
	}
	$.ajax({
		url: "ajax.php",
		data: {do: "attack", nextstep:step,ID:id},
		async: false,
		cache: false,
		success:function(r){
			//alert(r);
			eval("var resp = "+r);
			if(resp.failed){
				$('#output').prepend('<h3>'+resp.failed+'</h3>');
				return false;
			}
			$('#output').prepend(resp.msg);
			step++;
			$('#us_hp').html(''+resp.youhp+'');		
			$('#them_hp').html(''+resp.ohp+'');		
			$('#us_hp_img').width(resp.youhp/youmaxhp*100);		
			$('#them_hp_img').width(resp.ohp/omaxhp*100);
			if(auto && resp.youhp && resp.ohp)
				setTimeout('attack('+id+',true)',100);
		}
	}); 
}
function escape(id){
	if(stop)
		return false;
	stop=true;
	$.ajax({
		url: "ajax.php",
		data: {do: "runaway", ID:id},
		async: false,
		cache: false,
		success:function(r){
			//alert(r);
			eval("var resp = "+r);
			if(resp.failed){
				$('#output').prepend('<h3>'+resp.failed+'</h3>');
				return false;
			}
			$('#output').prepend(resp.msg);
		}
	}); 
}</script>

	<div id="attackPage" style="min-height: 400px;">
		<p><a href="index.php" style="color:#ffffff;">Click here to go back to the game.</a></p>
		<div class="help_tutorial">
			<table>
				<tbody><tr valign="top">
					<td rowspan="2" class="playerIMG" valign="top">
					<img style="padding-bottom: 8px" src="<?=htmlspecialchars($youdata['display_pic'])?>" alt="Display picture" height="130px">
					<img id="us_image" src="./images/characters/char<?=$youdata['class']?>_body.jpg" alt="Player class image">
					</td>
					<td class="playerData">
					<h3><?=$youdata['username'];?></h3>
					<div class="healthBar">
						<div id="us_hp_img" style="width: <?=$vars['hpperc'];?>px"></div>
					</div>
					<p><span id="us_hp"><?=$youdata['hp']?></span> / <?=$youdata['maxhp']?></p>
					</td>
					<td valign="middle" align="center">
					<p><button type="button" tabindex="0" id="doAttack-button" onclick="attack(<? echo($_GET['ID']);?>,false)">Attack</button></p>
					<p><button type="button" tabindex="0" id="doAutoAttack-button" onclick="attack(<? echo($_GET['ID']);?>,true)">Auto Attack</button></p>
					<p><button type="button" tabindex="0" id="doRun-button" onclick="escape(<? echo($_GET['ID']);?>);">Run away</button></p>
					</td>
					<td class="playerData second">
					<h3><?=$odata['username'];?></h3>
					<div class="healthBar">
						<div id="them_hp_img" style="width: <?=$vars2['hpperc'];?>px"></div>
					</div>
					<p><span id="them_hp"><?=$odata['hp'];?></span> / <?=$odata['maxhp']?></p>
					
					</td>
					<td rowspan="2" class="playerIMG" valign="top">
					<img style="padding-bottom: 8px" src="<?=htmlspecialchars($odata['display_pic'])?>" alt="Display picture" height="130px">
					<img id="them_image" src="./images/characters/char<?=$odata['class']?>_body.jpg" alt="Player class image">
					</td>
				</tr>
				<tr>
					<td colspan="3" valign="top">
					<div id="output">
					<h3>You search out and find <?=$odata['username']?>! Let's do this!.</h3>
					
					</div>
					</td>
				</tr>
			</tbody></table>
		</div>
	</div>
<?



$h->endpage();
?>
