<?php

declare(strict_types = 1);

namespace App\Repository;

use App\Exception\ArrayToEntityException;
use App\Exception\ValueCastException;
use DateTimeImmutable;
use ReflectionClass;
use ReflectionNamedType;

/**
 * @template T
 */
abstract class AbstractRepository
{
    /**
     * @param class-string $entity
     */
    protected function __construct(private readonly string $entity)
    {
    }

    /**
     * @return T[]
     */
    protected function toEntities(array $data): array
    {
        $entities = [];
        foreach ($data as $row) {
            $entities[] = $this->toEntity($row);
        }

        return $entities;
    }

    /**
     * @return T
     */
    protected function toEntity(array $data) {
        $reflection = new ReflectionClass($this->entity);
        $entity = $reflection->newInstance();

        foreach ($data as $column => $value) {
            $property = $this->getPropertyInCamelCase($column);
            $setter = $this->getSetter($property);

            if (!method_exists($entity, $setter)) {
                throw new ArrayToEntityException(
                    sprintf(
                        'Setter "%s", does not exists on entity "%s',
                        $setter,
                        $this->entity
                    )
                );
            }

            $method = $reflection->getMethod($setter);
            $paramType = $method->getParameters()[0]?->getType();

            if ($value !== null && $paramType instanceof ReflectionNamedType) {
                $castValue = $this->castValue($paramType->getName(), $value);

                $entity->$setter($castValue);
            }
        }

        return $entity;
    }

    private function getPropertyInCamelCase(string $column): string
    {
        return str_replace('_', '', ucwords($column, '_'));
    }

    private function getSetter(string $property): string
    {
        return 'set' . ucfirst($property);
    }

    private function castValue(string $typeName, $value)
    {
        if (enum_exists($typeName)) {
            return $typeName::from($value);
        }

        return match ($typeName) {
            DateTimeImmutable::class => new DateTimeImmutable($value),
            'int' => (int) $value,
            'float' => (float) $value,
            'bool' => (bool) $value,
            'string' => (string) $value,
            default => throw new ValueCastException(
                sprintf(
                    'Cannot cast value "%s" to type "%s"',
                    $value,
                    $typeName
                )
            ),
        };
    }
}
