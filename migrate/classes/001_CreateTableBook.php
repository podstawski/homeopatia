<?php

class CreateTableBook extends Doctrine_Migration_Base
{
    private $_tableName = 'book';

    public function up()
    {
        
        $this->createTable($this->_tableName, array(
            'id' => array(
                'type' => 'integer',
                'notnull' => true,
                'primary' => true,
                'autoincrement' => true,
            ),
            'name' => array(
                'type' => 'character varying(100)',
                'notnull' => false,
            ),
            'author' => array(
                'type' => 'character varying(100)',
                'notnull' => false,
            ),
           
            

        ), array('charset'=>'utf8'));
        
       
    }

    public function down()
    {
        $this->dropTable($this->_tableName);
    }
}
