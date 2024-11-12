<?php
session_start();

if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}

require "connection.php";


    $sql  = "UPDATE users SET `address` = "."'".$_REQUEST['addresss']."'".",
        `phone` = "."'".$_REQUEST['addresss']."'".",
          WHERE `id` =".$_REQUEST['id'];
    $stmt = $pdo->prepare($sql);
    $stmt ->execute();



setcookie("productData", $data, time() , "/");

?>
<script>
    function clearLocalStorage(){
        localStorage.clear()
    }
    window.onload = clearLocalStorage();
</script>
<?php 
header("Location: qwe.php");