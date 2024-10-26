<?php
require "../../connection.php"; 
$sql = "SELECT `id` , `name` FROM `categories`";
$stmt = $pdo->prepare($sql); 
$stmt -> execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
function price($price){
    if(is_numeric($price) ){
        if($price == 0 || $price <= 10){
            return 0;
        }
        return 1;
    }
    return 0;
}
function amount($amount){
    if(is_numeric($amount) ){
        if($amount == 0 || $amount <= 25){
            return 0;
        }
        return 1;
    }
    return 0;
}
function categoryId($category_id,$row){
    $Ids_cat=[];
    foreach($row as $cat){
        array_push($Ids_cat,$cat['id']);
    }
  if(in_array($category_id, $Ids_cat)){
    return 1;  
  }
  return 0;
}
function image($file_iamge){
    if(!empty($file_iamge)){
        $fileName = pathinfo($_FILES['iamge']['name']);
        $fileExtension = $fileName['extension'];
        $fileSize = $_FILES['iamge']['size'];
    
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
$id           = $_REQUEST['id'];
$name         = $_REQUEST['name'];
$desc         = $_REQUEST['desc'];
$price        = $_REQUEST['price'];
$amount       = $_REQUEST['amount'];
$category_id  = $_REQUEST['category_id'];
$file_iamge   = $_FILES['iamge']["tmp_name"];
echo "<pre>";
print_r($_FILES);
echo "</pre>";


$nameValidate  = name($name);
$descValidate  = desc($desc);
$priceValidate = price($price);
$amountVlidate = amount($amount);
$catIdValidate = categoryId($category_id,$row);
$imageValidate = image($file_iamge);

echo $nameValidate .
$descValidate .
$priceValidate .
$amountVlidate .
$catIdValidate  .
$imageValidate;
if($file_iamge == null){
    if ($nameValidate == 1 && $descValidate == 1 &&
    $priceValidate == 1 &&$amountVlidate == 1  && $catIdValidate ==1 ){
        
        $id           = $_REQUEST['id'];
        $name         = $_REQUEST['name'];
        $desc         = $_REQUEST['desc'];
        $price        = $_REQUEST['price'];
        $amount       = $_REQUEST['amount'];
        $category_id  = $_REQUEST['category_id'];
        $sql  = "UPDATE products
        SET `name` = '$name',
            `desc` = '$desc',
            `price`= '$price',
            `amount`= '$amount',
            `category_id` ='$category_id'
              WHERE `id` =".$id;
        $stmt = $pdo->prepare($sql);
        $stmt ->execute();
        header("Location: products.php");
    } 
}
if($file_iamge != null){
    if ($nameValidate == 1 && $descValidate == 1 && $priceValidate == 1 &&
            $amountVlidate == 1  && $catIdValidate == 1 && $imageValidate == 1){
                $sql = "SELECT `image` FROM `products` WHERE id = ".$id;
                $query = $pdo -> prepare($sql);
                $query ->execute();
                $data = $query->fetch(PDO::FETCH_ASSOC);
                $img = $data['image'];
                $fileName = pathinfo($_FILES['iamge']['name']);
                $fileExtension = $fileName['extension'];
                $fileSize = $_FILES['iamge']['size'];
                $ss = time() * $fileSize;
                $newFileName = $fileName['filename'] . '_' . $fileSize . '_' .time() ."_" . $ss . '.' . $fileExtension;
                $LocationImage = "imagesProduct/" . $newFileName;

                $sql  = "UPDATE products
                 SET `name` = '$name',
                     `desc` = '$desc',
                     `price`= '$price',
                     `amount`= '$amount',
                     `image`='$newFileName',
                     `category_id` ='$category_id'
                     WHERE `id` =".$id;

                move_uploaded_file( $_FILES['iamge']['tmp_name'], $LocationImage );
                unlink("imagesProduct/".$img);
                $stmt = $pdo->prepare($sql);
                $stmt ->execute();
                header("Location: products.php");
   }
}