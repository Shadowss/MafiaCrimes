<?
$disable = 1;
include "globals.php";
function json_error($msg){
	$array = array("failed" => $msg);
	die(json_encode($array));
}
if(!isset($_GET['do'])&& !isset($_POST['do']))
	 json_error("Unknown action.");
if(isset($_GET['do']))
	$do = $_GET['do'];
else
	$do = $_POST['do'];

/***********************************/
/*************Crime**************/
/*********************************/
if($do == "crime"){
	if($ir['jail'] or $ir['hospital']) { die("This page cannot be accessed while in jail or hospital.");}
	print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
	$_GET['crimeID']=abs((int) $_GET['crimeID']);
	if(!$_GET['crimeID']){
		print "Invalid crime. <a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Close</a>";
	}
	else{
		$q=$db->query("SELECT * FROM crimes WHERE crimeID={$_GET['crimeID']}",$c);
		$r=$db->fetch_row($q);
		if($ir['level'] < $r['crimeLEVEL']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You do not have the required LEVEL to perform this crime. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($ir['labour'] < $r['crimeLABOUR']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You do not have enough LABOUR to perform this crime. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($ir['IQ'] < $r['crimeIQ']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You do not have enough IQ to perform this crime. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($ir['agility'] < $r['crimeAGILITY']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You do not have enough AGILITY to perform this crime. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($ir['strength'] < $r['crimeSTRENGTH']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You do not have enough STRENGTH to perform this crime. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($ir['guard'] < $r['crimeGUARD']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You do not have enough GUARD to perform this crime. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($ir['robskill'] < $r['crimeROBSKILL']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You do not have enough ROBSKILL to perform this crime. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($r['crimeITEM'] && $ir['equip_primary'] != $r['crimeITEM'] && $ir['equip_secondary'] != $r['crimeITEM'] && $ir['equip_armor'] != $r['crimeITEM']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You must equip the requested item. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($r['crimeCOURSE'] && $db->num_rows($db->query("SELECT * FROM coursesdone WHERE userid='".$ir['userid']."' AND courseid='".$r['crimeCOURSE']."'"))==0){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You haven't attended the required course. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else if($ir['brave'] < $r['crimeBRAVE']){
			print "
				<style type='text/css'>
				.style1 {
				    color: #FF0000;
				}
				</style>
				<body class='style1'>
				You do not have enough Brave to perform this crime. <br />[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]

				";
		}else{
			$ec="\$sucrate=".str_replace(array("LEVEL","CRIMEXP","EXP","WILL","IQ","XPCRIME"), array($ir['level'], $ir['crimexp'], $ir['exp'], $ir['will'], $ir['IQ'], $r['crimeXP']),$r['crimePERCFORM']).";";
			eval($ec);
			print $r['crimeITEXT'];
			$ir['brave']-=$r['crimeBRAVE'];
			mysql_query("UPDATE users SET brave={$ir['brave']} WHERE userid=$userid",$c);
			if(rand(1,100) <= $sucrate){
				print str_replace("{money}",$r['crimeSUCCESSMUNY'],$r['crimeSTEXT']);
				$ir['money']+=$r['crimeSUCCESSMUNY'];
				$ir['crystals']+=$r['crimeSUCCESSCRYS'];
				$ir['exp']+=(int) ($r['crimeSUCCESSMUNY']/8);
				mysql_query("UPDATE users SET money={$ir['money']}, crystals={$ir['crystals']}, exp={$ir['exp']},crimexp=crimexp+{$r['crimeXP']} WHERE userid=$userid",$c);
				if($r['crimeSUCCESSITEM']){
				  item_add($userid, $r['crimeSUCCESSITEM'], 1);
				}
				$db->query("INSERT INTO usercrimelog (userid,crimegroup) VALUES (".sqlesc($ir['userid']).",".sqlesc($r['crimeGROUP']).")");
			}else{	
				if(rand(1, 2) == 1){
					print $r['crimeFTEXT'];
					$db->query("INSERT INTO usercrimelog (userid,crimegroup,success) VALUES (".sqlesc($ir['userid']).",".sqlesc($r['crimeGROUP']).",'no')");
				}else{
					print $r['crimeJTEXT'];
  					$db->query("UPDATE `users` SET `jail` = '$r[crimeJAILTIME]', `jail_reason` = '$r[crimeJREASON]' WHERE `userid` = '$userid'");
					$db->query("INSERT INTO usercrimelog (userid,crimegroup,success) VALUES (".sqlesc($ir['userid']).",".sqlesc($r['crimeGROUP']).",'no')");
				}
			}
			print "<br />[<a href='javascript:void(0)' onclick='doCrime({$_GET['crimeID']}); return false;'>Try Again</a>]
				&nbsp;[<a href='javascript:void(0)'  onclick=\"$('#crime_process').html('');\">Try Another Crime</a>]";
		}
	}
	print("</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>");
}
/***********************************/
/********Load user stats********/
/*********************************/
else if($do == "userStats"){
	$fm=money_formatter($ir['money']);
	$cm=money_formatter($ir['crystals'],'');
	$ir['moneyFormat'] = $fm;
	$ir['crystalsFormat'] = $cm;
	die(json_encode($ir));
}
/***********************************/
/***********Equip item***********/
/*********************************/
else if($do == "equipitem"){
	$response = array("failed" => false,"change" => false);
	$_GET['ID'] = abs((int) $_GET['ID']);
	$id=$db->query("SELECT iv.*,it.* FROM inventory iv LEFT JOIN items it ON iv.inv_itemid=it.itmid WHERE iv.inv_id={$_GET['ID']} AND iv.inv_userid=$userid LIMIT 1");
	if($db->num_rows($id)==0){
		json_error("Bad item id: ".$_GET['ID']." !");
		
	}
	$r=$db->fetch_row($id);
	$position = $_GET['position'];
	$positions = array("equip_primary","equip_secondary","equip_armor");
	if(!in_array($position,$positions))
		json_error("unknown position: ".$position." !");
	if(($r['itmtype'] == 3)||($r['itmtype'] == 4)){
		if(($position == "equip_primary")||($position == "equip_secondary")){
			if(!$r['weapon'])
				json_error("unknown item!");
		}else
			json_error("illegal position: ".$position." !");
	}elseif($r['itmtype'] == 7){
		if($position == "equip_armor"){
			if(!$r['armor'])
				json_error("unknown item!");
		}else
			json_error("illegal position: ".$position." !");
	}
	if($ir[$position])
		item_add($userid, $ir[$position], 1);
	item_remove($userid, $r['itmid'], 1);
	if($ir[$position]){
		$res = $db->query("SELECT iv.*,i.*,it.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE iv.inv_userid={$userid} AND iv.inv_itemid={$ir[$position]}");
		$response["change"] = $db->fetch_row($res);
	}
	$r['inv_qty'] --;
	$response["equiped"] = $r;

	echo(json_encode($response));
	$db->query("UPDATE users SET {$position} = {$r['itmid']} WHERE userid={$userid}");
	die();
}
/***********************************/
/*********Unequip item**********/
/*********************************/
else if($do == "unequipitem"){
	$response = array("failed" => false,"item" => false);
	$position = $_GET['position'];
	$positions = array("equip_primary","equip_secondary","equip_armor");
	if(!in_array($position,$positions))
		json_error("unknown position: ".$position." !");
	if($ir[$position]){
		item_add($userid, $ir[$position], 1);
		$res = $db->query("SELECT iv.*,i.*,it.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE iv.inv_userid={$userid} AND iv.inv_itemid={$ir[$position]}");
		$response["item"] = $db->fetch_row($res);
	}
	echo(json_encode($response));
	$db->query("UPDATE users SET {$position} =0 WHERE userid={$userid}");
	die();
}
/***********************************/
/************Use item***********/
/*********************************/
else if($do == "useitem"){
	$_GET['ID'] = abs((int) $_GET['ID']);
	if(!$_GET['ID'])
		json_error("Invalid Use of the item !");
	$i=$db->query("SELECT iv.*,i.*,it.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE iv.inv_id={$_GET['ID']} AND iv.inv_userid=$userid");
	if(mysql_num_rows($i) == 0)
		json_error("Invalid item ID !");
	$r=$db->fetch_row($i);
	if(!$r['effect1_on'] && !$r['effect2_on'] && !$r['effect3_on'])
		json_error("Sorry, this item cannot be used as it has no effect");
	if($r['effect1_on']){
	  $einfo=unserialize($r['effect1']);
	  if($einfo['inc_type']=="percent"){
	    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
	       $inc=round($ir['max'.$einfo['stat']]/100*$einfo['inc_amount']);
	    else
	      $inc=round($ir[$einfo['stat']]/100*$einfo['inc_amount']);
	  }	
	  else
	    $inc=$einfo['inc_amount'];
	  if($einfo['dir']=="pos"){
	    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
		      $ir[$einfo['stat']]=min($ir[$einfo['stat']]+$inc, $ir['max'.$einfo['stat']]);
	    else
	      $ir[$einfo['stat']]+=$inc;
	  }
	  else
	      $ir[$einfo['stat']]=max($ir[$einfo['stat']]-$inc, 0);
	  $upd=$ir[$einfo['stat']];
	  if(in_array($einfo['stat'], array('strength', 'agility', 'guard', 'labour', 'IQ')))
	    $db->query("UPDATE `userstats` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
	  else
	    $db->query("UPDATE `users` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
	}	
	if($r['effect2_on']){
	  $einfo=unserialize($r['effect2']);
	  if($einfo['inc_type']=="percent"){
	    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
	      $inc=round($ir['max'.$einfo['stat']]/100*$einfo['inc_amount']);
	    else
	      $inc=round($ir[$einfo['stat']]/100*$einfo['inc_amount']);
	  }
	  else
	    $inc=$einfo['inc_amount'];
	  if($einfo['dir']=="pos"){
	    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
	      $ir[$einfo['stat']]=min($ir[$einfo['stat']]+$inc, $ir['max'.$einfo['stat']]);
	    else
	      $ir[$einfo['stat']]+=$inc;
	  }
	  else
	      $ir[$einfo['stat']]=max($ir[$einfo['stat']]-$inc, 0);
	  $upd=$ir[$einfo['stat']];
	  if(in_array($einfo['stat'], array('strength', 'agility', 'guard', 'labour', 'IQ')))
	    $db->query("UPDATE `userstats` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
	  else
	    $db->query("UPDATE `users` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");	
	}
	if($r['effect3_on']){
	  $einfo=unserialize($r['effect3']);
	  if($einfo['inc_type']=="percent"){
	    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
	      $inc=round($ir['max'.$einfo['stat']]/100*$einfo['inc_amount']);
	    else
	      $inc=round($ir[$einfo['stat']]/100*$einfo['inc_amount']);
	  }
	  else
	    $inc=$einfo['inc_amount'];
	  if($einfo['dir']=="pos"){
	    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
	      $ir[$einfo['stat']]=min($ir[$einfo['stat']]+$inc, $ir['max'.$einfo['stat']]);
	    else
	      $ir[$einfo['stat']]+=$inc;
	  }
	  else
	      $ir[$einfo['stat']]=max($ir[$einfo['stat']]-$inc, 0);
	  $upd=$ir[$einfo['stat']];
	  if(in_array($einfo['stat'], array('strength', 'agility', 'guard', 'labour', 'IQ')))
	    $db->query("UPDATE `userstats` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
	  else
	    $db->query("UPDATE `users` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
	}
	item_remove($userid, $r['inv_itemid'], 1);
	$r["inv_qty"] -- ;
	$response = array("failed" => false, "item" => $r);
	die(json_encode($response));
}
/***********************************/
/**************Attack*************/
/*********************************/
else if($do == "attack"){
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
	}else if($ir['jail'] > 0)
		json_error("Only superman attacks from jail.");	
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
	$bonus = false;
	if($settings['CLASS_ATTACK'][$youdata['class']][$odata['class']]){
		$mydamage1+=$mydamage1*rand($settings['CLASS_ATTACK'][$youdata['class']][$odata['class']]/2,$settings['CLASS_ATTACK'][$youdata['class']][$odata['class']])/100;
		$mydamage2+=$mydamage2*rand($settings['CLASS_ATTACK'][$youdata['class']][$odata['class']]/2,$settings['CLASS_ATTACK'][$youdata['class']][$odata['class']])/100;
		$bonus = true;
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
		$critical = "";
		$crit=rand(1,40);
		if($crit==17) { $mydamage*=rand(20,40)/10; $critical=" You are a unlucky! A doctor passed and treated his wound! You inflicted just ".round($mydamage)." damage.";} else if($crit==25 or $crit == 8) { $mydamage/=(rand(20,40)/10); $critical=" You are a lucky: one of your weapons hit a vital organ generating a total damage of ".$mydamage.".";} 
		$mydamage=round($mydamage);
		$odata['hp']-=$mydamage;
		if($odata['hp']==1) { $odata['hp']=0;$mydamage+=1; }
		$db->query("UPDATE users SET hp=hp-$mydamage WHERE userid={$_GET['ID']}");
		$response['ohp'] = $odata['hp'];
		$response['msg'] = ($primary ? "<table><tr><th>Round {$_GET['nextstep']}</th></tr><tr><td class='green'>Using your {$r11['itmname']} you hit {$odata['username']} doing $mydamage1 damage." : "").($secondary ? (!$primary ? "<table><tr><th>Round {$_GET['nextstep']}</th></tr><tr><td class='green'>" :"")." Using your {$r12['itmname']} you hit {$odata['username']} doing $mydamage2 damage. ({$odata['hp']})" : "" ).$critical;
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
				if($settings['CLASS_ATTACK'][$odata['class']][$youdata['class']])
					$dam+=(int)($dam*rand($settings['CLASS_ATTACK'][$odata['class']][$youdata['class']]/2,$settings['CLASS_ATTACK'][$odata['class']][$youdata['class']])/100);
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
}
/***********************************/
/***********Run Away***********/
/*********************************/
else if($do == "runaway"){
		$response = array("msg" => "");
		if(!$ir['attacking'] || rand(1,100) <=25){
			$db->query("UPDATE users SET attacking=0 WHERE userid=$userid");
			$_SESSION['attacking']=0;
			$response['msg'] = "<table><tr><th>Lucky!</th></tr><tr><td class=green>You managed to escape the fight!</td></tr></table>";
			die(json_encode($response));
		}else{
			$hosptime=rand(5,15)+floor($ir['level']/2);
			$db->query("UPDATE users SET hp=1,hospital=$hosptime,attacking=0,hospreason='Hospitalized because ran from a fight' WHERE userid=$userid");
			$_SESSION['attacking']=0;
			$response['msg'] = "<table><tr><th>Unlucky!</th></tr><tr><td class=red>While running you hit a tree and broke one tooth. You must stay in hospital for the next ".$hosptime." minutes.</td></tr></table>";
			die(json_encode($response));		
		}
}
/***********************************/
/**************Shout*************/
/*********************************/
else if($do == "shout"){
	$shout = $_POST['message'];
	$delete = 0 + $_POST['delete'];
	$edit = 0 + $_POST['edit'];
	if(($ir['user_level'] >= 2) && $edit){
		@$bannedDays = explode("|", $ir['sA_Ban']);
		if(@$bannedDays[1] > 0)
			json_error("Impossible! You are still banned for ".$bannedDays[1]." days.");
		if(!strlen($shout))
			json_error("Impossible! You have to write smth there!!");
		$db->query("UPDATE shoutbox set message='".$db->escape($shout)."' WHERE id=".$edit);
	}elseif(($ir['user_level'] >= 2) && $delete){
		@$bannedDays = explode("|", $ir['sA_Ban']);
		if(@$bannedDays[1] > 0)
			json_error("Impossible! You are still banned for ".$bannedDays[1]." days.");
		$db->query("DELETE FROM shoutbox WHERE id=".$delete);
		if(!strlen($shout) && isset($_POST['message']))
			json_error("Please write a real message.");
	}elseif(strlen($shout)){
		@$bannedDays = explode("|", $ir['sA_Ban']);
		if(@$bannedDays[1] > 0)
			json_error("Impossible! You are still banned for ".$bannedDays[1]." days.");
		if( (substr($shout, 0, 1) == "/") && ($ir['user_level'] >= 2)) 
		  $cmd = explode(" ", str_replace("/", "", $shout)); //$cmd[0] = the command, $cmd[1] = The value etc
		if($cmd[0] == "empty") {
			$res = mysql_query("TRUNCATE TABLE shoutbox");
			$sql=	mysql_query("INSERT INTO shoutbox (userid, date, message,username) VALUES(0, NOW(), 'Shouts deleted.', 'System')");
		}elseif($cmd[0] == "system" && strlen($cmd[1])>0) {
			$text="";
			for($i=1;$i<count($cmd);$i++) $text.=" ".$cmd[$i];
			$sql=mysql_query("INSERT INTO shoutbox (userid, date, message,username) VALUES(0, NOW(), ".sqlesc($text).", 'System')");
		}else{
			if($_POST['size']) $shout = "[size=".$_POST['size']."] ".$shout." [/size]";
			if($_POST['color'])$shout = "[color=".$_POST['color']."] ".$shout." [/color]";
			if($_POST['fontFamily'])$shout = "[font=".$_POST['fontFamily']."] ".$shout." [/font]";
			if($_POST['fontStyle'])$shout = "[i] ".$shout." [/i]";
			if($_POST['textDecoration'])$shout = "[u] ".$shout." [/u]";
			if($_POST['fontWeight'])$shout = "[b] ".$shout." [/b]";
			$db->query("INSERT INTO shoutbox (userid, username, donor, date,message) VALUES(".$ir["userid"].",'".$db->escape($ir["username"])."',".$ir["donatordays"].",".time().",'".$db->escape($shout)."')");
		}
	}
	$q = $db->query("SELECT * FROM shoutbox ORDER BY id DESC LIMIT 15");
	while($r = $db->fetch_row($q)){
		if(($ir['user_level'] >= 2) || ($ir['userid'] == $r['userid']))
			$r['staff'] = true;
		else
			$r['staff'] = false;
		$r['date'] = gmdate("H:i",$r['date']);
		$r['edit'] = htmlspecialchars(str_replace("'", "&#39;", $r['message']));

		$r['message'] = format_comment(stripslashes($r['message']));
		$response[] = $r;
	}
	die(json_encode($response));
}
/***********************************/
/***********Gym Train***********/
/*********************************/
else if($do == "gym"){
	if($ir['hospital'])
		json_error("This page cannot be accessed while in hospital.");
	$skill = $_POST['skill'];
	$skills_array = array("strength","agility","guard","labour");
	if(!in_array($skill,$skills_array))
		json_error("Invalid skill! What are you training for?!");
	$times = (int)(0+$_POST['times']);
	if(!$times)
		json_error("You must train more than 0 times!");
	if($times > $ir['energy'])
		json_error("You don't have enough energy to train so many times.");
	$gain=0;
	for($i=0; $i<$times; $i++){
		$gain+=(rand(1,3)+ $settings['CLASS_GYM'][$ir['class']][$skill])*rand(800,1000)/rand(800,1000)*(($ir['will']+20)/150);
		$ir['will']-=rand(1,3);
		if($ir['will'] < 0)
			$ir['will']=0;
	}
	if($ir['jail'])
		$gain/=2;
//	$gain = number_format($gain,4);
	$ir['energy']-=$times;
	$ir[$skill]+=$gain;
	if($skill=="strength")
		$message = "
			<font color='green'>
			      You start to lift some weights, You go heavier and heavier until You are out of energy.<br />
			      You have gained {$gain} strength by doing {$times} sets of weights.<br />
			      You now have {$ir["strength"]} strength and {$ir["energy"]} energy left. 
			</font>";
	else if($skill=="agility")
		$message = "
			<font color='green'>
			      You Begin to run on the treadmill, You keep tapping the faster button till you fly off the damn thing!.<br />
			      You have gained {$gain} agility by doing {$times} minutes of running.<br />
			      You now have {$ir["agility"]} agility and {$ir["energy"]} energy left.      
			</font>";
	else if($skill=="guard")
		$message = "
			<font color='green'>
			      You jump into the pool and begin swimming, you keep flapping your arms in the water like Michael Felps, you get a cramp and almost drown.<br />
			      You have gained {$gain} guard by doing {$times} minutes of swimming.<br />
			      You now have {$ir["guard"]} guard and {$ir["energy"]} energy left.      
			</font>";
	else if($skill=="labour")
		$message = "
			<font color='green'>
			      You walk over to the front desk, and ask the manager If you can volunteer to help the gym out, He says unload the boxes In the back, You unload boxes until the gym closes<br />
			      You have gained {$gain} labour by unloading {$times} boxes.<br />
			      You now have {$ir["labour"]} labour and {$ir["energy"]} energy left.
			</font>";
	$fm=money_formatter($ir['money']);
	$cm=money_formatter($ir['crystals'],'');
	$ir['moneyFormat'] = $fm;
	$ir['crystalsFormat'] = $cm;
	$response = array(
			"failed"		=>false,
			"message"	=> $message,
			"user"		=> $ir,
			"gained"		=> number_format($gain,3),
			"srank"		=>get_rank($ir['strength'],'strength'),
			"arank"		=>get_rank($ir['agility'],'agility'),
			"grank"		=>get_rank($ir['guard'],'guard'),
			"lrank"		=>get_rank($ir['labour'],'labour')
		);
	$db->query("UPDATE `userstats` SET `{$skill}` = `{$skill}` + $gain WHERE `userid` = $userid");
	$db->query("UPDATE `users` SET `will` = {$ir['will']}, energy = energy - {$times} WHERE `userid` = $userid");
	die(json_encode($response));
}else if($do == "buyItem"){
	$item = abs((int) $_GET['ID']);
	$qty = abs((int) $_GET['qty']);
	if(!$item || ! $qty)
		json_error("ERROR1!");
	$q=$db->query("SELECT * FROM items WHERE itmid={$item}");
	if($db->num_rows($q) == 0)
		json_error("ERROR2!");
	$itemd=$db->fetch_row($q);
	if($ir['money'] < $itemd['itmbuyprice']*$qty)
		json_error(_INSUFFICIENT_MONEY);
	if(!$itemd['itmbuyable'])
		json_error("This item can't be bought!");
	$price=($itemd['itmbuyprice']*$qty);
	item_add($userid, $item, $qty);
	$db->query("UPDATE users SET money=money-$price WHERE userid=$userid");
	$ir['money']-=$price;
	$fm=money_formatter($ir['money']);
	$cm=money_formatter($ir['crystals'],'');
	$ir['moneyFormat'] = $fm;
	$ir['crystalsFormat'] = $cm;
	$db->query("INSERT INTO itembuylogs VALUES ('', $userid, $item, $price,$qty, unix_timestamp(), '{$ir['username']} bought {$qty} {$itemd['itmname']}(s) for {$price}')");
	$response = array("failed" => false, "message"=>_ITEM_BOUGHT1." ".$qty." ".$itemd['itmname']." "._ITEM_BOUGHT2." ".$price, "user" => $ir);
	die(json_encode($response));
}else
	json_error("ERROR!");
?>