<?php
 session_start();
 error_reporting(E_ALL);
 ini_set("display_errors", 1);
if (isset($_SESSION['typerole'])){
    if ($_SESSION['typerole']=='Responsable'){
    // Inclure le fichier requete.php pour établir la connexion à la base de données
    include('requete.php');

    // Vérifier si le formulaire de modification a été soumis
    if(isset($_POST['update'])) {
        // Récupérer les valeurs des champs
        $iddemande = (int) $_POST['iddemande'];
        $idetat = (int) $_POST['idetat'];
        $idpriorite = (int) $_POST['idpriorite'];
        $assignement = $_POST['assignement'];
        $iduser = (int) $_POST['iduser'];

        // Mettre à jour la demande dans la base de données
        $sql = "UPDATE demande SET idetat=?, idpriorite=?, assignement=?, iduser=? WHERE iddemande=?";
        $query = $pdo->prepare($sql);
        $result = $query->execute([$idetat, $idpriorite, $assignement, $iduser, $iddemande]);

        // Vérifier si la requête a été exécutée avec succès
        if($result){
            // Rediriger vers la page d'accueil avec un message de succès
            header('Location: index_Responsable.php?success=1');
            exit();
        }
    }

    // Récupérer l'identifiant de la demande à modifier
    $iddemande = (int) $_GET['iddemande'];

    // Récupérer les informations de la demande à partir de la base de données
    $sql = "SELECT * FROM demande WHERE iddemande=?";
    $query = $pdo->prepare($sql);
    $query->execute([$iddemande]);
    $demande = $query->fetch(PDO::FETCH_ASSOC);

    // Vérifier si la demande existe
    if(!$demande) {
        // Rediriger vers la page d'accueil avec un message d'erreur
        header('Location: index_Responsable.php?error=1');
        exit();
    }

    // Récupérer les informations d'état et de priorité à partir des tables correspondantes
    $sql_etat = "SELECT * FROM etat";
    $query_etat = $pdo->prepare($sql_etat);
    $query_etat->execute();
    $result_etat = $query_etat->fetchAll(PDO::FETCH_ASSOC);

    $sql_priorite = "SELECT * FROM priorite";
    $query_priorite = $pdo->prepare($sql_priorite);

	$query_priorite->execute();
	$result_priorite = $query_priorite->fetchAll(PDO::FETCH_ASSOC);

	// Récupérer la liste des utilisateurs à partir de la table user
	$sql_user = "SELECT * FROM user Where idrole = 2";
	$query_user = $pdo->prepare($sql_user);
	$query_user->execute();
	$result_user = $query_user->fetchAll(PDO::FETCH_ASSOC);
    
if (isset($_GET['success']) && $_GET['success'] == '1') {
    echo "Modification réussie!";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Modifier demande</title>
	<style>
		form {
			display: inline-block;
		}
 
		input[type="submit"] {
			margin-top: 5px;
		}
	</style>
</head>
<body>
	<h1>Modifier demande</h1>

	<form method="post" action="">
		<input type="hidden" name="iddemande" value="<?php echo $demande['iddemande']; ?>">

		<label>État :</label>
		<select name="idetat">
			<?php foreach ($result_etat as $etat) { ?>
				<option value="<?php echo $etat['idetat']; ?>" <?php if ($demande['idetat'] == $etat['idetat']) echo 'selected'; ?>>
					<?php echo $etat['etat']; ?>
				</option>
			<?php } ?>
		</select>
		<br>
        <br>

		<label>Priorité :</label>
		<select name="idpriorite">
			<?php foreach ($result_priorite as $priorite) { ?>
                <option value="<?php echo $priorite['idpriorite']; ?>" <?php if ($priorite['idpriorite'] == $priorite['idpriorite']) echo 'selected="selected"'; ?>><?php echo $priorite['priorite']; ?></option>
<?php } ?>
</select>
<br><br>

<label for="assignement">Assignement :</label>
<input type="text" name="assignement" value="<?php echo $demande['assignement']; ?>">
<br><br>

<label for="iduser">Utilisateur :</label>
<select name="iduser">
	<option value="">-- Sélectionner un utilisateur --</option>
	<?php foreach ($result_user as $user) { ?>
	<option value="<?php echo $user['iduser']; ?>" <?php if ($user['iduser'] == $user['iduser']) echo 'selected="selected"'; ?>><?php echo $user['login']; ?></option>
	<?php } ?>
</select>
<br><br>


<?php $pdo = null;
?>
<input type="submit" name="update" value="Modifier">
</form>

</body>
</html>
<?php
    }
}else{
    echo('session inexistante');
}
?>


