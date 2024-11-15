<?php
require "../connection.php";

$sql  = "SELECT  * FROM categories"; 
$stmt = $pdo->prepare($sql); 
$stmt -> execute();
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
                            <form action="addCategory.php" method="get" class="ms-auto">
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
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Images</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i=1;
                                     foreach($row as $r){?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$r['name']?></td>
                                        <td><?=$r['desc']?></td>
                                        <td><img src="imagesCategory/<?= $r['image']; ?>" width="100px" height="100px">
                                        </td>
                                        <td>
                                            <div class="form-button-action">
                                                <form action="updateCategory.php" method="get">
                                                    <input type="hidden" name="id" value="<?=$r['id']?>">
                                                    <button type="submit" data-bs-toggle="tooltip" title=""
                                                        class="btn btn-link btn-primary btn-lg"
                                                        data-original-title="Edit Task">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                </form>
                                                <form action="deleteCategory.php" method="get">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require "layouts/footer.php";