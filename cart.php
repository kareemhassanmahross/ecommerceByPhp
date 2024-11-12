<?php  


session_start();

if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}

require "connection.php";

$email = $_SESSION['user'];

$sql = "SELECT * FROM `users` WHERE `email` ="."'".$email."'";
$stmt = $pdo->prepare($sql); 
$stmt -> execute();
$user = $stmt -> fetch(PDO::FETCH_ASSOC);


$sqlOrdersUser = "SELECT * FROM `orders` WHERE `user_id` ="."'".$id."'"." ORDER BY `date` DESC";
$stmt = $pdo->prepare($sqlOrdersUser); 
$stmt -> execute();
$userOrders = $stmt -> fetch(PDO::FETCH_ASSOC);


$sqlOrder_items = "SELECT * FROM `order_items` WHERE `order_id` ="."'".$userOrders['id']."'";
$stmt = $pdo->prepare($sqlOrder_items); 
$stmt -> execute();
$userOrder_items = $stmt -> fetchAll(PDO::FETCH_ASSOC);
 
$orderAndNameOfProducts = [];

foreach ($userOrder_items as $us){
    $sqlOrderProductName = "SELECT `name` FROM `products` WHERE `id` ="."'".$us['product_id']."'";
    $stmt = $pdo->prepare($sqlOrderProductName); 
    $stmt -> execute();
    $OrderProductName = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    foreach($OrderProductName as $name) {
        array_push($orderAndNameOfProducts,[
                "id" => $us['id'],
                "order_id" =>$us['order_id'],
                "nameProduct" => $name['name'],
                "quantity" => $us['quantity'],
                "price" => $us['price'],
                "total_price" => $us['price']*$us['quantity']
            ]);
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container my-5">
        <h2 class="text-center mb-4">Billing Details</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Billing Address</h4>
                <form action="adduserData.php" method="post">
                <input type="hidden" class="form-control" name="id" id="id" value="<?= $user['id']?>" disabled>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="addresss" required>
                    </div>
                    <div class="mb-3">
                        <label for="Phone" class="form-label">Phone</label>
                        <input type="number" class="form-control" name="phone" id="Phone" required>
                    </div>
                    <!-- <input type="submit" class="btn btn-primary w-100" id="makeOrder" value="Place Order"> -->
                    <input type="submit"  value="Place Order" class="btn btn-primary w-100">
                </form>
                <!-- <button type="submit" class="btn btn-primary w-100"></button> -->
            </div>


            <div class="col-md-6">
                <h4>Order Summary</h4>
                <ul class="list-group mb-3" id="content">
                    <?php $total_price = 0 ; ?>
                    <?php foreach ($orderAndNameOfProducts as $product) { ?>
                    <li class='list-group-item d-flex justify-content-between'>
                        <span><?= $product['nameProduct']?></span>
                        <span><?= $product['quantity']?></span>
                        <span><?= $product['price']?></span>
                        <span class='fw-bold'><?= $product['total_price']?></span>
                    </li>
                    <?php $total_price += $product['total_price']; } ?>
                    <li class='list-group-item d-flex justify-content-between bg-primary border text-white'>
                        <span class='fw-bold'>Total Price :</span>
                        <span class='fw-bold'><?= $total_price?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>