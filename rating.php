<?php

require "globals.php";
$ID = mysql_real_escape_string($_GET['ID']);
$action = mysql_real_escape_string($_GET['action']);

switch($action) {
case 'goodrating':
good_rating();
break;
case 'badrating':
bad_rating();
break;
}

if(!$ID) {
  echo "Error - invaild player id.";
  $h->endpage();
  exit;
}
if(!$action) {
  echo "Error - invaild action.";
  $h->endpage();
  exit;
}

function good_rating() {
global $ir,$userid,$db;

if($ir['rates'] > 0){

$ID = mysql_real_escape_string($_GET['ID']);

if($ID == $userid) {
die("You cannot rate yourself.");
}
else {
$result = $db->query("SELECT * FROM users WHERE userid='{$ID}'");

while($row = $db->fetch_row($result)) {
  $gratings = $row['ratings'];
  }
$db->query("UPDATE users SET ratings = {$gratings}+1 WHERE userid='{$ID}'");
$db->query("UPDATE users SET rates = '0' WHERE userid='{$userid}'");
echo "You gave the user a good rating";
}
}
else {
die("You can only rate once a day.");
}

}



function bad_rating() {
global $ir,$userid,$db;

if($ir['rates'] > 0){

$ID = mysql_real_escape_string($_GET['ID']);
if($ID == $userid) {
die("You cannot rate yourself.");
}
else {
$result = $db->query("SELECT * FROM users WHERE userid='{$ID}'");

while($row = $db->fetch_row($result)) {
  $bratings = $row['ratings'];
  }
$db->query("UPDATE users SET ratings = {$bratings}-1 WHERE userid='{$ID}'");
$db->query("UPDATE users SET rates = '0' WHERE userid='{$userid}'");
echo "You gave the user a bad rating";
}
}
else {
die("You can only rate once a day.");
}
}

$h->endpage();
?>