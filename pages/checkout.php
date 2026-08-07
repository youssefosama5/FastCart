<?php
require_once __DIR__ . '/../config/session.php';
$root = '../';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>checkout - fastCart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/checkout.css">
</head>

<body>
    <?php include '../include/header.php'; ?>

    <div class="checkout">
        <h1>checkout <i class="fa-solid fa-bag-shopping"></i></h1>

        <div class="checkout-wrap">
            <div class="checkout-form">
                <h3>shipping details</h3>
                <form id="checkout-form">
                    <div class="row-inputs">
                        <div class="input">
                            <label for="ch-name">full name</label>
                            <input type="text" id="ch-name" class="form-control" placeholder="full name" required />
                        </div>
                        <div class="input">
                            <label for="ch-phone">phone</label>
                            <input type="tel" id="ch-phone" class="form-control" placeholder="01xxxxxxxxx" required pattern="01[0125][0-9]{8}" maxlength="11" />
                        </div>
                    </div>
                    <div class="input full">
                        <label for="ch-address">address</label>
                        <input type="text" id="ch-address" class="form-control" placeholder="street, building, floor..." required />
                    </div>
                    <div class="row-inputs">
                        <div class="input">
                            <label for="ch-city">city</label>
                            <input type="text" id="ch-city" class="form-control" placeholder="city" required />
                        </div>
                        <div class="input">
                            <label for="ch-postal">postal code</label>
                            <input type="text" id="ch-postal" class="form-control" placeholder="postal code" />
                        </div>
                    </div>

                    <label>payment method</label>
                    <div class="pay-methods">
                        <label><input type="radio" name="payment" value="cash" checked /> cash on delivery</label>
                        <label><input type="radio" name="payment" value="card" /> credit / debit card</label>
                    </div>

                    <button type="submit" id="place-order-btn">place order</button>
                </form>
            </div>

            <div class="order-summary" id="order-summary">
                <p class="checkout-msg">Loading...</p>
            </div>
        </div>
    </div>

    <div id="toast-container"></div>

    <?php include '../include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/common.js"></script>
    <script src="../assets/js/checkout-page.js"></script>
</body>

</html>
