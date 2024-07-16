<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
global $APPLICATION;
$APPLICATION->IncludeComponent(
    "only:company_cars",
    "",
    array(),
    false
);