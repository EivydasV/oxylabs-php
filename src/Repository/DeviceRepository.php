<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\MysqlPDO;
use App\Entity\Device;
use App\enum\DevicePlatform;
use PDO;

class DeviceRepository extends AbstractRepository
{
    private PDO $connection;

    public function __construct(MysqlPDO $mysqlPDO)
    {
        $this->connection = $mysqlPDO->getConnection();

        parent::__construct(Device::class);
    }

    public function hasDevice(int $userId, DevicePlatform $platform): bool
    {
        $stmt = $this->connection->prepare('SELECT COUNT(*) as count FROM devices WHERE user_id = ? AND platform = ?');
        $stmt->execute([$userId, $platform->value]);

        $result = $stmt->fetch();
        if ($result === false) {
            return false;
        }

        return (int) $result['count'] > 0;
    }
}
