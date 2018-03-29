<?php
$macropage="gym.php";
$special_page = '<script type="text/javascript" src="js/tw-sack.js"/></script>';
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
   <form method="post">
   <input type="hidden" name="stat" value="Strength"></input>
   <th width="15%"><ph2>Strength:</ph2></th>
   <td width="15%" id="gym_strength"><?=$ir["strength"];?></td>
   <td width="10%" id="gym_strength_rank">Rank <?=$ir["strank"];?></td>
   <td width="40%">Times to train: <input name="amnt" type="text" value="<?=$ir["energy"];?>" > </input> </td>
   <td width="20%">  <input type=image name="submit" src="images/trainbtn.jpg" alt="Home" border="0" onClick="return workOut('strength', this.parentNode.parentNode.amnt.value);"> </input> </td>
   </form>
</tr>
<tr>
   <form method="post" onsubmit="return workOut('agility', this.amnt.value);">
   <input type="hidden" name="stat" value="Agility"></input>
   <th width="15%"><ph2>Agility:</ph2></th>
   <td width="15%" id="gym_agility"><?=$ir["agility"];?></td>
   <td width="10%" id="gym_agility_rank">Rank <?=$ir["agirank"];?></td>
   <td width="40%">Times to train: <input type="text" name="amnt" value="<?=$ir["energy"];?>"></input></td>
   <td width="20%"><input type=image name="submit" src="images/trainbtn.jpg" alt="Home" border="0"> </input> </td>   
   </form>
</tr>
<tr>
   <form method="post" onsubmit="return workOut('guard', this.amnt.value);">
   <input type="hidden" name="stat" value="Guard"></input>
   <th width="15%"><ph2>Guard:</ph2></th>
   <td width="15%" id="gym_guard"><?=$ir["guard"];?></td>
   <td width="10%" id="gym_guard_rank">Rank <?=$ir["guarank"];?></td>
   <td width="40%">Times to train: <input type="text" name="amnt" value="<?=$ir["energy"];?>"></input></td>
   <td width="20%"><input type=image name="submit" src="images/trainbtn.jpg" alt="Home" border="0"> </input> </td>   
   </form>
</tr>
<tr>
   <form method="post" onsubmit="return workOut('labour', this.amnt.value);">
   <input type="hidden" name="stat" value="Labour"></input>
   <th width="15%"><ph2>Labour:</ph2></th>
   <td width="15%" id="gym_labour"><?=$ir["labour"];?></td>
   <td width="10%" id="gym_labour_rank">Rank <?=$ir["labrank"];?></td>
   <td width="40%">Times to train: <input type="text" name="amnt" value="<?=$ir["energy"];?>"></input></td>
   <td width="20%"><input type=image name="submit" src="images/trainbtn.jpg" alt="Home" border="0"> </input> </td>   
   </form>
</tr>
</table><br />

<script>
var working=false;
var ajax = new sack();
var container =  document.getElementById('gym_container');
function whenLoading(){
	container.innerHTML = "<p>Working out...</p>";
	var working=true;
	$(":input").val("Training...");
	$(":input").attr("readonly", true);
}

function whenCompleted(){
	eval("var r = "+ajax.response);
	var working=false;
	if(r.failed){
		$("#gym_container").html("<font color='red'>"+r.failed+"</font>");
		$(":input").attr("readonly", false);
		$(":input").val("0");
		return false;
	}
	$("#gym_container").html(r.message);
	$("#gym_strength").html(r.user.strength);
	$("#gym_strength_rank").html(r.srank);
	$("#gym_agility").html(r.user.agility);
	$("#gym_agility_rank").html(r.arank);
	$("#gym_guard").html(r.user.guard);
	$("#gym_guard_rank").html(r.grank);
	$("#gym_labour").html(r.user.labour);
	$("#gym_labour_rank").html(r.lrank);
	UpdateUserStats(r.user);
	$(":input").attr("readonly", false);
	$(":input").val(""+r.user.energy);
}

function workOut(skill,times){
	ajax.setVar("do", "gym");
	ajax.setVar("skill", skill);
	ajax.setVar("times", times);

	ajax.requestFile = "ajax.php";
	ajax.method = "POST";
	ajax.onLoading = whenLoading;
	ajax.onCompletion = whenCompleted;
	ajax.runAJAX();
	return false;
}

</script>



<?
$h->endpage();
?>