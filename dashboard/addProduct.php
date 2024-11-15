<?php
require "../connection.php";

$sql = "SELECT `id` , `name` FROM `categories`";
$stmt = $pdo->prepare($sql); 
$stmt -> execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);


if($_REQUEST){

    $name       = $_REQUEST['name'];
    $desc       = $_REQUEST['desc'];
    $price      = $_REQUEST['price'];
    $amount     = $_REQUEST['amount'];
    $category_id= $_REQUEST['category_id'];
    $file_iamge = $_FILES['iamge']["tmp_name"];
    
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
    $nameValidate  = name($name);
    $descValidate  = desc($desc);
    $imageValidate = image($file_iamge);
    $priceValidate = price($price);
    $amountVlidate = amount($amount);
    $catIdValidate = categoryId($category_id,$row);
      
    $errorMsg = [];
    $successMsg = []; 


    if ($nameValidate == 1 && $descValidate == 1 &&$imageValidate == 1 &&
        $priceValidate == 1 &&$amountVlidate == 1 &&$catIdValidate == 1) {
            $fileName = pathinfo($_FILES['iamge']['name']);
            $fileExtension = $fileName['extension'];
            $fileSize = $_FILES['iamge']['size'];
            $ss = time() * $fileSize;
            $newFileName = $fileName['filename'] . '_' . $fileSize . '_' .time() ."_" . $ss . '.' . $fileExtension;
            $LocationImage = "imagesProduct/" . $newFileName; 
            $name        = trim($_REQUEST['name']);
            $desc        = trim($_REQUEST['desc']);
            $price       = trim($_REQUEST['price']);
            $amount      = trim($_REQUEST['amount']);
            $category_id = trim($_REQUEST['category_id']);
            $image       = $newFileName;
            $sql = "INSERT INTO products (`name`,`desc`,`image` ,`price`,`amount`,`category_id`)
            VALUES ('$name','$desc','$image','$price','$amount','$category_id')";
            move_uploaded_file( $_FILES['iamge']['tmp_name'], $LocationImage );
            $pdo->prepare($sql)->execute();
            array_push($successMsg,"Your Are Add Product Successfully");

    }
     
   

    if($nameValidate != 1){
        array_push($errorMsg,"Name Must be contain at lest one char Cabital");
    }
    if($descValidate != 1){
        array_push($errorMsg,"The description must contain no more than 100 words and not equel null");
    }
    if($imageValidate != 1){
        array_push($errorMsg,$imageValidate);
    }
    if($priceValidate != 1){
        array_push($errorMsg,"The price must be more than 10");
    }
    if($amountVlidate != 1){
        array_push($errorMsg,"The amount must be more than 25");
    }
    if($catIdValidate != 1){
        array_push($errorMsg,"This Category is unavailable");
    }
    $count = count($errorMsg);
    $countM = count($successMsg);
}
require "layouts/header.php";
?>
<div class="container">
    <div class="page-inner">
    <h1 class="display-3 mb-5" >Add Category</h1 >
        <!-- ############################################################################################################################# -->
        <div class="row">
        <?php if(isset($count) && $count != 0 ) {?>
                    <div class="alert alert-danger display-6" role="alert">
                        <ul>
                            <?php foreach($errorMsg as $er) {echo "<li>" . $er . "</li>";}?>
                        </ul>
                    </div>
                    <?php } ?>
                    <?php if(isset($countM) && $countM != 0 ) {?>
                    <div class="alert alert-success display-6" role="alert">
                        <ul>
                            <?php foreach($successMsg as $sm) {echo "<li>" . $sm . "</li>";}?>
                        </ul>
                    </div>
                    <?php } ?>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <div class="col-3">
                        <label for="Price" class="form-label">Product Price</label>
                        <input type="number" class="form-control" id="Price" name="price">
                    </div>
                    <div class="col-3">
                        <label for="Amount" class="form-label">Product Amount</label>
                        <input type="number" class="form-control" id="Amount" name="amount">
                    </div>
                    <div class="col-3">
                        <label for="name" class="form-label">Category Product</label>
                        <select name="category_id" class="form-select" aria-label="Default select example">
                            <option value="" selected>...</option>
                            <?php foreach($row as $cat){ ?>
                            <option name="category_id" value="<?=$cat['id']?>"><?=$cat['name']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="floatingTextarea2">Product Description</label>
                    <textarea class="form-control" placeholder="Leave a comment here" name="desc" id="floatingTextarea2"
                        style="height: 200px"></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFileLg" class="form-label">Image</label>
                    <input class="form-control form-control-lg" name="iamge" id="formFileLg" type="file">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php
require "layouts/footer.php";