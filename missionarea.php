<?php    
include "include.php";
$h = new headers;
$h->startheaders();
$h->userdata($ir,$lv,$fm,$cm);
$h->menuarea();
if($ir['jail'] or $ir['hospital']) {
	print "This page cannot be accessed while in jail or hospital.";
	$h->endpage(); 
	exit; 
}

switch($_GET['action']){
	case "missionDetails": missionDetails(); break;
	default: missionWelcome();break;
}
/***********************/
/* Mission Details */
/********************/
function missionDetails(){
	global $db,$ir,$h;
	if($ir['mission'] > $_GET['ID']){
		print("
			<div><img src='images/generalinfo_top.jpg' alt='' /></div>
			<div class='generalinfo_simple'>Hello, please stick one finger in your ass and then put it in your mouth! This is the best mission!</div>
			<div><img src='images/generalinfo_btm.jpg' alt='' /></div>
		");
		$h->endpage();
		exit;
	}
	$missionID = 0+$_GET['ID'];
	$res = $db->query("SELECT missions.* FROM missions WHERE ID=".$missionID);
	if(!$db->num_rows($res)){
		print("
			<div><img src='images/generalinfo_top.jpg' alt='' /></div>
			<div class='generalinfo_simple'>You are retarded!</div>
			<div><img src='images/generalinfo_btm.jpg' alt='' /></div>
		");
		$h->endpage();
		exit;
	}
	$arr=$db->fetch_row($res);		
	print "
	<div class='generalinfo_txt'>
	<div><img src='images/info_left.jpg' alt='' /></div>
	<div class='info_mid'><h2 style='padding-top:10px;'><marquee> Mission ".$arr['ID']."</marquee> </h2></div>
	<div><img src='images/info_right.jpg' alt='' /></div>
	</div>
	<div class='generalinfo_simple'>
	<img src='images/missions/mission_".$missionID.".png' border='0'><br />
	<table class='table' width='85%'>
		<tr valign='middle'>
			<th width='34%'><span class='attack_16'><img src='./images/pixel.png' width='16px' height='16px' title='Missions!' border='0'/></span> Mission Progress</th>
		</tr>
	";
	$arr2 = explode("|",$arr['steps']);
//	$res2 = $db->query("SELECT * FROM usermissions WHERE missionID=".$missionID." AND userid=".sqlesc($ir['userid']));
	for($i=0;$i<count($arr2);$i++)
			print "
			<tr style='height: 100%;'>
				<td valign='top'>
					Step ".($i+1).":  ".$arr2[$i].". <i>(Done/NOT)</i>
				</td>
			</tr>
		";
	print("<tr><th>Bonuses</th></tr>");
	foreach ($arr as $key => $value){
		if($key != "ID" & $key != "steps" &  $key != "item" & $value!=0)
			print "
			<tr style='height: 100%;'>
				<td valign='top'>
					".$key.":  ".$value."
				</td>
			</tr>
		";
		if($key == "item" & $value!=0){
			$name = $db->fetch_row($db->query("SELECT itmname FROM items WHERE itmid=".$value));
			print "
			<tr style='height: 100%;'>
				<td valign='top'>
					".$key.":  ".$name['itmname']."
				</td>
			</tr>
		";
		}			
	}
	print "
		</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>
		This is your referal link: http://{$domain}/signup.php?REF={$ir['userid']} <br><br />
		Every signup from this link earns you two valuable crystals!";
}
/***********************/
/* Missions Home */
/********************/
function missionWelcome(){
	global $db,$ir,$h;
	print "
	<div class='generalinfo_txt'>
	<div><img src='images/info_left.jpg' alt='' /></div>
	<div class='info_mid'><h2 style='padding-top:10px;'><marquee> Missions Area</marquee> </h2></div>
	<div><img src='images/info_right.jpg' alt='' /></div>
	</div>
	<div class='generalinfo_simple'>
		<br>
		<br>
		<br />
	<table class='table' width='85%'>
		<tr valign='middle'>
			<th width='34%'><span class='attack_16'><img src='./images/pixel.png' width='16px' height='16px' title='Missions!' border='0'/></span> Available missions</th>
		</tr>
	";
	$res = $db->query("SELECT * FROM missions ORDER BY ID ASC");
	while($arr=$db->fetch_row($res)){
		if($ir['mission'] < $arr['ID'])
			print "
			<tr style='height: 100%;'>
				<td valign='top'>
					<a href='?action=missionDetails&ID=".$arr['ID']."'><img src='images/missions/mission_".$arr['ID'].".png' border='0'></a>
				</td>
			</tr>
		";
		else
			print "
			<tr style='height: 100%;'>
				<td valign='top'>
					Mission ".$arr['ID'].". <i>(Done)</i>
				</td>
			</tr>
		";
	}

	print "
		</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>
		This is your referal link: http://{$domain}/signup.php?REF={$ir['userid']} <br><br />
		Every signup from this link earns you two valuable crystals!";
}
$h->endpage();
?>

