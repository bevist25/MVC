<?php
$controller = new Controller\Frontend\Blog\Post();
$model = $controller->getModel();
$post = $controller->getPost();
?>
<div class="post">
    <div class="container">
        <h1 class="title-page"><?= $model->getTitle($post) ?></h1>
        <?php if ($model->getThumbnailImage($post)) : ?>
            <div class="thumbnail-image">
                <img src="<?= $model->getThumbnailImage($post) ?>" alt="<?= $model->getTitle($post) ?>">
            </div>
        <?php endif;
        if ($model->getContent($post)) : ?>
            <div class="content"><?= $model->getContent($post) ?></div>
        <?php endif ?>
    </div>
</div>