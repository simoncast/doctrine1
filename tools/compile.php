<?php

define('DOCTRINE_PATH', dirname(__FILE__) . '/../lib');
define('COMPILE_SAVE_PATH', dirname(__FILE__) . '/../compiled');

require_once(DOCTRINE_PATH . DIRECTORY_SEPARATOR . 'Doctrine.php');
spl_autoload_register(array('Doctrine', 'autoload'));

$drivers = array(
  'all' => array('db2', 'mssql', 'mysql', 'oracle', 'pgsql', 'sqlite'),  
  'sqlite' => array('sqlite'),
  'mysql' => array('mysql'),
  'mysql_sqlite' => array('mysql', 'sqlite'),
  'pgsql' => array('pgsql'),
  'pgsql_sqlite' => array('pgsql', 'sqlite'),
  'oracle' => array('oracle'),    
  'mssql' => array('mssql'),    
  'db2' => array('db2')
);

foreach($drivers as $name => $_drivers)
{
  Doctrine_Core::compile(COMPILE_SAVE_PATH . sprintf('/Doctrine.%s.php', $name), $_drivers);
  printf('Compiled version for "%s" saved.', $name == 'all' ? 'all drivers' : join(', ', $_drivers));
  echo "\n";
}
