<?php
session_start();
include "../../include/db.php";
$invalidInputEmail = '';
$invalidInputPassword = '';
if (isset($_POST['login'])) {
    if (empty(trim($_POST['email']))) {
        $invalidInputEmail = 'ایمل خود را وارد کنید';
    }
    if (empty(trim($_POST['password']))) {
        $invalidInputPassword = 'پسورد خود را وارد کنید';
    }
    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $db->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
        $user->execute(['email' => $email, 'password' => $password]);
        if ($user->rowCount() == 1) {
            $_SESSION['email'] = $email;
            header("Location:../../index.php");
        } else {
            header("Location:login.php?error=کاربری با این اطلاعات یافت نشد ");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />

    <link rel="stylesheet" href="../../assets/css/style.css" />
</head>

<body class="auth">
    <main class="form-signin w-100 m-auto">
        <form method="POST">
            <div class="fs-2 fw-bold text-center mb-4">sudo-ranjbar</div>
            <?php if (isset($_GET['error'])) : ?>
                <div class="alert alert-danger"> <?= $_GET['error'] ?> </div>
            <?php endif ?>
            <div class="mb-3">
                <label class="form-label">ایمیل</label>
                <input type="email" name="email" class="form-control" />
                <div class="form-text text-danger"><?= $invalidInputEmail ?></div>
            </div>

            <div class="mb-3">
                <label class="form-label">رمز عبور</label>
                <input type="password" name="password" class="form-control" />
                <div class="form-text text-danger"><?= $invalidInputPassword ?></div>
            </div>
            <button class="w-100 btn btn-dark mt-4" type="submit" name="login">
                ورود
            </button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>