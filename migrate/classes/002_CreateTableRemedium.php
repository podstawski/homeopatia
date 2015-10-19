<?php

class CreateTableRemedium extends Doctrine_Migration_Base
{
    private $_tableName = 'remedium';

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
            'short' => array(
                'type' => 'character varying(32)',
                'notnull' => false,
            ),
            'abbreviation' => array(
                'type' => 'character varying(32)',
                'notnull' => false,
            ),            
            
        ), array('charset'=>'utf8'));
        
    }

    public function down()
    {
        $this->dropTable($this->_tableName);
    }
}
