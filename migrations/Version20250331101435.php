<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331101435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE course_trainer (course_id INT NOT NULL, trainer_id INT NOT NULL, INDEX IDX_CDD60DCC591CC992 (course_id), INDEX IDX_CDD60DCCFB08EDF6 (trainer_id), PRIMARY KEY(course_id, trainer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE trainer (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', modified_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_trainer ADD CONSTRAINT FK_CDD60DCC591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_trainer ADD CONSTRAINT FK_CDD60DCCFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES trainer (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course ADD content LONGTEXT NOT NULL, ADD created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', ADD modified_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE course_trainer DROP FOREIGN KEY FK_CDD60DCC591CC992
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course_trainer DROP FOREIGN KEY FK_CDD60DCCFB08EDF6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE course_trainer
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE trainer
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE course DROP content, DROP created_at, DROP modified_at
        SQL);
    }
}
