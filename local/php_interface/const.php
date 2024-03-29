<?php
// SITE SETTINGS
const DAYS_EXPIRED_FREE_ADS = 30;

// ADS CODES FOR HL #28
const PROPERTY_ADS_TYPE_CODE = 'PROPERTY';
const AUTO_ADS_TYPE_CODE = 'AUTO';
const FLEA_ADS_TYPE_CODE = 'FLEA';
const CATEGORY_TO_IBLOCK_ID = [
    'FLEA' => 1,
    'PROPERTY' => 2,
    'AUTO' => [3, 7, 8]
];

// IBLOCKS
const SIMPLE_ADS_IBLOCK_ID = 1;
const PROPERTY_ADS_IBLOCK_ID = 2;
const AUTO_IBLOCK_ID = 3;
const SLIDER_IBLOCK_ID = 4;
const MOTO_IBLOCK_ID = 7;
const SCOOTER_IBLOCK_ID = 8;

const LIVING_PROP_SECTIONS_ID = [34, 35];
const COMMERCICAL_PROP_SECTIONS_ID = [32, 33];
const NEW_BUILDINGS_PROP_SECTIONS_ID = [31, 30];

// Highload-блоки
const AUTO_BODY_TYPE_HL_ID = 1;
const MOTO_BODY_TYPE_HL_ID = 31;
const SCOOTER_BODY_TYPE_HL_ID = 32;
const PERSONAL_VIP_TYPES_HL_ID = 22;
const MAP_REGIONS_HL_ID = 34;
const BOUGHT_RATE_HL_ID = 28;
const TYPE_RATES_HL_ID = 27;
const USER_BUY_HISTORY_HL_ID = 30;
const PERSONAL_RISE_HL_ID = 21;
const PERSONAL_COLOR_HL_ID = 23;
const PERSONAL_RIBBON_HL_ID = 24;
const PERSONAL_PACKET_HL_ID = 25;
const EXCHANGE_RATE_HL_ID = 29;
const USERS_CHAT_MESSAGES_HL_ID = 7;

const b   = 22;
const SECTION_PROPS_HL_ID = 8;
const PROPERTY_TYPES_HL_ID = 17;
const PROPERTY_ADD_PAGE_PROPS_HL_ID = 8;
const PERSONAL_HISTORY_BUY_HL_ID = 30;
const PERSONAL_FAVORITE_HL_ID = 5;

const REAL_ESTATE_LIVE_RENT_SECTION_ID = 34;
const FILTER_EXTRA_SHOW_COUNT = 3; //отвечает за то сколько свойств будет показано перед фильтром (минимум 2)
const ADD_AUTO_BODY_TYPES_SHOW_COUNT = 4; //отвечает за то сколько кузовов(пикап, минивен..) будет выводиться на странице добавления АВТО перед кнопкой show all (надо указывать на 1 меньше так как счёт идёт с 0 а не с 1)
/* Системные константы */
const RESIDENTIAL_BUY_SECTION_ID = 35;
const RESIDENTIAL_RENT_SECTION_ID = 34;
const RESIDENTIAL_SECTION_ID = 27;
const RESIDENTAL_SECTION_ARRAY = [RESIDENTIAL_BUY_SECTION_ID, RESIDENTIAL_RENT_SECTION_ID ,RESIDENTIAL_SECTION_ID];


const COMMERCIAL_BUY_SECTION_ID = 33;
const COMMERCIAL_RENT_SECTION_ID = 32;
const COMMERCIAL_SECTION_ID = 28;
const COMMERCIAL_SECTION_ARRAY = [COMMERCIAL_BUY_SECTION_ID, COMMERCIAL_RENT_SECTION_ID ,COMMERCIAL_SECTION_ID];
const RENT_SECTION_ID_ARRAY = [COMMERCIAL_RENT_SECTION_ID, RESIDENTIAL_RENT_SECTION_ID];
const BUY_SECTION_ID_ARRAY = [RESIDENTIAL_BUY_SECTION_ID, COMMERCIAL_BUY_SECTION_ID];


const NEW_BUY_SECTION_ID = 31;
const NEW_RENT_SECTION_ID = 30;
const NEW_SECTION_ID = 29;
const IBLOCK_PROPERTY_MAP_LAYOUT_JSON_PROP_ID = 201;
const IBLOCK_PROPERTY_MAP_LAYOUT_BIG_PROP_ID = 200;
const IBLOCK_PROPERTY_PROP_COUNT_ROOMS_PROP_ID = 109;
const IBLOCK_PROPERTY_PROP_TYPE_APART_PROP_ID = 165;



// PROPERTY PROPS CONST
const PROPERTY_CURRENCY_SYMBOL = '₪';
const PROPERTY_VIP_COLOR = '#FFF5D9;';
const PROP_NOT_FIRST_ID = 241;
const PROP_NOT_LAST_ID = 240;
const PROP_FLOOR_ID = 111;
const PROP_AREA_1_ID = 172;
const PROP_AREA_2_ID = 173;
const PROP_AREA_3_ID = 174;
const PROP_COMPLETION_ID = 113;
const PROP_RESTRICTIONS_ID = 166;
const PROP_IMMEDIATELY_ENTRY_ID = 239;
const SPECIAL_PROPERTY_PROPS_ID = [
    172,
    173,
    174,
    113
];

const IMMUTABLE_PROPERTY_FILTER_PROPS = [
    'MAP_LAYOUT_JSON',
    'MAP_LAYOUT_BIG',
    'PRICE',
    'PROP_AREA_2',
    'PROP_COUNT_ROOMS',
    'PROP_FREE_LAYOUT',
    'PROP_STUDIO',
    'PROP_TYPE_APART',
    'PROP_FLOOR',
    'NOT_FIRST',
    'NOT_LAST',
    'PROP_Completion',
    'IMMEDIATELY_ENTRY',
];

// Время
const DAY_TIME = [
    '00:00',
    '01:00',
    '02:00',
    '03:00',
    '04:00',
    '05:00',
    '06:00',
    '07:00',
    '08:00',
    '09:00',
    '10:00',
    '11:00',
    '12:00',
    '13:00',
    '14:00',
    '15:00',
    '16:00',
    '17:00',
    '18:00',
    '19:00',
    '20:00',
    '21:00',
    '22:00',
    '23:00',
];