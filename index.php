<?php
require_once __DIR__ . '/config/session.php';
$root = '';
require_once __DIR__ . '/config/db.php';

$realProductIds = [];
$idsRes = $conn->query('SELECT id FROM products ORDER BY id');
if ($idsRes) {
    while ($r = $idsRes->fetch_assoc()) {
        $realProductIds[] = (int) $r['id'];
    }
}
$realIdsCount = count($realProductIds);
function realId($index)
{
    global $realProductIds, $realIdsCount;
    if ($realIdsCount === 0)
        return $index + 1;
    return $realProductIds[$index % $realIdsCount];
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="assets/images/home-bg.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>e-commerce</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/home.css">
</head>

<body>
    <?php include 'include/header.php'; ?>


    <div class="all">
        <div class="hero">
            <div class="left">
                <span>organic</span>
                <h2>100% natural food</h2>
                <h3>fruit & vegetables</h3>
                <p>free shipping on order over $100</p>
                <button type="button">shop now</button>
            </div>
            <div class="right">
                <div class="left1 text-center pt-4 text-white">
                    <h3>fresh 100% & organic</h3>
                    <p>fresh fruits & vegetables</p>
                    <button type="button" class="bg-white text-black special">shop now</button>
                </div>
                <div class="right1">
                    <div class="top-right d-flex align-items-center justify-content-center text-white">
                        <h3 class="fs-2 text-center">organic lifestyle products</h3>
                    </div>
                    <div class="bottom-right p-4">
                        <h3>safe food products</h3>
                        <p>discount offer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container all-cat overflow-hidden">
        <div class="head-cat d-flex align-items-center justify-content-between mt-3">
            <h2 class="heading">shop by category</h2>
            <div class="btnss">
                <button type="button" class="scroll-btn" data-target="category-items" data-dir="left"><i
                        class="fa-solid fa-arrow-left"></i></button>
                <button type="button" class="scroll-btn" data-target="category-items" data-dir="right"><i
                        class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        <div class="items d-flex align-items-center overflow-hidden mt-5" id="category-items">
            <?php
            $categoryItems = [
                ['title' => 'onions', 'img' => 'cat-onions.png'],
                ['title' => 'vegetables', 'img' => 'cat-vegetables.png'],
                ['title' => 'greens', 'img' => 'cat-greens.png'],
                ['title' => 'dairy', 'img' => 'cat-dairy.png'],
                ['title' => 'bakery', 'img' => 'cat-bakery.png'],
                ['title' => 'fruit', 'img' => 'cat-fruit.png'],
                ['title' => 'fish', 'img' => 'cat-fish.png'],
                ['title' => 'bread', 'img' => 'cat-bread.png'],
                ['title' => 'strawberry', 'img' => 'cat-strawberry.png'],
                ['title' => 'ice cream', 'img' => 'cat-icecream.png'],
            ];
            foreach ($categoryItems as $item) {
                echo '<div class="item">
                        <img src="assets/images/category/' . $item['img'] . '" alt="' . $item['title'] . '" />
                        <p>' . $item['title'] . '</p>
                      </div>';
            }
            ?>
        </div>
    </div>


    <div class="container all-cat overflow-hidden">
        <div class="head-cat d-flex align-items-center justify-content-between mt-3">
            <h2 class="heading">best value</h2>
            <div class="btnss">
                <button type="button" class="scroll-btn" data-target="value-items" data-dir="left"><i
                        class="fa-solid fa-arrow-left"></i></button>
                <button type="button" class="scroll-btn" data-target="value-items" data-dir="right"><i
                        class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        <div class="items d-flex align-items-center overflow-hidden mt-5" id="value-items">
            <?php
            $valueItems = [
                ['title' => 'onions', 'img' => 'value/1.jpg'],
                ['title' => 'vegetables', 'img' => 'value/2.png'],
                ['title' => 'greens', 'img' => 'value/3.jpg'],
                ['title' => 'dairy', 'img' => 'value/4.png'],
                ['title' => 'bakery', 'img' => 'value/5.png'],
            ];
            foreach ($valueItems as $item) {
                echo '<div class="value">
                        <img src="assets/images/' . $item['img'] . '" alt="" />
                        <div class="info">
                            <a href="#">buy more-see more</a>
                            <span>' . $item['title'] . '</span>
                        </div>
                        <a href="#" class="more">view offer</a>
                      </div>';
            }
            ?>
        </div>
    </div>


    <div class="container mt-5">
        <div class="head-cat d-flex align-items-center justify-content-between mt-3">
            <h2 class="heading">deal of the day</h2>
            <div class="btnss">
                <button type="button" class="scroll-btn" data-target="deal-items" data-dir="left"><i
                        class="fa-solid fa-arrow-left"></i></button>
                <button type="button" class="scroll-btn" data-target="deal-items" data-dir="right"><i
                        class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        <div class="cards d-flex align-items-center overflow-hidden mt-4" id="deal-items">
            <?php
            $dealItems = [
                ['id' => realId(0), 'title' => 'apple', 'img' => 'category/cat-fruit.png', 'price' => 10, 'quantity' => 30],
                ['id' => realId(1), 'title' => 'vegetables', 'img' => 'category/cat-fish.png', 'price' => 20, 'quantity' => 35],
                ['id' => realId(2), 'title' => 'greens', 'img' => 'category/cat-bread.png', 'price' => 30, 'quantity' => 40],
                ['id' => realId(3), 'title' => 'dairy', 'img' => 'category/cat-strawberry.png', 'price' => 40, 'quantity' => 45],
                ['id' => realId(4), 'title' => 'bakery', 'img' => 'category/cat-icecream.png', 'price' => 50, 'quantity' => 50],
                ['id' => realId(5), 'title' => 'onion', 'img' => 'products/1.png', 'price' => 60, 'quantity' => 55],
            ];
            foreach ($dealItems as $item) {
                echo '<div class="card p-3">
                        <div class="head-card d-flex align-items-center justify-content-between">
                            <span>hot deals</span>
                            <button type="button" class="add-cart-btn" data-id="' . $item['id'] . '" data-title="' . $item['title'] . '" data-price="' . $item['price'] . '" data-img="assets/images/' . $item['img'] . '"><i class="fa-solid fa-cart-shopping"></i></button>
                        </div>
                        <h4>' . $item['title'] . '</h4>
                        <div class="photo d-flex align-items-center justify-content-between w-100">
                            <div class="info1">
                                <span>$' . $item['price'] . ' <del>$' . ($item['price'] * 1.5) . '</del></span>
                                <div class="range"></div>
                                <p>sold: ' . $item['quantity'] . '</p>
                                <span><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></span>
                            </div>
                            <figure>
                                <img src="assets/images/' . $item['img'] . '" alt="" />
                            </figure>
                        </div>
                        <p>harry up and get 50% off</p>
                        <div class="countdown" data-countdown></div>
                      </div>';
            }
            ?>
        </div>
    </div>


    <div class="products row container" id="products-home">
        <?php

        $products = [];
        $catTitles = ['new products', 'featured products', 'best seller', 'on sale'];
        for ($i = 1; $i <= 24; $i++) {
            $catIndex = intdiv($i - 1, 6);
            $prices = [200, 150, 250, 300];
            $products[] = [
                'id' => realId($i - 1 + 6),
                'img' => 'products/' . $i . '.png',
                'title' => 'product ' . $i,
                'price' => $prices[($i - 1) % 4],
                'category' => $catTitles[$catIndex],
            ];
        }

        foreach ($catTitles as $catIndex => $catTitle) {
            echo '<div class="col-3 prod">
                    <div class="head-prod w-100 d-flex align-items-center justify-content-between">
                        <h3>' . $catTitle . '</h3>
                        <div class="btnss">
                            <button type="button" class="scroll-btn" data-target="prod-row-' . $catIndex . '" data-dir="left"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" class="scroll-btn" data-target="prod-row-' . $catIndex . '" data-dir="right"><i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                    <div class="cardss" id="prod-row-' . $catIndex . '">';

            foreach ($products as $p) {
                if ($p['category'] !== $catTitle)
                    continue;
                echo '<div class="card-prod d-flex align-items-center gap-2">
                        <figure>
                            <img src="assets/images/' . $p['img'] . '" class="card-img-top" alt="' . $p['title'] . '" />
                        </figure>
                        <div class="card-body">
                            <h3 class="card-title">' . $p['title'] . '</h3>
                            <p class="card-text">$' . $p['price'] . ' <del>$' . ($p['price'] * 2) . '</del></p>
                            <span style="color: goldenrod"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                            <div class="actions">
                                <button type="button" class="add-cart-btn" data-id="' . $p['id'] . '" data-title="' . $p['title'] . '" data-price="' . $p['price'] . '" data-img="assets/images/' . $p['img'] . '"><i class="fa-solid fa-cart-shopping"></i></button>
                                <button type="button" class="add-fav-btn" data-id="' . $p['id'] . '" data-title="' . $p['title'] . '" data-price="' . $p['price'] . '" data-img="assets/images/' . $p['img'] . '"><i class="fa-solid fa-heart"></i></button>
                            </div>
                        </div>
                      </div>';
            }
            echo '</div></div>';
        }
        ?>
    </div>

    <div id="toast-container"></div>

    <?php include 'include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/common.js"></script>
    <script src="assets/js/home-page.js"></script>
</body>

</html>