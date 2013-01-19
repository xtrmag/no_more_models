<?php

class NMM_Object {
	
	private $_db;
	private $_fields;
	private $_fields_arr;
	private $_table;
	
	private $_primary_f;
	private $_primary_v;
	
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
	
	private function hasPrimary() {
		if(!empty($this->_primary_f) && !empty($this->_primary_v)) {
			return true;
		} else {
			return false;
		}
	}
	
	private function createWhereFromPrimary() {
		if($this->hasPrimary()) {
			$where =  $this->_primary_f." = ".$this->_primary_v;
			return $where;
		} else {
			NMM_Log::log("No primary key defined on ".$this->_table." table.", NMM_LOGLEVEL::ERROR);
			throw new Exception("No primary key defined on ".$this->_table." table.");
		}
	}
	
	public function setPrimary($fieldName, $value) {
		$this->_primary_f = $fieldName;
		$this->_primary_v = $value;
	}
	
	public function fill($where=null) {
	
		if($where==null) $where = $this->createWhereFromPrimary();
	
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
	
	public function update($where=null) {
	
		if($where==null) $where = $this->createWhereFromPrimary();
		
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
		$query .= " WHERE ".$where;
		
		$adp->connect();
		$adp->query($query);
		$adp->disconnect();
	}
	
	public function delete($where=null) {
	
		if($where==null) $where = $this->createWhereFromPrimary();
		
		$adp = $this->_db->getAdapter();
		$adp->connect();
		$adp->query("DELETE FROM ".$this->_table." WHERE ".$where);
		$adp->disconnect();
	}
}

?>
