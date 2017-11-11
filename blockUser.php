<?php 
require 'db.php';
require 'User.php';

$user = new User();
$block_by = $user->getCurrentUserId();
$block_to = $_POST['block_to'];
$sql1 = $conn->prepare("INSERT INTO blocks (block_by, block_to) VALUES (:block_by, :block_to)");
$sql1->bindValue(':block_by', $block_by);
$sql1->bindValue(':block_to', $block_to);
$sql1->execute(); 
?>