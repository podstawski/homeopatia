<?php

class complaintModel extends Model {
	protected $_table='complaint';
		

	public function find($lang,$complaint,$parent=null)
	{
		$sql="SELECT dict.*,".$this->_table.".id AS ".$this->_table." FROM dict
				LEFT JOIN ".$this->_table." ON dict.table_name='".$this->_table."' AND ".$this->_table.".id=dict.table_id
				WHERE dict.lang=? AND dict.body=?
				AND ".$this->_table.".parent_id";
		if (!is_null($parent)) $sql.='='.($parent+0);
		else $sql.=' IS NULL';
		
		return $this->conn->fetchRow($sql,[$lang,$complaint]);
	}
	
	public function add($complaint,$lang,$parent=null)
	{
		$model=new complaintModel();
		$model->parent_id=$parent;
		$model->save();
		
		$dict=new dictModel();
		$dict->table_name=$this->_table;
		$dict->table_id=$model->id;
		$dict->lang=$lang;
		$dict->body=$complaint;
		
		return $dict->save();
	}
	
	
}
