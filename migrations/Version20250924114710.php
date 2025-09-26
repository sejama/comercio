<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250924114710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria_producto ADD sucursal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categoria_producto ADD CONSTRAINT FK_96D7E705279A5D5E FOREIGN KEY (sucursal_id) REFERENCES sucursal (id)');
        $this->addSql('CREATE INDEX IDX_96D7E705279A5D5E ON categoria_producto (sucursal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria_producto DROP FOREIGN KEY FK_96D7E705279A5D5E');
        $this->addSql('DROP INDEX IDX_96D7E705279A5D5E ON categoria_producto');
        $this->addSql('ALTER TABLE categoria_producto DROP sucursal_id');
    }
}
