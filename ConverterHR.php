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
global $USER;
global $DB;

\Bitrix\Main\Loader::includeModule('iblock');
CModule::IncludeModule('humanresources');

//STEP 1: Prepare and insert users
//Step 1.1: Init module HR (Same as install humanresources module)
$a = Bitrix\HumanResources\Access\Install\AccessInstaller::installAgent();
$b = Bitrix\HumanResources\Compatibility\Converter\StructureBackwardConverter::startDefaultConverting();
$c = Bitrix\HumanResources\Install\Stepper\UpdateSortAndActiveFieldsStepper::checkDefaultConverting();

//Step 1.2: b_hr_structure_node_member - REMOVE UNIQUE INDEX on NODE_ID!
$zapr = "ALTER TABLE b_hr_structure_node_member DROP INDEX UX_B_HR_NODE_MEMBER_NODE_ID_ENTITY_TYPE_ENTITY_ID";
$result = $DB->query($zapr);

//Step 1.3: Searh max ID from b_user table
$lastID = Bitrix\Main\UserTable::getList(['select' => ['ID'], 'filter' => ['ACTIVE' => 'Y'], 'order' => ['ID' => 'DESC']])->fetch()['ID'];

//Step 1.4: Prepare user converter class
$strEmploee = new  \Bitrix\HumanResources\Compatibility\Converter\UserBackwardConverter();
for ($i = 1; $i <= $lastID; $i++) {
    $user = Bitrix\Main\UserTable::GetByID($i)->fetch();

    //not bots
    if ($user['PERSONAL_BIRTHDAY']||$user['PERSONAL_BIRTHDATE'] || $user['PERSONAL_PHOTO'] || $user['PERSONAL_PHONE'] || $user['WORK_PHONE'] || $user['PERSONAL_GENDER'])
    //Step 1.5: user to b_hr_* tables
        $strEmploee->convert($i);
}

//STEP 2 - INSERT HEADERS
$arSection = [];
$arSections = CIBlockSection::GetList([], ['IBLOCK_ID' => 3, 'ACTIVE' => 'Y'], false, ['ID', 'NAME', 'UF_*']);
while ($item = $arSections->fetch()) $arSection[] = $item;

foreach ($arSection as $one)
    //Not root headers
    if ($one['UF_HEAD'] > 0) {

        //Step 2.1: Search dep. node by name
        $zapr = "select ID from b_hr_structure_node WHERE NAME='" . $one['NAME'] . "'";
        echo "<BR>QUERY1 [" . $zapr . "]";
        $result = $DB->query($zapr);
        while ($item = $result->fetch()) {
            if ($item['ID'] > 0 && $one['UF_HEAD'] > 0) {
                //Step 2.2: Fill node
                $zapr2 = "update b_hr_structure_node_member SET NODE_ID ='" . $item['ID'] . "' where ENTITY_ID=" . $one['UF_HEAD'] . ' ORDER BY ID DESC LIMIT 1';
                echo "<BR>QUERY2 [" . $zapr2 . "]";
                $result2 = $DB->query($zapr2);

                //Step 2.3 Save Header
                $zapr3 = "select ID from b_hr_structure_node_member where ENTITY_ID='" . $one['UF_HEAD'] . "'";
                echo "<BR>QUERY3 [" . $zapr3 . "]";
                $result3 = $DB->query($zapr3)->fetch();

                //Step 2.4 Save role
                $zapr4 = "update b_hr_structure_node_member_role SET ROLE_ID=1 where MEMBER_ID=" . $result3['ID'];
                echo "<BR>QUERY4 [" . $zapr4 . "]<BR><BR>";
                $result4 = $DB->query($zapr4);
                break;
            }
            break;//next department
        }
    }

//Root header set manualy
