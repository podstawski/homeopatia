<?php

class CreateTableRemediumComplaint extends Doctrine_Migration_Base
{
    private $_tableName = 'rc';
    
    private $_fk = [
        'fk_rc_book'=>['book','id','book_id'],
        'fk_rc_remedium'=>['remedium','id','remedium_id'],
        'fk_rc_complaint'=>['complaint','id','complaint_id'],
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
            'remedium_id' => array(
                'type' => 'Integer',
                'notnull' => true,
            ),
            'book_id' => array(
                'type' => 'Integer',
                'notnull' => false,
            ),
            'complaint_id' => array(
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
