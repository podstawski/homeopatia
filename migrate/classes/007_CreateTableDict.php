<?php

class CreateTableDict extends Doctrine_Migration_Base
{
  

    public function up()
    {
        Doctrine_Manager::connection()->exec("
            CREATE TABLE dict (
                id INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
                table_name Varchar(32),
                table_id Integer,
                lang Varchar(2),
                body TEXT CHARACTER SET utf8,
                FULLTEXT (body)
            );
            
        ");
    }

    public function down()
    {
        Doctrine_Manager::connection()->exec("
            DROP TABLE dict;
        ");
    }
}
