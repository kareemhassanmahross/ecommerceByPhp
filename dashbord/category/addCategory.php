<?php 
require "../../connection.php";
if($_REQUEST){
   $name             = $_REQUEST['name'];
   $desc             = $_REQUEST['desc'];
   $file_iamge       = $_FILES['iamge']["tmp_name"];
    function name($name){
        $pattern  = '/^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/';
        $checkName = preg_match($pattern, $name);
        return $checkName;
    }
    

    function desc($desc){
            $wordCount = str_word_count($desc);
            if ( $wordCount >= 1 && $wordCount <= 100) {
                return 1;
            } else{
               return 0;
            }
    }

    function image($file_iamge){
        if(!empty($file_iamge)){
            $fileName = pathinfo($_FILES['iamge']['name']);
            $fileExtension = $fileName['extension'];
            $fileSize = $_FILES['iamge']['size'];
            if($fileSize > 2000000){
                $errorMsg = "File is Over 2 Mb in size <br>";
                return $errorMsg;
            }
        
            $allowedExtension = array('jpeg','png','jpg','jfif');
             
            if(!in_array( $fileExtension,$allowedExtension)){
                $errorMsg = "File type is not allowed  'jpeg','png','jpg','jfif' <br>";
                return $errorMsg;
            }
            return 1;
        }else{
            $errorMsg = "You must enter a photo";
            return $errorMsg;
        }
    }

     $nameValidate = name($name);
     $descValidate = desc($desc);
     $imageValidate = image($file_iamge);

     $errorMsg = [];
     $successMsg = []; 

    if($nameValidate == 1 && $descValidate == 1 && $imageValidate == 1 ){
        $fileName = pathinfo($_FILES['iamge']['name']);
        $fileExtension = $fileName['extension'];
        $fileSize = $_FILES['iamge']['size'];
        $ss = time() * $fileSize;
        $newFileName = $fileName['filename'] . '_' . $fileSize . '_' .time() ."_" . $ss . '.' . $fileExtension;
        $LocationImage = "imagesCategory/" . $newFileName;
        $data = [
          "name" => trim($_REQUEST['name']),
          'desc' => trim($_REQUEST['desc']),
          'image'=> $newFileName
        ];

        $sql = "INSERT INTO categories (`name`,`desc`,`image`) VALUES (:name, :desc, :image)";
        move_uploaded_file( $_FILES['iamge']['tmp_name'], $LocationImage );
        $pdo->prepare($sql)->execute($data);
        array_push($successMsg,"your Are Registerd successfully");
    }
    if($nameValidate != 1){
        array_push($errorMsg,"Name Must be contain at lest one char Cabital");
    }
    if($descValidate != 1){
        array_push($errorMsg,"The description must contain no more than 100 words and not equel null");
    }
    if($imageValidate != 1){
        array_push($errorMsg,$imageValidate);
    }

    $count = count($errorMsg);
    $countM = count($successMsg);
}
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">
                                Dashboard
                            </a>
                        </li>

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
                <h2>Add Category</h2>

                <?php if(isset($count) && $count != 0 ) {?>
                <div class="alert alert-danger display-6" role="alert">
                    <ul>
                        <?php foreach($errorMsg as $er) {echo "<li>" . $er . "</li>";}?>
                    </ul>
                </div>
                <?php } ?>
                <?php if(isset($countM) && $countM != 0 ) {?>
                <div class="alert alert-success display-6" role="alert">
                    <ul>
                        <?php foreach($successMsg as $sm) {echo "<li>" . $sm . "</li>";}?>
                    </ul>
                </div>
                <?php } ?>
                <div class="table-responsive">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea2">Category Description</label>
                            <textarea class="form-control" placeholder="Leave a comment here" name="desc"
                                id="floatingTextarea2" style="height: 200px"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formFileLg" class="form-label">Image</label>
                            <input class="form-control form-control-lg" name="iamge" id="formFileLg" type="file">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
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