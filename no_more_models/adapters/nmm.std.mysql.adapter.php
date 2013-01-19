<?php
class NMM_Std_Mysql_Adapter extends NMM_Abstract_Adapter {

	private $_con;

	public function connect(){
		global $config;
		$this->_con = mysql_connect($config['host'].":".$config['port'], $config['user'], $config['password']);
		if(!$this->_con) throw new Exception('Could not connect: ' . mysql_error());
		mysql_select_db($config['database']);
	}
	
	public function query($sql) {
		$result = mysql_query($sql); 
		if(!$result) throw new Exception('Query failed: ' . mysql_error());
		return $result;
	}
	
	public function fetch($result) {
		return mysql_fetch_assoc($result);
	}
	
	public function num_fields($result) {
		return mysql_num_fields($result);
	}
	
	public function fetch_fields($result, $i) {
		$meta = mysql_fetch_field($result, $i);
		return $meta->name;
	}
	
	public function free_results($result) {
		mysql_free_result($result);
	}	
	
	public function disconnect() {
		mysql_close($this->_con);
	}
}
?>