<?php

class descModel extends Model {
	protected $_table='description';
	
	
	public function find($lang,$book,$remedium)
	{
		$sql="SELECT dict.* FROM dict
				LEFT JOIN ".$this->_table." ON dict.table_name='".$this->_table."' AND ".$this->_table.".id=dict.table_id
				WHERE dict.lang=?
				AND ".$this->_table.".book_id=?
				AND ".$this->_table.".remedium_id=?
			";
			
		return $this->conn->fetchRow($sql,[$lang,$book,$remedium]);
	}
	
	
	public function add ($desc,$lang,$book,$remedium)
	{
		$model=new descModel();
		$model->remedium_id=$remedium;
		$model->book_id=$book;
		$model->save();
		
		$dict=new dictModel();
		$dict->table_name=$this->_table;
		$dict->table_id=$model->id;
		$dict->lang=$lang;
		$dict->body=$desc;
		
		return $dict->save();
	}

}
