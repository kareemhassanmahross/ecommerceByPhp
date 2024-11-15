<?php
require "../connection.php";

if($_REQUEST){
    $id = $_REQUEST['id'];
    $sql = "SELECT * FROM `categories` WHERE id =".$id;
    $stmt = $pdo ->prepare($sql);
    $stmt -> execute();
    $cat = $stmt->fetch(PDO::FETCH_ASSOC);

}
require "layouts/header.php";
?>
      <div class="container">
        <div class="page-inner">

          <!-- ############################################################################################################################# -->
          <div class="row">
          <h1 class="mb-5">Update Category</h1>
          <form action="editCategory.php" method="post" enctype="multipart/form-data">
                       
                           <input type="hidden" value="<?= $cat['id']?>" name="id">
                       <div class="mb-3">
                           <label for="name" class="form-label">Category Name</label>
                           <input type="text" class="form-control" id="name" name="name" value="<?= $cat['name']?>">
                       </div>
                       <div class="mb-3">
                           <label for="floatingTextarea2">Category Description</label>
                           <textarea class="form-control" placeholder="Leave a comment here" name="desc"
                            id="floatingTextarea2" style="height: 200px"><?= $cat['desc']?></textarea>
                       </div>
                       <div class="mb-3">
                           <label for="formFileLg" class="form-label">Image</label>
                           <input class="form-control form-control-lg" name="iamge" id="formFileLg" type="file">
                           <img src="imagesCategory/<?= $cat['image']?>" class="mt-2" width = "100px">
                       </div>

                       <button type="submit" class="btn btn-primary">Submit</button>
                   </form>
                
       
          </div>
        </div>
      </div>
<?php
require "layouts/footer.php";