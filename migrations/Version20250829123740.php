<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250829123740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE localidad (id INT AUTO_INCREMENT NOT NULL, provincia_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_4F68E0104E7121AF (provincia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE negocio (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE negocio_usuario (negocio_id INT NOT NULL, usuario_id INT NOT NULL, INDEX IDX_DB78FF57D879E4F (negocio_id), INDEX IDX_DB78FF5DB38439E (usuario_id), PRIMARY KEY(negocio_id, usuario_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pais (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provincia (id INT AUTO_INCREMENT NOT NULL, pais_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_D39AF213C604D5C6 (pais_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sucursal (id INT AUTO_INCREMENT NOT NULL, negocio_id INT DEFAULT NULL, localidad_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, domicilio VARCHAR(255) NOT NULL, INDEX IDX_E99C6D567D879E4F (negocio_id), INDEX IDX_E99C6D5667707C89 (localidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE localidad ADD CONSTRAINT FK_4F68E0104E7121AF FOREIGN KEY (provincia_id) REFERENCES provincia (id)');
        $this->addSql('ALTER TABLE negocio_usuario ADD CONSTRAINT FK_DB78FF57D879E4F FOREIGN KEY (negocio_id) REFERENCES negocio (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE negocio_usuario ADD CONSTRAINT FK_DB78FF5DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE provincia ADD CONSTRAINT FK_D39AF213C604D5C6 FOREIGN KEY (pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE sucursal ADD CONSTRAINT FK_E99C6D567D879E4F FOREIGN KEY (negocio_id) REFERENCES negocio (id)');
        $this->addSql('ALTER TABLE sucursal ADD CONSTRAINT FK_E99C6D5667707C89 FOREIGN KEY (localidad_id) REFERENCES localidad (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE localidad DROP FOREIGN KEY FK_4F68E0104E7121AF');
        $this->addSql('ALTER TABLE negocio_usuario DROP FOREIGN KEY FK_DB78FF57D879E4F');
        $this->addSql('ALTER TABLE negocio_usuario DROP FOREIGN KEY FK_DB78FF5DB38439E');
        $this->addSql('ALTER TABLE provincia DROP FOREIGN KEY FK_D39AF213C604D5C6');
        $this->addSql('ALTER TABLE sucursal DROP FOREIGN KEY FK_E99C6D567D879E4F');
        $this->addSql('ALTER TABLE sucursal DROP FOREIGN KEY FK_E99C6D5667707C89');
        $this->addSql('DROP TABLE localidad');
        $this->addSql('DROP TABLE negocio');
        $this->addSql('DROP TABLE negocio_usuario');
        $this->addSql('DROP TABLE pais');
        $this->addSql('DROP TABLE provincia');
        $this->addSql('DROP TABLE sucursal');
    }
}
