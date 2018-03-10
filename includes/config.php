<?php
ob_start();
session_start();

// Données de référence pour la base de données
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','blogtest');

$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// Mise en place du fuseau horaire
date_default_timezone_set('Europe/London');

// Mise en place de l'autoloader pour l'auto-chargement des classes 
/*http://php.net/manual/fr/language.oop5.autoload.php*/
function __autoload($class) {
   
   $class = strtolower($class);

	//if call from within assets adjust the path
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 	
	
	//if call from within admin adjust the path
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	}
	
	//if call from within admin adjust the path
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
	} 	
	
}
// Instanciation de la class user + connexion bdd
$user = new User($db); 