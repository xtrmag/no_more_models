<?php
class NMM_LOGLEVEL {
	const ALL     = 4;
	const ERROR   = 3;
	const WARNING = 2;
	const DEBUG   = 1;
	const INFO    = 0;
}

class NMM_Log {
	static public function log($message, $loglevel) {
		global $config;
		if(!$config['logging']) return;
		if($config['logging'] >= $config['log_level']) {
			$file = $config['log_file'];
			$date = new DateTime();
			$msg  = "[".$date->format('Y-m-d H:i:s')."] ".$message."\n";
			file_put_contents($file, $msg, FILE_APPEND | LOCK_EX);
		}
	}
	
	static public function clear() {
		global $config;
		$file = $config['log_file'];
		file_put_contents($file, "");
	}
}

?>