<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200922090134 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE organization (uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid_binary)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', profile_name VARCHAR(255) NOT NULL, profile_description LONGTEXT NOT NULL, profile_shor_description LONGTEXT NOT NULL, billing_information_company_name VARCHAR(255) DEFAULT NULL, billing_information_phone_number VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:phone_number)\', billing_information_email VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:email)\', billing_information_company_address_addressLine1 VARCHAR(255) DEFAULT NULL, billing_information_company_address_addressLine2 VARCHAR(255) DEFAULT NULL, billing_information_company_address_city VARCHAR(255) DEFAULT NULL, billing_information_company_address_region VARCHAR(255) DEFAULT NULL, billing_information_company_address_country VARCHAR(255) DEFAULT NULL, billing_information_company_address_zipCode VARCHAR(255) DEFAULT NULL, address_addressLine1 VARCHAR(255) DEFAULT NULL, address_addressLine2 VARCHAR(255) DEFAULT NULL, address_city VARCHAR(255) DEFAULT NULL, address_region VARCHAR(255) DEFAULT NULL, address_country VARCHAR(255) DEFAULT NULL, address_zipCode VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE organization');
    }
}
