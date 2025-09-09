<?php
$_SERVER['DOCUMENT_ROOT'] = '/home/bitrix/www';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

define("NO_KEEP_STATISTIC", true);
define("STOP_STATISTICS", true);
define("NO_AGENT_STATISTIC", "Y");
define("NOT_CHECK_PERMISSIONS", true);
define("BX_NO_ACCELERATOR_RESET", true);
define("DisableEventsCheck", true);
define("NO_AGENT_CHECK", true);

@set_time_limit(0);
@ignore_user_abort(true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
///////////////////////////////////// from this place you may insert code to PHP command tool in Bitrix admin panel
global $DB;

//Step 1: Delete HR module from tables
$zapr = "delete FROM 'b_module_to_module' where TO_CLASS like '%uman%' and TO_CLASS like '%esources%'";
$result = $DB->query($zapr);

$zapr = "delete FROM 'b_module' where ID like '%uman%' and ID like '%esources%'";
$result = $DB->query($zapr);

$zapr = "delete FROM 'b_agent' where NAME like '%uman%' and NAME like '%esources%'";
$result = $DB->query($zapr);

//Step 2: Install HR module from tables
include $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/humanresources/install/index.php";
$a=new HumanResources();
$a->doInstall();
