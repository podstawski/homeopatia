<?php

class rcModel extends Model {
	protected $_table='rc';
		
	public function find($complaint_id,$book_id,$remedium_id)
	{
		$sql="SELECT * FROM ".$this->_table." 
				WHERE complaint_id=?
				AND book_id=?
				AND remedium_id=?
			";
			
		return $this->conn->fetchRow($sql,[$complaint_id,$book_id,$remedium_id]);
	}
}
