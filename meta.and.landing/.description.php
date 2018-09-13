<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);

$arComponentDescription = array(
	"NAME" => Loc::getMessage('ADVANTIKA_META_DESCRIPTION_NAME'),
	"DESCRIPTION" => Loc::getMessage('ADVANTIKA_META_DESCRIPTION_DESCRIPTION'),
	"ICON" => '/images/icon.gif',
	"SORT" => 10,
	"PATH" => array(
		"ID" => 'Advantika',
		"NAME" => Loc::getMessage('ADVANTIKA_META_DESCRIPTION_GROUP'),
		"SORT" => 10,
		"CHILD" => array(
			"ID" => 'standard',
			"NAME" => Loc::getMessage('ADVANTIKA_META_DESCRIPTION_DIR'),
			"SORT" => 10
		)
	),
);

?>