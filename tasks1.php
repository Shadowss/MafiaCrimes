<?php
/**************************************************************************************************
| Software Name        : Ravan Scripts Online Mafia Game
| Software Author      : Ravan Soft Tech
| Software Version     : Version 2.0.1 Build 2101
| Website              : http://www.ravan.info/
| E-mail               : support@ravan.info
|**************************************************************************************************
| The source files are subject to the Ravan Scripts End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Ravan Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Ravan Scripts . All rights reserved.
|**************************************************************************************************/

$macropage="tasks.php";
$special_page = '<link rel="stylesheet" href="css/ui_crime.css" type="text/css" />';
include "globals.php";
print pageHelp(_HELP_TASKS_HEADER, _HELP_TASKS);
if($ir['jail'] or $ir['hospital']) { print "This page cannot be accessed while in jail or hospital.";

$h->endpage(); 
exit; 
}
$coloane = 4;
?>
<script>
var posting = false;
function doCrime(id){
	if(posting){
		 alert("Please wait! Another crime is in progress!");
		return false;
	}
	$("#crime_process").html("<div><img src='images/generalinfo_top.jpg' alt='' /></div><div class='generalinfo_simple'>Committing crime!</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>");
	$('html,body').animate({ scrollTop: $("#crime_process").offset().top }, { duration: 300, easing: 'swing'});
	posting = true;
	$.get("ajax.php", { do: "crime", crimeID: id},function(data){
		$.getJSON("ajax.php", { do: "userStats" },function(data2){
			UpdateUserStats(data2);
			$("#crime_process").html(data);
			posting = false;
   		});
   	});
}
</script>
<?
$q=$db->query("SELECT * FROM crimegroups ORDER by cgORDER ASC");
$q2=$db->query("SELECT * FROM crimes ORDER BY crimeBRAVE ASC");
while ($r2=$db->fetch_row($q2))
{
$crimes[]=$r2;
}
print "
<div class='crimepage' id='crimepage'>
<div class='crime_toppart'> 
<div class='toppara'></div>                    
</div>
<div class='crime_txt'><img src='images/crime_txt.jpg' alt='' /></div>
<div><img src='images/generalinfo_top.jpg' alt='' /></div>
<div class='generalinfo_simple'>";


?><table width='90%' cellspacing=1 class='table'><th colspan='<?=$coloane?>'>Choose the type of crime you would like to perform</th><?
$i = 0;
$out ="";
while($r=$db->fetch_row($q)){
	$crimeLogWon = $db->num_rows($db->query("SELECT * FROM usercrimelog WHERE userid=".sqlesc($ir['userid'])." AND crimegroup=".$r['cgID']." AND success='yes'"));
	$crimeLogLost = $db->num_rows($db->query("SELECT * FROM usercrimelog WHERE userid=".sqlesc($ir['userid'])." AND crimegroup=".$r['cgID']." AND success='no'"));
	if($i == 0) print("<tr>");
	elseif($i%$coloane == 0) print "</tr><tr>";
	print "<td align='center'><a href='#tab_".$i."'><b>{$r['cgNAME']}</b></a></td>";
	$out = $out."<div id='tab_".$i."' style='float: left; padding-top: 8px; padding-right: 8px; padding-bottom: 8px; padding-left: 20px; '>
		<div class='pref_mainmenu'>
		<div id='rotate'>
			<ul class='ui-tabs-nav'><li class='ui-tabs-selected'><a><span>{$r['cgNAME']}</span></a></li></ul>
			<div class='ui-tabs-panel'>
				<div class='crime_tab_conpart'>
					<div><img src='/images/crime_tab_top.jpg' alt='' /></div>
					<div class='crime_tab_mid'>
						<div class='crime_conpart'>";

	foreach($crimes as $v)
		if($v['crimeGROUP'] == $r['cgID']) {
			if($v['crimeITEM'] > 0){
				$d=$db->query("SELECT itmname FROM items WHERE itmid={$v['crimeITEM']}");
				$item=$db->fetch_row($d);
			}
			if($v['crimeCOURSE'] > 0){
				$d=$db->query("SELECT crNAME FROM courses WHERE crID={$v['crimeCOURSE']}");
				$course=$db->fetch_row($d);
			}
$ec="\$sucrate=".str_replace(array("LEVEL","CRIMEXP","EXP","WILL","IQ","XPCRIME"), array($ir['level'], $ir['crimexp'], $ir['exp'], $ir['will'], $ir['IQ'], $v['crimeXP']),$v['crimePERCFORM']).";";
eval($ec);
if($sucrate > 100) $sucrate = 100;
			$out = $out."
		<div style='padding-top: 10px;'><img src='images/sc_topbg.png' alt='' /></div>
		<div class='crime_maincon'>
		     <div class='crime_imgbg'><img src='images/items/{$v['crimePICTURE']}' alt='' width='100' height='90'/></div>
		     <div class='crime_content'>
			<div class='crime_txt1'>{$v['crimeNAME']} ({$v['crimeSUCCESSMUNY']}$)</div>
			    <div class='crime_txtpart'>
			       <div class='crime_txtpart_left'>				
				<div class='crime_txt2'>Requirements</div>
				<div class='crime_txt3'>
					You Need to have <span>{$v['crimeBRAVE']} Brave</span> . <br />
					".($v['crimeLEVEL'] > 0 ? "You Need to be <span>level {$v['crimeLEVEL']}</span> at least .<br />" : "")."
					".($v['crimeLABOUR'] > 0 ? "You Need to have <span>{$v['crimeLABOUR']} Labour skill</span> .<br />" : "")."
					".($v['crimeIQ'] > 0 ? "You Need to have <span>{$v['crimeIQ']} IQ</span> skill .<br />" : "")."
					".($v['crimeAGILITY'] > 0 ? "You Need to have <span>{$v['crimeAGILITY']} Agility</span> .<br />" : "")."
					".($v['crimeSTRENGTH'] > 0 ? "You Need to have <span>{$v['crimeSTRENGTH']} Strength</span> .<br />" : "")."
					".($v['crimeGUARD'] > 0 ? "You Need to have <span>{$v['crimeGUARD']} Gouard</span> skill .<br />" : "")."
					".($v['crimeROBSKILL'] > 0 ? "You Need to have <span>{$v['crimeROBSKILL']} Robbing</span> skill .<br />" : "")."
					".($v['crimeITEM'] > 0 ? "You Need to have <span>{$item['itmname']}</span> Item .<br />" : "")."
					".($v['crimeCOURSE'] > 0 ? "You Need to attend <span>{$course['crNAME']}</span> course .<br />" : "")."
					Chance of completing this crime: ".number_format($sucrate,2)."% <br />
					Jail time {$v['crimeJAILTIME']} Minutes
				</div>
			       </div>
			     <div class='crime_txtpart_right'>				
			   <div class='perform_btn'><a href='javascript:void(0)' onclick='doCrime({$v['crimeID']}); return false;'>PERFORM CRIME</a></div>
			</div>
		     </div>
		 </div>
		</div>
		<div><img src='images/sc_btmbg.png' alt='' /></div>
			";
	}

	$out = $out."</div></div><div><img src='/images/crime_tab_btm.jpg' alt='' /></div>";

$out.=	'		<div class="crime_recordpart">
				<div class="crime_recordtxt"><img src="images/crime_recordtxt.jpg" alt="" /></div>
				<div class="crime_record_txt1">Below is an accurate record of the crimes you have passed and failed.</div>
			</div>	
			<div class="crime_tabularpart">
				<div><img src="images/tabular_tit_left.jpg" alt="" /></div>

				<div class="crime_tabular_titmd">
					<div class="crime_tit1" style="margin-left:0px;">Crime Type</div>
					<div class="crime_tit2">Successful</div>
					<div class="crime_tit2">Failures</div>
					<div class="crime_tit2">Total Done</div>
				</div>
				<div><img src="images/tabular_tit_right.jpg" alt="" /></div>

			</div>	
			<div class="crime_tabularcontent">
				<table cellpadding="0" cellspacing="0" width="560">
					<tr>
						<td align="center" valign="middle" width="172" height="30" style="border-left:0px;">'.$r['cgNAME'].'</td>
						<td align="center" valign="middle" width="162">'.$crimeLogWon.'</td>
						<td align="center" valign="middle" width="162">'.$crimeLogLost.'</td>
						<td align="center" valign="middle" width="162">'.($crimeLogWon+$crimeLogLost).'</td>

					</tr>
				</table>
			</div>
';

	$out = $out."</div></div></div></div></div><div>";







	$i++;
}
while($i%$coloane != 0){
	print "<td align='center'></td>";
	$i++;
}

print "
</table>
</div>
<div><img src='images/generalinfo_btm.jpg' alt='' /></div>
<div style='height:10px; background:transparent;'></div>
<div id='crime_process'></div>
<div style='height:10px; background:transparent;'></div>
".$out."
</div>";
?><script type="text/javascript"> 
  $("#crimepage").idTabs(); 
</script><?

$h->endpage();
?>

