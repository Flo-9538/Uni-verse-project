<?php
session_start();

$servername = "localhost";
$user = "root";
$pass = "root";

$bdd = new PDO("mysql:host=$servername;dbname=universe", $user); 
// création de l'instance bdd (connexion à la bdd)

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = sha1($_POST['password']);
    // récupération des champs du form 

    if($email != "" && $password != ""){
        $req = $bdd->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
        // requete sql pour la bdd
        $rep = $req->fetch();
        if($rep['id'] != false){
            // c'est ok
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $_SESSION['id'] = $req->fetch()['id'];
            $_SESSION['username'] = $req->fetch()['username'];
            $_SESSION['connecte'] = 1;

            header("Location: Page1.php");
        }
        else{
            $error_msg = "Email ou mdp incorrect !";
        }
    }
    if($error_msg){
        ?>
        <p><?php echo $error_msg;?></p>
        <?php
    }
}
?>
