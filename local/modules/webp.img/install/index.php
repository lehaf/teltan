<?php

use Bitrix\Main\ModuleManager;

class webp_img extends CModule
{
    public function __construct()
    {
        $this->MODULE_VERSION = '1.0.0';
        $this->MODULE_VERSION_DATE = '27.12.2023';
        $this->MODULE_ID = 'webp.img'; // название модуля
        $this->MODULE_NAME = 'Генерация картинок в webp'; //описание модуля
        $this->MODULE_DESCRIPTION = 'Модуль преобразовывает картинки в webp формат';
        $this->MODULE_GROUP_RIGHTS = 'N';  //используем ли индивидуальную схему распределения прав доступа, мы ставим N, так как не используем ее
        $this->PARTNER_NAME = "webcompany"; //название компании партнера предоставляющей модуль
        $this->PARTNER_URI = 'https://webcompany.by/uslugi/razrabotka-sajtov';//адрес вашего сайта
    }

    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
    }

    public function doUninstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

}