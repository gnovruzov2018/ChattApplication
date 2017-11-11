<?php 
/**
* 
*/
	class User {
		function __construct(){
			session_start();
     	}
		function userLoggedIn($username){
			$_SESSION['username']= $username;
		}
		function userLoggedOut(){
			unset($_SESSION['username']);
		}
		function checkSession(){
			if ($_SESSION['username']) {
				return true;
			}
			return false;
		}
		function getSession(){
			if ($_SESSION['username']) {
				return $_SESSION['username'];
			}
		}
		function getCurrentUserId(){
			require 'db.php';
			$username = $_SESSION['username'];
			$sql = $conn->prepare("SELECT id from users WHERE username = :username");
			$sql->bindValue(':username', $username);
			$sql->execute();
			$result = $sql->fetch(PDO::FETCH_ASSOC);
			$currentUserId = $result['id'];
			return $currentUserId;
		}
	}

?>
