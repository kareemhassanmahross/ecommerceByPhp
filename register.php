<?php 
session_start();

if($_REQUEST){

require "connection.php";
echo "<pre>";
print_r($_FILES);
echo "</pre><br>";
function fullname($fullname){
    $pattern = '/^[A-Za-z][A-Za-z\'\-]+([\ A-Za-z][A-Za-z\'\-]+)*/';
    $checkName = preg_match($pattern, $fullname);
    return $checkName;
}

function email($email){
  $email = trim($email);  
  $pattern ="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
  $checkEmail = preg_match($pattern, $email);
  return $checkEmail;
}

function image($file_iamge){
    if(!empty($file_iamge)){
        $fileName = pathinfo($_FILES['image']['name']);
        $fileExtension = $fileName['extension'];
        $fileSize = $_FILES['image']['size'];
        // if($fileSize > 2000000){
        //     $errorMsg = "File is Over 2 Mb in size <br>";
        //     return $errorMsg;
        // }
    
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


function checkPassword($password, $confirm_password){
     if($password ===  $confirm_password ){
        $pattern ="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
        $checkPassword = preg_match($pattern, $password);
        if($checkPassword == 1){
            return $checkPassword;
        }else{
            return "The password must be contain at lest one char cabital and at lest 8 chars and atlest on spashial char";
        }
     }else{
        return "Password is not confirmed with confirm password";
     }
}

$file_iamge       = $_FILES['image']['tmp_name'];

$fullname         = $_REQUEST['fullname'];
$email            = $_REQUEST['email'];
$password         = $_REQUEST['password'];
$confirm_password = $_REQUEST['confirm-password'];
$fullNameValidate = fullname($fullname);
$emailValidate    = email($email);
$imageValidate    = image($file_iamge);
$passwordValidate = checkPassword($password,$confirm_password);


$successMass = [];
$errorMsg    = []; 


if($imageValidate == 1 && $fullNameValidate == 1  && $emailValidate == 1 && $passwordValidate == 1){
    
    $fileName = pathinfo($_FILES['image']['name']);
    $fileExtension = $fileName['extension'];
    $fileSize = $_FILES['image']['size'];
    $ss = time() * $fileSize;
    $newFileName = $fileName['filename'] . '_' . $fileSize . '_' .time() ."_" . $ss . '.' . $fileExtension;
    echo $newFileName;
    $LocationImage = "imagesUsers/" . $newFileName;

    $fullname = $_REQUEST['fullname'];
    $email = $_REQUEST['email'];
    $password1 = $_REQUEST['password'];
    $password = password_hash($password1,PASSWORD_BCRYPT,array("cost"=>12));
    $image = $newFileName;
    $data = [
      "fullname" => $fullname,
      "email" => $email,
      "password" => $password,
      "image" => $image
    ];
    $sql  = "SELECT email, COUNT(*) AS num FROM users WHERE `email` = "."'".$email."'"; 
    $stmt = $pdo->prepare($sql); 
    $stmt -> execute();
    $row = $stmt -> fetch(PDO::FETCH_ASSOC);
    if($row['num'] == 0 ){
        $sql = "INSERT INTO users (fullname,email,password,image) VALUES (:fullname, :email, :password, :image)";
        move_uploaded_file( $_FILES['image']['tmp_name'], $LocationImage );
        $pdo->prepare($sql)->execute($data);
        $_SESSION['user'] = $data['email'];
        array_push($successMass,"You Are Registerd Successfully");
        header("Location: profile.php");
    }else {
       array_push($errorMsg,"this mail is orady exist");
    } 

}

if($fullNameValidate != 1){
    array_push($errorMsg,"Full Name Must be contain at lest one char Cabital");
}
if($emailValidate != 1){
    array_push($errorMsg,"Email Must Be like 'example@example.com'");
}
// if($imageValidate != 1){
//     array_push($errorMsg,$imageValidate);
// }
if($passwordValidate != 1){
    array_push($errorMsg,$passwordValidate);
}
$count = count($successMass);
$count1 = count($errorMsg);

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="styles/style.css" rel="stylesheet"> -->
    <style>
    /* Full-page background */
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: #f0f2f5;
        font-family: Arial, sans-serif;
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    /* Card styling */
    .card {
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 1s ease forwards;
        /* Fade-in animation */
    }

    /* Animation for card */
    @keyframes fadeIn {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Input focus and hover styling */
    .form-control:focus,
    .form-control:hover {
        box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
        transition: box-shadow 0.3s;
    }

    /* Button styling */
    .btn-primary {
        background-color: #4a90e2;
        border: none;
        transition: transform 0.3s, background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #357abd;
        transform: translateY(-3px);
        /* Subtle hover lift */
    }
    </style>
</head>

<body>
    <div class="card">

        <?php
         if(isset($count)){
         if($count >= 1) { 
         if(isset($successMass)) { ?>
        <div class="alert alert-success" role="alert">
            <ul>
                <?php foreach($successMass as $em) {
                      echo "<li>".$em."</li>";
                }
                ?>
            </ul>
        </div>
        <?php }}}?>
        <?php
        if(isset($count1) >= 1) {
        if($count1 >= 1) {
        if(isset($errorMsg)) { ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach($errorMsg as $em) {
                      echo "<li>".$em."</li>";
                }
                ?>
            </ul>
        </div>
        <?php }}} ?>


        <h1> Register </h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                    >
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" id="formFile" name="image">
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="confirm-password">confirm-password</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password">
            </div>
            <input class="btn btn-primary w-100" type="submit" value="Submit">
            <div class="text-center mt-3">
            <a href="Login.php">If do you have an account? Login</a>
        </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
</body>

</html>