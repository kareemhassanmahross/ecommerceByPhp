<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two Forms with Bootstrap 5</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container my-5">
    <div class="row justify-content-center">
        <!-- First Form -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Category Seeder</h2>
                    <form action="cateSeeder.php" method="get">
                        <div class="mb-3">
                            <label for="numder" class="form-label">Numder Of Records</label>
                            <input type="number" class="form-control" id="numder" name="numder" required>
                        </div>
                        <input type="submit" class="btn btn-primary w-100"  value="Seed Data" name="" id="">
                    </form>
                </div>
            </div>
        </div>

        <!-- Second Form -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Product Seeder</h2>
                    <form action="proSeeder.php" method="get">
                    <div class="mb-3">
                            <label for="numder" class="form-label">Numder Of Records</label>
                            <input type="number" class="form-control" id="numder" name="numder" required>
                        </div>
                        <input type="submit" class="btn btn-primary w-100"  value="Seed Data" name="" id="">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

