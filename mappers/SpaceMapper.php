<?php
namespace app\mappers;

use app\core\BaseMapper;
use app\models\Space;
use PDO;

class SpaceMapper extends BaseMapper {
    protected function getTableName(): string {
        return 'spaces';
    }

    protected function mapToEntity(array $data): Space {
        $space = new Space();
        $space->setId($data['id']);
        $space->setName($data['name']);
        $space->setDescription($data['description']);
        $space->setPrice($data['price']);
        $space->setAvailability($data['availability']);
        $space->setLocation($data['location']);
        $space->setImage($data['image']);
        return $space;
    }

    public function findAvailable(): array {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE availability = TRUE";
        $stmt = $this->db->query($sql);
        return array_map([$this, 'mapToEntity'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function save(Space $space): int {
        $sql = "INSERT INTO {$this->getTableName()} 
                (name, description, price, availability, location, image) 
                VALUES (:name, :description, :price, :availability, :location, :image)";
        return $this->executeInsert($sql, [
            'name' => $space->getName(),
            'description' => $space->getDescription(),
            'price' => $space->getPrice(),
            'availability' => $space->isAvailable(),
            'location' => $space->getLocation(),
            'image' => $space->getImage()
        ]);
    }
}