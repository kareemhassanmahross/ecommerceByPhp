<?php
// ضبط ترويسة المحتوى على JSON للاستجابة
header('Content-Type: application/json');

// قراءة البيانات JSON من الطلب
$data = json_decode(file_get_contents("php://input"), true);

// echo "<pre>";
// print_r($data);
// echo "</pre>";
require "connection.php";


// التحقق من استلام البيانات
if ($data) {
    // يمكن الوصول إلى البيانات المرسلة من localStorage هنا
     $name = $data['name'];
     $email = $data['email'];
     $cart  = $data['cart'];
    //    $newArray = [];
       $arr = [];
    //    $placeholders = implode(',', array_fill(0, count($newArray), '?'));
     foreach($cart as $ca){
    
            $sql = "SELECT * FROM products WHERE id =".$ca['productId'];
            $stmt1 = $pdo->prepare($sql);
            $stmt1 -> execute();
            $Data = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            foreach($Data as $da){
            array_push($arr , [
                "id"=>$da['id'],
                "name"=>$da['name'],
                "price"=>$da['price'],
                "amount"=>($da['amount'])-($ca['amount_repit']),
                "desc"=>$da['desc'],
                "image"=>$da['image'],
            ]);
        }
           
     }
     foreach($arr as $ar){
        $sql = "UPDATE products  SET `amount` =". $ar['amount'] ." WHERE id=".$ar['id'];
        $stmt1 = $pdo->prepare($sql);
        $stmt1 -> execute();
     }
    // استجابة JSON
    echo json_encode([
        "status" => "success",
        "message" => "تم استلام البيانات بنجاح",
        "received_data" => $arr
    ]);
} else {
    // في حال لم يتم استلام بيانات
    echo json_encode([
        "status" => "error",
        "message" => "لم يتم استلام بيانات"
    ]);
}
?>