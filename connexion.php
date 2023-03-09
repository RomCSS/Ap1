<?php   
error_reporting(E_ALL);
ini_set("display_errors", 1);
require ("requete.php");
$pdo=connexion();
$stmt=userexist($pdo);

$data = $stmt->fetchall();
if ( count($data) == 1) { 
    //vérifie si l'utilisateur existe dans la base de donnée 
    session_start();
    $row = $data[0];
    $_SESSION['login'] = $row['login'];
    $_SESSION['iduser'] = $row['id'];
    $_SESSION['typerole'] = $row['role'];
    header('Location: index_'.$_SESSION['typerole'].'.php');

}else{
    header('location: login.php?login_err=loginorpassword'); die();
 }
 ?>