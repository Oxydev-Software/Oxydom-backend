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



        $sqltest = "INSERT INTO client (nom, prenom) VALUES ('Te','Te');";
        //$conn = new PDO("mysql:host=localhost;dbname=testfilrouge", 'root', '');
        // set the PDO error mode to exception
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        /*
        $result = Validator::Validate3(self::$sqltest);
        //self::Validate3();
        Executor::Execute($sqltest);

        Executor::SaveInLog($sqltest, '18/10/2018', 2);
        */


         //PARTIE RECUP REQUETE DANS LE FICHIER CSV

            extract(filter_input_array(INPUT_POST) );
            $fichier=$_FILES["userfile"]["name"];
            if ($fichier){
                //ouverture du fichier tempo
                //echo("ouverture du fichier");
                $fp = fopen($_FILES["userfile"]["tmp_name"],"r");
            }else{
                //fichier inconnu
                //echo("Fichier inconnu");

                //Desolé mais vous n'avez pas specifie de chemin valide !
                exit();
            }

            //Importation Réussie !


            //echo("Importation faite !");// importation
            //echo "<br/>\n<br/><br/><br/>";
            //declaration de la variable cpt qui permettra de compter le nombre d'enregistrement réalisé
            //C:\wamp64\www\import.php
            $cpt=0;
            while(!feof($fp)){
                $cpt+=1;
                $ligne = fgets($fp,4096);
                if ($ligne == ""){
                    //echo("Vide");
                    break;
                }
                //echo "ligne: $ligne";
                //on crée un tableau des éléments sépararés par des points virgules
                $liste = explode(";",$ligne);
                //echo "liste: $liste";
                $table = filter_input(INPUT_POST, 'userfile');
                //premier element
                //DANS CETTE CONFIG, LA REQUETE EST EN PREMIER ET LA DATE EN QUATRIEME ET IDCOMMERCIAL EN DEUXIO
                $liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
                $liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
                $liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
                $liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
                //echo "Premier element trouvé est (liste[0])=>".$liste[0]." !";
                //echo $liste[0];
                //echo " !";
                $champs1= $liste[0].'"'; //Correspond à la requete écrite dans le fic.csvcsv
                $champs2= $liste[1];	//Element 2 du fic.csv
                $champs3= $liste[2];	//Element 3 du fic.csv
                $champs4= '"'.$liste[3];	//Element 4 du fic.csv
                //echo "<br/>\n<br/><br/><br/>";
               // echo "champs1=>";
                //echo $champs1."<br/>";
                //echo "champs4=>";
                //echo $champs4."<br/>";
                //echo " !";
                //echo "<br/>\n<br/><br/><br/>";



                //APPEL METHODE DE VERIFICATION DE LA REQUETE
                $champs1 = substr($champs1, 1, -1);
                //echo("je vais envoyer ceci à vérifier:".$champs1);
                //echo "<br />";
                //echo("req qui marche: ".$sqltest);

                $resultBool = Validator::Validate3($champs1);
                if($resultBool){
                    //Validation true donc j'envoie à la vérification puis j'execute sur la BDD
                    //PARTIE VERIFICATION


                    //PARTIE EXECUTION
                    //echo("Cela a été validé, je go execute !");
                    $resultBoolExe = Executor::Execute($champs1);

                   $resultBoolSaveLog = Executor::SaveInLog($champs1, $champs4, $champs2);

                   if($resultBoolExe && $resultBoolSaveLog){
                       echo("TRAITEMENT CORRECT pour la ligne ".$cpt);
                       //APPEL DU COMMUNICATOR POUR LUI DIRE QUE LA LIGNE EST OK
                   }else{
                       echo("ERREUR D'EXECUTION POUR LA LIGNE".$cpt." ET DONT LA REQUETE EST:".$champs1);
                   };
                }
                else{
                    //echo ("Non valide..");
                    echo("ERREUR DE VALIDATION POUR LA LIGNE ".$cpt." ET DONT LA REQUETE EST:".$champs1);

                }


                echo "<br/>Fin ligne<br/>";
            } // fin de boucle

            //fermeture du fichier
            fclose($fp);





    }



}

SynchroManager::Test();