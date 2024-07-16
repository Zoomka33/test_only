<?php

declare(strict_types=1);

namespace Classes\Orm;

use Bitrix\Main\Entity;
use Bitrix\Main;

class AllowClassesForEmployeeTable extends Main\Entity\DataManager
{
    public static function getTableName(): string
    {
        return 'allow_classes_for_employee';
    }

    public static function getMap(): array
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true
            ]),
            new Entity\IntegerField('UF_CLASS_ID'),
            new Entity\IntegerField('UF_JOB_TITLE_ID'),

        ];
    }
}