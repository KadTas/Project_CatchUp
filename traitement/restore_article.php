<?php
session_start();
    require_once('../poo/class_database.php');
    require_once('../poo/class_user.php');

  $connexion = new Database('db5000303655.hosting-data.io', 'dbs296642', 'dbu526627', ')uq6PE.9');
  $bdd = $connexion->PDOConnexion();

?>

<?php 

$id = $_GET['id'];

$req = $bdd->prepare("UPDATE T_article SET article_visible = 1 WHERE article_id='$id'");
    $req->execute();
    

  $reqarchive = $bdd->prepare("DELETE FROM T_archive_article WHERE article_id = '$id'");
  $reqarchive->execute();
  header("location:./blog_post.php?id=$id");
?>
