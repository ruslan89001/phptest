<?php
namespace migrations;

use app\core\Database;

class Migration_001_init_tables {
    public function up() {
        $db = Database::getInstance();

        $db->query("
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                role VARCHAR(50) NOT NULL,
                token UUID DEFAULT gen_random_uuid()
            )
        ");

        $db->query("
            CREATE TABLE IF NOT EXISTS spaces (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                availability BOOLEAN DEFAULT TRUE,
                location VARCHAR(255) NOT NULL,
                image VARCHAR(255)
            )
        ");

        $db->query("
            CREATE TABLE IF NOT EXISTS bookings (
                id SERIAL PRIMARY KEY,
                user_id INT NOT NULL,
                space_id INT NOT NULL,
                start_time TIMESTAMP NOT NULL,
                end_time TIMESTAMP NOT NULL,
                status VARCHAR(50) DEFAULT 'pending',
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (space_id) REFERENCES spaces(id) ON DELETE CASCADE
            )
        ");

        $db->query("
            CREATE TABLE IF NOT EXISTS reviews (
                id SERIAL PRIMARY KEY,
                user_id INT NOT NULL,
                space_id INT NOT NULL,
                rating INT CHECK (rating >= 1 AND rating <= 5),
                comment TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (space_id) REFERENCES spaces(id) ON DELETE CASCADE
            )
        ");

        $db->query("
            DO $$
            BEGIN
                IF NOT EXISTS (
                    SELECT 1 FROM users WHERE email = 'admin@coworking.com'
                ) THEN
                    INSERT INTO users (username, password, email, role, token)
                    VALUES (
                        'admin',
                        crypt('admin', gen_salt('bf')),
                        'admin@coworking.com',
                        'admin',
                        gen_random_uuid()
                    );
                END IF;
            END
            $$;
        ");
    }

    public function down() {
        $db = Database::getInstance();
        $db->query("DROP TABLE IF EXISTS reviews");
        $db->query("DROP TABLE IF EXISTS bookings");
        $db->query("DROP TABLE IF EXISTS spaces");
        $db->query("DROP TABLE IF EXISTS users");
    }
}
