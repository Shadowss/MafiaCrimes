<?php
include "globals.php";


define('GANG_MODULE', true, true);

// gangID, gangNAME, gangDESC, gangPREF, gangSUFF, gangMONEY, gangCRYSTALS, gangRESPECT, gangPRESIDENT, gangVICEPRES, gangCAPACITY, gangCRIME, gangCHOURS, gangAMENT

include('./gangs/config.php');
$gvars = new GangVars();
$gvars->setPage('public');
include('./gangs/content.php');
$h->endpage();



























