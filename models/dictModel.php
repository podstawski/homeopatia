<?php

class dictModel extends Model {
	protected $_table='dict';
	
	
	public function search($word,$lang) {
		
		$sql="SELECT * FROM ".$this->_table."
				WHERE lang=?
				AND MATCH (body) AGAINST (?)
		";
		
		
	}

}
