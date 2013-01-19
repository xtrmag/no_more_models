<?php
include "nmm.log.php";
include "nmm.conf.php";
include "adapters/nmm.abstract.adapter.php";
include "adapters/nmm.std.mysql.adapter.php";
include "adapters/nmm.std.postgres.adapter.php";
include "nmm.db.php";
include "nmm.obj.php";

class NMM {

	private $_db;
	private $_adp;
	static private $instance;
	
	function __construct() {
		global $config;
		$this->_adp = new $config['adapter']();
		$this->_db  = new NMM_DB($this->_adp);
	}
	
	public static function getInstance()
	{
		if ( is_null( self::$instance ) )
		{
		  self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function getDB() {
		return $this->_db;
	}
	
	public function getADP() {
		return $this->_adp;
	}
	
	public function deleteCache() {
		global $config;
		if ($handle = opendir($config['cache_dir'])) {
			while (false !== ($entry = readdir($handle))) {
				if($entry != ".." && $entry != ".") {
					unlink($config['cache_dir']."/".$entry);
				}
			}
			NMM_Log::log("Cache deleted.", NMM_LOGLEVEL::INFO);
		} else {
			NMM_Log::log("Can't open cache directory.", NMM_LOGLEVEL::ERROR);
		}
	}
	
	public function createObject($tableName) {
		return new NMM_Object($tableName, $this->_db);
	}
	
	public function fetchRow($tableName, $where, $retObject=false) {
		$obj = $this->createObject($tableName);
		$obj->fill($where);
		if($retObject == true)
			return $obj;
		else
			return $obj->get();
	}
	
	public function fetchAll($tableName, $limit, $retObject=false) {
	}
}

?>
