<?php

use app\core\Migration;

class m0001_initial extends Migration
{
    public function getVersion(): int
    {
        return 1;
    }
    public function up()
    {
        $this->pdo->exec("
            CREATE EXTENSION IF NOT EXISTS pgcrypto;

            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                role VARCHAR(50) NOT NULL DEFAULT 'user',
                token UUID DEFAULT gen_random_uuid(),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS spaces (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                availability BOOLEAN DEFAULT TRUE,
                location VARCHAR(255) NOT NULL,
                image VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS bookings (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
                space_id INTEGER NOT NULL REFERENCES spaces(id) ON DELETE CASCADE,
                start_time TIMESTAMP NOT NULL,
                end_time TIMESTAMP NOT NULL,
                status VARCHAR(50) DEFAULT 'pending',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS reviews (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
                space_id INTEGER NOT NULL REFERENCES spaces(id) ON DELETE CASCADE,
                rating INTEGER CHECK (rating BETWEEN 1 AND 5),
                comment TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );

            -- Добавляем администратора по умолчанию
            INSERT INTO users (username, password, email, role) 
            VALUES (
                'admin', 
                crypt('admin123', gen_salt('bf')), 
                'admin@example.com', 
                'admin'
            );

            -- Добавляем тестовые пространства
            INSERT INTO spaces (name, description, price, location, image) 
            VALUES 
                ('Креативный коворкинг', 'Современное пространство для работы и творчества', 350, 'Москва, ул. Тверская, 10', 'space1.jpg'),
                ('Бизнес лофт', 'Просторное помещение для деловых встреч и работы', 500, 'Санкт-Петербург, Невский пр., 25', 'space2.jpg'),
                ('Тихий уголок', 'Уютное место для сосредоточенной работы', 250, 'Казань, ул. Баумана, 15', 'space3.jpg');
        ");
    }

    public function down()
    {
        $this->pdo->exec("
            DROP TABLE IF EXISTS reviews;
            DROP TABLE IF EXISTS bookings;
            DROP TABLE IF EXISTS spaces;
            DROP TABLE IF EXISTS users;
        ");
    }
}