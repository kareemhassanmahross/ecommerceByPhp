<?php

require "connection.php";


if($_REQUEST){
    $number = $_REQUEST['numder'];
    // echo $number;
  $image = array(
    '3d-render-home-appliances-collection-260nw-1668941440_16714_1730213503_28918788489142.webp',
    '3d-set-home-appliances-on-260nw-1126949681_12178_1730213586_21070541050308.webp',
    '360_F_313326626_DzL4o62hK6J9nMzstD6kB5tFaYRAg19j_45881_1730213598_79383930089838.jpg',
    'download_10099_1730213610_17473427247390.jpg',
    'images_4603_1730213636_7964173366508.jpg'
  );
  echo "<br>";
  
  $random = array_rand($image,5);


  $data = [];

  function rand1(){
    $index = [];
    for($i = 1 ; $i<=5 ; $i++){
        array_push($index , $i);
    }
    
    $ran = array_rand($index,2);
    return $index[$ran[0]];
  }



  for($i = 1 ; $i <= $number ; $i++){
      array_push($data,[
        'name'  => "Cat".$i,
        "desc"  => "It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
        "image" => $image[$random[rand1()]]
      ]);
  }
//   echo "<pre>";
//   print_r($data);
//   echo "</pre>";
  foreach ($data as $da){
    $name = $da["name"];
    $desc = $da["desc"];
    $image = $da["image"];
    $sql = "INSERT INTO categories (`name`,`desc`,`image`) VALUES ('$name','$desc','$image')";
    // echo $sql;
    $stmt = $pdo->prepare($sql); 
    $stmt -> execute();
    header("Location: seeder.php");
  }
}