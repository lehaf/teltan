<?php
function pr($o, $show = false, $die = false, $fullBackTrace = false)
{
    global $USER;
//    if ($USER->IsAdmin() && $USER -> GetId() == 1100 || $show) {
    if ($USER->IsAdmin() || $show) {
        $bt = debug_backtrace();

        $firstBt = $bt[0];
        $dRoot = $_SERVER["DOCUMENT_ROOT"];
        $dRoot = str_replace("/", "\\", $dRoot);
        $firstBt["file"] = str_replace($dRoot, "", $firstBt["file"]);
        $dRoot = str_replace("\\", "/", $dRoot);
        $firstBt["file"] = str_replace($dRoot, "", $firstBt["file"]);
        ?>
        <div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;'>
            <div style='padding:3px 5px; background:#99CCFF;'>

                <? if ($fullBackTrace == false): ?>
                    File: <b><?= $firstBt["file"] ?></b> [line: <?= $firstBt["line"] ?>]
                <? else: ?>
                    <? foreach ($bt as $value): ?>
                        <?
                        $dRoot = str_replace("/", "\\", $dRoot);
                        $value["file"] = str_replace($dRoot, "", $value["file"]);
                        $dRoot = str_replace("\\", "/", $dRoot);
                        $value["file"] = str_replace($dRoot, "", $value["file"]);
//                        echo '<pre>';
//                        print_r($value);
//                        echo '</pre>';
                        ?>

                        File: <b><?= $value["file"] ?></b> [line: <?= $value["line"] ?>] <?= $value['class'] . '->'.$value['function'].'()'?><br>
                    <? endforeach ?>
                <?endif; ?>
            </div>
            <pre style='padding:10px;'><? is_array($o) ? print_r($o) :  print_r(htmlspecialcharsbx($o)) ?></pre>
        </div>
        <?if ($die == true) {
            die();
        }?>
        <?
    } else {
        return false;
    }
}


//function getAllAutoProperties($cacheTtl = 360000) : array
//{
//    $cacheId = 'iblock_'.AUTO_IBLOCK_ID;
//    $cache = \Bitrix\Main\Application::getInstance()->getManagedCache();
//    if ($cache->read($cacheTtl, $cacheId)) {
//        $properties = $cache->get($cacheId);
//    } else {
//        $props = CIBlockProperty::GetList(
//            array("sort" => "asc", "name" => "asc"),
//            array("ACTIVE" => "Y", "IBLOCK_ID" => AUTO_IBLOCK_ID)
//        );
//        $properties = [];
//        while ($prop = $props->GetNext()) {
//
//            $prop_field[$prop["ID"]] = $prop;
//            $properties[] = $prop;
//        }
//        $cache->set($cacheId, array("FIELDS" => )); // записываем в кеш
//    }
//    return $properties ?? [];
//}