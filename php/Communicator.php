<?php

//include('SynchroManager.php');
/**
 * Created by PhpStorm.
 * User: Faurever
 * Date: 22/03/2018
 * Time: 20:28
 */

//Class qui recevra en entrée le fichier csv de requete
//Retournera une réponse au client (résumé lui expliquant les requetes qui ont marché ou échoué) formatera en nJSON
//Composant non bloquant

//SynchroManager::Test();
echo ("Mathieu à glandé");
?>

<html>
<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
    <meta charset="utf-8" />
    <title>API Synchronisation !</title>
</head>
<body>
<h1> Bienvenue dans l'API de Synchronisation qui est toujours en Beta</h1>

<h3>Veuillez choisir un fichier .csv ! </h3>
<form method="post" enctype='multipart/form-data' action="./SynchroManager.php">
    <input type="file" name="userfile" value="table" />
    <input type="submit" name="submit" value="Importer"/>
</form>



</body>
</html>
