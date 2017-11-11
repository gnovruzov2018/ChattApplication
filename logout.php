<?php 
require 'User.php';

$user = new User();
$username = $user->getSession();
$user->userLoggedOut();
header('Location: login.html');

?>