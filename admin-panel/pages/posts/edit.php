<?php
include '../../include/layout/header.php';
$invalidInputTitle = '';
$invalidInputAuthor = '';
$invalidInputImage = '';
$invalidInputBody = '';
$message = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $post = $db->prepare("SELECT * FROM posts WHERE id = :id");
    $post->execute(array('id' => $id));
    $post = $post->fetch();
    $categories = $db->query("SELECT * FROM categories");
}
if (isset($_POST['edit'])) {

    if (empty(trim($_POST['title']))) {
        $invalidInputTitle = 'عنوان مقاله را بنویسید';
    }
    if (empty(trim($_POST['author']))) {
        $invalidInputAuthor = 'نویسنده مقاله را بنویسید';
    }
    if (empty(trim($_POST['body']))) {
        $invalidInputBody = 'متن مقاله را بنویسید';
    }
    $title = $_POST['title'];
    $author = $_POST['author'];
    $categoryId = $_POST['categoryId'];
    $body = $_POST['body'];
    if (!empty(trim($_POST['title'])) && !empty(trim($_POST['author'])) && !empty(trim($_POST['body'])) && empty(trim($_FILES['image']['name']))) {
        $editedPost = $db->prepare("UPDATE posts SET title=:title, author=:author, category_id=:category_id, body=:body  WHERE id=:postId");
        $editedPost->execute([
            "postId" => $id,
            "title" => $title,
            "author" => $author,
            "category_id" => $categoryId,
            "body" => $body,
        ]);
        // header("Location:index.php");
    }
    if (!empty(trim($_POST['title'])) && !empty(trim($_POST['author'])) && !empty(trim($_POST['body'])) && !empty(trim($_FILES['image']['name']))) {
        $tmpName = $_FILES['image']['tmp_name'];
        $imgName = time() . "_" . $_FILES['image']['name'];
        if (move_uploaded_file($tmpName, "../../../media/images/$imgName")) {
            $catchImg = $db->prepare("SELECT * FROM posts WHERE id=:id");
            $catchImg->execute(array('id' => $id));
            $catchImg = $catchImg->fetch();
            $catchImg = $catchImg['image'];
            unlink("../../../media/images/$catchImg");
            $editedPost = $db->prepare("UPDATE posts SET title=:title, author=:author, category_id=:category_id, body=:body, image=:image  WHERE id=:postId");
            $editedPost->execute([
                "postId" => $id,
                "title" => $title,
                "author" => $author,
                "category_id" => $categoryId,
                "body" => $body,
                "image" => $imgName,
            ]);
            $message = 'مقاله شما با موفقیت ثبت شد';
            // header("Location:index.php");
        } else {
            die("upload Eror");
        }
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include '../../include/layout/sidebar.php' ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">ویرایش مقاله</h1>
            </div>
            <div class="text-success"><?= $message ?></div>

            <!-- Edit Post -->
            <div class="mt-4">
                <form class="row g-4" method="POST" enctype="multipart/form-data">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">عنوان مقاله</label>
                        <input type="text" name="title" class="form-control" value="<?= $post['title'] ?>">
                        <div class="form-text text-danger"><?= $invalidInputTitle ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">نویسنده مقاله</label>
                        <input type="text" name="author" class="form-control" value="<?= $post['author'] ?>">
                        <div class="form-text text-danger"><?= $invalidInputAuthor ?></div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">دسته بندی مقاله</label>
                        <select name="categoryId" class="form-select">
                            <?php if ($categories->rowCount() > 0) : ?>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?= $category['id'] ?>" <?= $post['category_id'] == $category['id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
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
                        <textarea name="body" class="form-control" rows="8"><?= $post['body'] ?></textarea>
                        <div class="form-text text-danger"><?= $invalidInputBody ?></div>
                    </div>


                    <div class="col-12 col-sm-6 col-md-4">
                        <img class="rounded" src="../../../media/images/<?= $post['image'] ?>" width="300" />
                    </div>

                    <div style="margin-bottom: 30px;" class="col-12">
                        <button name="edit" type="submit" class="btn btn-dark">
                            ویرایش
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<?php include '../../include/layout/footer.php' ?>