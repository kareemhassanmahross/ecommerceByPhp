<?php
// require "connection.php";
// session_start();

// if (isset($_GET['redirect'])) {
//     if($_REQUEST){
//         require "connection.php";
//     $errorMsg = [];
//     function email($email){
//         $pattern ="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
//         $checkEmail = preg_match($pattern, $email);
//         return $checkEmail;
//     }
//     function checkPassword($password){
//         $pattern ="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
//         $checkPassword = preg_match($pattern, $password);
//         if($checkPassword == 1){
//                 return $checkPassword;
//         }else{
//                 return $checkPassword;
//         }
//     }

    
//       if(isset($_REQUEST['email']) && isset($_REQUEST['password'])){
//         $emailVlidate    = email($_REQUEST['email']);
//         $passwordVlidate = checkPassword($_REQUEST['password']);
//         if($emailVlidate != 1){
//             array_push($errorMsg,"Email Must Be like 'example@example.com'");
//         }
//         if($passwordVlidate != 1){
//             array_push($errorMsg,"The password must be contain at lest one char cabital and at lest 8 chars and atlest on spashial char");
//         }
//         $count = count($errorMsg);
//         if($emailVlidate == 1 && $passwordVlidate == 1){
//             $sql = "SELECT * FROM `users` WHERE `email` ="."'".$email."'";
//             $stmt = $pdo->prepare($sql); 
//             $stmt -> execute();
//             $user = $stmt -> fetch(PDO::FETCH_ASSOC);
//             $validpassword = password_verify($password,$user['password']) ;
//             If($validpassword === false){
//                 array_push($errorMsg,"Password is invalid .");
//             }else{
//                 if($email == "Kareem@admin.com"){
    
//                     $_SESSION['user'] = $email;
//                     header("Location: dashbord/index.php");
//                 }else{
//                     echo "kareem";
//                         $_SESSION['user'] = $email;
//                         // header("Location: profile.php");
//                         echo $_GET['redirect'];
//                 }
//             }
    
//         }
//       }
//   }
// } else {
//     header("Location: index.php"); // Default page
// }
    // login(htmlspecialchars($previousPage));



// function login($url){
//         if($_REQUEST){
//             require "connection.php";
//             $errorMsg = [];
//             function email($email){
//                 $pattern ="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
//                 $checkEmail = preg_match($pattern, $email);
//                 return $checkEmail;
//             }
//             function checkPassword($password){
//                 $pattern ="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
//                 $checkPassword = preg_match($pattern, $password);
//                 if($checkPassword == 1){
//                         return $checkPassword;
//                 }else{
//                         return $checkPassword;
//                 }
//             }
//             $email           = $_REQUEST['email'];
//             $password        = $_REQUEST['password'];
//             $emailVlidate    = email($email);
//             $passwordVlidate = checkPassword($password);

//             if($emailVlidate != 1){
//                 array_push($errorMsg,"Email Must Be like 'example@example.com'");
//             }
//             if($passwordVlidate != 1){
//                 array_push($errorMsg,"The password must be contain at lest one char cabital and at lest 8 chars and atlest on spashial char");
//             }
//             $count = count($errorMsg);
//             if($emailVlidate == 1 && $passwordVlidate == 1){
//                 $sql = "SELECT * FROM `users` WHERE `email` ="."'".$email."'";
//                 $stmt = $pdo->prepare($sql); 
//                 $stmt -> execute();
//                 $user = $stmt -> fetch(PDO::FETCH_ASSOC);
//                 $validpassword = password_verify($password,$user['password']) ;
//                 If($validpassword === false){
//                     array_push($errorMsg,"Password is invalid .");
//                 }else{
//                     if($email == "Kareem@admin.com"){

//                         $_SESSION['user'] = $email;
//                         header("Location: dashbord/index.php");
//                     }else{
//                         $_SESSION['user'] = $email;
//                         header("Location: $url");
//                     }
//                 }

//             }
//         }
// }
// if($_REQUEST){
//     require "connection.php";
//     $errorMsg = [];
//     function email($email){
//         $pattern ="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
//         $checkEmail = preg_match($pattern, $email);
//         return $checkEmail;
//     }
//     function checkPassword($password){
//         $pattern ="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
//         $checkPassword = preg_match($pattern, $password);
//         if($checkPassword == 1){
//                 return $checkPassword;
//         }else{
//                 return $checkPassword;
//         }
//     }
//     $email           = $_REQUEST['email'];
//     $password        = $_REQUEST['password'];
//     $emailVlidate    = email($email);
//     $passwordVlidate = checkPassword($password);

//     if($emailVlidate != 1){
//         array_push($errorMsg,"Email Must Be like 'example@example.com'");
//     }
//     if($passwordVlidate != 1){
//         array_push($errorMsg,"The password must be contain at lest one char cabital and at lest 8 chars and atlest on spashial char");
//     }
//     $count = count($errorMsg);
//     if($emailVlidate == 1 && $passwordVlidate == 1){
//         $sql = "SELECT * FROM `users` WHERE `email` ="."'".$email."'";
//         $stmt = $pdo->prepare($sql); 
//         $stmt -> execute();
//         $user = $stmt -> fetch(PDO::FETCH_ASSOC);
//         $validpassword = password_verify($password,$user['password']) ;
//         If($validpassword === false){
//             array_push($errorMsg,"Password is invalid .");
//         }else{
//             if($email == "Kareem@admin.com"){

//                 $_SESSION['user'] = $email;
//                 header("Location: dashbord/index.php");
//             }else{
//                 $_SESSION['user'] = $email;
//                 header("Location: profile.php");
//             }
//         }

//     }
// }




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            animation: fadeIn 1s ease forwards; /* Fade-in animation */
        }

        /* Animation for card */
        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Input focus and hover styling */
        .form-control:focus, .form-control:hover {
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
            transform: translateY(-3px); /* Subtle hover lift */
        }
    </style>
</head>

<body>
<div class="card">
    <h3 class="text-center mb-4">Login</h3>
    <form action="login_.php" method="POST">
        <!-- Email Input -->
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>
        
        <!-- Password Input -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <?php
         if(isset($_GET['redirect'])){
            echo "<input type='hidden' class='form-control'  name='redirect' value=".$_GET["redirect"].">";
            }?>
        
        <!-- Remember Me Checkbox -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="rememberMe" name="rememberMe">
            <label class="form-check-label" for="rememberMe">
                Remember me
            </label>
        </div>
        
        <!-- Login Button -->
        <button type="submit" class="btn btn-primary w-100">Login</button>
        
        <!-- Register Link -->
        <div class="text-center mt-3">
            <a href="register.php">Don't have an account? Register</a>
        </div>
    </form>
</div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0-beta3/js/bootstrap.bundle.min.js"></script>
</body>

</html>