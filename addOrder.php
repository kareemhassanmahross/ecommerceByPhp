<?php 
session_start();
if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}
require "connection.php";
$email = $_SESSION['user'];
$sql = "SELECT id FROM `users` WHERE `email` ="."'".$email."'";
$stmt = $pdo->prepare($sql);
$stmt -> execute();
$user_id = $stmt->fetch(PDO::FETCH_ASSOC);
echo $user_id['id'];


if (isset($_COOKIE['productData'])) {

   
    $productCountsArray = json_decode($_COOKIE['productData'], true);
    echo "<pre>";
    print_r($productCountsArray); 
    echo"</pre>";
    $product_order_items=[];
    foreach($productCountsArray as $val=>$key){
        $sqlPro = "SELECT * from products where id ="."'".$val."'";
        $stmt = $pdo->prepare($sqlPro);
        $stmt -> execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        array_push($product_order_items , [
            "id"=>$product['id'],
            "name"=>$product['name'],
            "total_amount"=>($product['price']) * ($key) ,
            "price"=>$product['price'] ,
            "image"=>$product['image'],
            "desc"=>$product['desc'],
            "amount"=>($product['amount']) - ($key),
            "quntity"=>$key,
            "category_id"=>$product['category_id'],
        ]);
    }  
    $total_amount = [];
    foreach($product_order_items as $proOrder){
        array_push($total_amount,["price"=>$proOrder['total_amount']]);
    }
    $sum_total_amount = 0 ;
    foreach($total_amount as $amount){
     $sum_total_amount += $amount['price'];
    }
    $sqlOrder = "INSERT INTO orders (`user_id`,`total_amount`) VALUES (" . "'" . $user_id['id'] ."',"."'".$sum_total_amount."')";
    $stmt = $pdo->prepare($sqlOrder);
    $stmt -> execute();

    $sqlOrders = "SELECT MAX(id) AS last_id FROM orders";
    $stmt = $pdo->prepare($sqlOrders);
    $stmt -> execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $Order_id = $product['last_id'];

   foreach($product_order_items as $proOrder){
    $sqlProOrder = "INSERT INTO order_items (`order_id`,`product_id`,`quantity`,`price`) 
    VALUES (" . "'" .  $Order_id."',"."'".$proOrder['id']."',"."'".$proOrder['quntity']."',"."'".$proOrder['price']."')";
    $stmt = $pdo->prepare($sqlProOrder);
    $stmt -> execute();
   }
 

 
   
header("Location: Cart.php");
   
}else {
    echo "No product counts data found in cookies.";
}
?>
<script>
// localStorage.remove();
</script>