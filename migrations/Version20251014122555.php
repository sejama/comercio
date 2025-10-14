<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014122555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE precio_historico (id INT AUTO_INCREMENT NOT NULL, producto_id INT DEFAULT NULL, precio DOUBLE PRECISION NOT NULL, fecha_desde DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', fecha_hasta DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_732B0CC37645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_movimiento (id INT AUTO_INCREMENT NOT NULL, producto_id INT DEFAULT NULL, cantidad INT NOT NULL, fecha DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', referencia VARCHAR(255) NOT NULL, comentario VARCHAR(255) DEFAULT NULL, tipo VARCHAR(255) NOT NULL, INDEX IDX_66B6E7D67645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE precio_historico ADD CONSTRAINT FK_732B0CC37645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE stock_movimiento ADD CONSTRAINT FK_66B6E7D67645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE producto ADD precio_actual DOUBLE PRECISION NOT NULL, ADD stock_actual DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE precio_historico DROP FOREIGN KEY FK_732B0CC37645698E');
        $this->addSql('ALTER TABLE stock_movimiento DROP FOREIGN KEY FK_66B6E7D67645698E');
        $this->addSql('DROP TABLE precio_historico');
        $this->addSql('DROP TABLE stock_movimiento');
        $this->addSql('ALTER TABLE producto DROP precio_actual, DROP stock_actual');
    }
}
