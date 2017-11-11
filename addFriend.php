<?php 
require 'db.php';
require 'User.php';

$user = new User();
$friended_by = $user->getCurrentUserId();
$friended_to = $_POST['friended_to'];

$sql = $conn->prepare("INSERT INTO friends (friended_by, friended_to, isApproved) VALUES (:friended_by, :friended_to, false)");
$sql->bindValue(':friended_by',$friended_by);
$sql->bindValue(':friended_to',$friended_to);
$sql->execute();

?>