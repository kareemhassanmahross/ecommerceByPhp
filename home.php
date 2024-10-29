<?php
require "connection.php";
$sql = "SELECT 
p.`id`,
p.`name`,
p.`desc`,
p.`image`,
p.`price`,
p.`amount`,
p.`category_id`,
c.`name` as `namecat`,
c.`desc` as `desccat`,
c.`image` as `imagecat`
FROM  `products` p
INNER JOIN  `categories` c
ON c.id = p.category_id 
GROUP BY p.id ";
$stmt = $pdo->prepare($sql);
$stmt -> execute();
$Data = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
              
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <h2 class="text-center">Products</h2>
            <div class="row">
              <?php  foreach($Data as $data) { ?>
                <div class="col-md-3 mb-4">
                    <div class="card product-card">
                        <img src="dashbord/products/imagesProduct/<?= $data['image'] ?>" width="305px" height="220px" alt="Product 1">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $data['name'] ?></h5>
                            <p class="card-text"><?= $data['price'] ?> $</p>
                            <a href="#" class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
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
