<?php

declare(strict_types=1);

namespace Classes\Orm;

use Bitrix\Main;
use Bitrix\Main\Entity;

class TripTable extends Main\Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'trips';
    }


    public static function getMap(): array
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\IntegerField('UF_CAR_ID'),
            new Entity\DatetimeField('UF_START_TIME'),
            new Entity\DatetimeField('UF_END_TIME'),
        ];
    }
}