<?php

declare(strict_types=1);

namespace Classes\Orm;

use Bitrix\Main;
use Bitrix\Main\Entity;

class CarsTable extends Main\Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'cars';
    }

    public static function getMap(): array
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\StringField('UF_NAME'),
            new Entity\IntegerField('UF_DRIVER_ID'),
            new Entity\IntegerField('UF_CLASS_ID'),
            new Entity\BooleanField('UF_ACTIVE'),

        ];
    }
}