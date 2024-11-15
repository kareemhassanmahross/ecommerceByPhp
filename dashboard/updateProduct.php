<?php
require "../connection.php";

if($_REQUEST){
    $id = $_REQUEST['id'];
    $sql = "SELECT 
    p.`id`,
    p.`name`,
    p.`desc`,
    p.`image`,
    p.`price`,
    p.`amount`,
    p.`category_id`,
    c.`name` as `namecat`
    FROM  `products` p
    INNER JOIN  `categories` c
    ON c.id = p.category_id AND p.id = '$id'
    GROUP BY p.id";
    $stmt = $pdo ->prepare($sql);
    $stmt -> execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);


    $sql = "SELECT `id`,`name` from `categories` WHERE id != ".$product['category_id'];
    $stmt = $pdo ->prepare($sql);
    $stmt -> execute();
    $cats = $stmt->fetchAll(PDO::FETCH_ASSOC);
}




require "layouts/header.php";
?>
<div class="container">
    <div class="page-inner">
     <h1 class="display-2">Update Product</h1>
     <!-- <h1 class="display-3 mb-5" >Add Category</h1 > -->
        <!-- ############################################################################################################################# -->
        <div class="row">
            <form action="editProduct.php" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?= $product['id']?>" name="id">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $product['name']?>">
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <div class="col-3">
                        <label for="Price" class="form-label">Product Price</label>
                        <input type="number" class="form-control" id="Price" name="price"
                            value="<?= $product['price']?>">
                    </div>
                    <div class="col-3">
                        <label for="Amount" class="form-label">Product Amount</label>
                        <input type="number" class="form-control" id="Amount" name="amount"
                            value="<?= $product['amount']?>">
                    </div>
                    <div class="col-3">
                        <label for="name" class="form-label">Category Product</label>
                        <select name="category_id" class="form-select" aria-label="Default select example">
                            <option value="<?= $product['category_id']?>" selected><?= $product['namecat']?></option>
                            <?php foreach($cats as $cat){ ?>
                            <option name="category_id" value="<?=$cat['id']?>"><?=$cat['name']?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="floatingTextarea2">Product Description</label>
                    <textarea class="form-control" placeholder="Leave a comment here" name="desc" id="floatingTextarea2"
                        style="height: 100px"><?= $product['desc']?></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFileLg" class="form-label">Image</label>
                    <input class="form-control form-control-lg" name="iamge" id="formFileLg" type="file">
                    <img src="imagesProduct/<?= $product['image']?>" width="200px" height="150px">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php
require "layouts/footer.php";