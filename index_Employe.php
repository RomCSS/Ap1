<?php session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
if (isset($_SESSION['typerole'])){
if ($_SESSION['typerole']=='Employe'){
?>
<!DOCTYPE html>
<html>
<head>
	<title>Index Employe</title>
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
		}
	</style>
</head>
<body>
	<h1>CRUD Employe</h1>
	<?php
	// Inclure le fichier requete.php pour établir la connexion à la base de données
	include('requete.php');

	// Vérifier si le formulaire de recherche a été soumis
	if(isset($_POST['search'])) {
		// Récupérer la valeur de recherche
		$search_value = $_POST['search_value']; 
		// Effectuer la requête de recherche
		$sql = "SELECT * FROM demande WHERE iddemande LIKE '%$search_value%' OR idpriorite LIKE '%$search_value%' OR assignement LIKE '%$search_value%' OR iduser LIKE '%$search_value%'";
	} else {
		// Si le formulaire n'a pas été soumis, récupérer toutes les données de la table demande
		$sql = "SELECT * FROM demande";
	}

	// On prépare la requête
	$query = $pdo->prepare($sql); 

	// On exécute la requête
	$query->execute();

	// On stocke le résultat dans un tableau associatif
	$result = $query->fetchAll(PDO::FETCH_ASSOC);

	// Vérifier s'il y a des données dans la table demande
	if ($result){
		// Afficher le formulaire de recherche
		echo '<form method="post" action="index_Employe.php">';
		echo '<input type="text" name="search_value" placeholder="Rechercher">';
		echo '<input type="submit" name="search" value="Rechercher">';
		echo '</form>';

		// Afficher la table des demandes
		echo '<table>';
		echo '<tr><th>ID demande</th><th>Etat</th><th>Priorité</th><th>Assignement</th><th>ID utilisateur</th><th>Actions</th></tr>';
		foreach($result as $row) {
			// Récupérer les informations d'état et de priorité à partir des tables correspondantes
			$query_etat = "SELECT etat FROM etat WHERE idetat=".$row['idetat'];
			$result_etat = $pdo->query($query_etat); 
			$etat = $result_etat->fetch(PDO::FETCH_ASSOC);

			$query_priorite = "SELECT priorite FROM priorite WHERE idpriorite=".$row['idpriorite'];
			$result_priorite = $pdo->query($query_priorite); 
			$priorite = $result_priorite->fetch(PDO::FETCH_ASSOC);

				// Récupérer le login de l'utilisateur à partir de la table user
			$query_user = "SELECT login FROM user WHERE iduser=".$row['iduser'];
			$result_user = $pdo->query($query_user); 
			$user = $result_user->fetch(PDO::FETCH_ASSOC);

// Afficher les informations de la demande dans la table
echo '<tr>';
echo '<td>'.$row['iddemande'].'</td>';
echo '<td>'.$etat['etat'].'</td>';
echo '<td>'.$priorite['priorite'].'</td>';
echo '<td>'.$row['assignement'].'</td>';
echo '<td>'.$user['login'].'</td>';
echo '<td>';
echo '<a href="update_employe.php?iddemande='.$row['iddemande'].'">Modifier</a> ';
echo '</tr>';
			}
			echo '</table>';
		} else {
			echo 'Aucune demande trouvée.';
		}
	
		// Fermer la connexion à la base de données
		$pdo = null;
	}
	}else{
		echo('session inexistante');
	}
	?>
	<br><br>
		<a href="login.php">Déconnexion</a>
    </body>
	
</html>

    
