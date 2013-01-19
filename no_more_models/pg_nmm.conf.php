<?php
$config['host'] = 'localhost';
$config['port'] = '5432'; //mysql:'3306';
$config['database'] = 'test';
$config['user'] = 'postgres';
$config['password'] = '1234567';
$config['adapter'] = "NMM_Std_Postgres_Adapter"; //mysql:"NMM_Std_Mysql_Adapter";

//------------------------------------------
$config['cacheing'] = true;
$config['cache_dir']  = "cache";
$config['cache_time'] = 2*24*60*60;

$config['logging']  = true;
$config['log_level'] = NMM_LOGLEVEL::ALL;
$config['log_file'] = "nmm.log";
?>
