<?php
/**
* Bleach Forums Improved and Optimized for TBDEV.NET by Alex2005
*/
include("include/bittorrent.php");
dbconn();
loggedinorreturn();

if($CURUSER['class_change'])
	$CURUSER['class'] = $CURUSER['class_change'];

if (function_exists('parked'))
	parked();
include("include/textbbcode.php");
/**
* Configs Start
*/
	/**
	* The max class, ie: UC_CODER
	*
	* Is able to delete, edit the forum etc...
	*/
	define('MAX_CLASS', UC_SYSOP);
	
	/**
	* The max file size allowed to be uploaded
	*
	* Default: 1024*1024 = 1MB
	*/
	$maxfilesize = 1024*1024;
	
	/**
	* Set's the max file size in php.ini, no need to change
	*/
	ini_set("upload_max_filesize", $maxfilesize);
	
	/**
	* Set's the root path, change only if you know what you are doing
	*/
	define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'].'/');
	
	/**
	* The path to the attachment dir, no slahses
	*/
	$attachment_dir = ROOT_PATH."forum_attachments";
	
	/**
	* The width of the forum, in percent, 100% is the full width
	*
	* Note: the width is also set in the function begin_main_frame()
	*/
	$forum_width = '100%';
	
	/**
	* The readpost expiry date, default 14 days
	*
	* Note: if you already have it, delete this one
	*/
	$READPOST_EXPIRY = 14*86400;
	
	/**
	* The extensions that are allowed to be uploaded by the users
	*
	* Note: you need to have the pics in the $pic_base_url folder, ie zip.gif, rar.gif
	*/
	//$pic_base_url = $pic_base_url."forumicons/";
	$allowed_file_extensions = array('rar', 'zip');
	
	/**
	* The max subject lenght in the topic descriptions, forum name etc...
	*/
	$maxsubjectlength = 60;
	
	/**
	* Get's the users posts per page, no need to change
	*/
	$postsperpage = (empty($CURUSER['postsperpage']) ? 25 : (int)$CURUSER['postsperpage']);
	
	/**
	* Set to true if you want to use the flood mod
	*/
	$use_flood_mod = true;
	
		/**
		* If there are more than $limit(default 10) posts in the last $minutes(default 5) minutes, it will give them a error...
		*
		* Requires the flood mod set to true
		*/
		$minutes = 5;
		$limit = 10;
	
	/**
	* Set to true if you want to use the attachment mod
	*
	* Requires 2 extra tables(attachments, attachmentdownloads), so efore enabling it, make sure you have them...
	*/
	$use_attachment_mod = true;
	
	/**
	* Set to true if you want to use the forum poll mod
	*
	* Requires 2 extra tables(postpolls, postpollanswers), so efore enabling it, make sure you have them...
	*/
	$use_poll_mod = true;
	
	/**
	* Set to false to disable the forum stats
	*/
	$use_forum_stats_mod = true;

	/**
	* Path to disable forum
	*/
		$generalbanfile = "cache/disableforums";

	/**
	* Change the pics to the ones you use
	*/
	$forum_pics = array('default_avatar' => 'forumicons/default_avatar.gif',
			'locked' 	=> 'forumicons/locked.png',
			'lockednew' 	=> 'forumicons/lockednew.png',
			'unlocked' 	=> 'forumicons/unlocked.png',
			'multipage' 	=> 'forumicons/multipage.gif',
			'unlockednew' 	=> 'forumicons/unlockednew.png',
			'sticky'	 	=> 'forumicons/sticky.gif',
			'arrow_up' 	=> 'forumicons/up.png',
	 		'online_btn' 	=> 'forumicons/button_online.gif',
			'offline_btn' 	=> 'forumicons/button_offline.gif', 	
			'pm_btn' 	=> 'forumicons/pm.png', 		
			'p_report_btn' 	=> 'forumicons/report.png',
			'p_quote_btn' 	=> 'forumicons/quote.png', 			
			'p_delete_btn' 	=> 'forumicons/delete.png', 	
			'p_edit_btn' 	=> 'forumicons/edit.png');

	/**
	* Just a check, so that the default url, wont have a ending backslash(to double backslash the links), no need to edit or delete
	*/
	$DEFAULTBASEURL_rev = strrev($DEFAULTBASEURL);
	if ($DEFAULTBASEURL_rev[0] == '/')
	{
		$DEFAULTBASEURL_rev[0] = '';
		$DEFAULTBASEURL = strrev($DEFAULTBASEURL_rev);
	}
/**
* Configs End
*/

$action = (isset($_GET["action"]) ? $_GET["action"] : (isset($_POST["action"]) ? $_POST["action"] : ''));

if (!function_exists('highlight'))
{
	function highlight($search, $subject, $hlstart = '<b><font color=red>', $hlend = '</font></b>')
	{
		$srchlen = strlen($search);    // lenght of searched string
		if ($srchlen == 0)
			return $subject;
		
		$find = $subject;
		while ($find = stristr($find, $search)) // find $search text in $subject -case insensitiv
		{
			$srchtxt = substr($find,0,$srchlen);    // get new search text
			$find = substr($find,$srchlen);
			$subject = str_replace($srchtxt, $hlstart.$srchtxt.$hlend, $subject);    // highlight founded case insensitive search text
		}
		
		return $subject;
	}
}

function catch_up($id = 0)
{	
	global $CURUSER, $READPOST_EXPIRY;
	
	$userid = (int)$CURUSER['id'];
	
	$res = mysql_query("SELECT t.id, t.lastpost, r.id AS r_id, r.lastpostread ".
					   "FROM topics AS t ".
					   "LEFT JOIN posts AS p ON p.id = t.lastpost ".
					   "LEFT JOIN readposts AS r ON r.userid=".sqlesc($userid)." AND r.topicid=t.id ".
					   "WHERE p.added > ".sqlesc(get_date_time(gmtime() - $READPOST_EXPIRY)).
					   (!empty($id) ? ' AND t.id '.(is_array($id) ? 'IN ('.implode(', ', $id).')' : '= '.sqlesc($id)) : '')) or sqlerr(__FILE__, __LINE__);

	while ($arr = mysql_fetch_assoc($res))
	{
		$postid = (int)$arr['lastpost'];
		
		if (!is_valid_id($arr['r_id']))
			mysql_query("INSERT INTO readposts (userid, topicid, lastpostread) VALUES($userid, ".(int)$arr['id'].", $postid)") or sqlerr(__FILE__, __LINE__);
		else if ($arr['lastpostread'] < $postid)
			mysql_query("UPDATE readposts SET lastpostread = $postid WHERE id = ".$arr['r_id']) or sqlerr(__FILE__, __LINE__);
	}
	mysql_free_result($res);
}

function forum_stats()
{
	global $pic_base_url, $forum_width, $DEFAULTBASEURL,$forum_pics;
	
	$forumusers = '';
	
	$res = mysql_query("SELECT id, username, donor, warned, class,smilie,enabled,leechwarn FROM users WHERE forum_access >= ".sqlesc(get_date_time(gmtime() - 300))." ORDER BY username ASC") or sqlerr(__FILE__, __LINE__);
	while ($arr = mysql_fetch_assoc($res))
	{
		if (!empty($forumusers))
			$forumusers .= ",\n";
		
		if (!function_exists('get_user_class_color'))
		{
			switch ($arr["class"])
			{
				case UC_SYSOP:
					$username = "<font color=darkred>" . $arr["username"] . "</font>";
				break;
				
				case UC_ADMINISTRATOR:
					$username = "<font color=#B000B0>" . $arr["username"] . "</font>";
				break;
				
				case UC_MODERATOR:
					$username = "<font color=#ff5151>" . $arr["username"] . "</font>";
				break;
				
				case UC_UPLOADER:
					$username = "<font color=#6464FF>" . $arr["username"] . "</font>";
				break;
				
				case UC_VIP:
					$username = "<font color=#009F00>" . $arr["username"] . "</font>";
				break;
				
				case UC_POWER_USER:
					$username = "<font color=#f9a200>" . $arr["username"] . "</font>";
				break;
				
				case UC_USER:
					$username = "<font color=#FF007F>" . $arr["username"] . "</font>";
				break;
			}
		}
		else
			$username = htmlspecialchars($arr["username"]);

			$forumusers .= "<nobr>";
		
		$forumusers .= "<a onmouseover=\"ajax_showTooltip('showtip.php?id={$arr[id]}',this);return false\" onmouseout=\"ajax_hideTooltip()\" href='$DEFAULTBASEURL/userdetails.php?id={$arr['id']}' class='special' id='".get_user_class_Color($arr['class'])."'>".$username.format_smilie($arr['smilie'])."</a>";
		$forumusers .= get_user_icons($arr);
		$forumusers .= "</nobr>";
	}
	if (empty($forumusers))
		$forumusers = "No users on-line";
	
	$topic_post_res = mysql_query("SELECT SUM(topiccount) AS topics, SUM(postcount) AS posts FROM forums");
	$topic_post_arr = mysql_fetch_assoc($topic_post_res);
	
	?>
	<br />
	<table width='<?php echo $forum_width; ?>' border=0 cellspacing=0 cellpadding=5>
        <tr>
            <td class="colhead" align="center">Now active in Forums:</td>
        </tr>
        
        <tr>
            <td class='text'><?php echo $forumusers; ?></td>
        </tr>
        
        <tr>
            <td class='colhead' align='center'><h2>Our members wrote <b><?php echo number_format($topic_post_arr['posts']); ?></b> Posts in <b><?php echo number_format($topic_post_arr['topics']); ?></b> Threads</h2></td>
        </tr>
	</table><?php
}

function show_forums($forid)
{
	global $CURUSER, $pic_base_url, $READPOST_EXPIRY, $DEFAULTBASEURL,$forum_pics;
	
	$forums_res = mysql_query("SELECT f.id, f.name, f.description, f.postcount, f.ledby, f.topiccount, f.minclassread, p.added, p.topicid, p.userid, p.id AS pid, u.username, u.class, u.smilie, t.subject, t.lastpost, r.lastpostread ".
							  "FROM forums AS f ".
							  "LEFT JOIN posts AS p ON p.id = (SELECT MAX(lastpost) FROM topics WHERE forumid = f.id) ".
							  "LEFT JOIN users AS u ON u.id = p.userid ".
							  "LEFT JOIN topics AS t ON t.id = p.topicid ".
							  "LEFT JOIN readposts AS r ON r.userid = ".sqlesc($CURUSER['id'])." AND r.topicid = p.topicid ".
							  "WHERE f.forid = $forid ".
							  "ORDER BY f.forid ASC") or sqlerr(__FILE__, __LINE__);
	
	while ($forums_arr = mysql_fetch_assoc($forums_res))
	{
		if (get_user_class() < $forums_arr["minclassread"])
			continue;
		$moderator = 0;	
		if(isset($forums_arr['ledby']))
			{
			$modres = mysql_query("select username,class,smilie from users where id=".sqlesc($forums_arr['ledby']));
			if(mysql_num_rows($modres))
				{
				$moderator = 1;
				$mod = mysql_fetch_assoc($modres);
				}
			}
		$forumid = (int)$forums_arr["id"];
		$lastpostid = (int)$forums_arr['lastpost'];
		
		if (is_valid_id($forums_arr['pid']))
		{
			$lastpost = "<nobr>".$forums_arr["added"]."<br />" .
						"by <a onmouseover=\"ajax_showTooltip('showtip.php?id={$forums_arr[userid]}',this);return false\" onmouseout=\"ajax_hideTooltip()\" href='$DEFAULTBASEURL/userdetails.php?id=".(int)$forums_arr["userid"]."' class='special' id='".get_user_class_color($forums_arr["class"])."'>".htmlspecialchars($forums_arr['username']).format_smilie($forums_arr['smilie'])."</a><br />" .
						"in <a href='".$_SERVER['PHP_SELF']."?action=viewtopic&topicid=".(int)$forums_arr["topicid"]."&amp;page=p$lastpostid#$lastpostid'><b>".htmlspecialchars($forums_arr['subject'])."</b></a></nobr>";

			$img = 'unlocked'.((($forums_arr['added']>(get_date_time(gmtime()-$READPOST_EXPIRY)))?((int)$forums_arr['pid'] > $forums_arr['lastpostread']):0)?'new':'');
		}
		else
		{
			$lastpost = "N/A";
			$img = "unlocked";
		}
	
		?><tr>
			<td align='left'>
				<table border=0 cellspacing=0 cellpadding=0>
					<tr>
						<td class=embedded style='padding-right: 5px'><img src="<?php echo $pic_base_url.$forum_pics[$img]; ?>"></td>
						<td class=embedded>
							<a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo $forumid; ?>'><b><?php echo htmlspecialchars($forums_arr["name"]); ?></b></a><?php
						if (get_user_class() >= UC_ADMINISTRATOR or $CURUSER['id'] == $forums_arr["ledby"])
						{
							?>&nbsp;<font class='small'>[<a class='altlink' href='<?php echo $_SERVER['PHP_SELF']; ?>?action=editforum&forumid=<?php echo $forumid; ?>'>Edit</a>]</font><?php
						}
						if (get_user_class() >= UC_ADMINISTRATOR)
						{
							?>&nbsp;<font class='small'>[<a class='altlink' href='<?php echo $_SERVER['PHP_SELF']; ?>?action=deleteforum&forumid=<?php echo $forumid; ?>'>Delete</a>]</font><?php
						}
						
						if (!empty($forums_arr["description"]))
						{
							?><br /><?php echo htmlspecialchars($forums_arr["description"]);
						}
						if($moderator)
							  print("<br/><b>Forums Led by:</b> <a onmouseover=\"ajax_showTooltip('showtip.php?id={$forums_arr[ledby]}',this);return false\" onmouseout=\"ajax_hideTooltip()\" href='userdetails.php?id=".$forums_arr["ledby"]."' class='special' id=".get_user_Class_color($mod['class']).">".htmlspecialchars($mod['username']).format_smilie($mod['smilie'])."</a>");
						?></td>
					</tr>
				</table>
			</td>
			<td align='center'><?php echo number_format($forums_arr["topiccount"]); ?></td>
			<td align='center'><?php echo number_format($forums_arr["postcount"]); ?></td>
			<td align='left'><?php echo $lastpost; ?></td>
		</tr><?php
	}
}

//-------- Returns the minimum read/write class levels of a forum
function get_forum_access_levels($forumid)
{
	$res = mysql_query("SELECT minclassread, minclasswrite, minclasscreate FROM forums WHERE id = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
	
	if (mysql_num_rows($res) != 1)
		return false;
	
	$arr = mysql_fetch_assoc($res);
	
	return array("read" => $arr["minclassread"], "write" => $arr["minclasswrite"], "create" => $arr["minclasscreate"]);
}

//-------- Returns the forum ID of a topic, or false on error
function get_topic_forum($topicid)
{
	$res = mysql_query("SELECT forumid FROM topics WHERE id = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
	
	if (mysql_num_rows($res) != 1)
		return false;
	
	$arr = mysql_fetch_assoc($res);
	
	return (int)$arr['forumid'];
}

//-------- Returns the ID of the last post of a forum
function update_topic_last_post($topicid)
{
	$res = mysql_query("SELECT MAX(id) AS id FROM posts WHERE topicid = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);

	$arr = mysql_fetch_assoc($res) or die("No post found");

	mysql_query("UPDATE topics SET lastpost = {$arr['id']} WHERE id = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
}

function get_forum_last_post($forumid)
{
	$res = mysql_query("SELECT MAX(lastpost) AS lastpost FROM topics WHERE forumid = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
	
	$arr = mysql_fetch_assoc($res);
	
	$postid = (int)$arr['lastpost'];
	
	return (is_valid_id($postid) ? $postid : 0);
}

//-------- Inserts a quick jump menu
function insert_quick_jump_menu($currentforum = 0)
{
	global $CURUSER, $DEFAULTBASEURL;
	
	?>
	<p align='center'>
	<form method='get' action='<?php echo $_SERVER['PHP_SELF']; ?>' name='jump'>
	<input type="hidden" name="action" value="viewforum">
	<div align='center'><b>Quick jump:</b>
	<select name='forumid' onChange="if(this.options[this.selectedIndex].value != -1){ forms['jump'].submit() }">
	<?php
	$res = mysql_query("SELECT id, name, minclassread FROM forums ORDER BY name") or sqlerr(__FILE__, __LINE__);
	
	while ($arr = mysql_fetch_assoc($res))
		if (get_user_class() >= $arr["minclassread"])
			echo "<option value=".$arr["id"].($currentforum == $arr["id"] ? " selected" : "").'>'.$arr["name"]."</option>";
	?>
	</select>
	<input type='submit' value='Go!' class='gobutton'>
	</div>
	</form>
	</p>
	<?php
}

//-------- Inserts a compose frame
function insert_compose_frame($id, $newtopic = true, $quote = false, $attachment = false)
{
	global $maxsubjectlength, $CURUSER, $max_torrent_size, $maxfilesize, $pic_base_url, $use_attachment_mod, $forum_pics, $DEFAULTBASEURL;
	
	if ($newtopic)
	{
		$res = mysql_query("SELECT name FROM forums WHERE id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
		$arr = mysql_fetch_assoc($res) or die("Bad forum ID!");
		
		?><h3>New topic in <a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo $id; ?>'><?php echo htmlspecialchars($arr["name"]); ?></a> forum</h3><?php
	}
	else
	{
		$res = mysql_query("SELECT subject, locked FROM topics WHERE id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
		$arr = mysql_fetch_assoc($res) or die("Forum error, Topic not found.");
		
		if ($arr['locked'] == 'yes')
		{
			stdmsg("Sorry", "The topic is locked.");
			
			end_table(); end_main_frame(); stdfoot();
			exit();
		}
		
		?><h3 align="center">Reply to topic: <a href='<?php echo $_SERVER['PHP_SELF']; ?>action=viewtopic&topicid=<?php echo $id; ?>'><?php echo htmlspecialchars($arr["subject"]); ?></a></h3><?php
	}
	
	begin_frame("Compose", true);
	
	?><form onsubmit="javascript: submitonce(this)"  method='post' name='compose' action='<?php echo $_SERVER['PHP_SELF']; ?>' enctype='multipart/form-data'>
	<input type="hidden" name="action" value="post" />
	<input type='hidden' name='<?php echo ($newtopic ? 'forumid' : 'topicid'); ?>' value='<?php echo $id; ?>'><?php
	
	begin_table(true);
	
	if ($newtopic)
	{
		?>
		<tr>
			<td class='rowhead' width="10%">Subject</td>
			<td align='left'>
				<input type='text' size='100' maxlength='<?php echo $maxsubjectlength; ?>' name='subject' style='border: 0px; height: 19px'>
			</td>
		</tr><?php
	}
		
	if ($quote)
	{
		$postid = (int)$_GET["postid"];
		if (!is_valid_id($postid))
		{
			stdmsg("Error", "Invalid ID!");
			
			end_table(); end_main_frame(); stdfoot();
			exit();
		}
		
		$res = mysql_query("SELECT posts.*, users.username,users.smilie FROM posts JOIN users ON posts.userid = users.id WHERE posts.id = $postid") or sqlerr(__FILE__, __LINE__);
		
		if (mysql_num_rows($res) == 0)
		{
			stdmsg("Error", "No post with this ID");
			
			end_table(); end_main_frame(); stdfoot();
			exit();
		}
		
		$arr = mysql_fetch_assoc($res);
	}
		
	?><tr>
		<td class='rowhead' width="10%">Body</td>
		<td><?php
		$qbody = ($quote ? "[quote=".htmlspecialchars($arr["username"])."]".htmlspecialchars(unesc($arr["body"]))."[/quote]" : '');
		if (function_exists('textbbcode'))
			textbbcode("compose", "body", $qbody);
		else
		{
			?><textarea name="body" style="width:99%" rows="7"><?php echo $qbody; ?></textarea><?php
		}
		
		if ($use_attachment_mod && $attachment)
		{
			?><tr>
				<td colspan='2'><fieldset class="fieldset"><legend>Add Attachment</legend>
					<input type='checkbox' name='uploadattachment' value='yes'>
					<input type="file" name="file" size="60">
                    <div class='error'>Allowed Files: rar, zip<br />Size Limit <?php echo mksize($maxfilesize); ?></div></fieldset>
				</td>
			</tr><?php
		}
		
		?><tr>
        	<td colspan='2' align='center'>
            <input type='submit' value='Submit'>
			</td>
		</tr>
        
		</td>
        </tr><?php
		
		end_table();
		
		?></form><?php
		
		?><p align='center'><a href='<?php echo $DEFAULTBASEURL; ?>/tags.php' target='_blank'>Tags</a> | <a href='<?php echo $DEFAULTBASEURL; ?>/smilies.php' target='_blank'>Smilies</a></p><?php
		
		end_frame();
		
		//------ Get 10 last posts if this is a reply
		if (!$newtopic)
		{
			$postres = mysql_query("SELECT p.id, p.added, p.body, u.id AS uid, u.username, u.smilie, u.class, u.avatar ".
								   "FROM posts AS p ".
								   "LEFT JOIN users AS u ON u.id = p.userid ".
								   "WHERE p.topicid = ".sqlesc($id)." ".
								   "ORDER BY p.id DESC LIMIT 10") or sqlerr(__FILE__, __LINE__);
			if (mysql_num_rows($postres) > 0)
			{
				?><br /><?php
				begin_frame("10 last posts, in reverse order");
				
				while ($post = mysql_fetch_assoc($postres))
				{
					$avatar = ($CURUSER["avatars"] == "yes" ? htmlspecialchars($post["avatar"]) : '');
					
					if (empty($avatar))
						$avatar = $pic_base_url.$forum_pics['default_avatar'];
					
					?><p class=sub>#<?php echo $post["id"]; ?> by <a onmouseover="ajax_showTooltip('showtip.php?id=<?php echo $post["uid"];?>',this);return false" onmouseout="ajax_hideTooltip()" class=special id=<?php print(get_user_class_color($post["class"]));?>><?php echo (!empty($post["username"]) ? $post["username"].format_smilie($post['smilie']) : "unknown[{$post['uid']}]"); ?></a> at <?php echo $post["added"]; ?> GMT</p><?php
					
					begin_table(true);
					
					?>
					<tr>
						<td height='100' width='100' align='center' style='padding: 0px' valign="top"><img height='100' width='100' src="<?php echo $avatar; ?>" /></td>
						<td class='comment' valign='top'><?php echo format_comment($post["body"]); ?></td>
					</tr><?php
					
					end_table();
				}
				
				end_frame();
			}
		}
		
		insert_quick_jump_menu();
}

//if ($action == 'updatetopic' && get_user_class() >= UC_MODERATOR)
if ($action == 'updatetopic')
{
	$topicid = (isset($_GET['topicid']) ? (int)$_GET['topicid'] : (isset($_POST['topicid']) ? (int)$_POST['topicid'] : 0));
	if (!is_valid_id($topicid))
		stderr('Error...', 'Invalid topic ID!');
	
	$topic_res = mysql_query('SELECT t.sticky, t.locked, t.subject, t.forumid, f.minclasswrite, f.ledby,f.topiccount, '.
						     '(SELECT COUNT(id) FROM posts WHERE topicid = t.id) As post_count '.
						     'FROM topics AS t '.
						     'LEFT JOIN forums AS f ON f.id = t.forumid '.
						     'WHERE t.id = '.sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($topic_res) == 0)
		stderr('Error...', 'No topic with that ID!');
	
	$topic_arr = mysql_fetch_assoc($topic_res);
	if($CURUSER['id'] != $topic_arr['ledby'])
		{
		if (get_user_class() < (int)$topic_arr['minclasswrite'])
			stderr('Error...', 'You are not allowed to edit this topic.');
		if(get_user_class() < UC_MODERATOR)
			stderr('Error...', 'You are not allowed to edit this topic.');
		}
	$forumid = (int)$topic_arr['forumid'];
	$subject = $topic_arr['subject'];
	
	if ((isset($_GET['delete']) ? $_GET['delete'] : (isset($_POST['delete']) ? $_POST['delete'] : '')) == 'yes')
	{
		if ((isset($_GET['sure']) ? $_GET['sure'] : (isset($_POST['sure']) ? $_POST['sure'] : '')) != 'yes')
			stderr("Sanity check...", "You are about to delete this topic: <b>".htmlspecialchars($subject)."</b>. Click <a href=".$_SERVER['PHP_SELF']."?action=$action&topicid=$topicid&delete=yes&sure=yes>here</a> if you are sure.");
		
		write_log("Topic <b>".$subject."</b> was deleted by <a href='$DEFAULTBASEURL/userdetails.php?id=".$CURUSER['id']."'>".$CURUSER['username']."</a>.");
		
		if ($use_attachment_mod)
		{
			$res = mysql_query("SELECT attachments.filename ".
							   "FROM posts ".
							   "LEFT JOIN attachments ON attachments.postid = posts.id ".
							   "WHERE posts.topicid = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
			
			while ($arr = mysql_fetch_assoc($res))
				if (!empty($arr['filename']) && is_file($attachment_dir."/".$arr['filename']))
					unlink($attachment_dir."/".$arr['filename']);
		}
		
		mysql_query("DELETE posts, topics ".
					($use_attachment_mod ? ", attachments, attachmentdownloads " : "").
					($use_poll_mod ? ", postpolls, postpollanswers " : "").
					"FROM topics ".
					"LEFT JOIN posts ON posts.topicid = topics.id ".
					($use_attachment_mod ? "LEFT JOIN attachments ON attachments.postid = posts.id ".
					"LEFT JOIN attachmentdownloads ON attachmentdownloads.fileid = attachments.id " : "").
					($use_poll_mod ? "LEFT JOIN postpolls ON postpolls.id = topics.pollid ".
					"LEFT JOIN postpollanswers ON postpollanswers.pollid = postpolls.id " : "").
					"WHERE topics.id = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
		
		header('Location: '.$_SERVER['PHP_SELF'].'?action=viewforum&forumid='.$forumid);
		exit();
	}
	
	$returnto = $_SERVER['PHP_SELF'].'?action=viewtopic&topicid='.$topicid;

	$updateset = array();
	
	$locked = ($_POST['locked'] == 'yes' ? 'yes' : 'no');
	if ($locked != $topic_arr['locked'])
		$updateset[] = 'locked = '.sqlesc($locked);
	
	$sticky = ($_POST['sticky'] == 'yes' ? 'yes' : 'no');
	if ($sticky != $topic_arr['sticky'])
		$updateset[] = 'sticky = '.sqlesc($sticky);
	
	$new_subject = $_POST['subject'];
	if ($new_subject != $subject)
	{
		if (empty($new_subject))
		  stderr('Error...', 'Topic name cannot be empty.');
	
		$updateset[] = 'subject = '.sqlesc($new_subject);
	}
	
	$new_forumid = (int)$_POST['new_forumid'];
	if (!is_valid_id($new_forumid))
		stderr('Error...', 'Invalid forum ID!');
	
	if ($new_forumid != $forumid)
	{
		$post_count = (int)$topic_arr['post_count'];

		$res = mysql_query("SELECT minclasswrite FROM forums WHERE id = ".sqlesc($new_forumid)) or sqlerr(__FILE__, __LINE__);
	
		if (mysql_num_rows($res) != 1)
			stderr("Error...", "Forum not found!");
		
		$arr = mysql_fetch_assoc($res);
		if (get_user_class() < (int)$arr['minclasswrite'])
			stderr('Error...', 'You are not allowed to move this topic into the selected forum.');
		
		$updateset[] = 'forumid = '.sqlesc($new_forumid);
		
		if($topic_arr['topiccount'])
			mysql_query("UPDATE forums SET topiccount = topiccount - 1, postcount = postcount - ".sqlesc($post_count)." WHERE id = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
		mysql_query("UPDATE forums SET topiccount = topiccount + 1, postcount = postcount + ".sqlesc($post_count)." WHERE id = ".sqlesc($new_forumid)) or sqlerr(__FILE__, __LINE__);
		
		$returnto = $_SERVER['PHP_SELF'].'?action=viewforum&forumid='.$new_forumid;
	}
	
	if (sizeof($updateset) > 0)
		mysql_query("UPDATE topics SET ".implode(', ', $updateset)." WHERE id = ".sqlesc($topicid));
	
	header('Location: '.$returnto);
	exit();
}
else if ($action == "editforum") //-------- Action: Edit Forum
{

	$forumid = (int)$_GET["forumid"];
	if (!is_valid_id($forumid))
		stderr('Error', 'Invalid ID!');
	
	$res = mysql_query("SELECT name, description, ledby, minclassread, minclasswrite, minclasscreate FROM forums WHERE id = $forumid") or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) == 0)
		stderr('Error', 'No forum found with that ID!');
	$forum = mysql_fetch_assoc($res);

	if($CURUSER['id'] != $forum['ledby'])
		if(get_user_class() != MAX_CLASS)
			{
			write_log("User <a href=userdetails.php?id=".$CURUSER['id'].">".htmlspecialchars($CURUSER['username'])."</a> Tried to modify forums! Tard!");
			stderr("Oups!","Retard Alert!");	
			}
	stdhead("Edit forum"); begin_main_frame(); begin_frame("Edit Forum", "center");
	
	print("<form method=post action=".$_SERVER['PHP_SELF']."?action=updateforum&forumid=$forumid>\n");
	begin_table();
	print("<tr><td class=rowhead>Forum name</td>" .
	"<td align=left style='padding: 0px'><input type=text size=60 maxlength=$maxsubjectlength name=name " .
	"style='border: 0px; height: 19px' value=\"".htmlspecialchars($forum['name'])."\"></td></tr>\n".
	"<tr><td class=rowhead>Description</td>" .
	"<td align=left style='padding: 0px'><textarea name=description cols=68 rows=3 style='border: 0px'>".htmlspecialchars($forum['description'])."</textarea></td></tr>\n".
	"<tr><td class=rowhead>Led by</td>".
	"<td align=left style='padding: 0px'><input name=ledby style='border: 0px' value='".htmlspecialchars($forum['ledby'])."'></td></tr>\n".
	"<tr><td class=rowhead></td><td align=left style='padding: 0px'>&nbsp;Minimum <select name=readclass>");
	for ($i = 0; $i <= MAX_CLASS; ++$i)
		if(get_user_class_name($i)!="") 
		print("<option value=$i" . ($i == $forum['minclassread'] ? " selected" : "") . ">" . get_user_class_name($i) . "</option>\n");
	print("</select> Class required to View<br>\n&nbsp;Minimum <select name=writeclass>");
	for ($i = 0; $i <= MAX_CLASS; ++$i)
		if(get_user_class_name($i)!="") 
		print("<option value=$i" . ($i == $forum['minclasswrite'] ? " selected" : "") . ">" . get_user_class_name($i) . "</option>\n");
	print("</select> Class required to Post<br>\n&nbsp;Minimum <select name=createclass>");
	for ($i = 0; $i <= MAX_CLASS; ++$i)
		if(get_user_class_name($i)!="") 
		print("<option value=$i" . ($i == $forum['minclasscreate'] ? " selected" : "") . ">" . get_user_class_name($i) . "</option>\n");
	print("</select> Class required to Create Topics</td></tr>\n".
	"<tr><td colspan=2 align=center><input type=submit value='Submit'></td></tr>\n");
	end_table();
	print("</form>");
	
	end_frame(); end_main_frame(); stdfoot();
	exit();
}
else if ($action == "updateforum") //-------- Action: Update Forum
{
	$forumid = (int)$_GET["forumid"];
	if (!is_valid_id($forumid))
		stderr('Error', 'Invalid ID!');
		
	$res = mysql_query('SELECT id,ledby FROM forums WHERE id = '.sqlesc($forumid));
	if (mysql_num_rows($res) == 0)
		stderr('Error', 'No forum with that ID!');
	
	$name = $_POST['name'];
	$description = $_POST['description'];
	$ledby = $_POST['ledby'];
 	if($_POST['ledby'] != $CURUSER['id'])	
		if(get_user_class() != MAX_CLASS)
			{
		        write_log("User <a href=userdetails.php?id=".$CURUSER['id'].">".$CURUSER['username']."</a> Tried to modify forums! Tard!");
			stderr("Oups!?","Retard Alert!");
			}
	if (empty($name))
		stderr("Error", "You must specify a name for the forum.");
	
	if (empty($description))
		stderr("Error", "You must provide a description for the forum.");
	
	mysql_query("UPDATE forums SET name = ".sqlesc($name).", description = ".sqlesc($description).", ledby = ".sqlesc((int)$ledby).", minclassread = ".sqlesc((int)$_POST['readclass']).", minclasswrite = ".sqlesc((int)$_POST['writeclass']).", minclasscreate = ".sqlesc((int)$_POST['createclass'])." WHERE id = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
	
	header("Location: {$_SERVER['PHP_SELF']}");
	exit();
}
else if ($action == 'deleteforum' && get_user_class() == MAX_CLASS) //-------- Action: Delete Forum
{

        if(get_user_class() < UC_MODERATOR) {
                write_log("User <a href=userdetails.php?id=".$CURUSER['id'].">".$CURUSER['username']."</a> Tried to modify forums! Tard!");
		stderr("Omg?!","What the fuck are you doing? aaa?");
                }
    $forumid = (int)$_GET['forumid'];
    if (!is_valid_id($forumid))
        stderr('Error', 'Invalid ID!');
    
    $confirmed = (int)$_GET['confirmed'];
    if (!$confirmed)
    {
        $rt = mysql_query("SELECT topics.id, forums.name ".
                          "FROM topics ".
                          "LEFT JOIN forums ON forums.id=topics.forumid ".
                          "WHERE topics.forumid = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
 
        $topics = mysql_num_rows($rt);
        $posts = 0;
        
        if ($topics > 0)
        {
            while ($topic = mysql_fetch_assoc($rt))
            {
                $ids[] = $topic['id'];
                $forum = $topic['name'];
            }
            
            $rp = mysql_query("SELECT COUNT(id) FROM posts WHERE topicid IN (".join(', ', $ids).")");
            foreach ($ids as $id)
                if ($a = mysql_fetch_row($rp))
                    $posts += $a[0];
        }
        
		if ($use_attachment_mod || $use_poll_mod)
		{
			$res = mysql_query("SELECT ".
							   ($use_attachment_mod ? "COUNT(attachments.id) AS attachments " : "").
							   ($use_poll_mod ? ($use_attachment_mod ? ', ' : '')."COUNT(postpolls.id) AS polls " : "").
							   "FROM topics ".
							   "LEFT JOIN posts ON topics.id=posts.topicid ".
							   ($use_attachment_mod ? "LEFT JOIN attachments ON attachments.postid = posts.id " : "").
							   ($use_poll_mod ? "LEFT JOIN postpolls ON postpolls.id=topics.pollid " : "").
							   "WHERE topics.forumid=".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
			
			($use_attachment_mod ? $attachments = 0 : NULL);
			($use_poll_mod ? $polls = 0 : NULL);
		
			if ($arr = mysql_fetch_assoc($res))
			{
				($use_attachment_mod ? $attachments = $arr['attachments'] : NULL);
				($use_poll_mod ? $polls = $arr['polls'] : NULL);
			}
        }
        stderr("** WARNING! **", "Deleting forum with id=$forumid (".$forum.") will also delete ".$posts." post".($posts != 1 ? 's' : '').($use_attachment_mod ? ", ".$attachments." attachment".($attachments != 1 ? 's' : '') : "").($use_poll_mod ? " and ".($polls-$attachments)." poll".(($polls-$attachments) != 1 ? 's' : '') : "")." in ".$topics." topic".($topics != 1 ? 's' : '').". [<a href=".$_SERVER['PHP_SELF']."?action=deleteforum&forumid=$forumid&confirmed=1>ACCEPT</a>] [<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=$forumid>CANCEL</a>]");
    }
    
    $rt = mysql_query("SELECT topics.id ".($use_attachment_mod ? ", attachments.filename " : "").
                      "FROM topics ".
                      "LEFT JOIN posts ON topics.id = posts.topicid ".
                      ($use_attachment_mod ? "LEFT JOIN attachments ON attachments.postid = posts.id " : "").
                      "WHERE topics.forumid = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
    
    while ($topic = mysql_fetch_assoc($rt))
    {
        $tids[] = $topic['id'];
        
        if ($use_attachment_mod && !empty($topic['filename']))
		{
			$filename = $attachment_dir."/".$topic['filename'];
			if (is_file($filename))
            	unlink($filename);
		}
    }
    
    mysql_query("DELETE posts.*, topics.*, forums.* ".($use_attachment_mod ? ", attachments.*, attachmentdownloads.* " : "").($use_poll_mod ? ", postpolls.*, postpollanswers.* " : "").
                "FROM posts ".
                ($use_attachment_mod ? "LEFT JOIN attachments ON attachments.postid = posts.id ".
                "LEFT JOIN attachmentdownloads ON attachmentdownloads.fileid = attachments.id " : "").
                "LEFT JOIN topics ON topics.id = posts.topicid ".
                "LEFT JOIN forums ON forums.id = topics.forumid ".
                ($use_poll_mod ? "LEFT JOIN postpolls ON postpolls.id = topics.pollid ".
                "LEFT JOIN postpollanswers ON postpollanswers.pollid = postpolls.id " : "").
                "WHERE posts.topicid IN (".join(', ', $tids).")") or sqlerr(__FILE__, __LINE__);
    
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
else if ($action == "newtopic") //-------- Action: New topic
{
	$forumid = (int)$_GET["forumid"];
	if (!is_valid_id($forumid))
		stderr('Error', 'Invalid ID!');
	
	stdhead("New topic"); begin_main_frame();
	insert_compose_frame($forumid, true, false, true);
	end_main_frame(); stdfoot();
	exit();
}
else if ($action == "post") //-------- Action: Post
{
	$forumid = (isset($_POST['forumid']) ? (int)$_POST['forumid'] : NULL);
	if (isset($forumid) && !is_valid_id($forumid))
		stderr('Error', 'Invalid forum ID!');
	
	$topicid = (isset($_POST['topicid']) ? (int)$_POST['topicid'] : NULL);
	if (isset($topicid) && !is_valid_id($topicid))
		stderr('Error', 'Invalid topic ID!');

	$newtopic = is_valid_id($forumid);

	$subject = (isset($_POST["subject"]) ? $_POST["subject"] : '');

	if ($newtopic)
	{
		$subject = trim($subject);
		
		if (empty($subject))
			stderr("Error", "You must enter a subject.");
		
		if (strlen($subject) > $maxsubjectlength)
			stderr("Error", "Subject is limited to ".$maxsubjectlength." characters.");
	}
	else
		$forumid = get_topic_forum($topicid) or die("Bad topic ID");

	if ($CURUSER["forumpost"] == 'no')
		stderr(format_comment(":sorry:"), format_comment("Your are not allowed to post.:banned:"));

	if (file_exists($generalbanfile) && get_user_class()<UC_MODERATOR)
		stderr(format_comment(":sorry:"), format_comment("Forum posting is temporary disabled. Come back later."));

	//------ Make sure sure user has write access in forum
	$arr = get_forum_access_levels($forumid) or die("Bad forum ID");
	
	if (get_user_class() < $arr["write"] || ($newtopic && get_user_class() < $arr["create"]))
		stderr("Error", "Permission denied.");
	
	$body = trim($_POST["body"]);
	
	if (empty($body))
		stderr("Error", "No body text.");

	$userid = (int)$CURUSER["id"];
	
	if ($use_flood_mod && get_user_class() < UC_MODERATOR)
	{
		$res = mysql_query("SELECT COUNT(id) AS c FROM posts WHERE userid = ".$CURUSER['id']." AND added > '".get_date_time(gmtime() - ($minutes * 60))."'");
		$arr = mysql_fetch_assoc($res);
		
		if ($arr['c'] > $limit)
			stderr("Flood", "More than ".$limit." posts in the last ".$minutes." minutes.");
	}
	
	if ($newtopic)
	{
		mysql_query("INSERT INTO topics (userid, forumid, subject) VALUES($userid, $forumid, ".sqlesc($subject).")") or sqlerr(__FILE__, __LINE__);
		$topicid = mysql_insert_id() or stderr("Error", "No topic ID returned!");
	
		mysql_query("INSERT INTO posts (topicid, userid, added, body) VALUES($topicid, $userid, ".sqlesc(get_date_time()).", ".sqlesc($body).")") or sqlerr(__FILE__, __LINE__);	
		$postid = mysql_insert_id() or stderr("Error", "No post ID returned!");
		update_topic_last_post($topicid);
	}
	else
	{
		//---- Make sure topic exists and is unlocked
		$res = mysql_query("SELECT locked FROM topics WHERE id = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
		if (mysql_num_rows($res) == 0)
			stderr('Error', 'Inexistent Topic!');
		
		$arr = mysql_fetch_assoc($res);
		
		if ($arr["locked"] == 'yes' && get_user_class() < UC_MODERATOR)
			stderr("Error", "This topic is locked; No new posts are allowed.");
		
		//------ Check double post     
		$doublepost = mysql_query("SELECT p.id, p.added, p.userid, p.body, t.lastpost, t.id ".
								  "FROM posts AS p ".
								  "INNER JOIN topics AS t ON p.id = t.lastpost ".
								  "WHERE t.id = $topicid AND p.userid = $userid AND p.added > ".sqlesc(get_date_time(gmtime() - 1*86400))." ".
								  "ORDER BY p.added DESC LIMIT 1") or sqlerr(__FILE__, __LINE__);
		if (mysql_num_rows($doublepost) == 0 || get_user_class() >= UC_MODERATOR)
		{
			mysql_query("INSERT INTO posts (topicid, userid, added, body) VALUES($topicid, $userid, ".sqlesc(get_date_time()).", ".sqlesc($body).")") or sqlerr(__FILE__, __LINE__);

			$postid = mysql_insert_id() or die("Post id n/a");
			
			update_topic_last_post($topicid);
			mysql_query("UPDATE users SET reputation=reputation+1 where id=".sqlesc($CURUSER['id'])) or sqlerr(__FILE__,__LINE__);
		}
		else
		{
			$results = mysql_fetch_assoc($doublepost);
			$postid = (int)$results['lastpost'];
			
			mysql_query("UPDATE posts SET body = ".sqlesc(trim($results['body'])."\n\n".$body).", editedat = ".sqlesc(get_date_time()).", editedby = $userid WHERE id=$postid") or sqlerr(__FILE__, __LINE__);
		}
	}
	
	if ($use_attachment_mod && ((isset($_POST['uploadattachment']) ? $_POST['uploadattachment'] : '') == 'yes'))
	{
		$file = $_FILES['file'];
		
		$fname = trim(stripslashes($file['name']));
		$size = $file['size'];
		$tmpname = $file['tmp_name'];
		$tgtfile = $attachment_dir."/".$fname;
		$pp = pathinfo($fname = $file['name']);
		$error = $file['error'];
		$type = $file['type'];
		
		$uploaderror = '';
		
		if (empty($fname))
			$uploaderror = "Invalid Filename!";	
		
		if (!validfilename($fname))
			$uploaderror = "Invalid Filename!";		
		
		foreach ($allowed_file_extensions as $allowed_file_extension);
			if (!preg_match('/^(.+)\.['.join(']|[', $allowed_file_extensions).']$/si', $fname, $matches))
				$uploaderror = 'Only files with the following extensions are allowed: '.join(', ', $allowed_file_extensions).'.';
		
		if ($size > $maxfilesize)
			$uploaderror = "Sorry, that file is too large.";		
		
		if ($pp['basename'] != $fname)
			$uploaderror = "Bad file name.";				
		
		if (file_exists($tgtfile))
			$uploaderror = "Sorry, a file with the name already exists.";	
		
		if (!is_uploaded_file($tmpname))
			$uploaderror = "Can't Upload file!";
		
		if (!filesize($tmpname))
			$uploaderror = "Empty file!";
		
		if ($error != 0)
			$uploaderror = "There was an error while uploading the file.";
		
		if (empty($uploaderror))
		{
			mysql_query("INSERT INTO attachments (topicid, postid, filename, size, owner, added, type) VALUES ('$topicid','$postid',".sqlesc($fname).", ".sqlesc($size).", '$userid', ".sqlesc(get_date_time()).", ".sqlesc($type).")") or sqlerr(__FILE__, __LINE__);
			
			move_uploaded_file($tmpname, $tgtfile);
		}
	}
	
	$headerstr = "Location: ".$_SERVER['PHP_SELF']."?action=viewtopic&topicid=$topicid".($use_attachment_mod && !empty($uploaderror) ? "&uploaderror=$uploaderror" : "")."&page=last";
	
	header($headerstr.($newtopic ? '' : "#$postid"));
	exit();
}
else if ($action == "viewtopic") //-------- Action: View topic
{
	$userid = (int)$CURUSER["id"];
	
	if ($use_poll_mod && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$choice = $_POST['choice'];
		$pollid = (int)$_POST["pollid"];
		if (ctype_digit($choice) && $choice < 256 && $choice == floor($choice))
		{
			$res = mysql_query("SELECT pa.id ".
							   "FROM postpolls AS p ".
							   "LEFT JOIN postpollanswers AS pa ON pa.pollid = p.id AND pa.userid = ".sqlesc($userid)." ".
							   "WHERE p.id = ".sqlesc($pollid)) or sqlerr(__FILE__, __LINE__);
			$arr = mysql_fetch_assoc($res) or stderr('Sorry', 'Inexistent poll!');
			
			if (is_valid_id($arr['id']))
				stderr("Error...", "Dupe vote");
			
			mysql_query("INSERT INTO postpollanswers VALUES(id, ".sqlesc($pollid).", ".sqlesc($userid).", ".sqlesc($choice).")") or sqlerr(__FILE__, __LINE__);
			
			if (mysql_affected_rows() != 1)
				stderr("Error...", "An error occured. Your vote has not been counted.");
		}
		else
			stderr("Error..." , "Please select an option." );
	}

	$topicid = (int)$_GET["topicid"];
	if (!is_valid_id($topicid))
		stderr('Error', 'Invalid topic ID!');
	
	$page = (isset($_GET["page"]) ? $_GET["page"] : 0);
	
	//------ Get topic info
	$res = mysql_query("SELECT ".($use_poll_mod ? 't.pollid, ' : '')."t.locked, t.subject, t.sticky, t.userid AS t_userid, t.forumid, f.name AS forum_name, f.minclassread, f.ledby, f.minclasswrite, f.minclasscreate, (SELECT COUNT(id) FROM posts WHERE topicid = t.id) AS p_count ".
					   "FROM topics AS t ".
					   "LEFT JOIN forums AS f ON f.id = t.forumid ".
					   "WHERE t.id = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
	$arr = mysql_fetch_assoc($res) or stderr("Error", "Topic not found");
	mysql_free_result($res);
	
	($use_poll_mod ? $pollid = (int)$arr["pollid"] : NULL);
	$t_userid = (int)$arr['t_userid'];
	$locked = ($arr['locked'] == 'yes' ? true : false);
	$subject = $arr['subject'];
	$sticky = ($arr['sticky'] == "yes" ? true : false);
	$forumid = (int)$arr['forumid'];
	$ledby = (int)$arr['ledby'];
	$forum = $arr["forum_name"];
	$postcount = (int)$arr['p_count'];
	
	if ($CURUSER["class"] < $arr["minclassread"])
		stderr("Error", "You are not permitted to view this topic.");
	
	//------ Update hits column
	mysql_query("UPDATE topics SET views = views + 1 WHERE id=$topicid") or sqlerr(__FILE__, __LINE__);
	
	//------ Make page menu
	$pagemenu1 = "<p align='center'>";
	$perpage = $postsperpage;
	$pages = ceil($postcount / $perpage);
	
	if ($page[0] == "p")
	{
		$findpost = substr($page, 1);
		$res = mysql_query("SELECT id FROM posts WHERE topicid=$topicid ORDER BY added") or sqlerr(__FILE__, __LINE__);
		$i = 1;
		while ($arr = mysql_fetch_row($res))
		{
			if ($arr[0] == $findpost)
				break;
			++$i;
		}
		$page = ceil($i / $perpage);
	}
	
	if ($page == "last")
		$page = $pages;
	else
	{
		if ($page < 1)
			$page = 1;
		else if ($page > $pages)
			$page = $pages;
	}
	
	$offset = ((int)$page * $perpage) - $perpage;
	$offset = ($offset < 0 ? 0 : $offset);
	
	$pagemenu2 = '';
	for ($i = 1; $i <= $pages; ++$i)
		$pagemenu2 .= ($i == $page ? "<b>[<u>$i</u>]</b>" : "<a href=".$_SERVER['PHP_SELF']."?action=viewtopic&topicid=$topicid&page=$i><b>$i</b></a>");
	
	$pagemenu1 .= ($page == 1 ? "<b>&lt;&lt;&nbsp;Prev</b>" : "<a href=".$_SERVER['PHP_SELF']."?action=viewtopic&topicid=$topicid&page=".($page - 1)."><b>&lt;&lt;&nbsp;Prev</b></a>");
	$pmlb = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$pagemenu3 = ($page == $pages ? "<b>Next&nbsp;&gt;&gt;</b></p>" : "<a href=".$_SERVER['PHP_SELF']."?action=viewtopic&topicid=$topicid&page=".($page + 1)."><b>Next&nbsp;&gt;&gt;</b></a></p>");
	
	stdhead("Forums :: View Topic: $subject");
	if (file_exists($generalbanfile))
		stdmsg("Atentie!","Nu se poate posta pe forum!");
	begin_main_frame();
	if ($use_poll_mod && is_valid_id($pollid))
	{
		$res = mysql_query("SELECT p.*, pa.id AS pa_id, pa.selection FROM postpolls AS p LEFT JOIN postpollanswers AS pa ON pa.pollid = p.id AND pa.userid = ".$CURUSER['id']." WHERE p.id = ".sqlesc($pollid)) or sqlerr(__FILE__, __LINE__);
	
		if (mysql_num_rows($res) > 0)
		{
			$arr1 = mysql_fetch_assoc($res);
			
			$userid = (int)$CURUSER['id'];
			$question = htmlspecialchars($arr1["question"]);
			$o = array($arr1["option0"], $arr1["option1"], $arr1["option2"], $arr1["option3"], $arr1["option4"],
					   $arr1["option5"], $arr1["option6"], $arr1["option7"], $arr1["option8"], $arr1["option9"],
					   $arr1["option10"], $arr1["option11"], $arr1["option12"], $arr1["option13"], $arr1["option14"],
					   $arr1["option15"], $arr1["option16"], $arr1["option17"], $arr1["option18"], $arr1["option19"]);
			
			?><table cellpadding=5 width='<?php echo $forum_width; ?>' align='center'>
			<tr><td class=colhead align=left><h2>Poll<?php
			
			if ($userid == $t_userid || get_user_class() >= UC_MODERATOR)
			{
				?><font class='small'> - [<a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=makepoll&subaction=edit&pollid=<?php echo $pollid; ?>'><b>Edit</b></a>]</font><?php
				
				if (get_user_class() >= UC_MODERATOR)
				{
					?><font class='small'> - [<a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=deletepoll&pollid=<?php echo $pollid; ?>'><b>Delete</b></a>]</font><?php
				}
			}
			?></h2></td></tr><?php
			?><tr><td align=center class='clearalt7'><?php
			?><table width="55%"><tr><td class='clearalt6'>
			<div align=center><b><?php echo $question; ?></b></div>
			<?php
			
			$voted = (is_valid_id($arr1['pa_id']) ? true : false);
			
			if (($locked && get_user_class() < UC_MODERATOR) ? true : $voted)
			{
				$uservote = ($arr1["selection"] != '' ? (int)$arr1["selection"] : -1);
				
				$res3 = mysql_query("SELECT selection FROM postpollanswers WHERE pollid = ".sqlesc($pollid)." AND selection < 20");
				$tvotes = mysql_num_rows($res3);
				
				$vs = $os = array();
				
				while ($arr3 = mysql_fetch_row($res3))
					$vs[$arr3[0]] += 1;
				
				reset($o);
				for ($i = 0; $i < count($o); ++$i)
					if ($o[$i])
						$os[$i] = array($vs[$i], $o[$i]);
				
				function srt($a,$b)
				{
					if ($a[0] > $b[0])
						return -1;
						
					if ($a[0] < $b[0])
						return 1;
				
					return 0;
				}
				
				if ($arr1["sort"] == "yes")
					usort($os, "srt");
				
				?><br /><?php
				?><table width='100%' cellpadding="5"><?php
				for ($i=0; $a = $os[$i]; ++$i)
				{
					if ($i == $uservote)
						$a[1] .= " *";
					
					$p = ($tvotes == 0 ? 0 : round($a[0] / $tvotes * 100));				
					$c = ($i % 2 ? '' : "poll");
					
					?><tr><?php
					?><td width='1%' style="padding:3px;" class='embedded<?php echo $c; ?>'><nobr><?php echo htmlspecialchars($a[1]); ?></nobr></td><?php
					?><td width='99%' class='embedded<?php echo $c; ?>' align="center"><?php
						 ?><img src='<?php echo $pic_base_url; ?>bar_left.gif'><?php
						 ?><img src='<?php echo $pic_base_url; ?>bar.gif' height='9' width='<?php echo ($p*3); ?>'><?php
						 ?><img src='<?php echo $pic_base_url; ?>bar_right.gif'>&nbsp;<?php echo $p; ?>%</td><?php
					?></tr><?php
				}
				
				?></table><?php
				?><p align=center>Votes: <b><?php echo number_format($tvotes); ?></b></p><?php
			}
			else
			{
				?><form method=post action="<?php echo $_SERVER['PHP_SELF']; ?>?action=viewtopic&topicid=<?php echo $topicid; ?>"><?php
				?><input type='hidden' name='pollid' value=<?php echo $pollid; ?>><?php
				
				for ($i=0; $a = $o[$i]; ++$i)
					echo "<input type=radio name=choice value=$i>".htmlspecialchars($a)."<br />";
				
				?><br /><?php
				?><p align=center><input type=submit value='Vote!'></p><?php
			}
			?></form></td></tr></table><?php
			
			$listvotes = (isset($_GET['listvotes']) ? true : false);
			
			if (get_user_class() >= UC_ADMINISTRATOR)
			{
				if (!$listvotes)
					echo "<a href=".$_SERVER['PHP_SELF']."?action=viewtopic&topicid=$topicid&listvotes>List Voters</a>";
				else
				{
					$res4 = mysql_query("SELECT pa.userid, u.username, u.smilie, u.class FROM postpollanswers AS pa LEFT JOIN users AS u ON u.id = pa.userid WHERE pa.pollid = ".sqlesc($pollid)) or sqlerr(__FILE__, __LINE__);
					$voters = '';
					while ($arr4 = mysql_fetch_assoc($res4))
					{
						if (!empty($voters) && !empty($arr4['username']))
							$voters .= ', ';

						$voters .= "<a onmouseover=\"ajax_showTooltip('showtip.php?id={$arr4[userid]}',this);return false\" onmouseout=\"ajax_hideTooltip()\" href='$DEFAULTBASEURL/userdetails.php?id=".(int)$arr4['userid']."' class='special' id='".get_user_class_color($arr4['class'])."'>".htmlspecialchars($arr4['username'])."".format_smilie($arr4['smilie'])."</a>";
					}
					
					echo $voters.'(<font class="small"><a href="'.str_replace('&listvotes', '', $_SERVER['REQUEST_URI']).'">hide</a></font>)';
				}
			}
			
			?></td></tr></table><?php
		}
		else
		{
			?><br /><?php
			stdmsg('Sorry', "Poll doesn't exist");
		}
		
		?><br /><?php
	}
	
	?><a name='top'></a>
    <h1 align="left"><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo $forumid; ?>"><?php echo $forum; ?></a> &gt; <?php echo htmlspecialchars($subject); ?></h1><?php


	//------ Print table
	begin_frame();
	
//	$res = mysql_query(
//	"SELECT p.id, p.added, p.userid, p.added, p.body, p.editedby, p.editedat, u.id as uid, u.username as uusername, u.class, u.avatar, u.donor, u.title, u.country, u.enabled, u.warned,u.leechwarn, u.uploaded, u.downloaded, u.signature, u.last_access, (SELECT COUNT(id) FROM posts WHERE userid = u.id) AS posts_count, u2.username as u2_username ".($use_attachment_mod ? ", at.id as at_id, at.filename as at_filename, at.postid as at_postid, at.size as at_size, at.downloads as at_downloads, at.owner as at_owner " : "").
//	", (SELECT lastpostread FROM readposts WHERE userid = ".sqlesc((int)$CURUSER['id'])." AND topicid = p.topicid LIMIT 1) AS lastpostread ".
//	"FROM posts AS p ".
//	"LEFT JOIN users AS u ON p.userid = u.id ".
//	($use_attachment_mod ? "LEFT JOIN attachments AS at ON at.postid = p.id " : "").
//	"LEFT JOIN users AS u2 ON u2.id = p.editedby ".
//	"WHERE p.topicid = ".sqlesc($topicid)." ORDER BY id LIMIT $offset, $perpage") or sqlerr(__FILE__, __LINE__);

	$res = mysql_query(
	"SELECT p.id, p.added, p.userid, p.added, p.body, p.editedby, p.editedat, u.id as uid, u.username as uusername, u.class, u.smilie, u.avatar, u.donor, u.title, u.country, u.enabled, u.warned, u.leechwarn, u.signature, u.last_access, u.reputation, u2.username as u2_username ".($use_attachment_mod ? ", at.id as at_id, at.filename as at_filename, at.postid as at_postid, at.size as at_size, at.downloads as at_downloads, at.owner as at_owner " : "").
	", (SELECT lastpostread FROM readposts WHERE userid = ".sqlesc((int)$CURUSER['id'])." AND topicid = p.topicid LIMIT 1) AS lastpostread ".
	"FROM posts AS p ".
	"LEFT JOIN users AS u ON p.userid = u.id ".
	($use_attachment_mod ? "LEFT JOIN attachments AS at ON at.postid = p.id " : "").
	"LEFT JOIN users AS u2 ON u2.id = p.editedby ".
	"WHERE p.topicid = ".sqlesc($topicid)." ORDER BY id LIMIT $offset, $perpage") or sqlerr(__FILE__, __LINE__);
	$pc = mysql_num_rows($res);
	$pn = 0;
	
	while ($arr = mysql_fetch_assoc($res))
	{
		++$pn;
		
		$lpr = $arr['lastpostread'];
		$postid = (int)$arr["id"];
		$postadd = $arr['added'];
		$reputationpoints = $arr['reputation']-1900;
		$reputationpower = (int)($reputationpoints/10);
		$reputation = reputationimages($reputationpower);
		$posterid = (int)$arr['userid'];
		$voteexists = mysql_fetch_array(mysql_query("SELECT COUNT(*) FROM reputation where post='".$postid."' and userid_voter=".sqlesc($CURUSER['id'])));
		$reputationimg = "";
		if($CURUSER['id'] != $posterid)
			if($voteexists[0] ==0)
				$reputationimg = "<img alt='Thumbs Up' title='Thumbs Up' style='cursor: pointer;' class='thumbsup' src='pic/spacer.gif' onclick=\"ajax_loadContent('post" . $postid . "','ajax.php?do=giverating&id={$posterid}&reputation=good&post={$postid}');\">&nbsp;&nbsp;&nbsp;<img alt='Thumbs Down' title='Thumbs Down' class='thumbsdown' src='pic/spacer.gif' style='cursor: pointer;' onclick=\"ajax_loadContent('post" . $postid . "','ajax.php?do=giverating&id={$posterid}&reputation=bad&post={$postid}');\"></span>";
		$added = $arr['added'] . " GMT <font class=small>(" . (get_elapsed_time(sql_timestamp_to_unix_timestamp($arr['added']))) . ")</font>";
		$signature = ($CURUSER['signatures'] == 'yes' ? format_comment($arr['signature']) : '');
		$postername = $arr['uusername'].format_smilie($arr['smilie']);
		$avatar = (!empty($postername) ? ($CURUSER['avatars'] == "yes" ? htmlspecialchars($arr['avatar']) : '') : '');
		$title = (!empty($postername) ? (empty($arr['title']) ? "" : "(".format_comment($arr['title']).")") : '');
		$forumposts = (!empty($postername) ? ($arr['posts_count'] != 0 ? $arr['posts_count'] : 'N/A') : 'N/A');
		$by = (!empty($postername) ? "<a onmouseover=\"ajax_showTooltip('showtip.php?id={$posterid}',this);return false\" onmouseout=\"ajax_hideTooltip()\" href='$DEFAULTBASEURL/userdetails.php?id=$posterid' class='special' id='".get_user_class_color($arr['class'])."'>".$postername."</a>".get_user_icons($arr) : "unknown[".$posterid."]");
	
		if (empty($avatar))
			$avatar = $pic_base_url.$forum_pics['default_avatar'];
		
		echo "<a name=$postid></a>";
		echo ($pn == $pc ? '<a name=last></a>' : '');
		
		begin_table();
		?><tr><td width='100%' colspan="2"><table class="main"><tr><td style="border:none;" width="100%"><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewtopic&topicid=<?=$topicid;?>&page=p<?=$postid;?>#<?=$postid;?>'>#<?=$postid;?></a> by <?=$by;?> <?=$title;?> at <?php echo $added; ?><?php
		?></td><td style="border:none;"><a href="#top"><img align="right" style="border:none" src='<?php echo $pic_base_url.$forum_pics['arrow_up']; ?>' alt='Top' /></a></td></tr></table></td></tr><?php
		
		$highlight = (isset($_GET['highlight']) ? $_GET['highlight'] : '');
		$body = (!empty($highlight) ? highlight(htmlspecialchars(trim($highlight)), format_comment($arr['body'])) : format_comment($arr['body']));
		
		if (is_valid_id($arr['editedby']))
			$body .= "<p><font size=1 class=small>Last edited by <a href='$DEFAULTBASEURL/userdetails.php?id=".$arr['editedby']."'><b>".$arr['u2_username']."</b></a> at ".$arr['editedat']." GMT</font></p>";
		
		if ($use_attachment_mod && ((!empty($arr['at_filename']) && is_valid_id($arr['at_id'])) && $arr['at_postid'] == $postid))
		{
			foreach ($allowed_file_extensions as $allowed_file_extension)
				if (substr($arr['at_filename'], -3) == $allowed_file_extension)
					$aimg = $allowed_file_extension;
			
			$body .= "<div style=\"padding:6px\"><fieldset class=\"fieldset\">
					<legend>Attached Files</legend>
					
					<table cellpadding=\"0\" cellspacing=\"3\" border=\"0\">
					<tr>
					<td><img class=\"inlineimg\" src=\"$pic_base_url$aimg.gif\" width=\"16\" height=\"16\" border=\"0\" style=\"vertical-align:baseline\" />&nbsp;</td>
					<td><a href=\"".$_SERVER['PHP_SELF']."?action=attachment&attachmentid=".$arr['at_id']."\" target=\"_blank\">".htmlspecialchars($arr['at_filename'])."</a> (".mksize($arr['at_size']).", ".$arr['at_downloads']." downloads)</td>
					<td>&nbsp;&nbsp;<input type=\"button\" class=\"none\" value=\"See who downloaded\" tabindex=\"1\" onclick=\"window.open('".$_SERVER['PHP_SELF']."?action=whodownloaded&fileid=".$arr['at_id']."','whodownloaded','toolbar=no, scrollbars=yes, resizable=yes, width=600, height=250, top=50, left=50'); return false;\" />".(get_user_class() >= UC_MODERATOR ? "&nbsp;&nbsp;<input type=\"button\" class=\"gobutton\" value=\"Delete\" tabindex=\"2\" onclick=\"window.open('".$_SERVER['PHP_SELF']."?action=attachment&subaction=delete&attachmentid=".$arr['at_id']."','attachment','toolbar=no, scrollbars=yes, resizable=yes, width=600, height=250, top=50, left=50'); return false;\"\" />" : "")."</td>
					</tr>
					</table>
					</fieldset>
					</div>";
		}
					
		if (!empty($signature))
			$body .= "<p style='vertical-align:bottom'><br>____________________<br>".$signature;
		
		?><tr valign='top'><td width='150' align='center' style='padding: 0px'>
		<img width='150' src="<?=$avatar;?>"><br /><fieldset style='text-align:left;border:none;'><nobr>
		<div id="post<?=$postid;?>"><b>Reputation (<?=$reputationpower;?>):</b>&nbsp;&nbsp;&nbsp;<?=$reputation;?><br />
		<?=$reputationimg;?></div>
		</fieldset>

</td><td class='text' width='100%'><?=$body;?></td></tr><?php
		
		?><tr>
			<td>
				<img src='<?php echo $pic_base_url.$forum_pics[($last_access > get_date_time(gmtime()-360) || $posterid == $CURUSER['id'] ? 'on' : 'off').'line_btn']; ?>' border=0>&nbsp;
				<a href="<?php echo $DEFAULTBASEURL; ?>/sendmessage.php?receiver=<?php echo $posterid; ?>"><img src="<?php echo $pic_base_url.$forum_pics['pm_btn']; ?>" border="0" alt="PM <?php echo htmlspecialchars($postername); ?>"></a>&nbsp;
				<a href='<?php echo $DEFAULTBASEURL; ?>/report.php?forumpost=<?php echo $postid; ?>&forumid=<?php echo $topicid; ?>'><img src="<?php echo $pic_base_url.$forum_pics['p_report_btn']; ?>" border="0" alt="Report Post"></a>
			</td>
			<td align='right'>
		<?php
		if (!$locked || get_user_class() >= UC_MODERATOR)
		{
			?><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=quotepost&topicid=<?php echo $topicid; ?>&postid=<?php echo $postid; ?>'><img src="<?php echo $pic_base_url.$forum_pics['p_quote_btn']; ?>" border="0" alt="Quote Post"></a>&nbsp;<?php
		}
		
		if (get_user_class() >= UC_MODERATOR|| $ledby == $CURUSER['id'])
		{
			?><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=deletepost&postid=<?php echo $postid; ?>'><img src="<?php echo $pic_base_url.$forum_pics['p_delete_btn']; ?>" border="0" alt="Delete Post"></a>&nbsp;<?php
		}
		
		if (($CURUSER["id"] == $posterid && !$locked) || get_user_class() >= UC_MODERATOR || $ledby == $CURUSER['id'])
		{
			?><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=editpost&postid=<?php echo $postid; ?>'><img src="<?php echo $pic_base_url.$forum_pics['p_edit_btn']; ?>" border="0" alt="Edit Post"></a><?php
		}
		
		?></td></tr><?php
			
		end_table();
		?><br /><?php
	}
	
	if ($use_poll_mod && (($userid == $t_userid || get_user_class() >= UC_MODERATOR) && !is_valid_id($pollid)))
	{
		?>
		<table cellpadding="5" width=<?php echo $forum_width; ?>>
        <tr>
        	<td align="right">
            	<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
                <input type='hidden' name='action' value="makepoll">
				<input type='hidden' name='topicid' value="<?php echo $topicid; ?>">
				<input type='submit' value='Add a Poll'>
				</form>
			</td>
        </tr>
        </table>
        <br />
        <?php
	}

	if (($postid > $lpr) && ($postadd > (get_date_time(gmtime() - $READPOST_EXPIRY))))
	{
		if ($lpr)
			mysql_query("UPDATE readposts SET lastpostread = $postid WHERE userid = $userid AND topicid = $topicid") or sqlerr(__FILE__, __LINE__);
		else
			mysql_query("INSERT INTO readposts (userid, topicid, lastpostread) VALUES($userid, $topicid, $postid)") or sqlerr(__FILE__, __LINE__);
	}
	
	//------ Mod options
	if (get_user_class() >= UC_MODERATOR || $ledby == $CURUSER['id'])
	{
		begin_table();
		
		?>
		<tr>
			<td colspan="2" class='colhead'>Staff options</td>
		</tr>
		
		<form method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
		<input type='hidden' name='action' value='updatetopic' />
		<input type='hidden' name='topicid' value='<?php echo $topicid; ?>' />
		
		<tr>
			<td class="rowhead" width="1%">Sticky</td>
			<td>
				<select name="sticky">
					<option value="yes"<?php echo ($sticky ? " selected='selected'" : ''); ?>>Yes</option>
					<option value="no"<?php echo (!$sticky ? " selected='selected'" : ''); ?>>No</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td class="rowhead">Locked</td>
			<td>
				<select name="locked">
					<option value="yes"<?php echo ($locked ? " selected='selected'" : ''); ?>>Yes</option>
					<option value="no"<?php echo (!$locked ? " selected='selected'" : ''); ?>>No</option>
				</select>
			</td>
		</tr>
	
		<tr>
			<td class="rowhead">Topic name</td>
			<td>
				<input type="text" name="subject" size="60" maxlength="<?php echo $maxsubjectlength; ?>" value="<?php echo htmlspecialchars($subject); ?>">
			</td>
		</tr>
		
		<tr>
<?
if($ledby != $CURUSER['id'])
{
?>
			<td class="rowhead">Move topic</td>
			<td>
				<select name='new_forumid'><?php
				$res = mysql_query("SELECT id, name, minclasswrite FROM forums ORDER BY name") or sqlerr(__FILE__, __LINE__);
				while ($arr = mysql_fetch_assoc($res))
					if (get_user_class() >= $arr["minclasswrite"])
						echo '<option value="'.(int)$arr["id"].'"'.($arr["id"] == $forumid ? ' selected="selected"' : '').'>'.htmlspecialchars($arr["name"]).'</option>';
				?></select>
			</td>
<?
}
else
{
?>
<input type="hidden" name="new_forumid" value="<?=$forumid;?>">
<?
}
?>		</tr>
		
		<tr>
			<td class="rowhead"><nobr>Delete topic</nobr></td>
			<td>
				<select name="delete">
					<option value="no" selected="selected">No</option>
					<option value="yes">Yes</option>
				</select>
				
				<br />
				<b>Note:</b> Any changes made to the topic won't take effect if you select "yes"
			</td>
		</tr>
		
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="Update Topic" />
			</td>
		</tr>
	
		</form><?php
		end_table();
	}
	
	end_frame();
	
	echo $pagemenu1.$pmlb.$pagemenu2.$pmlb.$pagemenu3;
	
	if ($locked && get_user_class() < UC_MODERATOR)
	{
		?><p align="center">This topic is locked; no new posts are allowed.</p><?php
	}
	else
	{
		$arr = get_forum_access_levels($forumid);
		
		if (get_user_class() < $arr["write"])
		{
			?><p align="center"><i>You are not permitted to post in this forum.</i></p><?php
			
			$maypost = false;
		}
		else
			$maypost = true;
	}
	
	//------ "View unread" / "Add reply" buttons
	?>
	<table align="center" class="main" border=0 cellspacing=0 cellpadding=0><tr>
	<td class=embedded>
		<form method=get action='<?php echo $_SERVER['PHP_SELF']; ?>'><input type=hidden name=action value=viewunread><input type=submit value='Show new'></form>
	</td>
	<?php
	if ($maypost)
	{
		?>
		<td class=embedded style='padding-left: 10px'>
			<form method=get action='<?php echo $_SERVER['PHP_SELF']; ?>'>
			<input type=hidden name=action value=reply><input type=hidden name=topicid value=<?php echo $topicid; ?>><input type=submit value='Answer'></form>
		</td>
		<?php
	}
	?></tr></table><?php
	
	if ($maypost)
	{
		?>
		<table style='border:1px solid #000000;' align="center"><tr>
		<td style='padding:10px;text-align:center;'>
		<b>Quick Reply</b>
		<form onsubmit="javascript: submitonce(this)"  name='compose' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
		<input type=hidden name=action value=post>
		<input type=hidden name=topicid value=<?php echo $topicid; ?>>
		<textarea name="body" rows="4" cols="70"></textarea><br />
		<input type=submit value="Submit">
		</form></td></tr></table>
		<?php
	}
	
	
	//------ Forum quick jump drop-down
	insert_quick_jump_menu($forumid);
	
	end_main_frame(); stdfoot();
	
	$uploaderror = (isset($_GET['uploaderror']) ? htmlspecialchars($_GET['uploaderror']) : '');
	
	if (!empty($uploaderror))
	{
		?><script>alert("Upload Failed: <?php echo $uploaderror; ?>\nHowever your post was successful saved!\n\nClick 'OK' to continue.");</script><?php
	}
	
	exit();
}
else if ($action == "quotepost") //-------- Action: Quote
{
	$topicid = (int)$_GET["topicid"];
	if (!is_valid_id($topicid))
		stderr('Error', 'Invalid ID!');
	
	stdhead("Post reply"); begin_main_frame();
	insert_compose_frame($topicid, false, true);
	end_main_frame(); stdfoot();
	exit();
}
else if ($action == "reply") //-------- Action: Reply
{
	$topicid = (int)$_GET["topicid"];
	if (!is_valid_id($topicid))
		stderr('Error', 'Invalid ID!');

	stdhead("Post reply"); begin_main_frame();
	insert_compose_frame($topicid, false, false, true);
	end_main_frame(); stdfoot();
	exit();
}
else if ($action == "editpost") //-------- Action: Edit post
{
	$postid = (int)$_GET["postid"];
	if (!is_valid_id($postid))
		stderr('Error', 'Invalid ID!');
	if (file_exists($generalbanfile) && get_user_class()<UC_MODERATOR)
		stderr(format_comment(":sorry:"), format_comment("Forum posting is temporary disabled. Come back later."));
	
/*
	$res = mysql_query("SELECT p.userid, p.topicid, p.body, t.locked ".
					   "FROM posts AS p ".
					   "LEFT JOIN topics AS t ON t.id = p.topicid ".
					   "WHERE p.id = ".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
	
*/
	$res = mysql_query("SELECT p.userid, p.topicid, p.body, t.locked, f.ledby ".
					   "FROM posts AS p ".
					   "LEFT JOIN topics AS t ON t.id = p.topicid ".
					   "LEFT JOIN forums AS f ON f.id = t.forumid ".
					   "WHERE p.id = ".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
	if (mysql_num_rows($res) == 0)
		stderr("Error", "No post with that ID!");
	
	$arr = mysql_fetch_assoc($res);
	
	if($arr['ledby'] != $CURUSER['id'])
	if (($CURUSER["id"] != $arr["userid"] || $arr["locked"] == 'yes') && get_user_class() < UC_MODERATOR)
		stderr("Error", "Access Denied!");
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$body = trim($_POST['body']);
		
		if (empty($body))
			stderr("Error", "Body cannot be empty!");
		
		mysql_query("UPDATE posts SET body = ".sqlesc($body).", editedat = ".sqlesc(get_date_time()).", editedby = {$CURUSER['id']} WHERE id = $postid") or sqlerr(__FILE__, __LINE__);
		
		header("Location: {$_SERVER['PHP_SELF']}?action=viewtopic&topicid={$arr['topicid']}&page=p$postid#$postid");
		exit();
	}
	
	stdhead(); begin_main_frame();
	
	?>
	<h3>Edit Post</h3>
	
	<form onsubmit="javascript: submitonce(this)"  name=edit method=post action='<?php echo $_SERVER['PHP_SELF']; ?>?action=editpost&postid=<?php echo $postid; ?>'>
	
	<table border=1 cellspacing=0 cellpadding=5 width=100%>
	<tr>
		<td class=rowhead width="10%">Body</td>
		<td align=left style='padding: 0px'>
		<?php
		$ebody = htmlspecialchars(unesc($arr["body"]));
		if (function_exists('textbbcode'))
			textbbcode("edit", "body", $ebody);
		else
		{
			?><textarea name="body" style="width:99%" rows="7"><?php echo $ebody; ?></textarea><?php
		}
		?>
		</td>
	</tr>
	
	<tr>
		<td align=center colspan=2><input type=submit value='Update post' class=gobutton></td>
	</tr>
	</table>
	
	</form>
	
	<?php
	end_main_frame(); stdfoot();
	exit();
}
//else if ($action == 'deletepost' && get_user_class() >= UC_MODERATOR) //-------- Action: Delete post
else if ($action == 'deletepost') //-------- Action: Delete post
{
    $postid = (int)$_GET['postid'];
    if (!is_valid_id($postid))
        stderr('Error', 'Invalid ID');

    $res = mysql_query("SELECT p.topicid,t.forumid, f.ledby ".($use_attachment_mod ? ", a.filename" : "").", (SELECT COUNT(id) FROM posts WHERE topicid=p.topicid) AS posts_count, ".
					   "(SELECT MAX(id) FROM posts WHERE topicid=p.topicid AND id < p.id) AS p_id ".
					   "FROM posts AS p
					 LEFT JOIN topics AS t ON t.id=p.topicid
					 LEFT JOIN forums AS f ON f.id=t.forumid ".
					   ($use_attachment_mod ? "LEFT JOIN attachments AS a ON a.postid = p.id " : "").
					   "WHERE p.id=".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);
    $arr = mysql_fetch_assoc($res) or stderr("Error", "Post not found");
    if($arr['ledby'] != $CURUSER['id'] && get_user_class() < UC_MODERATOR)
	stderr("What?!","What the fuck are you doing?!");
    $topicid = (int)$arr['topicid'];

    if ($arr['posts_count'] < 2)
		stderr("Error", "Can't delete post; it is the only post of the topic. You should<br /><a href=".$_SERVER['PHP_SELF']."?action=deletetopic&topicid=$topicid>delete the topic</a> instead.");
    $redirtopost = (is_valid_id($arr['p_id']) ? "&page=p".$arr['p_id']."#".$arr['p_id'] : '');

    $sure = (int)$_GET['sure'];
    if (!$sure)
        stderr("Sanity check...", "You are about to delete a post. Click <a href=".$_SERVER['PHP_SELF']."?action=deletepost&postid=$postid&sure=1>here</a> if you are sure.");

    mysql_query("DELETE posts.* ".($use_attachment_mod ? ", attachments.*, attachmentdownloads.* " : "").
                "FROM posts ".
                ($use_attachment_mod ? "LEFT JOIN attachments ON attachments.postid = posts.id ".
                "LEFT JOIN attachmentdownloads ON attachmentdownloads.fileid = attachments.id " : "").
                "WHERE posts.id = ".sqlesc($postid)) or sqlerr(__FILE__, __LINE__);

    if ($use_attachment_mod && !empty($arr['filename']))
	{
		$filename = $attachment_dir."/".$arr['filename'];
		if (is_file($filename))
        	unlink($filename);
	}

    update_topic_last_post($topicid);

    header("Location: {$_SERVER['PHP_SELF']}?action=viewtopic&topicid=".$topicid.$redirtopost);
    exit();
}
else if ($use_poll_mod && ($action == 'deletepoll' && get_user_class() >= UC_MODERATOR))
{
	$pollid = (int)$_GET["pollid"];
	if (!is_valid_id($pollid))
		stderr("Error", "Invalid ID!");
	
	$res = mysql_query("SELECT pp.id, t.id AS tid FROM postpolls AS pp LEFT JOIN topics AS t ON t.pollid = pp.id WHERE pp.id = ".sqlesc($pollid));
	if (mysql_num_rows($res) == 0)
		stderr("Error", "No poll found with that ID.");
	
	$arr = mysql_fetch_array($res);
	
	$sure = (int)$_GET['sure'];
	if (!$sure || $sure != 1)
		stderr('Sanity check...', 'You are about to delete a poll. Click <a href='.$_SERVER['PHP_SELF'].'?action='.htmlspecialchars($action).'&pollid='.$arr['id'].'&sure=1>here</a> if you are sure.');
				
	mysql_query("DELETE pp.*, ppa.* FROM postpolls AS pp LEFT JOIN postpollanswers AS ppa ON ppa.pollid = pp.id WHERE pp.id = ".sqlesc($pollid));
	
	if (mysql_affected_rows() == 0)
		stderr('Sorry...', 'There was an error while deleting the poll, please re-try.');
	
	mysql_query("UPDATE topics SET pollid = '0' WHERE pollid = ".sqlesc($pollid));
	
	header('Location: '.$_SERVER['PHP_SELF'].'?action=viewtopic&topicid='.(int)$arr['tid']);
	exit();
}
else if ($use_poll_mod && $action == 'makepoll')
{
	$subaction = (isset($_GET["subaction"]) ? $_GET["subaction"] : (isset($_POST["subaction"]) ? $_POST["subaction"] : ''));
	$pollid = (isset($_GET["pollid"]) ? (int)$_GET["pollid"] : (isset($_POST["pollid"]) ? (int)$_POST["pollid"] : 0));
	
	$topicid = (isset($_POST["topicid"]) ? (int)$_POST["topicid"] : 0);
	
	if ($subaction == "edit")
	{
		if (!is_valid_id($pollid))
			stderr("Error", "Invalid ID!");
		
		$res = mysql_query("SELECT pp.*, t.id AS tid FROM postpolls AS pp LEFT JOIN topics AS t ON t.pollid = pp.id WHERE pp.id = ".sqlesc($pollid)) or sqlerr(__FILE__, __LINE__);
		
		if (mysql_num_rows($res) == 0)
			stderr("Error", "No poll found with that ID.");
		
		$poll = mysql_fetch_assoc($res);
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST" && !$topicid)
	{
		$topicid = (int)($subaction == "edit" ? $poll['tid'] : $_POST["updatetopicid"]);
		
		$question = $_POST["question"];
		$option0 = $_POST["option0"];
		$option1 = $_POST["option1"];
		$option2 = $_POST["option2"];
		$option3 = $_POST["option3"];
		$option4 = $_POST["option4"];
		$option5 = $_POST["option5"];
		$option6 = $_POST["option6"];
		$option7 = $_POST["option7"];
		$option8 = $_POST["option8"];
		$option9 = $_POST["option9"];
		$option10 = $_POST["option10"];
		$option11 = $_POST["option11"];
		$option12 = $_POST["option12"];
		$option13 = $_POST["option13"];
		$option14 = $_POST["option14"];
		$option15 = $_POST["option15"];
		$option16 = $_POST["option16"];
		$option17 = $_POST["option17"];
		$option18 = $_POST["option18"];
		$option19 = $_POST["option19"];
		$sort = $_POST["sort"];
	
		if (!$question || !$option0 || !$option1)
			stderr("Error", "Missing form data!");
	
		if ($subaction == "edit" && is_valid_id($pollid))
			mysql_query("UPDATE postpolls SET " .
							"question = " . sqlesc($question) . ", " .
							"option0 = " . sqlesc($option0) . ", " .
							"option1 = " . sqlesc($option1) . ", " .
							"option2 = " . sqlesc($option2) . ", " .
							"option3 = " . sqlesc($option3) . ", " .
							"option4 = " . sqlesc($option4) . ", " .
							"option5 = " . sqlesc($option5) . ", " .
							"option6 = " . sqlesc($option6) . ", " .
							"option7 = " . sqlesc($option7) . ", " .
							"option8 = " . sqlesc($option8) . ", " .
							"option9 = " . sqlesc($option9) . ", " .
							"option10 = " . sqlesc($option10) . ", " .
							"option11 = " . sqlesc($option11) . ", " .
							"option12 = " . sqlesc($option12) . ", " .
							"option13 = " . sqlesc($option13) . ", " .
							"option14 = " . sqlesc($option14) . ", " .
							"option15 = " . sqlesc($option15) . ", " .
							"option16 = " . sqlesc($option16) . ", " .
							"option17 = " . sqlesc($option17) . ", " .
							"option18 = " . sqlesc($option18) . ", " .
							"option19 = " . sqlesc($option19) . ", " .
							"sort = " . sqlesc($sort) . " " .
					"WHERE id = ".sqlesc((int)$poll["id"])) or sqlerr(__FILE__, __LINE__);
		else
		{
			if (!is_valid_id($topicid))
				stderr('Error', 'Invalid topic ID!');
	
			mysql_query("INSERT INTO postpolls VALUES(id" .
							", " . sqlesc(get_date_time()) .
							", " . sqlesc($question) .
							", " . sqlesc($option0) .
							", " . sqlesc($option1) .
							", " . sqlesc($option2) .
							", " . sqlesc($option3) .
							", " . sqlesc($option4) .
							", " . sqlesc($option5) .
							", " . sqlesc($option6) .
							", " . sqlesc($option7) .
							", " . sqlesc($option8) .
							", " . sqlesc($option9) .
							", " . sqlesc($option10) .
							", " . sqlesc($option11) .
							", " . sqlesc($option12) .
							", " . sqlesc($option13) .
							", " . sqlesc($option14) .
							", " . sqlesc($option15) .
							", " . sqlesc($option16) .
							", " . sqlesc($option17) .
							", " . sqlesc($option18) .
							", " . sqlesc($option19) .
							", " . sqlesc($sort).")") or sqlerr(__FILE__, __LINE__);
	
			$pollnum = mysql_insert_id();
	
			mysql_query("UPDATE topics SET pollid = ".sqlesc($pollnum)." WHERE id = ".sqlesc($topicid)) or sqlerr(__FILE__, __LINE__);
		}
		
		header("Location: {$_SERVER['PHP_SELF']}?action=viewtopic&topicid=$topicid");
		exit();
	}
	stdhead(); begin_main_frame();
	
	if ($subaction == "edit")
		echo "<h1>Edit poll</h1>";
	?>
	<table border=1 cellspacing=0 cellpadding=5 width=100%>
	<form method=post action='<?php echo $_SERVER['PHP_SELF']; ?>'>
    <input type=hidden name=action value=<?php echo $action; ?>>
	<input type=hidden name=subaction value=<?php echo $subaction; ?>>
	<input type=hidden name=updatetopicid value=<?php echo (int)$topicid; ?>>
	<?php
	if ($subaction == "edit")
	{
		?><input type=hidden name=pollid value=<?php echo (int)$poll["id"]; ?>><?php
	}
	?>
	<tr><td class=rowhead>Question <font color=red>*</font></td><td align=left><textarea name=question cols=70 rows=4><?php echo ($subaction == "edit" ? htmlspecialchars($poll['question']) : ''); ?></textarea></td></tr>
	<tr><td class=rowhead>Option 1 <font color=red>*</font></td><td align=left><input name=option0 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option0']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 2 <font color=red>*</font></td><td align=left><input name=option1 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option1']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 3</td><td align=left><input name=option2 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option2']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 4</td><td align=left><input name=option3 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option3']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 5</td><td align=left><input name=option4 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option4']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 6</td><td align=left><input name=option5 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option5']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 7</td><td align=left><input name=option6 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option6']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 8</td><td align=left><input name=option7 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option7']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 9</td><td align=left><input name=option8 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option8']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 10</td><td align=left><input name=option9 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option9']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 11</td><td align=left><input name=option10 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option10']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 12</td><td align=left><input name=option11 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option11']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 13</td><td align=left><input name=option12 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option12']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 14</td><td align=left><input name=option13 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option13']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 15</td><td align=left><input name=option14 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option14']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 16</td><td align=left><input name=option15 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option15']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 17</td><td align=left><input name=option16 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option16']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 18</td><td align=left><input name=option17 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option17']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 19</td><td align=left><input name=option18 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option18']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Option 20</td><td align=left><input name=option19 size=80 maxlength=40 value="<?php echo ($subaction == "edit" ? htmlspecialchars($poll['option19']) : ''); ?>"><br></td></tr>
	<tr><td class=rowhead>Sort</td><td>
	<input type=radio name=sort value=yes <?php echo ($subaction == "edit" ? ($poll["sort"] != "no" ? " checked" : "") : ''); ?>>Yes
	<input type=radio name=sort value=no <?php echo ($subaction == "edit" ? ($poll["sort"] == "no" ? " checked" : "") : ' checked'); ?>> No
	</td></tr>
	<tr><td colspan=2 align=center><input type=submit value='<?php echo ($pollid ? 'Edit poll' : 'Create poll'); ?>' style='height: 20pt'></td></tr>
	</table>
	<p align="center"><font color=red>*</font> required</p>
	
	</form><?php
	end_main_frame(); stdfoot();
}
else if ($use_attachment_mod && $action == "attachment")
{
	@ini_set('zlib.output_compression', 'Off');
	@set_time_limit(0);
	
	if (@ini_get('output_handler') == 'ob_gzhandler' && @ob_get_length() !== false)
	{
		@ob_end_clean();
		header('Content-Encoding:');
	}
	
	$id = (int)$_GET['attachmentid'];
	if (!is_valid_id($id))
		die('Invalid Attachment ID!');
	
	$at = mysql_query("SELECT filename, owner, type FROM attachments WHERE id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
	$resat = mysql_fetch_assoc($at) or die('No attachment with that ID!');
	$filename = $attachment_dir.'/'.$resat['filename'];
	
	if (!is_file($filename))
		die('Inexistent atachment.');
		
	if (!is_readable($filename))
		die('Attachment is unreadable.');
	
	if ((isset($_GET['subaction']) ? $_GET['subaction'] : '') == 'delete')
	{
		if ($CURUSER['id'] <> $resat["owner"] && get_user_class() < UC_MODERATOR)
			die('Not your attachment to delete.');
		
		unlink($filename);
		
		mysql_query("DELETE attachments, attachmentdownloads ".
					"FROM attachments ".
					"LEFT JOIN attachmentdownloads ON attachmentdownloads.fileid = attachments.id ".
					"WHERE attachments.id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
		
		die('<font color=red>File successfully deleted...</font>');
	}
		
	mysql_query("UPDATE attachments SET downloads = downloads + 1 WHERE id = ".sqlesc($id)) or sqlerr(__FILE__, __LINE__);
	
	$res = mysql_query("SELECT fileid FROM attachmentdownloads WHERE fileid=".sqlesc($id)." AND userid=".sqlesc($CURUSER['id']));
	if (mysql_num_rows($res) == 0)
		mysql_query("INSERT INTO attachmentdownloads (fileid, username, userid, date, downloads) VALUES (".sqlesc($id).", ".sqlesc($CURUSER['username']).", ".sqlesc($CURUSER['id']).", ".sqlesc(get_date_time()).", 1)") or sqlerr(__FILE__, __LINE__);
	else
		mysql_query("UPDATE attachmentdownloads SET downloads = downloads + 1 WHERE fileid = ".sqlesc($id)." AND userid = ".sqlesc($CURUSER['id']));
	
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false); // required for certain browsers 
	header("Content-Type: ".$arr['type']);
	header("Content-Disposition: attachment; filename=\"".basename($filename)."\";" );
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($filename));
	readfile($filename);
	exit();
}
else if ($use_attachment_mod && $action == "whodownloaded")
{
	$fileid = (int)$_GET['fileid'];
	if (!is_valid_id($fileid))
		die('Invalid ID!');
	
	$res = mysql_query("SELECT fileid, at.filename, userid, username, atdl.downloads, date, at.downloads AS dl ".
					   "FROM attachmentdownloads AS atdl ".
					   "LEFT JOIN attachments AS at ON at.id=atdl.fileid ".
					   "WHERE fileid = ".sqlesc($fileid).(get_user_class() < UC_MODERATOR ? " AND owner=".$CURUSER['id'] : '')) or sqlerr(__FILE__, __LINE__);
	
	if (mysql_num_rows($res) == 0)
		die('<h2 align="center">Nothing found!</h2>');
	else
	{
		?><html><head><link rel="stylesheet" href="<?php echo $DEFAULTBASEURL; ?>/default.css" type="text/css" media="screen" /></head><body>
		<table width='100%' cellpadding='5' border="1">
		<tr align="center">
			<td>File Name</td>
			<td><nobr>Downloaded by</nobr></td>
			<td>Downloads</td>
			<td>Date</td>
		</tr><?php
		
		$dls = 0;
		while ($arr = mysql_fetch_assoc($res))
		{
			echo "<tr align='center'>".
				 "<td>".htmlspecialchars($arr['filename'])."</td>".
				 "<td><a class='pointer' onclick=\"opener.location=('/userdetails.php?id=".(int)$arr['userid']."'); self.close();\">".htmlspecialchars($arr['username'])."</a></td>".
				 "<td>".(int)$arr['downloads']."</td>".
				 "<td>".$arr['date']." (".get_elapsed_time(sql_timestamp_to_unix_timestamp($arr['date'])).")</td>".
				 "</tr>";
	
			$dls += (int)$arr['downloads'];
		}
		?><tr><td colspan='4'><b>Total Downloads:</b> <b><?php echo number_format($dls); ?></b></td></tr></table></body></html><?php
	}
}
else if ($action == "viewforum") //-------- Action: View forum
{
	$forumid = (int)$_GET['forumid'];
	if (!is_valid_id($forumid))
		stderr('Error', 'Invalid ID!');
	
	$page = (isset($_GET["page"]) ? (int)$_GET["page"] : 0);
	$userid = (int)$CURUSER["id"];
	
	//------ Get forum details
	$res = mysql_query("SELECT f.name AS forum_name, f.minclassread, (SELECT COUNT(id) FROM topics WHERE forumid = f.id) AS t_count ".
					   "FROM forums AS f ".
					   "WHERE f.id = ".sqlesc($forumid)) or sqlerr(__FILE__, __LINE__);
	$arr = mysql_fetch_assoc($res) or stderr('Error', 'No forum with that ID!');
	
	if (get_user_class() < $arr["minclassread"])
		stderr('Error', 'Access Denied!');
	
	$perpage = (empty($CURUSER['topicsperpage']) ? 20 : (int)$CURUSER['topicsperpage']);
	$num = (int)$arr['t_count'];
	
	if ($page == 0)
		$page = 1;
	
	$first = ($page * $perpage) - $perpage + 1;
	$last = $first + $perpage - 1;
	
	if ($last > $num)
		$last = $num;
	
	$pages = floor($num / $perpage);
	
	if ($perpage * $pages < $num)
		++$pages;
	
	//------ Build menu
	$menu1 = "<p class=success align=center>";
	$menu2 = '';
	
	$lastspace = false;
	for ($i = 1; $i <= $pages; ++$i)
	{
		if ($i == $page)
			$menu2 .= "<b>[<u>$i</u>]</b>\n";
		
		else if ($i > 3 && ($i < $pages - 2) && ($page - $i > 3 || $i - $page > 3))
		{
			if ($lastspace)
				continue;
			
			$menu2 .= "... \n";
			
			$lastspace = true;
		}
		else
		{
			$menu2 .= "<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=$forumid&page=$i><b>$i</b></a>\n";
	
			$lastspace = false;
		}
	
		if ($i < $pages)
			$menu2 .= "</b>|<b>";
	}    
	
	$menu1 .= ($page == 1 ? "<b>&lt;&lt;&nbsp;Prev</b>" : "<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=$forumid&page=" . ($page - 1) . "><b>&lt;&lt;&nbsp;Prev</b></a>");
	$mlb = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$menu3 = ($last == $num ? "<b>Next&nbsp;&gt;&gt;</b></p>" : "<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=$forumid&page=" . ($page + 1) . "><b>Next&nbsp;&gt;&gt;</b></a></p>");
	
	$offset = $first - 1;
	
	$topics_res = mysql_query(
	"SELECT t.id, t.userid, t.views, t.locked, t.sticky".($use_poll_mod ? ', t.pollid' : '').", t.subject, u1.username, u1.smilie, u1.class, r.lastpostread, p.id AS p_id, p.userid AS p_userid, p.added AS p_added, (SELECT COUNT(id) FROM posts WHERE topicid=t.id) AS p_count, u2.username AS u2_username, u2.class AS u2_class, u2.smilie AS u2_smilie ".
	"FROM topics AS t ".
	"LEFT JOIN users AS u1 ON u1.id=t.userid ".
	"LEFT JOIN readposts AS r ON r.userid = ".sqlesc($userid)." AND r.topicid = t.id ".
	"LEFT JOIN posts AS p ON p.id = (SELECT MAX(id) FROM posts WHERE topicid = t.id) ".
	"LEFT JOIN users AS u2 ON u2.id = p.userid ".
	"WHERE t.forumid = ".sqlesc($forumid)." ORDER BY t.sticky, t.lastpost ASC LIMIT $offset, $perpage") or sqlerr(__FILE__, __LINE__);
	
	stdhead("Forum"); begin_main_frame();
	
	?><h1 align="center"><?php echo htmlspecialchars($arr["forum_name"]); ?></h1><?php
	
	if (mysql_num_rows($topics_res) > 0)
	{
		?><table border=1 cellspacing=0 cellpadding=5 width=<?php echo $forum_width; ?>>
		<tr>
			<td class=colhead align=left>Topic</td>
			<td class=colhead>Replies</td>
			<td class=colhead>Views</td>
			<td class=colhead align=left>Author</td>
			<td class=colhead align=left>Last&nbsp;post</td>
		</tr>
		<?php
		while ($topic_arr = mysql_fetch_assoc($topics_res))
		{
			$topicid = (int)$topic_arr['id'];
			$topic_userid = (int)$topic_arr['userid'];
			$sticky = ($topic_arr['sticky'] == "yes");
			($use_poll_mod ? $topicpoll = is_valid_id($topic_arr["pollid"]) : NULL);
		
			$tpages = floor($topic_arr['p_count'] / $postsperpage);
			
			if (($tpages * $postsperpage) != $topic_arr['p_count'])
				++$tpages;
			
			if ($tpages > 1)
			{
				$topicpages = "&nbsp;(<img src='".$pic_base_url.$forum_pics['multipage']."' alt='Multiple pages' title='Multiple pages'>";
				$split = ($tpages > 10) ? true : false;
				$flag = false;
				
				for ($i = 1; $i <= $tpages; ++$i)
				{
					if ($split && ($i > 4 && $i < ($tpages - 3)))
					{
						if (!$flag)
						{
							$topicpages .= '&nbsp;...';
							$flag = true;
						}
						continue;
					}
					$topicpages .= "&nbsp;<a href=".$_SERVER['PHP_SELF']."?action=viewtopic&topicid=$topicid&page=$i>$i</a>";
				}
				$topicpages .= ")";
			}
			else
				$topicpages = '';
		
			$lpusername = (is_valid_id($topic_arr['p_userid']) && !empty($topic_arr['u2_username']) ? "<a onmouseover=\"ajax_showTooltip('showtip.php?id={$topic_arr[p_userid]}',this);return false\" onmouseout=\"ajax_hideTooltip()\" href='$DEFAULTBASEURL/userdetails.php?id=".(int)$topic_arr['p_userid']."' class='special' id='".get_user_class_color($topic_arr['u2_class'])."'>".$topic_arr['u2_username']."".format_smilie($topic_arr['u2_smilie'])."</a>" : "unknown[$topic_userid]");
			$lpauthor = (is_valid_id($topic_arr['userid']) && !empty($topic_arr['username']) ? "<a onmouseover=\"ajax_showTooltip('showtip.php?id={$topic_userid}',this);return false\" onmouseout=\"ajax_hideTooltip()\" href='$DEFAULTBASEURL/userdetails.php?id=$topic_userid' class='special' id='".get_user_class_color($topic_arr['class'])."'>".$topic_arr['username']."".format_smilie($topic_arr['smilie'])."</a>" : "unknown[$topic_userid]");
			$new = ($topic_arr["p_added"] > (get_date_time(gmtime() - $READPOST_EXPIRY))) ? ((int)$topic_arr['p_id'] > $topic_arr['lastpostread']) : 0;
			$topicpic = ($topic_arr['locked'] == "yes" ? ($new ? "lockednew" : "locked") : ($new ? "unlockednew" : "unlocked"));
			
			?>
			<tr>
				<td align=left width="100%">
					<table border=0 cellspacing=0 cellpadding=0>
						<tr>
							<td class=embedded style='padding-right: 5px'><img src='<?php echo $pic_base_url.$forum_pics[$topicpic]; ?>'></td>
							<td class=embedded align=left><?php echo ($sticky ? "<img src=".$pic_base_url.$forum_pics["sticky"]." alt='Sticky:' title='Sticky:' border='none'>&nbsp;" : ""); ?><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewtopic&topicid=<?php echo $topicid; ?>'><?php echo htmlspecialchars($topic_arr['subject']); ?></a><?php echo $topicpages; ?></td>
						</tr>
					</table>
				</td>
				<td align="center"><?php echo max(0, $topic_arr['p_count'] - 1); ?></td>
				<td align="center"><?php echo number_format($topic_arr['views']); ?></td>
				<td align="center"><?php echo $lpauthor; ?></td>
				<td align='left'><nobr><?php echo $topic_arr["p_added"]; ?><br />by&nbsp;<?php echo $lpusername; ?></td>
			</tr>
			<?php
		}
		
		end_table();
	}
	else
	{
		?><p align=center>No topics found</p><?php
	}
	
	echo $menu1.$mlb.$menu2.$mlb.$menu3;
	?>
	<table class=main border=0 cellspacing=0 cellpadding=0 align=center>
	<tr valing=center>
		<td class=embedded><img src='<?php echo $pic_base_url.$forum_pics['unlocked']; ?>' style='margin-right: 5px'></td>
		<td class=embedded>New posts</td>
		<td class=embedded><img src='<?php echo $pic_base_url.$forum_pics['locked']; ?>' style='margin-left: 10px; margin-right: 5px'></td>
		<td class=embedded>Locked topic</td>
	</tr>
	</table>
	<?php
	$arr = get_forum_access_levels($forumid) or die();
	
	$maypost = (get_user_class() >= $arr["write"] && get_user_class() >= $arr["create"]);
	
	if (!$maypost)
	{
		?><p><i>You are not permitted to start new topics in this forum.</i></p><?php
	}
	
	?>
	<table border=0 class=main cellspacing=0 cellpadding=0 align=center>
	<tr>
	<td class=embedded><form method=get action='<?php echo $_SERVER['PHP_SELF']; ?>'><input type=hidden name=action value=viewunread><input type=submit value='View unread' class=gobutton></form></td>
	<?php
	if ($maypost)
	{
		?>
		<td class=embedded><form method=get action='<?php echo $_SERVER['PHP_SELF']; ?>'><input type=hidden name=action value=newtopic><input type=hidden name=forumid value=<?php echo $forumid; ?>><input type=submit value='New topic' class=gobutton style='margin-left: 10px'></form></td>
		<?php
	}
	
	?></tr></table><?php
	
	insert_quick_jump_menu($forumid);
	
	end_main_frame(); stdfoot();
	exit();
}
else if ($action == 'viewunread') //-------- Action: View unread posts
{
	if ((isset($_POST[$action."_action"]) ? $_POST[$action."_action"] : '') == 'clear')
	{
		$topic_ids = (isset($_POST['topic_id']) ? $_POST['topic_id'] : array());
	
		if (empty($topic_ids))
		{
			header('Location: '.$_SERVER['PHP_SELF'].'?action='.$action);
			exit();
		}
	
		foreach ($topic_ids as $topic_id)
			if (!is_valid_id($topic_id))
				stderr('Error...', 'Invalid ID!');
		
		catch_up($topic_ids);
		
		header('Location: '.$_SERVER['PHP_SELF'].'?action='.$action);
		exit();
	}
	else
	{
		$added = sqlesc(get_date_time(gmtime() - $READPOST_EXPIRY));
		
		$res = mysql_query('SELECT t.lastpost, r.lastpostread, f.minclassread '.
						   'FROM topics AS t '.
						   'LEFT JOIN posts AS p ON t.lastpost=p.id '.
						   'LEFT JOIN readposts AS r ON r.userid='.sqlesc((int)$CURUSER['id']).' AND r.topicid=t.id '.
						   'LEFT JOIN forums AS f ON f.id=t.forumid '.
						   'WHERE p.added < '.$added) or sqlerr(__FILE__, __LINE__);
		$count = 0;
		while($arr = mysql_fetch_assoc($res))
		{
			if ($arr['lastpostread'] >= $arr['lastpost'] || get_user_class() < $arr['minclassread'])
				continue;
			
			$count++;
		}
		mysql_free_result($res);
		
		if ($count > 0)
		{
			list($pagertop, $pagerbottom, $limit) = pager(25, $count, $_SERVER['PHP_SELF'].'?action='.$action.'&');
			
			stdhead(); begin_main_frame();
			
			echo '<h1 align=center>Topics with unread posts</h1>';
			
			echo '<p>'.$pagertop.'</p>';
			
			?>
			<script language="javascript">
				var checkflag = "false";
	
				function check(a)
				{
					if (checkflag == "false")
					{
						for(i=0; i < a.length; i++)
							a[i].checked = true;
						
						checkflag = "true";
						
						value = "Uncheck";
					}
					else
					{
						for(i=0; i < a.length; i++)
							a[i].checked = false;
						
						checkflag = "false";
						
						value = "Check";
					}
					
					return value + " All";
				};
			</script>
	
			<form method="post" action="<?php echo $_SERVER['PHP_SELF'].'?action='.$action; ?>">
			<input type="hidden" name="<?php echo $action.'_action'; ?>" value="clear" />
			<?php
			
			?>
            <table cellpadding="5" width='<?php echo $forum_width; ?>'>
			<tr align="left">
				<td class="colhead" colspan="2">Topic</td>
				<td class="colhead" width="1%">Clear</td>
			</tr>
			<?php
		
			$res = mysql_query('SELECT t.id, t.forumid, t.subject, t.lastpost, r.lastpostread, f.name, f.minclassread '.
							   'FROM topics AS t '.
							   'LEFT JOIN posts AS p ON t.lastpost=p.id '.
							   'LEFT JOIN readposts AS r ON r.userid='.sqlesc((int)$CURUSER['id']).' AND r.topicid=t.id '.
							   'LEFT JOIN forums AS f ON f.id=t.forumid '.
							   'WHERE p.added < '.$added.' '.
							   'ORDER BY t.forumid '.$limit) or sqlerr(__FILE__, __LINE__);
	
			while($arr = mysql_fetch_assoc($res))
			{
				if ($arr['lastpostread'] >= $arr['lastpost'] || get_user_class() < $arr['minclassread'])
					continue;
				
				?>
				<tr>
					<td align="center" width="1%">
						<img src='<?php echo $pic_base_url.$forums_pics['unlocked']; ?>'>
					</td>
					<td align="left">
						<a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewtopic&topicid=<?php echo (int)$arr['id']; ?>&page=last#last'><?php echo htmlspecialchars($arr['subject']); ?></a><br />in&nbsp;<font class="small"><a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo (int)$arr['forumid']; ?>'><?php echo htmlspecialchars($arr['name']); ?></a></font>
					 </td>
					<td align="center">
						<input type="checkbox" name="topic_id[]" value="<?php echo (int)$arr['id']; ?>" />
					</td>
				</tr>
				<?php
			}
			mysql_free_result($res);
			
			?>
			<tr>
				<td align="center" colspan="3">
					<input type='button' value="Check All" onClick="this.value = check(form);">&nbsp;<input type="submit" value="Clear selected" />
				</td>
			</tr>
			<?php
			
			end_table();
			
			?></form><?php
			
			echo '<p>'.$pagerbottom.'</p>';
			
			echo '<div align="center"><a href="'.$_SERVER['PHP_SELF'].'?catchup">Mark all posts as read</a></div>';
			
			end_main_frame(); stdfoot(); die();
		}
		else
			stderr("Sorry...", "There are no unread posts.<br /><br />Click <a href=".$_SERVER['PHP_SELF']."?action=getdaily>here</a> to get today's posts (last 24h).");
	}
}
else if ($action == "getdaily")
{
	$res = mysql_query('SELECT COUNT(p.id) AS post_count '.
					   'FROM posts AS p '.
					   'LEFT JOIN topics AS t ON t.id = p.topicid '.
					   'LEFT JOIN forums AS f ON f.id = t.forumid '.
					   'WHERE ADDDATE(p.added, INTERVAL 1 DAY) > '.sqlesc(get_date_time()).' AND f.minclassread <= '.get_user_class()) or sqlerr(__FILE__, __LINE__);
	
	$arr = mysql_fetch_assoc($res);
	mysql_free_result($res);
	
	$count = (int)$arr['post_count'];
	if (empty($count))
		stderr('Sorry', 'No posts in the last 24 hours.');
	
	stdhead('Today Posts (Last 24 Hours)'); begin_main_frame();
	
	list($pagertop, $pagerbottom, $limit) = pager(20, $count, $_SERVER['PHP_SELF'].'?action='.$action.'&');
	
	?><h2 align="center">Today Posts (Last 24 Hours)</h2><?php
	echo "<p>$pagertop</p>";
	
	?>
    <table cellpadding="5" width="<?php echo $forum_width; ?>">
    <tr class="colhead" align="center">
		<td width="100%" align="left">Topic Title</td>
		<td>Views</td>
		<td>Author</td>
		<td>Posted At</td>
	</tr><?php
	
	$res = mysql_query('SELECT p.id AS pid, p.topicid, p.userid AS userpost, p.added, t.id AS tid, t.subject, t.forumid, t.lastpost, t.views, f.name, f.minclassread, f.topiccount, u.username,u.class, u.smilie '.
					   'FROM posts AS p '.
					   'LEFT JOIN topics AS t ON t.id = p.topicid '.
					   'LEFT JOIN forums AS f ON f.id = t.forumid '.
					   'LEFT JOIN users AS u ON u.id = p.userid '.
					   'LEFT JOIN users AS topicposter ON topicposter.id = t.userid '.
					   'WHERE ADDDATE(p.added, INTERVAL 1 DAY) > '.sqlesc(get_date_time()).' AND f.minclassread <= '.get_user_class().' '.
					   'ORDER BY p.added DESC '.$limit) or sqlerr(__FILE__, __LINE__);
	
	while ($getdaily = mysql_fetch_assoc($res))
	{
		$postid = (int)$getdaily['pid'];
		$posterid = (int)$getdaily['userpost'];
		
		?><tr><?php
			?><td align="left"><?php
				?><a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=viewtopic&topicid=<?php echo $getdaily['tid']; ?>&page=<?php echo $postid; ?>#<?php echo $postid ?>"><?php echo htmlspecialchars($getdaily['subject']); ?></a><br /><?php
				?><b>In</b>&nbsp;<a href="<?php echo $_SERVER['PHP_SELF']; ?>?action=viewforum&forumid=<?php echo (int)$getdaily['forumid']; ?>"><?php echo htmlspecialchars($getdaily['name']); ?></a><?php
			?></td><?php
			?><td align="center"><?php echo number_format($getdaily['views']); ?></td><?php
			?><td align="center"><?php
				if (!empty($getdaily['username']))
				{
					?><a onmouseover="ajax_showTooltip('showtip.php?id=<?php echo $posterid;?>',this);return false" onmouseout="ajax_hideTooltip()" href="<?php echo $DEFAULTBASEURL; ?>/userdetails.php?id=<?php echo $posterid; ?>" class="special" id="<?php echo get_user_class_color($getdaily['class']);?>"><?php echo htmlspecialchars($getdaily['username']).format_smilie($getdaily['smilie']); ?></a><?php
				}
				else
				{
					?><b>unknown[<?php echo $posterid; ?>]</b><?php
				}
			?></td><?php
			?><td><?php
				?><nobr><?php
				echo $getdaily['added'];
				?><br /><?php
				echo get_elapsed_time(strtotime($getdaily['added']));
				?></nobr><?php
			?></td><?php
		?></tr><?php
	}
	mysql_free_result($res);
	
	end_table();
	
	echo "<p>$pagerbottom</p>";
	
	end_main_frame(); stdfoot();
}
else if ($action == "search") //-------- Action: Search
{
	stdhead("Forum Search");
	
	$error = false;
	$found = '';
	$keywords = (isset($_GET['keywords']) ? trim($_GET['keywords']) : '');
	if (!empty($keywords))
	{
		$res = mysql_query("SELECT COUNT(id) AS c FROM posts WHERE body LIKE ".sqlesc("%".sqlwildcardesc($keywords)."%")) or sqlerr(__FILE__, __LINE__);
		$arr = mysql_fetch_assoc($res);
		$count = (int)$arr['c'];
		$keywords = htmlspecialchars($keywords);
		
		if ($count == 0)
			$error = true;
		else
		{
			list($pagertop, $pagerbottom, $limit) = pager(10, $count, $_SERVER['PHP_SELF'].'?action='.$action.'&keywords='.$keywords.'&');
			
			$res = mysql_query(
			"SELECT p.id, p.topicid, p.userid, p.added, t.forumid, t.subject, f.name, f.minclassread, u.username, u.class, u.smilie ".
			"FROM posts AS p ".
			"LEFT JOIN topics AS t ON t.id=p.topicid ".
			"LEFT JOIN forums AS f ON f.id=t.forumid ".
			"LEFT JOIN users AS u ON u.id=p.userid ".
			"WHERE p.body LIKE ".sqlesc("%".$keywords."%")." $limit");
	
			$num = mysql_num_rows($res);
			echo "<p>$pagertop</p>";
			begin_main_frame();
			
			?>
            <table border=0 cellspacing=0 cellpadding=5 width='100%'>
			<tr align="left">
            	<td class=colhead>Post</td>
                <td class=colhead>Topic</td>
                <td class=colhead>Forum</td>
                <td class=colhead>Posted by</td>
			</tr>
            <?php
			for ($i = 0; $i < $num; ++$i)
			{
				$post = mysql_fetch_assoc($res);
	
				if ($post['minclassread'] > get_user_class())
				{
					--$count;
					continue;
				}
	
				echo "<tr>".
					 	"<td align='center'>".$post['id']."</td>".
						"<td align=left width='100%'><a href=".$_SERVER['PHP_SELF']."?action=viewtopic&highlight=$keywords&topicid=".$post['topicid']."&page=p".$post['id']."#".$post['id']."><b>" . htmlspecialchars($post['subject']) . "</b></a></td>".
						"<td align=left><nobr>".(empty($post['name']) ? 'unknown['.$post['forumid'].']' : "<a href=".$_SERVER['PHP_SELF']."?action=viewforum&forumid=".$post['forumid']."><b>" . htmlspecialchars($post['name']) . "</b></a>")."</nobr></td>".
						"<td align=left><nobr>".(empty($post['username']) ? 'unknown['.$post['userid'].']' : "<a onmouseover=\"ajax_showTooltip('showtip.php?id={$post[userid]}',this);return false\" onmouseout=\"ajax_hideTooltip()\" href='$DEFAULTBASEURL/userdetails.php?id=".$post['userid']."' class='special' id='".get_user_class_color($post['class'])."'>".$post['username']."".format_smilie($post['smilie'])."</a>")."<br />at ".$post['added']."</nobr></td>".
					 "</tr>";
			}
			end_table();
			
			end_main_frame();
			echo "<p>$pagerbottom</p>";
			$found ="[<b><font color=red> Found $count post" . ($count != 1 ? "s" : "")." </font></b> ]";
			
		}
	}
	?><div>
	  <div><center><h1>Search on Forums</h1> <?php echo ($error ? "[<b><font color=red> Nothing Found</font></b> ]" : $found)?></center></div>
	  <div style="margin-left: 53px; margin-top: 13px;">
	<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="search_form" style="margin: 0pt; padding: 0pt; font-family: Tahoma,Arial,Helvetica,sans-serif; font-size: 11px;">
	<input type="hidden" name="action" value="search">
		  <table border="0" cellpadding="0" cellspacing="0" width="50%">
			<tbody>
			  <tr>
			  <td valign="top"><b>By keyword:</b></td>
			  </tr>
			  <tr>
			  <td valign="top">			
				<input name="keywords" type="text" value="<?php echo $keywords; ?>" size="65"><br /><font class="small"><b>Note:</b> Searches <u>only</u> in posts.</font></td>
				<td valign="top"><input type=submit value=search></td>
			  </tr>
			</tbody>
		  </table>
		</form>
	  </div>
	</div><?php
	stdfoot();
	exit();
}
else if ($action == 'forumview')
{
	$ovfid = (isset($_GET["forid"]) ? (int)$_GET["forid"] : 0);
	if (!is_valid_id($ovfid))
		stderr('Error', 'Invalid ID!');

	$res = mysql_query("SELECT name FROM overforums WHERE id = $ovfid") or sqlerr(__FILE__, __LINE__);
	$arr = mysql_fetch_assoc($res) or stderr('Sorry', 'No forums with that ID!');
	
	mysql_query("UPDATE users SET forum_access = ".sqlesc(get_date_time())." WHERE id = {$CURUSER['id']}") or sqlerr(__FILE__, __LINE__);
	
	stdhead("Forums"); begin_main_frame();
	
	?>
	<h1 align="center"><b><a href='<?php echo $_SERVER['PHP_SELF']; ?>'>Forums</a></b> -> <?php echo htmlspecialchars($arr["name"]); ?></h1>
	
	<table border=1 cellspacing=0 cellpadding=5 width='<?php echo $forum_width; ?>'>
		<tr>
        	<td class=colhead align=left>Forums</td>
            <td class=colhead align=right>Topics</td>
		<td class=colhead align=right>Posts</td>
		<td class=colhead align=left>Last post</td>
	</tr>
	<?php
	
	show_forums($ovfid);

	end_table();
	
	end_main_frame(); stdfoot();
	exit();
}
else //-------- Default action: View forums
{
	if (isset($_GET["catchup"]))
	{
		catch_up();
		
		header('Location: '.$_SERVER['PHP_SELF']);
		exit();
	}
	
	mysql_query("UPDATE users SET forum_access = '".get_date_time()."' WHERE id={$CURUSER['id']}") or sqlerr(__FILE__, __LINE__);
	
	stdhead("Forums"); begin_main_frame();
	
	?><h1 align="center"><b><?php echo $SITENAME; ?> - Forum</b></h1>
	<br />
	<table border=1 cellspacing=0 cellpadding=5 width='<?php echo $forum_width; ?>'><?php
	
	$ovf_res = mysql_query("SELECT id, name, minclassview FROM overforums ORDER BY sort ASC") or sqlerr(__FILE__, __LINE__);
	while ($ovf_arr = mysql_fetch_assoc($ovf_res))
	{
		if (get_user_class() < $ovf_arr["minclassview"])
			continue;
		
		$ovfid = (int)$ovf_arr["id"];
		$ovfname = $ovf_arr["name"];
	
		?><tr>
			<td align='left' class='colhead' width="100%">
				<a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=forumview&forid=<?php echo $ovfid; ?>'><b><font color='white'><?php echo htmlspecialchars($ovfname); ?></font></b></a>
			</td>
			<td align='right' class='colhead'><font color='white'><b>Topics</b></td>
			<td align='right' class='colhead'><font color='white'><b>Posts</b></font></td>
			<td align='left' class='colhead'><font color='white'><b>Last post</b></font></td>
		</tr><?php
	
		show_forums($ovfid);
	}
	end_table();
	
	if ($use_forum_stats_mod)
		forum_stats();
	
	?><p align='center'>
	<a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=search'><b>Search Forums</b></a> | 
	<a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=viewunread'><b>New Posts</b></a> | 
	<a href='<?php echo $_SERVER['PHP_SELF']; ?>?action=getdaily'><b>Todays Posts (Last 24 h.)</b></a> | 
	<a href='<?php echo $_SERVER['PHP_SELF']; ?>?catchup'><b>Mark all as read</b></a><?php 
	echo (get_user_class() == MAX_CLASS ? " | <a href='$DEFAULTBASEURL/moforums.php#add'><b>Forum-Manager</b></a>":"");
	?></p><?php
	
	end_main_frame(); stdfoot();
}
?>
