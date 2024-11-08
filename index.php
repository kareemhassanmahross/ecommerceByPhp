<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landing Page</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="styles/styleindex.css" rel="stylesheet">
</head>

<body>

    <!-- Header with Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Brand Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Store</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div id="carouselExampleInterval" class="carousel slide  new-bg" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="dashbord/category/imagesCategory/3d-render-home-appliances-collection-260nw-1668941440_16714_1730213503_28918788489142.webp" class="w-100" height="500px">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="dashbord/category/imagesCategory/3d-render-home-appliances-collection-260nw-1668941440_16714_1730213503_28918788489142.webp" class="w-100" height="500px" >
                </div>
                <div class="carousel-item">
                    <img src="dashbord/category/imagesCategory/3d-render-home-appliances-collection-260nw-1668941440_16714_1730213503_28918788489142.webp" class="w-100" height="500px">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">Our Services</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Service 1</h5>
                            <p class="card-text">A brief description of the service you provide.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Service 2</h5>
                            <p class="card-text">A brief description of the service you provide.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Service 3</h5>
                            <p class="card-text">A brief description of the service you provide.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>About Us</h2>
                    <p>
                        Welcome to our company! We are dedicated to providing the best services to our clients. Our team
                        is made up of experienced professionals who are passionate about what they do. We strive to
                        deliver high-quality solutions that exceed expectations and help our clients achieve their
                        goals.
                    </p>
                    <p>
                        Whether you are looking for innovative solutions or reliable services, we are here to assist you
                        every step of the way. Our commitment to excellence and attention to detail make us stand out in
                        the industry. Let us help you make your vision a reality!
                    </p>
                </div>
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500x500" alt="About Us Image">
                </div>
            </div>
        </div>
    </section>
    <section class="contact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="text-center">Contact Us</h2>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Enter your message"
                                required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer>
        <p>&copy; 2024 All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>