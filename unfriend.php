<?php 
require 'db.php';
require 'User.php';

$user = new User();
$cur_id = $user->getCurrentUserId();
$id = $_GET['id'];

$sql = $conn->prepare("DELETE FROM friends WHERE friended_by = :user_id and friended_to = :curr_user_id");
$sql->bindValue(':user_id',$id);
$sql->bindValue(':curr_user_id',$cur_id);
$sql->execute();
$sql1 = $conn->prepare("DELETE FROM friends WHERE friended_by = :curr_user_id and friended_to = :user_id");
$sql1->bindValue(':user_id',$id);
$sql1->bindValue(':curr_user_id',$cur_id);
$sql1->execute();
header('location: index.php');

?>