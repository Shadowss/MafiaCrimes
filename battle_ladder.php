<?php
include_once ('globals.php');
switch($_GET['page'])
{
case 'signup': ladder_signup(); break;
default: ladder_index(); break;
}
function ladder_index()
{
global $ir, $db;
if(!isset($_GET['id']))
{
echo '

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Battle Ladder</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

<a href="battle_ladder.php?page=signup"><b>Join a ladder</b></a><br /><br />

<table width=80% cellspacing=1 class="table"><tr style="background: gray; "><th>ID</th> <th>Ladder Name</th> <th>Level Required</th> </tr> ';
$fetch = $db->query("SELECT * FROM `battle_ladders` ORDER BY `ladderLevel` ASC");
while ($r = $db->fetch_row($fetch)) 
{
$count ++;
echo ' <tr><td> '.$count.'. </td><td><a href="battle_ladder.php?id='.$r['ladderId'].'">'.stripslashes($r['ladderName']).'</a></td><td> '.$r['ladderLevel'].' ';
}
echo '</td></tr></table> </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
}
else
{
$fetch = $db->query(sprintf("SELECT * FROM `battle_members` LEFT JOIN `users` ON `userid` = `bmemberUser` WHERE `bmemberLadder` = '%u' ORDER BY `bmemberScore` DESC", abs((int) $_GET['id'])));
if(!$db->num_rows($fetch))
{
echo 'This battle ladder does not exist at this time, or there are no members using the ladder at this time.';
exit;

}



else

  
$sql = $db->query(sprintf("SELECT * FROM `battle_ladders` WHERE `ladderId` = '%u'", abs((int) $_GET['id'])));
$r = $db->fetch_row($sql); 
  {
         echo '      
<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> '.stripslashes($r['ladderName']).'</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>
         <table width="600" class="table">
         <tr>
         <th width="10%">Rank</th>
         <th width="40%">Name</th>
         <th width="20%">Score</th>
         <th width="15%">Wins</th>
         <th width="15%">Losses</th>
         </tr>';
         while($r = $db->fetch_row($fetch))
          {
            $count ++;
            echo '<tr>
            <td align="center">'.$count.'</td>
            <td><a href="viewuser.php?u='.$r['userid'].'">'.$r['username'].'</a></td>
            <td>'.number_format($r['bmemberScore']).'</td>
            <td>'.$r['bmemberWins'].'</td>
            <td>'.$r['bmemberLosses'].'</td>
            </tr>'; 
          }
       }
    }    

 }
print "</table>  ";
$h->endpage();
 exit;

 
function ladder_signup()
 {
   global $ir, $db;
   if(!isset($_GET['id']))
    {
      echo '
      
<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Join a ladder</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>

      You are qualified to join one of the ladders shown below.<br /><br />
      <table width="300" class="table">
      <tr>
      <td>';
      $fetch = $db->query(sprintf("SELECT * FROM `battle_ladders` WHERE `ladderLevel` <= '%d' ORDER BY `ladderLevel` ASC", $ir['level']));
      while ($r = $db->fetch_row($fetch)) 
       {
         echo '<a href="battle_ladder.php?page=signup&id='.$r['ladderId'].'">'.stripslashes($r['ladderName']).'</a><br />';
       }
      echo '</td>
      </tr>
      </table> </div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>';
    }
   else
    {
      $check = $db->query(sprintf("SELECT * FROM `battle_members` WHERE `bmemberUser` = '%u'", $ir['userid']));
      if($db->num_rows($check))
       {
         echo 'You are part of another ladder at this time, wait for that to finish before joining another.';
       }
      else
       {
         $sql = $db->query(sprintf("SELECT * FROM `battle_ladders` WHERE `ladderId` = '%u'", abs((int) $_GET['id'])));
         $r = $db->fetch_row($sql);
         if($r['ladderLevel'] > $ir['level'])
          {
            echo 'You are not experienced enough to join this ladder right now.';
          }
         else
          {
            $db->query(sprintf("INSERT INTO `battle_members` (`bmemberId`, `bmemberUser`, `bmemberLadder`, `bmemberScore`) VALUES ('NULL','%u', '%d', '%d')", $ir['userid'], $r['ladderId'], 100));
            echo 'You have signed up to the '.stripslashes($r['ladderName']).', attack other members of that ladder to increase the score.';
          }
       }
    }
 }
$h->endpage(); 
?>