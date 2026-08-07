<?php
require_once __DIR__ . '/../config/session.php';
$root = '../'; // we're inside the pages/ folder
require_once __DIR__ . '/../config/db.php';

$products = [];
$result = $conn->query('SELECT id, title, category, price, discount, quantity, img, description AS `desc` FROM products');
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Filter: if a filter comes from the URL (?category=xxx) we filter it here on the server
// If not, we send all products and let the filtering happen in JavaScript as before (without a reload)
$activeFilter = isset($_GET['category']) ? $_GET['category'] : 'all';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>shop - fastCart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/shop.css">
</head>

<body>
    <?php include '../include/header.php'; ?>

    <div class="shop">
        <h2>shop <span><i class="fa-solid fa-store"></i></span></h2>
        <div class="products-shop">
            <div class="head-shop d-flex align-items-center justify-content-between w-100">
                <h3>our products <span><i class="fa-solid fa-bag-shopping"></i></span></h3>
                <div class="filter d-flex align-items-center gap-2">
                    <?php
                    $categories = ['all' => 'All', 'Fruits & Vegetables' => 'Fruits', 'Delicious' => 'delicious', 'Dairy' => 'dairy', 'Beverage' => 'beverage', 'Snacks' => 'snacks', 'Cooking' => 'cooking'];
                    foreach ($categories as $catValue => $catLabel) {
                        $active = ($activeFilter === $catValue) ? ' active' : '';
                        echo '<button type="button" class="filter-btn' . $active . '" data-filter="' . htmlspecialchars($catValue) . '">' . $catLabel . '</button>';
                    }
                    ?>
                </div>
            </div>
            <div class="all-products d-flex align-items-center justify-content-evenly flex-wrap row-gap-4 mt-5 pb-3">
                <?php foreach ($products as $product): ?>
                    <div class="product d-flex align-items-center justify-content-evenly flex-column" data-category="<?php echo htmlspecialchars($product['category']); ?>">
                        <figure>
                            <img src="<?php echo htmlspecialchars($product['img']); ?>" alt="" />
                        </figure>
                        <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                        <p><?php echo htmlspecialchars($product['category']); ?></p>
                        <span style="color: goldenrod"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></span>
                        <span>$<?php echo $product['price']; ?> <del class="ms-2">$<?php echo round($product['price'] * 1.5); ?></del></span>
                        <button type="button" class="add-cart-btn" data-id="<?php echo $product['id']; ?>" data-title="<?php echo htmlspecialchars($product['title']); ?>" data-price="<?php echo $product['price']; ?>" data-img="<?php echo htmlspecialchars($product['img']); ?>">Add to cart</button>
                        <button type="button" class="add-fav-btn" id="fav" data-id="<?php echo $product['id']; ?>" data-title="<?php echo htmlspecialchars($product['title']); ?>" data-price="<?php echo $product['price']; ?>" data-img="<?php echo htmlspecialchars($product['img']); ?>"><i class="fa-solid fa-heart"></i></button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="toast-container"></div>

    <?php include '../include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/common.js"></script>
    <script src="../assets/js/shop-page.js"></script>
</body>

</html>