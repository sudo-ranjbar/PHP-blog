<?php
$categories = $db->query("SELECT * FROM categories");
$invalidInputName = '';
$invalidInputEmail = '';
$message = '';
if (isset($_POST['submit'])) {
    if (empty(trim($_POST['name']))) {
        $invalidInputName = 'فیلد نام ضروری است';
    } elseif (empty(trim($_POST['email']))) {
        $invalidInputEmail = 'فیلد ایمیل ضروری است';
    } else {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $sql = $db->prepare("INSERT INTO subscribers (name, email) VALUES (:name, :email)");
        $sql->execute(array('name' => $name, 'email' => $email));
        $message = 'عضویت شما با موفقیت انجام شد';
    }

    // there should be a validation that checks whether there is a subscriber already exists with the given values.
    // $nameCheck = ($db->prepare("SELECT name FROM subscribers WHERE name=$name")->execute(array('name' => $name)) !== null);
    // $emailCheck = ($db->prepare("SELECT email FROM subscribers WHERE email=$email")->execute(array('email' => $email)) !== null);
    // if ($nameCheck) {
    //     $nameError =  "کاربری با این نام وجود دارد!";
    // } elseif ($emailCheck) {
    //     $emailError = "کاربری با این ایمیل قبلا ثبت نام شده!";
    // } else {
    //     $sql = $db->prepare("INSERT INTO subscribers (name, email) VALUES (:name, :email)");
    //     $sql->execute(array('name' => $name, 'email' => $email));
    // }
}
?>

<div class="col-lg-4">
    <!-- Search Section -->
    <div class="card">
        <div class="card-body">
            <p class="fw-bold fs-6">جستجو در وبلاگ</p>
            <form action="search.php" method="GET">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="جستجو ..." />
                    <button class="btn btn-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="card mt-4">
        <div class="fw-bold fs-6 card-header">دسته بندی ها</div>
        <ul class="list-group list-group-flush p-0">
            <?php if ($categories->rowCount() > 0) : ?>
                <?php foreach ($categories as $category) : ?>
                    <li class="list-group-item">
                        <a class="link-body-emphasis text-decoration-none" href="index.php?category_id=<?= $category['id'] ?>"><?= $category['title'] ?></a>
                    </li>
                <?php endforeach ?>
            <?php endif ?>
        </ul>
    </div>

    <!-- Subscribe Section -->
    <div class="card mt-4">
        <div class="card-body">
            <p class="fw-bold fs-6">عضویت در خبرنامه</p>
            <div class="text-success"><?= $message ?></div>
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">نام</label>
                    <input type="text" name="name" class="form-control" />
                    <div class="form-text text-danger"><?= $invalidInputName ?></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">ایمیل</label>
                    <input type="email" name="email" class="form-control" />
                    <div class="form-text text-danger"><?= $invalidInputEmail ?></div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" name="submit" class="btn btn-secondary">
                        ارسال
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- About Section -->
    <div class="card mt-4">
        <div class="card-body">
            <p class="fw-bold fs-6">درباره ما</p>
            <p class="text-justify">
                لورم ایپسوم متن ساختگی با تولید سادگی
                نامفهوم از صنعت چاپ و با استفاده از
                طراحان گرافیک است. چاپگرها و متون بلکه
                روزنامه و مجله در ستون و سطرآنچنان که
                لازم است و برای شرایط فعلی تکنولوژی مورد
                نیاز و کاربردهای متنوع با هدف بهبود
                ابزارهای کاربردی می باشد.
            </p>
        </div>
    </div>
</div>