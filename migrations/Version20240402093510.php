<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402093510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, bio LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_album (user_id INT NOT NULL, album_id INT NOT NULL, INDEX IDX_DB5A951BA76ED395 (user_id), INDEX IDX_DB5A951B1137ABCF (album_id), PRIMARY KEY(user_id, album_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_album ADD CONSTRAINT FK_DB5A951BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_album ADD CONSTRAINT FK_DB5A951B1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4349ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA11137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E4349ABEB17');
        $this->addSql('ALTER TABLE user_album DROP FOREIGN KEY FK_DB5A951BA76ED395');
        $this->addSql('ALTER TABLE user_album DROP FOREIGN KEY FK_DB5A951B1137ABCF');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE user_album');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA11137ABCF');
    }
}
