<?php

include_once ('config.php');
include_once('Validator.php');
include_once ('Executor.php');

/**
 * Created by PhpStorm.
 * User: Faurever
 * Date: 22/03/2018
 * Time: 20:07
 */

//Class faisant le lien entre tous les composants Executor, Communicator, Validator, Verificator
//Composant maitre BLOQUANT
class SynchroManager
{

    const HOST = 'user';


    public static function Test(){

        $sqltest = "INSERT INTO client (nom, prenom) VALUES ('Test','Test');";
        //$conn = new PDO("mysql:host=localhost;dbname=testfilrouge", 'root', '');
        // set the PDO error mode to exception
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Validator::Validate3(self::$sqltest);
        //self::Validate3();
        Executor::Execute($sqltest);

        Executor::SaveInLog($sqltest, '18/10/2018', 2);

    }



}

SynchroManager::Test();