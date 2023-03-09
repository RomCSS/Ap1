<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/*************************CONNEXION A LA BDD*************************************** */
function connexion(){
    $host = 'localhost';
    $db   = 'ap1';
    $user = 'root';
    $pass = 'root';
    $dsn = "mysql:host=$host;dbname=$db";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } 
    catch (\PDOException $e) {
        print"ERREUR:".$e;
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
    return $pdo;
}
/*************************FIN******************************************** */

/************************EXECUTION DE LA REQUETE********************** 
*/





$pdo=connexion();
function userexist($pdo){
    $stmt = $pdo->prepare("
        SELECT u.iduser AS 'id', u.login AS 'login' , r.typerole AS 'role'
        FROM user u
        INNER JOIN role r
        ON u.idrole = r.idrole
        WHERE login= ? and password= ? "
    );
    $stmt->execute(array($_POST['login'], $_POST['password']));
return $stmt;

}


function insert_user($pdo, $objet, $idpriorite, $iduser){
    $stmt = $pdo->prepare("INSERT INTO `demande`(`idpriorite`, `assignement`,`iduser`) VALUES (?,?,?)");
    $stmt->execute(array($idpriorite, $objet, $iduser));
    return $stmt;
    
 }
 

function voir_demande($pdo, $idetat = null, $idpriorite = null){
    $stmt=$pdo->prepare("SELECT d.iddemande, d.assignement,d.idpriorite,e.idetat,u.login FROM `demande` d INNER JOIN user u ON u.iduser = d.iduser INNER JOIN etat e ON e.idetat= d.idetat WHERE d.`idetat`=? AND d.`idpriorite`=? ");
    $stmt->execute(array($idetat,$idpriorite));
    return $stmt;
 }
 ?>