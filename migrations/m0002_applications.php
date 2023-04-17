<?php

use app\core\Application;

class m0002_applications {
    public function up()
    {
        $db = Application::$app->db;
        $SQL = "CREATE TABLE applications (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,                
                date_from DATE NOT NULL,
                date_to DATE NOT NULL,            
                reason TEXT NOT NULL,
                status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
                user_id int(10) unsigned NOT NULL,
                KEY `FK_users_applications` (`user_id`),
                CONSTRAINT `FK_user_applications` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $db->pdo->exec($SQL);
    }

    public function down()
    {
        $db = Application::$app->db;
        $SQL = "DROP TABLE applications";

        $db->pdo->exec($SQL);
    }
}