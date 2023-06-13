<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613131133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weekly_ingredients DROP CONSTRAINT fk_e28554d91205968');
        $this->addSql('ALTER TABLE weekly_ingredients DROP CONSTRAINT fk_e28554d93caf64a');
        $this->addSql('DROP INDEX idx_e28554d93caf64a');
        $this->addSql('DROP INDEX idx_e28554d91205968');
        $this->addSql('ALTER TABLE weekly_ingredients ADD ingredient_id INT NOT NULL');
        $this->addSql('ALTER TABLE weekly_ingredients ADD recipe_id INT NOT NULL');
        $this->addSql('ALTER TABLE weekly_ingredients DROP weekly_recipe_id');
        $this->addSql('ALTER TABLE weekly_ingredients DROP recipe_ingredient_id');
        $this->addSql('ALTER TABLE weekly_ingredients ADD CONSTRAINT FK_E28554D9933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE weekly_ingredients ADD CONSTRAINT FK_E28554D959D8A214 FOREIGN KEY (recipe_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E28554D9933FE08C ON weekly_ingredients (ingredient_id)');
        $this->addSql('CREATE INDEX IDX_E28554D959D8A214 ON weekly_ingredients (recipe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE weekly_ingredients DROP CONSTRAINT FK_E28554D9933FE08C');
        $this->addSql('ALTER TABLE weekly_ingredients DROP CONSTRAINT FK_E28554D959D8A214');
        $this->addSql('DROP INDEX IDX_E28554D9933FE08C');
        $this->addSql('DROP INDEX IDX_E28554D959D8A214');
        $this->addSql('ALTER TABLE weekly_ingredients ADD weekly_recipe_id INT NOT NULL');
        $this->addSql('ALTER TABLE weekly_ingredients ADD recipe_ingredient_id INT NOT NULL');
        $this->addSql('ALTER TABLE weekly_ingredients DROP ingredient_id');
        $this->addSql('ALTER TABLE weekly_ingredients DROP recipe_id');
        $this->addSql('ALTER TABLE weekly_ingredients ADD CONSTRAINT fk_e28554d91205968 FOREIGN KEY (weekly_recipe_id) REFERENCES weekly_recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE weekly_ingredients ADD CONSTRAINT fk_e28554d93caf64a FOREIGN KEY (recipe_ingredient_id) REFERENCES recipe_ingredients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e28554d93caf64a ON weekly_ingredients (recipe_ingredient_id)');
        $this->addSql('CREATE INDEX idx_e28554d91205968 ON weekly_ingredients (weekly_recipe_id)');
    }
}
