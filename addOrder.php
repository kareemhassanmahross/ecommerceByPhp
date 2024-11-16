<?php 
session_start();
if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}


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
header("Location: index.php");
?>
