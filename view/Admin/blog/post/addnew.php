<?php $title = $content = $thumbnail_image = $url_key = '';
    $categories_id = [];
    $controller = new Controller\Admin\Blog\Post\Addnew();
    $categoriesArr = $controller->getModelCategory()->getCategories();
    if (isset($_GET['id'])) {
        $posts = $controller->getModel()->getPostById((int)$_GET['id']);
        if (isset($posts)) {
            foreach ($posts as $index => $_post) {
                if ($index === 0) {
                    $title = $controller->getModel()->getTitle($_post);
                    $content = $controller->getModel()->getContent($_post);
                    $thumbnail_image = $controller->getModel()->getThumbnailImage($_post);
                    $url_key = $controller->getModel()->getUrlKey($_post);
                    $status = $controller->getModel()->getStatus($_post);
                }
                $categoriesid[] = $_post['category_id'];
            }
        }
    }
?>
<div class="header">
    <h3>New Post</h3>
    <button class="btn-save">Save</button>
</div>
<form action="<?= ROOT_URL.'/admin/post/save' ?>" method="post" id="post-data" enctype="multipart/form-data">
    <?php if (isset($_GET['id'])) { ?>
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
    <?php } ?>
    <div class="admin__field status">
        <label for="status">Status</label>
        <div class="control">
            <input type="checkbox" id="status" name="status" value="1" <?php if ($status) echo 'checked' ?>>
        </div>
    </div>
    <div class="admin__field post-title require">
        <label for="post_title">Post Title</label>
        <div class="control">
            <input type="text" id="post_title" name="post_title" class="input-data" value="<?= $title ?>">
        </div>
    </div>
    <div class="admin__field categories">
        <label for="post_title">Categories</label>
        <div class="control">
            <select name="categories" id="categories" class="multiselect" multiple>
                <?php
                    if (isset($categoriesArr)) :
                    foreach ($categoriesArr as $category) : ?>
                        <option value="<?= $category['entity_id'] ?>" <?php if (isset($categoriesid) && in_array($category['entity_id'], $categoriesid)) echo 'selected=selected' ?>><?= $category['title'] ?></option>
                <?php endforeach; endif ?>
            </select>
            <input type="hidden" val=""  name="categories_id" id="categories_id">
        </div>
    </div>
    <div class="admin__field content require">
        <label for="content">Content</label>
        <div class="control">
            <textarea name="content" id="content" cols="30" rows="5" class="input-data"><?= $content ?></textarea>
        </div>
    </div>
    <div class="admin__field thumbnail-image">
        <label for="thumbnail_image">Thumbnail Image</label>
        <div class="control">
            <input type="file" id="thumbnail_image" name="thumbnail_image" accept="image/png, image/gif, image/jpeg"/>
            <div class="preview-image">
                <?php if ($thumbnail_image) : ?>
                    <img src="<?= $thumbnail_image ?>" alt="<?= $title ?>">
                <?php endif ?>
            </div>
            <input type="hidden"  name="thumbnail_image_1" value="<?= $thumbnail_image ?>">
        </div>
    </div>
    <div class="admin__field url-key">
        <label for="url_key">Url Key</label>
        <div class="control">
            <input type="text" id="url_key" name="url_key" value="<?= $url_key ?>">
        </div>
    </div>
</form>
<script>
    jQuery(document).ready(function($) {
        var form = $('#post-data');
        form.submit(function(e){
            e.preventDefault();
        })
        $('.btn-save').click(function(e){
            //require
            $('.require').each(function() {
                if (!$(this).find('.input-data').val()) {
                    e.preventDefault();
                    $(this).find('.control').append('<span class="error">This field is require.</span>')
                }
            })

            //categories
            var selectedValues = [];
            var selectElement = document.getElementById("categories");
            for (var i = 0; i < selectElement.options.length; i++) {
                var option = selectElement.options[i];
                if (option.selected) {
                    selectedValues.push(option.value);
                }
            }
            $('[name=categories_id]').val(selectedValues.join())
            //ajax save
            var formdata = form.serialize(),
                url = form.attr('action');
                $.ajax({
                       url: url,
                       type: 'post',
                       dataType: 'html',
                       data: formdata,
                       success: function(response){
                        if (!response) {
                            location.href = "<?= ADMIN_URL.'/posts' ?>"
                         }
                       }
                })
        })
    })
</script>
