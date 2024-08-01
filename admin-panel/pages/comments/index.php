<?php
include '../../include/layout/header.php';
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = $_GET['id'];
    if ($action == 'approve') {
        $query = $db->prepare("UPDATE comments SET status=1 WHERE id=:id");
        $query->execute(array('id' => $id));
    } elseif ($action == 'delete') {
        $query = $db->prepare("DELETE FROM comments WHERE id=:id");
    }
    $query->execute(array('id' => $id));
    // header("Location:index.php");
    // exit();
}
$comments = $db->query("SELECT * FROM comments ORDER BY id DESC");
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include '../../include/layout/sidebar.php' ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">کامنت ها</h1>
            </div>

            <!-- Recent Comments -->
            <div class="mt-4">
                <h4 class="text-secondary fw-bold">کامنت های اخیر</h4>
                <?php if ($comments->rowCount() > 0) : ?>
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
                                <?php foreach ($comments as $comment) : ?>
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
                                                <a href="index.php?action=approve&id=<?= $comment['id'] ?>" class="btn btn-sm btn-outline-info">در انتظار تایید</a>
                                            <?php endif ?>
                                            <a href="index.php?action=delete&id=<?= $comment['id'] ?>" class="btn btn-sm btn-outline-danger">حذف</a>
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

            <!-- Comments -->
            <!-- <div class="mt-4">
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
                            <tr>
                                <th>1</th>
                                <td>علی شیخ</td>
                                <td>
                                    لورم ایپسوم متن ساختگی با تولید
                                    سادگی نامفهوم از صنعت چاپ و با
                                    استفاده از طراحان گرافیک است.
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-dark disabled">تایید شده</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger">حذف</a>
                                </td>
                            </tr>
                            <tr>
                                <th>2</th>
                                <td>علی شیخ</td>
                                <td>
                                    لورم ایپسوم متن ساختگی با تولید
                                    سادگی نامفهوم از صنعت چاپ و با
                                    استفاده از طراحان گرافیک است.
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info">در انتظار تایید</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger">حذف</a>
                                </td>
                            </tr>
                            <tr>
                                <th>3</th>
                                <td>علی شیخ</td>
                                <td>
                                    لورم ایپسوم متن ساختگی با تولید
                                    سادگی نامفهوم از صنعت چاپ
                                </td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-dark disabled">تایید شده</a>
                                    <a href="#" class="btn btn-sm btn-outline-danger">حذف</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> -->
        </main>
    </div>
</div>
<?php include '../../include/layout/footer.php' ?>