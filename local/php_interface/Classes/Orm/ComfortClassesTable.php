<?php

declare(strict_types=1);

namespace Classes\Orm;

use Bitrix\Main;
use Bitrix\Main\Entity;

class ComfortClassesTable extends Main\Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'comfort_classes';
    }


    public static function getMap(): array
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\StringField('UF_TITLE'),
            new Entity\BooleanField('UF_ACTIVE'),

        ];
    }
}