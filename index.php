<?php
require "connection.php";
session_start();
// echo $_SESSION['order'];
if(isset($_SESSION['user'])){
    $getUserId = "SELECT id FROM users WHERE email = "."'".$_SESSION['user']."'";
    $stmt = $pdo->prepare($getUserId);
    $stmt -> execute();
    $userID = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderByUserIdAndOrderID = "SELECT id  ,  COUNT(*)  AS countOrder FROM orders Where `status` = 1 AND user_id = ".$userID['id'];
    $stmt = $pdo->prepare($orderByUserIdAndOrderID);
    $stmt -> execute();
    $orderStatus = $stmt->fetch(PDO::FETCH_ASSOC);
    if($orderStatus['countOrder'] == 1){
        $sqlGetOrderItemsByOrderId = "SELECT quantity FROM order_items WHERE order_id = ".$orderStatus['id'];
        $stmt = $pdo->prepare($sqlGetOrderItemsByOrderId);
        $stmt -> execute();
        $quantityOrderItemsByOrderId = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $sumQuantity = 0;
        foreach($quantityOrderItemsByOrderId as $sq){
            $sumQuantity += $sq['quantity'];
        }
    }
}


$sqlCat = "SELECT  * from `categories`";
$stmt = $pdo->prepare($sqlCat);
$stmt -> execute();
$DataCat = $stmt->fetchAll(PDO::FETCH_ASSOC);
$id = 1;

if(!$_REQUEST){
    $sql = "SELECT * from `products` where category_id =".$id;
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();
    $Data = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
    $sql = "SELECT * from `products` where category_id =" . $_REQUEST['id'];
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();
    $Data2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // echo $sumQuantity;
    // print_r($quantityOrderItemsByOrderId);
    // echo "</pre>";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories and Products </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Custom styling to match a Noon-like look */
    .category-sidebar {
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 0.5rem;
    }

    .category-item {
        color: #333;
        cursor: pointer;
        padding: 0.5rem;
        border-bottom: 1px solid #e0e0e0;
        transition: background-color 0.3s;
    }

    .category-item:hover {
        background-color: #e9ecef;
    }

    .product-card {
        border: 1px solid #e0e0e0;
        border-radius: 0.5rem;
        transition: transform 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .product-image {
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #e0e0e0;
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
                    <li class="nav-item">
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
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="py-3">
        <div class="container text-center">
            <h1>Online Store</h1>
        </div>
    </header>

    <!-- Main Content Area -->
    <div class="container my-4 border border-dark p-5">
        <div class="row">
            <!-- Sidebar for Categories -->
            <aside class="col-lg-3 mb-4">
                <div class="category-sidebar">
                    <h4 class="mb-3">Categories</h4>
                    <?php foreach($DataCat as $cat) { ?>
                    <form action="">
                        <input type="hidden" value="<?= $cat['id'] ?>" name="id" id="id">
                        <button type="submit" class="btn btn-light w-100"><?= $cat['name'] ?></button>
                    </form>
                    <?php } ?>
                </div>
            </aside>

            <!-- Product Grid -->
            <main class="col-lg-9">
                <div class="row g-4" id="cards">
                    <!-- Product Card -->
                    <?php if(!isset($Data)){ ?>
                    <?php foreach($Data2 as $pro){ ?>
                    <div class="col-6 col-md-4 col-lg-3 car">
                        <div class="card product-card">
                            <img src="dashboard/imagesProduct/<?= $pro['image'] ?>"
                                class="card-img-top product-image" alt="Product Image">
                            <div class="card-body text-center">
                                <input type="hidden" class="id" name="id" value="<?= $pro['id'] ?>">
                                <h5 class="card-title"><?= $pro['name']?></h5>
                                <p class="card-text text-muted">Price: $<?= $pro['price'] ?></p>
                                <p class="card-text text-muted">quntity: <?= $pro['amount'] ?></p>

                                <form action="addOrder.php" method="get">
                                    <input type="hidden" name="product_id" value="<?= $pro['id'] ?>">
                                    <input type="hidden" name="price" value="<?= $pro['price'] ?>">
                                    <input type="submit" id="addProductButton" class="btn1 btn btn-primary btn-sm"
                                        value="Add to Cart">
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php }  ?>
                    <?php }else {?>
                    <?php foreach($Data as $pro){ ?>
                    <div class="col-6 col-md-4 col-lg-3 car">
                        <div class="card product-card ">
                            <img src="dashboard/imagesProduct/<?= $pro['image'] ?>"
                                class="card-img-top product-image" alt="Product Image">
                            <div class="card-body text-center">
                                <input type="hidden" class="id" name="id" value="<?= $pro['id'] ?>">
                                <h5 class="card-title"><?= $pro['name']?></h5>
                                <p class="card-text text-muted">Price: $<?= $pro['price'] ?></p>
                                <p class="card-text text-muted">quntity: <?= $pro['amount'] ?></p>

                                <form action="addOrder.php" method="get">
                                    <input type="hidden" name="product_id" value="<?= $pro['id'] ?>">
                                    <input type="hidden" name="price" value="<?= $pro['price'] ?>">
                                    <input type="submit" id="addProductButton" class="btn1 btn btn-primary btn-sm"
                                        value="Add to Cart">
                                </form>
                                <!-- onclick="storeProductId(this)" -->
                            </div>
                        </div>
                    </div>
                    <?php }  ?>
                    <?php } ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function storeProductId(button) {
        const productID = button.previousElementSibling.value;
        let myDiv = document.getElementById("myDiv");
        const cookies = getCookies();
        let productData = cookies.productData ? JSON.parse(cookies.productData) : {};

        productData[productID] = (productData[productID] || 0) + 1;

        setCookie("productData", JSON.stringify(productData), 7);

        console.log("Updated Product Data:", productData);


        let totalQuantity = 0;

        for (let key in productData) {
            if (productData.hasOwnProperty(key)) {
                totalQuantity += productData[key];
            }
        }
        localStorage.setItem("totalQuantity", totalQuantity);

        // Display the sum in HTML
        myDiv.innerText = `${totalQuantity}`;
        console.log(`Total quantity of products: ${totalQuantity}`);
    }
    window.onload = function() {
        // Retrieve the sum from localStorage
        let storedTotalQuantity = localStorage.getItem("totalQuantity");

        // Display the sum if it exists in localStorage
        if (storedTotalQuantity !== null) {
            document.getElementById("myDiv").innerText = `${storedTotalQuantity}`;
        }
    };

    function getCookies() {
        const cookies = document.cookie.split('; ');
        const cookieObj = {};
        cookies.forEach(cookie => {
            const [name, value] = cookie.split('=');
            cookieObj[name] = decodeURIComponent(value);
        });
        return cookieObj;
    }



    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Set expiration in days
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + encodeURIComponent(value) + ";" + expires + ";path=/";

    }
    </script>
</body>

</html>