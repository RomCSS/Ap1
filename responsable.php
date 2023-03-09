<?php 
require ("requete.php");
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

function demande(){
    $pdo=connexion();
    $stmt=recherche_demande($pdo,$_POST['idetat'],$_POST['idpriorite']);
    $_SESSION['iddemande']=NULL;
    $_SESSION['assignement']=NULL;
    $_SESSION['idpriorite']=NULL;
    $_SESSION['idetat']=NULL;
    $_SESSION['iduser']= NULL;

    while ($row =$stmt->fetch()){
        $_SESSION['iddemande']=$row['iddemande'];
        $_SESSION['assignement']=$row['assignement'];
        $_SESSION['idpriorite']=$row['idpriorite'];
        $_SESSION['idetat']=$row['idetat'];
        $_SESSION['iduser']=$row['iduser'];
    }
    return $_SESSION['iddemande']."".$_SESSION['assignement']."".$_SESSION['idpriorite']."".$_SESSION['idetat']."".$_SESSION['iduser']; 
}
header('Location: index_Responsable.php');
function initialisation(){
    $pdo=connexion();
    $_SESSION['iddemande']=NULL;
    $_SESSION['assignement']=NULL;
    $_SESSION['idpriorite']=NULL;
    $_SESSION['idetat']=NULL;
    $_SESSION['iduser']= NULL;
}
?>
