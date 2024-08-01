<?php
include '../../include/layout/header.php';
$categories = $db->query("SELECT * FROM categories");
$invalidInputTitle = '';
$invalidInputAuthor = '';
$invalidInputImage = '';
$invalidInputBody = '';
$InputTitle = '';
$InputAuthor = '';
$InputCategory = 0;
$InputBody = '';
// $InputImage = '';
$message = '';
if (isset($_POST['create'])) {

    if (empty(trim($_POST['title']))) {
        $invalidInputTitle = 'عنوان مقاله را بنویسید';
    }
    if (empty(trim($_POST['author']))) {
        $invalidInputAuthor = 'نویسنده مقاله را بنویسید';
    }
    if (empty(trim($_FILES['image']['name']))) {
        $invalidInputImage = 'عکسی برای مقاله انتخاب کنید';
    }
    if (empty(trim($_POST['body']))) {
        $invalidInputBody = 'متن مقاله را بنویسید';
    }
    if (!empty(trim($_POST['title'])) && !empty(trim($_POST['author'])) && !empty(trim($_FILES['image']['name'])) && !empty(trim($_POST['body']))) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $categoryId = $_POST['categoryId'];
        $body = $_POST['body'];

        $tmpName = $_FILES['image']['tmp_name'];
        $imgName = time() . "_" . $_FILES['image']['name'];
        if (move_uploaded_file($tmpName, "../../../media/images/$imgName")) {
            $newPost = $db->prepare("INSERT INTO posts (title, author, category_id, body, image) VALUES (:title, :author, :category_id, :body, :image)");
            $newPost->execute([
                "title" => $title,
                "author" => $author,
                "category_id" => $categoryId,
                "body" => $body,
                "image" => $imgName,
            ]);
            $message = 'مقاله شما با موفقیت ثبت شد';
            // header("Location:create.php");
        } else {
            echo "upload Eror";
        }
    }
    $InputTitle = $_POST['title'];
    $InputAuthor = $_POST['author'];
    $InputCategory = $_POST['categoryId'];
    $InputBody = $_POST['body'];
    // $InputImage = '';
}
?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include '../../include/layout/sidebar.php' ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">ایجاد مقاله</h1>
            </div>
            <div class="text-success"><?= $message ?></div>

            <!-- Create Posts -->
            <div class="mt-4">
                <form class="row g-4" action="./create.php" method="POST" enctype="multipart/form-data">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">عنوان مقاله</label>
                        <input type="text" name="title" class="form-control" value=<?= $InputTitle ?>>
                        <div class="form-text text-danger"><?= $invalidInputTitle ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">نویسنده مقاله</label>
                        <input type="text" name="author" class="form-control" value=<?= $InputAuthor ?>>
                        <div class="form-text text-danger"><?= $invalidInputAuthor ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">دسته بندی مقاله</label>
                        <select name="categoryId" class="form-select">
                            <?php if ($categories->rowCount() > 0) : ?>
                                <?php foreach ($categories as $category) : ?>
                                    <option value=<?= $category['id'] ?> <?= $InputCategory == $category['id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
                                <?php endforeach ?>
                            <?php endif ?>
                        </select>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label for="formFile" class="form-label">تصویر مقاله</label>
                        <input name="image" class="form-control" type="file" />
                        <div class="form-text text-danger"><?= $invalidInputImage ?></div>
                    </div>

                    <div class="col-12">
                        <label for="formFile" class="form-label">متن مقاله</label>
                        <textarea name="body" class="form-control" rows="6"><?= $InputBody ?></textarea>
                        <div class="form-text text-danger"><?= $invalidInputBody ?></div>
                    </div>

                    <div style="margin-bottom: 30px;" class="col-12">
                        <button name="create" type="submit" class="btn btn-dark">
                            ایجاد
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<?php include '../../include/layout/footer.php' ?>