<?php


if (!defined('GANG_MODULE')) {
	return; 
}

//$gvars->tabs += array(
//	'gang_foo' => 'Foo',
//);
$gvars->actions += array(
	'sgang_home' => 'sgang_home',
	'sgang_vault' => 'sgang_vault',
	'sgang_vault_give' => 'sgang_vault_give',
	'sgang_apps' => 'sgang_apps',
	'sgang_app_decline' => 'sgang_app_decline',
	'sgang_app_accept' => 'sgang_app_accept',
	'sgang_leadership' => 'sgang_leadership',
	'sgang_alter_staff' => 'sgang_alter_staff',
	'sgang_upgrade' => 'sgang_upgrade',
	'sgang_upgrade2' => 'sgang_upgrade2',
	'sgang_payment' => 'sgang_payment',
	'sgang_payment2' => 'sgang_payment2',
	'sgang_war' => 'sgang_war',
	'sgang_war_surrender' => 'sgang_war_surrender',
	'sgang_war_surrender2' => 'sgang_war_surrender2',
	'sgang_war_decline' => 'sgang_war_decline',
	'sgang_war_accept' => 'sgang_war_accept',
	'sgang_war_declare' => 'sgang_war_declare',
	'sgang_mail' => 'sgang_mail',
	'sgang_mail2' => 'sgang_mail2',
	'sgang_settings' => 'sgang_settings',
	'sgang_settings2' => 'sgang_settings2',
);


$gvars->links_staff += array(
	'sgang_vault' => array(
		'label' => 'Vault Management',
		'order' => 1
	), 'sgang_leadership' => array(
		'label' => 'Manage Leadership',
		'order' => 2
	), 'sgang_upgrade' => array(
		'label' => 'Upgrade Gang',
		'order' => 3
	), 'sgang_payment' => array(
		'label' => 'Mass Payment',
		'order' => 4
	), 'sgang_war' => array(
		'label' => 'War Management',
		'order' => 5
	), 'sgang_mail' => array(
		'label' => 'Mass Mail Gang',
		'order' => 6
	), 'sgang_settings' => array(
		'label' => 'Change Gang Settings',
		'order' => 7
	), 'sgang_apps' => array(
		'label' => 'Application Management',
		'order' => 8
	),
);


function sgang_home() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access the staff panel.</h3>";
		gang_go_back('yourgang.php'); return;
	}
	
	$gang_links = array();
	foreach ($gvars->links_staff as $key => $value) {
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
	
	echo <<<EOT

	<table class="ygang_menu" style="width: 300px">
$gang_links2
	</table>
EOT;
	
}

function sgang_settings() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	if (strlen($gvars->gang_name_allowable_special_characters) > 0) {
		$sp_chars = '<br>It may also contain these special characters: ' . $gvars->gang_name_allowable_special_characters;
	} else {
		$sp_chars = '';
	}
	
	printf('
<p class="center">
The %s name must start with a letter, can contain letters, numbers. %s
</p>
	<table>
		<tr valign="top">
			<td>
			Name
			</td>
			<td>
			<form method="post" action="yourgang.php?action=sgang_settings2">
				<input type="submit" value="Change">
				<input type="text" name="name" value="%s">
			</form>
			</td>
		</tr>
		<tr valign="top">
			<td>
			Tag
			</td>
			<td>
			<form method="post" action="yourgang.php?action=sgang_settings2">
				<input type="submit" value="Change">
				<input type="text" name="tag" value="%s">
			</form>
			</td>
		</tr>
		<tr valign="top">
			<td>
			Desc
			</td>
			<td>
			<form method="post" action="yourgang.php?action=sgang_settings2">
				<input type="submit" value="Change" style="float: left; margin-right: 3px">
				<textarea name="desc" style="width: 200px; height: 80px">%s</textarea>
			</form>
			</td>
		</tr>
		<tr valign="top">
			<td>
			Announcement
			</td>
			<td>
			<form method="post" action="yourgang.php?action=sgang_settings2">
				<input type="submit" value="Change" style="float: left; margin-right: 3px">
				<textarea name="ann" style="width: 200px; height: 80px">%s</textarea>
			</form>
			</td>
		</tr>
	</table>
	', $gvars->name_sl, $sp_chars, $gvars->data['gangNAME'], $gvars->data['gangPREF'], $gvars->data['gangDESC'], $gvars->data['gangAMENT']);
}

function sgang_settings2() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
//	$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
	$us_p = $gvars->ir['username'];
	
	if (isset($_REQUEST['name'])) {
		$data = $_REQUEST['name'];
		$field = 'gangNAME';
		if (strlen($data) < 1 or !$gvars->check_gang_name_allowable_special_characters($data) or !ctype_alpha(substr($data, 0, 1))) {
			$data = $gvars->ir['username'] . "'s " . $gvars->name_su;
		}
		$msg = sprintf('%s changed the %s name to %s', $us_p, $gvars->name_sl, $data);
		$data = $gvars->escape($data);
		$q_check = sprintf('select count(*) from gangs where gangNAME = "%s"', $data);
		list($num_names) = mysql_fetch_row(mysql_query($q_check));
		if ($num_names) {
			echo "<h3>Another $gvars->name_sl has that name already.</h3>";
			gang_go_back('yourgang.php?action=sgang_settings'); return;
		}
		
	} else if (isset($_REQUEST['tag'])) {
		$data = $_REQUEST['tag'];
		$field = 'gangPREF';
		if (strlen($data) < 1 or !$gvars->check_gang_name_allowable_special_characters($data)) {
			$data = '';
		}
		$msg = sprintf('%s changed the %s tag to %s', $us_p, $gvars->name_sl, $data);
		$data = $gvars->escape($data);
	} else if (isset($_REQUEST['desc'])) {
		$data = $_REQUEST['desc'];
		$field = 'gangDESC';
		$msg = sprintf('%s changed the %s description', $us_p, $gvars->name_sl);
		$data = $gvars->clean($data);
	} else if (isset($_REQUEST['ann'])) {
		$data = $_REQUEST['ann'];
		$field = 'gangAMENT';
		$msg = sprintf('%s changed the %s announcement', $us_p, $gvars->name_sl);
		$data = $gvars->clean($data);
	} else {
		echo "<h3>Please submit a valid request.</h3>";
		gang_go_back('yourgang.php?action=sgang_settings'); return;
	}
	
	$q_set = sprintf('update gangs set `%s` = "%s" where gangID = %d', $field, $data, $gvars->ir['gang']);
	mysql_query($q_set);
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The $gvars->name_sl could not be edited.</h3>";
	} else {
		echo "<h3>The $gvars->name_sl was edited.</h3>";
		gang_new_event($gvars->ir['gang'], $msg);
	}
	gang_go_back('yourgang.php?action=sgang_settings');
	
}

function sgang_mail() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	echo <<<EOT
	<h2>Mass Mailer</h2>
	<form method="post" action="yourgang.php?action=sgang_mail2">
		<table>
			<tr>
				<th>
				Text
				</th>
			</tr>
			<tr>
				<th>
				<textarea name="msg" style="width: 200px; height: 100px;"></textarea>
				</th>
			</tr>
			<tr>
				<th>
				<input type="submit" value="Send">
				</th>
			</tr>
		</table>
	</form>
EOT;
}

function sgang_mail2() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['msg']) or strlen($_REQUEST['msg']) < 1) {
		echo "<h3>Please submit a message.</h3>";
		gang_go_back('yourgang.php?action=sgang_mail'); return;
	}
	$msg = $_REQUEST['msg'];
	
	$q_get = sprintf('select userid from users
		where gang = %d', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	while (list($them_id) = mysql_fetch_row($q_get)) {
		$q_set = sprintf('insert into mail (mail_read, mail_from, mail_to, mail_time, mail_subject, mail_text)
			values (0, %d, %d, unix_timestamp(), "A mass mail from your %s", "%s")',
			$gvars->userid, $them_id, $gvars->name_sl, $gvars->clean_br($msg));
		mysql_query($q_set);
		$q_set = sprintf('update users set new_mail = new_mail + 1 where userid = %d', $them_id);
		mysql_query($q_set);
	}
	$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
	
	gang_new_event($gvars->ir['gang'], sprintf('%s sent a mass mailer', $us_p), 'escape');
	
	echo "<h3>The mass mailer was sent.</h3>";
	gang_go_back('yourgang.php?action=sgang_home'); return;
}

function sgang_war() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	$gang_list = array();
	$q_get = sprintf('select gangID, gangNAME from gangs where gangID != %d order by gangNAME', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if ($q_get and mysql_num_rows($q_get) > 0) {
		while (list($gang_id, $gang_name) = mysql_fetch_row($q_get)) {
			$gang_list[$gang_id] = $gang_name;
		}
	}
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	// surID, surWAR, surWHO, surTO, surMSG <<< surrenders
	$war_list = '';
	$war_ids = array();
	$q_get = sprintf('select w.warID as war_id, ga.gangID as us_id, ga.gangNAME as us_name,
		gb.gangID as them_id, gb.gangNAME as them_name, a.surID as us_sur_id, a.surMSG as us_sur_msg,
		b.surID as them_sur_id, b.surMSG as them_sur_msg
		from gangwars as w
		left join surrenders as a on w.warID = a.surWAR and w.warDECLARER = a.surWHO
		left join surrenders as b on w.warID = b.surWAR and w.warDECLARED = b.surWHO
		left join gangs as ga on w.warDECLARER = ga.gangID
		left join gangs as gb on w.warDECLARED = gb.gangID
		where %d in (warDECLARER, warDECLARED)', $gvars->ir['gang']);
	$q_get = mysql_query($q_get); 
	if ($q_get and mysql_num_rows($q_get) > 0) {
		while ($row = mysql_fetch_assoc($q_get)) {
			if (is_null($row['us_id']) or is_null($row['them_id'])) {
				$q_del = sprintf('delete from gangwars where warID = %d', $row['war_id']);
				mysql_query($q_del);
				continue;
			}
			if ($gvars->ir['gang'] == $row['us_id']) {
				$war_ids[$row['them_id']] = $row['them_id'];
			} else {
				$war_ids[$row['us_id']] = $row['us_id'];
			}
			$us_p = gang_get_gang_link($row['us_id'], $row['us_name']);
			$them_p = gang_get_gang_link($row['them_id'], $row['them_name']);
			
			$surrender = "No";
			$surrender_msg = "N/A";
			$surrender_accept = "<td colspan=\"2\">N/A</td>";
			$surrender_accept = sprintf('
					<td colspan="2" class="ygang_menu">
					<a href="yourgang.php?action=sgang_war_surrender&war_id=%d">Offer Surrender</a>
					</td>', $row['war_id']);
			if ($row['us_sur_id']) {
				$surrender = $us_p;
				$surrender_msg = $row['us_sur_msg'];
				if ($gvars->ir['gang'] != $row['us_id']) {
					$surrender_accept = sprintf('
					<td class="ygang_menu">
					<a href="yourgang.php?action=sgang_war_accept&sur_id=%d">Accept</a>
					</td>
					<td class="ygang_menu">
					<a href="yourgang.php?action=sgang_war_decline&sur_id=%d">Decline</a>
					</td>
					', $row['us_sur_id'], $row['us_sur_id']);
				} else {
					$surrender_accept = '
					<td colspan="2">
					N/A
					</td>';
				}
			}
			if ($row['them_sur_id']) {
				$surrender = $them_p;
				$surrender_msg = $row['them_sur_msg'];
				if ($gvars->ir['gang'] != $row['them_id']) {
					$surrender_accept = sprintf('
					<td class="ygang_menu">
					<a href="yourgang.php?action=sgang_war_accept&sur_id=%d">Accept</a>
					</td>
					<td class="ygang_menu">
					<a href="yourgang.php?action=sgang_war_decline&sur_id=%d">Decline</a>
					</td>
					', $row['them_sur_id'], $row['them_sur_id']);
				} else {
					$surrender_accept = '
					<td colspan="2">
					N/A
					</td>';
				}
			}
			
			$war_list .= sprintf('
			<tr>
				<td>
				%s
				</td>
				<td>
				%s
				</td>
				<td>
				%s
				</td>
				<td>
				%s
				</td>
				%s
			</tr>%s
			', $us_p, $them_p, $surrender, $surrender_msg, $surrender_accept, "\n");
		}
	}
	
	$potential_wars = array_diff_key($gang_list, $war_ids);
	$potential_war_list = '';
	foreach ($potential_wars as $key => $value) {
		$potential_war_list .= <<<EOT
<option value="$key">$value</option>\n
EOT;
	}
	
	echo <<<EOT
	<h2>War Management</h2>
	<table>
		<tr>
			<th>
			Declarer
			</th>
			<th>
			Declared
			</th>
			<th>
			Surrendered?
			</th>
			<th>
			Surrender Msg
			</th>
			<th colspan="2">
			Surrender Links
			</th>
		</tr>
$war_list
	</table>
	
<br>
<br>

	<p class="bold center">Declare War</p>
	<form method="post" action="yourgang.php?action=sgang_war_declare">
		<table style="width: 220px">
			<tr>
				<th>
				Declare war on:
				<select name="gang_id">
<option value="0">Select one...</option
$potential_war_list
				</select>
				</th>
			</tr>
			<tr>
				<th>
				<input type="submit" value="Declare">
				</th>
			</tr>
		</table>
	</form>
EOT;
	
	
}

function sgang_war_declare() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['gang_id']) or intval($_REQUEST['gang_id']) < 1) {
		echo "<h3>Which $gvars->name_sl are you declaring war on?</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	$them_id = intval($_REQUEST['gang_id']);
	
	$q_get = sprintf('select gangNAME from gangs where gangID = %d', $them_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you are declaring war on does not exist.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($other_name) = mysql_fetch_row($q_get);
	$other_p = gang_get_gang_link($them_id, $other_name);
	
	$q_get = sprintf('select count(*) from gangwars
		where %d in (warDECLARER, warDECLARED) and %d in (warDECLARER, warDECLARED)', $gvars->ir['gang'], $them_id);
	$q_get = mysql_query($q_get);
	list($has_war) = mysql_fetch_row($q_get);
	
	if ($has_war) {
		echo "<h3>You are already in a war with $other_name.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	$q_set = sprintf('insert into gangwars (warDECLARER, warDECLARED, warTIME)
		values (%d, %d, unix_timestamp())', $gvars->ir['gang'], $them_id);
	mysql_query($q_set);
	
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The war could not be declared.</h3>";
	} else {
		echo "<h3>The war has been declared.</h3>";
		
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		$us_gang__p = gang_get_profile_link($gvars->ir['gang'], $gvars->data['gangNAME']);
		
		gang_new_event($gvars->ir['gang'], sprintf('%s declared war on %s.', $us_p, $other_p), 'escape');
		gang_new_event($them_id, sprintf('%s declared war.', $us_gang__p), 'escape');
	}
	gang_go_back('yourgang.php?action=sgang_war');
}

function sgang_war_decline() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['sur_id']) or intval($_REQUEST['sur_id']) < 1) {
		echo "<h3>Which surrender are you declining?</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	$sur_id = intval($_REQUEST['sur_id']);
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	// surID, surWAR, surWHO, surTO, surMSG <<< surrenders
	$q_get = sprintf('select surWAR, surWHO from surrenders
		where surID = %d and surTO = %d', $sur_id, $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The surrender you selected could not be found.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($war_id, $who_id) = mysql_fetch_row($q_get);
	
	$q_get = sprintf('select gangNAME from gangs where gangID = %d', $who_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you are warring does not exist. The war will be canceled.</h3>";
		mysql_query(sprintf('delete from gangwars where %d in (warDECLARER, warDECLARED)', $who_id));
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($other_name) = mysql_fetch_row($q_get);
	$other_p = gang_get_gang_link($who_id, $other_name);
	
	$q_set = sprintf('delete from surrenders where surID = %d', $sur_id);
	mysql_query($q_set);
	
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The surrender could not be declined.</h3>";
	} else {
		echo "<h3>The surrender was declined.</h3>";
		
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		$us_gang__p = gang_get_profile_link($gvars->ir['gang'], $gvars->data['gangNAME']);
		
		gang_new_event($gvars->ir['gang'], sprintf('%s declined the surrender from %s.', $us_p, $other_p), 'escape');
		gang_new_event($who_id, sprintf('%s declined the surrender.', $us_gang__p), 'escape');
	}
	gang_go_back('yourgang.php?action=sgang_war');
	
}

function sgang_war_accept() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['sur_id']) or intval($_REQUEST['sur_id']) < 1) {
		echo "<h3>Which surrender are you accepting?</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	$sur_id = intval($_REQUEST['sur_id']);
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	// surID, surWAR, surWHO, surTO, surMSG <<< surrenders
	$q_get = sprintf('select surWAR, surWHO from surrenders
		where surID = %d and surTO = %d', $sur_id, $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The surrender you selected could not be found.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($war_id, $who_id) = mysql_fetch_row($q_get);
	
	$q_get = sprintf('select gangNAME from gangs where gangID = %d', $who_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you are warring does not exist. The war will be canceled.</h3>";
		mysql_query(sprintf('delete from gangwars where %d in (warDECLARER, warDECLARED)', $who_id));
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($other_name) = mysql_fetch_row($q_get);
	$other_p = gang_get_gang_link($who_id, $other_name);
	
	$q_set = sprintf('delete from surrenders where surID = %d', $sur_id);
	mysql_query($q_set);
	
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The surrender could not be accepted.</h3>";
	} else {
	
		$q_set = sprintf('delete from gangwars where warID = %d', $war_id);
		mysql_query($q_set);
		echo "<h3>The surrender was accepted.</h3>";
		
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		$us_gang__p = gang_get_profile_link($gvars->ir['gang'], $gvars->data['gangNAME']);
		
		gang_new_event($gvars->ir['gang'], sprintf('%s accepted the surrender from %s.', $us_p, $other_p), 'escape');
		gang_new_event($who_id, sprintf('%s accepted the surrender.', $us_gang__p), 'escape');
	}
	gang_go_back('yourgang.php?action=sgang_war');
	
}

function sgang_war_surrender() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['war_id']) or intval($_REQUEST['war_id']) < 1) {
		echo "<h3>Which war are you surrendering?</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	$war_id = intval($_REQUEST['war_id']);
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	// surID, surWAR, surWHO, surTO, surMSG <<< surrenders
	$q_get = sprintf('select warDECLARER, warDECLARED from gangwars
		where warID = %d and %d in (warDECLARER, warDECLARED)', $war_id, $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The war you selected could not be found.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($us_id, $them_id) = mysql_fetch_row($q_get);
	
	if ($gvars->ir['gang'] == $them_id) {
		$other_id = $us_id;
	} else {
		$other_id = $them_id;
	}
	
	$q_get = sprintf('select gangNAME from gangs where gangID = %d', $other_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you are warring does not exist. The war will be canceled.</h3>";
		mysql_query(sprintf('delete from gangwars where %d in (warDECLARER, warDECLARED)', $other_id));
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($other_name) = mysql_fetch_row($q_get);
	$other_p = gang_get_gang_link($other_id, $other_name);
	
	$q_get = sprintf('select count(*) from surrenders
		where surWAR = %d and %d in (surWHO, surTO)', $war_id, $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	list($has_surrendered) = mysql_fetch_row($q_get);
	
	if ($has_surrendered) {
		echo "<h3>A surrender has already been offered in this war.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	
	echo <<<EOT
	<h2>Offer $other_p a Surrender</h2>
	<form method="post" action="yourgang.php?action=sgang_war_surrender2&war_id=$war_id">
		<table>
			<tr>
				<th>
				Enter a Message
				</th>
			</tr>
			<tr>
				<th>
				<textarea name="msg" style="width: 200px; height: 60px"></textarea>
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
	
//	$q_set = sprintf('insert into surrenders (surWAR, surWHO, surTO, surMSG)
//		values ()');
	
}

function sgang_war_surrender2() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['war_id']) or intval($_REQUEST['war_id']) < 1) {
		echo "<h3>Which war are you surrendering?</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	$war_id = intval($_REQUEST['war_id']);
	
	if (!isset($_REQUEST['msg']) or strlen($_REQUEST['msg']) < 1) {
		echo "<h3>Please submit a message with your surrender.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	$msg = $_REQUEST['msg'];
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	// surID, surWAR, surWHO, surTO, surMSG <<< surrenders
	$q_get = sprintf('select warDECLARER, warDECLARED from gangwars
		where warID = %d and %d in (warDECLARER, warDECLARED)', $war_id, $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The war you selected could not be found.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($us_id, $them_id) = mysql_fetch_row($q_get);
	
	if ($gvars->ir['gang'] == $them_id) {
		$other_id = $us_id;
	} else {
		$other_id = $them_id;
	}
	
	$q_get = sprintf('select gangNAME from gangs where gangID = %d', $other_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you are warring does not exist. The war will be canceled.</h3>";
		mysql_query(sprintf('delete from gangwars where %d in (warDECLARER, warDECLARED)', $other_id));
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	list($other_name) = mysql_fetch_row($q_get);
	$other_p = gang_get_gang_link($other_id, $other_name);
	
	$q_get = sprintf('select count(*) from surrenders
		where surWAR = %d and %d in (surWHO, surTO)', $war_id, $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	list($has_surrendered) = mysql_fetch_row($q_get);
	
	if ($has_surrendered) {
		echo "<h3>A surrender has already been offered in this war.</h3>";
		gang_go_back('yourgang.php?action=sgang_war'); return;
	}
	
	$q_set = sprintf('insert into surrenders (surWAR, surWHO, surTO, surMSG)
		values (%d, %d, %d, "%s")', $war_id, $gvars->ir['gang'], $other_id, $gvars->clean($msg));
	mysql_query($q_set);
	
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The surrender could not be submitted.</h3>";
	} else {
		echo "<h3>The surrender was submitted.</h3>";
		
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		$us_gang__p = gang_get_profile_link($gvars->ir['gang'], $gvars->data['gangNAME']);
		
		gang_new_event($gvars->ir['gang'], sprintf('%s asked for a surrender from %s.', $us_p, $other_p), 'escape');
		gang_new_event($other_id, sprintf('%s asked for a surrender.', $us_gang__p), 'escape');
	}
	gang_go_back('yourgang.php?action=sgang_war');
	
}

function sgang_payment() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	printf('
	<h2>Mass Payment</h2>
	<p class="center">The vault has %s and %s %s.</p>
	<form method="post" action="yourgang.php?action=sgang_payment2">
		<table>
			<tr>
				<th>
				%s
				</th>
				<th>
				%s
				</th>
			</tr>
			<tr>
				<th>
				<input type="text" name="money">
				</th>
				<th>
				<input type="text" name="crystals">
				</th>
			</tr>
			<tr>
				<th colspan="2">
				<input type="submit" value="Send">
				</th>
			</tr>
		</table>
	</form>
	', gang_money_format($gvars->data['gangMONEY']), number_format($gvars->data['gangCRYSTALS']),
	strtolower($gvars->crystals_name), $gvars->money_name, $gvars->crystals_name);
}

function sgang_payment2() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
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
		echo "<h3>Please select an amount of $gvars->money_name or $gvars->crystals_name to send.</h3>";
		gang_go_back('yourgang.php?action=sgang_payment'); return;
	}
	$money_l = strtolower($gvars->money_name);
	$crystals_l = strtolower($gvars->crystals_name);
	
	$q_get = sprintf('select u.userid, u.username from users as u
		where u.gang = %d', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	$members = array();
	while (list($them_id, $them_name) = mysql_fetch_row($q_get)) {
		$members[$them_id] = $them_name;
	}
	
	$num_members = count($members);
	$total_money = $money * $num_members;
	$total_crystals = $crystals * $num_members;
	
	if ($money > 0) {
		if (!gang_take_gang_money($gvars->ir['gang'], $total_money)) {
			echo "<h3>The $gvars->name_sl doesn't have enough $money_l to cover this transaction.</h3>";
			gang_go_back('yourgang.php?action=sgang_payment');
			return;
		}
	}
	
	if ($crystals > 0) {
		if (!gang_take_gang_money($gvars->ir['gang'], $total_crystals, 'gangCRYSTALS')) {
			if ($money > 0) {
				gang_give_gang_money($gvars->ir['gang'], $total_money);
			}
			echo "<h3>The $gvars->name_sl doesn't have enough $crystals_l to cover this transaction.</h3>";
			gang_go_back('yourgang.php?action=sgang_payment');
			return;
		}
	}
	
	if ($money > 0 and $crystals > 0) {
		$gang_event = '%1$s sent a mass payment of %2$s and %3$s %4$s';
		$player_event = '%1$s sent %2$s and %3$s %4$s to you from the %5$s';
		$msg = '<h3>You sent a mass payment of %1$s and %2$s %3$s</h3>';
	} else if ($money > 0) {
		$gang_event = '%1$s sent a mass payment of %2$s';
		$player_event = '%1$s sent %2$s to you from the %5$s';
		$msg = '<h3>You sent a mass payment of %1$s</h3>';
	} else if ($crystals > 0) {
		$gang_event = '%1$s sent a mass payment of %3$s %4$s';
		$player_event = '%1$s sent %3$s %4$s to you from the %5$s';
		$msg = '<h3>You sent a mass payment of %2$s %3$s</h3>';
	}
	
	$us_p = gang_get_profile_link($gvars->userid, $gvars->ir['username']);
	foreach ($members as $them_id => $them_name) {
		if ($money > 0) {
			gang_give_money($them_id, $money);
		}
		if ($crystals > 0) {
			gang_give_money($them_id, $crystals, 'crystals');
		}
		event_add($them_id, sprintf($player_event, $us_p, gang_money_format($money), number_format($crystals), $crystals_l, $gvars->name_sl), $gvars->c);
	}
	
	gang_new_event($gvars->ir['gang'], sprintf($gang_event,	$us_p, gang_money_format($money), number_format($crystals), $crystals_l), 'escape');
	printf($msg, gang_money_format($money), number_format($crystals), $crystals_l);
	gang_go_back('yourgang.php?action=sgang_payment'); return;
}

function sgang_upgrade() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	$capacity = $gvars->data['gangCAPACITY'];
	$upgrade_price = gang_money_format($gvars->upgrade_price);
	
	
	echo <<<EOT
	<h2>$gvars->name_su Capacity</h2>
	<p class="center">Current Capacity: $capacity</p>
	<p class="center">Enter the amount of extra capacity you need. Each extra member slot costs $upgrade_price.</p>
	<form method="post" action="yourgang.php?action=sgang_upgrade2">
		<table>
			<tr>
				<th>
				Capacity Increase
				</th>
				<th>
				<input type="text" name="amount">
				</th>
			</tr>
			<tr>
				<th colspan="2">
				<input type="submit" value="Buy">
				</th>
			</tr>
		</table>
	</form>
EOT;
	/*
Capacity
Current Capacity: 5
Enter the amount of extra capacity you need. Each extra member slot costs $100,000.
	*/
	
	
}

function sgang_upgrade2() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['amount']) or intval($_REQUEST['amount']) < 1) {
		echo "<h3>How much extra capcity do you want?</h3>";
		gang_go_back('yourgang.php?action=sgang_upgrade'); return;
	}
	$amount = intval($_REQUEST['amount']);
	
	$capacity = $gvars->data['gangCAPACITY'];
	
	$cost = $amount * $gvars->upgrade_price;
	$cost_f = gang_money_format($cost);
	
	if (!gang_take_gang_money($gvars->ir['gang'], $cost)) {
		echo "<h3>The $gvars->name_sl doesn't have enough $gvars->money_name to pay for that.</h3>";
		gang_go_back('yourgang.php?action=sgang_upgrade'); return;
	}
	
	$q_set = sprintf('update gangs set gangCAPACITY = gangCAPACITY + %d where gangID = %d', $amount, $gvars->ir['gang']);
	mysql_query($q_set);
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The capacity could not be upgraded.</h3>";
	} else {
		echo "<h3>The capacity was upgraded for a cost of $cost_f.</h3>";
		
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		
		gang_new_event($gvars->ir['gang'], sprintf('%s increased the %s capacity to %d', $us_p, $gvars->name_sl, $capacity + $amount), 'escape');
	}
	gang_go_back('yourgang.php?action=sgang_upgrade');
}

function sgang_leadership() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	$user_ids = array($gvars->data['gangPRESIDENT'], $gvars->data['gangVICEPRES']);
	$q_get = sprintf('select userid, username from users where userid in (%s)', implode(', ', $user_ids));
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This gang has no leadership and will be deleted..</h3>";
		_gang_delete($gvars->ir['gang']); return;
	}
	$leadership = '';
	
	$ranks = array(
		0 => 'Select one...',
		'pres' => $gvars->pres,
		'vice' => $gvars->vice_pres,
		'remove' => 'Remove...',
	);
	
	$count = 0;
	while (list($them_id, $them_name) = mysql_fetch_array($q_get)) {
		switch ($them_id) {
			case $gvars->data['gangPRESIDENT']: $rank_name = $gvars->pres; break;
			case $gvars->data['gangVICEPRES']: $rank_name = $gvars->vice_pres; break;
			default: $rank_name = 'N/A'; break;
		}
		$them_p = gang_get_profile_link($them_id, $them_name);
		
		$options = '';
		foreach ($ranks as $key => $rank) {
			if ($rank == $rank_name) {
				$selected = ' selected="selected"';
			} else {
				$selected = '';
			}
			$options .= <<<EOT
<option value="$key"$selected>$rank</option>\n
EOT;
		}
		
		$leadership .= <<<EOT
		<tr>
			<td>
			$them_p
			</td>
			<td>
			<form method="post" action="yourgang.php?action=sgang_alter_staff">
				<input type="hidden" name="them_id" value="$them_id">
				<select name="rank">
$options
				</select>
				<input type="submit" value="Save">
			</form>
			</td>
		</tr>\n
EOT;
		$count++;
	}
	
	
	
	
	$q_get = sprintf('select u.userid, u.username from users as u
		where u.gang = %d
		order by u.username', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	$member_list = '';
	while (list($them_id, $them_name) = mysql_fetch_row($q_get)) {
		if (in_array($them_id, $user_ids)) {
			continue;
		}
		$member_list .= <<<EOT
<option value="$them_id">$them_name</option>\n
EOT;
	}
	$options = '';
	array_pop($ranks);
	foreach ($ranks as $key => $rank) {
		$options .= <<<EOT
<option value="$key"$selected>$rank</option>\n
EOT;
	}
	
	echo <<<EOT
	<h2>$gvars->name_su Leadership</h2>
	<table style="width: 300px">
		<tr>
			<th>
			Staff Member
			</th>
			<th>
			Rank
			</th>
		</tr>
$leadership
	</table>
	
<br>
<br>
<br>

	<p class="bold center">Promote a member to staff</p>
	<form method="post" action="yourgang.php?action=sgang_alter_staff">
		<table style="width: 300px">
			<tr>
				<th>
				Promote:
				<select name="them_id">
<option value="0">Select one...</option>
$member_list
				</select>
				To:
				<select name="rank">
$options
				</select>
				</th>
			</tr>
			<tr>
				<th>
				<input type="submit" value="Promote">
				</th>
			</tr>
		</table>
	</form>
EOT;
	
}

function sgang_alter_staff() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['them_id']) or intval($_REQUEST['them_id']) < 1) {
		echo "<h3>Please submit a valid request.</h3>";
		gang_go_back('yourgang.php?action=sgang_leadership'); return;
	}
	$them_id = intval($_REQUEST['them_id']);
	
	$q_get = sprintf('select username from users where userid = %d and gang = %d', $them_id, $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>Please submit a valid request.</h3>";
		gang_go_back('yourgang.php?action=sgang_leadership'); return;
	}
	list($them_name) = mysql_fetch_array($q_get);
	
	if (!isset($_REQUEST['rank']) or strlen($_REQUEST['rank']) < 1) {
		echo "<h3>Please submit a valid request.</h3>";
		gang_go_back('yourgang.php?action=sgang_leadership'); return;
	}
	$rank = $_REQUEST['rank'];
	
	$us_p = gang_get_profile_link($gvars->userid, $gvars->ir['username']);
	$them_p = gang_get_profile_link($them_id, $them_name);
	
	$completed = false;
	switch ($rank) {
		case 'pres':
			if (gang_auth($gvars->userid, 'pres')) {
				$q_set = sprintf('update gangs set gangPRESIDENT = %d where gangID = %d', $them_id, $gvars->ir['gang']);
				mysql_query($q_set);
				if (mysql_affected_rows() > 0) {
					$q_set = sprintf('update gangs set gangVICEPRES = 0 where gangVICEPRES = %d and gangID = %d', $them_id, $gvars->ir['gang']);
					mysql_query($q_set);
					gang_new_event($gvars->ir['gang'], sprintf('%s promoted %s to the position of %s', $us_p, $them_p, $gvars->pres), 'escape');
					event_add($them_id, sprintf('%s promoted you to the position of %s of %s', $us_p, $gvars->pres, $gvars->data['gangNAME']), $gvars->c);
					$result = "<p class=\"center\">$them_p has been promoted to $gvars->pres.</p>";
					$completed = true;
				}
			}
			break;
		case 'vice':
			if (gang_auth($gvars->userid, 'pres') and $gvars->userid != $them_id) {
				$q_set = sprintf('update gangs set gangVICEPRES = %d where gangID = %d', $them_id, $gvars->ir['gang']);
				mysql_query($q_set);
				if (mysql_error()) {
					echo mysql_error();
				}
				if (mysql_affected_rows() > 0) {
					gang_new_event($gvars->ir['gang'], sprintf('%s promoted %s to the position of %s', $us_p, $them_p, $gvars->vice_pres), 'escape');
					if ($gvars->userid != $gvars->data['gangVICEPRES'] and $gvars->data['gangVICEPRES'] > 0) {
						event_add($them_id, sprintf('%s demoted you from the position of %s of %s', $us_p, $gvars->vice_pres, $gvars->data['gangNAME']), $gvars->c);
					}
					event_add($them_id, sprintf('%s promoted you to the position of %s of %s', $us_p, $gvars->vice_pres, $gvars->data['gangNAME']), $gvars->c);
					$result = "<p class=\"center\">$them_p has been promoted to $gvars->vice_pres.</p>";
					$completed = true;
				}
			}
			break;
		case 'remove':
			if (gang_auth($gvars->userid, 'pres')) {
				$q_set = sprintf('update gangs set gangVICEPRES = 0 where gangVICEPRES = %d and gangID = %d', $them_id, $gvars->ir['gang']);
				mysql_query($q_set);
				if (mysql_affected_rows() > 0) {
					gang_new_event($gvars->ir['gang'], sprintf('%s demoted %s from the position of %s', $us_p, $them_p, $gvars->vice_pres), 'escape');
					if ($them_id != $gvars->userid) {
						event_add($them_id, sprintf('%s demoted you from the position of %s of %s', $us_p, $gvars->vice_pres, $gvars->data['gangNAME']), $gvars->c);
					}
					$result = "<p class=\"center\">$them_p has been demoted from $gvars->vice_pres.</p>";
					$completed = true;
				}
			}
			break;
	}
	if (!$completed) {
		echo "<h3>The request could not be completed.</h3><p>If you are the $gvars->pres, you may not demote yourself, you may only promote someone else
		to the position of $gvars->pres. If you are the $gvars->vice_pres, you can only remove yourself from your position.</p>";
	} else {
		echo "<h3>Complete</h3>$result";
	}
	gang_go_back('yourgang.php?action=sgang_leadership'); return;
}

function sgang_vault() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	$q_get = sprintf('select u.userid, u.username from users as u
		where u.gang = %d
		order by u.username', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	$member_list = '';
	while (list($them_id, $them_name) = mysql_fetch_row($q_get)) {
		$member_list .= <<<EOT
<option value="$them_id">$them_name</option>\n
EOT;
	}
	
	printf('
	<h2>Vault Management</h2>
	<p class="center">The vault has %s and %s %s.</p>
	<form method="post" action="yourgang.php?action=sgang_vault_give">
		<table>
			<tr>
				<th>
				%s
				</th>
				<th>
				%s
				</th>
			</tr>
			<tr>
				<th>
				<input type="text" name="money">
				</th>
				<th>
				<input type="text" name="crystals">
				</th>
			</tr>
			<tr>
				<th>
				To: <select name="them_id">
	<option value="0">Select one...</option>
				%s
				</select>
				</th>
				<th>
				<input type="submit" value="Give">
				</th>
			</tr>
		</table>
	</form>
	', gang_money_format($gvars->data['gangMONEY']), number_format($gvars->data['gangCRYSTALS']),
	strtolower($gvars->crystals_name), $gvars->money_name, $gvars->crystals_name, $member_list);
}

function sgang_vault_give() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['them_id']) or intval($_REQUEST['them_id']) < 1) {
		echo "<h3>Please select a $gvars->name_sl member.</h3>";
		gang_go_back('yourgang.php?action=sgang_vault'); return;
	}
	$them_id = intval($_REQUEST['them_id']);
	
	$q_check = sprintf('select username, gang from users where userid = %d', $them_id);
	$q_check = mysql_query($q_check);
	if (!$q_check or mysql_num_rows($q_check) < 1) {
		echo "<h3>The player you selected could not be found.</h3>";
		gang_go_back('yourgang.php?action=sgang_vault'); return;
	}
	list($them_name, $them_gang) = mysql_fetch_row($q_check);
	
	if ($them_gang != $gvars->ir['gang']) {
		echo "<h3>The player you selected is not in your $gvars->name_sl.</h3>";
		gang_go_back('yourgang.php?action=sgang_vault'); return;
	}
	
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
		echo "<h3>Please select an amount of $gvars->money_name or $gvars->crystals_name to give.</h3>";
		gang_go_back('yourgang.php?action=sgang_vault'); return;
	}
	$money_l = strtolower($gvars->money_name);
	$crystals_l = strtolower($gvars->crystals_name);
	
	if ($money > 0) {
		if (!gang_take_gang_money($gvars->ir['gang'], $money)) {
			echo "<h3>The $gvars->name_sl doesn't have enough $money_l to cover this transaction.</h3>";
			gang_go_back('yourgang.php?action=sgang_vault');
			return;
		}
	}
	
	if ($crystals > 0) {
		if (!gang_take_gang_money($gvars->ir['gang'], $crystals, 'gangCRYSTALS')) {
			if ($money > 0) {
				gang_give_gang_money($gvars->ir['gang'], $money);
			}
			echo "<h3>The $gvars->name_sl doesn't have enough $crystals_l to cover this transaction.</h3>";
			gang_go_back('yourgang.php?action=sgang_vault');
			return;
		}
	}
	if ($money > 0) {
		gang_give_money($them_id, $money);
		
	}
	if ($crystals > 0) {
		gang_give_money($them_id, $crystals, 'crystals');
	}
	
	if ($money > 0 and $crystals > 0) {
		$gang_event = '%1$s sent %2$s and %3$s %4$s to %5$s';
		$player_event = '%1$s sent %2$s and %3$s %4$s to you from the %5$s';
		$msg = '<h3>You sent %1$s and %2$s %3$s to %4$s</h3>';
	} else if ($money > 0) {
		$gang_event = '%1$s sent %2$s to %5$s';
		$player_event = '%1$s sent %2$s to you from the %5$s';
		$msg = '<h3>You sent %1$s to %4$s</h3>';
	} else if ($crystals > 0) {
		$gang_event = '%1$s sent %3$s %4$s to %5$s';
		$player_event = '%1$s sent %3$s %4$s to you from the %5$s';
		$msg = '<h3>You sent %2$s %3$s to %4$s</h3>';
	}
	
	$us_p = gang_get_profile_link($gvars->userid, $gvars->ir['username']);
	$them_p = gang_get_profile_link($them_id, $them_name);
	gang_new_event($gvars->ir['gang'], sprintf($gang_event,	$us_p, gang_money_format($money), number_format($crystals), $crystals_l, $them_p), 'escape');
	event_add($them_id, sprintf($player_event, $us_p, gang_money_format($money), number_format($crystals), $crystals_l, $gvars->name_sl), $gvars->c);
	printf($msg, gang_money_format($money), number_format($crystals), $crystals_l, $them_p);
	gang_go_back('yourgang.php?action=sgang_vault'); return;
}

function sgang_apps() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	// appID, appUSER, appGANG, appTEXT <<< 
	$q_get = sprintf('select a.appID, a.appUSER, u.username, a.appTEXT, u.level from applications as a
		left join users as u on a.appUSER = u.userid
		where a.appGANG = %d', $gvars->ir['gang']);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		$app_list = <<<EOT
			<tr>
				<td colspan="5" class="bold center">
				There are no applications at this time.
				</td>
			</tr>
EOT;
	} else {
		$app_list = '';
		while (list($app_id, $them_id, $them_name, $text, $level) = mysql_fetch_array($q_get)) {
			$them_p = gang_get_profile_link($them_id, $them_name);
			$text = nl2br($text);
			$app_list .= <<<EOT
			<tr>
				<td>
				$them_p
				</td>
				<td>
				$level
				</td>
				<td>
				$text
				</td>
				<td class="ygang_menu">
				<a href="yourgang.php?action=sgang_app_accept&app_id=$app_id">Accept</a>
				</td>
				<td class="ygang_menu">
				<a href="yourgang.php?action=sgang_app_decline&app_id=$app_id">Decline</a>
				</td>
			</tr>
EOT;
		}
	}
	
	$q_count = sprintf('select count(*) from users where gang = %d', $gvars->ir['gang']);
	list($num_members) = mysql_fetch_row(mysql_query($q_count));
	$max_members = $gvars->data['gangCAPACITY'];
	
	// User	Level	Money	Reason
	echo <<<EOT
	<h2>Application Management</h2>
	<p class="center">Number of Members/Max: $num_members/$max_members</p>
	<table style="width: 450px">
		<tr>
			<th>
			Applicant
			</th>
			<th>
			Level
			</th>
			<th>
			Reason
			</th>
			<th colspan="2">
			Links
			</th>
		</tr>
		$app_list
	</table>
	
EOT;
}

function sgang_app_decline() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['app_id']) or intval($_REQUEST['app_id']) < 1) {
		echo "<h3>Which application are you declining?</h3>";
		gang_go_back('yourgang.php?action=sgang_apps'); return;
	}
	$app_id = intval($_REQUEST['app_id']);
	
	
	// appID, appUSER, appGANG, appTEXT <<< 
	$q_get = sprintf('select a.appUSER, u.username from applications as a
		left join users as u on a.appUSER = u.userid
		where a.appGANG = %d and a.appID = %d', $gvars->ir['gang'], $app_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This application does not exist.</h3>";
		gang_go_back('yourgang.php?action=sgang_apps'); return;
	}
	
	list($them_id, $them_name) = mysql_fetch_array($q_get);
	
	$q_del = sprintf('delete from applications where appGANG = %d and appID = %d', $gvars->ir['gang'], $app_id);
	mysql_query($q_del);
	
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The application could not be declined.</h3>";
	} else {
		echo "<h3>The application was declined.</h3>";
		
		$them_p = gang_get_profile_link($them_id, $them_name);
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		
		gang_new_event($gvars->ir['gang'], sprintf('%s declined an application from %s', $us_p, $them_p), 'escape');
		event_add($them_id, sprintf('%s declined your application to %s', $us_p, $gvars->data['gangNAME']), $gvars->c);
	}
	gang_go_back('yourgang.php?action=sgang_apps');
}

function sgang_app_accept() {
	global $gvars;
	
	if (!gang_auth_all($gvars->userid, array('pres', 'vice'))) {
		echo "<h3>You are not authorized to access this portion of the staff panel.</h3>";
		gang_go_back('yourgang.php?action=sgang_home'); return;
	}
	
	if (!isset($_REQUEST['app_id']) or intval($_REQUEST['app_id']) < 1) {
		echo "<h3>Which application are you accepting?</h3>";
		gang_go_back('yourgang.php?action=sgang_apps'); return;
	}
	$app_id = intval($_REQUEST['app_id']);
	
	
	
	$q_count = sprintf('select count(*) from users where gang = %d', $gvars->ir['gang']);
	list($num_members) = mysql_fetch_row(mysql_query($q_count));
	$max_members = $gvars->data['gangCAPACITY'];
	
	if ($num_members >= $gvars->data['gangCAPACITY']) {
		echo "<h3>The $gvars->name_sl cannot hold any more members.</h3>";
		gang_go_back('yourgang.php?action=sgang_apps'); return;
	}
	
	// appID, appUSER, appGANG, appTEXT <<< 
	$q_get = sprintf('select a.appUSER, u.username from applications as a
		left join users as u on a.appUSER = u.userid
		where a.appGANG = %d and a.appID = %d', $gvars->ir['gang'], $app_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>This application does not exist.</h3>";
		gang_go_back('yourgang.php?action=sgang_apps'); return;
	}
	
	list($them_id, $them_name) = mysql_fetch_array($q_get);
	
	$q_del = sprintf('delete from applications where appGANG = %d and appID = %d', $gvars->ir['gang'], $app_id);
	mysql_query($q_del);
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The application could not be accepted.</h3>";
	} else {
		$q_set = sprintf('update users set gang = %d where userid = %d and gang = 0', $gvars->ir['gang'], $them_id);
        mysql_query($q_set);
		if (mysql_affected_rows() < 1) {
			echo "<h3>The application could not be accepted.</h3>";
		} else {
			echo "<h3>The application was accepted.</h3>";
			
			$them_p = gang_get_profile_link($them_id, $them_name);
			$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
			
			gang_new_event($gvars->ir['gang'], sprintf('%s accepted an application from %s', $us_p, $them_p), 'escape');
			event_add($them_id, sprintf('%s accepted your application to %s', $us_p, $gvars->data['gangNAME']), $gvars->c);
		}
	}
	gang_go_back('yourgang.php?action=sgang_apps');
}
