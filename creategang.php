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
if($ir['user_level'] == 2) {
$file = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $file);
$pfile = $break[count($break) - 1];
//echo $pfile;
echo "This file was last modified on: " .date("d/m/Y",filemtime($pfile));
}
if($ir['money'] < 500000)
{
die("<p>You don't have enough money. You need \$500,000.");
}
if($ir['gang'])
{
die ("You're already in a gang!");
}
if($_POST['submit'])
{
$name=htmlspecialchars($_POST['name']);
$name=stripslashes($_POST['name']);
$desc=htmlspecialchars($_POST['desc']);
$desc=stripslashes($_POST['desc']);
$string = $name;
$first = substr($string, 0, 3);
if (strlen($name)== 0)
{
    print("Please enter a gang name.
    <br><a href=creategang.php>Try Again</a>
    ");
    
    exit;
}

if (strlen($desc)== 0)
{
    print("Please enter gang description.
    <br><a href=creategang.php>Try Again</a> </b>
    ");
    
    exit;
}

$sql = sprintf("INSERT INTO gangs VALUES('', '%s', '%s', '%s', 0, 0, 0, 100, '%u', '%u', 5, 0, 0, 'Welcome')", $name, $desc, $first, $userid, $userid);
$db->query($sql);
$i=$db->insert_id();
$query=sprintf("UPDATE users SET gang=$i,money=money-500000 where userid=$userid");
mysql_query($query);
print "Gang created!";
}
else
{
print "<h3> Create A Gang </h3><form action='creategang.php' method='post'><input type='hidden' name='submit' value='1' />Name:<input type='text' STYLE='color: black;  background-color: white;' name='name' /><br />Description:<br /> <textarea name='desc' cols='40' rows='7'></textarea> <br /><input type='submit' STYLE='color: black;  background-color: white;' value='Create Gang for \$500,000' /></form>";
}
$h->endpage();
?>