<?php
session_start();
    require_once('../poo/class_database.php');
    require_once('../poo/class_user.php');

  $connexion = new Database('db5000303655.hosting-data.io', 'dbs296642', 'dbu526627', ')uq6PE.9');
  $bdd = $connexion->PDOConnexion();

?>

<?php 

$id = $_GET['id'];

$req = $bdd->prepare("UPDATE T_comment SET comment_visible = 0 WHERE comment_id='$id'");
    $req->execute();
    

  $reqarchive = $bdd->prepare('INSERT INTO T_archive_comment (archive_comment_date, user_id, comment_id) VALUES (:archive_comment_date, :user_id, :comment_id)');
  $reqarchive->execute(array(
    ':archive_comment_date' => date('Y-m-d'),
    ':user_id' => $_SESSION['user_id'],
    ':comment_id' => $id,
  ));
  header("location:./blog_post.php?id=$id");
?>
