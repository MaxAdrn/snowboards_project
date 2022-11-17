<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221117010224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE snowboards ADD cambre_id INT NOT NULL, ADD marque_id INT NOT NULL, ADD niveau_id INT NOT NULL, ADD programme_id INT NOT NULL, ADD shape_id INT NOT NULL, ADD snowinsert_id INT NOT NULL, ADD taille VARCHAR(255) NOT NULL, ADD stock INT NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE snowboards ADD CONSTRAINT FK_87DBCD926112222 FOREIGN KEY (cambre_id) REFERENCES cambre (id)');
        $this->addSql('ALTER TABLE snowboards ADD CONSTRAINT FK_87DBCD94827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE snowboards ADD CONSTRAINT FK_87DBCD9B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE snowboards ADD CONSTRAINT FK_87DBCD962BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE snowboards ADD CONSTRAINT FK_87DBCD950266CBB FOREIGN KEY (shape_id) REFERENCES shape (id)');
        $this->addSql('ALTER TABLE snowboards ADD CONSTRAINT FK_87DBCD950C75CAE FOREIGN KEY (snowinsert_id) REFERENCES snowinsert (id)');
        $this->addSql('CREATE INDEX IDX_87DBCD926112222 ON snowboards (cambre_id)');
        $this->addSql('CREATE INDEX IDX_87DBCD94827B9B2 ON snowboards (marque_id)');
        $this->addSql('CREATE INDEX IDX_87DBCD9B3E9C81 ON snowboards (niveau_id)');
        $this->addSql('CREATE INDEX IDX_87DBCD962BB7AEE ON snowboards (programme_id)');
        $this->addSql('CREATE INDEX IDX_87DBCD950266CBB ON snowboards (shape_id)');
        $this->addSql('CREATE INDEX IDX_87DBCD950C75CAE ON snowboards (snowinsert_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE snowboards DROP FOREIGN KEY FK_87DBCD926112222');
        $this->addSql('ALTER TABLE snowboards DROP FOREIGN KEY FK_87DBCD94827B9B2');
        $this->addSql('ALTER TABLE snowboards DROP FOREIGN KEY FK_87DBCD9B3E9C81');
        $this->addSql('ALTER TABLE snowboards DROP FOREIGN KEY FK_87DBCD962BB7AEE');
        $this->addSql('ALTER TABLE snowboards DROP FOREIGN KEY FK_87DBCD950266CBB');
        $this->addSql('ALTER TABLE snowboards DROP FOREIGN KEY FK_87DBCD950C75CAE');
        $this->addSql('DROP INDEX IDX_87DBCD926112222 ON snowboards');
        $this->addSql('DROP INDEX IDX_87DBCD94827B9B2 ON snowboards');
        $this->addSql('DROP INDEX IDX_87DBCD9B3E9C81 ON snowboards');
        $this->addSql('DROP INDEX IDX_87DBCD962BB7AEE ON snowboards');
        $this->addSql('DROP INDEX IDX_87DBCD950266CBB ON snowboards');
        $this->addSql('DROP INDEX IDX_87DBCD950C75CAE ON snowboards');
        $this->addSql('ALTER TABLE snowboards DROP cambre_id, DROP marque_id, DROP niveau_id, DROP programme_id, DROP shape_id, DROP snowinsert_id, DROP taille, DROP stock, DROP updated_at');
    }
}
