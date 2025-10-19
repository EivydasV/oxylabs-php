<?php

declare(strict_types=1);

namespace App\Database;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use PDO;

class MysqlPDO
{
    private ?PDO $connection = null;

    public function __construct(
        #[Autowire(env: 'DATABASE_NAME')]
        private readonly string $databaseName,
        #[Autowire(env: 'DATABASE_PASSWORD')]
        private readonly string $rootPassword,
        #[Autowire(env: 'DATABASE_HOST')]
        private readonly string $host,
        #[Autowire(env: 'DATABASE_USER')]
        private readonly string $user,
        #[Autowire(env: 'DATABASE_PORT')]
        private readonly int $port,
    ) {
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $this->host,
                $this->port,
                $this->databaseName,
            );

            $this->connection = new PDO(
                $dsn,
                $this->user,
                $this->rootPassword,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }

        return $this->connection;
    }
}
