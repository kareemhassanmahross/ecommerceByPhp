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
            if($email == "Kareem@admin.com"){
                $_SESSION['user'] = $email;
                header("Location: dashbord/index.php");
            }else{
                if (isset($_REQUEST['redirect'])) {
                    $_SESSION['user'] = $email;
                    header("Location: " . $_REQUEST['redirect']);
                } else {
                    $_SESSION['user'] = $email;
                    header("Location: profile.php"); 
                }
            }
        }
    }
}

