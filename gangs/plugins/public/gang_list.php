<?php


if (!defined('GANG_MODULE')) {
	return; 
}


$gvars->tabs += array(
	'gang_list' => 'Gang List',
	'gang_wars' => 'Wars',
);
if ($gvars->ir['gang'] === '0') {
	$q_check = sprintf('select count(*) from applications where appUSER = %d', $gvars->userid);
	list($num_apps) = mysql_fetch_row(mysql_query($q_check));
	if ($num_apps) {
		$gvars->tabs += array(
			'gang_my_apps' => 'My Apps',
		);
	}
}

$gvars->actions += array(
	'gang_list' => 'gang_list',
	'gang_wars' => 'gang_wars',
	'gang_create' => 'gang_create',
	'gang_create2' => 'gang_create2',
	'gang_view' => 'gang_view',
	'gang_app' => 'gang_app',
	'gang_app2' => 'gang_app2',
	'gang_my_apps' => 'gang_my_apps',
	'gang_app_cancel' => 'gang_app_cancel',
);

function gang_list() {
	global $gvars;
	// gangID, gangNAME, gangDESC, gangPREF, gangSUFF, gangMONEY, gangCRYSTALS, gangRESPECT, gangPRESIDENT, gangVICEPRES, gangCAPACITY, gangCRIME, gangCHOURS, gangAMENT
	
	$where = array();
	if (!isset($_REQUEST['letter']) or strlen($_REQUEST['letter']) != 1 or !ctype_alpha($_REQUEST['letter'])) {
		$letter = '';
		$form_letter = '';
	} else {
		$letter = $_REQUEST['letter'];
		$where[] = sprintf('g.gangNAME like("%s%%")', $letter);
		$form_letter = sprintf('<input type="hidden" name="letter" value="%s">', $letter);
	}
	
	if (!empty($where)) {
		$where = 'where ' . implode(' and ', $where);
	} else {
		$where = '';
	}
	
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
		from gangs as g
		%s
	', $where);
	$q_get = mysql_query($q_get);
	list($total_results) = mysql_fetch_row($q_get);
	
	$num_pages = ceil($total_results / $limit);
	$current_page = floor($offset / $limit) + 1;
	
	$q_get = sprintf('select gangID as gang_id, gangNAME as name, gangDESC as description,
		gangPREF as prefix, gangSUFF as suffix, gangMONEY as money, gangCRYSTALS as crystals,
		gangRESPECT as respect, gangPRESIDENT as president, gangVICEPRES as vice_president,
		gangCAPACITY as capacity, gangCRIME as crime, gangCHOURS as crime_hours, gangAMENT as announcement,
		up.username as pres_name, uv.username as vice_name
		from gangs as g
		left join users as up on gangPRESIDENT = up.userid
		left join users as uv on gangVICEPRES = uv.userid
		%s
		order by g.gangNAME limit %d, %d
	', $where, $offset, $limit);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		$gang_list = <<<EOT
		<tr>
			<td colspan="5">
			<h3>No $gvars->name_pl found.</h3>
			</td>
		</tr>
EOT;
	} else {
		$gang_list = '';
		while ($data = mysql_fetch_assoc($q_get)) {
			
			$respect = number_format($data['respect']);
			
			if ($gvars->ir['gang']) {
				$app_link = '';
			} else {
				$app_link = sprintf('| <a href="gangs.php?action=gang_app&gang_id=%d">Apply</a>', $data['gang_id']);
			}
			
			$gang_list .= sprintf('
			<tr>
				<td>
				%1$s
				</td>
				<td>
				%2$s
				</td>
				<td>
				%3$s
				</td>
				<td class="right">
				%4$s
				</td>
				<td class="center">
				%5$s
				%6$s
				</td>
			</tr>
			', gang_get_gang_link($data['gang_id'], $data['name']), gang_get_profile_link($data['president'], $data['pres_name']),
			gang_get_profile_link($data['vice_president'], $data['vice_name']), $respect, gang_get_gang_link($data['gang_id'], 'View'), $app_link);
		}
	}
	
	$atoz = range('A', 'Z');
	$all_selected = ' selected';
	foreach ($atoz as $key => &$value) {
		if (strtoupper($letter) === $value) {
			$selected = ' selected';
			$all_selected = '';
		} else {
			$selected = '';
		}
		$value = <<<EOT
<a class="gang_letter$selected" href="gangs.php?action=gang_list&letter=$value">$value</a>
EOT;
	}
	unset($value);
	$atoz = implode(' ', $atoz);
	
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
	<h2>$gvars->name_su List</h2>
	<table>
		<tr>
			<td>
$atoz
<a class="gang_letter$all_selected" href="gangs.php?action=gang_list">All</a>
			</td>
		</tr>
		<tr>
			<td class="center">
				<form method="get" action="gangs.php">
					$form_letter
					<input type="hidden" name="action" value="gang_list">
					Page Number <select name="offset">$page_options</select>
					<input type="submit" value="Go">
				</form>
			</td>
		</tr>
	</table>
	<table style="width: 400px">
		<tr>
			<th>
			$gvars->name_su
			</th>
			<th>
			President
			</th>
			<th>
			Vice President
			</th>
			<th>
			Respect
			</th>
			<th>
			Links
			</th>
		</tr>
$gang_list
	</table>
EOT;
}

function gang_wars() {
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
	$q_get = mysql_query('select count(*) from gangwars');
	list($total_results) = mysql_fetch_row($q_get);
	
	$num_pages = ceil($total_results / $limit);
	$current_page = floor($offset / $limit) + 1;
	
	// warID, warDECLARER, warDECLARED, warTIME <<< gangwars
	$q_get = sprintf('select w.warID, w.warDECLARER, w.warDECLARED, w.warTIME,
		a.gangNAME, a.gangRESPECT, b.gangNAME, b.gangRESPECT from gangwars as w
		left join gangs as a on w.warDECLARER = a.gangID
		left join gangs as b on w.warDECLARED = b.gangID
		order by %s limit %d, %d', $order_by, $offset, $limit);
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
				<form method="get" action="gangs.php">
					<input type="hidden" name="action" value="gang_wars">
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

function gang_create() {
	global $gvars;
	
	if ($gvars->ir['gang']) {
		echo "<h3>You are in a $gvars->name_sl!</h3>";
		_gang_auto_clear_user($gvars->ir['userid'], $gvars->ir['gang']);
		return;
	}
	
	$cost_f = $gvars->new_gang_money_prefix . number_format($gvars->new_gang_price);
	if (strlen($gvars->gang_name_allowable_special_characters) > 0) {
		$sp_chars = '<br>It may also contain these special characters: ' . $gvars->gang_name_allowable_special_characters;
	} else {
		$sp_chars = '';
	}
	
	echo <<<EOT
<h3>Creating a New $gvars->name_su</h3>
<p class="center">It costs $cost_f to start a new $gvars->name_sl.</p>
<p class="center">
The $gvars->name_sl name must start with a letter, can contain letters, numbers. $sp_chars
</p>
<form method="post" action="gangs.php?action=gang_create2">
<ul class="right bold" style="width: 300px; margin: 0 auto; border: 1px solid #d2ae04; background-color: #727843; padding: 4px">
	<li>$gvars->name_su Name: <input type="text" name="name" style="width: 150px"></li>
	<li>$gvars->name_su Tag: <input type="text" name="prefix" style="width: 150px"></li>
	<li class="center"><p>Description:</p>
	<p><textarea name="description" style="width: 95%; height: 100px"></textarea></p>
	</li>
	<li class="center">
	<input type="submit" value="Create">
	</li>
</ul>
</form>
EOT;
}

function gang_create2() {
	global $gvars, $ir;
	
	if ($gvars->ir['gang']) {
		echo "<h3>You are in a $gvars->name_sl!</h3>";
		_gang_auto_clear_user($gvars->ir['userid'], $gvars->ir['gang']);
		return;
	}
	
	$cost_f = $gvars->new_gang_money_prefix . number_format($gvars->new_gang_price);
	
	if ($ir[$gvars->new_gang_db_field] < $gvars->new_gang_price) {
		echo "<h3>You can't afford the price of $cost_f to create a new $gvars->name_sl.</h3>";
		return;
	}
	
	if (!isset($_REQUEST['name']) or strlen($_REQUEST['name']) < 1 or !$gvars->check_gang_name_allowable_special_characters($_REQUEST['name']) or !ctype_alpha(substr($_REQUEST['name'], 0, 1))) {
		$name = $ir['username'] . "'s " . $gvars->name_su;
	} else {
		$name = $_REQUEST['name'];
	}
	
	if (!isset($_REQUEST['prefix']) or strlen($_REQUEST['prefix']) > $gvars->gang_prefix_max_length) {
		$prefix = '';
	} else {
		$prefix = $_REQUEST['prefix'];
	}
	
	if (!isset($_REQUEST['description'])) {
		$description = '';
	} else {
		$description = $_REQUEST['description'];
	}
	
	if (!gang_take_money($ir['userid'], $gvars->new_gang_price, $gvars->new_gang_db_field)) {
		echo "<h3>You don't have enough money create a $gvars->name_sl.</h3>";
		return;
	}
	
	$q_set = sprintf('insert into gangs (gangNAME, gangDESC, gangPREF, gangSUFF, gangMONEY, gangCRYSTALS,
		gangRESPECT, gangPRESIDENT, gangVICEPRES, gangCAPACITY, gangCRIME, gangCHOURS, gangAMENT)
		values ("%s", "%s", "%s", "", 0, 0, 100, %d, %d, 5, 0, 0, "")',
		$gvars->escape($name), $gvars->escape($description), $gvars->escape($prefix), $ir['userid'], $ir['userid']);
	mysql_query($q_set);
	if (mysql_affected_rows() < 1) {
		echo "<h3>The $gvars->name_sl could not be created.</h3>";
		gang_go_back('gangs.php?action=gang_create');
		return;
	}
	$q_set = sprintf('update users set gang = %d where userid = %d', mysql_insert_id(), $ir['userid']);
	mysql_query($q_set);
	echo "<h3>Your $gvars->name_sl, $name, has been created!</h3>";
	gang_go_back('yourgang.php');
}

function gang_view() {
	global $gvars;
	
	if (!isset($_REQUEST['gang_id']) or intval($_REQUEST['gang_id']) < 1) {
		echo "<h3>Which $gvars->name_sl are you looking for?</h3>"; return;
	}
	$gang_id = intval($_REQUEST['gang_id']);
	
	
	// gangID, gangNAME, gangDESC, gangPREF, gangSUFF, gangMONEY, gangCRYSTALS, gangRESPECT, gangPRESIDENT,
	// gangVICEPRES, gangCAPACITY, gangCRIME, gangCHOURS, gangAMENT
	$q_get = sprintf('select g.gangNAME, g.gangDESC, g.gangRESPECT, g.gangPRESIDENT, g.gangVICEPRES, g.gangCAPACITY
		from gangs as g where g.gangID = %d', $gang_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you selected could not be found.</h3>"; return;
	}
	list($gang_name, $desc, $respect, $pres_id, $vice_id, $capacity) = mysql_fetch_row($q_get);
	
	$desc = nl2br($desc);
	
	$pres_name = 'N/A';
	$vice_name = 'N/A';
	
	$q_get = sprintf('select userid, username, daysingang, level from users where gang = %d', $gang_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you selected does not have any members.</h3>";
		_gang_delete($gang_id);
		return;
	}
	
	$user_list = '';
	$member_count = mysql_num_rows($q_get);
	while (list($them_id, $them_name, $daysingang, $level) = mysql_fetch_row($q_get)) {
		$profile = gang_get_profile_link($them_id, $them_name);
		if ($pres_id == $them_id) {
			$pres_name = $profile;
		}
		if ($vice_id == $them_id) {
			$vice_name = $profile;
		}
		$user_list .= <<<EOT
		<tr class="right">
			<td class="left">
			$profile
			</td>
			<td>
			$level
			</td>
			<td>
			$daysingang
			</td>
		</tr>\n
EOT;
	}
			
	if ($gvars->ir['gang']) {
		$app_link = '';
	} else {
		$app_link = sprintf('<p class="center"><a href="gangs.php?action=gang_app&gang_id=%d">Apply</a></p>', $gang_id);
	}
	
	echo <<<EOT
	<h3>$gang_name</h3>
	$app_link
	<table style="width:400px;">
		<tr>
			<th>
			$gvars->pres
			</th>
			<th>
			$gvars->vice_pres
			</th>
			<th>
			Members
			</th>
			<th>
			Respect Level
			</th>
		</tr>
		<tr class="right">
			<td class="left">
			$pres_name
			</td>
			<td class="left">
			$vice_name
			</td>
			<td>
			$member_count
			</td>
			<td>
			$respect
			</td>
		</tr>
		<tr>
			<th colspan="4">
			Description
			</th>
		</tr>
		<tr>
			<td colspan="4">
			$desc
			</td>
		</tr>
	</table>
	
	<h3>User List</h3>
	<table style="width:400px;">
		<tr>
			<th>
			User
			</th>
			<th>
			Level
			</th>
			<th>
			Days In Gang
			</th>
		</tr>
		$user_list
	</table>
EOT;
}

function gang_app() {
	global $gvars;
	
	if ($gvars->ir['gang']) {
		echo "<h3>You are in a $gvars->name_sl!</h3>";
		_gang_auto_clear_user($gvars->ir['userid'], $gvars->ir['gang']);
		return;
	}
	
	if (!isset($_REQUEST['gang_id']) or intval($_REQUEST['gang_id']) < 1) {
		echo "<h3>Which $gvars->name_sl are you applying to?</h3>"; return;
	}
	$gang_id = intval($_REQUEST['gang_id']);
	
	$q_get = sprintf('select g.gangNAME, g.gangDESC, g.gangRESPECT, g.gangPRESIDENT, g.gangVICEPRES, g.gangCAPACITY
		from gangs as g where g.gangID = %d', $gang_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you selected could not be found.</h3>"; return;
	}
	list($gang_name, $desc, $respect, $pres_id, $vice_id, $capacity) = mysql_fetch_row($q_get);
	
	echo <<<EOT
	<h2>Applying to: $gang_name</h2>
	<p class="center">$desc</p>
	<form method="post" action="gangs.php?action=gang_app2&gang_id=$gang_id">
		<table>
			<tr>
				<td>
				Type in why your application should be accepted:
				</td>
			</tr>
			<tr>
				<th>
				<textarea name="reason" style="width: 100%; height: 60px"></textarea>
				</th>
			</tr>
			<tr>
				<th>
				<input type="submit" value="Submit Application">
				</th>
			</tr>
		</table>
	</form>
EOT;
	
}

function gang_app2() {
	global $gvars;
	
	if ($gvars->ir['gang']) {
		echo "<h3>You are in a $gvars->name_sl!</h3>";
		_gang_auto_clear_user($gvars->ir['userid'], $gvars->ir['gang']);
		return;
	}
	
	if (!isset($_REQUEST['gang_id']) or intval($_REQUEST['gang_id']) < 1) {
		echo "<h3>Which $gvars->name_sl are you applying to?</h3>"; return;
	}
	$gang_id = intval($_REQUEST['gang_id']);
	
	if (!isset($_REQUEST['reason']) or strlen($_REQUEST['reason']) < 1) {
		$reason = 'N\A';
	} else {
		$reason = $_REQUEST['reason'];
	}
	
	// appID, appUSER, appGANG, appTEXT <<< applications
	$q_check = sprintf('select count(*) from applications where appUSER = %d', $gvars->userid);
	list($num_apps) = mysql_fetch_row(mysql_query($q_check));
	
	if ($num_apps >= $gvars->max_apps) {
		echo "<h3>You are allowed to have a maximum of $gvars->max_apps applications pending.</h3>"; return;
	}
	
	$q_get = sprintf('select g.gangNAME, g.gangDESC, g.gangRESPECT, g.gangPRESIDENT, g.gangVICEPRES, g.gangCAPACITY
		from gangs as g where g.gangID = %d', $gang_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>The $gvars->name_sl you selected could not be found.</h3>"; return;
	}
	list($gang_name, $desc, $respect, $pres_id, $vice_id, $capacity) = mysql_fetch_row($q_get);
	
	
	$q_set = sprintf('insert into applications (appUSER, appGANG, appTEXT)
		values (%d, %d, "%s")', $gvars->userid, $gang_id, $gvars->clean($reason));
	
	mysql_query($q_set);
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The application submission failed.</h3>";
	} else {
		$gang_link = gang_get_gang_link($gang_id, $gang_name);
		echo "<h3>Your application to $gang_link has been submitted.</h3>";
		$us_p = gang_get_profile_link($gvars->ir['userid'], $gvars->ir['username']);
		gang_new_event($gang_id, "$us_p submitted an application.", 'escape');
	}
	gang_go_back('gangs.php?action=gang_view&gang_id=' . $gang_id);
	
	
}

function gang_my_apps() {
	global $gvars;
	
	// appID, appUSER, appGANG, appTEXT <<< applications
	$q_get = sprintf('select a.appID, g.gangID, g.gangNAME from applications as a
		left join gangs as g on a.appGANG = g.gangID
		where appUSER = %d', $gvars->userid);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>You don't have any pending applications.</h3>"; return;
	}
	$app_list = '';
	while (list($app_id, $gang_id, $gang_name) = mysql_fetch_row($q_get)) {
		$gang_name = gang_get_gang_link($gang_id, $gang_name);
		$app_list .= <<<EOT
		<tr>
			<td>
			$gang_name
			</td>
			<td class="center">
			<a href="gangs.php?action=gang_app_cancel&app_id=$app_id">Cancel</a>
			</td>
		</tr>
EOT;
	}
	echo <<<EOT
	<h2>My Applications</h2>
	<table style="width: 300px">
		<tr>
			<th>
			$gvars->name_su
			</th>
			<th>
			Link
			</th>
		</tr>
$app_list
	</table>
EOT;
}

function gang_app_cancel() {
	global $gvars;
	
	if (!isset($_REQUEST['app_id']) or intval($_REQUEST['app_id']) < 1) {
		echo "<h3>Which application are you cancelling?</h3>"; gang_go_back('gangs.php?action=gang_my_apps'); return;
	}
	$app_id = intval($_REQUEST['app_id']);
	// appID, appUSER, appGANG, appTEXT <<< applications
	$q_get = sprintf('select a.appID, g.gangID, g.gangNAME from applications as a
		left join gangs as g on a.appGANG = g.gangID
		where appUSER = %d and appID = %d', $gvars->userid, $app_id);
	$q_get = mysql_query($q_get);
	if (!$q_get or mysql_num_rows($q_get) < 1) {
		echo "<h3>Which application are you cancelling?</h3>"; gang_go_back('gangs.php?action=gang_my_apps'); return;
	}
	list($app_id, $gang_id, $gang_name) = mysql_fetch_row($q_get);
	$gang_name = gang_get_gang_link($gang_id, $gang_name);
	
	$q_del = sprintf('delete from applications where appUSER = %d and appID = %d', $gvars->userid, $app_id);
	mysql_query($q_del);
	
	if (mysql_affected_rows() < 1) {
		echo "<h3>The application could not be deleted.</h3>";
	} else {
		$gang_link = gang_get_gang_link($gang_id, $gang_name);
		echo "<h3>Your application to $gang_link has been deleted.</h3>";
	}
	gang_go_back('gangs.php?action=gang_my_apps');
}

if (!$gvars->ir['gang']) {
	echo <<<EOT
<p class="center"><a href="gangs.php?action=gang_create">Click here</a> to create a new $gvars->name_sl</p>
EOT;
}












