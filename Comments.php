<?php


include(DIRNAME(__FILE__).'/globals.php');

if(isset($_GET['Delete']))
{
$Data = mysql_query("SELECT `RecieverID` FROM `gComments` WHERE (`ID` = ".abs(intval($_GET['ID'])).") AND (`RecieverID` = ".$_SESSION['userid'].")",$c);

if(mysql_num_rows($Data))
{
mysql_query("DELETE FROM `gComments` WHERE (`ID` = ".abs(intval($_GET['ID'])).")");
echo ('The comment chose has been deleted. <br /><a href = "index.php"><span style = "color:#8B0000">Go Home</span></a><br />');
exit($h->endpage());

}
else{
echo ('This comment doesn\'t belong to you.<br /><a href = "index.php"><span style = "color:#8B0000">Go Home</span></a><br />'); 
exit($h->endpage());
}
}
if((isset($_POST['comment'])))
{
if(empty($_POST['comment']))
{
echo ('You\'ve failed to fill the form in correctly.');
exit($h->endpage());
}

mysql_query("INSERT INTO `gComments` VALUES ('',
".$_SESSION['userid'].",
".abs(intval($_GET['ID'])).",
'".mysql_real_escape_string(strip_tags($_POST['comment']))."')",$c);
event_add(abs(intval($_GET['ID'])), ''.mysql_real_escape_string($ir['username']).' has just left a comment on your profile!');

echo ('Your comment has successfully been posted.<br /><a href ="index.php"<span style = "color:#8B0000">Go Home</span></a>');
exit($h->endpage());
}
else{

echo ('

<div class="generalinfo_txt">
<div><img src="images/info_left.jpg" alt="" /></div>
<div class="info_mid"><h2 style="padding-top:10px;"> Posting Comments</h2></div>
<div><img src="images/info_right.jpg" alt="" /></div> </div>
<div class="generalinfo_simple"><br> <br><br>


<form action = "Comments.php?ID='.$_GET['ID'].'" method = "post">
<input type = "text" size="50" STYLE="color: black;  background-color: white;"  name = "comment" value = "" /><br />
<input type = "submit" STYLE="color: black;  background-color: white;" value = "Post Comment" />
</form><br />
<a href = "index.php"><span style = "color:#8B0000">Go Back</span></a><br /></div><div><img src="images/generalinfo_btm.jpg" alt="" /></div><br></div></div></div></div></div>');
}
?> 