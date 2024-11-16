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


$sqlOrdersUser = "SELECT * FROM `orders` WHERE `user_id` ="."'".$user['id']."'"." AND status = 1 ORDER BY `date` DESC";
$stmt = $pdo->prepare($sqlOrdersUser); 
$stmt -> execute();
$userOrders = $stmt -> fetch(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($userOrders);
// echo "</pre>";

if($userOrders == ""){
    header("Location: index.php");
}
    

$sqlOrder_items = "SELECT * FROM `order_items` WHERE `order_id` ="."'".$userOrders['id']."'";
$stmt = $pdo->prepare($sqlOrder_items); 
$stmt -> execute();
$userOrder_items = $stmt -> fetchAll(PDO::FETCH_ASSOC);


$orderAndNameOfProducts = [];

foreach ($userOrder_items as $us){
$sqlOrderProductName = "SELECT `name`,`image`,`desc` FROM `products` WHERE `id` ="."'".$us['product_id']."'";
$stmt = $pdo->prepare($sqlOrderProductName); 
$stmt -> execute();
$OrderProductName = $stmt -> fetchAll(PDO::FETCH_ASSOC);
foreach($OrderProductName as $name) {
    array_push($orderAndNameOfProducts,[
            "id" => $us['id'],
            "order_id" =>$us['order_id'],
            "nameProduct" => $name['name'],
            "image" => $name['image'],
            "desc" => $name['desc'],
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Brand Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Stores</a>
                    </li>

                    <?php if(isset($_SESSION['user'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php } ?>
                    <!-- <li class="nav-item">
                        <nav class="navbar navbar-light bg-light">
                            <form class="container-fluid">
                                <div class="input-group">
                                    <a href="cart.php">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="25"
                                                fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                                            </svg>
                                        </span>
                                    </a>
                                    <?php if(isset($_SESSION['order'])){ ?>
                                    <div id="myDiv"><?= $sumQuantity ?></div>
                                    <?php }else{ ?>
                                        <div id="myDiv">0</div>
                                    <?php } ?>
                                </div>
                            </form>
                        </nav>
                    </li> -->

                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <h2 class="text-center mb-4">Billing Details</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Billing Address</h4>
                <form action="adduserData.php" method="post">
                    <input type="hidden" class="form-control" name="id" value="<?= $user['id']?>">
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="addresss" required>
                    </div>
                    <div class="mb-3">
                        <label for="Phone" class="form-label">Phone</label>
                        <input type="number" class="form-control" name="phone" id="Phone" required>
                    </div>
                    <!-- <input type="submit" class="btn btn-primary w-100" id="makeOrder" value="Place Order"> -->
                    <input type="submit" value="Place Order" class="btn btn-primary w-100">
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
        <?php foreach($orderAndNameOfProducts  as $product){ ?>
            <div class="card mt-5" style="">
            <div class="row g-0 ">
                <div class="col-md-4">
                    <img src="dashboard/imagesProduct/<?=$product['image']?>" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?=$product['nameProduct']?></h5>
                        <p class="card-text"><?=$product['desc']?></p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        <form action="deleteOrderItem.php" method="post">
                            <input type="hidden" name="product_id" value = "<?=$product['id']?>">
                            <input type="submit" class="btn btn-danger" value="Cancel">
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <?php } ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>