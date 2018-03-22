<?php
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

    public static function Validate2($requeteSQL)
    {
        return self::$valid;
    }
    /*function Validate($mysqli, $query) {
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
                $result = $mysqli->query($q) ;
                $err = !$result ? $mysqli->error : false ;
                if ( ! is_object($result) && ! $err ) $err = "Unknown SQL error";
                if ( $err) return $err ;
            }
            return false ;
        }
    }*/
}