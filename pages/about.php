<?php
require_once __DIR__ . '/../config/session.php';
$root = '../';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>about us - fastCart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/about.css">
</head>

<body>
    <?php include '../include/header.php'; ?>

    <div class="about">
        <div class="about-hero">
            <div class="txt">
                <h1>about <span>fresh<span style="color:var(--green)">Cart</span></span></h1>
                <p>
                    fastCart started with a simple idea: getting 100% natural, organic food
                    from local farms to your door without the hassle. we hand pick every
                    product on our shelves and work directly with trusted farmers to make
                    sure what you get is always fresh, healthy and fairly priced.
                </p>
                <p>
                    today we're proud to serve thousands of happy customers who trust us
                    for their everyday fruits, vegetables, dairy and pantry essentials.
                </p>
            </div>
            <figure>
                <img src="../assets/images/value/2.png" alt="fresh organic products" />
            </figure>
        </div>

        <div class="about-values">
            <div class="value-card">
                <i class="fa-solid fa-leaf"></i>
                <h3>100% organic</h3>
                <p>every product is sourced from certified organic farms with no shortcuts.</p>
            </div>
            <div class="value-card">
                <i class="fa-solid fa-truck-fast"></i>
                <h3>fast delivery</h3>
                <p>free shipping on orders over $100, delivered fresh to your door.</p>
            </div>
            <div class="value-card">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <h3>support local farmers</h3>
                <p>we work directly with local farmers to keep the supply chain short and fair.</p>
            </div>
        </div>

        <div class="about-stats">
            <div class="stat">
                <h2>10K+</h2>
                <p>happy customers</p>
            </div>
            <div class="stat">
                <h2>200+</h2>
                <p>partner farms</p>
            </div>
            <div class="stat">
                <h2>5000+</h2>
                <p>products delivered</p>
            </div>
            <div class="stat">
                <h2>3+</h2>
                <p>years of experience</p>
            </div>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
