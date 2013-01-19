<?php
class NMM_Std_Postgres_Adapter extends NMM_Abstract_Adapter {

	private $_con;

	public function connect(){
		global $config;
		$connectString = 'host=' . $config['host'] 
			. ' port=' . $config['port'] 
			. ' dbname=' . $config['database'] 
			. ' user=' . $config['user']
			. ' password=' . $config['password'];
		
		$this->_con = pg_connect($connectString);
		if(!$this->_con) throw new Exception('Could not connect: ' . pg_last_error());
	}
	
	public function query($sql) {
		$result = pg_query($sql); 
		if(!$result) throw new Exception('Query failed: ' . pg_last_error());
		return $result;
	}
	
	public function fetch($result) {
		return pg_fetch_assoc($result);
	}
	
	public function num_fields($result) {
		return pg_num_fields($result);
	}
	
	public function fetch_fields($result, $i) {
		return pg_field_name($result, $i);
	}
	
	public function free_results($result) {
		pg_free_result($result);
	}	
	
	public function disconnect() {
		pg_close($this->_con);
	}
}
?>
