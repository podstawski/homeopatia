<?php

class CreateTableComplaint extends Doctrine_Migration_Base
{
    private $_tableName = 'complaint';
    
    private $_fk = [
        'fk_complaint_complaint'=>['complaint','id','parent_id'],
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
            'parent_id' => array(
                'type' => 'Integer',
                'notnull' => true,
            ),
           

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
