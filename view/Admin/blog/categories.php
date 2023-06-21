<?php $controller = new Controller\Admin\Blog\Categories();
      $categories = $controller->getCategories();
      $model = $controller->getModel();
?>
<div class="admin-categories">
    <div class="header-content">
        <h1>Categories</h1>
        <a href="<?= ADMIN_URL . '/category/addnew' ?>" class="add-new btn-add">Add New</a>
    </div>
    <table class="list-table col-sm-12">
        <thead>
            <th>ID</th>
            <th>Title</th>
            <th>Thumbnail Image</th>
            <th>Url Key</th>
            <th>Status</th>
            <th>Create At</th>
            <th>Update At</th>
            <th colspan="3">Action</th>
        </thead>
        <tbody>
        <?php if (count($categories)) :
            foreach($categories as $category) : ?>
            <tr>
                <td><?= $model->getID($category) ?></td>
                <td><?= $model->getTitle($category) ?></td>
                <td class="thumbnail-image">
                    <div class="border">
                    <?php if ($model->getThumbnailImage($category)) : ?>
                        <img src="<?= $model->getThumbnailImage($category) ?>" alt="category">
                    <?php endif; ?>
                    </div>
                </td>
                <td><?= $model->getUrlKey($category) ?></td>
                <td><?= $model->getStatus($category) ?></td>
                <td><?= $model->getCreateAt($category) ?></td>
                <td><?= $model->getUpdateAt($category) ?></td>
                <td><a href="<?= ADMIN_URL . '/category/delete?id='.$model->getID($category) ?>" class="delete">Delete</a></td>
                <td><a href="<?= ADMIN_URL . '/category/addnew?id='.$model->getID($category) ?>">Edit</a></td>
                <td><a href="<?= ROOT_URL . '/category'.'/'.$model->getUrlKey($category) ?>" target="_blank">view</a></td>
            </tr>
        <?php endforeach; else : ?>
            <tr>
                <td colspan="10" class="empty">
                    <span>No Category</span>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
