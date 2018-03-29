<?php
require 'inc/config.php';
?>
<html><head>
<title>More Clickable Smilies</title>
</head>
<BODY BGCOLOR="#000000" TEXT="#ffffff" LINK="#ff0000" VLINK="#808080">

<script language=javascript>
function SmileIT(smile,form,text){
window.opener.document.forms[form].elements[text].value = window.opener.document.forms[form].elements[text].value+" "+smile+" ";
window.opener.document.forms[form].elements[text].focus();
window.close();
}
</script>

<div align="center">
	<h1>Click on the smilie you want to use</h1>
	<br>
	<a href="javascript: window.close()"><? echo CLOSE; ?></a>
</div>

<table width="100%" cellpadding="1" cellspacing="1">
<tr><td bgcolor="#888888">Code</td><td bgcolor="#888888">Smilie</td><td bgcolor="#888888">Code</td><td bgcolor="#888888">Smilie</td></tr>
<?
$count = 0;
while ((list($code, $url) = each($smilies))) {
	if ($count % 2==0)
		print("<tr>");

	print("<td align=\"left\"  bgcolor=\"#444444\">$code</td><td align=\"left\" bgcolor=\"#222222\"><a href=\"javascript: SmileIT('".str_replace("'","\'",$code)."','".$_GET["form"]."','".$_GET["text"]."')\"><img border=0 style=\"max-width: 100px\" src=images/smilies/".$url."></a></td>");
	$count++;
	if ($count % 2==0)
		print("\n</tr>");
	}
?>
</tr>
</table>
<div align="center">
<a href="javascript: window.close()"><? echo CLOSE; ?></a>
</div>