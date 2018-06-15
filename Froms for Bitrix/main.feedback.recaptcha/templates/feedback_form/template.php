<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
?>
<div class="mfeedback">
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if(strlen($arResult["OK_MESSAGE"]) > 0)
{
	?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
}
?>

<form action="<?=POST_FORM_ACTION_URI?>" method="POST">
<?=bitrix_sessid_post()?>
	<div class="mf-name">
		<!-- <div class="mf-text">
			<?=GetMessage('MFT_NAME')?><?if(empty($arParams['REQUIRED_FIELDS']) || in_array('NAME', $arParams['REQUIRED_FIELDS'])):?><span class='mf-req'>*</span><?endif?>
		</div> -->
		<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>" placeholder="<?=GetMessage('MFT_NAME')?><?if(empty($arParams['REQUIRED_FIELDS']) || in_array('NAME', $arParams['REQUIRED_FIELDS'])):?>*<?endif?>">
	</div>
	<div class="mf-phone">
		<!-- <div class="mf-text">
			<?=GetMessage("MFT_PHONE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div> -->
		<input type="text" name="user_phone" value="<?=$arResult["AUTHOR_PHONE"]?>" placeholder="<?=GetMessage("MFT_PHONE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("PHONE", $arParams["REQUIRED_FIELDS"])):?>*<?endif?>">
	</div>
	<div class="mf-email">
		<!-- <div class="mf-text">
			<?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div> -->
		<input type="text" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" placeholder="<?=GetMessage("MFT_EMAIL")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])):?>*<?endif?>">
	</div>

	<div class="mf-message">
		<!-- <div class="mf-text">
			<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div> -->
		<textarea name="MESSAGE" placeholder="<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?>*<?endif?>"><?=$arResult["MESSAGE"]?></textarea>
	</div>

	<div class="g-recaptcha" data-sitekey="6LcTJVkUAAAAADRifUrg_Bd8wH1TJYwdCR8vGRj4"></div>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
	<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
</form>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</div>