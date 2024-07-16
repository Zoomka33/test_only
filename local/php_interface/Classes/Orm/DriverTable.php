<?php

declare(strict_types=1);

namespace Classes\Orm;

use Bitrix\Main;
use Bitrix\Main\Entity;

class DriverTable extends Main\Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'driver';
    }


    public static function getMap(): array
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\StringField('UF_NAME'),
            new Entity\StringField('UF_SECOND_NAME'),
            new Entity\BooleanField('UF_ACTIVE'),

        ];
    }
}