<?php
require_once __DIR__ . '/../config/session.php';
$root = '../';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . $root . 'index.php');
    exit;
}

$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
$old = $_SESSION['login_old'] ?? ['email' => ''];
unset($_SESSION['login_old']);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>login - fastCart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>

<body>
    <?php include '../include/header.php'; ?>

    <div class="all-forms">
        <div class="forms">
            <div class="login active d-flex align-items-center justify-content-evenly w-100 h-100">
                <div class="left-form w-50 h-100 d-flex flex-column justify-content-center align-items-center text-white">
                    <h1>welcome back</h1>
                    <p>Login to continue shopping with fresh<span>Cart</span></p>
                </div>
                <div class="right-form w-50 h-100">
                    <form action="../action/login.php" method="post">
                        <?php if ($error): ?>
                            <div class="form-alert error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span><?php echo htmlspecialchars($error); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="input">
                            <input type="email" name="email" placeholder="email" class="form-control" required value="<?php echo htmlspecialchars($old['email']); ?>" />
                        </div>
                        <div class="input">
                            <input type="password" name="password" placeholder="password" class="form-control pass" required />
                            <button type="button" class="eye"><i class="fa-solid fa-eye-slash"></i></button>
                        </div>
                        <button type="submit" class="btn1">login</button>
                        <p>don't have account? <a href="register.php" class="btn2">join freshCart</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/login-page.js"></script>
</body>

</html>