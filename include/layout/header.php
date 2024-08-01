<?php
include "./include/db.php";
$categories = $db->query("SELECT * FROM categories");
// $categories is a PDOStatement Object which is a queryString
// in order to obtain the list of records by that specific queryString, we must use: $categories->fetchAll()
// however, we can use this $categories in foreach statements
?>
<!DOCTYPE html>
<html dir="rtl" lang="fa">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ranjbar weblog</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />

    <link rel="stylesheet" href="./assets/css/style.css" />
</head>

<body>
    <div class="container py-3">
        <header class="d-flex flex-column flex-md-row align-items-center pb-3 mb-4 border-bottom">
            <a href="index.php" class="fs-4 fw-medium link-body-emphasis text-decoration-none">
                sudo-ranjbar.com
            </a>

            <nav class="d-inline-flex mt-2 mt-md-0 me-md-auto">
                <?php if ($categories->rowCount() > 0) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <a class="me-3 py-2 link-body-emphasis text-decoration-none <?= (isset($_GET['category_id'])) && ($category['id'] == $_GET['category_id']) ? 'fw-bold' : '' ?>" href="index.php?category_id=<?= $category['id'] ?>"><?= $category['title'] ?></a>
                    <?php endforeach ?>
                <?php endif ?>
            </nav>
        </header>