<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925183232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coupon (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, currency VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql(<<<SQL
INSERT INTO application.product (id, title, price, currency) VALUES (1, 'Iphone', 100, 'EUR');
INSERT INTO application.product (id, title, price, currency) VALUES (2, 'Наушники', 20, 'EUR');
INSERT INTO application.product (id, title, price, currency) VALUES (3, 'Чехол', 10, 'EUR');

INSERT INTO application.coupon (id, type, code, amount) VALUES (1, 'percent', 'percent', 50);
INSERT INTO application.coupon (id, type, code, amount) VALUES (2, 'fixed', 'fixed', 20);

SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE product');
    }
}
