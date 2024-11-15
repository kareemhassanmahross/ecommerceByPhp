<?php

if($_REQUEST){
    require "../connection.php";
    $id = $_REQUEST['id'];
    $sql = "SELECT `image` FROM `products` WHERE id =".$id;
    $query = $pdo -> prepare($sql);
    $query ->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    $img = $data['image'];
    echo $img;
    $sql = "DELETE  FROM `products` WHERE id = ".$id;
    $query = $pdo -> prepare($sql);
    unlink("imagesProduct/".$img);
    $query ->execute();
    header("Location: products.php");
}