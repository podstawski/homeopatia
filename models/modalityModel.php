<?php

class modalityModel extends Model {
	protected $_table='modality';
	
	public function find($lang,$modality,$book,$remedium=null,$complaint=null)
	{
		$sql="SELECT dict.*,".$this->_table.".id AS ".$this->_table." FROM dict
				LEFT JOIN ".$this->_table." ON dict.table_name='".$this->_table."' AND ".$this->_table.".id=dict.table_id
				WHERE dict.lang=? AND dict.body=? AND book_id=?
				";
		if ($remedium) $sql.=" AND remedium_id=".($remedium+0);
		if ($complaint) $sql.=" AND complaint_id=".($complaint+0);
		
		return $this->conn->fetchRow($sql,[$lang,$modality,$book]);
	}
	
	public function add($modality,$betterORworse,$lang,$book,$remedium=null,$complaint=null)
	{
		$model=new modalityModel();
		$model->remedium_id=$remedium;
		$model->complaint_id=$complaint;
		$model->book_id=$book;
		$model->modality=$betterORworse;
		$model->save();
		
		$dict=new dictModel();
		$dict->table_name=$this->_table;
		$dict->table_id=$model->id;
		$dict->lang=$lang;
		$dict->body=$modality;
		
		return $dict->save();
	}
}
