<?php
session_start();

if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}

require "connection.php";

if($_REQUEST['id'] != null && $_REQUEST['newQuantity'] != null ){
    $id = $_REQUEST['id'];
    $sql  = "UPDATE order_items SET `quantity` = "."'".$_REQUEST['newQuantity']."'"."
      WHERE `id` =".$id;
    //   print_r($_REQUEST);
    //   echo $sql;
    $stmt = $pdo->prepare($sql);
    $stmt ->execute();
    header("Location: cart.php");
}else{
    header("Location: cart.php");
}