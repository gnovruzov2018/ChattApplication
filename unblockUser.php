<?php 
require 'db.php';
require 'User.php';

$user = new User();
$block_by = $user->getCurrentUserId();
$block_to = $_POST['block_to'];

$sql = $conn->prepare("DELETE FROM blocks WHERE block_by = :block_by and block_to = :block_to");
$sql->bindValue(':block_by', $block_by);
$sql->bindValue(':block_to', $block_to);
$sql->execute(); 

?>