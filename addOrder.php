<?php 
session_start();
if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}
// if (isset($_SESSION['order'])) {
//     unset($_SESSION['order']);
// }

require "connection.php";
if(isset($_REQUEST)){
$getUserId = "SELECT id FROM users WHERE email = "."'".$_SESSION['user']."'";
$stmt = $pdo->prepare($getUserId);
$stmt -> execute();
$userID = $stmt->fetch(PDO::FETCH_ASSOC);
$orderByUserIdAndOrderID = "SELECT id  ,  COUNT(*)  AS countOrder FROM orders Where `status` = 1 AND user_id = ".$userID['id'];
$stmt = $pdo->prepare($orderByUserIdAndOrderID);
$stmt -> execute();
$orderStatus = $stmt->fetch(PDO::FETCH_ASSOC); 

//  echo "<pre>";
//  print_r($orderStatus);
//  echo "</pre>";
  if($orderStatus['countOrder'] == 0){
        $sqlOrder = "INSERT INTO orders (`user_id`,`total_amount`) VALUES (" . "'" . $userID['id'] ."',"."'".$_REQUEST['price']."')";
        $stmt = $pdo->prepare($sqlOrder);
        $stmt -> execute();
        $sqlOrder1 = "SELECT MAX(id) AS LAST_ID_Order FROM `orders` ORDER BY `date` DESC";
        $stmt = $pdo->prepare($sqlOrder1);
        $stmt -> execute();
        $LAST_ID_Order = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['order'] = $LAST_ID_Order['LAST_ID_Order'];
        //  echo $_SESSION['order'];

        $sqlProOrder = "INSERT INTO order_items (`order_id`,`product_id`,`quantity`,`price`) 
        VALUES (" . "'" .  $LAST_ID_Order['LAST_ID_Order'] ."',
        "."'".$_REQUEST['product_id']."',
        "."'1',
        "."'".$_REQUEST['price']."')";
        $stmt = $pdo->prepare($sqlProOrder);
        $stmt -> execute();
    }
    if($orderStatus['countOrder'] == 1){
        if(!isset($_SESSION['order'])){
            $_SESSION['order'] = $orderStatus['id'];
            $sqlOrderById = "SELECT total_amount FRom orders WHERE id = ".$_SESSION['order'];
            $stmt = $pdo->prepare($sqlOrderById);
            $stmt -> execute();
            $total_amount = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_amount =  ($total_amount['total_amount'])+($_REQUEST['price']);
            $sqlUpdataOrder  = "UPDATE orders
                                SET `total_amount` = ".$total_amount."
                                WHERE `id` =".$_SESSION['order'];
            $stmt = $pdo->prepare($sqlUpdataOrder);
            $stmt ->execute();


            $ORDER_ITEMS = "SELECT * FROM order_items WHERE order_id = ". $_SESSION['order'] . " AND product_id = ".$_REQUEST['product_id'];
            $stmt = $pdo->prepare($ORDER_ITEMS);
            $stmt -> execute();
            $total_amount = $stmt->fetch(PDO::FETCH_ASSOC);

            
            if(isset($total_amount['id'])){
                $total_amount = ($total_amount['quantity']) + 1;
                echo $total_amount['quantity'];
                $sqlUpdataOrderItem  = "UPDATE order_items 
                SET `quantity` = ".$total_amount."
                WHERE `order_id` =".$_SESSION['order']." AND `product_id` = ".$_REQUEST['product_id'];
                //   echo $sqlUpdataOrderItem ;
                $stmt = $pdo->prepare($sqlUpdataOrderItem);
                $stmt ->execute();
            }else{
                $insertOrderItem = "INSERT INTO order_items (`order_id`,`product_id`,`quantity`,`price`)
                        VALUES (" . "'" . $_SESSION['order'] ."',"."'".$_REQUEST['product_id']."','" . 1 ."',"."'" . $_REQUEST['price'] ."')";
                        $stmt = $pdo->prepare($insertOrderItem);
                        $stmt ->execute();
            }
        }
        if(isset($_SESSION['order'])){
            // echo $_SESSION['order'];
            $sqlOrderById = "SELECT total_amount FRom orders WHERE id = ".$_SESSION['order'];
            $stmt = $pdo->prepare($sqlOrderById);
            $stmt -> execute();
            $total_amount = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_amount =  ($total_amount['total_amount'])+($_REQUEST['price']);
            $sqlUpdataOrder  = "UPDATE orders
                                SET `total_amount` = ".$total_amount."
                                WHERE `id` =".$_SESSION['order'];
            $stmt = $pdo->prepare($sqlUpdataOrder);
            $stmt ->execute();


            $ORDER_ITEMS = "SELECT *  FROM order_items WHERE order_id = ". $_SESSION['order'] . " AND product_id = ".$_REQUEST['product_id'];
            echo $ORDER_ITEMS;
            $stmt = $pdo->prepare($ORDER_ITEMS);
            $stmt -> execute();
            $total_amount = $stmt->fetch(PDO::FETCH_ASSOC);
             echo "<pre>";
                print_r($total_amount);
             echo "</pre>";
            
            if(isset($total_amount['id'])){
                $total_amount = ($total_amount['quantity']) + 1;
                echo $total_amount['quantity'];
                $sqlUpdataOrderItem  = "UPDATE order_items 
                SET `quantity` = ".$total_amount."
                WHERE `order_id` =".$_SESSION['order']." AND `product_id` = ".$_REQUEST['product_id'];
                //   echo $sqlUpdataOrderItem ;
                $stmt = $pdo->prepare($sqlUpdataOrderItem);
                $stmt ->execute();
            }else{
                $insertOrderItem = "INSERT INTO order_items (`order_id`,`product_id`,`quantity`,`price`)
                        VALUES (" . "'" . $_SESSION['order'] ."',"."'".$_REQUEST['product_id']."','" . 1 ."',"."'" . $_REQUEST['price'] ."')";
                        $stmt = $pdo->prepare($insertOrderItem);
                        $stmt ->execute();
            }
        }
    }
}
    // if(isset($_SESSION['order'])){
    //     echo $_SESSION['order']."<br>";
    //     echo $_REQUEST['product_id']."<br>";
    //     $sqlOrderById = "SELECT total_amount FRom orders WHERE id = ".$_SESSION['order'];
    //     $stmt = $pdo->prepare($sqlOrderById);
    //     $stmt -> execute();
    //     $total_amount = $stmt->fetch(PDO::FETCH_ASSOC);
    //     $total_amount =  ($total_amount['total_amount'])+($_REQUEST['price']);
    //     $sqlUpdataOrder  = "UPDATE orders
    //     SET `total_amount` = ".$total_amount."
    //           WHERE `id` =".$_SESSION['order'];
    //     //       echo $sqlUpdataOrder;
    //     $stmt = $pdo->prepare($sqlUpdataOrder);
    //     $stmt ->execute();
        
             
    //    $ORDER_ITEMS = "SELECT quantity , COUNT(*) As count FROM order_items WHERE order_id = ". $_SESSION['order'] . " AND product_id = ".$_REQUEST['product_id'];
    //    $stmt = $pdo->prepare($ORDER_ITEMS);
    //     $stmt -> execute();
    //     $total_amount = $stmt->fetch(PDO::FETCH_ASSOC);  

    //     if($total_amount['count'] == 1 ){
    //         $total_amount = ($total_amount['quantity']) + 1;
    //         $sqlUpdataOrderItem  = "UPDATE order_items 
    //         SET `quantity` = ".$total_amount."
    //          WHERE `order_id` =".$_SESSION['order']." AND `product_id` = ".$_REQUEST['product_id'];
    //         //   echo $sqlUpdataOrderItem ;
    //          $stmt = $pdo->prepare($sqlUpdataOrderItem);
    //          $stmt ->execute();
    //     }else{
    //         $insertOrderItem = "INSERT INTO order_items (`order_id`,`product_id`,`quantity`,`price`)
    //          VALUES (" . "'" . $_SESSION['order'] ."',"."'".$_REQUEST['product_id']."','" . 1 ."',"."'" . $_REQUEST['price'] ."')";
    //         $stmt = $pdo->prepare($insertOrderItem);
    //         $stmt ->execute();
    //         // echo $insertOrderItem;
    //     }
            

         
    // }else{



    // }
// }


// if (isset($_COOKIE['productData'])) {

   
//     $productCountsArray = json_decode($_COOKIE['productData'], true);
//     echo "<pre>";
//     print_r($productCountsArray); 
//     echo"</pre>";
//     $product_order_items=[];
//     foreach($productCountsArray as $val=>$key){
//         $sqlPro = "SELECT * from products where id ="."'".$val."'";
//         $stmt = $pdo->prepare($sqlPro);
//         $stmt -> execute();
//         $product = $stmt->fetch(PDO::FETCH_ASSOC);
//         array_push($product_order_items , [
//             "id"=>$product['id'],
//             "name"=>$product['name'],
//             "total_amount"=>($product['price']) * ($key) ,
//             "price"=>$product['price'] ,
//             "image"=>$product['image'],
//             "desc"=>$product['desc'],
//             "amount"=>($product['amount']) - ($key),
//             "quntity"=>$key,
//             "category_id"=>$product['category_id'],
//         ]);
//     }  
//     $total_amount = [];
//     foreach($product_order_items as $proOrder){
//         array_push($total_amount,["price"=>$proOrder['total_amount']]);
//     }
//     $sum_total_amount = 0 ;
//     foreach($total_amount as $amount){
//      $sum_total_amount += $amount['price'];
//     }
//     $sqlOrder = "INSERT INTO orders (`user_id`,`total_amount`) VALUES (" . "'" . $user_id['id'] ."',"."'".$sum_total_amount."')";
//     $stmt = $pdo->prepare($sqlOrder);
//     $stmt -> execute();

//     $sqlOrders = "SELECT MAX(id) AS last_id FROM orders";
//     $stmt = $pdo->prepare($sqlOrders);
//     $stmt -> execute();
//     $product = $stmt->fetch(PDO::FETCH_ASSOC);
//     $Order_id = $product['last_id'];

//    foreach($product_order_items as $proOrder){
//     $sqlProOrder = "INSERT INTO order_items (`order_id`,`product_id`,`quantity`,`price`) 
//     VALUES (" . "'" .  $Order_id."',"."'".$proOrder['id']."',"."'".$proOrder['quntity']."',"."'".$proOrder['price']."')";
//     $stmt = $pdo->prepare($sqlProOrder);
//     $stmt -> execute();
//    }
 

 
   
// header("Location: Cart.php");
   
// }else {
//     echo "No product counts data found in cookies.";
// }
header("Location: qwe.php");
?>
<script>
// localStorage.remove();
</script>