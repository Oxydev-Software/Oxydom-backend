<?php
@session_start();

include_once ("Tables.php");
// Fonction autoload, charge les lib dont elle a besoin !
// Je remplace les _ par des /
function __autoload($className){
    $class = str_replace('_', '/', $className);
    require_once "BDD/".$class.'.php';
}

// Connexion TOM a la BDD
//$db_inst = new DbObj('mysql:host=localhost;dbname=testfilrouge;charset=utf8', 'root', '');
//Db::setInstance($db_inst);

/**
 * Convertie la date Fr pour la BDD
 * @param $date
 * @return bool
 */
function _insertSqlDateFr($date){
    if (preg_match("`([0-9]{2})\/([0-9]{2})\/([0-9]{4})`", $date, $m)){
        $new_date = $m[3].'-'.$m[2].'-'.$m[1];
        return $new_date;
        //echo '<code><pre>'. print_r($new_date, true) .'</pre></code>';
    }
}



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

/*
$values = array(
    'Requete'      => 'caca',
    'DateReq'      => '2018-03-30',
    'idCommercial' => 2
);
Db::insert(TBL_Log, $values);
*/