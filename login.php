<?php
session_start();

if($_REQUEST){
    require "connection.php";


    $errorMsg = [];
    function email($email){
        $pattern ="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
        $checkEmail = preg_match($pattern, $email);
        return $checkEmail;
    }
    function checkPassword($password){
           $pattern ="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
           $checkPassword = preg_match($pattern, $password);
           if($checkPassword == 1){
                 return $checkPassword;
           }else{
                return $checkPassword;
           }
    }
    $email           = $_REQUEST['email'];
    $password        = $_REQUEST['password'];
    $emailVlidate    = email($email);
    $passwordVlidate = checkPassword($password);

    if($emailVlidate != 1){
        array_push($errorMsg,"Email Must Be like 'example@example.com'");
    }
    if($passwordVlidate != 1){
        array_push($errorMsg,"The password must be contain at lest one char cabital and at lest 8 chars and atlest on spashial char");
    }
    $count = count($errorMsg);
    if($emailVlidate == 1 && $passwordVlidate == 1){
        $sql = "SELECT * FROM `users` WHERE `email` ="."'".$email."'";
        $stmt = $pdo->prepare($sql); 
        $stmt -> execute();
        $user = $stmt -> fetch(PDO::FETCH_ASSOC);
        $validpassword = password_verify($password,$user['password']) ;
        If($validpassword === false){
            array_push($errorMsg,"Password is invalid .");
        }else{
            $_SESSION['user'] = $email;
            header("Location: profile.php");
        }

    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/style.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="text-right">Login</h1>
        <?php
        if(isset($count) >= 1) {
        if($count >= 1) {
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
        <form>
            <div class="form-group">
                <label for="email">E-Mail</label>
                <input type="text" class="form-control" id="email" name="email" >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" >
            </div>
            <button type="submit" class="btn btn-danger">Login</button>
            <a href="register.php" class="btn btn-link"> SIGN UP </a>
        </form>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
</body>

</html>