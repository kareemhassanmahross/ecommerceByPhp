<?php

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

$file_iamge       = $_FILES['iamge']["tmp_name"];
if($file_iamge == null){
    $errorMsg = [];
    $successMass = "";
    $nameValidate = name($_REQUEST['name']);
    $descValidate = desc($_REQUEST['desc']);
    if($nameValidate != 1){
        array_push($errorMsg,"Name Must be contain at lest one char Cabital");
    }
    if($descValidate != 1){
        array_push($errorMsg,"The description must contain no more than 100 words and not equel null");
    }
    if($nameValidate == 1 && $descValidate == 1){
        require "../../connection.php";
        $id   = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $desc = $_REQUEST['desc'];
        $sql  = "UPDATE categories SET `name` = '$name', `desc` = '$desc' WHERE `id` =".$id;
        echo $sql;
        $stmt = $pdo->prepare($sql);
        $stmt ->execute();
        $successMass = "Category Updated Successfully";
        header("Location: showAllCategories.php?".$successMass);
    }else{
      echo "<pre>";
      print_r($errorMsg);
      echo "</pre>";
    }
}
if($file_iamge != null){
    echo "mogode malaf ";
}
