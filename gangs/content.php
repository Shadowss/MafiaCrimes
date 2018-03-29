<?php


if (!defined('GANG_MODULE')) {
	// Don't die() because we can toss control back to the including file. :O
	// But if this file is accessed directly, this counts as a die().
	return; 
}

function gang_include_plugins() {
	global $gvars;
	if ($gvars->page === $gvars->page_values->private) {
		$dir = './gangs/plugins/private/';
//	} else if ($gvars->page === $gvars->page_value->public) {
//		$dir = './gangs/plugins/public/';
	} else {
		$dir = './gangs/plugins/public/';
	}
	
	$dh  = opendir($dir);
	while (false !== ($filename = readdir($dh))) {
		if (strlen(str_replace('.', '', $filename)) > 0 and $filename !== 'index.html') {
			include($dir . $filename);
		}
	}
}

/**
 * This function loads the actual plugin function requested by the user
 *
 */
function gang_load_plugin_function() {
	global $gvars;
	if (isset($_REQUEST['action'])) {
		_gang_load_plugin_function($_REQUEST['action']);
	} else if ($gvars->page === $gvars->page_values->public) {
		_gang_load_plugin_function('gang_list');
	} else if ($gvars->page === $gvars->page_values->private and $gvars->ir['gang']) {
		_gang_load_plugin_function('gang_your_gang');
	}
}

function _gang_load_plugin_function($action) {
	global $gvars;
	if (isset($gvars->actions[$action])) {
		$gvars->actions[$action]();
	}
}

function gang_generate_tabs() {
	global $gvars;
	$tabs = '';
	if ($gvars->page === $gvars->page_values->public) {
		$url = 'gangs.php';
	} else {
		$url = 'yourgang.php';
	}
	foreach ($gvars->tabs as $action => $label) {
		$tabs .= <<<EOT
			<span class="gang-tab">
				<a class="gang-tab-content" href="$url?action=$action">$label</a>
			</span>\n
EOT;
	}
	return $tabs;
}

function gang_generate_page($content) {
	global $gvars;
	
	if ($gvars->page === $gvars->page_values->private) {
		$title = <<<EOT

    <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h1 style='padding-top:10px;'> <a href="yourgang.php">Your Gang - {$gvars->data['gangNAME']}</a></h1></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
    
EOT;
	} else {
		$title = <<<EOT
        
        <div class='generalinfo_txt'>
<div><img src='images/info_left.jpg' alt='' /></div>
<div class='info_mid'><h1 style='padding-top:10px;'> <a href="gangs.php">$gvars->name_pu</a></h1></div>
<div><img src='images/info_right.jpg' alt='' /></div> </div>
<div class='generalinfo_simple'><br> <br><br>
        
EOT;
		
	}
	
	$tabs = gang_generate_tabs();
	$styles = gang_get_css_styles();
	
	$page = <<<EOT
$styles
<div id="gangPage">
$title
	<div class="gang-tabs">
		<div class="gang-tabs-content">
$tabs
		</div>
	</div>

$content

</div><div><img src='images/generalinfo_btm.jpg' alt='' /></div><br></div></div></div></div></div>

EOT;
	return $page;
}

function gang_determine_page_specific_accessibility() {
	global $gvars;
	if ($gvars->page === $gvars->page_values->private) {
		if (!$gvars->ir['gang']) {
			echo <<<EOT
<h3>You are not in a gang.</h3>
<p><a href="gangs.php">Click here</a> to go to the gang list.</p>
EOT;
			return false;
		}
//	} else if ($gvars->page === $gvars->page_value->public) {
//		$dir = './gangs/plugins/public/';
	}
	return true;
}

function gang_get_css_styles() {
	global $gvars;
	return <<<EOT
<style>
#gangPage {
	width: 600px;
	margin: 0 auto;
}
#gangPage h1,
#gangPage h2,
#gangPage h3 {
	text-align: center;
}
#gangPage p {
	margin: 0;
	padding: 5px 0;
	width: 100%;
}
#gangPage table {
	margin: 6px auto;
}
#gangPage th {
	background-color: $gvars->color_bg;
	font-weight: bold;
	text-align: center;
}
#gangPage ul,
#gangPage ul li {
	list-style-type: none;
}
#gangPage li {
	padding: 2px;
}
#gangPage input,
#gangPage textarea,
#gangPage select {
	border: 1px solid #35391e;
	background-color: #ababab;
	font-weight: normal;
}
#gangPage input[type="submit"] {
	cursor: pointer;
}
#gangPage .bold {
	font-weight: bold;
}
#gangPage .center {
	text-align: center;
}
#gangPage .left {
	text-align: left;
}
#gangPage .right {
	text-align: right;
}
#gangPage .gang-tabs {
	margin: 0 auto;
	width: 400px;
	height: 24px;
	background-color: #34381d;
}
#gangPage .gang-tabs-content {
	height: 100%;
	border: 1px solid $gvars->color_border;
}
#gangPage .gang-tab {
	height: 100%;
	display: inline-block;
}
#gangPage .gang-tab-content {
	padding: 4px 10px;
	display: inline-block;
}
#gangPage .gang-tab-content {
	padding: 4px 10px;
	display: inline-block;
	color: #ffffff;
	font-weight: bold;
	font-size: 108%;
}
#gangPage .gang-tab-content:hover {
	background-color: #000000;
	text-decoration: none;
}
#gangPage .gang_letter {
	display: block;
	height: 14px;
	width: 14px;
	float: left;
	border: 1px solid $gvars->color_border;
	background-color: #34381d;
	color: #ffffff;
	margin: 0 1px;
	text-align: center;
	font-weight: bold;
}
#gangPage .gang_letter:hover,
#gangPage .gang_letter.selected {
	background-color: $gvars->color_bg;
	color: #000000;
}


#gangPage .ygang_menu th,
#gangPage th.ygang_menu,
#gangPage td.ygang_menu {
	height: 18px;
	padding: 0;
}
#gangPage .ygang_menu th a,
#gangPage th.ygang_menu a,
#gangPage td.ygang_menu a {
	display: block;
	height: 18px;
	padding: 4px;
	line-height: 18px;
	text-align: center;
}
#gangPage .ygang_menu th a:hover,
#gangPage th.ygang_menu a:hover,
#gangPage td.ygang_menu a:hover {
	background-color: #000000;
	text-decoration: none;
	color: #ffffff;
}
#gangPage .gang_forum_post {
	border: 1px solid #34381D;
	border-bottom: none;
}
#gangPage .gang_forum_reply {
	border: 1px solid #35391e;
	background-color: #ababab;
	font-weight: normal;
	display: block;
	height: 18px;
	width: 50px;
	line-height: 18px;
	text-align: center;
}
#gangPage .gang_forum_spacer {
	font-size: 0px;
	height: 2px;
	background-color: #34381D;
}
#gangPage .gang_forum_hr {
	border: 1px solid #34381D;
}
// border d2ae04
// bg 34381d
</style>
EOT;
}

if (!gang_determine_page_specific_accessibility()) {
	return;
}
ob_start();
gang_include_plugins();
gang_load_plugin_function();
$content = ob_get_clean();
$page = gang_generate_page($content);
echo $page;