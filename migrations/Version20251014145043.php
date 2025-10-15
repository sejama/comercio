<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251014145043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pago (id INT AUTO_INCREMENT NOT NULL, venta_id INT DEFAULT NULL, fecha DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', forma_pago VARCHAR(255) NOT NULL, referencia VARCHAR(255) DEFAULT NULL, INDEX IDX_F4DF5F3EF2A5805D (venta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venta (id INT AUTO_INCREMENT NOT NULL, cliente_id INT DEFAULT NULL, fecha DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', total DOUBLE PRECISION DEFAULT NULL, estado VARCHAR(255) NOT NULL, forma_pago VARCHAR(255) NOT NULL, observacion VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8FE7EE55DE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venta_detalle (id INT AUTO_INCREMENT NOT NULL, venta_id INT DEFAULT NULL, producto_id INT NOT NULL, cantidad INT NOT NULL, precio_unitario DOUBLE PRECISION NOT NULL, subtotal DOUBLE PRECISION NOT NULL, INDEX IDX_82DFB1DCF2A5805D (venta_id), UNIQUE INDEX UNIQ_82DFB1DC7645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pago ADD CONSTRAINT FK_F4DF5F3EF2A5805D FOREIGN KEY (venta_id) REFERENCES venta (id)');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE55DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE venta_detalle ADD CONSTRAINT FK_82DFB1DCF2A5805D FOREIGN KEY (venta_id) REFERENCES venta (id)');
        $this->addSql('ALTER TABLE venta_detalle ADD CONSTRAINT FK_82DFB1DC7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pago DROP FOREIGN KEY FK_F4DF5F3EF2A5805D');
        $this->addSql('ALTER TABLE venta DROP FOREIGN KEY FK_8FE7EE55DE734E51');
        $this->addSql('ALTER TABLE venta_detalle DROP FOREIGN KEY FK_82DFB1DCF2A5805D');
        $this->addSql('ALTER TABLE venta_detalle DROP FOREIGN KEY FK_82DFB1DC7645698E');
        $this->addSql('DROP TABLE pago');
        $this->addSql('DROP TABLE venta');
        $this->addSql('DROP TABLE venta_detalle');
    }
}
