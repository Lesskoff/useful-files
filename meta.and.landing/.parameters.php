<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__);
$arIBlocks = array();
$db_iblock = CIBlock::GetList(
	array("SORT"=>"ASC"),
	array(
		"SITE_ID"=>$_REQUEST["site"],
		"TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")
	)
);
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = $arRes["NAME"];
try
{
	$arComponentParameters = array(
		'GROUPS' => array(
            'CONTAINER_PARAMETERS'=>array(
                'NAME' => GetMessage('ADVANTIKA_META_PARAMETERS_GROUP_CONTAINER_PARAMETERS'),
            ),
		),
		'PARAMETERS' => array(
			"IBLOCK_ID" => array(
				"PARENT" => "BASE",
				"NAME" => GetMessage("ADVANTIKA_META_PARAMETERS_IBLOCK"),
				"TYPE" => "LIST",
				"VALUES" => $arIBlocks,
				"DEFAULT" => '',
				"ADDITIONAL_VALUES" => "Y",
				"REFRESH" => "Y",
			),
		)
	);
}
catch (Main\LoaderException $e)
{
	ShowError($e -> getMessage());
}
?>