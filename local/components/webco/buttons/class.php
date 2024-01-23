<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class BoostBtn extends \CBitrixComponent
{
    private array $services = [
        'RISE' => [
            'HL_BLOCK_ID' => PERSONAL_RISE_HL_ID,
            'INCLUDE_PATH' => SITE_TEMPLATE_PATH.'/includes/area/service_rise.php',
            'ICON' => [
                'CLASS' => 'text-uppercase font-weight-bold up',
                'NAME' => 'UP',
            ]
        ],
        'VIP' => [
            'HL_BLOCK_ID' => PERSONAL_VIP_TYPES_HL_ID,
            'INCLUDE_PATH' => SITE_TEMPLATE_PATH.'/includes/area/service_vip.php',
            'ICON' => [
                'CLASS' => 'crown',
                'SRC' => '/local/templates/teltan/assets/svg/crown.svg'
            ]
        ],
        'COLOR' => [
            'HL_BLOCK_ID' => PERSONAL_COLOR_HL_ID,
            'INCLUDE_PATH' => SITE_TEMPLATE_PATH.'/includes/area/service_color.php',
            'ICON' => [
                'CLASS' => 'color',
                'SRC' => '/local/templates/teltan/assets/svg/color.svg'
            ]
        ],
        'RIBBON' => [
            'HL_BLOCK_ID' => PERSONAL_RIBBON_HL_ID,
            'INCLUDE_PATH' => SITE_TEMPLATE_PATH.'/includes/area/service_ribbon.php',
            'ICON' => [
                'CLASS' => 'ribbon',
                'SRC' => '/local/templates/teltan/assets/svg/ribbon.svg'
            ]
        ],
        'SET' => [
            'HL_BLOCK_ID' => PERSONAL_PACKET_HL_ID,
            'INCLUDE_PATH' => SITE_TEMPLATE_PATH.'/includes/area/service_set.php',
            'ICON' => [
                'CLASS' => 'lightning',
                'SRC' => '/local/templates/teltan/assets/svg/lightning.svg'
            ]
        ]
    ];

    public function setColorName(&$values) : void
    {
        if (!empty($values)) {
            // Получаем все возможные ленты продвижения
            $ribTypes = getHighloadInfo(
                PERSONAL_RIBBON_HL_ID,
                array(
                    'select' => array('*'),
                    'cache' => [
                        'ttl' => 3600000,
                        'cache_joins' => true
                    ]
                )
            );
            if (!empty($ribTypes)) {
                $ribbonTypes = [];
                foreach ($ribTypes as $ribbon) {
                    $ribbonTypes[$ribbon['UF_XML_ID']] = $ribbon;
                }
            }

            foreach ($values as &$val) {
                if (!empty($val['UF_XML_ID_LENT']) && !empty($ribbonTypes[$val['UF_XML_ID_LENT']]))
                    $val['RIBBON_NAME'] = $ribbonTypes[$val['UF_XML_ID_LENT']]['UF_NAME'];
            }
        }
    }

    public function setResult() : void
    {
        if (!empty($this->arParams['ITEM_ID'])) $this->arResult['ITEM_ID'] = $this->arParams['ITEM_ID'];
        if (!empty($this->arParams['IBLOCK_ID'])) $this->arResult['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];
        if (!empty($this->arParams['ITEM_ACTIVE'])) $this->arResult['ITEM_ACTIVE'] = $this->arParams['ITEM_ACTIVE'];
        if (!empty($this->arParams['EDIT_PAGE'])) $this->arResult['EDIT_PAGE'] = $this->arParams['EDIT_PAGE'];

        if ($this->getTemplateName() === 'boost') {
            foreach ($this->services as $serviceType => $service) {
                $info = getHLData($service['HL_BLOCK_ID']);
                if ($serviceType === 'SET') $this->setColorName($info);
                $this->arResult['BOOST'][$serviceType] = [
                    'ICON' => $service['ICON'],
                    'INCLUDE_PATH' => $service['INCLUDE_PATH'],
                    'INFO' => $info
                ];
            }
        }

    }

    public function prepareResult() : void
    {
        $this->setResult();
    }

    public function executeComponent()
    {
        $this->prepareResult();
        $this->includeComponentTemplate();

    }
}

