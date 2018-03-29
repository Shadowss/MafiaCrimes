<?php
// Report all PHP errors (see changelog)
error_reporting(E_ALL);

$disable = 1;
include "globals.php";
function json_error($msg){
	$array = array("failed" => $msg);
	die(json_encode($array));
}

if(!isset($_GET['do']))
	die("failed! unknown action");
$do = $_GET['do'];


$_GET['ID'] = isset($_GET['ID']) && is_numeric($_GET['ID']) ? abs(@intval($_GET['ID'])) : false;

if(!$_GET['ID'])
	json_error("Invalid Command, Try Again Later.");
else if($_GET['ID'] == $userid)
	json_error("<center>Only the crazy attack themselves.");
else if ($ir['hp'] <= 1)
	json_error("Only the crazy attack when their unconscious.");
else if ($_SESSION['attacklost'] == 1){
	$_SESSION['attacklost']=0;
	json_error("Only the losers of all their EXP attack when they've already lost.");
}
$youdata=$ir;
$sql = sprintf("SELECT u.*,us.* FROM users u LEFT JOIN userstats us ON u.userid=us.userid WHERE u.userid=%s", $_GET['ID']);
$q=$db->query($sql);
$odata=$db->fetch_row($q);
$nextstep = 0+$_GET['nextstep'];
if(!$nextstep)
	$nextstep = 2;

$response = array("failed" => false, "msg" => false,"youhp" => $youdata["hp"], "ohp" => $odata["hp"],"nextstep" => $nextstep);
$myabbr=($ir['gender']=="Male") ? "his" : "her";
$oabbr=($ir['gender']=="Male") ? "his" : "her";
if($ir['attacking'] && $ir['attacking'] != $_GET['ID']){
	$_SESSION['attacklost']=0;
	json_error("Your already in a fight, but some reason cant get back to it... <br /> Please wait 1 hour (game time) then you can attack players again.");
}
if($odata['hp'] == 1){
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	json_error("Unable! This player is unconscious.");
}
$hospit = rand(10,30);
if($odata['bguard'] >0){
	$response["msg"] = " <center><b><font color='#FFFF00'>Holy Shit!</b></font> You Just Got Your Ass Kicked By The Bodygaurd!! You were injured and taken to the hspital for $hospit min<br/><br/><a href='index.php'>>Home</a></center>";
	$response["youhp"] = 0;
	$db->query("UPDATE users SET hp=0, hospital=hospital+$hospit, hospreason='Beaten Severely By Someones Personal Bodyguard' WHERE userid=$userid",$c);
	die(json_encode($response));
}
if($_GET['nextstep'] > 100){
	$response["msg"] = "<center><h2><font color='red'>STALEMATE!</h2>
		<a href='index.php'>> Go Back <</a></center>";
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	event_add($odata['userid'],"<a href='viewuser.php?u=$userid'>{$youdata['username']}</a> Tried to beat you but stalemated.",$c);
	event_add($youdata['userid']," You Tried to beat <a href='viewuser.php?u={$odata['userid']}'>{$odata['username']}</a> but stalemated.",$c);
	die(json_encode($response));
}else if($odata['hospital']){
	$response["msg"] = "<center>This player is in hospital.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die(json_encode($response));
}else if($ir['hospital']){
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	json_error("<center>While in hospital you can't attack.
		<br><a href='index.php'>> Go Back <</a>");
}else if($odata['jail']){
	$response["msg"] ="<center>This player is in jail.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die(json_encode($response));
}else if($ir['jail']){
	$response["msg"] = "<center>While in jail you can't attack.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die(json_encode($response));
}else if($odata['travelling']){
	$response["msg"] = "<center>That player is travelling.
		<br><a href='index.php'>> Go Back <</a>";
	$_SESSION['attacking']=0;
	$ir['attacking']=0;
	$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
	die(json_encode($response));
}else if ($youdata['location'] != $odata['location']){
	$response["msg"] = "<center>You can only attack someone in the same location!
		<br><a href='index.php'>> Go Back <</a>";
	die(json_encode($response));
}else if ($odata['maxhp']/$odata['hp'] <0.5){
	$response["msg"] = "<center>You can only attack those who have atleast 50% health !
		<br><a href='index.php'>> Go Back <</a>";
	die(json_encode($response));
}else if ($ir['gang'] == $odata['gang'] && $ir['gang'] > 0){
	$response["msg"] = "<center>You are in the same gang as {$odata['username']}!<br>Why would you attack someone in your gang?!
		<br><a href='index.php'>> Go Back <</a>";
	die(json_encode($response));
}else if ($ir['equip_primary'] == 0){
	$response["msg"] = "<center>You need a Primary Weapon to attack...<br><a href='index.php'>> Go Back <</a>";
	die(json_encode($response));
} 



	if($_SESSION['attacking']==0 && $ir['attacking'] == 0){
		if ($youdata['energy'] >= $youdata['maxenergy']/2){
			$youdata['energy']-= floor($youdata['maxenergy']/2);
			$me=floor($youdata['maxenergy']/2);
			$db->query("UPDATE users SET energy=energy- {$me} WHERE userid=$userid");
			$_SESSION['attacklog']="";
			$_SESSION['attackdmg']=0;
		}else{
			print "You can only attack someone when you have 50% energy";
			exit;
		}
	}
	$_SESSION['attacking']=1;
	$ir['attacking']=$odata['userid'];
	$db->query("UPDATE users SET attacking={$ir['attacking']} WHERE userid=$userid");
	$_GET['nextstep'] = (int) $_GET['nextstep'];
	//damage
	if($ir['equip_primary'] == 0 && $ir['equip_secondary'] == 0){
		$db->query("UPDATE users SET exp=0 where userid=$userid",$c);
		json_error("Stop trying to abuse a game bug. You can lose all your EXP for that.<br />
			<a href='index.php'>&gt; Home</a>");
	}
	$primary = false;
	$secondary = false;
	$mydamage2 = $mydamage1 = 0;
	if($ir['equip_primary'] != 0){
		$qo1=$db->query("SELECT i.* FROM items i   WHERE i.itmid={$ir['equip_primary']}");
		$r11=$db->fetch_row($qo1);
		$mydamage1=(int) (($r11['weapon']*$youdata['strength']/($odata['guard']/1.5))*(rand(8000,12000)/10000));
		$primary = true;
	}

	if($ir['equip_secondary'] != 0){
		$qo2=$db->query("SELECT i.* FROM items i   WHERE i.itmid={$ir['equip_secondary']}");
		$r12=$db->fetch_row($qo2);
		$mydamage2=(int) (($r12['weapon']*$youdata['strength']/($odata['guard']/1.5))*(rand(8000,12000)/10000));
		$secondary = true;
	}
	$mydamage = $mydamage1 + $mydamage2;
	$realdamage1 = $mydamage1;
	$realdamage2 = $mydamage2;
	$hitratio=max(10,min(60*$ir['agility']/$odata['agility'],95));
	if(rand(1,100) <= $hitratio ){
		$q3=$db->query("SELECT i.armor FROM items i   WHERE itmid={$odata['equip_armor']} ORDER BY rand()");
		if($db->num_rows($q3)){
			$armor = $db->fetch_single($q3);
			$mydamage-=$armor;
			if($mydamage1>$armor/2)
				$mydamage1-=round($armor/2);
			else
				$mydamage1 = 0;
			if($mydamage2>$armor/2)
				$mydamage2-=round($armor/2);
			else
				$mydamage2 = 0;
		}
		if($mydamage < -100000) { 
			$mydamage=abs($mydamage);
		}
		if($mydamage1 < -100000) { 
			$mydamage1=abs($mydamage1);
		}
		if($mydamage2 < -100000) { 
			$mydamage2=abs($mydamage2);
		}
		if($mydamage < 1) { 
			$mydamage=1; 
		}
		$critical = false;
		$crit=rand(1,40);
		if($crit==17) { $mydamage*=rand(20,40)/10; $critical=true;} else if($crit==25 or $crit == 8) { $mydamage/=(rand(20,40)/10); $critical=true;} 
		$mydamage=round($mydamage);
		$odata['hp']-=$mydamage;
		if($odata['hp']==1) { $odata['hp']=0;$mydamage+=1; }
		$db->query("UPDATE users SET hp=hp-$mydamage WHERE userid={$_GET['ID']}");
		$response['ohp'] = $odata['hp'];
		$response['msg'] = ($primary ? "<table><tr><th>Round {$_GET['nextstep']}</th></tr><tr><td class='green'>Using your {$r11['itmname']} you hit {$odata['username']} doing $mydamage1 damage." : "").($secondary ? (!$primary ? "<table><tr><th>Round {$_GET['nextstep']}</th></tr><tr><td class='green'>" :"")." Using your {$r12['itmname']} you hit {$odata['username']} doing $mydamage2 damage. ({$odata['hp']})" : "" ).($critical ? " You are a lucky: one of your weapons hit a vital organ generating a total damage of ".$mydamage."." :"");
		$_SESSION['attackdmg']+=$mydamage;
		$_SESSION['attacklog'].="<font color=red>{$_GET['nextstep']}. Using {$myabbr} {$r1['itmname']} {$ir['username']} hit {$odata['username']} doing $mydamage damage ({$odata['hp']})</font><br />\n";
	}else{
		$response['msg'] = "<table><tr><th>Round {$_GET['nextstep']}</th></tr><tr><td class='red'>You tried to hit {$odata['username']} but missed ({$odata['hp']})\n";
		$_SESSION['attacklog'].="<font color=red>{$_GET['nextstep']}. {$ir['username']} tried to hit {$odata['username']} but missed ({$odata['hp']})</font><br />\n";
	}
	if($odata['hp'] <= 0){
		$response['ohp']=0;
		$odata['hp']=0;
		$_SESSION['attackwon']=$_GET['ID'];
		$db->query("UPDATE users SET hp=0 WHERE userid={$_GET['ID']}");
		$response['msg'] = $response['msg']."<br /> 
			<b>What do you want to do with {$odata['username']} now?</b><br /><br />
			<form action='attackwon.php?ID={$_GET['ID']}' method='post'><input type='submit' STYLE='color: white;  background-color: red;' value='Mug Them' />  </form>  <br />  
			<form action='attackbeat.php?ID={$_GET['ID']}' method='post'><input type='submit' STYLE='color: white;  background-color: green;' value='Hospitalize Them' />  </form>  <br /> 
			<form action='attacktake.php?ID={$_GET['ID']}' method='post'><input type='submit' STYLE='color: black;  background-color: white;' value='Leave Them' /> </form>  <br /> 
			<br /> 
			NB:If you not choose any of the option above you lose all your EXP point !  <br /> <br />   
			If you and the enemy beaten are on the same battle ladder mug them to get points added to the ladder table !  
			</td></tr></table>
		";
	}else {
		//choose opp gun
		$eq=$db->query("SELECT i.* FROM  items i  WHERE i.itmid IN({$odata['equip_primary']}, {$odata['equip_secondary']})");
		if(mysql_num_rows($eq) == 0){
			$wep="Fists";
			$dam=(int)((((int) ($odata['strength']/$ir['guard']/100)) +1)*(rand(8000,12000)/10000));
		}else{
			$cnt=0;
			while($r=$db->fetch_row($eq)){
				$enweps[]=$r;
				$cnt++;
			}
			for($weptouse=0;$weptouse<$cnt;$weptouse++){
				$wep=$wep." ".$enweps[$weptouse]['itmname'].", ";
				$dam+=(int) (($enweps[$weptouse]['weapon']*$odata['strength']/($youdata['guard']/1.5))*(rand(8000,12000)/10000));
			}
		}
		$hitratio=max(10,min(60*$odata['agility']/$ir['agility'],95));
		if(rand(1,100) <= $hitratio){
			$q3=$db->query("SELECT i.armor FROM items i   WHERE itmid={$ir['equip_armor']} ORDER BY rand()");
			if($db->num_rows($q3)){
				$dam-=$db->fetch_single($q3);
			}
			if($dam < -100000) { $dam=abs($dam); }
			else if($dam < 1) { $dam=1; }
			$crit=rand(1,40);
			if($crit==17) { $dam*=rand(20,40)/10; } else if($crit==25 or $crit == 8) { $dam/=(rand(20,40)/10); } 
			$dam=round($dam);
			$youdata['hp']-=$dam;
			$response['youhp'] = $youdata['hp'];
			if ($youdata['hp']==1) { $dam+=1; $youdata['hp']=0; $response['youhp'] = $youdata['hp'];}
			$db->query("UPDATE users SET hp=hp-$dam WHERE userid=$userid");
			$ns=$_GET['nextstep']+1;
			$response['msg'] = $response['msg']."<br /><span class='red'>Using $oabbr $wep {$odata['username']} hit you doing $dam damage ({$youdata['hp']})</span><br />\n";
			$_SESSION['attacklog'].="<font color=blue>{$ns}. Using $oabbr $wep {$odata['username']} hit {$ir['username']} doing $dam damage ({$youdata['hp']})</font><br />\n";
		}else{
			$ns=$_GET['nextstep']+1;
			$response['msg'] = $response['msg']."<br /><span class='gold'>{$odata['username']} tried to hit you but missed ({$youdata['hp']})</span><br />\n";
			$_SESSION['attacklog'].="<font color=blue>{$ns}. {$odata['username']} tried to hit {$ir['username']} but missed ({$youdata['hp']})</font><br />\n";
			$response['youhp'] = $youdata['hp'];
		}
		if($youdata['hp'] <= 0){
			$youdata['hp']=0;
			$response['youhp'] = 0;
			$_SESSION['attacklost']=1;
			$db->query("UPDATE users SET hp=0 WHERE userid=$userid");
			$response['msg'] = $response['msg']."<form action='attacklost.php?ID={$_GET['ID']}' method='post'><input type='submit' STYLE='color: black;  background-color: white;' value='Continue' />";
		}
		$response['msg'] = $response['msg']."</td></tr></table>";
		die(json_encode($response));
	}
		die(json_encode($response));

?>
