<?php


include_once('globals.php');

if($ir['user_level'] != 2) //The admin
	{
		echo "You are not allowed in here";
		exit($h->endpage());
	}

if(!$_GET)
	{
		return index();
	}

echo "<a href='shoutarea.php'>Back To ShoutBox</a><br />";	

	
switch($_GET['p'])
	{
		case 'systemShout' : sshout(); break;
		case 'banPlayer' : banPlayer(); break;
		case 'unban' : unBan(); break;
		case 'del' : del(); break;
        case 'clear' : clear(); break;
		default: index(); break;
	}

function index()
	{
		echo " <br>
        <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h2 style='padding-top:10px;'> Shout Box - Panel</h2></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>


<table width='300' class=table bgcolor='black' border='2'>
<tr>
<td colspan='100%'><center>
<b>Manage Shout Box:</b></center></td></tr>
<tr><td><a href='?p=systemShout'>System Shout</a></td>
<td> <a href='?p=banPlayer'>ShoutBan a Player</a> </td></tr>
<tr><td> <a href='?p=unban'>UnBan a Player</a> </td>
<td> <a href='?p=clear'>Clear ShoutBox</a> </td></tr>

</td>
</tr>
</table> </div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div> <br/> ";
	}
	
function sshout()
	{
		global $db;
		
		if(isset($_POST['shout']))
			{
				echo "<div style='background: #6EFF70;' width='100%'>Done!</div><br />";
				$db->query("INSERT INTO `shoutarea` VALUES ('NULL', 0, '{$_POST['shout']}', ".date("d").")");
			}
		echo "<form action='#' method='post'>
		  <input type='text' name='shout' size='50' STYLE='color: black;  background-color: white;' length='15' maxlength='100'>
		  <input type='submit' STYLE='color: black;  background-color: white;' value='Shout'>
		  </form>";
	}

function banPlayer()
	{
		global $db;
		
		if(isset($_POST['user']))
			{
				$_POST['user'] == (int) abs($_POST['user']);
				$_POST['days'] == (int) abs($_POST['days']);
				$maxUser = $db->fetch_row($db->query("SELECT COUNT(`userid`) AS `m` FROM `users`"));
				if(!is_numeric($_POST['user']) || !is_numeric($_POST['days']) || $_POST['user'] > $maxUser['m'] || strlen($_POST['days']) < 1)
					{
						echo "<div style='background: #FF0000;' width='100%'>Either the user doesn't exist or you didn't put in a numerical value</div><br />";
						exit;
					}
					
				echo "<div style='background: #6EFF70;' width='100%'>User Banned!</div><br />";
				$info = array($_POST['reason'], $_POST['days']);
				$insert = implode("|", $info);
				$db->query("UPDATE users SET `sA_Ban`='$insert' WHERE `userid`={$_POST['user']}");
			}
		echo "<form action='#' method='post'>
		  Userid: <input type='text' STYLE='color: black;  background-color: white;' name='user' length='5' maxlength='5'>
		  	<br />
		  Reason: <input type='text' STYLE='color: black;  background-color: white;' name='reason' length='15' maxlength='75'>
		  	<br />
		  Days: <input type='text' STYLE='color: black;  background-color: white;' name='days' length='5' maxlength='3'>
		  	<br /> <br />
		  <input type='submit' STYLE='color: black;  background-color: white;' value='Ban Player'>
		  </form>";
	}

function unban()
	{
		global $db;
		
		if(isset($_POST['user']))
			{
				$_POST['user'] == (int) abs($_POST['user']);
				$maxUser = $db->fetch_row($db->query("SELECT COUNT(`userid`) AS `m` FROM `users`"));
				$Banned = $db->fetch_row($db->query("SELECT `sA_Ban` FROM `users` WHERE `userid`={$_POST['user']}"));
				@$banned = explode("|", $Banned['sA_Ban']);
				if(!is_numeric($_POST['user']) || $_POST['user'] > $maxUser['m'] || @$banned[1] < 1)
					{
						echo "<div style='background: #FF0000;' width='100%'>Either the user doesn't exist or you didn't put in a numerical value or they are not banned</div><br />";
						exit;
					}
					
				echo "<div style='background: #6EFF70;' width='100%'>User Unbanned!</div><br />";
				$db->query("UPDATE users SET `sA_Ban`=0 WHERE `userid`={$_POST['user']}");
			}
		echo "<form action='#' method='post'>
		  Userid: <input type='text' name='user' STYLE='color: black;  background-color: white;' length='5' maxlength='5'>
		  	<br /><br />
		  <input type='submit' STYLE='color: black;  background-color: white;' value='Unban Player'>
		  </form>";
	}
	
function del()
	{
		global $db;
		
		$_GET['s'] == (int) abs($_GET['s']);
		$inTable = $db->fetch_row($db->query("SELECT `Key` FROM `shoutarea` WHERE `Key`={$_GET['s']}"));
		if(!$_GET['s'] OR !$inTable)
			{
						echo "<div style='background: #FF0000;' width='100%'>Invalid Shout</div><br />";
						exit;
			}
		else
			{
				echo "<div style='background: #6EFF70;' width='100%'>Deleted!</div><br />";
				$db->query("DELETE FROM `shoutarea` WHERE `Key`={$_GET['s']}");
			}
	}
    
 
 function clear()
    {
        global $db;
        
            {
                echo "<div style='background: #6EFF70;' width='100%'>Shout Box Cleared</div><br />";
                $db->query("TRUNCATE TABLE shoutarea;");
                $db->query("INSERT INTO `shoutarea` VALUES ('NULL', 0, 'ShoutBox Cleared', ".date("d").")");
            }

    }

    
?>
