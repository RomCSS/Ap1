<?php 
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (isset($_SESSION['typerole'])) {
	if ($_SESSION['typerole'] == 'Employe') {
		// Inclure le fichier requete.php pour établir la connexion à la base de données
		include('requete.php');

		// Vérifier si le formulaire de modification a été soumis
		if (isset($_POST['submit'])) {
			// Récupérer l'ID de la demande et l'état modifié
			$iddemande = $_POST['iddemande'];
			$idetat = $_POST['idetat'];

			// Mettre à jour l'état de la demande dans la base de données
			$sql = "UPDATE demande SET idetat=:idetat WHERE iddemande=:iddemande";
			$query = $pdo->prepare($sql);
			$query->bindParam(':idetat', $idetat, PDO::PARAM_INT);
			$query->bindParam(':iddemande', $iddemande, PDO::PARAM_INT);
			$query->execute();

			// Rediriger vers la page index_Employe
			header('Location: index_Employe.php');
			exit;
		}

		// Vérifier si l'ID de la demande est spécifié dans l'URL
		if (isset($_GET['iddemande'])) {
			$iddemande = $_GET['iddemande'];

			// Récupérer les informations de la demande à partir de la base de données
			$sql = "SELECT * FROM demande WHERE iddemande=:iddemande";
			$query = $pdo->prepare($sql);
			$query->bindParam(':iddemande', $iddemande, PDO::PARAM_INT);
			$query->execute();
			$result = $query->fetch(PDO::FETCH_ASSOC);

			// Vérifier si la demande existe dans la base de données
			if ($result) {
				// Récupérer les informations d'état à partir de la table correspondante
				$query_etat = "SELECT * FROM etat";
				$result_etat = $pdo->query($query_etat); 

				// Afficher le formulaire de modification
				echo '<!DOCTYPE html>';
				echo '<html>';
				echo '<head>';
				echo '<title>Modifier la demande</title>';
				echo '</head>';
				echo '<body>';
				echo '<h1>Modifier la demande</h1>';
				echo '<form method="post" action="update_employe.php">';
				echo '<input type="hidden" name="iddemande" value="'.$result['iddemande'].'">';
				echo 'État : <select name="idetat">';
				foreach($result_etat as $etat) {
					echo '<option value="'.$etat['idetat'].'"';
					if ($result['idetat'] == $etat['idetat']) {
						echo ' selected';
					}
					echo '>'.$etat['etat'].'</option>';
				}
				echo '</select><br><br>';
				echo '<input type="submit" name="submit" value="Enregistrer">';
				echo '</form>';
				echo '<br>';
				echo '<a href="index_Employe.php">Retour</a>';
				echo '</body>';
				echo '</html>';
			} else {
				echo 'La demande n\'existe pas.';
            }
            $pdo = null;
        }
        } else {
            echo('session inexistante');
        }
    }
        ?>