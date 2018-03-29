<?php
include "config.php";
global $_CONFIG;
define("MONO_ON", 1);
require "class/class_db_{$_CONFIG['driver']}.php";
$db=new database;
$db->configure($_CONFIG['hostname'],
 $_CONFIG['username'],
 $_CONFIG['password'],
 $_CONFIG['database'],
 $_CONFIG['persistent']);
$db->connect();
$c=$db->connection_id;
include "global_func.php";
   $fetch = $db->query("SELECT * FROM `battle_ladders` ORDER BY `ladderLevel` ASC");
   while($ft = $db->fetch_row($fetch))
    {
      $count = 0;
      $sql = $db->query(sprintf("SELECT * FROM `battle_members` LEFT JOIN `users` ON `userid` = `bmemberUser` WHERE `bmemberLadder` = '%u' ORDER BY `bmemberScore` DESC LIMIT 10", $ft['ladderId']));
      while($r = $db->fetch_row($sql))
       {
         $count ++;
         $cash = ((((rand(500000, 750000) / 10) * $r['level']) / $count) * ($ft['ladderLevel'] + 1));
         $points = ((((rand(120, 250) / 10) * $r['level']) / $count) * ($ft['ladderLevel'] + 1));
         if($r['userid'])
          {
            $db->query(sprintf("UPDATE `users` SET `money` = `money` + '%d', `crystals` = `crystals` + '%d' WHERE `userid` = '%u'", $cash, $points, $r['bmemberUser']));
            event_add($r['bmemberUser'], 'You have earned $'.number_format($cash).' and '.number_format($points).' Points for achieveing rank #'.$count.' in the '.$ft['ladderName'].' ladder!');
          }
       }
    }
   $db->query("TRUNCATE TABLE battle_members;");
   
print "

<meta HTTP-EQUIV='REFRESH' content='5; url=staff.php?action=cmanual'>
<style type='text/css'>
.style2 {
    text-align: center;
}
.style3 {
    text-align: center;
    color: #008000;
}
.style4 {
    color: #FFFFFF;
}
</style>


<body style='background-color: #000000'>

<h2 class='style3'>Cron Job Successfully Ran</h2>

<div class='style2'>
    <h3>

<a href='staff.php?action=cmanual'><span class='style4'>Back</span></a></h3>
</div> 

";
   
?>