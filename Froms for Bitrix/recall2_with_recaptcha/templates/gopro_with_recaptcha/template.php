<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();

if($arResult['LAST_ERROR']!='') {
	ShowError( $arResult["LAST_ERROR"] );
}

if($arResult['GOOD_SEND']=='Y') {
	ShowMessage( array('MESSAGE'=>$arParams['ALFA_MESSAGE_AGREE'],'TYPE'=>'OK') );
	?>
    <script>
        dataLayer.push({
            'event':'adv.event',
            'eventCategory':'formSubmit',
            'eventAction':'sendCall',
            'eventLabel':''
        });
    </script>

<?}

?><div class="someform clearfix asdf"><?
	
	?><form action="<?=$arResult['ACTION_URL']?>" method="POST"><?
		
		?><?=bitrix_sessid_post()?><?
		?><input type="hidden" name="<?=$arParams['REQUEST_PARAM_NAME']?>" value="Y" /><?
		?><input type="hidden" name="PARAMS_HASH" value="<?=$arResult['PARAMS_HASH']?>"><?
		
		foreach($arResult['FIELDS'] as $arField) {
			if($arField['SHOW']=='Y') {
				?><div class="line clearfix"><?
					if($arField['CONTROL_NAME']!='RS_AUTHOR_COMMENT') {
						?><input<?if($arField['CONTROL_NAME']=='RS_AUTHOR_PHONE'):?> class="maskPhone"<?endif;?> type="text" name="<?=$arField['CONTROL_NAME']?>" value="<?=$arField['HTML_VALUE']?>" placeholder="<?=GetMessage('MSG_'.$arField['CONTROL_NAME'])?><?if(in_array($arField['CONTROL_NAME'], $arParams['REQUIRED_FIELDS'])):?>*<?endif;?>:" /><?
					} else {
						?><textarea name="<?=$arField['CONTROL_NAME']?>" placeholder="<?=GetMessage('MSG_'.$arField['CONTROL_NAME'])?><?if(in_array($arField['CONTROL_NAME'], $arParams['REQUIRED_FIELDS'])):?>*<?endif;?>:"><?=$arField['HTML_VALUE']?></textarea><?
					}
				?></div><?
			}
		}
		
		?><div class="g-recaptcha" data-sitekey="6LcTJVkUAAAAADRifUrg_Bd8wH1TJYwdCR8vGRj4"></div><?
		?><div class="line buttons clearfix"><?
			?><input class="btn btn1" type="submit" name="submit" value="<?=GetMessage('MSG_SUBMIT')?>"><?
		?></div><?

		
	?></form><?
	?><script src="https://www.google.com/recaptcha/api.js" async defer></script><?
	?><script>
		$('.btn1').click(function(){
			setTimeout(() => {
			  grecaptcha.reset();
			}, 3000)
		})
	</script><?
?></div>