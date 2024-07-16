<?php

declare(strict_types=1);

namespace Classes\DTO;

class AllowCarDto
{

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $comfortId,
        public readonly string $comfortName,
        public readonly int $driverId,
        public readonly string $driverName,
    )
    {
    }

    public static function fromOrmArray(array $data): static
    {
        return new static(

        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getComfortId(): int
    {
        return $this->comfortId;
    }

    public function getComfortName(): string
    {
        return $this->comfortName;
    }

    public function getDriverId(): int
    {
        return $this->driverId;
    }

    public function getDriverName(): string
    {
        return $this->driverName;
    }

}