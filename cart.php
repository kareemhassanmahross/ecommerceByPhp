<?php  


session_start();

if (!isset($_SESSION['user'])) {
    $currentPage = urlencode($_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$currentPage");
}

require "connection.php";

$email = $_SESSION['user'];

$sql = "SELECT * FROM `users` WHERE `email` ="."'".$email."'";
$stmt = $pdo->prepare($sql); 
$stmt -> execute();
$user = $stmt -> fetch(PDO::FETCH_ASSOC);
// echo $sql; 
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container my-5">
        <h2 class="text-center mb-4">Billing Details</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Billing Address</h4>
                <form action="" method="post">
                    <input type="hiden" name="" id="" value="<?= $user['id']?>">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" value="<?= $user['fullname']?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" value="<?= $_SESSION['user'] ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="Phone" class="form-label">Phone</label>
                        <input type="Phone" class="form-control" name="phone" id="Phone" required>
                    </div>
                    <!-- <input type="submit" class="btn btn-primary w-100" id="makeOrder" value="Place Order"> -->
                    <input type="submit" id = "makeOrder" value="Place Order" class="btn btn-primary w-100">
                </form>
                    <!-- <button type="submit" class="btn btn-primary w-100"></button> -->
            </div>


            <div class="col-md-6">
                <h4>Order Summary</h4>
                <ul class="list-group mb-3" id="content">

                </ul>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    const cart = localStorage.getItem('cart');
    const products = JSON.parse(cart);
    const productCounts = products.reduce((acc, product) => {
        const key = product.productId;
        if (acc[key]) {
            acc[key].amount_repit += 1;
        } else {
            acc[key] = {
                ...product,
                amount_repit: 1
            };
        }

        return acc;
    }, {});
    // localStorage.clear();
    const cart1 = Object.values(productCounts);
    localStorage.setItem('cart1', JSON.stringify(cart1));
     
    
    const contentDiv = document.getElementById('content');
    let sumPrice = 0;
    cart1.forEach(product => {
        let totalPriceProduct = (product.price) * (product.amount_repit);
        contentDiv.innerHTML += "<li class='list-group-item d-flex justify-content-between'><span>" + product
            .name + "</span><span>price :" + product.price + "</span><span>quntity :" + product.amount_repit +
            "</span><span>" + totalPriceProduct + " $</span></li>";
        sumPrice = sumPrice + Number(totalPriceProduct);
    });
    contentDiv.innerHTML +=
        "<li class='list-group-item d-flex justify-content-between bg-lite border'><span class='fw-bold'>Totla </span><span class='fw-bold'>" +
        sumPrice + " $</span></li>";
        let name = document.getElementById('fullName').value;
        let email = document.getElementById('email').value;
        let makeOrder = document.getElementById('makeOrder');
            makeOrder.addEventListener("click",sendDataToPHP());
        function sendDataToPHP() {
            let cart = JSON.parse(localStorage.getItem("cart1") || "{}");
            cart = {
                cart,
                "name":`${name}`,
                "email":`${email}`
            };
            fetch("process_data.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(cart)
            })
            .then(response => response.json())
            .then(result => {
                console.log("استجابة PHP:", result); // التعامل مع استجابة PHP
            })
            .catch(error => {
                console.error("خطأ:", error); // التعامل مع الأخطاء
            });
        }
    </script>
</body>

</html>