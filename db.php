<?php
$user = 'root';
$pass = 'gadir';

$conn = new PDO("mysql:host=localhost;dbname=mydb", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

