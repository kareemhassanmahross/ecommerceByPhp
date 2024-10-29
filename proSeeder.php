<?php
require "connection.php";


if($_REQUEST){
    $number = $_REQUEST['numder'];

$sql = "SELECT `id` FROM categories";
$stmt = $pdo->prepare($sql); 
$stmt -> execute();
$DataOfcategory_id  = $stmt->fetchAll(PDO::FETCH_ASSOC);
//   echo "<pre>";
//   print_r($DataOfcategory_id);
//   echo "</pre>";
$image = array(
    '3d-render-home-appliances-collection-260nw-1668941440_16714_1730213503_28918788489142.webp',
    '3d-set-home-appliances-on-260nw-1126949681_12178_1730213586_21070541050308.webp',
    '360_F_313326626_DzL4o62hK6J9nMzstD6kB5tFaYRAg19j_45881_1730213598_79383930089838.jpg',
    'download_10099_1730213610_17473427247390.jpg',
    'images_4603_1730213636_7964173366508.jpg',
    '51GY9x6VfYS._AC._SR360,460_10200_1729975292_17645747978400.jpg',
    '51mPmc0rRQL._AC_UL320__8162_1730238621_14122207624602.jpg',
    '51noQkUJHoL._AC._SR360,460_10201_1729975315_17647478188315.jpg',
    '51OMg-qLlbL._AC._SR360,460_13340_1730214120_23081056360800.jpg',
    '51-s5ANJNdL._AC_UL320__6893_1730238675_11926535186775.jpg',
    '51T2nbc4v0L._AC_UL320__14038_1730238801_24289092288438.jpg',
    '51Tj2BNiI0L._AC_UL165_SR165,165__4881_1730238659_8445294894579.jpg',
    '61o7guxLrzL._AC_UL320__10883_1730238765_18830188479495.jpg',
    '61QoFpeM+3L._AC_SX522__18579_1730238736_32146105476144.jpg',
    '61T25sbWW7L._AC._SR360,460_15504_1730215998_26825268832992.jpg',
    '71ARXWgUqiL._AC._SR360,460_16431_1730214130_28429148370030.jpg',
    'cat-4_35606_1730216135_61606075702810.jpg'
  );
  $countCat = count($DataOfcategory_id);
  $random = array_rand($image,17);
  $randomCat = array_rand($DataOfcategory_id, $countCat);


  $data = [];

  function rand1(){
    $index = [];
    for($i = 1 ; $i<=5 ; $i++){
        array_push($index , $i);
    }
    
    $ran = array_rand($index,2);
    return $index[$ran[0]];
  }
  function randcat($countCat){
    $index = [];
    for($i = 8 ; $i<=$countCat ; $i++){
        array_push($index , $i);
    }
    //   echo "<pre>";
    //     print_r($index);
    //   echo "</pre>";
    $ran = array_rand($index,2);
    return $index[$ran[0]];
  }

    for($i = 1 ; $i <= $number ; $i++){
            array_push($data,[
            'name'  => "Pro".$i,
            "desc"  => "It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum",
            "image" => $image[$random[rand1()]],
            "price" => 100,
            "amount"=> 100,
            "category_id"=>randcat($countCat)
            ]);
    }
    //   echo "<pre>";
    //     print_r($data);
    //   echo "</pre>";


    foreach ($data as $da){
        $name = $da["name"];
        $desc = $da["desc"];
        $image = $da["image"];
        $price = $da["price"];
        $amount = $da["amount"];
        $category_id = $da['category_id'];
        $sql = "INSERT INTO products (`name`,`desc`,`image`,`price`,`amount`,`category_id`)
         VALUES ('$name','$desc','$image','$price','$amount','$category_id')";
        // echo $sql;
        $stmt = $pdo->prepare($sql); 
        $stmt -> execute();
        header("Location: seeder.php");
      }
}