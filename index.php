<?php
include 'bdd.php';

if(isset($_GET['categorie'])){
  $page = $_GET['categorie'];
}
else{
  $page = 'general';
}

$get_messages = $bdd->query("SELECT `username`,`message`,`date` FROM `messages` INNER JOIN `users` ON messages.user_id = users.id WHERE `category`='$page' ORDER BY messages.id DESC");

session_start();

if(isset($_POST['ok'])){
  // on va envoyer un message
    $message = $_POST['message'];
    // récupération des champs du form 

    $requete = $bdd->prepare("INSERT INTO messages VALUES(0, :user_id, :message, :category, :date)");
    // requete sql pour la bdd
    $requete->execute(
        array(
            "user_id" => $_SESSION['id'],
            "message" => $message,
            "category" => $page,
            "date" => date("Y-m-d")." ".date("H:i:s")
        )
    );
    header("Location: index.php?categorie=".$page);
}
?>

<!DOCTYPE html>
<link href="main.css" rel="stylesheet" media="all" />
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Uni'verse</title>
  </head>
  <body>
    <div class="container">
      <div class="parent">
        <div class="haut">
          <div class="logo">
            <img class="image_logo" src="Logo_Uni-verse.png" alt="Uni'Verse" />
          </div>
        </div>
        <div class="messages">
          <?php
          if (isset($_SESSION['connecte'])){
          ?>
          <form method="POST" id="ecrire">
            <fieldset id="messageField">
              <legend>Ecrire un nouveau message :</legend>
              <textarea oninput="auto_grow(this)" name="message" id="ecrire_message" wrap="hard" title="ecrivez votre message" autocomplete="off" maxlength="999" required></textarea>
            </fieldset>
            <input type="submit" id="envoyer" name="ok">
          </form>
          <?php
          }
          ?>
          
          <div id="message">
            <?php
            if (isset($_SESSION['connecte']) or $page == 'general'){
              while ($messages = $get_messages->fetch()) {
                ?>
                <fieldset class="users_messages">
                <legend><span class="username">
                <?php
                echo "$messages[0]</span>";
                ?>
                <span class="date">
                <?php
                echo "$messages[2]</span> :</legend>";
                echo "<pre>$messages[1]</pre>";
                ?>
                </fieldset>
                <?php
              }
            }
            else{
              echo "Vous devez être connecté pour visionner ces messages.";
            }
            ?>
            
          </div>
        </div>
        <div class="gauche">
          <h2 class="titre_catégories">Catégories:</h2>
          <ul class="liste_catégories" style="font-size: 25px">
            <li class="element_liste_catégories">
              <a href="index.php">General</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=maths">Mathématiques</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=physique">Physique</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=informatique">Informatique</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=chimie">Chimie</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=medecine">Médecine</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=pharmacie">Pharmacie</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=geologie">Géologie</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=droit">Droit</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=economie">Economie</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=ss">Sciences sociales</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=ll">Lettres et langues</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=philosophie">Philosophie</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=psychologie">Psychologie</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=arts">Arts</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=musique">Musique</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=agronomie">Agronomie</a>
            </li>
            <li class="element_liste_catégories">
              <a href="index.php?categorie=cpes">CPES</a>
            </li>
          </ul>
        </div>
        <?php
          if (isset($_SESSION['connecte'])){
            ?>
            <a href="profile.php" class="connection"><?php echo $_SESSION['username'];?></a>
            <?php
          }
          else{
            ?>
            <a href="login.php" class="connection">Se connecter</a>
            <?php
          }
        ?>
        <div class="espace-bas"></div>
        <div class="espace-haut"></div>
        <div class="espace-gauche"></div>
        <div class="espace-droit"></div>
      </div>
    </div>
    <script>
      function auto_grow(element) {
        element.style.height = "5px";
        element.style.height = (element.scrollHeight) + "px";
      }
    </script>

  </body>
</html>
