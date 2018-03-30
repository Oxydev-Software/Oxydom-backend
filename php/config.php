<?php
@session_start();

// Fonction autoload, charge les lib dont elle a besoin !
// Je remplace les _ par des /
function __autoload($className){
    $class = str_replace('_', '/', $className);
    require_once "BDD/".$class.'.php';
}

// Connexion TOM a la BDD
$db_inst = new DbObj('mysql:host=localhost;dbname=testfilrouge;charset=utf8', 'root', '');
Db::setInstance($db_inst);






/*function _config(){

    $config = array(
        'host' => 'localhost',
        'name' => 'testfilrouge',
        'user' => 'root',
        'pass' => ''
    );

    return $config;
}*/

/*
$insert = array(
    'nom' => 'toto',
    'prenom' => 'titi'
);

Db::insert('client', $insert);
*/


include_once ("Tables.php");
