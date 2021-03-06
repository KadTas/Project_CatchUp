<?php class User {
    protected $_username;
    protected $_password;
    protected $_mail;
    protected $_token;
    protected $_validation;
    protected $_usertype;

    public function __construct($_password, $_mail) {
        $this->_password = $_password;
        $this->_mail = $_mail;
        $this->_token=substr(str_shuffle(str_repeat("0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN", 40)), 0, 40);
    }

    public function register($bdd) {

        $login = !empty($_POST['login']) ? $_POST['login'] : NULL;

        $req= $bdd->prepare('INSERT INTO T_user (user_login, user_mail, user_password, user_confirmation, user_token, usertype_id) VALUES (:user_login, :user_mail, :user_password, :user_confirmation, :user_token, :usertype_id)');
        $req->execute(array(
        ':user_login' => $login,
        ':user_mail' => $this->_mail,
        ':user_password' => $this->_password,
        ':user_token' => $this->_token,
        ':usertype_id' => 3,
        ':user_confirmation' => 0));
        return $req;
    }

    public function login($bdd) {
        $req = $bdd->prepare("SELECT * FROM T_user WHERE user_mail = :email AND user_password = :pass");
        $req->execute(array(
            ':email' => $this->_mail,
            ':pass' => $this->_password
        ));

        $count = $req->fetch();
        if($count != NULL)
    {
    session_start();
    $_SESSION['user_id'] = $count['user_id'];
    $_SESSION['email'] = $count['user_mail'];
    $_SESSION['login'] = $count['user_login'];
    $_SESSION['usertype_id'] = $count['usertype_id'];
    header("location:../index.php?id=success");
    }
    else
    {
    //Mauvais identifiant ou mauvais tout cours
    header("location:../login.php?id=fail");
    }
    }
 
    public function sendmail($bdd) {
        $req = $bdd->prepare("SELECT * FROM T_user WHERE user_mail = '$this->_mail'" );
        $req->execute();
        mail($this->_mail, "Test envoi de mail","Votre inscription a été effectuée, confirmez votre compte : http://tas.simplon-charleville.fr/CatchUp/traitement/confirm.php?id=$this->_token");
    }

    public function confirmed($bdd) {
        $reqconfirm = $bdd->prepare("UPDATE T_user SET validate = 1 WHERE user_token = '$idtoken'");
        $reqconfirm->execute();
    }
}