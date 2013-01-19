<?php
$config['host'] = 'localhost';
$config['port'] = '3306'; //pg:'5432';
$config['database'] = 'test';
$config['user'] = 'root';
$config['password'] = '';
$config['adapter'] = "NMM_Std_Mysql_Adapter"; //pg:"NMM_Std_Postgres_Adapter";

//------------------------------------------
$config['cacheing']   = true;
$config['cache_dir']  = "cache";
$config['cache_time'] = 2*24*60*60;

$config['logging']   = true;
$config['log_level'] = NMM_LOGLEVEL::ALL;
$config['log_file']  = "nmm.log";
?>