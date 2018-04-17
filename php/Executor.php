<?php

//include('config.php');
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
            //echo '<code> <pre>Résultat:'. print_r($result, true) .'</pre></code>';

            if ($result > 0){
                $comment = 'Requete qui a bien été exécuté, je vais procéder à lenreigistrement dans les log !';
                //echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
                $resultbool = true;
            }
            else {
                $comment2 = 'Requete incorrecte !';
                //echo '<code><pre>'. print_r($comment2, true) .'</pre></code>';
                $resultbool = false;
            }

        }
        catch(PDOException $e)
        {
            $comment = 'Requete synthaxiquement incorrecte !';
           // echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
            echo "Error Executor: " . $e->getMessage();
            $resultbool = false;
        }
        $conn = null;
        return $resultbool;
    }

    //Fonction sauvegardant les données dans les LOG
    public static  function SaveInLog($sql, $date, $author){

           //$result =  _insertSqlDateFr('18/10/2018');
            //echo '<code><pre>'. print_r($result, true) .'</pre></code>';
        $conn = new PDO('mysql:host=localhost;dbname=testfilrouge;charset=utf8', 'root', '');
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $date2 = _insertSqlDateFr($date);
        if (trim($sql) != '' && is_numeric($author)){
            $values = array(
                'Requete'      => $sql,
                'DateReq'      => $date2,
                'idCommercial' => $author
            );

            $insertLog = $conn->prepare('insert into '.TBL_Log.'(Requete, DateReq, idCommercial) values (:Requete, :DateReq, :idCommercial)');
            $result = $insertLog->execute($values);
            if ($result > 0){
                $comment = 'Requete qui a bien été exécuté  dans les log !';
                //echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
                $resultat = true;
            }
            else {
                $comment2 = 'Requete LOG synthaxiquement incorrecte !';
                //echo '<code><pre>'. print_r($comment2, true) .'</pre></code>';
                $resultat = false;
            }

        }

        else {
            //echo 'Erreur requette !';
            $resultat = false;
        }
        $conn = null;
        return $resultat;
        /*$data = array(
          array('name' => 'John', 'age' => '25'),
          array('name' => 'Wendy', 'age' => '32')
        );

        try {
          $pdo = new PDO('sqlite:myfile.sqlite');
        }

        catch(PDOException $e) {
          die('Unable to open database connection');
        }

        $insertStatement = $pdo->prepare('insert into mytable (name, age) values (:name, :age)');

        // start transaction
        $pdo->beginTransaction();

        foreach($data as &$row) {
          $insertStatement->execute($row);
        } */
    }

}