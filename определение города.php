<?php

// получаем ip
$ip = $_SERVER['REMOTE_ADDR'];

// получаем данные о ip
$url = 'http://ipgeobase.ru:7020/geo?ip='.$ip;
$xml = new DOMDocument();
if ($xml->load($url)){
$result = array();
$root = $xml->documentElement;
$result = array(
'country' => $root->getElementsByTagName('country')->item(0)->nodeValue,
'region'	=> $root->getElementsByTagName('region')->item(0)->nodeValue,
'city' => $root->getElementsByTagName('city')->item(0)->nodeValue,
'district' => $root->getElementsByTagName('district')->item(0)->nodeValue
);
}

//print_r($result['city']);

$city = $result['city'];



// выводим контакты относительно выбранного города
switch ($city) {
    case ("Хабаровск"):?>
        <div class="">ПРивет</div>
        <?
        break;
    case ("Иркутск"):
        echo "city = Иркутск";
        break;
    case ("Чита"):
        echo "city = Чита";
        break;

        default:
       echo "Все контактные данные";
               break;
}



// $id = 47;  
//    $db = JFactory::getDBO();
//    $sql = "SELECT introtext,fulltext FROM #__content WHERE id=".$id;
//    $db->setQuery($sql);
//    $item = $db->loadAssoc();
// print_r($item);

?>