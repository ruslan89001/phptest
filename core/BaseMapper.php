<?php
namespace app\core;

use PDO;

abstract class BaseMapper {
    protected Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    abstract protected function getTableName(): string;
    abstract protected function mapToEntity(array $data);

    public function findById(int $id) {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE id = :id";
        $stmt = $this->db->query($sql, ['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToEntity($data) : null;
    }

    protected function executeInsert(string $sql, array $params) {
        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }
    public function findAll(): array {
        $sql = "SELECT * FROM {$this->getTableName()}";
        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([$this, 'mapToEntity'], $results);
    }
    public function update(object $entity): void {
        $tableName = $this->getTableName();
        $data = $this->entityToArray($entity);
        $id = $data['id'];
        unset($data['id']);

        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
        }

        $sql = "UPDATE $tableName SET " . implode(', ', $setParts) . " WHERE id = :id";
        $data['id'] = $id;
        $this->db->query($sql, $data);
    }

    public function delete(int $id): void {
        $sql = "DELETE FROM {$this->getTableName()} WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }

    protected function entityToArray(object $entity): array {
        $reflection = new \ReflectionClass($entity);
        $properties = $reflection->getProperties();
        $data = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $property->getValue($entity);

            if ($value instanceof \DateTime) {
                $value = $value->format('Y-m-d H:i:s');
            }

            $data[$property->getName()] = $value;
        }

        return $data;
    }
}