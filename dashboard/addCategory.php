<?php
require "../connection.php";
if($_REQUEST){
    $name             = $_REQUEST['name'];
    $desc             = $_REQUEST['desc'];
    $file_iamge       = $_FILES['iamge']["tmp_name"];
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
 
      $nameValidate = name($name);
      $descValidate = desc($desc);
      $imageValidate = image($file_iamge);
 
      $errorMsg = [];
      $successMsg = []; 
 
     if($nameValidate == 1 && $descValidate == 1  & $imageValidate == 1){
         $fileName = pathinfo($_FILES['iamge']['name']);
         $fileExtension = $fileName['extension'];
         $fileSize = $_FILES['iamge']['size'];
         $ss = time() * $fileSize;
         $newFileName = $fileName['filename'] . '_' . $fileSize . '_' .time() ."_" . $ss . '.' . $fileExtension;
         $LocationImage = "imagesCategory/" . $newFileName;
         $data = [
           "name" => trim($_REQUEST['name']),
           'desc' => trim($_REQUEST['desc']),
           'image'=> $newFileName
         ];
 
         $sql = "INSERT INTO categories (`name`,`desc`,`image`) VALUES (:name, :desc, :image)";
         move_uploaded_file( $_FILES['iamge']['tmp_name'], $LocationImage );
         $pdo->prepare($sql)->execute($data);
         array_push($successMsg,"your Are Registerd successfully");
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
 
     $count = count($errorMsg);
     $countM = count($successMsg);
 }
require "layouts/header.php";
?>
<div class="container">
    <div class="page-inner">

        <!-- ############################################################################################################################# -->
        <div class="row">
            <h2>Add Category</h2>

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
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="floatingTextarea2">Category Description</label>
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