<?php

class NMM_Object {
	
	private $_db;
	private $_fields;
	private $_fields_arr;
	private $_table;
	
	function __construct($table, $db) {
		$this->_db = $db;
		$this->_table = $table;
		$this->_fields_arr = $this->_db->getFieldNamesToArray($table);
		$this->_fields = (object) $this->_fields_arr;
	}
	
	public function get($fieldName=null) {
		if($fieldName == null)
			return $this->_fields;
		else
			return $this->_fields->$fieldName;
	}
	
	public function set($fieldName, $value) {
		$this->_fields->$fieldName = $value;
	}
	
	public function fill($where) {
		$adp = $this->_db->getAdapter();
		
		$adp->connect();
		$result = $adp->query("SELECT * FROM ".$this->_table." WHERE ".$where." LIMIT 1");
		$row    = $adp->fetch($result);
		
		foreach(array_keys($row) as $key)
		{
			$this->_fields->$key = $row[$key];
		}
		
		$adp->free_results($result);
		$adp->disconnect();
	}
	
	public function insert() {
		$columns = "";
		$values  = "";
		$adp = $this->_db->getAdapter();
		
		foreach(array_keys($this->_fields_arr) as $key)
		{
			if($this->_fields->$key != null && !empty($this->_fields->$key)) {
				$columns .= $key.", ";
				$values  .= "'".$this->_fields->$key."', ";
			}
		}
		
		$columns = substr($columns, 0, -2);
		$values  = substr($values,  0, -2);
		$query = "INSERT INTO ".$this->_table." (".$columns.") VALUES (".$values.")";
	
		$adp->connect();
		$adp->query($query);
		$adp->disconnect();
	}
	
	public function update() {
		$adp = $this->_db->getAdapter();
		
		$query = "UPDATE ".$this->_table." SET ";
		$i = count($this->_fields_arr);
		foreach(array_keys($this->_fields_arr) as $key)
		{
			$query .= $key." = '". $this->_fields->$key."'";
			if($i > 1)
				$query .= ", ";	
			$i--;
		}
		$query .= " WHERE nform_id = 1";
		
		$adp->connect();
		$adp->query($query);
		$adp->disconnect();
	}
	
	public function delete($where) {
		$adp = $this->_db->getAdapter();
		$adp->connect();
		$adp->query("DELETE FROM ".$this->_table." WHERE ".$where);
		$adp->disconnect();
	}
}

?>
