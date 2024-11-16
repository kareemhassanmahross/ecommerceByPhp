<?php
session_start();

if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}

require "connection.php";
if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
    $sql  = "UPDATE users SET `address` = "."'".$_REQUEST['addresss']."'".",
    `phone_number` = "."'".$_REQUEST['phone']."'"."
      WHERE `id` =".$id;
      echo $sql;
    $stmt = $pdo->prepare($sql);
    $stmt ->execute();
}
$sql = "SELECT * FROM `users` WHERE `email` ="."'".$_SESSION['user']."'";
$stmt = $pdo->prepare($sql); 
$stmt -> execute();
$user = $stmt -> fetch(PDO::FETCH_ASSOC);
    
// $sqlOrdersUser = "SELECT * FROM `orders` WHERE `user_id` ="."'".$user['id']."'"." AND status = 1 ORDER BY `date` DESC";
// $stmt = $pdo->prepare($sqlOrdersUser); 
// $stmt -> execute();
// $userOrders = $stmt -> fetch(PDO::FETCH_ASSOC);

$sqlUpdataOrder  = "UPDATE orders
                                SET `status` = 0
                                WHERE `user_id` ="."'".$user['id']."'"." AND status = 1 ORDER BY `date` DESC";
            $stmt = $pdo->prepare($sqlUpdataOrder);
            $stmt ->execute();


if (isset($_SESSION['order'])) {
    unset($_SESSION['order']);
}

 
header("Location: index.php");