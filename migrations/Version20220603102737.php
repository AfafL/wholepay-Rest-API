<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220603102737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advance (id INT AUTO_INCREMENT NOT NULL, expense_id INT NOT NULL, participant_user_id INT NOT NULL, participant_amount DOUBLE PRECISION NOT NULL, INDEX IDX_E7811BF3F395DB7B (expense_id), INDEX IDX_E7811BF33D631C9D (participant_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, paid_by_user_id INT NOT NULL, wholepay_id INT NOT NULL, title VARCHAR(255) NOT NULL, amount DOUBLE PRECISION NOT NULL, date DATETIME NOT NULL, INDEX IDX_2D3A8DA6B63F5575 (paid_by_user_id), INDEX IDX_2D3A8DA683F98AD3 (wholepay_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation (id INT AUTO_INCREMENT NOT NULL, wholepay_id INT NOT NULL, email VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_F11D61A283F98AD3 (wholepay_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invitation_user (invitation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_40921A1DA35D7AF0 (invitation_id), INDEX IDX_40921A1DA76ED395 (user_id), PRIMARY KEY(invitation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, avatar_id INT NOT NULL, name VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(100) NOT NULL, INDEX IDX_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wholepay_event (id INT AUTO_INCREMENT NOT NULL, creator_user_id INT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(100) NOT NULL, currency VARCHAR(50) NOT NULL, category VARCHAR(100) NOT NULL, INDEX IDX_A869E05329FC6AE1 (creator_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wholepay_event_user (wholepay_event_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_58A2943F62AB7F61 (wholepay_event_id), INDEX IDX_58A2943FA76ED395 (user_id), PRIMARY KEY(wholepay_event_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advance ADD CONSTRAINT FK_E7811BF3F395DB7B FOREIGN KEY (expense_id) REFERENCES expense (id)');
        $this->addSql('ALTER TABLE advance ADD CONSTRAINT FK_E7811BF33D631C9D FOREIGN KEY (participant_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6B63F5575 FOREIGN KEY (paid_by_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA683F98AD3 FOREIGN KEY (wholepay_id) REFERENCES wholepay_event (id)');
        $this->addSql('ALTER TABLE invitation ADD CONSTRAINT FK_F11D61A283F98AD3 FOREIGN KEY (wholepay_id) REFERENCES wholepay_event (id)');
        $this->addSql('ALTER TABLE invitation_user ADD CONSTRAINT FK_40921A1DA35D7AF0 FOREIGN KEY (invitation_id) REFERENCES invitation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invitation_user ADD CONSTRAINT FK_40921A1DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id)');
        $this->addSql('ALTER TABLE wholepay_event ADD CONSTRAINT FK_A869E05329FC6AE1 FOREIGN KEY (creator_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wholepay_event_user ADD CONSTRAINT FK_58A2943F62AB7F61 FOREIGN KEY (wholepay_event_id) REFERENCES wholepay_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE wholepay_event_user ADD CONSTRAINT FK_58A2943FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE advance DROP FOREIGN KEY FK_E7811BF3F395DB7B');
        $this->addSql('ALTER TABLE invitation_user DROP FOREIGN KEY FK_40921A1DA35D7AF0');
        $this->addSql('ALTER TABLE advance DROP FOREIGN KEY FK_E7811BF33D631C9D');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6B63F5575');
        $this->addSql('ALTER TABLE invitation_user DROP FOREIGN KEY FK_40921A1DA76ED395');
        $this->addSql('ALTER TABLE wholepay_event DROP FOREIGN KEY FK_A869E05329FC6AE1');
        $this->addSql('ALTER TABLE wholepay_event_user DROP FOREIGN KEY FK_58A2943FA76ED395');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA683F98AD3');
        $this->addSql('ALTER TABLE invitation DROP FOREIGN KEY FK_F11D61A283F98AD3');
        $this->addSql('ALTER TABLE wholepay_event_user DROP FOREIGN KEY FK_58A2943F62AB7F61');
        $this->addSql('DROP TABLE advance');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE invitation');
        $this->addSql('DROP TABLE invitation_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wholepay_event');
        $this->addSql('DROP TABLE wholepay_event_user');
    }
}
