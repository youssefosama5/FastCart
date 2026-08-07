<?php
require_once __DIR__ . '/../config/session.php';
$root = '../';

if (isset($_SESSION['user_id'])) {
    header('Location: ' . $root . 'index.php');
    exit;
}

$error = $_SESSION['register_error'] ?? '';
unset($_SESSION['register_error']);
$old = $_SESSION['register_old'] ?? ['name' => '', 'email' => '', 'phone' => ''];
unset($_SESSION['register_old']);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>register - fastCart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/register.css">
</head>

<body>
    <?php include '../include/header.php'; ?>

    <div class="all-forms">
        <div class="forms active">
            <div class="register active w-100 h-100 d-flex">
                <div class="left-reg w-50 h-100">
                    <form action="../action/register.php" method="post" class="h-100">
                        <?php if ($error): ?>
                            <div class="form-alert error">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span><?php echo htmlspecialchars($error); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="input">
                            <input type="text" name="name" placeholder="name" class="form-control" required value="<?php echo htmlspecialchars($old['name']); ?>" />
                        </div>
                        <div class="input">
                            <input type="email" name="email" placeholder="email" class="form-control" required value="<?php echo htmlspecialchars($old['email']); ?>" />
                        </div>
                        <div class="input">
                            <input type="tel" name="phone" placeholder="01xxxxxxxxx" class="form-control" required pattern="01[0125][0-9]{8}" maxlength="11" title="Valid Egyptian mobile number: starts with 010, 011, 012 or 015, 11 digits total" value="<?php echo htmlspecialchars($old['phone']); ?>" />
                        </div>
                        <div class="input">
                            <input type="password" name="password" placeholder="password" class="form-control pass" required minlength="6" />
                            <button type="button" class="eye"><i class="fa-solid fa-eye-slash"></i></button>
                        </div>
                        <div class="input1 d-flex align-items-center">
                            <input type="checkbox" class="form-check-input" id="agree" name="agree" required />
                            <label for="agree" style="margin:0 .8em">i agree to the Terms & Conditions</label>
                        </div>
                        <button type="submit" class="btn1">sign up</button>
                        <p>already have account? <a href="login.php" class="btn2">sign in</a></p>
                    </form>
                </div>
                <div class="right-reg w-50 h-100 d-flex align-items-center justify-content-center flex-column text-white">
                    <h2>join freshCart</h2>
                    <p>Start shopping and making a difference</p>
                </div>
            </div>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/login-page.js"></script>
</body>

</html>