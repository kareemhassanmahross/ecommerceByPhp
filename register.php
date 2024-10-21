<?php 
session_start();

if($_REQUEST){
require "connection.php";
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

$file_iamge       = $_FILES['iamge']['tmp_name'];
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
    
    $fileName = pathinfo($_FILES['iamge']['name']);
    $fileExtension = $fileName['extension'];
    $fileSize = $_FILES['iamge']['size'];
    $ss = time() * $fileSize;
    $newFileName = $fileName['filename'] . '_' . $fileSize . '_' .time() ."_" . $ss . '.' . $fileExtension;
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
        move_uploaded_file( $_FILES['iamge']['tmp_name'], $LocationImage );
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
if($imageValidate != 1){
    array_push($errorMsg,$imageValidate);
}
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
    <link href="styles/style.css" rel="stylesheet">

</head>

<body>
    <div class="container">

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
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" >
            </div>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="text" class="form-control" id="email" name="email" >
            </div>
            <div>
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" id="formFile" name="iamge">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>
            <div class="form-group">
                <label for="confirm-password">confirm-password</label>
                <input type="password" class="form-control" id="confirm-password" name="confirm-password" >
            </div>
            <input class="btn  l-btn" type="submit" value="Submit">
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
</body>

</html>