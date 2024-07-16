<?php

declare(strict_types=1);

use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;
use Classes\DTO\AllowCarDto;

class CompanyCars extends CBitrixComponent
{

    public function __construct()
    {
        if (!Loader::includeModule('iblock'))
        {
            throw new \Exception('Не загружены модули необходимые для работы модуля');
        }
        parent::__construct();
    }

    /**
     * @param $arParams
     * @return mixed
     */
    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    public function executeComponent()
    {
        $dateStart = $this->request->get('start');
        $dateEnd = $this->request->get('end');

        $cars = $this->getAllowCars($this->getJobTitle());

        $cars = $this->refreshAlowedCarsByTripTime($dateStart, $dateEnd, $cars);

        $this->arResult['cars'] = $cars;
        dump($cars);
        die();
//        $this->includeComponentTemplate();
    }

    /**
     * Метод возвращает все доступные автомобили для должности
     *
     * @param int $jobTitileId
     * @return array<AllowCarDto>
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getAllowCars(int $jobTitileId): array
    {
        $allowCars = [];
        $rows = \Classes\Orm\AllowClassesForEmployeeTable::getList([
            'filter' => [
                'UF_JOB_TITLE_ID' => $jobTitileId,
            ],
            'select' => [
                '*',
                'DATA_JOB_TITLE_' => 'JOB_TITLE',
                'CLASS_INFO_' => 'CLASS_INFO',
                'CARS_' => 'CARS',
                'DRIVER_' => 'DRIVER',

            ],
            'runtime' => [
                'JOB_TITLE' => [
                    'data_type' => \Classes\Orm\JobTitleTable::class,
                    'reference' => ['this.UF_JOB_TITLE_ID' => 'ref.ID'],
                    'join_type' => 'LEFT',
                ],
                'CLASS_INFO' => [
                    'data_type' => \Classes\Orm\ComfortClassesTable::class,
                    'reference' => ['this.UF_CLASS_ID' => 'ref.ID'],
                    'join_type' => 'LEFT',
                ],
                'CARS' => [
                    'data_type' => \Classes\Orm\CarsTable::class,
                    'reference' => ['this.CLASS_INFO_ID' => 'ref.UF_CLASS_ID'],
                    'join_type' => 'LEFT',
                ],
                'DRIVER' => [
                    'data_type' => \Classes\Orm\DriverTable::class,
                    'reference' => ['this.CARS_UF_DRIVER_ID' => 'ref.ID'],
                    'join_type' => 'LEFT',
                ],
            ],
            'cache' => ['ttl' => 3600]
        ])->fetchCollection();


        foreach ($rows as $row) {
            $allowCars[] = new AllowCarDto(
                id: $row->get('CARS')->get('ID'),
                name: $row->get('CARS')->get('UF_NAME'),
                comfortId: $row->get('CLASS_INFO')->get('ID'),
                comfortName: $row->get('CLASS_INFO')->get('UF_TITLE'),
                driverId: $row->get('DRIVER')->get('ID'),
                driverName: $row->get('DRIVER')->get('UF_NAME'),
            );
        }

        return $allowCars;
    }

    /**
     * Метод обновляет доступные автомобили по заданному интервалу времени
     *
     * @param string $startTime
     * @param string $endTime
     * @param array<AllowCarDto> $cars
     * @return array
     */
    public function refreshAlowedCarsByTripTime(string $startTime, string $endTime, array $cars)
    {
        $ids = [];
        foreach ($cars as $car) {
            $ids[] = $car->getId();
        }
        $rows = \Classes\Orm\TripTable::getList([
            'filter' => [
                'UF_CAR_ID' => $ids,
                '<UF_START_TIME' => new \Bitrix\Main\Type\DateTime($dateStart),
                '>UF_END_TIME' => new \Bitrix\Main\Type\DateTime($endTime),
            ],
            'select' => [
                '*',
            ],
            'cache' => ['ttl' => 3600]
        ])->fetchAll();

        if ($rows) {
            $discardIds = array_column($rows, 'UF_CAR_ID');
            foreach ($cars as $key => $car) {
                if (in_array($car->getId(),$discardIds)) {
                    unset($cars[$key]);
                }
            }
        }
        return $cars;
    }

    private function getJobTitle(): ?int
    {
        global $USER;
        return (int)CUser::GetList(
            [],
            [],
            [
                'ID' => $USER->getId()
            ],
            [
                'SELECT' => [
                    'UF_JOB_TITLE'
                ]
            ]
        )->Fetch()['UF_JOB_TITLE'];
    }
}