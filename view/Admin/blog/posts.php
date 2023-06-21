<?php $controller = new Controller\Admin\Blog\Posts();
      $posts = $controller->getPosts();
      $model = $controller->getModel();
      $url = ADMIN_URL .'/'. $controller->getUrlKey()[count($controller->getUrlKey()) - 1];
?>
<div class="admin-posts">
    <div class="header-content">
        <h1>Posts</h1>
        <a href="<?= ADMIN_URL . '/post/addnew' ?>" class="add-new btn-add">Add New</a>
    </div>
    <table class="list-table col-sm-12">
        <thead>
            <th>ID</th>
            <th colspan="2">Title</th>
            <th>Thumbnail Image</th>
            <th>Status</th>
            <th>Create At</th>
            <th>Update At</th>
            <th colspan="3">Action</th>
        </thead>
        <tbody>
        <?php if (!empty($posts)) :
         foreach($posts as $post) : ?>
            <tr>
                <td><?= $model->getID($post) ?></td>
                <td colspan="2"><?= $model->getTitle($post) ?></td>
                <td class="thumbnail-image">
                    <div class="border">
                    <?php if ($model->getThumbnailImage($post)) : ?>
                        <img src="<?= $model->getThumbnailImage($post) ?>" alt="post">
                    <?php endif; ?>
                    </div>
                </td>
                <td><?= $model->getStatus($post) ?></td>
                <td><?= $model->getCreateAt($post) ?></td>
                <td><?= $model->getUpdateAt($post) ?></td>
                <td><a href="<?= ADMIN_URL . '/post/delete?id='.$model->getID($post) ?>" class="delete">Delete</a></td>
                <td><a href="<?= ADMIN_URL . '/post/addnew?id='.$model->getID($post) ?>">Edit</a></td>
                <td><a href="<?= ROOT_URL . '/post'.'/'.$model->getUrlKey($post) ?>" target="_blank">view</a></td>
            </tr>
        <?php endforeach; else : ?>
            <tr>
                <td colspan="10" class="empty">
                    <span>No posts</span>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php $model->getPagination($url, $number = 9, $categoryId = null); ?>
</div>
