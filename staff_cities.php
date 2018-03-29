<?php
include "sglobals.php";
if($ir['user_level'] > 2)
{
die("403");
}
//This contains city stuffs
switch($_GET['action'])
{
case "addcity": addcity(); break;
case "editcity": editcity(); break;
case "delcity": delcity(); break;
default: print "Error: This script requires an action."; break;
}
function addcity()
{
global $db, $ir, $c, $h, $userid;
$minlevel=abs((int) $_POST['minlevel']);
$travtime=abs((int) $_POST['travtime']);
$name=$_POST['name'];
$desc=$_POST['desc'];
if($minlevel and $desc and $name and $travtime)
{
$q=$db->query("SELECT * FROM cities WHERE cityname='{$name}'");
if($db->num_rows($q))
{
print "Sorry, you cannot have two cities with the same name.";
$h->endpage();
exit;
}

$db->query("INSERT INTO cities VALUES(NULL, '$name', '$desc', '$minlevel', '$travtime')");
print "City {$name} added to the game.";
stafflog_add("Created City $name");
}
else
{
print " <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Add City</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>

<form action='staff_cities.php?action=addcity' method='post'>
Name: <input type='text' STYLE='color: black;  background-color: white;' name='name' /><br />
Description: <input type='text' STYLE='color: black;  background-color: white;' name='desc' /><br />
Minimum Level: <input type='text' STYLE='color: black;  background-color: white;' name='minlevel' /><br />
Travel Time: <input type='text' STYLE='color: black;  background-color: white;' name='travtime' /><br /> 

<input type='submit' STYLE='color: black;  background-color: white;' value='Add City' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function editcity()
{
global $db, $ir, $c, $h, $userid;
switch($_POST['step'])
{
case "2":
$minlevel=abs((int) $_POST['minlevel']);
$travtime=abs((int) $_POST['travtime']);
$name=$_POST['name'];
$desc=$_POST['desc'];
$q=$db->query("SELECT * FROM cities WHERE cityname='{$name}' AND cityid!={$_POST['id']}");
if($db->num_rows($q))
{
print "Sorry, you cannot have two cities with the same name.";
$h->endpage();
exit;
}
$name=$_POST['name'];
$q=$db->query("SELECT * FROM cities WHERE cityid={$_POST['id']}");
$old=$db->fetch_row($q);
$db->query("UPDATE cities SET cityminlevel=$minlevel, citytravtime=$travtime, citydesc='$desc', cityname='$name' WHERE cityid={$_POST['id']}");
print "City $name was edited successfully.";
stafflog_add("Edited city $name");
break;
case "1":
$q=$db->query("SELECT * FROM cities WHERE cityid={$_POST['city']}");
$old=$db->fetch_row($q);
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing a City</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>



<form action='staff_cities.php?action=editcity' method='post'>
<input type='hidden' name='step' value='2' />
<input type='hidden' name='id' value='{$_POST['city']}' />
Name: <input type='text' STYLE='color: black;  background-color: white;' name='name' value='{$old['cityname']}' /><br />
Description: <input type='text' STYLE='color: black;  background-color: white;' name='desc' value='{$old['citydesc']}' /><br />
Minimum Level: <input type='text' STYLE='color: black;  background-color: white;' name='minlevel' value='{$old['cityminlevel']}' /><br />
Travel Time: <input type='text' STYLE='color: black;  background-color: white;' name='travtime' value='{$old['citytravtime']}' /><br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit City' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
default:
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Editing a City</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>



<form action='staff_cities.php?action=editcity' method='post'>
<input type='hidden' name='step' value='1' />
City: ".location_dropdown($c, "city")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Edit City' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
break;
}
}
function delcity()
{
global $db,$ir,$c,$h,$userid;
if($_POST['city'])
{
$q=$db->query("SELECT * FROM cities WHERE cityid={$_POST['city']}");
$old=$db->fetch_row($q);
if($old['cityid']==1)
{
die("This city cannot be deleted.");
}

$db->query("UPDATE users SET location=1 WHERE location={$old['cityid']}");
$db->query("UPDATE shops SET shopLOCATION=1 WHERE shopLOCATION={$old['cityid']}");
$db->query("DELETE FROM cities WHERE cityid={$old['cityid']}");
print "City {$old['cityname']} deleted.";
stafflog_add("Deleted city {$old['cityname']}");
}
else
{
print "

<div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Delete City</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


Deleting a city is permanent - be sure. Any users and shops that are currently in the city you delete will be moved to the default city (ID 1).<form action='staff_cities.php?action=delcity' method='post'>
City: ".location_dropdown($c, "city")."<br />
<input type='submit' STYLE='color: black;  background-color: white;' value='Delete City' /></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
}
function report_clear()
{
global $db,$ir,$c,$h,$userid;
if($ir['user_level'] > 3)
{
die("403");
}
$_GET['ID'] = abs((int) $_GET['ID']);
stafflog_add("Cleared player report ID {$_GET['ID']}");
$db->query("DELETE FROM preports WHERE prID={$_GET['ID']}");
print "Report cleared and deleted!<br />
<a href='staff_users.php?action=reportsview'>> Back</a>";
}
$h->endpage();
?>