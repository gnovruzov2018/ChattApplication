<?php 

require 'db.php';
require 'User.php';

$user = new User();
$cur_id = $user->getCurrentUserId();
$id = $_GET['id'];

$sql = $conn->prepare("UPDATE friends SET isApproved = true WHERE friended_by = :user_id and friended_to = :curr_user_id");
$sql->bindValue(':user_id',$id);
$sql->bindValue(':curr_user_id',$cur_id);
$sql->execute();
$sql1 = $conn->prepare("INSERT INTO friends (friended_by, friended_to, isApproved) VALUES (:friended_to, :friended_by, true)");
$sql1->bindValue(':friended_by',$id);
$sql1->bindValue(':friended_to',$cur_id);
$sql1->execute();
header('location: index.php');

?>