<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
require ("requete.php");
session_start();


$stmt=insert_user($pdo, $_POST['demande'], $_POST['priorite'], $_SESSION['iduser']);

header('Location: index_' . $_SESSION['typerole'] . '.php');
