<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190104161942 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, category_id INT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_3535ED97E3C61F9 (owner_id), INDEX IDX_3535ED912469DE2 (category_id), INDEX IDX_3535ED98BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE busy_days (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, date DATE DEFAULT NULL, INDEX IDX_F162CFA73243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, author VARCHAR(255) NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_9474526C3243BB18 (hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED97E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED98BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE busy_days ADD CONSTRAINT FK_F162CFA73243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE busy_days DROP FOREIGN KEY FK_F162CFA73243BB18');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C3243BB18');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED912469DE2');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED97E3C61F9');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED98BAC62AF');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE busy_days');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE comment');
    }
}
