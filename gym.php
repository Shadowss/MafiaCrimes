<?php
$macropage="gym.php";
$special_page = '<script type="text/javascript" src="js/gym.js"/></script>';
require "globals.php";
print pageHelp(_HELP_GYM_HEADER, _HELP_GYM);
if($ir['hospital']) { die("<prb>This page cannot be accessed while in hospital.</prb>"); }

if(!$ir['jail'])
{
print "<div class='gympage'>
 <div class='gympart'>
 <div class='gymtxt'><img src='images/gym_txt.jpg' align=left alt='' /></div>
</div>";
}
else
{
  print "
  <div class='gympage'>
    <div class='gympart'></div>
  
  ";
}
$ir['strank']=get_rank($ir['strength'],'strength');
$ir['agirank']=get_rank($ir['agility'],'agility');
$ir['guarank']=get_rank($ir['guard'],'guard');
$ir['labrank']=get_rank($ir['labour'],'labour');

print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>
		<table width='90%'><tr><td ><p id='gym_container'>
	");
if(  $ir['energy'] == "0"   )
	print "You dont have any energy for taining <a href='crystaltemple.php?spend=refill'><font color='green'>[Refill Energy]</font></a>";
else
	print "You can train up to <prb> {$ir['energy']} </prb> times with your current energy.";

?>
</p></td></tr></table></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br /><br />

<table width="90%" class="table">
<tr>
   <form action="gym.php" method="post" onsubmit="return workOut('strength', this.amnt.value);">
   <input type="hidden" name="stat" value="Strength"></input>
   <th width="15%"><ph2>Strength:</ph2></th>
   <td width="15%" id="gym_strength"><?=$ir["strength"];?></td>
   <td width="10%" id="gym_strength_rank">Rank <?=$ir["strank"];?></td>
   <td width="40%">Times to train: <input name="amnt" type="text" value="<?=$ir["energy"];?>" > </input> </td>
   <td width="20%">  <input type=image name="submit" src="images/trainbtn.jpg" alt="Home" border="0"> </input> </td>
   </form>
</tr>
<tr>
   <form action="gym.php" method="post" onsubmit="return workOut('agility', this.amnt.value);">
   <input type="hidden" name="stat" value="Agility"></input>
   <th width="15%"><ph2>Agility:</ph2></th>
   <td width="15%" id="gym_agility"><?=$ir["agility"];?></td>
   <td width="10%" id="gym_agility_rank">Rank <?=$ir["agirank"];?></td>
   <td width="40%">Times to train: <input type="text" name="amnt" value="<?=$ir["energy"];?>"></input></td>
   <td width="20%"><input type=image name="submit" src="images/trainbtn.jpg" alt="Home" border="0"> </input> </td>   
   </form>
</tr>
<tr>
   <form action="gym.php" method="post" onsubmit="return workOut('guard', this.amnt.value);">
   <input type="hidden" name="stat" value="Guard"></input>
   <th width="15%"><ph2>Guard:</ph2></th>
   <td width="15%" id="gym_guard"><?=$ir["guard"];?></td>
   <td width="10%" id="gym_guard_rank">Rank <?=$ir["guarank"];?></td>
   <td width="40%">Times to train: <input type="text" name="amnt" value="<?=$ir["energy"];?>"></input></td>
   <td width="20%"><input type=image name="submit" src="images/trainbtn.jpg" alt="Home" border="0"> </input> </td>   
   </form>
</tr>
<tr>
   <form action="gym.php" method="post" onsubmit="return workOut('labour', this.amnt.value);">
   <input type="hidden" name="stat" value="Labour"></input>
   <th width="15%"><ph2>Labour:</ph2></th>
   <td width="15%" id="gym_labour"><?=$ir["labour"];?></td>
   <td width="10%" id="gym_labour_rank">Rank <?=$ir["labrank"];?></td>
   <td width="40%">Times to train: <input type="text" name="amnt" value="<?=$ir["energy"];?>"></input></td>
   <td width="20%"><input type=image name="submit" src="images/trainbtn.jpg" alt="Home" border="0"> </input> </td>   
   </form>
</tr>
</table><br />
<?
$h->endpage();
?>