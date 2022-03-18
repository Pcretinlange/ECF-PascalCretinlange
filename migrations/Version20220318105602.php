<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318105602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hotel_rooms (id INT AUTO_INCREMENT NOT NULL, hotels_id INT NOT NULL, title VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, price NUMERIC(6, 2) NOT NULL, booking_link VARCHAR(255) NOT NULL, INDEX IDX_9F75D452F42F66C8 (hotels_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotel_rooms_images (hotel_rooms_id INT NOT NULL, images_id INT NOT NULL, INDEX IDX_F0D86103CC42BAD9 (hotel_rooms_id), INDEX IDX_F0D86103D44F05E5 (images_id), PRIMARY KEY(hotel_rooms_id, images_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotels (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, adress VARCHAR(50) NOT NULL, city VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hotels_users (hotels_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_A4CC8FAF42F66C8 (hotels_id), INDEX IDX_A4CC8FA67B3B43D (users_id), PRIMARY KEY(hotels_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, size INT NOT NULL, type VARCHAR(20) NOT NULL, bin LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation_rooms (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, hotels_id INT DEFAULT NULL, hotel_rooms_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_3FDECA3167B3B43D (users_id), INDEX IDX_3FDECA31F42F66C8 (hotels_id), INDEX IDX_3FDECA31CC42BAD9 (hotel_rooms_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel_rooms ADD CONSTRAINT FK_9F75D452F42F66C8 FOREIGN KEY (hotels_id) REFERENCES hotels (id)');
        $this->addSql('ALTER TABLE hotel_rooms_images ADD CONSTRAINT FK_F0D86103CC42BAD9 FOREIGN KEY (hotel_rooms_id) REFERENCES hotel_rooms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotel_rooms_images ADD CONSTRAINT FK_F0D86103D44F05E5 FOREIGN KEY (images_id) REFERENCES images (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotels_users ADD CONSTRAINT FK_A4CC8FAF42F66C8 FOREIGN KEY (hotels_id) REFERENCES hotels (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hotels_users ADD CONSTRAINT FK_A4CC8FA67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_rooms ADD CONSTRAINT FK_3FDECA3167B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reservation_rooms ADD CONSTRAINT FK_3FDECA31F42F66C8 FOREIGN KEY (hotels_id) REFERENCES hotels (id)');
        $this->addSql('ALTER TABLE reservation_rooms ADD CONSTRAINT FK_3FDECA31CC42BAD9 FOREIGN KEY (hotel_rooms_id) REFERENCES hotel_rooms (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel_rooms_images DROP FOREIGN KEY FK_F0D86103CC42BAD9');
        $this->addSql('ALTER TABLE reservation_rooms DROP FOREIGN KEY FK_3FDECA31CC42BAD9');
        $this->addSql('ALTER TABLE hotel_rooms DROP FOREIGN KEY FK_9F75D452F42F66C8');
        $this->addSql('ALTER TABLE hotels_users DROP FOREIGN KEY FK_A4CC8FAF42F66C8');
        $this->addSql('ALTER TABLE reservation_rooms DROP FOREIGN KEY FK_3FDECA31F42F66C8');
        $this->addSql('ALTER TABLE hotel_rooms_images DROP FOREIGN KEY FK_F0D86103D44F05E5');
        $this->addSql('ALTER TABLE hotels_users DROP FOREIGN KEY FK_A4CC8FA67B3B43D');
        $this->addSql('ALTER TABLE reservation_rooms DROP FOREIGN KEY FK_3FDECA3167B3B43D');
        $this->addSql('DROP TABLE hotel_rooms');
        $this->addSql('DROP TABLE hotel_rooms_images');
        $this->addSql('DROP TABLE hotels');
        $this->addSql('DROP TABLE hotels_users');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE reservation_rooms');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
