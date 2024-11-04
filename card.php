<?php 
require "connection.php";
// start_session();

// $_SESSION['user'] = $email;

// if(!$email){

//     header("Location: login.php");
// }
var_dump($_REQUEST['id']);


$sql = "SELECT  * from `products` WHERE id = ".$_REQUEST['id'];
$stmt = $pdo->prepare($sql);
$stmt -> execute();
$Data = $stmt->fetch(PDO::FETCH_ASSOC);
echo "<pre>";
print_r($Data);
echo "</pre>";


?>

<!DOCTYPE html>
<html>
<body>

<h1>The Window Object</h1>
<h2>The localStorage Property</h2>

<h2>Array from Local Storage:</h2>
    <ul id="arrayDisplay"></ul>

    <script>
let product = {
   
    id: "<?php echo $Data['id'] ;?>",
    name: "<?php echo $Data['name'] ;?>",
    desc: "<?php echo $Data['desc'] ;?>",
    image: "<?php echo $Data['image'] ;?>",
    price: "<?php echo $Data['price'] ;?>",
    category_id: "<?php echo $Data['category_id'] ;?>", 
    amount: "<?php echo $Data['amount'] ;?>"

};
const list = document.getElementById("arrayDisplay");
console.log(typeof product); 
for (const key in product) {
    if (product.hasOwnProperty(key)) {
        const listItem = document.createElement("li");
        listItem.textContent = `${key}: ${product[key]}`;
        list.appendChild(listItem);
    }
}

localStorage.setItem("product", JSON.stringify(product));

window.location.href = "http://localhost/ecommerce/home.php";

// const arrayDisplay = document.getElementById("arrayDisplay");
// const newProduct = JSON.parse(localStorage.getItem("product"));
// const arrayOfObjects = Object.entries(newProduct).map(([key, value]) => ({ key, value }));

//         // Check if the array exists
//         if (arrayOfObjects && Array.isArray(arrayOfObjects)) {
//             // Loop through the array and create list items
//             arrayOfObjects.forEach(item => {
//                 const listItem = document.createElement("li");
//                 listItem.textContent = item;
//                 arrayDisplay.appendChild(listItem);
//             });
//         } else {
//             arrayDisplay.textContent = "No array found in local storage.";
//         }

// localStorage.clear();

// انت هنا وصلت لانك ازاى تضيف اراى من ال بى لتش بى و تخزنها فى اللوكل استورج و تجبها تانى 
</script>

</body>
</html>