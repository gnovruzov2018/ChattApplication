<?php 
require 'db.php';
require 'User.php';
$message = $_POST['message'];
$user = new User();
$username = htmlentities($user->getSession(), ENT_QUOTES | ENT_HTML5, 'UTF-8');
$sql1 = $conn->prepare("SELECT id from users WHERE username = :username");
$sql1->bindValue(':username', $username);
$sql1->execute();
$result = $sql1->fetch(PDO::FETCH_ASSOC);
$user_id = $result['id'];
if(isset($message)&&!empty($message)){
$sql = $conn->prepare("INSERT INTO messages (message, username, user_id) VALUES (:message, :username, :user_id)");
    $sql->bindValue(':message', $message);
    $sql->bindValue(':username', $username);
    $sql->bindValue(':user_id', $user_id);
    $sql->execute(); 
}


?>