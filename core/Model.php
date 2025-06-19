<?php
namespace app\core;

use PDO;

abstract class Model {
    protected Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    abstract public function tableName(): string;

    public function findOne($where) {
        $tableName = $this->tableName();
        $attributes = array_keys($where);
        $sql = "SELECT * FROM $tableName WHERE " . implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = $this->db->query($sql, $where);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll() {
        $tableName = $this->tableName();
        $stmt = $this->db->query("SELECT * FROM $tableName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(array $data) {
        $tableName = $this->tableName();
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
        $this->db->query($sql, $data);
        return $this->db->lastInsertId();
    }
}