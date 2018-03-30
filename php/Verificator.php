<?php
/**
 * Created by PhpStorm.
 * User: Faurever
 * Date: 22/03/2018
 * Time: 20:29
 */

//Class qui auront pour role d'aller check dans la table log si la requete est déjà existante ou non
//Devra retourner une réponse au Manager
//Composant non bloquant
class Verificator
{

    public function Verif($date, $id){
        //Dans mon idée, il return vraie pour requete non présente dans les log et false dans le cas contraire
        $db = new mysqli('mysql-linkyu.alwaysdata.net', 'linkyu_madera', 'M@d3r4', 'linkyu_madera_db_test');
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }
        $sql = "SELECT Requete FROM log WHERE DateReq = '$date' AND log.idCommercial = $id ";
        $result2 = $db-> query($sql)->fetch_assoc();
        //echo "Result2 de la requete SELECT:  taille -> ";
        $size =  sizeof($result2);
        //echo $size;
        //echo "<br/>\n<br/>";
        if($size == 0){
            //Alors pas de resultat à cette date dans la BDD et avec tel id de commercial
            echo "Pas de résultat pour cette date dans la BDD (doit etre vide)!";
            return true;
        }else{
            //On a un résultat à cette date dans la BDD donc il n'y aura pas d'intégration à faire
            //$result2 = current($result2);
            echo "Occurence trouvée pour cette date dans la BDD (!=vide) ->";
            //echo $result2;
            return false;
        }


    }
}