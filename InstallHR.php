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
include $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/humanresources/install/index.php";
$a=new HumanResources();
$a->doInstall();
