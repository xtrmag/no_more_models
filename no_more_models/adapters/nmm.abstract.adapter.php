<?php
abstract class NMM_Abstract_Adapter {

	abstract protected function connect();
	abstract protected function query($sql);
	abstract protected function fetch($result);
	abstract protected function num_fields($result);
	abstract protected function fetch_fields($result, $i);
	abstract protected function free_results($result);
	abstract protected function disconnect();
	
}