<?php

class CreateTableModality extends Doctrine_Migration_Base
{
    private $_tableName = 'modality';
    
    private $_fk = [
        'fk_modality_complaint'=>['complaint','id','complaint_id'],
        'fk_modality_remedium'=>['remedium','id','remedium_id'],
        'fk_modality_book'=>['book','id','book_id'],
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
            'complaint_id' => array(
                'type' => 'Integer',
                'notnull' => false,
            ),
            'remedium_id' => array(
                'type' => 'Integer',
                'notnull' => false,
            ),
            'book_id' => array(
                'type' => 'Integer',
                'notnull' => false,
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
