<?php session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
if (isset($_SESSION['typerole'])){
    if ($_SESSION['typerole']=='Utilisateur'){
        ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Formulaire</title>
            <link href="responsable.css" rel="stylesheet">
        </head>
    <body>
        <div class="container">
            <div class="row">
                <article class="col-md-5">
                    <nav class = "navbar navbar-inverse">
                        <div class="container-fluid">
                            <div class="navbar-header"> 
                                <h5 class="d-inline p-2 text-bg-dark">maison des ligue</h5>
                                <h5 class="d-inline p-2 text-bg-dark" style="margin-top: 15px">page d'accueil</h5>
                            </div>
                        </div>
                    </nav>
                </article>
            </div>
            <div class="row" style="margin-top: 15px">
                <article class="col-md-3">
                <h4>Quel est l'object de votre demande?</h4>
                    <form action= "user.php" method="post">
                        <textarea id="demande" name="demande"
                        rows="5" cols="33" required></textarea>
            </div>
            <div class="row" style="margin-top: 15px">
                <article class="col-md-3">
                    <h4>Quelle est la priorité de votre demande?</h4>
                        <SELECT name="priorite" id="priorite" size="1">
                        <OPTION>-----
                        <OPTION value=1>1  Priorité Niveau 1 
                        <OPTION value=2>2   Priorité Niveau 2 
                        <OPTION value=3>3   Priorité Niveau 3
                        </SELECT>
                </article>
            </div>
            <div class="row" style="margin-top: 15px">
            </br>
            <div class="row">
                <article class="col-md-1">
                <a href="page_Utilisateur.php" class="bouton">Ok</a>
                </article>
            </form>
            </div>
        </div>
    </body>
</html>
<?php    
    }
}else{
    echo('session inexistante');
}

?>