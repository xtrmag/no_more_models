<?php

class NMM_Log {
	static public function log($message) {
		$file = "mnn.log";
		$date = new DateTime();
		$msg  = "[".$date->format('Y-m-d H:i:s')."] ".$message."\n";
		file_put_contents($file, $msg, FILE_APPEND | LOCK_EX);
	}
	
	static public function clear() {
		$file = "mnn.log";
		file_put_contents($file, "");
	}
}

?>