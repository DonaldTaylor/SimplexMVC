<?php
	
	$settings = array();
	
	// routes
	$settings['routes'] = array(
	  'index' => 'RootController',
	  '404' => 'NotFoundController'
	);
	
	// environment
	$settings['timeZone'] = 'America/Chicago';
	$settings['useTestMode'] = false;

	// database credentials
	$settings['databaseHost'] = '';
	$settings['databaseName'] = '';
	$settings['databaseUser'] = '';
	$settings['databasePassword'] = '';
	
	// log file
	$settings['logFilePath'] = 'logs/log.log';
	$settings['logFileMaxSizeMegabytes'] = 5;
  																			 
?>
