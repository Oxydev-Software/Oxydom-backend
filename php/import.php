<?php
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
	echo "liste[0]=>";
	echo $liste[0];
	echo " !";
	$champs1= $liste[0].'"';
	$champs2= $liste[1];
	$champs3= $liste[2];
	$champs4= '"'.$liste[3];
	echo "<br/>\n<br/><br/><br/>";
	echo "champs1=>";
	echo $champs1."<br/>";
	echo "champs4=>";
	echo $champs4."<br/>";
	echo " !";
	echo "<br/>\n<br/><br/><br/>";
	$db = null;
	$datetest = "2017-10-11";
	$db = new mysqli('mysql-linkyu.alwaysdata.net', 'linkyu_madera', 'M@d3r4', 'linkyu_madera_db_test');
		if ($db->connect_error) {
    	die("Connection failed: " . $db->connect_error);
}
		$sql2 = "SELECT Requete FROM log WHERE DateReq = '2017-10-11'"; 
		$result2 = $db-> query($sql2)->fetch_assoc();
		echo "Result2 partiel taille ->";
		$size =  sizeof($result2);
		echo $size;
		if($size == 0){
			$result2 = '';
		}else{
			$result2 = current($result2);
			echo "Result2 else ->";
			echo $result2;
		}
		
		
		//Prévoir boucle car il y aura plusieurs élément !!
		//$result = $result2[0]
		//$result2 = $result2['Requete'];
		echo "<br/>\n<br/><br/><br/>";
		echo "Result2  ->";
		echo $result2;
		echo " !!";	


	if ($champs1==''){
		echo "champs vide, pas de requete ->";
		exit;
	}
	if ($result2 ==''){
		if ($result2  == $champs1){

			//COMPARER DATE !!!!!!!!!!!!!!!!!!!

			echo "Champs identique";
			//A ne pas inserer dans la database
			echo"Pas d'integration dans les log";

		}
		else{
			//N'existe pas dans la database, à ajouter dans les log et à executer !

				//Ajout de la requete à la table log
				$champs1 = substr($champs1, 1, -1);
				echo "Test chaps1: ".$champs1." et date=".$datetest;
				$champs1 = addslashes($champs1);
				$sql = "INSERT INTO log (Requete, DateReq) VALUES ('$champs1', '$datetest')";
				$result = $db-> query($sql);
				echo "Result -> ".$result;
				echo "<br/>\n<br/><br/><br/>";
				//echo "Champs non identique";
				echo "Result est vide, du coup jy rentre les valeurs, champs1  ->";
				echo $champs1;
				echo " !!";		


				//Execution de la requete
				$sql = $champs1;
				$sql = substr($sql, 1);
				echo "<br/>\n<br/><br/><br/>";
				echo "Valeur de sql  ->";
				echo $sql;
				echo " !!";
					$result3 = $db-> query($sql);

				echo "<br/>\n<br/><br/><br/>";
				echo "Result3  ->";
				echo $result3;
				echo " !!";
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
	echo "<br/>\n<br/><br/><br/>";
}
//fermeture du fichier
fclose($fp);
?>
<h3>Nombre de valeurs nouvellement enregistrees: </h3><b><?php echo $cpt;?></b>
