<?php
include '../../include/layout/header.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $selectedCategory = $db->prepare("SELECT * FROM categories WHERE id=:id");
    $selectedCategory->execute(['id' => $id]);
    $selectedCategory = $selectedCategory->fetch();
}
$invalidInputTitle = '';
if (isset($_POST['editTitle'])) {
    if (empty($_POST['selectedTitle'])) {
        $invalidInputTitle = 'دسته بندی را وارد کنید';
    }else{
        $title = $_POST['selectedTitle'];
        $editedCategory = $db->prepare("UPDATE categories SET title=:title WHERE id=:id");
        $editedCategory->execute(['title'=>$title, 'id'=>$id]);
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
                <h1 class="fs-3 fw-bold">ویرایش دسته بندی</h1>
            </div>

            <!-- Posts -->
            <div class="mt-4">
                <form class="row g-4" method="POST">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label">عنوان دسته بندی</label>
                        <input type="text" name="selectedTitle" class="form-control" value="<?= $selectedCategory['title'] ?>" />
                        <div class="form-text text-danger"><?= $invalidInputTitle ?></div>
                    </div>

                    <div class="col-12">
                        <button type="submit" name="editTitle" class="btn btn-dark">
                            ویرایش
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<?php include '../../include/layout/footer.php' ?>