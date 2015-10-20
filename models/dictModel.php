<?php

class dictModel extends Model {
	protected $_table='dict';
	
	
	public function search($word,$lang,$ids=[],$limit=0,$offset=0) {
		
		$sql="SELECT id FROM ".$this->_table."
				WHERE lang=?
				AND MATCH (body) AGAINST (?)
		";
		
		
	}

}
