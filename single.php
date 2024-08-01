<?php
include "./include/layout/header.php";
if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];
    $post = $db->prepare("SELECT * FROM posts WHERE id = :id");
    $post->execute(array('id' => $postId));
    $post = $post->fetch();

    $comments = $db->prepare("SELECT * FROM comments WHERE post_id = :id AND status=1");
    $comments->execute(array('id' => $postId));
}
$invalidInputName = '';
$invalidInputText = '';
$message = '';
if (isset($_POST['single_submit'])) {
    if (empty($_POST['name'])) {
        $invalidInputName = 'نام خود را وارد کنید';
    } elseif (empty($_POST['text'])) {
        $invalidInputText = 'متن خود را وارد کنید';
    } else {
        $name = $_POST['name'];
        $text = $_POST['text'];
        $comment = $db->prepare("INSERT INTO comments (name, text, post_id) VALUES (:name, :text, :post_id)");
        $comment->execute(array('name' => $name, 'text' => $text, 'post_id' => $postId));

        $message = 'عضویت شما با موفقیت انجام شد';
    }
}
?>
<main>
    <!-- Content -->
    <section class="mt-4">
        <div class="row">
            <!-- Posts & Comments Content -->
            <?php if (empty($post)) : ?>
                <div class="alert alert-danger">
                    مقاله مورد نظر پیدا نشد !!!!
                </div>
            <?php else : ?>
                <div class="col-lg-8">
                    <div class="row justify-content-center">
                        <!-- Post Section -->
                        <div class="col">
                            <div class="card">
                                <img src="./media/images/<?= $post['image'] ?>" class="card-img-top" alt="post-image" />
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-bold">
                                            <?= $post['title'] ?>
                                        </h5>
                                        <?php
                                        $categoryId = $post['category_id'];
                                        $category = $db->query("SELECT * FROM categories WHERE id=$categoryId")->fetch();
                                        ?>
                                        <div>
                                            <span class="badge text-bg-secondary"><?= $category['title'] ?></span>
                                        </div>
                                    </div>
                                    <p class="card-text text-secondary text-justify pt-3">
                                        <?= $post['body'] ?>
                                    </p>
                                    <div>
                                        <p class="fs-6 mt-5 mb-0">
                                            نویسنده : <?= $post['author'] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4" />

                        <!-- Comment Section -->
                        <div class="col">
                            <!-- Comment Form -->
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold fs-5">
                                        ارسال کامنت
                                    </p>
                                    <div class="text-success"><?= $message ?></div>
                                    <form action="single.php?post_id=<?= $postId ?>" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">نام</label>
                                            <input type="text" name="name" class="form-control" />
                                            <div class="form-text text-danger"><?= $invalidInputName ?></div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">متن کامنت</label>
                                            <textarea name="text" class="form-control" rows="3"></textarea>
                                            <div class="form-text text-danger"><?= $invalidInputText ?></div>
                                        </div>
                                        <button type="submit" name="single_submit" class="btn btn-dark">
                                            ارسال
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <hr class="mt-4" />
                            <!-- Comment Content -->
                            <p class="fw-bold fs-6">تعداد کامنت : <?= $comments->rowCount() ?></p>
                            <?php if ($comments->rowCount() > 0) : ?>
                                <?php foreach ($comments as $comment) : ?>
                                    <div class="card bg-light-subtle mb-3">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="./assets/images/profile.png" width="45" height="45" alt="user-profle" />
                                                <h5 class="card-title me-2 mb-0">
                                                    <?= $comment['name'] ?>
                                                </h5>
                                            </div>
                                            <p class="card-text pt-3 pr-3">
                                                <?= $comment['text'] ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php include "include/layout/sidebar.php"; ?>
        </div>
    </section>
</main>
<?php include "include/layout/footer.php"; ?>