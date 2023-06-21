<?php
$controller = new Controller\Frontend\Blog\Category();
$category = $controller->getCategoryByUrlKey();
$modelPost = $controller->getModelPost();
?>
<div class="category">
    <div class="container">
        <h1><?= $category['title'] ?></h1>
        <div class="content"><p><?= $category['content'] ?></p></div>
        <div class="posts">
            <?php if (isset($category['posts'])) : ?>
                <ul class="list-item">
                <?php foreach ($category['posts'] as $post) : ?>
                    <li>
                        <div class="img">
                            <img src="<?= $post['thumbnail_image'] ?>" alt="post">
                        </div>
                        <div class="title-content">
                            <a href="<?= POST_URL .'/'. $post['url_key'] ?>">
                                <h4><?= $post['title'] ?></h4>
                            </a>
                        </div>
                    </li>
            <?php endforeach; ?>
                </ul>
        <?php $modelPost->getPagination(CAT_URL.'/'.$category['url_key'], 9, (int)$category['ID']);
        endif; ?>
        </div>
    </div>
</div>