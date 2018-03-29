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

require "core.php"; 

require 'inc/config.php';

function valid_email($email) {
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!ereg("^(([A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }  
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}
print <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>{$set['game_name']} - $metar </title>
<meta name="keywords" content="RPG, Online Games, Online Mafia Game" />
<meta name="description" content=" {$set['game_name']} - Online Mafia Game " />
<meta name="author" content="Mafia Crimes" />
<meta name="copyright" content="Copyright {$_SERVER['HTTP_HOST']} " />
<link rel="SHORTCUT ICON" href="favicon.ico" />
<link rel="stylesheet" href="css/stylenew.css" type="text/css"/>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen"/>
<!--<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="js/lightbox.js"></script>-->
<script type="text/javascript" src="js/jquery-1.js"></script>
</head>
<body>
    <div id="pagecontainer">
        <!-- Header Part Starts -->
            <div class="headerpart">
                <div ></div>
                <div class="toplist">
                                   
                </div>
            </div>
            
            
<script language="JavaScript">
<!--

function getCookieVal (offset) {
  var endstr = document.cookie.indexOf (";", offset);
  if (endstr == -1)
    endstr = document.cookie.length;
  return unescape(document.cookie.substring(offset, endstr));
}
function GetCookie (name) {
  var arg = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;
  while (i < clen) {
    var j = i + alen;
    if (document.cookie.substring(i, j) == arg)
      return getCookieVal (j);
    i = document.cookie.indexOf(" ", i) + 1;
    if (i == 0) break;
  }
  return null;
}
function SetCookie (name,value,expires,path,domain,secure) {
  document.cookie = name + "=" + escape (value) +
    ((expires) ? "; expires=" + expires.toGMTString() : "") +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") +
    ((secure) ? "; secure" : "");
}

function DeleteCookie (name,path,domain) {
  if (GetCookie(name)) {
    document.cookie = name + "=" +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      "; expires=Thu, 01-Jan-70 00:00:01 GMT";
  }
}
// -->
</script>

<script language="JavaScript">
var usr;
var pw;
var sv;
function getme()
{
usr = document.login.username;
pw = document.login.password;
sv = document.login.save;

    if (GetCookie('player') != null)
    {
        usr.value = GetCookie('username')
        pw.value = GetCookie('password')
        if (GetCookie('save') == 'true')
        {
            sv[0].checked = true;
        }
    }

}
function saveme()
{
    if (usr.value.length != 0 && pw.value.length != 0)
    {
        if (sv[0].checked)
        {
            expdate = new Date();
            expdate.setTime(expdate.getTime()+(365 * 24 * 60 * 60 * 1000));
            SetCookie('username', usr.value, expdate);
            SetCookie('password', pw.value, expdate);
            SetCookie('save', 'true', expdate);
        }
        if (sv[1].checked)
        {
            DeleteCookie('username');
            DeleteCookie('password');
            DeleteCookie('save');
        }
    }
        else
    {
        alert('$javaerr1');
        return false;
    }
}
</script>



<script type="text/javascript">
var xmlHttp // xmlHttp variable

function GetXmlHttpObject(){ // This function we will use to call our xmlhttpobject.
var objXMLHttp=null // Sets objXMLHttp to null as default.
if (window.XMLHttpRequest){ // If we are using Netscape or any other browser than IE lets use xmlhttp.
objXMLHttp=new XMLHttpRequest() // Creates a xmlhttp request.
}else if (window.ActiveXObject){ // ElseIf we are using IE lets use Active X.
objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP") // Creates a new Active X Object.
} // End ElseIf.
return objXMLHttp // Returns the xhttp object.
} // Close Function

function CheckPasswords(password){ // This is our fucntion that will check to see how strong the users password is.
xmlHttp=GetXmlHttpObject() // Creates a new Xmlhttp object.
if (xmlHttp==null){ // If it cannot create a new Xmlhttp object.
alert ("Browser does not support HTTP Request") // Alert Them!
return // Returns.
} // End If.

var url="check.php?password="+escape(password) // Url that we will use to check the password.
xmlHttp.open("GET",url,true) // Opens the URL using GET
xmlHttp.onreadystatechange = function () { // This is the most important piece of the puzzle, if onreadystatechange = equal to 4 than that means the request is done.
if (xmlHttp.readyState == 4) { // If the onreadystatechange is equal to 4 lets show the response text.
document.getElementById("passwordresult").innerHTML = xmlHttp.responseText; // Updates the div with the response text from check.php
} // End If.
}; // Close Function
xmlHttp.send(null); // Sends NULL insted of sending data.
} // Close Function.

function CheckUsername(password){ // This is our fucntion that will check to see how strong the users password is.
xmlHttp=GetXmlHttpObject() // Creates a new Xmlhttp object.
if (xmlHttp==null){ // If it cannot create a new Xmlhttp object.
alert ("Browser does not support HTTP Request") // Alert Them!
return // Returns.
} // End If.

var url="checkun.php?password="+escape(password) // Url that we will use to check the password.
xmlHttp.open("GET",url,true) // Opens the URL using GET
xmlHttp.onreadystatechange = function () { // This is the most important piece of the puzzle, if onreadystatechange = equal to 4 than that means the request is done.
if (xmlHttp.readyState == 4) { // If the onreadystatechange is equal to 4 lets show the response text.
document.getElementById("usernameresult").innerHTML = xmlHttp.responseText; // Updates the div with the response text from check.php
} // End If.
}; // Close Function
xmlHttp.send(null); // Sends NULL insted of sending data.
} // Close Function.

function CheckEmail(password){ // This is our fucntion that will check to see how strong the users password is.
xmlHttp=GetXmlHttpObject() // Creates a new Xmlhttp object.
if (xmlHttp==null){ // If it cannot create a new Xmlhttp object.
alert ("Browser does not support HTTP Request") // Alert Them!
return // Returns.
} // End If.

var url="checkem.php?password="+escape(password) // Url that we will use to check the password.
xmlHttp.open("GET",url,true) // Opens the URL using GET
xmlHttp.onreadystatechange = function () { // This is the most important piece of the puzzle, if onreadystatechange = equal to 4 than that means the request is done.
if (xmlHttp.readyState == 4) { // If the onreadystatechange is equal to 4 lets show the response text.
document.getElementById("emailresult").innerHTML = xmlHttp.responseText; // Updates the div with the response text from check.php
} // End If.
}; // Close Function
xmlHttp.send(null); // Sends NULL insted of sending data.
} // Close Function.

function PasswordMatch()
{
pwt1=document.getElementById('pw1').value;
pwt2=document.getElementById('pw2').value;
if(pwt1 == pwt2)
{
document.getElementById('cpasswordresult').innerHTML="<font color='green'>$rrerr5</font>";
}
else
{
document.getElementById('cpasswordresult').innerHTML="<font color='red'>$rrerr6</font>";
}
}
</script>
  
            
            

            <div class="flashpart">
              <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="1000" height="460" title="Mafia Crimes">
                <param name="movie" value="images/mafia.swf" />
                <param name="quality" value="high" />
                <param name="wmode" value="Transparent" />
                <embed src="images/mafia.swf" quality="high"  wmode="transparent" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="1000" height="460"></embed>
              </object>
            </div>
 
         <div class="menu">
                <ul>
                    <li class="home_active"><a href="login.php" title="Home">&nbsp;</a></li>
                    <li class="story"><a href="story.php" title="The Story">&nbsp;</a></li>
                    <li class="contact"><a href="contact.php" title="Contact Us">&nbsp;</a></li>
                    <li class="signup"><a href="signup.php" title="Sign Up">&nbsp;</a></li>
                </ul>            
            </div>

    
<br><br>
<div align='center' style='width: 1000px;height:600px; background-image:url(images/reg_para_bg.jpg); border:0px solid #999;'>
<div class='reg_container'>
<div class='reg_frmpart'>
<form action=signup.php method=post> 
<div class='regtop'>
<div class='reg_nametxt'>                                              
                                                        
                                                        
EOF;
$IP = $_SERVER['REMOTE_ADDR'];
$IP=addslashes($IP);
$IP=mysql_real_escape_string($IP);
$IP=strip_tags($IP);
if(file_exists('ipbans/'.$IP))
{
die("<b><font color=red size=+1>$ipban</font></b></body></html>");
}
if($_POST['username'])
{
if($set['regcap_on'])
{
  if(!$_SESSION['captcha'] or $_SESSION['captcha'] != $_POST['captcha'])
  {
    unset($_SESSION['captcha']);
    print " 
    <p> $rrerr0 </p> 
    

    ";
      exit;
  }
  unset($_SESSION['captcha']);
}
if(!valid_email($_POST['email']))
{
    
print " 
<P ALIGN='CENTER'> $rrerr1 
<br><br><b><a href=signup.php>$rrerr2</a>  </p>
";
exit;

    
}
if(strlen($_POST['username']) < 4)
{
    
    
print "
<P ALIGN='CENTER'> $rrerr3b 
<br><br><b><a href=signup.php>$rrerr2</a>  </p> 

";
      exit;

    
}
$sm=100;
if($_POST['promo'] == "Your Promo Code Here")
{
$sm+=100;
}
$username=$_POST['username'];
$username=str_replace(array("<", ">"), array("&lt;", "&gt;"), $username);
$q=$db->query("SELECT * FROM users WHERE username='{$username}' OR login_name='{$username}'");
$q2=$db->query("SELECT * FROM users WHERE email='{$_POST['email']}'");
if($db->num_rows($q))
{
print " 
<P ALIGN='CENTER'> $rrerr3 
<br><br><b><a href=signup.php>$rrerr2</a>  </p> 


";
      exit;
}
else if($db->num_rows($q2))
{
print "
<P ALIGN='CENTER'>   $rrerr3a 
<br><br><b><a href=signup.php>$rrerr2</a>  <br><br><b><a href=signup.php>$rrerr2</a>  </p>


";
      exit;
}
else if($_POST['password'] != $_POST['cpassword'])
{
print " 

<P ALIGN='CENTER'> $rrerr4 <br><br><b><a href=signup.php>$rrerr2</a>  </p>

";
      exit;
}
else
{
$_POST['ref'] = abs((int) $_POST['ref']);
$IP = $_SERVER['REMOTE_ADDR'];
$IP=addslashes($IP);
$IP=mysql_real_escape_string($IP);
$IP=strip_tags($IP);
$q=$db->query("SELECT * FROM users WHERE lastip='$IP' AND userid={$_POST['ref']}");
if($db->num_rows($q))
{
print " 

<P ALIGN='CENTER'> $nomulti <br><br><b><a href=signup.php>$rrerr2</a>  </p>";                                                                 
exit;
}



if($_POST['ref']) {
$q=$db->query("SELECT * FROM users WHERE userid={$_POST['ref']}");
$r=$db->fetch_row($q);
}
$db->query("INSERT INTO users (username, display_pic, login_name, userpass, level, money, crystals, donatordays, user_level, energy, maxenergy, will, maxwill, brave, maxbrave, hp, maxhp, location, gender, signedup, email, bankmoney, lastip, lastip_signup) VALUES( '{$username}', 'http://{$_SERVER['HTTP_HOST']}/images/avatar.gif', '{$username}', md5('{$_POST['password']}'), 1, $sm, 0, 0, 1, 12, 12, 100, 100, 5, 5, 100, 100, 1, '{$_POST['gender']}', unix_timestamp(), '{$_POST['email']}', -1, '$IP', '$IP')");   
$i=$db->insert_id();
$class = 0 + $_POST['class'];
if(!$class || $class > MAX_CLASS)
	$class=1;
$db->query("INSERT INTO userstats (userid,strength,agility,guard,labour,IQ,robskill,class) VALUES($i, ".$settings['CLASS_SIGNUP'][$class]["strength"].", ".$settings['CLASS_SIGNUP'][$class]["agility"].", ".$settings['CLASS_SIGNUP'][$class]["guard"].", ".$settings['CLASS_SIGNUP'][$class]["labour"].", ".$settings['CLASS_SIGNUP'][$class]["IQ"].", ".$settings['CLASS_SIGNUP'][$class]["robskill"].",$class)");

if($_POST['ref']) {
require "global_func.php";
$db->query("UPDATE users SET crystals=crystals+2 WHERE userid={$_POST['ref']}");
event_add($_POST['ref'],"For refering $username to the game, you have earnt 2 valuable crystals!",$c);
$db->query("INSERT INTO referals VALUES('', {$_POST['ref']}, $i, unix_timestamp(),'{$r['lastip']}','$IP')");
}
print "

<P ALIGN='CENTER'>$regsucess <br><br><b><a href=login.php>$reglogin</a>  </p> 
";
}
}
else
{
if($set['regcap_on'])
{  $chars="123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!?\\/%^";
  $len=strlen($chars);
  $_SESSION['captcha']="";
  for($i=0;$i<6;$i++)
  $_SESSION['captcha'].=$chars[rand(0, $len - 1)];
}



print "
<table width='100%' class='table' cellspacing='1'>
<tr>
<td width='25%'>$ruser</td>
<td width='25%'> <div class='reg_namebox'> <input type=text name=username onkeyup='CheckUsername(this.value);'></div></td>
<td width='50%'><div id='usernameresult'></div></td>
</tr>
<tr>
<td>$rpass</td>
<td><div class='reg_namebox'><input type=password id='pw1' name=password onkeyup='CheckPasswords(this.value);PasswordMatch();'></div></td>
<td><div id='passwordresult'></div></td>
</tr>
<tr>
<td>$rcpass</td><td><div class='reg_namebox'><input type=password name=cpassword id='pw2' onkeyup='PasswordMatch();'></div></td>
<td><div id='cpasswordresult'></div></td>
</tr>
<tr>
<td>$remail</td><td> <div class='reg_namebox'> <input type=text name=email onkeyup='CheckEmail(this.value);'></div></td>
<td><div id='emailresult'></div></td>
</tr>
<tr>
<td>$rgender</td>
<td colspan='2' ><div class='reg_namebox'><select name='gender' style='width: 120px; height:23px; border:0px; padding:3px 0px 0px 6px; color: white;  background-color: #111;' type='dropdown'>
<option value='Male'>$rmal</option>
<option value='Female'>$rfem</option></select></div></td>
</tr>
<tr>
<td>".$rclass['class']."</td>
<td colspan='2'><div class='reg_classbox'><select id='class_select' name='class' style='width: 120px; height:23px; border:0px; padding:3px 0px 0px 6px; color: white;  background-color: #111;' type='dropdown'>
<option value='1'>".$rclass['name']['gangster']."</option>
<option value='2'>".$rclass['name']['pimp']."</option>
<option value='3'>".$rclass['name']['lady']."</option></select></div></td>
</tr>
<input type=hidden name=ref value='
";


if($_GET['REF']) { print $_GET['REF']; }
print "' />";
if($set['regcap_on'])
{
print " <tr><td>Enter Captcha Code</td><td><div class='reg_namebox'><input type='text'  name='captcha' /></div></td><td><img src='captcha_verify.php?bgcolor=C3C3C3' width='200' height='23'/></td></tr> ";
}
print "
<tr> 
 <td colspan=3 align=center>
  <div class='reg_nametxt'><input type=submit value=$rreg id='reg_btn'></div>
 </td>
</tr>
</table><div class='regtop'> </div>    
</div>
</div>
</form>
</div>
<div class='regtop'> </div>   
<div class='reg_class'>
 <div class='reg_class_body'>
  <div class='reg_class_img1_selected' onclick='change(1)'><img src='./images/pixel.png' width='100%' height='100%'></div>
  <div class='reg_class_descr'><p>".$settings['CLASS_DES'][1]."</p></div>
 </div>
 <div class='reg_class_body'>
  <div class='reg_class_img2' onclick='change(2)'><img src='./images/pixel.png' width='100%' height='100%'></div>
  <div class='reg_class_descr'><p>".$settings['CLASS_DES'][2]."</p></div>
 </div>
 <div class='reg_class_body'>
  <div class='reg_class_img3' onclick='change(3)'><img src='./images/pixel.png' width='100%' height='100%'></div>
  <div class='reg_class_descr'><p>".$settings['CLASS_DES'][3]."</p></div>
 </div>
</div>
</div>
</div>
</div>
";
?>
<script>
var selected = 1;
function change(value){
	$("select.#class_select").val(value);
	$(".reg_class_img"+selected+"_selected").addClass("reg_class_img"+selected).removeClass("reg_class_img"+selected+"_selected");
	selected = value;
	$(".reg_class_img"+selected).addClass("reg_class_img"+selected+"_selected").removeClass("reg_class_img"+selected);
}
$("select.#class_select").change(function(){
	change($(this).val());
});
</script>

<?
} 

print <<<OUT

 <!--  Do Not Remove Powered By Ravan Scripts without permission .
              
However, if you would like to use the script without the powered by links you may do so by purchasing a Copyright removal license for a very low fee.   -->

<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

OUT;

include "lfooter.php";  


?>


