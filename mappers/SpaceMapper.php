<?php

namespace app\mappers;

use app\core\Database;
use app\models\Space;
use PDO;

class SpaceMapper
{
    private PDO $pdo;

    public function __construct(Database $database)
    {
        $this->pdo = $database->getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM spaces");
        $spaces = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $spaces[] = $this->mapToSpace($row);
        }

        return $spaces;
    }

    public function getById(int $id): ?Space
    {
        $stmt = $this->pdo->prepare("SELECT * FROM spaces WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapToSpace($row) : null;
    }

    public function save(Space $space): bool
    {
        if ($space->id) {
            return $this->update($space);
        }

        return $this->insert($space);
    }

    private function insert(Space $space): bool
    {
        $sql = "INSERT INTO spaces (name, description, price, availability, location, image) 
                VALUES (:name, :description, :price, :availability, :location, :image)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'name' => $space->name,
            'description' => $space->description,
            'price' => $space->price,
            'availability' => $space->availability ? 1 : 0,
            'location' => $space->location,
            'image' => $space->image
        ]);
    }

    private function update(Space $space): bool
    {
        $sql = "UPDATE spaces SET 
                name = :name, 
                description = :description, 
                price = :price, 
                availability = :availability, 
                location = :location, 
                image = :image 
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $space->id,
            'name' => $space->name,
            'description' => $space->description,
            'price' => $space->price,
            'availability' => $space->availability ? 1 : 0,
            'location' => $space->location,
            'image' => $space->image
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM spaces WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getCount(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM spaces");
        return (int)$stmt->fetchColumn();
    }

    private function mapToSpace(array $row): Space
    {
        $space = new Space();
        $space->id = $row['id'];
        $space->name = $row['name'];
        $space->description = $row['description'];
        $space->price = $row['price'];
        $space->availability = (bool)$row['availability'];
        $space->location = $row['location'];
        $space->image = $row['image'];
        $space->created_at = $row['created_at'];
        $space->updated_at = $row['updated_at'];

        return $space;
    }
}