<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325165327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articulos (
                    id INT AUTO_INCREMENT NOT NULL, 
                    nif_autor VARCHAR(9) NOT NULL, 
                    titulo VARCHAR(50) NOT NULL, 
                    publicado TINYINT(1) NOT NULL, 
                    INDEX IDX_9C6F85975F979F52 (nif_autor), 
                    PRIMARY KEY(id)
                    ) DEFAULT CHARACTER SET utf8mb4 
                    COLLATE `utf8mb4_unicode_ci` 
                    ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autores (
                    nif VARCHAR(9) NOT NULL, 
                    nombre VARCHAR(50) NOT NULL, 
                    edad INT DEFAULT NULL, 
                    sueldo_hora NUMERIC(4, 2) DEFAULT NULL, 
                    PRIMARY KEY(nif)
                    ) DEFAULT CHARACTER SET utf8mb4 
                    COLLATE `utf8mb4_unicode_ci` 
                    ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articulos ADD CONSTRAINT FK_9C6F85975F979F52 FOREIGN KEY (nif_autor) REFERENCES autores (nif)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articulos DROP FOREIGN KEY FK_9C6F85975F979F52');
        $this->addSql('DROP TABLE articulos');
        $this->addSql('DROP TABLE autores');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
