<?php

use Bitrix\Main\Config\Option;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;


CModule::IncludeModule('highloadblock');
require_once($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/const.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/config.php");

// Подключаем функции
if (file_exists(__DIR__.'/include/function.php')) {
    require __DIR__.'/include/function.php';
}

// Настройки сайта из админки
$BXK_OPTIONS = Option::getForModule('bxk_setting');
function GetEntityDataClass($HlBlockId)
{
    if (empty($HlBlockId) || $HlBlockId < 1) {
        return false;
    }
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class;
}
function searchForId($id, $array) {

    foreach ($array as $key => $val) {
        ps($val);
        if ($val['CODE'] == $id) {
            return $key;
        }
    }
    return null;
}
function GetImageFromUrl($link)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function convertImage($originalImage, $outputImage, $quality)
{
    // jpg, png, gif or bmp?
    $exploded = explode('.', $originalImage);
    $ext = $exploded[count($exploded) - 1];

    if (preg_match('/jpg|jpeg/i', $ext))
        $imageTmp = imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i', $ext))
        $imageTmp = imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i', $ext))
        $imageTmp = imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i', $ext))
        $imageTmp = imagecreatefrombmp($originalImage);
    else
        return 0;

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}

function RotateJpg($filename = '', $angle = 0, $savename = false, $type = 'image/jpeg', $matches = array(), $rerun = 0)
{
    if (empty($filename)) die('photo is empty');

    if ($rerun > 3) die('photo error');

    $rerun++;
    if (!empty($matches[0])) {
        $type = str_replace('data:', "", $matches[0]);
    }

    if ($type == 'image/png') {
        $source = imagecreatefrompng($filename);
        if (!$source) {
            RotateJpg($filename, $angle, $savename, 'image/jpeg', $rerun);
        }

        $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
        if (!$bgColor) {
            RotateJpg($filename, $angle, $savename, 'image/jpeg', $rerun);
        }

        $rotate = imagerotate($source, $angle, $bgColor);
        if (!$rotate) {
            RotateJpg($filename, $angle, $savename, 'image/jpeg', $rerun);
        }

        imagesavealpha($rotate, true);
        if (!imagepng($rotate, $savename)) {
            RotateJpg($filename, $angle, $savename, 'image/jpeg', $rerun);
        }

        imagedestroy($rotate);
    } else {
        $imageTmp = imagecreatefromjpeg($filename);

        imagejpeg($imageTmp, $filename, 100);

        if (!empty($imageTmp)) imagedestroy($imageTmp);

        $original = imagecreatefromjpeg($filename);

        if (!$original) {
            RotateJpg($filename, $angle, $savename, 'image/png', $rerun);
        }

        $rotated = imagerotate($original, $angle, 0);
        if (!$rotated) {
            RotateJpg($filename, $angle, $savename, 'image/png', $rerun);
        }

        if (!imagejpeg($rotated, $savename)) {
            RotateJpg($filename, $angle, $savename, 'image/png', $rerun);
        }
        if (!empty($imageTmp)) imagedestroy($rotated);
    }
}

function getFileIdBySrc($strFilename)
{
    $strUploadDir = '/' . \Bitrix\Main\Config\Option::get('main', 'upload_dir') . '/';
    $strFile = substr($strFilename, strlen($strUploadDir));
    $strSql = "SELECT ID FROM b_file WHERE CONCAT(SUBDIR, '/', FILE_NAME) = '{$strFile}'";
    return \Bitrix\Main\Application::getConnection()->query($strSql)->fetch()['ID'];
}


function ps($array)
{
    ?>
    <script>console.log(<?=json_encode($array)?>)</script>
    <?php
}

function sort_date($a_new, $b_new)
{

    $a_new = strtotime($a_new['PROPERTIES']['TIME_RAISE']['VALUE']);
    $b_new = strtotime($b_new['PROPERTIES']['TIME_RAISE']['VALUE']);

    return $b_new - $a_new;

}

$GLOBALS['arSetting'] = array(
    's1' => array(
        'lang' => 'ru',
        'lang_print' => 'Rus',
        'href' => '/',
    ),
    's2' => array(
        'lang' => 'en',
        'lang_print' => 'Eng',
        'href' => '/en/',
    ),
    's3' => array(
        'lang' => 'heb',
        'lang_print' => 'Heb',
        'href' => '/heb/',
    ),
);

// Выбор vip объявлений для главной
function getVipADMain()
{
    $arSelect = array("ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_PRICE", "SHOW_COUNTER", "DATE_CREATE", "DETAIL_PAGE_URL", "PROPERTY_TYPE_TAPE");
    $arFilter = array("IBLOCK_ID" => IBLOCK_ID_AD, "ACTIVE" => "Y", ">=PROPERTY_VIP_DATE" => date('Y-m-d H:i:s'));
    $res = CIBlockElement::GetList(array('TIMESTAMP_X' => 'DESC'), $arFilter, false, array("nTopCount" => 2), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        print_r($arFields);
    }
}

// Вывод даты в строку (вчера, сегодня)
function getStringDate($date)
{
    $date_time = explode(' ', $date);
    $date = strtotime($date_time[0]);
    $yesterday = strtotime("-1 day", strtotime(date("d.m.Y", time())));
    $today = strtotime(date("d.m.Y", time()));
    if ($date == $today) {
        return array(
            'MES' => 'TODAY',
            'HOURS' => substr($date_time[1], 0, 5),
        );
    }
    if ($date == $yesterday) {
        return array(
            'MES' => 'YESTERDAY',
            'HOURS' => substr($date_time[1], 0, 5),
        );
    } else {
        return array(
            'MES' => '',
            'HOURS' => $date_time[0],
            'MIN' => $date_time[1],
        );
    }
}

// Получаем ID автора объявления
function getIDAutorAd($IDAd)
{
    CModule::IncludeModule('iblock');

    $arSelect = array("ID", "IBLOCK_ID");
    $arFilter = array("ID" => (int)$IDAd);

    $res = CIBlockElement::GetList(array(), $arFilter, false, array("nTopCount" => 1), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
        return $arProps['ID_USER']['VALUE'];
    }
}

/**
 * Ресайз картинок
 *
 * $id - ID картинки
 * $width - нужная ширина картинки
 * $height - нужная высота картинки
 * $type - тип ресайза
 * */
function resizeImg($id, $width, $height, $type = 0)
{
    $id = intval($id);
    $width = intval($width);
    $height = intval($height);
    $type = intval($type);

    if (!$id) {
        return false;
    }

    $fileArray = CFile::GetFileArray($id);
    if ($fileArray['HEIGHT'] > $fileArray['WIDTH'] && $type === 2) {
        $type = BX_RESIZE_IMAGE_PROPORTIONAL_ALT;
        $w = $width;
        $width = $height;
        $height = $w;
        unset($w);
    } else {
        if ($type === 1) {
            $type = BX_RESIZE_IMAGE_PROPORTIONAL;
        } else {
            $type = BX_RESIZE_IMAGE_EXACT;
        }
    }

    $picture = CFile::ResizeImageGet(
        $id,
        array(
            'width' => $width,
            'height' => $height
        ),
        $type
    );
    if ($picture) {
        return $picture['src'];
    } else {
        return false;
    }
}

/*
 * array(
      'select' => array('ID','UF_NAME','UF_MESSAGE','UF_DATETIME'),
      'order' => array('ID' => 'ASC'),
      'limit' => '50',
   )
 * */

function getHighloadInfo($hlblock_id, $arSelect)
{
    Loader::includeModule("highloadblock");

    $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();

    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    $rsData = $entity_data_class::getList($arSelect);

    while ($arData = $rsData->Fetch()) {
        $result[] = $arData;
    }

    return $result;

}

function addHLItem($hlblock_id, $arData)
{
    Loader::includeModule("highloadblock");

    $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();

    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    return $entity_data_class::add($arData);
}

function delHlItem($hlblock_id, $IDItem)
{
    Loader::includeModule("highloadblock");

    $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();

    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    return $entity_data_class::Delete($IDItem);
}

function UpdateHlItem($hlblock_id, $IDItem, $arData)
{
    Loader::includeModule("highloadblock");

    $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();

    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    return $entity_data_class::update($IDItem, $arData);
}

// Получаем Избранные объявления пользователя
function getFavoritesUser($IDUser)
{
    $result = array();
    $params = array(
        'select' => array('*'),
        'filter' => array('UF_ID_USER' => $IDUser)
    );
    $info = getHighloadInfo(FAVORITES_HL_ID, $params);

    foreach ($info as $item) {
        $result[] = $item['UF_ID_AD'];
    }
    return $result;

}

// Получаем название раздела и ссылку на раздел для объявления
function getSectionInfo($sectionID, $iblockID)
{
    $arFilter = array('IBLOCK_ID' => $iblockID, 'ID' => $sectionID);
    $db_list = CIBlockSection::GetList(array(), $arFilter, false, array('NAME', 'SECTION_PAGE_URL'));
    while ($ar_result = $db_list->GetNext()) {
        return $ar_result;
    }
}

// Получаем данные пользователя
function getUserInfoByID($IDUser = false)
{
    global $USER;

    if (!$IDUser)
        $IDUser = $USER->GetID();

    $rsUser = CUser::GetByID($IDUser);
    $arUser = $rsUser->Fetch();
    return $arUser;
}

// Получаем данные пользователя по ID
function getUserInfo($IDUser)
{
    $rsUser = CUser::GetByID((int)$IDUser);
    $arUser = $rsUser->Fetch();
    return $arUser;
}

// Добавление сообщения
function addMessage($IDAutor, $IDUser, $IDAd, $message, $files = array())
{
    $params = array(
        'UF_AUTOR_ID' => (int)$IDAutor,
        'UF_ID_USER' => (int)$IDUser,
        'UF_DATE' => time(),
        'UF_ID_AD' => (int)$IDAd,
        'UF_MESSAGE' => strip_tags($message),
        'UF_FILES' => $files,
    );

    /*if($files)
    {
        foreach($files as $file)
        {
            $params['UF_FILES'][] = CFile::MakeFileArray($file);
        }
    }*/
    $hl = addHLItem(7, $params);
    return $hl->getId();
}

// Прочитать все сообщения пользователя в чате
function readAllMessageInChat($IDAd, $IDAutor)
{
    $params = array(
        'select' => array(
            'ID',
            'UF_DATE_BLOCK',
            'UF_READ'
        ),
        'filter' => array(
            'UF_ID_AD' => (int)$IDAd,
            'UF_AUTOR_ID' => (int)$IDAutor
            //'LOGIC' => 'OR',
            //array('UF_AUTOR_ID' => (int)$IDAutor),
            //array('UF_ID_USER' => (int)$IDAutor),
        )

    );

    $IDmessages = getHighloadInfo(7, $params);
    if ($IDmessages) {
        foreach ($IDmessages as $mess) {
            if ($mess['UF_DATE_BLOCK'])
                break;
            if ($mess['UF_READ'] == 1)
                continue;

            UpdateHlItem(7, $mess['ID'], array('UF_READ' => 1));
        }
    }
}

// Получаем чаты пользователя
function getChatsUser($IDUser, $forDel = false)
{
    $result = array();
    $params = array(
        'select' => array('*'),
        'order' => array('ID' => 'ASC'),
        'filter' => array(
            'LOGIC' => 'OR',
            array('UF_AUTOR_ID' => $IDUser),
            array('UF_ID_USER' => $IDUser),
        ),
    );

    $messages = getHighloadInfo(7, $params);
    $block = array();

    if ($messages) {
        foreach ($messages as $message) {
            if ($forDel) {
                $result[$message['ID']]['ID'] = $message['ID'];
                $result[$message['ID']]['ID_AUTOR'] = $message['UF_AUTOR_ID'];
                $result[$message['ID']]['ID_SEC_USER'] = $message['UF_ID_USER'];
            } else {
                if (($message['UF_AUTOR_ID'] == $IDUser && !$message['UF_DEL_AUTOR']) || ($message['UF_ID_USER'] == $IDUser && !$message['UF_DEL_USER'])) {
                    if ($message['UF_DATE_BLOCK']) {
                        $block[] = $message['UF_ID_AD'];
                    }


                    $user2 = ($message['UF_AUTOR_ID'] == $IDUser) ? $message['UF_ID_USER'] : $message['UF_AUTOR_ID'];

                    if (!in_array($message['UF_ID_AD'], $block)) {
                        $result[$message['UF_ID_AD'] . '_' . $user2]['MESSAGE'] = $message['UF_MESSAGE'];
                        $result[$message['UF_ID_AD'] . '_' . $user2]['DATE'] = $message['UF_DATE'];
                        $result[$message['UF_ID_AD'] . '_' . $user2]['ID_AD'] = $message['UF_ID_AD'];
                        $result[$message['UF_ID_AD'] . '_' . $user2]['ID_AUTOR'] = $message['UF_AUTOR_ID'];
                        $result[$message['UF_ID_AD'] . '_' . $user2]['ID_SEC_USER'] = $message['UF_ID_USER'];
                        $result[$message['UF_ID_AD'] . '_' . $user2]['FILES'] = $message['UF_FILES'];
                        if ($message['UF_READ'] == 0 && $message['UF_AUTOR_ID'] != $IDUser)
                            $result[$message['UF_ID_AD'] . '_' . $user2]['COUNT_UNREAD'] += 1;
                    } else {
                        $result[$message['UF_ID_AD'] . '_' . $user2]['BLOCK'] = 'Y';
                    }
                }
            }
        }
    }

    return array_reverse($result);
    //return $result;
}

// Заблокированное сообщение
function blockMessageID($IDAd, $IDUser)
{
    $params = array(
        'select' => array('*'),
        'order' => array('ID' => 'ASC'),
        'filter' => array(
            'LOGIC' => 'OR',
            array('UF_AUTOR_ID' => $IDUser, 'UF_ID_AD' => $IDAd, 'UF_BLOCK_AUTOR' => 1),
            array('UF_ID_USER' => $IDUser, 'UF_ID_AD' => $IDAd, 'UF_BLOCK_USER' => 1),
        ),
    );

    return getHighloadInfo(7, $params);
}

// Получаем сообщения конкретной переписки
function getMessagesChat($IDAd, $IDUser, $IDUser2)
{
    $params = array(
        'select' => array('*'),
        'order' => array('ID' => 'ASC'),
        'filter' => array(
            'LOGIC' => 'OR',
            array('UF_AUTOR_ID' => $IDUser, 'UF_ID_AD' => $IDAd, 'UF_ID_USER' => $IDUser2, 'UF_DEL_AUTOR' => 0),
            array('UF_AUTOR_ID' => $IDUser2, 'UF_ID_AD' => $IDAd, 'UF_ID_USER' => $IDUser, 'UF_DEL_USER' => 0),
        ),
    );
    return getHighloadInfo(7, $params);

}

// Получаем количество непрочитанных сообщений
function getCountUnreadMessages($IDUser)
{

    $count = 0;
    $params = array(
        'select' => array('ID', 'UF_DATE_BLOCK', 'UF_READ', 'UF_ID_AD'),
        'filter' => array(
            array(
                'UF_ID_USER' => $IDUser,
                'UF_DEL_AUTOR' => 0,
                'UF_DEL_USER' => 0,
            ),
        ),
    );

    $IDmessages = getHighloadInfo(7, $params);
    $blockArr = array();


    if ($IDmessages) {
        foreach ($IDmessages as $mess) {
            if ($mess['UF_DATE_BLOCK']) {
                $blockArr[] = $mess['UF_ID_AD'];
            }

            if ($mess['UF_READ'] == 1)
                continue;

            if ($mess['UF_DATE_BLOCK'] || in_array($mess['UF_ID_AD'], $blockArr)) {
                continue;
            } else {
                $count++;
            }
        }
    }

    return $count;

    /*$params = array(
        'select' => array('ID'),
        'filter' => array(
            array(
                'UF_ID_USER' => $IDUser,
                'UF_READ' => 0,
                'UF_DEL_AUTOR' => 0,
                'UF_DEL_USER' => 0,
            ),
        ),
    );

    $result = getHighloadInfo(7, $params);

    if($result)
        return count($result);

    return 0;*/
}

// Получаем название объявления для чата
function getTitleAD($IDAd)
{
    $res = CIBlockElement::GetByID($IDAd);
    if ($ar_res = $res->GetNext())
        return $ar_res['NAME'];
}

function getDetailAD($IDAd)
{
    $res = CIBlockElement::GetByID($IDAd);
    if ($ar_res = $res->GetNext())
        return $ar_res['DETAIL_PAGE_URL'];
}

// Получаем цену по объявлению
function getPriceAD($IDAd)
{
    $res = CIBlockElement::GetByID($IDAd);
    while ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
        return $arProps['PRICE']['VALUE'];
    }
}

function getPreviewPictAD($IDAd)
{
    $res = CIBlockElement::GetByID($IDAd);
    if ($ar_res = $res->GetNext()) {
        if ($ar_res['PREVIEW_PICTURE']) {
            return resizeImg($ar_res['PREVIEW_PICTURE'], 62, 62);
        } else
            return '/local/templates/teltan/assets/no-image.svg';
    }

}

// Получаем список стран
function getCountriesHL()
{
    $arr = array();
    $params = array(
        'select' => array('*'),
    );
    $result = getHighloadInfo(10, $params);

    foreach ($result as $item) {
        $arr[$item['ID']] = $item;
    }
    return $arr;
}

// Получаем список городов
function getCitiesHL()
{
    $params = array(
        'select' => array('*'),
    );
    return getHighloadInfo(11, $params);
}

// Добавляем новый проверочный код
function addConfirmCode($code, $IDUser, $type)
{
    $hl = addHLItem(12, array(
        'UF_ID_USER' => $IDUser,
        'UF_COD' => $code,
        'UF_TYPE' => $type,
        'UF_TIME' => time(),
    ));
    return $hl->getId();
}

// Получаем проверочный код
function getConfirmCode($IDUser, $type)
{
    $param = array(
        'select' => array('*'),
        'filter' => array('UF_ID_USER' => $IDUser, 'UF_TYPE' => $type),
        'limit' => 1,
        'order' => array('ID' => 'DESC')
    );

    $result = getHighloadInfo(12, $param)[0];

    // Проверяем время жизни кода
    if ($result && ((time() - $result['UF_TIME']) <= 600)) {
        return $result['UF_COD'];
    }

    return false;
}

// Отправка смс
function sendSMS($msgBody, $mobile, $msgName = false)
{
    $url = "https://slng5.com/Api/SendSmsJsonBody.ashx";
    $json = '{
 "Username": "tetl.c.il01@gmail.com",
 "Password": "8ff439fa-58c2-4ed0-82fc-44fc55232682",
 "MsgName": ' . $msgName . ',
 "MsgBody": ' . $msgBody . ',
 "FromMobile": "0533028865",
 "DeliveryAckUrl": null,
 "Mobiles": [ { "Mobile": "' . $mobile . '"}]
 }';
    //-----------------------------------------------
    $CR = curl_init();
    print_r($CR);
    curl_setopt($CR, CURLOPT_URL, $url);
    curl_setopt($CR, CURLOPT_POST, 1);
    curl_setopt($CR, CURLOPT_FAILONERROR, true);
    curl_setopt($CR, CURLOPT_POSTFIELDS, $json);
    curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($CR, CURLOPT_HTTPHEADER, array("charset=utf-8"));
    //-----------------------------------------------
    $result = curl_exec($CR);
    $error = curl_error($CR);
    $response = json_decode(urldecode($result));
    print_r($error);
    print_r($response);
}

AddEventHandler("main", "OnAfterUserAdd", array("MyClass", "OnAfterUserAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementDelete", array("MyClass", "OnAfterIBlockElementDeleteHandler"));

class MyClass
{
    public static function OnAfterIBlockElementDeleteHandler($arFields)
    {

        $hlbl = 5;
        $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();

        $entity = HL\HighloadBlockTable::compileEntity($hlblock);
        $entity_data_class = $entity->getDataClass();

        $rsData = $entity_data_class::getList(array(
            "select" => array("*"),
            "order" => array("ID" => "ASC"),
            "filter" => array("UF_ID_AD" => $arFields['ID'])  // Задаем параметры фильтра выборки
        ));

        while ($arData = $rsData->Fetch()) {
            $entity_data_class::Delete($arData['ID']);
        }
    }

    // создаем обработчик события "OnAfterUserAdd"
    function OnAfterUserAddHandler(&$arFields)
    {

        $user = new CUser;
        $fields = array(
            "UF_DAYS_FREE1" => 1,
            "UF_UF_DAYS_FREE2" => 1,
            "UF_DAYS_FREE3" => 1,
            'UF_DAYS_FLEA_REMAIN' => 30,
            'UF_DAYS_AUTO_REMAIN' => 30,
            'UF_DAYS_PROP_REMAIN' => 30,
            "UF_COUNT_RENT" => 1,
            "UF_AUTO" => 1,
            "UF_ANOUNC" => 1,
        );
        $user->Update($arFields['ID'], $fields);


    }
}

function drawElement($arItem, $arLink, $arProps)
{
    if ($arItem['PROPERTY_TYPE'] == 'L' && $arItem['ID'] != 31 && $arItem['ID'] != 168) {
        if ($arItem['MULTIPLE'] == 'Y' && $arItem['ID'] != 32 && $arItem['ID'] != 167) {
            ?>
            <div class="additional">
                <div class="flex-wrap fl-right d-lg-flex <?= ($arItem['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?> justify-content-end">
                    <? foreach ($arItem['PROP_ENUM_VAL'] as $val) { ?>
                        <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                   id="<?= $val['VALUE'] ?>" type="checkbox"
                                <?= ($arProps[$arItem['CODE']]['VALUE'] == $val['VALUE']) ? 'checked' : '' ?>
                                <? if (is_array($arProps[$arItem['CODE']]['VALUE'])) { ?>
                                    <?= (in_array($val['VALUE'], $arProps[$arItem['CODE']]['VALUE'])) ? 'checked' : '' ?>
                                <? } ?>
                                   name="prop<?= $arItem['CODE'] ?>"
                                   data-id_prop="<?= $val['PROPERTY_ID'] ?>"
                                   data-id-self="<?= $val['ID'] ?>">
                            <label for="<?= $val['VALUE'] ?>"><?= $val['VALUE'] ?> </label>
                        </div>
                        <?
                    } ?>
                    <? if ($arItem['ID'] == 44) { ?>
                        <div class=" d-lg-flex mr-2 mr-lg-3 mb-2 mb-lg-3 form-group">
                            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                   id="millage" class="w-125  form-control"
                                   value="<?= (int)$arProps['PROP_PROBEG_Left']['VALUE'] ?>"
                                   data-id_prop="43" type="number"
                                   placeholder="0"
                                   required>
                        </div>
                        <?
                    }
                    if ($arItem['ID'] == 123) { ?>
                        <div class=" d-lg-flex mr-2 mr-lg-3 mb-2 mb-lg-3 form-group">
                            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                   id="PROP_ENGIEN_NEW_Left"
                                   class="w-125 form-control"
                                   value="<?= (int)$arProps['PROP_ENGIEN_NEW_Left']['VALUE'] ?>"
                                   data-id_prop="124" type="number"
                                   placeholder="0"
                            >
                        </div>
                    <? } ?>
                </div>
            </div>
            <?
        } elseif ($arLink[$arItem['ID']]['DISPLAY_TYPE'] == 'P') { ?>
            <div class="additional">
                <div class="d-flex justify-content-end">
                    <div class="dropdown bootstrap-select" style="padding-right: 15px;"><select
                                class="selectpicker"
                                data-style-base="form-control form-control-select"
                                data-code_prop="<?= $arItem['CODE'] ?>"
                                data-id_prop="<?= $arItem['ID'] ?>"
                                data-style=""
                                data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                name="<?= $arItem['ID'] ?>"
                                id="<?= $arItem['ID'] ?>"
                                tabindex="-98">
                            <? foreach ($arItem['PROP_ENUM_VAL'] as $enumProp) { ?>
                                <option <?= ($arProps[$arItem['CODE']]['VALUE'] == $enumProp['VALUE'] ? 'selected' : '') ?>
                                        value="<?= $enumProp['ID'] ?>"><?= $enumProp['VALUE'] ?></option>
                            <? } ?>
                            <option <? if (!$_GET['EDIT']){ ?>selected<? } ?>
                                    value="Nothing selected"></option>
                        </select>
                        <div class="dropdown-menu ">
                            <div class="inner show" role="listbox"
                                 id="bs-select-22" tabindex="-1">
                                <ul class="dropdown-menu inner show" role="presentation">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <? } else { ?>
            <div class="additional">
                <div class="fl-right d-lg-flex  <?= ($arItem['IS_REQUIRED'] == 'Y') ? 'div-req' : '' ?>  justify-content-end">
                    <? foreach ($arItem['PROP_ENUM_VAL'] as $val) { ?>
                        <div class="mr-2 mr-lg-3 mb-2 mb-lg-3 form_radio_btn">
                            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                   id="<?= $val['VALUE'] ?>" type="radio"
                                   name="<?= $val['PROPERTY_ID'] ?>"
                                <?= ($arProps[$arItem['CODE']]['VALUE'] == $val['VALUE']) ? 'checked' : '' ?>
                                <? if (is_array($arProps[$arItem['CODE']]['VALUE'])) { ?>
                                    <?= ($arProps[$arItem['CODE']]['VALUE'][0] == $val['VALUE']) ? 'checked' : '' ?>
                                <? } ?>
                                   data-id_prop="<?= $val['PROPERTY_ID'] ?>"
                                   data-id-self="<?= $val['ID'] ?>">
                            <label for="<?= $val['VALUE'] ?>"><?= $val['VALUE'] ?> <?= ($arItem['IS_REQUIRED'] == 'Y') ? '' : '' ?></label>
                        </div>
                        <?
                    } ?>
                    <? if ($arItem['ID'] == 32) { ?>
                        <div class="d-lg-flex mr-2 mr-lg-3 mb-2 mb-lg-3 form-group">
                            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                   id="PROP_PROBEG_Left" class=" form-control"
                                   value="<?= (int)$arProps['PROP_PROBEG_Left']['VALUE'] ?>"
                                   data-id_prop="31" type="text" placeholder="0"
                                   required>
                        </div>
                        <?
                    }
                    if ($arItem['ID'] == 167) { ?>
                        <div class="d-lg-flex mr-2 mr-lg-3 mb-2 mb-lg-3 form-group">
                            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                                   id="PROP_ENGIEN_NEW_Left"
                                   class=" form-control"
                                   value="<?= (int)$arProps['PROP_ENGIEN_NEW_Left']['VALUE'] ?>"
                                   data-id_prop="168" type="text"
                                   placeholder="0"
                                   required="">
                        </div>
                    <? } ?>
                </div>
            </div>
            <?
        }
    } elseif ($arItem['PROPERTY_TYPE'] == 'N' && $arItem['ID'] != 31 && $arItem['ID'] != 168) { ?>
        <div class="col-6 d-lg-flex additional">
            <input data-req="<?= $arItem['IS_REQUIRED'] ?>"
                   id="<?= $arItem['CODE'] ?>" class="form-control"
                   data-id_prop="<?= $arItem['ID'] ?>" type="number"
                <?= ($arProps[$arItem['CODE']]['VALUE']) ? 'value="' . $arProps[$arItem['CODE']]['VALUE'] . '"' : '' ?>
                   placeholder="" required>
        </div>
        <?
    }
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/include/events.php");
?>