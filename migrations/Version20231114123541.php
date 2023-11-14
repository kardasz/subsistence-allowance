<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231114123541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create schema';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE business_trip (id UUID NOT NULL, employee_id UUID NOT NULL, country VARCHAR(255) NOT NULL, amount_due INT NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN business_trip.id IS \'(DC2Type:business_trip_id)\'');
        $this->addSql('COMMENT ON COLUMN business_trip.employee_id IS \'(DC2Type:employee_id)\'');
        $this->addSql('COMMENT ON COLUMN business_trip.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN business_trip.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE employee (id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN employee.id IS \'(DC2Type:employee_id)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE business_trip');
        $this->addSql('DROP TABLE employee');
    }
}
