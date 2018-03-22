<?php
echo("Test de rentré héhé");
extract(filter_input_array(INPUT_POST) );
$fichier=$_FILES["userfile"]["name"];
if ($fichier){
	//ouverture du fichier tempo
	echo("ouverture du fichier");
	$fp = fopen($_FILES["userfile"]["tmp_name"],"r");
}else{
	//fichier inconnu 
	echo("Fichier inconnu");
	?>
	<p align="center">-Importation échouée -</p>
	<p align="center"><B>Desolé mais vous n'avez pas specifie de chemin valide ! </B></p>
	<?php exit();
}
?>
<p align="center">-Importation Réussie !-</p>

<?php
echo("Importation faite !");// importation
echo "<br/>\n<br/><br/><br/>";
//declaration de la variable cpt qui permettra de compter le nombre d'enregistrement réalisé
//C:\wamp64\www\import.php
$cpt=0;
while(!feof($fp)){
	$ligne = fgets($fp,4096);
	echo "ligne: $ligne";
	//on crée un tableau des éléments sépararés par des points virgules
	$liste = explode(";",$ligne);
	//echo "liste: $liste";
	$table = filter_input(INPUT_POST, 'userfile');
	//premier element
	$liste[0] = ( isset($liste[0]) ) ? $liste[0] : Null;
	$liste[1] = ( isset($liste[1]) ) ? $liste[1] : Null;
	$liste[2] = ( isset($liste[2]) ) ? $liste[2] : Null;
	$liste[3] = ( isset($liste[3]) ) ? $liste[3] : Null;
	echo "Premier element trouvé est (liste[0])=>";
	echo $liste[0];
	echo " !";
	$champs1= $liste[0].'"'; //Correspond à la requete écrite dans le fic.csvcsv
	$champs2= $liste[1];	//Element 2 du fic.csv
	$champs3= $liste[2];	//Element 3 du fic.csv
	$champs4= '"'.$liste[3];	//Element 4 du fic.csv
	echo "<br/>\n<br/><br/><br/>";
	echo "champs1=>";
	echo $champs1."<br/>";
	echo "champs4=>";
	echo $champs4."<br/>";
	echo " !";
	echo "<br/>\n<br/><br/><br/>";
	$db = null;
	//En cas d'intégration à la BDD, variable prenant la date d'aujourdui
	//$datetest = $champs4;
	$datetest = "2015-10-22";
	$db = new mysqli('mysql-linkyu.alwaysdata.net', 'linkyu_madera', 'M@d3r4', 'linkyu_madera_db_test');
		if ($db->connect_error) {
			die("Connection failed: " . $db->connect_error);
		}
		$sql2 = "SELECT Requete FROM log WHERE DateReq = '$datetest'"; 
		$result2 = $db-> query($sql2)->fetch_assoc();
		echo "Result2 de la requete SELECT:  taille -> ";
		$size =  sizeof($result2);
		echo $size;
		echo "<br/>\n<br/>";
		if($size == 0){
			//Alors pas de resultat à cette date dans la BDD
			$result2 = '';
			echo "Pas de résultat pour cette date dans la BDD (doit etre vide)!";
		}else{
			//On a un résultat à cette date dans la BDD donc il n'y aura pas d'intégration à faire
			$result2 = current($result2);
			echo "Occurence trouvée pour cette date dans la BDD (!=vide) ->";
			//echo $result2;
		}
		
		
		//Prévoir boucle car il y aura plusieurs élément !!
		//$result = $result2[0]
		//$result2 = $result2['Requete'];
		echo "<br/>\n<br/>";
		echo "Result2  ->";
		echo $result2;
		echo " !!";
		echo "<br/>\n<br/><br/><br/>";		

		//Vérif si ya une requete à intégrer dans la BDD venant du fic.csv 
	if ($champs1=='"'){
		echo "champs vide, pas de requete, sauter cette ligne";
		//exit;
		break;
	}
	else if ($result2 ==''){
		//Comme on a pas de résultat dans la BDD alors on tente d'intégrer 
		if ($result2  == $champs1){
			
			//COMPARER DATE !!!!!!!!!!!!!!!!!!!
			
			echo "Champs identique"."<br/>";
			//A ne pas inserer dans la database car la requete déjà écrite dans la BDD est identique à celle qu'on veut intégrer
			echo"Pas d'integration dans les log";

		}
		else{
			//N'existe pas dans la database, à ajouter dans les log et à executer !

				//Ajout de la requete à la table log
				$champs1 = substr($champs1, 1, -1);
				$sql2 = $champs1;
				echo "On va tenter d'inserer dans la table log -> ".$champs1." et avec pour date= ".$datetest;
				$champs1 = addslashes($champs1);
				echo "<br/>\n<br/>";
				//$sql = "INSERT INTO log (Requete, DateReq) VALUES ('$champs1', '$datetest')";
				$sql = "INSERT INTO log (Requete, DateReq) VALUES ('$champs1', '$champs4')";
				$result = $db-> query($sql);
				echo "<br/>\n<br/>";
				echo "Result de l'insert dans la BDD -> ".$result;
				echo "<br/>\n<br/><br/><br/>";
				//echo "Champs non identique";
				//echo "Result est vide, du coup jy rentre les valeurs, champs1  ->".$champs1;
				//echo " !!";		


				//Execution de la requete
				echo "New Requete sql qu'on va executer dans la BDD ->";
				echo $sql2;
				echo " !!";
				$result3 = $db-> query($sql2);

				echo "<br/>\n<br/><br/><br/>";
				echo "Resultat de la tentative de l'execution  ->".$result3;
				//echo $result3;
				echo " !!";
				
				echo "<br/>\n<br/>FIN DE TRAITEMENT POUR CETTE LIGNE<br/><br/><br/><br/>";
				$cpt++;
			}
	}
	

	
		/*
			echo "Champs pas identique";
			//A integrer dans la database car requete inexistante
			$cpt++;
			$db = new mysqli('localhost', 'root', '', 'testfilrouge');


			$sql = ("INSERT INTO avancement(type, pourcentage, commentaire, date) VALUES('$champs1', '$champs2', '$champs3', '$champs4')");
			$result = $db-> query($sql);
			echo "Result donne ->";
			echo $result;

			$sql = ("INSERT INTO log(Requete, DateReq) VALUES('$result2', '$datetest')");
			$result = $db-> query($sql);
			//echo "Result donne ->";
			//echo $result;

			//PLUS Qu'a executer la requete venant du csv
			//String query = "LOAD DATA LOCAL INFILE 'C:\\Documents and Settings\\input.csv' INTO TABLE trial FIELDS TERMINATED BY ',' IGNORE 2 LINES"; 
			$sql = $champs1;
			$result = $db-> query($sql);
		
		*/
		

	//echo ""."\n";

	//echo "Ligne Suivante"."\r\n".$test;
	echo "Fin<br/>\n<br/><br/><br/>";
}
//fermeture du fichier
fclose($fp);
?>
<h3>Nombre de valeurs nouvellement enregistrees: </h3><b><?php echo $cpt;?></b>
