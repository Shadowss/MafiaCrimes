<?php
include "globals.php";

$_POST['search'] = mysql_real_escape_string($_POST['search']);
$_POST['save'] = mysql_real_escape_string($_POST['save']);
$_POST['clear'] = mysql_real_escape_string($_POST['clear']);

if($_POST['search'])
{
$_POST['moneymin'] = abs(@intval($_POST['moneymin']));
$_POST['daysmax'] = abs(@intval($_POST['daysmax']));
$_POST['daysmin'] = abs(@intval($_POST['daysmin']));
$_POST['levelmin'] = abs(@intval($_POST['levelmin']));
$_POST['levelmax'] = abs(@intval($_POST['levelmax']));
$_POST['id'] = mysql_real_escape_string($_POST['id']);
$_POST['location'] = abs(@intval($_POST['location']));
$_POST['name'] = mysql_real_escape_string($_POST['name']);


$levelmin_clause="WHERE level >= {$_POST['levelmin']}";
$levelmax_clause=" AND level <= {$_POST['levelmax']}";
$id_clause=($_POST['id']) ? " AND userid LIKE('%{$_POST['id']}%')" : "";
$name_clause=($_POST['name']) ? " AND username LIKE('%{$_POST['name']}%')" : "";
$location_clause=($_POST['location']) ? " AND location LIKE('{$_POST['location']}')" : "";
$online_clause=($_POST['online']) ? " AND laston >= unix_timestamp()" : "";

$daysmin_clause=($_POST['daysmin']) ? " AND daysold >= {$_POST['daysmin']}" : "";
$daysmax_clause=($_POST['daysmax']) ? " AND daysold <= {$_POST['daysmax']}" : "";
$moneymin_clause=($_POST['moneymin']) ? " AND money > {$_POST['moneymin']}" : "";


$q=$db->query("SELECT * FROM users $levelmin_clause$levelmax_clause$id_clause$name_clause$location_clause$online_clause$daysmin_clause$daysmax_clause$moneymin_clause",$c);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h4 style='padding-top:10px;'> Search Result<br>"; print mysql_num_rows($q)." User(s) found !</h4></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width='75%' class= 'table' border='2' >
<tr colspan=1 class='table'><th>User</th><th>Level</th><th>Money</th><th>Add Contact</th><th>Attack</th></tr>   "; 

while($r=mysql_fetch_array($q))
{


print "


<tr><td><a href='viewuser.php?u={$r['userid']}'>";


print" {$r['username']}";

print"

</a></td><td>{$r['level']}</td><td>\${$r['money']}</td><td><a href='contactlist.php?action=add&ID={$r['userid']}'>[Add Contact]</a></td><td><a href='attack.php?ID={$r['userid']}'>[Attack]</a></td></tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";


}
else if($_POST['save'])
{


$_POST['moneymin'] = abs(@intval($_POST['moneymin']));
$_POST['daysmax'] = abs(@intval($_POST['daysmax']));
$_POST['daysmin'] = abs(@intval($_POST['daysmin']));
$_POST['levelmin'] = abs(@intval($_POST['levelmin']));
$_POST['levelmax'] = abs(@intval($_POST['levelmax']));
$_POST['id'] = mysql_real_escape_string($_POST['id']);
$_POST['location'] = abs(@intval($_POST['location']));
$_POST['name'] = mysql_real_escape_string($_POST['name']);


$levelmin_clause="WHERE level >= {$_POST['levelmin']}";
$levelmax_clause=" AND level <= {$_POST['levelmax']}";
$id_clause=($_POST['id']) ? " AND userid LIKE('%{$_POST['id']}%')" : "";
$name_clause=($_POST['name']) ? " AND username LIKE('%{$_POST['name']}%')" : "";
$location_clause=($_POST['location']) ? " AND location LIKE('{$_POST['location']}')" : "";

$online_clause=($_POST['online']) ? " AND laston >= unix_timestamp()" : "";

$daysmin_clause=($_POST['daysmin']) ? " AND daysold >= {$_POST['daysmin']}" : "";
$daysmax_clause=($_POST['daysmax']) ? " AND daysold <= {$_POST['daysmax']}" : "";
$moneymin_clause=($_POST['moneymin']) ? " AND money > {$_POST['moneymin']}" : "";


$q=$db->query("SELECT * FROM users $levelmin_clause$levelmax_clause$id_clause$name_clause$location_clause$online_clause$daysmin_clause$daysmax_clause$moneymin_clause",$c);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h4 style='padding-top:10px;'>Search Result<br>"; print mysql_num_rows($q)." User(s) found ! </h4></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<table width='75%' class= 'table' border='2' >
<tr colspan=1 class='table'><th>User</th><th>Level</th><th>Money</th><th>Add Contact</th><th>Attack</th></tr>   "; 

while($r=mysql_fetch_array($q))
{

print "
<tr><td><a href='viewuser.php?u={$r['userid']}'>";
print" {$r['username']}";
print"</a></td><td>{$r['level']}</td><td>\${$r['money']}</td><td><a href='contactlist.php?action=add&ID?={$r['userid']}'>[Add Contact]</a></td><td><a href='attack.php?ID={$r['userid']}'>[Attack]</a></td></tr>";
}
print "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";

$sql = sprintf("SELECT * FROM search WHERE userid = %d ", $ir['userid']);

$q1 = mysql_query($sql);
if(mysql_num_rows($q1) > 0)
{

$updatesearch = sprintf
(
    "UPDATE `search` SET `id` = '%s', `moneymin` = '%d', `daysmax` = '%s', `daysmin` = '%s', `levelmin` = '%d', `levelmax` = '%d', `location` = '%d', name = '%s', `online` = '%s' WHERE `userid` = ('%u')",
    
    $_POST['id'],
    $_POST['moneymin'], 
    $_POST['daysmax'],  
    $_POST['daysmin'] ,
    $_POST['levelmin'],
    $_POST['levelmax'],
    $_POST['location'],
    $_POST['name'],
    $_POST['online'],
    $ir['userid']

    
);


$db->query($updatesearch);
}

else 
{
$insertsearch = sprintf
(
    "INSERT INTO `search` values ('' , '%u' , '%u' , '%s' , '%s' , '%u' , '%u' , '%s' , '%u' , '%s', '%s' )",
    
    $ir['userid'],
    $_POST['moneymin'], 
    $_POST['daysmax'],  
    $_POST['daysmin'] ,
    $_POST['levelmin'],
    $_POST['levelmax'],
    $_POST['id'],
    $_POST['location'],
    $_POST['name'],
    $_POST['online']
    

    
);


$db->query($insertsearch);
}


}





else if($_POST['clear'])
{
$sql = sprintf("SELECT * FROM search WHERE userid = %d ", $ir['userid']);

$q1 = mysql_query($sql);
if(mysql_num_rows($q1) > 0)
{

$deletesearch = sprintf
(
    "DELETE FROM `search` WHERE `userid` = ('%u')",
    

    $ir['userid']

    
);


$db->query($deletesearch);
print"last Search has been Deleted";
}
else
{
print"You have no searches saved to delete...!!";
}
}


?>