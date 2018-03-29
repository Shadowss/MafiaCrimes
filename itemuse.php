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

include "globals.php";
$_GET['ID'] = abs((int) $_GET['ID']);
//Food
if(!$_GET['ID'])
{
print "
<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>


Invalid Use of the item ! <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

</div></div>

"

;
}
else
{
$i=$db->query("SELECT iv.*,i.*,it.* FROM inventory iv LEFT JOIN items i ON iv.inv_itemid=i.itmid LEFT JOIN itemtypes it ON i.itmtype=it.itmtypeid WHERE iv.inv_id={$_GET['ID']} AND iv.inv_userid=$userid");
if(mysql_num_rows($i) == 0)
{
print "

<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

Invalid item ID ! <br><br>

<a href='inventory.php'><font color='white'>Back To Inventory</font></a>

</div></div> 

";
}
else
{
$r=$db->fetch_row($i);
if(!$r['effect1_on'] && !$r['effect2_on'] && !$r['effect3_on'])
{
    
print "
  
<div id='mainOutput' style='text-align: center; color: red;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>
  
Sorry, this item cannot be used as it has no effect. <br><br>
  
<a href='inventory.php'><font color='white'>Back To Inventory</font></a> 

  
  ";

$h->endpage(); 
exit;
  
  
}
if($r['effect1_on'])
{
  $einfo=unserialize($r['effect1']);
  if($einfo['inc_type']=="percent")
  {
    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
    {

      $inc=round($ir['max'.$einfo['stat']]/100*$einfo['inc_amount']);
    }
    else
    {
      $inc=round($ir[$einfo['stat']]/100*$einfo['inc_amount']);
    }
  }
  else
  {
    $inc=$einfo['inc_amount'];
  }
  if($einfo['dir']=="pos")
  {
    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
    {
      $ir[$einfo['stat']]=min($ir[$einfo['stat']]+$inc, $ir['max'.$einfo['stat']]);
    }
    else
    {
      $ir[$einfo['stat']]+=$inc;
    }
  }
  else
  {

      $ir[$einfo['stat']]=max($ir[$einfo['stat']]-$inc, 0);

  }
  $upd=$ir[$einfo['stat']];
  if(in_array($einfo['stat'], array('strength', 'agility', 'guard', 'labour', 'IQ')))
  {
    $db->query("UPDATE `userstats` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
  }
  else
  {
    $db->query("UPDATE `users` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
  }
}
if($r['effect2_on'])
{
  $einfo=unserialize($r['effect2']);
  if($einfo['inc_type']=="percent")
  {
    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
    {

      $inc=round($ir['max'.$einfo['stat']]/100*$einfo['inc_amount']);
    }
    else
    {
      $inc=round($ir[$einfo['stat']]/100*$einfo['inc_amount']);
    }
  }
  else
  {
    $inc=$einfo['inc_amount'];
  }
  if($einfo['dir']=="pos")
  {
    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
    {
      $ir[$einfo['stat']]=min($ir[$einfo['stat']]+$inc, $ir['max'.$einfo['stat']]);
    }
    else
    {
      $ir[$einfo['stat']]+=$inc;
    }
  }
  else
  {

      $ir[$einfo['stat']]=max($ir[$einfo['stat']]-$inc, 0);

  }
  $upd=$ir[$einfo['stat']];
  if(in_array($einfo['stat'], array('strength', 'agility', 'guard', 'labour', 'IQ')))
  {
    $db->query("UPDATE `userstats` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
  }
  else
  {
    $db->query("UPDATE `users` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
  }
}
if($r['effect3_on'])
{
  $einfo=unserialize($r['effect3']);
  if($einfo['inc_type']=="percent")
  {
    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
    {

      $inc=round($ir['max'.$einfo['stat']]/100*$einfo['inc_amount']);
    }
    else
    {
      $inc=round($ir[$einfo['stat']]/100*$einfo['inc_amount']);
    }
  }
  else
  {
    $inc=$einfo['inc_amount'];
  }
  if($einfo['dir']=="pos")
  {
    if(in_array($einfo['stat'],array('energy','will','brave','hp')))
    {
      $ir[$einfo['stat']]=min($ir[$einfo['stat']]+$inc, $ir['max'.$einfo['stat']]);
    }
    else
    {
      $ir[$einfo['stat']]+=$inc;
    }
  }
  else
  {

      $ir[$einfo['stat']]=max($ir[$einfo['stat']]-$inc, 0);

  }
  $upd=$ir[$einfo['stat']];
  if(in_array($einfo['stat'], array('strength', 'agility', 'guard', 'labour', 'IQ')))
  {
    $db->query("UPDATE `userstats` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
  }
  else
  {
    $db->query("UPDATE `users` SET {$einfo['stat']} = '{$upd}' WHERE userid={$userid}");
  }
}
print "

<div id='mainOutput' style='text-align: center; color: green;  width: 600px; border: 1px solid #222222; height: 70px;
margin: 0 auto 10px; clear: both; position: relative; left: -20px; padding: 8px'>

{$r['itmname']} used successfully!  <br><br>
  
<a href='inventory.php'><font color='white'>Back To Inventory</font></a>  </div></div>   

";
item_remove($userid, $r['inv_itemid'], 1);
}
}
$h->endpage();
?>
