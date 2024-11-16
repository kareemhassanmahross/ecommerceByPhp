<?php  


session_start();

if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}

require "connection.php";

$email = $_SESSION['user'];
if($email != "" ){
    $sql = "SELECT * FROM `users` WHERE `email` ="."'".$email."'";
    $stmt = $pdo->prepare($sql); 
    $stmt -> execute();
    $user = $stmt -> fetch(PDO::FETCH_ASSOC);

    $sqlOrdersUser = "SELECT * FROM `orders` WHERE `user_id` ="."'".$user['id']."'"." AND status = 1 ORDER BY `date` DESC";
    $stmt = $pdo->prepare($sqlOrdersUser); 
    $stmt -> execute();
    $userOrders = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($userOrders != ""){
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
    // if(isset($orderAndNameOfProducts)){
    //     echo "Kareem";
    // }
}
    
}
  





// echo "<pre>";
// print_r($userOrders);
// echo "</pre>";

  






 



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .quantity-wrapper {
        display: flex;
        align-items: center;
        width: fit-content;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .quantity-wrapper button {
        width: 40px;
        height: 40px;
        border: none;
        background-color: transparent;
    }

    .quantity-wrapper input {
        width: 60px;
        text-align: center;
        border: none;
        outline: none;
    }

    .quantity-wrapper button:hover {
        background-color: #f8f9fa;
    }
    </style>
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
                    <?php if($userOrders != ""){
                    $total_price = 0 ; ?>
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
                    <?php }?>
                </ul>
            </div>
        </div>
        <?php
        if($userOrders != ""){
        foreach($orderAndNameOfProducts  as $product){ ?>
        <div class="card mt-5" style="">
            <div class="row g-0 ">
                <div class="col-md-4">
                    <img src="dashboard/imagesProduct/<?=$product['image']?>" class="img-fluid rounded-start h-100"
                        alt="...">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title"><?=$product['nameProduct']?></h5>
                        <p class="card-text"><?=$product['desc']?></p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="col-md-2 border">
                    <div class="card-body">
                        <div class="quantity-wrapper">
                            <button class="btn-decrease" data-id="<?php echo $product['id']; ?>">-</button>


                            <input type="number" 
                            class="quntityFromDataBase<?=$product['id'] ?>" 
                            data-id="<?php echo $product['id']; ?>"
                            value="<?php echo $product['quantity']; ?>" min="1">


                            <button class="btn-increase" data-id="<?php echo $product['id']; ?>">+</button>
                        </div>
                        <div class="my-2  d-flex justify-content-center w-100">
                            <form action="updatequntit.php" method="get">
                                <div class="na">
                                <input type="hidden" name="id" value="<?= $product['id']; ?>">
                                    <input type="hidden" class="dataFromInput<?=$product['id'] ?>" id="updated-input-<?= $product['id'] ?>" name="newQuantity">
                                </div>
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </form>
                        </div>
                        <div class="dic  d-flex justify-content-center w-100">
                            <form action="deleteOrderItem.php" method="post">
                                <input type="hidden" name="product_id" value="<?=$product['id']?>">
                                <input type="submit" class="btn btn-danger" value="Cancel">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }} ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
 
    document.querySelectorAll('.btn-increase').forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id'); 
        const input = document.querySelector(`.quntityFromDataBase${id}`);
        const dataInput = document.querySelector(`.dataFromInput${id}`);
        console.log(dataInput);

        input.value = parseInt(input.value) + 1; 
        dataInput.value = input.value; 
      });
    });

    document.querySelectorAll('.btn-decrease').forEach(button => {
      button.addEventListener('click', () => {
        const id = button.getAttribute('data-id'); 
        const input = document.querySelector(`.quntityFromDataBase${id}`);
        const dataInput = document.querySelector(`.dataFromInput${id}`);

        if (parseInt(input.value) > 1) { 
          input.value = parseInt(input.value) - 1; 
          dataInput.value = input.value; 
        }
      });
    });
  </script>

</body>

</html>