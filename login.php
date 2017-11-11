<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>


<?php 


if(isset($_POST['username']) && is_string($_POST['username']) && !empty($_POST['username']) && 
  isset($_POST['password']) && is_string($_POST['password']) && !empty($_POST['password']))
 {
    $username = test_input($_POST['username']);
    $password = test_input($_POST['password']);

    if(authenticate($username, $password)) {
      require 'User.php';
      $user = new User();
      $user->userLoggedIn($username);
      header('Location: index.php');
  } else {
      echo '<center><h1 style="color: red;">Wrong username or password. <a href="login.html">Please, login again.</a></h1></center>';
  }
}
function authenticate($username, $password){
  
  require 'db.php';

  $sql = $conn->prepare("SELECT username, password FROM users WHERE username = :username AND  password = :password");
  $sql->bindValue(':username', $username);
  $sql->bindValue(':password', $password);
  $sql->execute();
  $result = $sql->fetch(PDO::FETCH_ASSOC);
  if($result == true && !empty($result) && isset($result)){ 
    return true;
  }
  return false;
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
</body>
</html>