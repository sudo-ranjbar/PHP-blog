<?php
include './include/layout/header.php';
if (isset($_GET['entity']) && isset($_GET['action']) && isset($_GET['id'])) {
    $entity = $_GET['entity'];
    $action = $_GET['action'];
    $id = $_GET['id'];
    if ($action == 'approve') {
        $query = $db->prepare("UPDATE comments SET status=1 WHERE id=:id");
        $query->execute(array('id' => $id));
    } elseif ($action == 'delete') {

        switch ($entity) {
            case 'post':
                $catchImg = $db->prepare("SELECT * FROM posts WHERE id=:id");
                $catchImg->execute(array('id' => $id));
                $catchImg = $catchImg->fetch();
                $catchImg = $catchImg['image'];
                unlink("../media/images/$catchImg");
                $query = $db->prepare("DELETE FROM posts WHERE id=:id");
                break;
            case 'comment':
                $query = $db->prepare("DELETE FROM comments WHERE id=:id");
                break;
            case 'category':
                $query = $db->prepare("DELETE FROM categories WHERE id=:id");
                break;
        }
        $query->execute(array('id' => $id));
        // header("Location:index.php");
        // exit();
    }
}
$recentPosts = $db->query("SELECT * FROM posts ORDER BY id DESC LIMIT 4");
$recentComments = $db->query("SELECT * FROM comments ORDER BY id DESC LIMIT 4");
$categories = $db->query("SELECT * FROM categories");
?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include './include/layout/sidebar.php' ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">داشبورد</h1>
            </div>

            <!-- Recent Posts -->
            <div class="mt-4">
                <h4 class="text-secondary fw-bold">مقالات اخیر</h4>
                <?php if ($recentPosts->rowCount() > 0) : ?>
                    <div class="table-responsive small">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>عنوان</th>
                                    <th>نویسنده</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentPosts as $post) : ?>
                                    <tr>
                                        <th><?= $post['id'] ?></th>
                                        <td><?= $post['title'] ?></td>
                                        <td><?= $post['author'] ?></td>
                                        <td>
                                            <a href="./pages/posts/edit.php?id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-dark">ویرایش</a>
                                            <a href="index.php?entity=post&action=delete&id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="col">
                        <div class="alert alert-danger">
                            مقاله ای یافت نشد ...
                        </div>
                    </div>
                <?php endif ?>
            </div>

            <!-- Recent Comments -->
            <div class="mt-4">
                <h4 class="text-secondary fw-bold">کامنت های اخیر</h4>
                <?php if ($recentComments->rowCount() > 0) : ?>
                    <div class="table-responsive small">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>نام</th>
                                    <th>متن کامنت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentComments as $comment) : ?>
                                    <tr>
                                        <th><?= $comment['id'] ?></th>
                                        <td><?= $comment['name'] ?></td>
                                        <td>
                                            <?= substr($comment['text'], 0, 100) ?>
                                        </td>
                                        <td>
                                            <?php if ($comment['status']) : ?>
                                                <a href="#" class="btn btn-sm btn-outline-dark disabled">تایید شده</a>
                                            <?php else : ?>
                                                <a href="index.php?entity=comment&action=approve&id=<?= $comment['id'] ?>" class="btn btn-sm btn-outline-info">در انتظار تایید</a>
                                            <?php endif ?>
                                            <a href="index.php?entity=comment&action=delete&id=<?= $comment['id'] ?>" class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="col">
                        <div class="alert alert-danger">
                            کامنتی یافت نشد ...
                        </div>
                    </div>
                <?php endif ?>
            </div>

            <!-- Categories -->
            <div class="mt-4">
                <h4 class="text-secondary fw-bold">دسته بندی ها</h4>
                <?php if ($categories->rowCount() > 0) : ?>
                    <div class="table-responsive small">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>عنوان</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category) : ?>
                                    <tr>
                                        <th><?= $category['id'] ?></th>
                                        <td><?= $category['title'] ?></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-dark">ویرایش</a>
                                            <a href="index.php?entity=category&action=delete&id=<?= $category['id'] ?>" class="btn btn-sm btn-outline-danger">حذف</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="col">
                        <div class="alert alert-danger">
                            دسته بندی ای وجود ندارد ...
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </main>
    </div>
</div>
<?php include './include/layout/footer.php' ?>