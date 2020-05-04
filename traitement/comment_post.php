<?php session_start();

	require_once('../poo/class_database.php');
	require_once('../poo/class_user.php');

	$connexion = new Database('db5000303655.hosting-data.io', 'dbs296642', 'dbu526627', ')uq6PE.9');
  $bdd = $connexion->PDOConnexion();

$article_id = $_GET['id'];
$comment = $_POST['message'];
$user = $_SESSION['user_id'];

  $reqarchive = $bdd->prepare('INSERT INTO T_comment (comment_content, comment_visible, user_id , article_id) VALUES (:comment_content, :comment_visible, :user_id , :article_id)');
  $reqarchive->execute(array(
    ':comment_content' => $comment,
    ':comment_visible' => '1',
    ':user_id' => $user,
    ':article_id' => $article_id,
  ));
  header("location:../blog_post.php?id=$article_id");


 ?>