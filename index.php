<?php
//Step 0: Define PTBR - Utf8
setlocale(LC_ALL, 'pt_BR.utf8');

//Step 1: Require the Slim Framework
require 'Slim/Slim.php';
require 'Attachments/database/samopaster.php';

\Slim\Slim::registerAutoloader();

// Step 2: Instantiate a Slim application
$app = new \Slim\Slim( array(

	// Configurações Iniciais
	'templates.path' => './Views',
	'debug' => true,

));

// Step 3: Define the Slim application routes
foreach( glob('./Controllers/*.php') AS $controller):
	
	// Executa o controler
	require $controller;

endforeach;

//Step 4: Run the Slim application
$app->run();