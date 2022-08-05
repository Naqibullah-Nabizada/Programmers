<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";

try{

    $connect = new PDO("mysql:host=$servername; dbname=programmers", $username, $password);

}catch(PDOException $e){
    echo "connection failed ". $e->getMessage();
}

$query = $connect->prepare("SELECT * FROM user");
$query->execute();
$users = $query->fetchAll(PDO::FETCH_OBJ);
foreach ($users as $user){
    $_SESSION['gender'] = $user->gender;
    $_SESSION['photo'] = $user->photo; 
}

?>
