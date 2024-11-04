<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <h2 class="text-center mb-4">Billing Details</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Billing Address</h4>
                <form>
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="email@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" placeholder="123 Main St" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="zip" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zip" required>
                        </div>
                    </div>
                    <hr>
                    <h4>Payment Information</h4>
                    <div class="mb-3">
                        <label for="cardName" class="form-label">Name on Card</label>
                        <input type="text" class="form-control" id="cardName" placeholder="John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Card Number</label>
                        <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456"
                            required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="expiration" class="form-label">Expiration Date</label>
                            <input type="text" class="form-control" id="expiration" placeholder="MM/YY" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv" placeholder="123" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Place Order</button>
                </form>
            </div>


            <div class="col-md-6">
                <h4>Order Summary</h4>
                <ul class="list-group mb-3" id="content">
                    
                </ul>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    const cart = localStorage.getItem('cart');
    const products = JSON.parse(cart);

    const contentDiv = document.getElementById('content');
    let sumPrice = 0;
    products.forEach(product => {
        contentDiv.innerHTML += "<li class='list-group-item d-flex justify-content-between'><span>"+product.name+"</span><span>"+product.price+"</span></li>";
        
        sumPrice = sumPrice + Number(product.price);
        // let data = product.productId
        // ids.push(data);
    });
    contentDiv.innerHTML += "<li class='list-group-item d-flex justify-content-between  bg-lite  border'><span class='fw-bold'>Totla </span><span class='fw-bold'>"+sumPrice+"</span></li>";

    // console.log(ids);
    </script>
</body>

</html>