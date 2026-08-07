<?php
require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/db.php';

$cartCount = 0;
$favCount  = 0;
$isLoggedIn = isset($_SESSION['user_id']);
if ($isLoggedIn) {
    $uid = (int) $_SESSION['user_id'];

    $cartStmt = $conn->prepare('SELECT COUNT(*) AS c FROM cart WHERE user_id = ?');
    $cartStmt->bind_param('i', $uid);
    $cartStmt->execute();
    $cartCount = (int) $cartStmt->get_result()->fetch_assoc()['c'];

    $favStmt = $conn->prepare('SELECT COUNT(*) AS c FROM favorites WHERE user_id = ?');
    $favStmt->bind_param('i', $uid);
    $favStmt->execute();
    $favCount = (int) $favStmt->get_result()->fetch_assoc()['c'];
}

$root = isset($root) ? $root : '';
?>
<script>window.APP_ROOT = "<?php echo $root; ?>";</script>
<div class="header">
    <header class="d-flex align-items-center justify-content-between">
        <div class="logo d-flex align-items-center">
            <p>fast<span>cart</span></p>
            <input type="search" placeholder="search for products" />
        </div>
        <div class="btns d-flex align-items-center justify-content-between gap-3">
            <?php if ($isLoggedIn): ?>
                <div class="user-box d-flex align-items-center gap-2">
                    <span class="user-name-label" title="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                        <i class="fa-solid fa-circle-user"></i>
                        <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                    </span>
                    <a href="<?php echo $root; ?>action/logout.php" class="logout-link" title="Logout">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </div>
            <?php else: ?>
                <a href="<?php echo $root; ?>pages/login.php" title="Login"><i class="fa-solid fa-user"></i></a>
            <?php endif; ?>
            <a href="<?php echo $root; ?>pages/cart.php"><i class="fa-solid fa-cart-shopping"></i>
                <span class="num"><?php echo $cartCount; ?></span></a>
            <a href="<?php echo $root; ?>pages/fav.php"><i class="fa-solid fa-heart"></i>
                <span class="num"><?php echo $favCount; ?></span></a>
        </div>
    </header>
    <div class="nav">
        <nav class="d-flex align-items-center justify-content-between m-auto">
            <ul class="d-flex align-items-center gap-5 list-unstyled">
                <li><a href="#">all Categories </a><span><i class="fa-solid fa-bars-staggered"></i></span></li>
                <li><a href="<?php echo $root; ?>index.php">Home</a></li>
                <li><a href="<?php echo $root; ?>pages/shop.php">shop</a></li>
                <li><a href="#">blog <i class="fa-solid fa-caret-down"></i></a>
                    <ul>
                        <li><a href="#">blog</a></li>
                        <li><a href="#">blog details</a></li>
                        <li><a href="#">blog sidebar</a></li>
                    </ul>
                </li>
                <li><a href="#">products <i class="fa-solid fa-caret-down"></i></a>
                    <ul>
                        <li><a href="#products-home">top rated</a></li>
                        <li><a href="#products-home">best selling</a></li>
                        <li><a href="#products-home">new arrivals</a></li>
                        <li><a href="#products-home">featured</a></li>
                        <li><a href="#products-home">on sale</a></li>
                    </ul>
                </li>
                <li><a href="#">pages <i class="fa-solid fa-caret-down"></i></a>
                    <ul>
                        <li><a href="<?php echo $root; ?>pages/about.php">about us</a></li>
                        <li><a href="<?php echo $root; ?>pages/contact.php">contact</a></li>
                        <li><a href="<?php echo $root; ?>pages/cart.php">cart</a></li>
                        <li><a href="<?php echo $root; ?>pages/checkout.php">checkout</a></li>
                    </ul>
                </li>
            </ul>
            <a href="#" class="deal">hot deals <i class="fa-solid fa-fire"></i></a>
        </nav>
    </div>
</div>