<?php $id = $title = $content = $thumbnail_image = $url_key = '';
    $status = 1;
    if (isset($_GET['id'])) {
        $controller = new Controller\Admin\Blog\Category\Addnew();
        $category = $controller->getModel()->getCategoryById($_GET['id']);
        if ($category) {
            foreach ($category as $arr) {
                $id = $controller->getModel()->getID($arr);
                $title = $controller->getModel()->getTitle($arr);
                $status = $controller->getModel()->getStatus($arr);
                $content = $controller->getModel()->getContent($arr);
                $thumbnail_image = $controller->getModel()->getThumbnailImage($arr);
                $url_key = $controller->getModel()->getUrlKey($arr);
            }
        }
    }
?>
<div class="header">
    <h3>New Category</h3>
    <button class="btn-save">Save</button>
</div>
<form action="<?= ADMIN_URL.'/category/Save' ?>" method="post" id="category-data">
    <?php if ($id) : ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>
    <div class="admin__field status">
        <label for="status">Status</label>
        <div class="control">
            <input type="checkbox" id="status" name="status" value="1" <?php if ($status) echo 'checked' ?>>
        </div>
    </div>
    <div class="admin__field category-title require">
        <label for="category_title">Category Title</label>
        <div class="control">
            <input type="text" id="category_title" name="category_title" class="input-data" value="<?= $title ?>">
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
                    <img src="<?= $thumbnail_image ?>" alt="category">
                <?php endif; ?>
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
        var form = $('#category-data');
        form.submit(function(e){
            e.preventDefault();
        })
        $('.btn-save').click(function(e){
            //require
            $('.require').each(function() {
                $(this).find('.error').remove();
                if (!$(this).find('.input-data').val()) {
                    e.preventDefault();
                    $(this).find('.control').append('<span class="error">This field is require.</span>')
                }
            })

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
                            location.href = "<?= ADMIN_URL.'/categories' ?>"
                         }
                       }
                })
        })
    })
</script>