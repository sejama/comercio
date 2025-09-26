<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250926163925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, localidad_id INT DEFAULT NULL, negocio_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, correo VARCHAR(255) DEFAULT NULL, telefono VARCHAR(25) DEFAULT NULL, celular VARCHAR(25) DEFAULT NULL, domicilio VARCHAR(255) NOT NULL, INDEX IDX_F41C9B2567707C89 (localidad_id), INDEX IDX_F41C9B257D879E4F (negocio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B2567707C89 FOREIGN KEY (localidad_id) REFERENCES localidad (id)');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B257D879E4F FOREIGN KEY (negocio_id) REFERENCES negocio (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B2567707C89');
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B257D879E4F');
        $this->addSql('DROP TABLE cliente');
    }
}
