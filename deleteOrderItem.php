<?php
session_start();
if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}

require "connection.php";

if(isset($_REQUEST['product_id'])){
    $product_id = $_REQUEST['product_id'];
    $sqlToDeleteOrderItem = "DELETE FROM `order_items` WHERE `id` ="."'".$product_id."'";
    $stmt = $pdo->prepare($sqlToDeleteOrderItem); 
    $stmt -> execute();
}
header("Location: cart.php");