<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database\MysqlPDO;
use App\Entity\User;
use PDO;

/**
 * @extends AbstractRepository<User>
 */
class UserRepository extends AbstractRepository
{
    private PDO $connection;

    public function __construct(MysqlPDO $mysqlPDO) {
        $this->connection = $mysqlPDO->getConnection();

        parent::__construct(User::class);
    }

    public function findById(int $userId): ?User
    {
        $stmt = $this->connection->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$userId]);

        $user = $stmt->fetch();
        if ($user === false) {
            return null;
        }

        return $this->toEntity($user);
    }
}
