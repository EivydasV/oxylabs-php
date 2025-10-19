<?php

declare(strict_types=1);

namespace App\Entity;

use App\enum\DevicePlatform;
use DateTimeImmutable;

class Device
{
    private int $id;

    private int $userId;

    private ?DevicePlatform $platform;

    private ?string $label;

    private ?DateTimeImmutable $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPlatform(): ?DevicePlatform
    {
        return $this->platform;
    }

    public function setPlatform(?DevicePlatform $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
