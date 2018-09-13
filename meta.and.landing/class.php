<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

class AdvantikaMETAandLandingComponent extends CBitrixComponent
{
    /**
     * проверяет подключение необходиимых модулей
     * @throws LoaderException
     */
    protected function checkModules()
    {
        if (!Main\Loader::includeModule('iblock'))
            throw new Main\LoaderException(Loc::getMessage('STANDARD_ELEMENTS_LIST_CLASS_IBLOCK_MODULE_NOT_INSTALLED'));
    }
    /**
     * страница шаблона
     * @var string
     */
    protected $page = '';

    /**
     * переопределение параметров
     */
    protected function setSefDefaultParams()
    {
        $this->arParams['CACHE_TYPE'] = 'N';
        $this->arParams['~CACHE_TYPE'] = 'N';
    }

    /**
     * получение результатов
     */
    protected function getResult()
    {
        $pages = array();
        $linksElements = $this->_getInfoByCity(array('NAME','PROPERTY_LINKS_FOOTER','PROPERTY_LINKS_TEXTS'));
        while($ar_result = $linksElements->GetNext()){
            $pages[$ar_result['NAME']]['footer'][] = $ar_result['PROPERTY_LINKS_FOOTER_VALUE'];
            $linksTexts = explode("\n", $ar_result['PROPERTY_LINKS_TEXTS_VALUE']['TEXT']);
            $pages[$ar_result['NAME']]['links'] = $linksTexts;
        }
        $pageURL = strtok($_SERVER['REQUEST_URI'], '?');
        if (isset($pages[$pageURL])){
            $footers = $pages[$pageURL]['footer'];
            $landing =  $footers[0];
        }
        else{
            $key = array_rand($pages);
            $links = $pages[$key]['links'];
            $link = preg_replace('/#([^#]+)#/', "<a href='".$key."'>\\1</a>", $links[array_rand($links)]);
            $landing = $link;
        }
        $this->arResult = $landing;
    }

    /**
     * выполняет действия после выполения компонента
     */
    protected function executeEpilog()
    {
        global $APPLICATION;

        $dbMetaInfo = $this->_getInfoByCity(array('PROPERTY_KEYWORDS','PROPERTY_TITLE','PROPERTY_H1','PROPERTY_DESCRIPTION'), true);
        while($ar_result = $dbMetaInfo->GetNext()){
            $APPLICATION->SetPageProperty('description', $ar_result['PROPERTY_DESCRIPTION_VALUE']['TEXT']);
            $APPLICATION->SetPageProperty('keywords', $ar_result['PROPERTY_KEYWORDS_VALUE']['TEXT']);
            $APPLICATION->SetTitle($ar_result['PROPERTY_H1_VALUE']);
            $APPLICATION->SetPageProperty('title', $ar_result['PROPERTY_TITLE_VALUE']);
            
        }
    }

    /**
     * Выборка нужной информации по городу
     *
     * @param array $params - массив параметров, которые надо выбрать (в формате arSelectFields для CIBlockElement::GetList)
     * @param bool $checkURL - флаг, проверять ли по текущему адресу страницы
     * @return CIBlockResult|int - результат выполнения запроса (как у CIBlockElement::GetList)
     */
    protected function _getInfoByCity($params = array(), $checkURL = false)
    {
        $cityCode = strtok($_SERVER['HTTP_HOST'], '.');
        //домены склеены, костыль получен.
        if($cityCode == 'www')
            $cityCode = 'khab';
        $filterParams = array(
            'IBLOCK_ID' => $this->arParams['IBLOCK_ID'],
            'SECTION_CODE' => 'khab',
            'ACTIVE'=>'Y'
        );

        if($checkURL)
            $filterParams['NAME'] = strtok($_SERVER['REQUEST_URI'], '?');

        return CIBlockElement::GetList(array(),$filterParams,false,false,$params);
    }

    /**
     * выполняет логику работы компонента
     */
    public function executeComponent()
    {
        try {
            $this->checkModules();
            $this->setSefDefaultParams();
            $this->getResult();
            $this->includeComponentTemplate($this->page);
            $this->executeEpilog();
        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
    }
}