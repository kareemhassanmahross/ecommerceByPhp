<?php
require "connection.php";

$page = isset($_REQUEST['page']) ?(int)$_REQUEST['page'] : 1; 
$prePage = isset($_REQUEST["prePage"]) && $_REQUEST["prePage"] <= 50? (int)$_REQUEST['prePage'] : 3;


$start = ($page > 1) ? ($page * $prePage) - $prePage : 0;
$sqlCat = "SELECT SQL_CALC_FOUND_ROWS * from `categories` LIMIT  {$start} , {$prePage}";
$stmt = $pdo->prepare($sqlCat);
$stmt -> execute();
$DataCat = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = $pdo->query("SELECT FOUND_ROWS() As total")->fetch()['total'];
$pages = ceil($total / $prePage);


$page1 = isset($_REQUEST['page1']) ?(int)$_REQUEST['page1'] : 1; 
$prePage1 = isset($_REQUEST["prePage1"]) && $_REQUEST["prePage1"] <= 50? (int)$_REQUEST['prePage1'] : 48;


$start1 = ($page1 > 1) ? ($page1 * $prePage1) - $prePage1 : 0;

$sql ="SELECT SQL_CALC_FOUND_ROWS * From `products` LIMIT  {$start1} , {$prePage1}"; 
$stmt1 = $pdo->prepare($sql);
$stmt1 -> execute();
$Data = $stmt1->fetchAll(PDO::FETCH_ASSOC);
$total1 = $pdo->query("SELECT FOUND_ROWS() As total")->fetch()['total'];
$pages1 = ceil($total1 / $prePage1);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home Page - Categories and Products</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the page */
        .categories-section, .products-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }

        .categories-section h2, .products-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .category-card, .product-card {
            transition: transform 0.3s ease;
        }

        .category-card:hover, .product-card:hover {
            transform: scale(1.05);
        }

        /* .product-card img {
            max-height: 200px;
            object-fit: cover;
        }

        .category-card img {
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
        } */

        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Brand Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <h2 class="text-center">Categories</h2>
            <div class="row">
                <!-- #################################################################### -->
                <?php  foreach($DataCat as $data) { ?>
                    
                <div class="col-md-4 mb-4">
                <a href ="showCat.php?id=<?=$data['id']?>" >
                    <div class="card category-card">
                        <img src="dashbord/category/imagesCategory/<?= $data['image'] ?>" width="415px" height="300px"  alt="Category 1">
                        <div class="card-body">
                            <h5 class="card-title text-center"><?= $data['name'] ?></h5>
                        </div>
                    </div>
                    </a>
                </div>
                
                <?php } ?>
            </div>
            <nav aria-label="Page navigation example">
                        <div >
                            <ul class="pagination pagination-lg justify-content-center">
                                <?php for($i = 1 ; $i <= $pages ; $i++) { ?>
                                <li class="page-item"><a class="page-link <?php if($page === $i) {echo "active" ;}?>"
                                        href="?page=<?=$i?>&prePage=<?=$prePage?>"><?= $i; ?></a></li>
                                <?php } ?>

                            </ul>
                        </div>
            </nav>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <h2 class="text-center">Products</h2>
            <div class="row">
              <?php  foreach($Data as $data) { ?>
                <div class="col-2 mb-4">
                    <div class="card product-card">
                        <img src="dashbord/products/imagesProduct/<?= $data['image'] ?>" height="220px" alt="Product 1">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $data['name'] ?></h5>
                            <p class="card-text"><?= $data['price'] ?> $</p>
                            <a href="#" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
            <nav aria-label="Page navigation example">
                        <div >
                            <ul class="pagination pagination-lg justify-content-center">
                                <?php for($i = 1 ; $i <= $pages1 ; $i++) { ?>
                                <li class="page-item"><a class="page-link <?php if($page1 === $i) {echo "active" ;}?>"
                                        href="?page1=<?=$i?>&prePage1=<?=$prePage1?>"><?= $i; ?></a></li>
                                <?php } ?>

                            </ul>
                        </div>
            </nav>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2024 Your Company. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
