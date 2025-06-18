<?php

use app\core\Migration;

class m0002_add_reviews extends Migration
{
    public function getVersion(): int
    {
        return 1;
    }
    public function up()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS reviews (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
                space_id INTEGER NOT NULL REFERENCES spaces(id) ON DELETE CASCADE,
                rating INTEGER NOT NULL CHECK (rating BETWEEN 1 AND 5),
                comment TEXT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            
            INSERT INTO reviews (user_id, space_id, rating, comment)
            VALUES 
                (1, 1, 5, 'Отличное пространство! Быстро интернет, удобные кресла.'),
                (1, 2, 4, 'Хорошее место для работы, но немного шумно.'),
                (1, 3, 5, 'Уютное место для сосредоточенной работы.');
        ");
    }

    public function down()
    {
        $this->pdo->exec("DROP TABLE IF EXISTS reviews");
    }
}