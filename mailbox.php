<?php

/**************************************************************************************************
| Software Name        : Mafia Game Scripts Online Mafia Game
| Software Author      : Mafia Game Scripts
| Software Version     : Version 2.3.1 Build 2301
| Website              : http://www.mafiagamescript.net/
| E-mail               : support@mafiagamescript.net
|**************************************************************************************************
| The source files are subject to the Mafia Game Script End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Mafia Game Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Mafia Game Script . All rights reserved.
|**************************************************************************************************/

include "globals.php";

if($ir['mailban']){
die("<font color=red><h3>! ERROR</h3>"._MAIL_BANNED." {$ir['mailban']} "._DAYS.".<br />
<br />
<b>"._REASON.": {$ir['mb_reason']}</font></b>");
}
$_GET['ID'] = abs((int) $_GET['ID']);

print "
<div class='generalinfo_txt'>
	<div><img src='images/info_left.jpg' alt='' /></div>
	<div class='info_mid'><h2 style='padding-top:10px;'> "._MAIL_HEAD." </h2></div>
	<div><img src='images/info_right.jpg' alt='' /></div>
</div>
<div class='generalinfo_simple'><br> <br><br>
	<table width=85% class='table' cellspacing='1'>
	   <tr>
	     <td align=center><a href='mailbox.php?action=inbox'><img src='images/indox.gif' title='Inbox'></a></td>
                   <td align=center><a href='mailbox.php?action=outbox'><img src='images/sent.gif' title='Sent Messages'></a></td>
	     <td align=center><a href='mailbox.php?action=compose'><img src='images/compose.gif' title='Compose'></a></td>
	     <td align=center><a href='mailbox.php?action=delall'><img src='images/deleteall.gif' title='Delete All Messages'></a></td>
	     <td align=center><a href='mailbox.php?action=archive'><img src='images/archiveall.gif' title='Archive All Messages'></a></td>
	     <td align=center><a href='contactlist.php'><img src='images/contacts.gif' title='Contacts List'></a></td>
	   </tr>
	</table><br />
";
switch($_GET['action'])
{
case 'inbox':
mail_inbox();
break;

case 'outbox':
mail_outbox();
break;

case 'compose':
mail_compose();
break;

case 'delb': 
delb(); 
break;

case 'send':
mail_send();
break;

case 'delall':
mail_delall();
break;

case 'delall2':
mail_delall2();
break;

case 'archive':
mail_archive();
break;

default:
mail_inbox();
break;
}
function mail_inbox(){
	global $db,$ir,$c,$userid,$h,$lang;
	print <<<OUT
		{$lang(_INBOX_MESSAGE)}<br><br />
		<table width=75% class="table" border="0" cellspacing="1">
		<tr>
		<td class="h" width="30%">{$lang(_MAIL_FROM)}</td>
		<td class="h" width="70%">{$lang(_SUBJECT)}/{$lang(_MESSAGE)}</td>
		</tr>
OUT;
	$q=$db->query("SELECT m.*,u.* FROM mail m LEFT JOIN users u ON m.mail_from=u.userid WHERE m.mail_to=$userid ORDER BY mail_time DESC LIMIT 25");
	while($r=$db->fetch_row($q)){
		$sent=date('F j, Y, g:i:s a',$r['mail_time']);
		print "<tr><td>";
		if($r['userid']){
			print "<a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]";
		}else{
			print "SYSTEM";
		}
		$fm=urlencode($r['mail_text']); 
		print <<<EOF
			</td>
			<td>{$r['mail_subject']}</td>
			</tr>
			<tr>
			<td>{$lang(_SENT_AT)}: {$sent}<br /><a href='mailbox.php?action=compose&ID={$r['userid']}'>{$lang(_REPLY)}</a>
			<br />
			<a href='?action=delb&ID={$r['mail_id']}'>{$lang(_DELETE)}</a>
			<br />
			</td>
			<td>{$r['mail_text']}</td>
			</tr>
EOF;
	}
	if($ir['new_mail'] > 0){
		$db->query("UPDATE mail SET mail_read=1 WHERE mail_to=$userid");
		$db->query("UPDATE users SET new_mail=0 WHERE userid=$userid");
	}
	echo "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>";
}
function mail_outbox(){
global $db,$ir,$c,$userid,$h; 
print _OUTBOX_MESSAGE."<br />
	<table width=75% cellspacing=1 class='table' ><tr style='background:gray'><th> "._MAIL_TO."</th><th>"._SUBJECT."/"._MESSAGE."</th></tr>";
	$q=$db->query("SELECT m.*,u.* FROM mail m LEFT JOIN users u ON m.mail_to=u.userid WHERE m.mail_from=$userid ORDER BY mail_time DESC LIMIT 25");
	if($r=$db->fetch_row($q)){
		$sent=date('F j, Y, g:i:s a',$r['mail_time']);
		print "<tr><td><a href='viewuser.php?u={$r['userid']}'>{$r['username']}</a> [{$r['userid']}]</td><td>{$r['mail_subject']}</td></tr><tr><td>"._SENT_AT.": $sent<br /></td><td>{$r['mail_text']}</td></tr>";
	}
	echo "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>";

} 


function mail_compose(){
	global $ir,$c,$userid,$h,$lang;
	echo <<< EOF
		<script type="text/javascript">
		function insert(el,ins) {
if (el.setSelectionRange){
el.value = el.value.substring(0,el.selectionStart) + ins + el.value.substring(el.selectionStart,el.selectionEnd) +

el.value.substring(el.selectionEnd,el.value.length);
}
else if (document.selection && document.selection.createRange) {
el.focus();
var range = document.selection.createRange();
range.text = ins + range.text;
}
}
</script>
<form action='mailbox.php?action=send' method='post'>
<table width=75% border=2> <tr>
<td>{$lang(_ID_RECEIVER)}:</td> <td><input type='text' STYLE='color: black;  background-color: white;' name='userid' value='{$_GET['ID']}'/></td></tr><tr>
<td>{$lang(_SUBJECT)}:</td> <td><input type='text' STYLE='color: black;  background-color: white;' name='subject'/></td></tr><tr>
<td>{$lang(_MESSAGE)}:</td>
<td>

<textarea name='message' rows='10' cols='70' style='color: black; background-color: white'></textarea><br />
<input type="image" src="smilies/smiley1.gif" alt="Smile" title="smile" onclick="insert(this.form.message,':)'); return false;" />
<input type="image" src="smilies/smiley2.gif" alt="Wink" title="Wink" onclick="insert(this.form.message,';)'); return false;" />
<input type="image" src="smilies/smiley3.gif" alt="Suprised" title="Suprised" onclick="insert(this.form.message,':o'); return false;" />
<input type="image" src="smilies/smiley4.gif" alt="Cheesy Grin" title="Cheesy Grin" onclick="insert(this.form.message,':D'); return false;" />
<input type="image" src="smilies/smiley5.gif" alt="Confused" title="Confused" onclick="insert(this.form.message,':s'); return false;" />
<input type="image" src="smilies/smiley6.gif" alt="Sad" title="Sad" onclick="insert(this.form.message,':('); return false;" />
<input type="image" src="smilies/smiley7.gif" alt="Angry" title="Angry" onclick="insert(this.form.message,':red'); return false;" />
<input type="image" src="smilies/smiley8.gif" alt="Clown" title="Clown" onclick="insert(this.form.message,':clown'); return false;" />
<input type="image" src="smilies/smiley9.gif" alt="Embarrassed" title="Embarrassed" onclick="insert(this.form.message,':bashful'); return false;" />
<input type="image" src="smilies/smiley10.gif" alt="Star" title="Star" onclick="insert(this.form.message,':x'); return false;" />
<input type="image" src="smilies/smiley11.gif" alt="Sick" title="Sick" onclick="insert(this.form.message,':green'); return false;" />
<input type="image" src="smilies/smiley12.gif" alt="Bored" title="Bored" onclick="insert(this.form.message,':|'); return false;" />
<input type="image" src="smilies/smiley13.gif" alt="Begging" title="Begging" onclick="insert(this.form.message,';('); return false;" />
<input type="image" src="smilies/smiley14.gif" alt="Smug" title="Smug" onclick="insert(this.form.message,':]'); return false;" />
<input type="image" src="smilies/smiley15.gif" alt="Horny" title="Horny" onclick="insert(this.form.message,':horny'); return false;" />
<input type="image" src="smilies/smiley16.gif" alt="Cool" title="Cool" onclick="insert(this.form.message,':cool'); return false;" /></center>
</td></tr><tr>
</td></tr><td colspan=2><input type='submit' STYLE='color: black;  background-color: white;' value='{$lang(_SEND)}' class='btn'></td></tr></table></form></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>
EOF;

if($_GET['ID'])
{
print("<div><img src='images/generalinfo_top.jpg' alt='' /></div>
	<div class='generalinfo_simple'>");
print "<br /><table width=75% border=2><tr><td colspan=2><b>{$lang(_OUTBOX_MESSAGES)}:</b></td></tr>";
$q=mysql_query("SELECT m.*,u1.username as sender from mail m left join users u1 on m.mail_from=u1.userid WHERE (m.mail_from=$userid AND m.mail_to= {$_GET['ID']} ) OR (m.mail_to=$userid AND m.mail_from={$_GET['ID']}) ORDER BY m.mail_time

DESC LIMIT 5",$c);
while($r=mysql_fetch_array($q))
{
$sent=date('F j, Y, g:i:s a',$r['mail_time']);
print "<tr><td>$sent</td> <td><b>{$r['sender']} "._WROTE.":</b> {$r['mail_text']}</td></tr>";
}
}

	echo "</table></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div>";

}

function mail_send(){
	global $ir,$c,$userid,$h;
	$sql=mysql_query("select max(userid) from users");
	$result=mysql_result($sql,$users);
	$_POST['userid']=(int) $_POST['userid'];
	if($_POST['userid'] > $result OR $_POST['userid'] ==0 ){
		print "Oh no, you're trying to mail a ghost.<br /><br /><a href='mailbox.php'>Back</a>";
		$h->endpage();
		exit;
	}
	if($userid==$_POST['userid'] ){
		print "Whats the point in mailing yourself ?<br /><br /><a href='mailbox.php'>Back</a>";
		$h->endpage();
		exit;
	}
	$subj= $_POST['subject'];
	$msg= $_POST['message'];
	$to= (int) $_POST['userid'];
	if(strlen($_POST['message']) < 5){
		print _COMPOSE_SHORT_MESSAGE;
		$h->endpage();
		exit;
	}
	mysql_query("INSERT INTO mail VALUES ('',0,$userid,$to,unix_timestamp(),".sqlesc($subj).",".sqlesc($msg).")",$c) or die(mysql_error());
	mysql_query("UPDATE users SET new_mail=new_mail+1 WHERE userid={$to}")  or die(mysql_error()); 
	print _COMPOSE_SENT;
}

function delb()
 {
global $db,$ir,$c,$userid,$h;
$db->query("DELETE FROM mail WHERE mail_id={$_GET['ID']} AND mail_to=$userid");
print "Message deleted!<br /><br />
<a href='mailbox.php'>Back</a>";
}

function mail_delall()
{
global $db,$ir,$c,$userid,$h;
print " 
       

This will delete all the messages in your mailbox.
There is <b>NO</b> undo, so be sure.<br />    <br />
<a href='mailbox.php?action=delall2'> Yes, delete all messages</a><br /> <br />
<a href='mailbox.php'>No, go back</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
function mail_delall2()
{
global $db,$ir,$c,$userid,$h;
$db->query("DELETE FROM mail WHERE mail_to=$userid");
print "All ".$db->affected_rows()." mails in your inbox were deleted.<br />
<a href='mailbox.php'>Back</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div></a>";
}
function mail_archive()
{
global $ir,$c,$userid,$h;
print "This tool will download an archive of all your messages.<br />
<a href='dlarchive.php?a=inbox'><br />Download Inbox</a><br /><br /
<a href='dlarchive.php?a=outbox'>Download Outbox</a></div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>";
}
$h->endpage();
?>
