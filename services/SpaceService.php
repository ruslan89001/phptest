<?php
namespace app\services;

use app\mappers\SpaceMapper;
use app\models\Space;

class SpaceService {
    private SpaceMapper $spaceMapper;

    public function __construct() {
        $this->spaceMapper = new SpaceMapper();
    }

    public function getAvailableSpaces(): array {
        return $this->spaceMapper->findAvailable();
    }

    public function createSpace(Space $space): Space {
        $spaceId = $this->spaceMapper->save($space);
        return $this->spaceMapper->findById($spaceId);
    }
    public function getSpaceById(int $id): ?Space {
        return $this->spaceMapper->findById($id);
    }

    public function getAllSpaces(): array {
        return $this->spaceMapper->findAll();
    }

    public function updateSpace(Space $space): Space {
        $this->spaceMapper->update($space);
        return $this->spaceMapper->findById($space->getId());
    }

    public function deleteSpace(int $id): void {
        $this->spaceMapper->delete($id);
    }
}