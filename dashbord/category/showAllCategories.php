<?php 

require "../../connection.php";

$page = isset($_REQUEST['page']) ?(int)$_REQUEST['page'] : 1; 
$prePage = isset($_REQUEST["prePage"]) && $_REQUEST["prePage"] <= 50? (int)$_REQUEST['prePage'] : 5;


$start = ($page > 1) ? ($page * $prePage) - $prePage : 0;

$sql  = "SELECT SQL_CALC_FOUND_ROWS * FROM categories LIMIT {$start} , {$prePage}"; 
$stmt = $pdo->prepare($sql); 
$stmt -> execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = $pdo->query("SELECT FOUND_ROWS() As total")->fetch()['total'];


$pages = ceil($total / $prePage);
################################################




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">Categories</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="showallCategories.php">Categories</a></li>
                            <li><a class="dropdown-item" href="addCategory.php">Add Category</a></li>
                        </ul>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">Products</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../products/products.php">products</a></li>
                            <li><a class="dropdown-item" href="../products/addproduct.php">Add product</a></li>
                        </ul>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">Orders</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Orders</a></li>
                            <li><a class="dropdown-item" href="#">Add Order</a></li>
                        </ul>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">Customers</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Customers</a></li>
                            <li><a class="dropdown-item" href="#">Add Customer</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->

            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <!-- <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">
                                Dashboard
                            </a>
                        </li> -->

                        <!-- Dropdown Menu -->
                        <li class="nav-item">
                            <a class="nav-link" href="category/addCategory.php" data-bs-toggle="collapse"
                                data-bs-target="#submenu1" aria-expanded="false">
                                Categories
                            </a>
                            <div class="collapse" id="submenu1">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="showAllCategories.php">Categories</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="addCategory.php">Add Category</a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="" data-bs-toggle="collapse" data-bs-target="#Product"
                                aria-expanded="false">
                                Products
                            </a>
                            <div class="collapse" id="Product">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="../products/products.php">Products</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="../products/addproduct.php">Add Product</a>
                                    </li>
                                </ul>
                            </div>

                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#submenu2"
                                aria-expanded="false">
                                Orders
                            </a>
                            <div class="collapse" id="submenu2">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Product 1</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Product 2</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Product 3</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Customers
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                    </div>
                </div>
                <h2>Section title</h2>
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach($row as $cat) { ?>

                            <tr>
                                <td><?php  echo $cat['id'] ; ?></td>
                                <td><?php  echo $cat['name'] ; ?></td>
                                <td class=""><?php  echo $cat['desc'] ; ?></td>
                                <td><img src="imagesCategory/<?php echo $cat['image']; ?>" width="100px" height="100px">
                                </td>
                                <td>
                                    <form action="deleteCat.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $cat['id'] ; ?>">
                                        <input type="submit" value="Delete" class="btn btn-danger">
                                    </form>
                                </td>
                                <td>
                                    <form action="updateCategory.php" method="get">
                                        <input type="hidden" name="id" value="<?php echo $cat['id'] ; ?>">
                                        <input type="submit" value="Update" class="btn btn-primary">
                                    </form>
                                </td>
                            </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example">
                        <div >
                            <ul class="pagination pagination-lg justify-content-center">
                                <?php for($i = 1 ; $i <= $pages ; $i++) { ?>
                                <li class="page-item"><a class="page-link <?php if($page === $i) {echo "active" ;}?>"
                                        href="?page=<?=$i?>&<?=$prePage?>"><?= $i; ?></a></li>
                                <?php } ?>

                            </ul>
                        </div>
                    </nav>
                </div>
                <div class=" d-block d-md-none ">
                    <?php foreach($row as $cat) { ?>
                    <div class="card my-5">
                        <div class="card-header">
                            <?= $cat['name'] ?>
                        </div>
                        <div class="card-body">
                            <img src="imagesCategory/<?php echo $cat['image']; ?>" width="150px" height="150px">
                            <p class="card-text pt-5"><?= $cat['desc'] ?>
                            </p>
                            <div class="w-100">
                                <form action="updateCategory.php" method="get">
                                    <input type="hidden" name="id" value="<?php echo $cat['id'] ; ?>">
                                    <input type="submit" value="Update" class="btn btn-primary w-100">
                                </form>
                            </div>
                            <div>
                                <form action="">
                                    <input type="hidden" name="id" value="<?php echo $cat['id'] ; ?>">
                                    <input type="submit" value="Delete" class="btn btn-danger w-100">
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </main>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer bg-dark text-white mt-auto py-3">
        <div class="container">
            <span>&copy; 2024 Dashboard. All rights reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap 5 JS & Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>