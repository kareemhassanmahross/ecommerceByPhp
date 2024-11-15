<?php
   require "../connection.php";
   $page = isset($_REQUEST['page']) ?(int)$_REQUEST['page'] : 1; 
   $prePage = isset($_REQUEST["prePage"]) && $_REQUEST["prePage"] <= 50? (int)$_REQUEST['prePage'] : 20;
   
   
   $start = ($page > 1) ? ($page * $prePage) - $prePage : 0;
   $sql = "SELECT SQL_CALC_FOUND_ROWS
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
   ON c.id = p.category_id 
   GROUP BY p.id 
   LIMIT {$start} , {$prePage}";
   $stmt = $pdo->prepare($sql); 
   $stmt -> execute();
   $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

   $total = $pdo->query("SELECT FOUND_ROWS() As total")->fetch()['total'];


$pages = ceil($total / $prePage);

require "layouts/header.php";
?>
<div class="container">
    <div class="page-inner">

        <!-- ############################################################################################################################# -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Add Row</h4>
                            <form action="addProduct.php" method="get" class="ms-auto">
                                <button type="submit" class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal"
                                    data-bs-target="#addRowModal">
                                    <i class="fa fa-plus"></i>
                                    Add Row
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="add-row" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Images</th>
                                        <th>Name</th>
                                        <th>Category Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>QTY</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i=1;
                                     foreach($products as $r){?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><img src="imagesProduct/<?= $r['image']; ?>" width="100px" height="100px">
                                        <td><?=$r['name']?></td>
                                        <td><?=$r['namecat']?></td>
                                        <td><?=$r['desc']?></td>
                                        <td><?=$r['price']?></td>
                                        <td><?=$r['amount']?></td>
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <form action="updateProduct.php" method="get">
                                                    <input type="hidden" name="id" value="<?=$r['id']?>">
                                                    <button type="submit" data-bs-toggle="tooltip" title=""
                                                        class="btn btn-link btn-primary btn-lg"
                                                        data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </form>
                                                <form action="deleteProduct.php" method="post">
                                                    <input type="hidden" name="id" value="<?=$r['id']?>">
                                                    <button type="submit" data-bs-toggle="tooltip" title=""
                                                        class="btn btn-link btn-danger btn-lg">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                                <!-- deleteCategory.php -->
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $i++; }?>
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation example">
                        <div >
                            <ul class="pagination pagination-lg justify-content-center">
                                <?php for($i = 1 ; $i <= $pages ; $i++) { ?>
                                <li class="page-item"><a class="page-link <?php if($page === $i) {echo "active" ;}?>"
                                        href="?page=<?=$i?>&<?=$prePage?>"><?= $i; ?></a></li>
                                <?php } ?>

                            </ul>
                        </div>
                    </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require "layouts/footer.php";