<?php

/**************************************************************************************************
| Software Name        : Mafia Game Scripts Online Mafia Game
| Software Author      : Mafia Game Scripts
| Software Version     : Version 2.3.1 Build 2301
| Website              : http://www.ravan.info/
| E-mail               : support@ravan.info
|**************************************************************************************************
| The source files are subject to the Mafia Game Script End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Mafia Game Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Mafia Game Script . All rights reserved.
|**************************************************************************************************/

$housequery=1;


include "globals.php";
print pageHelp(_HELP_INDEX_HEADER, _HELP_INDEX);

if(!$ir['donatordays'])
{

print "

<div class='icolumn2' id='mainContentDiv'>
<div class='upgradepart'>
<div class='upgradepart_left'>
<h1><img src='images/upgrade_img.jpg' alt='' /></h1>
<p>You are not a Respected <b>Mob</b> Boss? <br/><span>Check out what you’re missing!</span></p>

<h2><a href='donator.php'><img src='images/click_upgradebtn.jpg' title='Click here to Upgrade!' alt='Click here to Upgrade!' /></a></h2>
</div>
<div class='gainpart'>
<div><img src='images/gain_top.jpg' alt='' /></div>
<div class='gain_md'>
<ul>
<li>- Special Donator Badge & Respected Ribbon</li>
<li>- Gain Energy twice as quick</li>
<li>- Gain HP twice as quick</li>
<li>- Gain Will twice as quick</li>    
<li>- Gain Brave twice as quick</li>
<li>- Different Color Name</li>
<li>- Special Will Package</li>
<li>- Special Money and Crystal Package</li> 
<li>- Add Friend/Enemy</li>
<li>- And Much Much More</li>
</ul>                                
</div>

<div><img src='images/gain_btm.jpg' alt='' /></div>
</div>                        
</div>


</div>

<br/>  <br/>   <br/>   <br/>   <br/>   <br/>   <br/>   <br/>   <br/> <br/>  <br/>   <br/>   <br/>   <br/>   <br/>   <br/>   <br/>   <br/>      <br/>  <br/>   <br/>   <br/>   ";

}

print"

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> <img src='images/info_txt.gif' alt='General Info' /> </h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width=75% border=2  style=text-align:center; class=table>
<tr>
<th colspan=3></th>
</tr>";
$exp=(int)($ir['exp']/$ir['exp_needed']*100);
print "<tr>
<td width=50%><b>"._NAME.":</b> {$ir['username']}</td><td><b>"._CRYSTALS.":</b> {$cm}</td></tr><tr>
<td><b>"._LEVEL.":</b> {$ir['level']}</td>
<td><b>"._EXP.":</b> {$exp}%</td></tr><tr>
<td><b>"._MONEY.":</b> $fm</td>
<td><b>"._GANG.":</b> ";
$qs=$db->query("SELECT * FROM gangs WHERE gangID={$ir['gang']}");
$rs=$db->fetch_row($qs);
if(!$db->num_rows($qs) ) 
{
print _NO_GANG;   
}
else
{
print" {$rs['gangNAME']} ";
}
print "
</td>
</tr>
<tr><td><b>"._PROPERTY.":</b> {$ir['hNAME']}</td>  
<td><b>"._DAYS_OLD.":</b> {$ir['daysold']} </td></tr>
<tr><td><b>"._HEALTH.":</b> {$ir['hp']}/{$ir['maxhp']}  </td>
<td><b>"._ENERGY.":</b>  {$ir['energy']}/{$ir['maxenergy']} </td></tr>
<tr><td><b>"._BRAVE.":</b> {$ir['brave']}/{$ir['maxbrave']}  </td>
<td><b>"._WILL.":</b>  {$ir['will']}/{$ir['maxwill']} </td></tr>
<tr>
<th colspan=3></th>
</tr>
</table></div><div> <img src='images/generalinfo_btm.jpg' alt='' /> </div><br></div></div></div></div></div>";

print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> <img src='images/stats_txt.gif' alt='Status Info' /></h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br><br>
<br><table width=75% border=2 class=table style= text-align:center; >";
$ts=$ir['strength']+$ir['agility']+$ir['guard']+$ir['labour']+$ir['robskill']+$ir['IQ'];
$ir['strank']=get_rank($ir['strength'],'strength');
$ir['agirank']=get_rank($ir['agility'],'agility');
$ir['guarank']=get_rank($ir['guard'],'guard');
$ir['labrank']=get_rank($ir['labour'],'labour');
$ir['robrank']=get_rank($ir['robskill'],'robskill');
$ir['IQrank']=get_rank($ir['IQ'],'IQ');
$tsrank=get_rank($ts,'strength+agility+guard+labour+IQ');
$ir['strength']=number_format($ir['strength']);
$ir['agility']=number_format($ir['agility']);
$ir['guard']=number_format($ir['guard']);
$ir['labour']=number_format($ir['labour']);
$ir['robskill']=number_format($ir['robskill']); 
$ir['IQ']=number_format($ir['IQ']);
$ts=number_format($ts);

print "<tr><th width='33%'>"._STAT."</th><th width='33%'>"._AMOUNT."</th><th width='34%'>"._RANK."</th></tr>
<tr><td>"._STRENGTH."</td> <td>{$ir['strength']}</td> <td>"._RANK.": {$ir['strank']}</td></tr>
<tr><td>"._AGILITY."</td><td> {$ir['agility']} </td><td>"._RANK.": {$ir['agirank']}</td></tr>
<tr><td>"._GUARD."</td><td>{$ir['guard']}</td><td>"._RANK.": {$ir['guarank']}</td></tr>
<tr><td>"._LABOUR."</td><td>{$ir['labour']}</td><td>"._RANK.": {$ir['labrank']}</td></tr>
<tr><td>"._ROB_SKILL."</td><td>{$ir['robskill']}</td><td>"._RANK.": {$ir['robrank']}</td></tr>
<tr><td>"._IQ."</td><td>{$ir['IQ']}</td><td>"._RANK.": {$ir['IQrank']}</td></tr> 
<tr><td>"._TOTAL_STATS.":</td><td>{$ts}</td><td>"._RANK.": $tsrank</td></tr>
<tr><th colspan=3></th></tr>
</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> ";



$attacks_won = $db->query(sprintf('SELECT COUNT(`log_id`) AS attacking_won FROM `attacklogs` WHERE `attacker` = %u AND `result` = "%s"', $userid, 'won'));
$attacks_wonc = $db->fetch_row($attacks_won);
$attacks_lost = $db->query(sprintf('SELECT COUNT(`log_id`) AS attacking_lost FROM `attacklogs` WHERE `attacker` = %u AND `result` = "%s"', $userid, 'lost'));
$attacks_lostc = $db->fetch_row($attacks_lost);
if ($attacks_lostc['attacking_lost'])
{
$attacking_perl = $attacks_lostc['attacking_lost'] / ($attacks_wonc['attacking_won'] + $attacks_lostc['attacking_lost']) * 100;
}
elseif (!$attacks_lostc['attacking_lost'])
{
$attacking_perl = 0;
}
if ($attacks_wonc['attacking_won'])
{
$attacking_perw = $attacks_wonc['attacking_won'] / ($attacks_wonc['attacking_won'] + $attacks_lostc['attacking_lost']) * 100;
}
elseif (!$attacks_wonc['attacking_won'])
{
$attacking_perw = 0;
}


$attacksd_won = $db->query(sprintf('SELECT COUNT(`log_id`) AS defending_won FROM `attacklogs` WHERE `attacked` = %u AND `result` = "%s"', $userid, 'lost'));
$attacksd_wonc = $db->fetch_row($attacksd_won);
$attacksd_lost = $db->query(sprintf('SELECT COUNT(`log_id`) AS defending_lost FROM `attacklogs` WHERE `attacked` = %u AND `result` = "%s"', $userid, 'won'));
$attacksd_lostc = $db->fetch_row($attacksd_lost);
if ($attacksd_lostc['defending_lost'])
{
$defending_perl = $attacksd_lostc['defending_lost'] / ($attacksd_wonc['defending_won'] + $attacksd_lostc['defending_lost']) * 100;
}
elseif (!$attacksd_lostc['defending_lost'])
{
$defending_perl = 0;
}
if ($attacksd_wonc['defending_won'])
{
$defending_perw = $attacksd_wonc['defending_won'] / ($attacksd_wonc['defending_won'] + $attacksd_lostc['defending_lost']) * 100;
}
elseif (!$attacksd_wonc['defending_won'])
{
$defending_perw = 0;
}

$T_won = $attacks_wonc['attacking_won'] + $attacksd_wonc['defending_won'];
$T_lost = $attacks_lostc['attacking_lost'] + $attacksd_lostc['defending_lost'];
if ($T_won)
{
$T_won_per = $T_won / ($T_won + $T_lost) * 100;
}
elseif (!$T_won)
{
$T_won_per = 0;
}
if ($T_lost)
{
$T_lost_per = $T_lost / ($T_won + $T_lost) * 100;
}
elseif (!$T_lost)
{
$T_lost_per = 0;
}











echo "


<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> <img src='images/attack_txt.gif' alt='Attack Record' /></h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br><br>
<br><table width=75% border=2 class=table style= text-align:center; >     

";
echo sprintf('   
<table width="73%%" class=table bgcolor="#000000" cellpadding="1" bordercolor="Silver" border="1">     
<tr>
<th > <font color=green> '._WON.' </font></th> <th > '._AMOUNT.'</th> <th > <font color=red> '._LOST.'</th> </font> <th > '._AMOUNT.'</th> 
</tr> 
<tr>  
<td>
<font color=green>'._ATTACKING_WON.'</font>
</td>

<td>
%u (%u%%)
</td>

<center></center>
<td>
<font color=red>'._ATTACKING_LOST.'</font>
</td>

<td>
%u (%u%%)
</td>


</tr>

<tr>
<td>
<font color=green>'._DEFENDING_WON.'</font>
</td>

<td>
%u (%u%%)
</td>

<td>
<font color=red>'._DEFENDING_LOST.'</font>
</td>

<td>
%u (%u%%)
</td>


</tr>


<tr>
<td>
<font color=green>'._TOTAL_WON.'</font>
</td>
<td>
%u (%u%%)
</td>
<td>
<font color=red>'._TOTAL_LOST.'</font>
</td>

<td>
%u (%u%%)
</td>


</tr> <tr>
<th colspan=4></th>
</tr>




</table>  </div><div><img src="images/generalinfo_btm.jpg" /></div></div></div></div></div></div>
',
$attacks_wonc['attacking_won'], 
$attacking_perw, 
$attacks_lostc['attacking_lost'], 
$attacking_perl, 
$attacksd_wonc['defending_won'], 
$defending_perw, 
$attacksd_lostc['defending_lost'], 
$defending_perl, 
$T_won, 
$T_won_per, 
$T_lost, 
$T_lost_per
);



if(isset($_POST['pn_update']))

{
$db->query("UPDATE users SET user_notepad='{$_POST['pn_update']}' WHERE userid=$userid");
$ir['user_notepad']=stripslashes($_POST['pn_update']);
print "<br><br><b>Personal Notepad Updated!</b>";
}


print " 


<div class='generalinfopart' style='padding-top:35px;'>
	<div class='generalinfo_txt'>
		<div><img src='images/personal_left.gif' alt='' /></div>
		<div class='personal_mid'><p><img src='images/personal_txt.gif' alt='' /></p></div>
		<div><img src='images/personal_right.gif' alt='' /></div>
	</div>
	<div class='personal_md' style='width:668px;float:right;'>
		<form action='index.php' method='post'>
			<div class='update_con'>
				<textarea rows='0' cols='0' name='pn_update'> ".htmlspecialchars($ir['user_notepad'])."  </textarea>
			</div>
			<div class='update_btn'>
				<span><input type='image' src='images/update_txt.gif' id='myNotesButton' title='Update Notes' alt='Update Notes' /></span>
			</div>    
		</form>    
	</div>
	<div><img src='images/personal_btm.gif' alt='' /></div>
</div>    




";
$h->endpage();
?>
