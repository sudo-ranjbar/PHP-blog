<?php
include '../../include/layout/header.php';
$message = '';
$invalidInputTitle = '';
if (isset($_POST['createTitle'])) {
    if (!isset($_POST['title'])) {
        $invalidInputTitle = 'دسته بندی را وارد کنید';
    } else {
        $title = $_POST['title'];
        $createdCategory = $db->prepare("INSERT INTO categories (title) VALUES (:title)");
        $createdCategory->execute(['title' => $title]);
        $message = 'دسته بندی شما با موفقیت ثبت شد';
        // header("Location:index.php");
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <?php include '../../include/layout/sidebar.php' ?>

        <!-- Main Section -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="fs-3 fw-bold">ایجاد دسته بندی</h1>
            </div>
            <div class="text-success"><?= $message ?></div>

            <!-- Create Categories -->
            <div class="mt-4">
                <form class="row g-4" method="POST">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">عنوان دسته بندی</label>
                        <input type="text" name="title" class="form-control" />
                        <div class="form-text text-danger"><?= $invalidInputTitle ?></div>
                    </div>

                    <div class="col-12">
                        <button type="submit" name="createTitle" class="btn btn-dark">
                            ایجاد
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<?php include '../../include/layout/footer.php' ?>