<?php 
require 'db.php';
require 'User.php';
$user = new User();
$id = $_POST['id'];
$current_user_id = $user->getCurrentUserId();
$stmt = $conn->prepare("SELECT * FROM messages LEFT JOIN blocks 
on (messages.user_id= blocks.block_by and blocks.block_to = :user_id ) or (messages.user_id = blocks.block_to and blocks.block_by = :user_id) WHERE messages.id > :id and blocks.block_to IS NULL"); 
$stmt->bindValue(':id', $id);
$stmt->bindValue(':user_id', $current_user_id);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($result)>0) { 
 	echo json_encode($result);
}else{
	echo 'no data';
}


?>