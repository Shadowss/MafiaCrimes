<?php



if (!defined('GANG_MODULE')) {
	return; 
}

/**
 * Check a user against one gang rank.
 *
 * @param int $userid
 * @param string $rank
 * @return bool
 */
function gang_auth($userid, $rank) {
	global $gvars;
	switch ($rank) {
		case 'pres':
			return $userid == $gvars->data['gangPRESIDENT'];
			break;
		case 'vice':
			return $userid == $gvars->data['gangVICEPRES'];
			break;
		default:
			return true;
			break;
	}
}

/**
 * Check a user against multiple gang ranks.
 * This function calls gang_auth() once for each rank checked.
 * It returns true if any of the ranks validated. In other words,
 * this performs a logical OR comparison.
 *
 * @param int $userid
 * @param array $ranks
 * @return bool
 */
function gang_auth_all($userid, $ranks) {
	global $gvars;
	if (!is_array($ranks)) {
		$ranks = array($ranks);
	}
	foreach ($ranks as $rank) {
		if (gang_auth($userid, $rank)) {
			return true;
		}
	}
	return false;
}


if (gang_auth_all($gvars->userid, array('pres', 'vice'))) {
	$gvars->tabs += array(
		'sgang_home' => 'Staff',
	);
	$gvars->links_mygang += array(
		'sgang_home' => array(
			'label' => 'Staff Room',
			'order' => 7
		),
	);
}