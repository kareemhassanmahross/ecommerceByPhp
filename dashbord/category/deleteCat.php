<?php


if($_REQUEST){
    require "../../connection.php";
    $id = $_REQUEST['id'];
    $sql = "SELECT `image` FROM `categories` WHERE id =".$id;
    $query = $pdo -> prepare($sql);
    $query ->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    $img = $data['image'];
    $sql = "DELETE  FROM `categories` WHERE id = ".$id;
    $query = $pdo -> prepare($sql);
    unlink("imagesCategory/".$img);
    $query ->execute();
    header("Location: showAllCategories.php");
}