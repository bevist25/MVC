jQuery(document).ready(function($) {
    //Upload thumnbail image
    $('#thumbnail_image').change(function() {
        var formData = new FormData($(this).closest('form')[0]);
        $.ajax({
            url: 'https://72.merket.io/pt2/giangnq/admin/UploadFile',
            type: 'post',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function(result){
                $('[name=thumbnail_image_1]').parent().find('.error').remove()
                if (result) {
                    $('[name=thumbnail_image_1]').val(result)
                    $('.preview-image').html('<img src="'+result+'">')
                } else {
                    $('[name=thumbnail_image_1]').parent().append('<span class="error">Change thumbnail image failed.</span>')
                }
            },
            error: function(result) {
                console.log(result);
            }
        })
    })

    //Delete
    $('.delete').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
               url: url,
               type: 'get',
               dataType: 'html',
               beforeSend: function() {
                $('#content-admin').addClass('loading');
               },
               success: function(response){
                   if (response) {
                        $('#content-admin').removeClass('loading');
                        location.reload();
                   }
               }
        })
    })
})