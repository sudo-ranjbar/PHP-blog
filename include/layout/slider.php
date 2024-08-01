<?php
$postSlider = $db->query("SELECT * FROM post_slider");
?>
<!-- Slider Section -->
<section>
    <div id="carousel" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#carousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner rounded">
            <?php if ($postSlider->rowCount() > 0) : ?>
                <?php foreach ($postSlider as $ps) : ?>
                    <?php
                    $postId = $ps['post_id'];
                    $post = $db->query("SELECT * FROM posts WHERE id=$postId")->fetch();
                    ?>
                    <div class="carousel-item overlay carousel-height <?= ($ps['active']) ? 'active' : '' ?>">
                        <img src="./media/images/<?= $post['image'] ?>" class="d-block w-100" alt="post-image" />
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= $post['title'] ?></h5>
                            <p><?= substr($post['body'], 0, 150) ?> ...</p>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>