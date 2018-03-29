<?php


if (!defined('GANG_MODULE')) {
	return; 
}

################################
### The code below works     ###
### like the standard        ###
### switch/case blocks       ###
### that are used            ###
### to match $_GET['action'] ###
### to a function name       ###
################################


/*	Use this to add new tabs.
	action => tab label

$gvars->tabs += array(
	'gang_foo' => 'Foo',
);
*/

/*	Us this to allow new functions to be linked to in urls.
	action => function name

$gvars->actions += array(
	'gang_foo' => 'gang_foo',
	'gang_bar' => 'gang_bar',
);
*/

/*	If you need "my gang page" menu links, use this:

$gvars->links_mygang += array(
	'ygang_summary' => array(
		'label' => 'Summary',
		'order' => 1
	), 'ygang_donate' => array(
		'label' => 'Donate',
		'order' => 2
	),
);
*/

/*	If you need "gang staff page" menu links, use this:

$gvars->links_staff += array(
	'sgang_vault' => array(
		'label' => 'Vault Management',
		'order' => 1
	), 'sgang_leadership' => array(
		'label' => 'Manage Leadership',
		'order' => 2
	),
);
*/
##########################
### END OF SWITCH/CASE ###
##########################