<?php


if (!defined('GANG_MODULE')) {
	return; 
}

	
$q_get = sprintf('select count(*) from gangwars
	where %d in (warDECLARER, warDECLARED)', $gvars->ir['gang']);
$q_get = mysql_query($q_get);
list($num_wars) = mysql_fetch_row($q_get);

$gvars->tabs += array(
	'gang_your_gang' => 'Home',
	'ygang_wars' => sprintf('Wars (%d)', $num_wars),
);
$gvars->actions += array(
	'gang_your_gang' => 'gang_your_gang',
	'ygang_summary' => 'ygang_summary',
	'ygang_donate' => 'ygang_donate',
	'ygang_donate2' => 'ygang_donate2',
	'ygang_members' => 'ygang_members',
	'ygang_kick' => 'ygang_kick',
	'ygang_kick2' => 'ygang_kick2',
	'ygang_leave' => 'ygang_leave',
	'ygang_leave2' => 'ygang_leave2',
	'ygang_attack_logs' => 'ygang_attack_logs',
	'ygang_forum' => 'ygang_forum',
	'ygang_new_topic' => 'ygang_new_topic',
	'ygang_new_topic2' => 'ygang_new_topic2',
	'ygang_topic' => 'ygang_topic',
	'ygang_reply' => 'ygang_reply',
	'ygang_reply2' => 'ygang_reply2',
	'ygang_edit_reply' => 'ygang_edit_reply',
	'ygang_edit_reply2' => 'ygang_edit_reply2',
	'ygang_delete_reply' => 'ygang_delete_reply',
	'ygang_delete_reply2' => 'ygang_delete_reply2',
	'ygang_wars' => 'ygang_wars',
);
$gvars->links_mygang += array(
	'ygang_summary' => array(
		'label' => 'Summary',
		'order' => 1
	), 'ygang_donate' => array(
		'label' => 'Donate',
		'order' => 2
	), 'ygang_members' => array(
		'label' => 'Members',
		'order' => 3
	), 'ygang_forum' => array(
		'label' => 'Forum',
		'order' => 4
	), 'ygang_leave' => array(
		'label' => 'Leave',
		'order' => 5
	), 'ygang_attack_logs' => array(
		'label' => 'Attack Logs',
		'order' => 6
	),
);


function gang_your_gang() {
	global $gvars;
	
	$gang_links = array();
	foreach ($gvars->links_mygang as $key => $value) {
		$gang_links[$value['order']] = sprintf('
<a href="yourgang.php?action=%s">%s</a>
		', $key, $value['label']);
	}
	ksort($gang_links, SORT_NUMERIC);
	
	$gang_links2 = '';
	$count = 0;
	foreach ($gang_links as $key => $value) {
		if ($count % 2 === 0) {
		$gang_links2 .= <<<EOT
		<tr>
			<th>
			$value
			</th>\n
EOT;
		} else {
		$gang_links2 .= <<<EOT
			<th>
			$value
			</th>
		</tr>\n
EOT;
		}
		$count++;
	}
	if ($count % 2 === 1) {
		$gang_links2 .= <<<EOT
			<th>
			&nbsp;
			</th>
		</tr>\n
EOT;
	}
	
	$events_list = '';
	// gevID, gevGANG, gevTIME, gevTEXT <<< gangevents
	$q_get = sprintf('select gevTIME, gevTEXT from gangevents
		where gevGANG = %d
		order by gevTIME desc limit 10', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		$events_list = <<<EOT
		<tr>
			<td colspan="2" class="bold center">
			There are no events yet.
			</td>
		</tr>
EOT;
	} else {
		while (list($ev_time, $ev_text) = mysql_fetch_row($q_get)) {
			$ev_time = gang_time_format($ev_time);
			$events_list .= <<<EOT
			<tr>
				<td>
				$ev_time
				</td>
				<td>
				$ev_text
				</td>
			</tr>\n
EOT;
		}
	}
	
	// gangID, gangNAME, gangDESC, gangPREF, gangSUFF, gangMONEY, gangCRYSTALS, gangRESPECT, gangPRESIDENT, gangVICEPRES, gangCAPACITY, gangCRIME, gangCHOURS, gangAMENT
	printf('
	<table class="ygang_menu" style="width: 200px">
		%s
	</table>
	<table style="width: 200px">
		<tr>
			<th>
			Gang Announcement
			</th>
		</tr>
		<tr>
			<td>
			%s
			</td>
		</tr>
	</table>
	<p class="bold center">Last 10 Gang Events</p>
	<table style="width: 400px; margin-top: 0">
		<tr>
			<th>
			Time
			</th>
			<th>
			Event
			</th>
		</tr>
		%s
	</table>
	', $gang_links2, $gvars->data['gangAMENT'], $events_list);
}

function ygang_wars() {
	global $gvars;
	
	if (!isset($_REQUEST['offset']) or intval($_REQUEST['offset']) < 1) {
		$offset = 0;
	} else {
		$offset = intval($_REQUEST['offset']);
	}
	if (!isset($_REQUEST['limit']) or intval($_REQUEST['limit']) < 25) {
		$limit = 25;
	} else if (intval($_REQUEST['limit']) > 100) {
		$limit = 100;
	} else {
		$limit = intval($_REQUEST['limit']);
	}
	
	$sorts = array('us', 'them', 'us_respect', 'them_respect', 'date');
	if (!isset($_REQUEST['sort']) or !in_array($_REQUEST['sort'], array('us', 'them', 'us_respect', 'them_respect', 'date'), true)) {
		$sort = 'date';
	} else {
		$sort = $_REQUEST['sort'];
	}
	
	$sorts = array_fill_keys($sorts, '');
	$sorts[$sort] = ' selected="selected"';
	switch ($sort) {
		case 'us':
			$order_by = 'a.gangNAME';
			break;
		case 'them':
			$order_by = 'b.gangNAME';
			break;
		case 'us_respect':
			$order_by = 'a.gangRESPECT desc';
			break;
		case 'them_respect':
			$order_by = 'b.gangRESPECT desc';
			break;
		case 'date':
		default:
			$order_by = 'w.warTIME desc';
			break;
	}
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	$q_get = sprintf('select count(*) from gangwars
		where %d in (warDECLARER, warDECLARED)', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	list($total_results) = mysql_fetch_row($q_get);
	
	$num_pages = ceil($total_results / $limit);
	$current_page = floor($offset / $limit) + 1;
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	$q_get = sprintf('select w.warID, w.warDECLARER, w.warDECLARED, w.warTIME,
		a.gangNAME, a.gangRESPECT, b.gangNAME, b.gangRESPECT from gangwars as w
		left join gangs as a on w.warDECLARER = a.gangID
		left join gangs as b on w.warDECLARED = b.gangID
		where %d in (w.warDECLARER, w.warDECLARED)
		order by %s limit %d, %d', $gvars->ir['gang'], $order_by, $offset, $limit);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		$gang_war_list = <<<EOT
		<tr>
			<td colspan="5">
			<h3>There are currently no $gvars->name_sl $gvars->war_pl in progress.</h3>
			</td>
		</tr>
EOT;
	} else {
		$gang_war_list = '';
		while (list($war_id, $us_id, $them_id, $start_time, $us_name, $us_respect, $them_name, $them_respect) = mysql_fetch_row($q_get)) {
			
			if (is_null($us_name) or is_null($them_name)) {
				mysql_query(sprintf('delete from gangwars where warID = %d', $war_id));
			}
			
			$gang_war_list .= sprintf('
			<tr class="left">
				<td>
				%s
				</td>
				<td class="right">
				%d
				</td>
				<td class="center bold" style="width: 70px; border: medium solid %s; border-top: none; border-bottom: none">
				vs.
				</td>
				<td>
				%s
				</td>
				<td class="right">
				%d
				</td>
			</tr>
			', gang_get_gang_link($us_id, $us_name), $us_respect, $gvars->color_border, gang_get_gang_link($them_id, $them_name), $them_respect);
		}
	}
	
	$page_options = '';
	for ($x = 1; $x <= $num_pages; $x++) {
		$page_offset = $x * $limit - $limit;
		if ($current_page == $x) {
			$selected = ' selected="selected"';
		} else {
			$selected = '';
		}
		$page_options .= <<<EOT
<option value="$page_offset"$selected>$x</option>\n
EOT;
	}
	
	
	// $sorts[$sort]
	printf('
	<h2>%s %s</h2>
	<table>
		<tr>
			<td class="center">
				<form method="get" action="yourgang.php">
					<input type="hidden" name="action" value="ygang_wars">
					Page Number <select name="offset">%s</select>
					Sort <select name="sort">
						<option value="date"%s>Start Date</option>
						<option value="us"%s>Attacker</option>
						<option value="them"%s>Defender</option>
						<option value="us_respect"%s>Attacker Respect</option>
						<option value="them_respect"%s>Defender Respect</option>
					</select>
					<input type="submit" value="Go">
				</form>
			</td>
		</tr>
	</table>
	<table style="width: 400px">
		<tr>
			<th>
			Attacker
			</th>
			<th>
			Respect
			</th>
			<th>
			&nbsp;
			</th>
			<th>
			Defender
			</th>
			<th>
			Respect
			</th>
		</tr>
%s
	</table>', $gvars->name_su, $gvars->war_pu, $page_options, $sorts['date'], $sorts['us'],
	$sorts['them'], $sorts['us_respect'], $sorts['them_respect'], $gang_war_list);
	
	
//	 Gang Wars
//There are currently no gang wars in progress.
}

function ygang_forum() {
	global $gvars;
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	
	if (!isset($_REQUEST['offset']) or intval($_REQUEST['offset']) < 1) {
		$offset = 0;
	} else {
		$offset = intval($_REQUEST['offset']);
	}
	
	if (!isset($_REQUEST['limit']) or intval($_REQUEST['limit']) < 25) {
		$limit = 25;
	} else if (intval($_REQUEST['limit']) > 100) {
		$limit = 100;
	} else {
		$limit = intval($_REQUEST['limit']);
	}
	
	$q_get = sprintf('select count(*)
		from gangforums_topics
		where gft_gangid = %d', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	list($total_results) = mysql_fetch_row($q_get);
	
	$num_pages = ceil($total_results / $limit);
	$current_page = floor($offset / $limit) + 1;
	
	$q_get = sprintf('select t.gft_id, t.gft_title, r.max_gfr_posttime, r.num_posts, t.gft_userid, u.username from gangforums_topics as t
		left join users as u on t.gft_userid = u.userid
		left join (select max(gfr_posttime)as max_gfr_posttime, count(*) as num_posts, gfr_topic from gangforums_replies group by gfr_topic) as r on t.gft_id = r.gfr_topic
		where gft_gangid = %d
		order by r.max_gfr_posttime desc limit %d, %d', $gvars->ir['gang'], $offset, $limit);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
			$topics = <<<EOT
			<tr>
				<td class="center bold" colspan="4">
				There aren't any topics yet.
				</td>
			</tr>\n
EOT;
	} else {
		$topics = '';
		while (list($topic_id, $title, $last_post_time, $num_posts, $them_id, $them_name) = mysql_fetch_row($q_get)) {
			$them_p = gang_get_profile_link($them_id, $them_name);
			$last_post_time = gang_time_format($last_post_time);
			$num_posts--;
			$topics .= <<<EOT
			<tr>
				<td>
				<a href="yourgang.php?action=ygang_topic&topic_id=$topic_id">$title</a>
				</td>
				<td>
				$them_p
				</td>
				<td class="right">
				$num_posts
				</td>
				<td class="center">
				$last_post_time
				</td>
			</tr>\n
EOT;
		}
	}
	
	if ($gvars->userid == $gvars->data['gangPRESIDENT'] or $gvars->userid == $gvars->data['gangVICEPRES']) {
		$new_topic = <<<EOT
<p class="center"><a href="yourgang.php?action=ygang_new_topic">Start a new topic.</a></p>
EOT;
	} else {
		$new_topic = '';
	}
	
	$page_options = '';
	for ($x = 1; $x <= $num_pages; $x++) {
		$page_offset = $x * $limit - $limit;
		if ($current_page == $x) {
			$selected = ' selected="selected"';
		} else {
			$selected = '';
		}
		$page_options .= <<<EOT
<option value="$page_offset"$selected>$x</option>
EOT;
	}
	
	echo <<<EOT
	<h2>$gvars->name_su Message Board</h2>
	$new_topic
	<table>
		<tr>
			<td class="center">
				<form method="get" action="yourgang.php">
					<input type="hidden" name="action" value="ygang_forum">
					Page Number <select name="offset">$page_options</select>
					<input type="submit" value="Go">
				</form>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<th>
			Topic
			</th>
			<th>
			Starter
			</th>
			<th>
			Replies
			</th>
			<th>
			Last Post
			</th>
		</tr>
		$topics
	</table>
EOT;
}

function ygang_new_topic() {
	global $gvars;
	
	if ($gvars->userid != $gvars->data['gangPRESIDENT'] and $gvars->userid != $gvars->data['gangVICEPRES']) {
		echo "<h3>Only the $gvars->name_sl can start new topics.</h3>"; return;
	}
	
	$topic = '';
	$post = '';
	if (isset($_SESSION['GFORUM_DATA']) and $_SESSION['GFORUM_DATA']['time'] > $_SERVER['REQUEST_TIME'] - 600) {
		$topic = strip_tags($_SESSION['GFORUM_DATA']['topic']);
		$post = strip_tags($_SESSION['GFORUM_DATA']['post']);
	}
	
	echo <<<EOT
	<h2>$gvars->name_su Message Board: Start a New Topic</h2>
	<form method="post" action="yourgang.php?action=ygang_new_topic2">
		<table style="width: 350px">
			<tr>
				<th>
				Topic
				</th>
			</tr>
			<tr>
				<th>
				<input type="text" style="width: 98%" name="topic" value="$topic" maxlength="255">
				</th>
			</tr>
			<tr>
				<th>
				Post
				</th>
			</tr>
			<tr>
				<th>
				<textarea style="width: 98%; height: 150px" name="post">$post</textarea>
				</th>
			</tr>
			<tr>
				<th>
				<input type="submit" value="Submit">
				</th>
			</tr>
		</table>
	</form>
EOT;
}

function ygang_new_topic2() {
	global $gvars;
	
	if ($gvars->userid != $gvars->data['gangPRESIDENT'] and $gvars->userid != $gvars->data['gangVICEPRES']) {
		echo "<h3>Only the $gvars->name_sl can start new topics.</h3>"; return;
	}
	
	$errors = array();
	$topic = '';
	if (!isset($_REQUEST['topic']) or strlen($_REQUEST['topic']) < 1) {
		$errors[] = 'Please enter a topic.';
	} else {
		$topic = $_REQUEST['topic'];
	}
	$post = '';
	if (!isset($_REQUEST['post']) or strlen($_REQUEST['post']) < 1) {
		$errors[] = 'Please enter a post.';
	} else {
		$post = $_REQUEST['post'];
	}
	
	if (!empty($errors)) {
		$_SESSION['GFORUM_DATA'] = array(
			'topic' => $topic,
			'post' => $post,
			'time' => $_SERVER['REQUEST_TIME'],
		);
		echo "<h3>Your post contained these errors:</h3>";
		foreach ($errors as $error) {
			echo "<p>$error</p>";
		}
		echo '<a href="yourgang.php?action=ygang_new_topic">Click here to go back and try again.</a>';
		return;
	}
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	$q_set = sprintf('insert into gangforums_topics (gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime)
		values (%d, %d, "%s", "", 0, 0, 0, 0, unix_timestamp())', $gvars->userid, $gvars->ir['gang'], $gvars->clean($topic));
	mysql_query($q_set);
	$topic_id = mysql_insert_id();
	
	$q_set = sprintf('insert into gangforums_replies (gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime)
		values (%d, %d, %d, "%s", unix_timestamp())', $gvars->userid, $gvars->ir['gang'], $topic_id, $gvars->clean($post));
	mysql_query($q_set);
	
	if (isset($_SESSION['GFORUM_DATA'])) {
		unset($_SESSION['GFORUM_DATA']);
	}
	
	echo "<h3>Your topic has been posted.</h3>";
	gang_go_back('yourgang.php?action=ygang_forum');
}

function ygang_topic() {
	global $gvars;
	
	if (!isset($_REQUEST['topic_id']) or intval($_REQUEST['topic_id']) < 1) {
		echo "<h3>Which topic are you looking for?</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	$topic_id = intval($_REQUEST['topic_id']);
	
	if (!isset($_REQUEST['offset']) or intval($_REQUEST['offset']) < 1) {
		$offset = 0;
	} else {
		$offset = intval($_REQUEST['offset']);
	}
	
	if (!isset($_REQUEST['limit']) or intval($_REQUEST['limit']) < 25) {
		$limit = 25;
	} else if (intval($_REQUEST['limit']) > 100) {
		$limit = 100;
	} else {
		$limit = intval($_REQUEST['limit']);
	}
	
	$q_get = sprintf('select count(*) from gangforums_replies
		where gfr_gangid = %d and gfr_topic = %d', $gvars->ir['gang'], $topic_id);
	$q_get = mysql_query($q_get);
	list($total_results) = mysql_fetch_row($q_get);
	
	$num_pages = ceil($total_results / $limit);
	$current_page = floor($offset / $limit) + 1;
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	$q_get = sprintf('select gft_title from gangforums_topics where gft_gangid = %d and gft_id = %d', $gvars->ir['gang'], $topic_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This topic does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($topic_title) = mysql_fetch_row($q_get);
	
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	$q_get = sprintf('select r.gfr_id, r.gfr_userid, u.username,
		r.gfr_text, r.gfr_posttime from gangforums_replies as r
		left join users as u on r.gfr_userid = u.userid
		where r.gfr_gangid = %d and r.gfr_topic = %d
		order by r.gfr_posttime limit %d, %d', $gvars->ir['gang'], $topic_id, $offset, $limit);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This topic does not have any posts.</h3>";
		$q_del = sprintf('delete from gangforums_topics where gft_id = %d', $topic_id);
		mysql_query($q_del);
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	
	$posts = '';
	
	$is_admin = ($gvars->userid == $gvars->data['gangPRESIDENT'] or $gvars->userid == $gvars->data['gangVICEPRES']);
	
	while (list($reply_id, $poster_id, $poster_name, $post, $post_time) = mysql_fetch_row($q_get)) {
		$poster_p = gang_get_profile_link($poster_id, $poster_name);
		$post = nl2br($post);
		$post_time = gang_time_format($post_time);
		if ($is_admin or $poster_id == $gvars->userid) {
			$delete_link = <<<EOT
<hr class="gang_forum_hr">
<p class="left">
	<a href="yourgang.php?action=ygang_edit_reply&reply_id=$reply_id">Edit</a><br>
	<a href="yourgang.php?action=ygang_delete_reply&reply_id=$reply_id">Delete</a>
</p>
EOT;
		} else {
			$delete_link = '';
		}
		$posts .= <<<EOT
		<tr>
			<th class="left" valign="top" rowspan="2">
			$poster_p
$delete_link
			</th>
			<th class="right" style="height: 16px">
			$post_time
			</th>
		</tr>
		<tr>
			<td class="gang_forum_post">
			$post
			</td>
		</tr
		<tr>
			<td class="gang_forum_spacer" colspan="2">
			&nbsp;
			</td>
		</tr>\n
EOT;
	}
	
	$page_options = '';
	for ($x = 1; $x <= $num_pages; $x++) {
		$page_offset = $x * $limit - $limit;
		if ($current_page == $x) {
			$selected = ' selected="selected"';
		} else {
			$selected = '';
		}
		$page_options .= <<<EOT
<option value="$page_offset"$selected>$x</option>
EOT;
	}
	
	echo <<<EOT
	<h2>$gvars->name_su Message Board: $topic_title</h2>
	<table>
		<tr>
			<td class="center">
				<form method="get" action="yourgang.php">
					<input type="hidden" name="action" value="ygang_topic">
					<input type="hidden" name="topic_id" value="$topic_id">
					Page Number <select name="offset">$page_options</select>
					<input type="submit" value="Go">
				</form>
			</td>
		</tr>
	</table>
	<div style="width: 500px; margin: 0 auto">
		<p><a class="gang_forum_reply" href="yourgang.php?action=ygang_reply&topic_id=$topic_id">Reply</a></p>
		<table style="width: 500px">
$posts
		</table>
		<p><a class="gang_forum_reply" href="yourgang.php?action=ygang_reply&topic_id=$topic_id">Reply</a></p>
	</div>
EOT;
	
}

function ygang_reply() {
	global $gvars;
	
	if (!isset($_REQUEST['topic_id']) or intval($_REQUEST['topic_id']) < 1) {
		echo "<h3>Which topic are you replying to?</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	$topic_id = intval($_REQUEST['topic_id']);
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	$q_get = sprintf('select gft_title from gangforums_topics where gft_gangid = %d and gft_id = %d', $gvars->ir['gang'], $topic_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This topic does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($topic_title) = mysql_fetch_row($q_get);
	
	echo <<<EOT
	<h2>$gvars->name_su Message Board: Replying to <a href="yourgang.php?action=ygang_topic&topic_id=$topic_id">$topic_title</a></h2>
	<p class="center"><a href="yourgang.php?action=ygang_topic&topic_id=$topic_id">Go Back</a></p>
	<form method="post" action="yourgang.php?action=ygang_reply2&topic_id=$topic_id">
		<table style="width: 350px">
			<tr>
				<th>
				Post
				</th>
			</tr>
			<tr>
				<th>
				<textarea style="width: 98%; height: 150px" name="post"></textarea>
				</th>
			</tr>
			<tr>
				<th>
				<input type="submit" value="Submit">
				</th>
			</tr>
		</table>
	</form>
EOT;
}

function ygang_reply2() {
	global $gvars;
	
	if (!isset($_REQUEST['topic_id']) or intval($_REQUEST['topic_id']) < 1) {
		echo "<h3>Which topic are you replying to?</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	$topic_id = intval($_REQUEST['topic_id']);
	
	if (!isset($_REQUEST['post']) or strlen($_REQUEST['post']) < 1) {
		echo "<h3>Please submit a post.</h3>";
		gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
		return;
	}
	$post = $_REQUEST['post'];
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	$q_get = sprintf('select gft_title from gangforums_topics where gft_gangid = %d and gft_id = %d', $gvars->ir['gang'], $topic_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This topic does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($topic_title) = mysql_fetch_row($q_get);
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	
	$q_set = sprintf('insert into gangforums_replies (gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime)
		values (%d, %d, %d, "%s", unix_timestamp())', $gvars->userid, $gvars->ir['gang'], $topic_id, $gvars->clean($post));
	mysql_query($q_set);
	
	echo "<h3>Your reply has been posted.</h3>";
	gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
}

function ygang_edit_reply() {
	global $gvars;
	
	if (!isset($_REQUEST['reply_id']) or intval($_REQUEST['reply_id']) < 1) {
		echo "<h3>Which reply are you editing?</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	$reply_id = intval($_REQUEST['reply_id']);
	
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	$q_get = sprintf('select gfr_userid, gfr_topic, gfr_text from gangforums_replies
		where gfr_gangid = %d and gfr_id = %d', $gvars->ir['gang'], $reply_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This post does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($poster_id, $topic_id, $post) = mysql_fetch_row($q_get);
	
	
	if ($gvars->userid != $gvars->data['gangPRESIDENT'] and $gvars->userid != $gvars->data['gangVICEPRES'] and $gvars->userid != $poster_id) {
		echo "<h3>You may only edit your own posts.</h3>";
		gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
		return;
	}
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	$q_get = sprintf('select gft_title from gangforums_topics where gft_gangid = %d and gft_id = %d', $gvars->ir['gang'], $topic_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This topic does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($topic_title) = mysql_fetch_row($q_get);
	
	echo <<<EOT
	<h2>$gvars->name_su Message Board: Editing a post from <a href="yourgang.php?action=ygang_topic&topic_id=$topic_id">$topic_title</a></h2>
	<p class="center"><a href="yourgang.php?action=ygang_topic&topic_id=$topic_id">Go Back</a></p>
	<form method="post" action="yourgang.php?action=ygang_edit_reply2&reply_id=$reply_id">
		<table style="width: 350px">
			<tr>
				<th>
				Post
				</th>
			</tr>
			<tr>
				<th>
				<textarea style="width: 98%; height: 150px" name="post">$post</textarea>
				</th>
			</tr>
			<tr>
				<th>
				<input type="submit" value="Submit">
				</th>
			</tr>
		</table>
	</form>
EOT;
}

function ygang_edit_reply2() {
	global $gvars;
	
	if (!isset($_REQUEST['reply_id']) or intval($_REQUEST['reply_id']) < 1) {
		echo "<h3>Which reply are you editing?</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	$reply_id = intval($_REQUEST['reply_id']);
	
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	$q_get = sprintf('select gfr_userid, gfr_topic from gangforums_replies
		where gfr_gangid = %d and gfr_id = %d', $gvars->ir['gang'], $reply_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This post does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($poster_id, $topic_id) = mysql_fetch_row($q_get);
	
	
	if ($gvars->userid != $gvars->data['gangPRESIDENT'] and $gvars->userid != $gvars->data['gangVICEPRES'] and $gvars->userid != $poster_id) {
		echo "<h3>You may only edit your own posts.</h3>";
		gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
		return;
	}
	
	if (!isset($_REQUEST['post']) or strlen($_REQUEST['post']) < 1) {
		echo "<h3>Please submit a post.</h3>";
		gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
		return;
	}
	$post = $_REQUEST['post'];
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	$q_get = sprintf('select gft_title from gangforums_topics where gft_gangid = %d and gft_id = %d', $gvars->ir['gang'], $topic_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This topic does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($topic_title) = mysql_fetch_row($q_get);
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	
	$q_set = sprintf('update gangforums_replies set gfr_text = "%s" where gfr_id = %d', $gvars->clean($post), $reply_id);
	mysql_query($q_set);
	
	echo "<h3>The reply has been edited.</h3>";
	gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
}

function ygang_delete_reply() {
	global $gvars;
	
	if (!isset($_REQUEST['reply_id']) or intval($_REQUEST['reply_id']) < 1) {
		echo "<h3>Which reply are you deleting?</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	$reply_id = intval($_REQUEST['reply_id']);
	
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	$q_get = sprintf('select gfr_userid, gfr_topic, gfr_text from gangforums_replies
		where gfr_gangid = %d and gfr_id = %d', $gvars->ir['gang'], $reply_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This post does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($poster_id, $topic_id, $post) = mysql_fetch_row($q_get);
	
	
	if ($gvars->userid != $gvars->data['gangPRESIDENT'] and $gvars->userid != $gvars->data['gangVICEPRES'] and $gvars->userid != $poster_id) {
		echo "<h3>You may only delete your own posts.</h3>";
		gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
		return;
	}
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	$q_get = sprintf('select gft_title from gangforums_topics where gft_gangid = %d and gft_id = %d', $gvars->ir['gang'], $topic_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This topic does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($topic_title) = mysql_fetch_row($q_get);
	
	echo <<<EOT
	<h2>$gvars->name_su Message Board: Deleting a post from <a href="yourgang.php?action=ygang_topic&topic_id=$topic_id">$topic_title</a></h2>
	<p class="center"><a href="yourgang.php?action=ygang_topic&topic_id=$topic_id">Go Back</a></p>
	<table style="width: 350px" class="ygang_menu">
		<tr>
			<th colspan="2">
			Post
			</th>
		</tr>
		<tr>
			<th colspan="2">
			$post
			</th>
		</tr>
		<tr>
			<th style="width: 50%">
			<a href="yourgang.php?action=ygang_delete_reply2&reply_id=$reply_id">Yes</a>
			</th>
			<th>
			<a href="yourgang.php?action=ygang_topic&topic_id=$topic_id">No</a>
			</th>
		</tr>
	</table>
EOT;
}

function ygang_delete_reply2() {
	global $gvars;
	
	if (!isset($_REQUEST['reply_id']) or intval($_REQUEST['reply_id']) < 1) {
		echo "<h3>Which reply are you deleting?</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	$reply_id = intval($_REQUEST['reply_id']);
	
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	$q_get = sprintf('select gfr_userid, gfr_topic from gangforums_replies
		where gfr_gangid = %d and gfr_id = %d', $gvars->ir['gang'], $reply_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This post does not exist.</h3>";
		gang_go_back('yourgang.php?action=ygang_forum');
		return;
	}
	list($poster_id, $topic_id) = mysql_fetch_row($q_get);
	
	
	if ($gvars->userid != $gvars->data['gangPRESIDENT'] and $gvars->userid != $gvars->data['gangVICEPRES'] and $gvars->userid != $poster_id) {
		echo "<h3>You may only delete your own posts.</h3>";
		gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
		return;
	}
	
	
	// gft_id, gft_userid, gft_gangid, gft_title, gft_text, gft_replies, gft_views, gft_lastpost, gft_lastposterid, gft_starttime <<< gangforums_topics
	// gfr_id, gfr_userid, gfr_gangid, gfr_topic, gfr_text, gfr_posttime <<< gangforums_replies
	
	$q_set = sprintf('delete from gangforums_replies where gfr_id = %d', $reply_id);
	mysql_query($q_set);
	
	echo "<h3>The reply has been deleted.</h3>";
	gang_go_back('yourgang.php?action=ygang_topic&topic_id=' . $topic_id);
}

function ygang_summary() {
	global $gvars;
	
	$leaders = array(
		'pres' => 'N/A',
		'vice' => 'N/A',
	);
	$q_get = sprintf('select userid, username, "pres" as rank from users where userid = %d
		union select userid, username, "vice" as rank from users where userid = %d',
		$gvars->data['gangPRESIDENT'], $gvars->data['gangVICEPRES']);
	$q_get = mysql_query($q_get);
	if ($q_get and mysql_num_rows($q_get) > 0) {
		while(list($them_id, $them_name, $rank) = mysql_fetch_row($q_get)) {
			$leaders[$rank] = gang_get_profile_link($them_id, $them_name);
		}
	}
	
	$q_count = sprintf('select count(*) from users where gang = %d', $gvars->ir['gang']);
	list($num_members) = mysql_fetch_row(mysql_query($q_count));
	
	printf('
	<h2>Summary</h2>
	<table style="width: 300px">
		<tr>
			<th colspan="2">
			General
			</th>
		</tr>
		<tr>
			<td>
			President
			</td>
			<td>
			%s
			</td>
		</tr>
		<tr>
			<td>
			Vice-President
			</td>
			<td>
			%s
			</td>
		</tr>
		<tr>
			<td>
			Members
			</td>
			<td>
			%d
			</td>
		</tr>
		<tr>
			<td>
			Capacity
			</td>
			<td>
			%d
			</td>
		</tr>
		<tr>
			<td>
			Respect Level
			</td>
			<td>
			%d
			</td>
		</tr>
		<tr>
			<th colspan="2">
			Financial
			</th>
		</tr>
		<tr>
			<td>
			%s in vault
			</td>
			<td>
			%d
			</td>
		</tr>
		<tr>
			<td>
			%s in vault
			</td>
			<td>
			%d
			</td>
		</tr>
	</table>
	', $leaders['pres'], $leaders['vice'], $num_members, $gvars->data['gangCAPACITY'], $gvars->data['gangRESPECT'],
	$gvars->money_name, $gvars->data['gangMONEY'], $gvars->crystals_name, $gvars->data['gangCRYSTALS']);
}

function ygang_donate() {
	global $gvars;
	
	printf('
	<br><h2>Donate</h2>
	<p class="bold center">Enter the amounts you wish to donate.</p>
	<p class="center">Your gang has %s %s and %s %s.</p>
	<form method="post" action="yourgang.php?action=ygang_donate2">
		<table style="width: 300px">
			<tr>
				<th>
				%s
				</th>
				<th>
				<input type="text" name="money" value="">
				</th>
			</tr>
			<tr>
				<th>
				%s
				</th>
				<th>
				<input type="text" name="crystals" value="">
				</th>
			</tr>
			<tr>
				<th colspan="2">
				<input type="submit" value="Donate">
				</th>
			</tr>
		</table>
	</form>
	', gang_money_format($gvars->data['gangMONEY']), strtolower($gvars->money_name),
	number_format($gvars->data['gangCRYSTALS']), strtolower($gvars->crystals_name),
	$gvars->money_name, $gvars->crystals_name);
}

function ygang_donate2() {
	global $gvars;
	
	if (!isset($_REQUEST['money']) or floatval($_REQUEST['money']) < 1) {
		$money = 0;
	} else {
		$money = floatval($_REQUEST['money']);
	}
	
	if (!isset($_REQUEST['crystals']) or floatval($_REQUEST['crystals']) < 1) {
		$crystals = 0;
	} else {
		$crystals = floatval($_REQUEST['crystals']);
	}
	
	if ($money < 1 and $crystals < 1) {
		echo "<h3>You haven't donated anything. Please try again.</h3>";
		gang_go_back('yourgang.php?action=ygang_donate');
		return;
	}
	$money_l = strtolower($gvars->money_name);
	$crystals_l = strtolower($gvars->crystals_name);
	
	if ($money > 0) {
		if (!gang_take_money($gvars->userid, $money)) {
			echo "<h3>You don't have enough $money_l to cover your donation.</h3>";
			gang_go_back('yourgang.php?action=ygang_donate');
			return;
		}
	}
	
	if ($crystals > 0) {
		if (!gang_take_money($gvars->userid, $crystals, 'crystals')) {
			if ($money > 0) {
				gang_give_money($gvars->userid, $money);
			}
			echo "<h3>You don't have enough $crystals_l to cover your donation.</h3>";
			gang_go_back('yourgang.php?action=ygang_donate');
			return;
		}
	}
	if ($money > 0) {
		$result = gang_give_gang_money($gvars->ir['gang'], $money);
		if (!$result) {
			echo 'error';
		}
	}
	if ($crystals > 0) {
		gang_give_gang_money($gvars->ir['gang'], $crystals, 'gangCRYSTALS');
	}
	
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The donation failed.</h3>";
	} else {
		echo "<h3>Your donation has been received.</h3>";
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		
		if ($money > 1 and $crystals > 1) {
			$ev_msg = '%4$s donated %1$s and %2$s %3$s.';
		} else if ($money > 1) {
			$ev_msg = '%4$s donated %1$s.';
		} else {
			$ev_msg = '%4$s donated %2$s %3$s.';
		}
		gang_new_event($gvars->ir['gang'], sprintf($ev_msg, gang_money_format($money), number_format($crystals), $gvars->crystals_name, $us_p), 'escape');
		gang_go_back('yourgang.php?action=ygang_donate');
	}
	
}

function ygang_members() {
	global $gvars;
	/*
	User	Level	Days In Gang	 
	floydian	1 	0	Kick 	
	*/
	
	// gangID, gangNAME, gangDESC, gangPREF, gangSUFF, gangMONEY, gangCRYSTALS, gangRESPECT, gangPRESIDENT, gangVICEPRES, gangCAPACITY, gangCRIME, gangCHOURS, gangAMENT
	if ($gvars->userid == $gvars->data['gangPRESIDENT'] or $gvars->userid == $gvars->data['gangVICEPRES']) {
		$kick = '<a href="yourgang.php?action=ygang_kick&them_id=%1$d">Kick</a>';
	} else {
		$kick = '';
	}
	
	
	$q_get = sprintf('select u.userid, u.username, u.level, u.daysingang from users as u
		where u.gang = %d
		order by u.username', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	$member_list = '';
	
	
	while (list($them_id, $them_name, $them_level, $daysingang) = mysql_fetch_row($q_get)) {
		$them_p = gang_get_profile_link($them_id, $them_name);
		$kick2 = sprintf($kick, $them_id);
		
		if ($them_id == $gvars->data['gangPRESIDENT']) {
			$rank = $gvars->pres;
		} else if ($them_id == $gvars->data['gangVICEPRES']) {
			$rank = $gvars->vice_pres;
		} else {
			$rank = 'Member';
		}
		
		$member_list .= <<<EOT
		<tr class="right">
			<td class="left">
			$them_p
			</td>
			<td>
			$them_level
			</td>
			<td>
			$daysingang
			</td>
			<td class="center">
			$rank
			</td>
			<td class="ygang_menu">
			$kick2
			</td>
		</tr>\n
EOT;
	}
	
	echo <<<EOT
	<h2>Member List</h2>
	<table style="width: 400px">
		<tr>
			<th>
			Member
			</th>
			<th>
			Level
			</th>
			<th>
			Days In Gang
			</th>
			<th>
			Rank
			</th>
			<th>
			Link
			</th>
		</tr>
$member_list
	</table>
EOT;
}

function ygang_kick() {
	global $gvars;
	
	if (!isset($_REQUEST['them_id']) or intval($_REQUEST['them_id']) < 1) {
		echo "<h3>Who are you kicking from the $gvars->name_sl?</h3>";
	}
	$them_id = intval($_REQUEST['them_id']);
	
	if ($them_id == $gvars->data['gangPRESIDENT']) {
		echo "<h3>The $gvars->pres cannot be kicked from the $gvars->name_sl.</h3>";
		return;
	} else if ($them_id == $gvars->data['gangVICEPRES']) {
		echo "<h3>The $gvars->vice_pres must be demoted before being kicked from the gang.</h3>";
		return;
	}
	$q_get = sprintf('select username, gang from users where userid = %d', $them_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The member you selected does not exist.</h3>";
		return;
	}
	list($them_name, $them_gang_id) = mysql_fetch_row($q_get);
	
	$them_p = gang_get_profile_link($them_id, $them_name);
	
	if ($them_gang_id != $gvars->ir['gang']) {
		echo "<h3>$them_p is not in your gang.</h3>";
		return;
	}
	
	echo <<<EOT
	<table class="ygang_menu">
		<tr>
			<td colspan="2">
			Are you sure you want to kick $them_p from the $gvars->name_sl?
			</td>
		</tr>
		<tr>
			<th style="width: 50%">
			<a href="yourgang.php?action=ygang_kick2&them_id=$them_id">Yes</a>
			</th>
			<th>
			<a href="yourgang.php">No</a>
			</th>
		</tr>
	</table>
EOT;
}

function ygang_kick2() {
	global $gvars;
	
	// gangID, gangNAME, gangDESC, gangPREF, gangSUFF, gangMONEY, gangCRYSTALS, gangRESPECT, gangPRESIDENT, gangVICEPRES, gangCAPACITY, gangCRIME, gangCHOURS, gangAMENT
	if ($gvars->userid != $gvars->data['gangPRESIDENT'] and $gvars->userid != $gvars->data['gangVICEPRES']) {
		echo "<h3>Only the $gvars->name_sl leadership can kick members from the $gvars->name_sl.</h3>";
		return;
	}
	
	if (!isset($_REQUEST['them_id']) or intval($_REQUEST['them_id']) < 1) {
		echo "<h3>Who are you kicking from the $gvars->name_sl?</h3>";
	}
	$them_id = intval($_REQUEST['them_id']);
	
	if ($them_id == $gvars->data['gangPRESIDENT']) {
		echo "<h3>The $gvars->pres cannot be kicked from the $gvars->name_sl.</h3>";
		return;
	} else if ($them_id == $gvars->data['gangVICEPRES']) {
		echo "<h3>The $gvars->vice_pres must be demoted before being kicked from the gang.</h3>";
		return;
	}
	
	$q_set = sprintf('update users set gang = 0 where userid = %d and gang = %d', $them_id, $gvars->ir['gang']);
	mysql_query($q_set);
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The member could not be kicked.</h3>";
	} else {
		$q_get = sprintf('select username from users where userid = %d', $them_id);
		list($them_name) = mysql_fetch_row(mysql_query($q_get));
		$them_p = gang_get_profile_link($them_id, $them_name);
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		
		event_add($them_id, "$us_p kicked you from the $gvars->name_sl.", $gvars->c);
		
		echo "<h3>$them_p has been kicked from the $gvars->name_sl.</h3>";
		gang_new_event($gvars->ir['gang'], "$them_p has been kicked from the $gvars->name_sl by $us_p.", 'escape');
	}
	
	echo <<<EOT
<p class="center"><a href="yourgang.php?action=ygang_members">Click here to go to the member list.</a></p>
EOT;
	
}

function ygang_leave() {
	global $gvars;
	
	echo <<<EOT
	<table class="ygang_menu">
		<tr>
			<td colspan="2">
			Are you sure you want to leave the $gvars->name_sl
			</td>
		</tr>
		<tr>
			<th>
			<a href="yourgang.php?action=ygang_leave2">Yes</a>
			</th>
			<th>
			<a href="yourgang.php">No</a>
			</th>
		</tr>
	</table>
EOT;
}

function ygang_leave2() {
	global $gvars;
	
	if ($gvars->userid == $gvars->data['gangPRESIDENT']) {
		echo "<h3>You cannot leave the $gvars->name_sl while you are still the $gvars->name_sl $gvars->pres.</h3>";
		return;
	}
	
	if ($gvars->userid == $gvars->data['gangVICEPRES']) {
		$q_set = sprintf('update gangs set gangVICEPRES = 0 where gangID = %d', $gvars->ir['gang']);
		mysql_query($q_set);
	}
	
	$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
	gang_new_event($gvars->ir['gang'], "$us_p has left the $gvars->name_sl.", 'escape');
	
	$q_set = sprintf('update users set gang = 0 where userid = %d', $gvars->userid);
	mysql_query($q_set);
	
	echo "<h3>You have left the $gvars->name_sl.</h3>";
}

function ygang_attack_logs() {
	global $gvars;
	// log_id, attacker, attacked, result, time, stole, attacklog <<< attacklogs
	//Attack Logs - The last 50 attacks involving someone in your gang
	
	$q_get = sprintf('select l.attacker, a.username, l.attacked, b.username, l.result, l.time, l.stole
		from attacklogs as l
		left join users as a on l.attacker = a.userid
		left join users as b on l.attacked = b.userid
		where %d in (a.gang, b.gang)
		order by l.time desc
		limit 50
	', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		$logs = <<<EOT
			<tr>
				<td class="center bold" colspan="5">
				There have been no attacks on members of your $gvars->name_sl.
				</td>
			</tr>\n
EOT;
	} else {
		$logs = '';
		while (list($a_id, $a_name, $b_id, $b_name, $result, $time, $stole) = mysql_fetch_row($q_get)) {
			$ap = gang_get_gang_link($a_id, $a_name);
			$bp = gang_get_gang_link($b_id, $b_name);
			
			if ($result === 'won') {
				$result = $a_name;
			} else if ($result === 'lost') {
				$result = $b_name;
			} else {
				$result = 'draw';
			}
			
			$time = gang_time_format($time);
			$stole = '$' . number_format($stole);
			
			$logs .= <<<EOT
			<tr>
				<td>
				$ap
				</td>
				<td>
				$bp
				</td>
				<td>
				$result
				</td>
				<td>
				$stole
				</td>
				<td>
				$time
				</td>
			</tr>\n
EOT;
		}
	}
	
	echo <<<EOT
	<h2>Attack Logs</h2>
	<p class="center bold">The last 50 attacks involving someone in your $gvars->name_sl.</p>
	<table style="width: 500">
		<tr>
			<th>
			Attacker
			</th>
			<th>
			Defender
			</th>
			<th>
			Winner
			</th>
			<th>
			Loot
			</th>
			<th>
			Time
			</th>
		</tr>
$logs
	</table>
EOT;
}
