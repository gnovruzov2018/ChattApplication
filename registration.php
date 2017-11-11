<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>

<?php

include 'db.php';
if(isset($_POST['username']) && is_string($_POST['username']) && !empty($_POST['username']) && 
  isset($_POST['email']) && is_string($_POST['email']) && !empty($_POST['email']) &&
  isset($_POST['password']) && is_string($_POST['password']) && !empty($_POST['password']))
 {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sqlCheck = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username");

    $sqlCheck->bindValue(':username', $username);
    $sqlCheck->execute();
    $result = $sqlCheck->fetch(PDO::FETCH_ASSOC);
    if ($result == true && !empty($result) && isset($result)) {
      echo '<center><h1 style="color: green;">Username already exists,<a href="registration.html"> try another</a></h1></center>';
    }else{
      $sql = $conn->prepare("INSERT INTO users (username, email, password)
      VALUES (:username, :email, :password)");
      $sql->bindValue(':username', $username);
      $sql->bindValue(':email', $email);
      $sql->bindValue(':password', $password);
      if( $sql->execute()){
        echo '<center><h1 style="color: green;">Dear ' . $username . ', you have successfully registered. <a href="login.html">Please, login.</a></h1></center>';
      }else{
        echo '<center><h1 style="color: red;">Dear ' . $username . ', some problems occured during registration. <a href="registration.html">Please, sign up again.</a></h1></center>';
      }
    }
  
  }
 ?>

</body>
</html>