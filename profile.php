<?php
session_start();

$email = $_SESSION['user'];

if($email){
    require "connection.php";

    $sql = "SELECT * FROM `users` WHERE `email` ="."'".$email."'";
    $stmt = $pdo->prepare($sql); 
    $stmt -> execute();
    $user = $stmt -> fetch(PDO::FETCH_ASSOC);
    $image = $user['image'];
}else{
    header("Location: login.php");
}


?>
<!-- index.html -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styleProfile.css">
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <h6>Wellcom Mr . <?php echo $user['fullname'] ?></h6>
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
                            <a class="nav-link" href="#">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="row justify-content-center my-5">
            <div class="col-md-6">
                <h2 class="text-center">User Profile</h2>
                <div class="profile-info">
                    <img src="imagesUsers/<?php echo $user['image'] ?>" alt="Profile Image" class="profile-image"
                        width="100px">
                    <h3>Full Name: <span id="fullname"><?php echo $user['fullname'] ?></span></h3>
                    <p>Email: <span id="email"><?php echo $user['email'] ?></span></p>
                    <p>Password: <span id="password">password123</span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>