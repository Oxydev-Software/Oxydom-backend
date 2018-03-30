<?php

include('config.php');
/**
 * Created by PhpStorm.
 * User: Faurever
 * Date: 22/03/2018
 * Time: 20:27
 */

//Class qui a pour mission d'executer la requete sur la BDD
//Element non bloquant
class Executor
{

    //Fonction executant la requete SQL déjà vérifiée
    public static function Execute($sql){

        //Execution REQ
        try {
            $conn = new PDO('mysql:host=localhost;dbname=testfilrouge;charset=utf8', 'root', '');
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            // prepare sql and bind parameters
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute();
            echo '<code> <pre>Résultat:'. print_r($result, true) .'</pre></code>';

            if ($result > 0){
                $comment = 'Requete qui a bien été exécuté, je vais procéder à lenreigistrement dans les log !';
                echo '<code><pre>'. print_r($comment, true) .'</pre></code>';

            }

        }
        catch(PDOException $e)
        {
            $comment = 'Requete synthaxiquement incorrecte !';
            echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
            echo "Error: " . $e->getMessage();

        }
        $conn = null;

    }

    //Fonction sauvegardant les données dans les LOG
    public static  function SaveInLog($sql, $date, $author){
        try {

            $values = array(
                'Requete' => $sql,
                'DateReq' => $date,
                'idCommercial' => $author
            );

            $result = Db::insert(TBL_Log, $values);
            echo '<code><pre>'. print_r($result, true) .'</pre></code>';

            if ($result > 0){
                $comment = 'Requete qui a bien été exécuté  dans les log !';
                echo '<code><pre>'. print_r($comment, true) .'</pre></code>';

            }
            else {
                $comment = 'Requete LOG synthaxiquement incorrecte !';
                echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
            }

        }
        catch(PDOException $e)
        {
            $comment = 'Requete LOG synthaxiquement incorrecte !';
            echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
            echo "Error: " . $e->getMessage();

        }
        $conn = null;
    }

}