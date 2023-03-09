<?php 
// Inclure le fichier de connexion à la base de données
include('requete.php');

// Vérifier si l'identifiant de la demande à supprimer est présent dans l'URL
if(isset($_GET['iddemande'])) {
    // Récupérer l'identifiant de la demande à supprimer
    $iddemande = (int) $_GET['iddemande'];

    // Supprimer la demande de la base de données
    $sql = "DELETE FROM demande WHERE iddemande=?";
    $query = $pdo->prepare($sql);
    $result = $query->execute([$iddemande]);

    // Vérifier si la requête a été exécutée avec succès
    if($result) {
        // Rediriger vers la page d'accueil avec un message de succès
        header('Location: index_Responsable.php?success=1');
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supprimer demande</title>
</head>
<body>
    <?php if(isset($_GET['success']) && $_GET['success'] == '1') { ?>
        <p>Demande supprimée avec succès!</p>
    <?php } else { ?>
        <p>Êtes-vous sûr de vouloir supprimer cette demande?</p> 
        <form method="post" action="">
            <input type="submit" name="submit" value="Oui">
            <a href="index_Responsable.php">Non</a>
        </form>
    <?php } ?>
</body>
</html>

<label for="iduser">Employé en charge de la demande :</label>
<select name="iduser">
	<option value="">-- Sélectionner un Employé --</option>
	<?php while ($row = $resultemp->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['login'] . '"></option>';
      }
      ?>
</select>
$queryemp = "SELECT login FROM user WHERE idrole=3";
    $resultemp = $pdo->query($queryemp);