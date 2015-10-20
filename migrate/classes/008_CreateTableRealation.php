<?php

class CreateTableRelation extends Doctrine_Migration_Base
{
    private $_tableName = 'relation';
    
    private $_fk = [
        'fk_relation_master'=>['remedium','id','master_id'],
        'fk_relation_slave'=>['remedium','id','slave_id'],
        'fk_relation_book'=>['book','id','book_id'],
    ];   

    public function up()
    {
        $this->createTable($this->_tableName, array(
            'id' => array(
                'type' => 'integer',
                'notnull' => true,
                'primary' => true,
                'autoincrement' => true,
            ),
            'master_id' => array(
                'type' => 'Integer',
                'notnull' => false,
            ),
            'slave_id' => array(
                'type' => 'Integer',
                'notnull' => false,
            ),
            'book_id' => array(
                'type' => 'Integer',
                'notnull' => false,
            ),
            'relation' => array(
                'type' => 'Varchar(32)',
                'notnull' => false,
            )

        ), array('charset'=>'utf8'));
        
        foreach ($this->_fk AS $name=>$f) {
            $this->createForeignKey($this->_tableName, $name, array(
                 'local'         => $f[2],
                 'foreign'       => $f[1],
                 'foreignTable'  => $f[0],
                 'onDelete'      => 'CASCADE',
                 'onUpdate'      => 'CASCADE'
            ));
            $this->addIndex($this->_tableName,$name.'_key',array('fields'=>array($f[2])));
        }
    }

    public function down()
    {
        foreach ($this->_fk AS $name=>$f) $this->dropForeignKey($this->_tableName, $name);
        $this->dropTable($this->_tableName);
    }
}
