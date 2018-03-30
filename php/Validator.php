<?php


include_once ('config.php');


/**
 * Created by PhpStorm.
 * User: Faurever
 * Date: 22/03/2018
 * Time: 20:28
 */

//Class qui devra vérifier la validaité de la requete avant son check et son execution
//Retourne une réponse au Manager
//Composant possiblement BLOQUANT
class Validator
{
    public static $valid = true;


    /*
    public static function Validate($mysqli, $query) {

        cubrid_set_autocommit(0, false); // A VERIF !!
        echo 'MySQLi'.$mysqli;
        echo '';
        echo 'Myquery:'.$query;
        if ( trim($query) ) {
            // Remove comments # comment ; or  # comment newline
            // Remove SET @var=val;
            // Remove empty statements
            // Remove last ;
            // Put EXPLAIN in front of every MySQL statement (separated by ;)
            $query = "EXPLAIN " .
                preg_replace(Array("/#[^\n\r;]*([\n\r;]|$)/",
                    "/[Ss][Ee][Tt]\s+\@[A-Za-z0-9_]+\s*=\s*[^;]+(;|$)/",
                    "/;\s*;/",
                    "/;\s*$/",
                    "/;/"),
                    Array("","", ";","", "; EXPLAIN "), $query) ;

            foreach(explode(';', $query) as $q) {
                $result = $mysqli->query($q);
                $err = !$result ? $mysqli->error : false ;
                if ( ! is_object($result) && ! $err ) $err = "Unknown SQL error";
                if ( $err) return $err ;
            }
            return false ;
            //It wil return False if de query is OK (multiple ; separated statements allowed), or an error message stating the error if there is a syntax or other MySQL other (like non-existent table or column).
            KNOWN BUGS:
            //Queries with string literals containing # or ; will fail
            //MySQL errors with linenumbers: the linenumbers mostly don't match.
            //Does not work for MySQL statements other than SELECT, UPDATE, REPLACE, INSERT, DELETE

        }
    }*/

    public static function Validate3 ($sql) {

        try {
            $conn = new PDO('mysql:host=localhost;dbname=testfilrouge;charset=utf8', 'root', '');
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->beginTransaction(); // Début d'une transaction, désactivation du mode autocommit

            // prepare sql and bind parameters
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute();
            echo '<code> <pre>Résultat:'. print_r($result, true) .'</pre></code>';

            if ($result > 0){
                $comment = 'Requete qui a marché, je vais procéder au rollback !';
                echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
                $conn->rollBack();
            }
            else {
                $comment = 'Requete synthaxiquement incorrecte !';
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


        //DEUXIEME PARTIE QUI MARCHE TRES BIEN AVEC DONNE EN DUR !!!
        /*
        $insert = array(
            'nom' => 'toto',
            'prenom' => 'tutu'
        );

        $uid = Db::insert(TBL_Client, $insert);
        echo '<code><pre>'. print_r($uid, true) .'</pre></code>';

        if ($uid > 0){
            $comment = 'commit, ça a marché, je vais procéder au rollback !';
            echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
            //FlashMessage::add(FlashMessage::TYPE_SUCCESS, FlashMessage::ICON_SUCCESS, 'Success !', 'Requete SQL Valide !.');
            //Db::delete(TBL_Client,$insert);
            //echo '<code><pre>'. print_r('Rollback done !', true) .'</pre></code>';
        }
        else {
            $comment = 'Requete synthaxiquement incorrecte !';
            echo '<code><pre>'. print_r($comment, true) .'</pre></code>';
            //FlashMessage::add(FlashMessage::TYPE_ERROR, FlashMessage::ICON_ERROR, 'Error !', ' Synthaxe SQL incorrecte !');
        }
        //FlashMessage::afficheMessages();

        */
    }


    public static function Validate4 ($mysqli, $query) {
        /*$erg = $mysqli->query($query);
        if($erg) {
            //$mysqli->query('COMMIT;');
            echo 'commit';
            return true;
        }
        else{
            $mysqli->query('ROLLBACK;');
            echo('rollback');
            return false;
        }


        $db = new mysqli('localhost', 'root' , '','testfilrouge');
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        $erg = $db->query($query);
        if($erg) {
            //$mysqli->query('COMMIT;');
            echo 'commit, ça a marché, je vais procéder au rollback !';

            return true;
        }
        else{
            $db->query('ROLLBACK;');
            echo('rollback');
            return false;
        }
        */
    }


}

