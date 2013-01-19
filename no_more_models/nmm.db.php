<?php
class NMM_DB {

	private $_adapter;
	private $_cache;
	private $_cacheFolder;
	private $_cahceLifeTime;
	
	function __construct($adapter) {
		global $config;
		$this->_adapter = $adapter;
	
		if($config['cacheing']) {
			$this->_cache = true;
			$this->_cacheFolder   = $config['cache_dir'];
			$this->_cahceLifeTime = $config['cache_time'];
		} else {
			$this->_cache = false;
		}
	}

	public function setAdapter($adapter) {
		$this->_adapter = $adapter;
	}
	
	public function getAdapter() {
		return $this->_adapter;
	}
	
	private function cacheFieldNames($fieldNameArr, $tableName) {
		$file = $this->_cacheFolder."/".$tableName;
		if(!file_exists($file) || filemtime($file) <= time()-$this->_cahceLifeTime) {
			$content = serialize($fieldNameArr);
			file_put_contents($file, $content);
			NMM_Log::log("table: ".$tableName." cached.", NMM_LOGLEVEL::INFO);
		}
	}
	
	private function checkCache($tableName) {
		$file = $this->_cacheFolder."/".$tableName;
		if(file_exists($file)) {
			return unserialize(file_get_contents($file));
		} else
			return null;
	}
	
	public function getFieldNamesToArray($tableName) {
	
		$obj_arr = ($this->_cache) ? $this->checkCache($tableName) : null;
		$i = 0;
		
		if($obj_arr == null) 
		{		
			$this->_adapter->connect();
			$result = $this->_adapter->query('select * from '.$tableName);
			
			while ($i < $this->_adapter->num_fields($result)) 
			{
				$name = $this->_adapter->fetch_fields($result, $i);
				$obj_arr[$name] = "";
				$i++;
			}
		}
		
		if ($this->_cache) $this->cacheFieldNames($obj_arr, $tableName);
		return $obj_arr;
	}
	
	public function getEmptyObject($tableName) {
			return (object) $this->getFieldNamesToArray($tableName);
	}
	
}
?>