<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605180710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE ingredients_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE recipe_ingredients_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE weekly_ingredients_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE weekly_recipes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ingredients (id INT NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE recipe_ingredients (id INT NOT NULL, recipe_id INT NOT NULL, ingredient_id INT NOT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9F925F2B59D8A214 ON recipe_ingredients (recipe_id)');
        $this->addSql('CREATE INDEX IDX_9F925F2B933FE08C ON recipe_ingredients (ingredient_id)');
        $this->addSql('CREATE TABLE weekly_ingredients (id INT NOT NULL, weekly_recipe_id INT NOT NULL, recipe_ingredient_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E28554D91205968 ON weekly_ingredients (weekly_recipe_id)');
        $this->addSql('CREATE INDEX IDX_E28554D93CAF64A ON weekly_ingredients (recipe_ingredient_id)');
        $this->addSql('CREATE TABLE weekly_recipes (id INT NOT NULL, recipe_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AB194EBA59D8A214 ON weekly_recipes (recipe_id)');
        $this->addSql('ALTER TABLE recipe_ingredients ADD CONSTRAINT FK_9F925F2B59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipe_ingredients ADD CONSTRAINT FK_9F925F2B933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE weekly_ingredients ADD CONSTRAINT FK_E28554D91205968 FOREIGN KEY (weekly_recipe_id) REFERENCES weekly_recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE weekly_ingredients ADD CONSTRAINT FK_E28554D93CAF64A FOREIGN KEY (recipe_ingredient_id) REFERENCES recipe_ingredients (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE weekly_recipes ADD CONSTRAINT FK_AB194EBA59D8A214 FOREIGN KEY (recipe_id) REFERENCES recipes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE ingredients_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE recipe_ingredients_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE weekly_ingredients_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE weekly_recipes_id_seq CASCADE');
        $this->addSql('ALTER TABLE recipe_ingredients DROP CONSTRAINT FK_9F925F2B59D8A214');
        $this->addSql('ALTER TABLE recipe_ingredients DROP CONSTRAINT FK_9F925F2B933FE08C');
        $this->addSql('ALTER TABLE weekly_ingredients DROP CONSTRAINT FK_E28554D91205968');
        $this->addSql('ALTER TABLE weekly_ingredients DROP CONSTRAINT FK_E28554D93CAF64A');
        $this->addSql('ALTER TABLE weekly_recipes DROP CONSTRAINT FK_AB194EBA59D8A214');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE recipe_ingredients');
        $this->addSql('DROP TABLE weekly_ingredients');
        $this->addSql('DROP TABLE weekly_recipes');
    }
}
