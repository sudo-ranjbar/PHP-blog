<?php
include "./include/layout/header.php";
if (!empty($_GET['category_id'])) {
    $catId = $_GET['category_id'];
    $posts = $db->query("SELECT * FROM posts WHERE category_id=$catId ORDER BY id DESC");
} else {
    $posts = $db->query("SELECT * FROM posts ORDER BY id DESC");
}
?>
<main>
    <?php include "include/layout/slider.php"; ?>
    <!-- Content Section -->
    <section class="mt-4">
        <div class="row">
            <!-- Posts Content -->
            <div class="col-lg-8">
                <div class="row g-3">
                    <?php if ($posts->rowCount() > 0) : ?>
                        <?php foreach ($posts as $post) : ?>
                            <div class="col-sm-6">
                                <?php
                                $categoryId = $post['category_id'];
                                $category = $db->query("SELECT * FROM categories WHERE id=$categoryId")->fetch();
                                ?>
                                <div class="card">
                                    <img src="./media/images/<?= $post['image'] ?>" class="card-img-top" alt="post-image" />
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="card-title fw-bold">
                                                <?= $post['title'] ?>
                                            </h5>
                                            <div>
                                                <span class="badge text-bg-secondary"><?= $category['title'] ?></span>
                                            </div>
                                        </div>
                                        <p class="card-text text-secondary pt-3">
                                            <?= substr($post['body'], 0, 350) ?> ...
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="single.php?post_id=<?= $post['id'] ?>" class="btn btn-sm btn-dark">مشاهده</a>

                                            <p class="fs-7 mb-0">
                                                نویسنده : <?= $post['author'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                </div>
            </div>
            <?php include "include/layout/sidebar.php"; ?>
        </div>
    </section>
</main>
<?php include "include/layout/footer.php"; ?>