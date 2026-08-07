<?php
require_once __DIR__ . '/../config/session.php';
$root = '../';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>contact us - fastCart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">
    <link rel="stylesheet" href="../assets/css/contact.css">
</head>

<body>
    <?php include '../include/header.php'; ?>

    <div class="contact">
        <div class="contact-head">
            <h1>get in <span style="color:var(--green)">touch</span></h1>
            <p>got a question, feedback or just want to say hi? we'd love to hear from you.</p>
        </div>

        <div class="contact-wrap">
            <div class="contact-info">
                <div class="info-card">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>
                        <h4>our location</h4>
                        <p>cairo, egypt</p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <h4>call us</h4>
                        <p>01555555555</p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <h4>email us</h4>
                        <p>Tabteam@gmail.com</p>
                    </div>
                </div>
                <div class="info-card">
                    <i class="fa-solid fa-clock"></i>
                    <div>
                        <h4>working hours</h4>
                        <p>sat - thu: 9am - 10pm</p>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h3>send us a message</h3>
                <form id="contact-form">
                    <div class="row-inputs">
                        <div class="input">
                            <label for="c-name">name</label>
                            <input type="text" id="c-name" class="form-control" placeholder="your name" required />
                        </div>
                        <div class="input">
                            <label for="c-email">email</label>
                            <input type="email" id="c-email" class="form-control" placeholder="your email" required />
                        </div>
                    </div>
                    <div class="input full">
                        <label for="c-subject">subject</label>
                        <input type="text" id="c-subject" class="form-control" placeholder="subject" required />
                    </div>
                    <div class="input full">
                        <label for="c-message">message</label>
                        <textarea id="c-message" class="form-control" placeholder="write your message here..." required></textarea>
                    </div>
                    <button type="submit" class="btn1">send message</button>
                </form>
            </div>
        </div>
    </div>

    <div id="toast-container"></div>

    <?php include '../include/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/common.js"></script>
    <script src="../assets/js/contact-page.js"></script>
</body>

</html>
