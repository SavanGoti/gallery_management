$(document).ready(function(){

    $(".albumModalBtn").click(function(){
        var id = $(this).data('id');
        $.ajax({
            url: "albumFormData.php",
            type: "post",
            data: {
                id:id
            },
            dataType: "text",
            success: function(response){
                $(".albumFormData").html(response);
            }
        });
    });
    
    $('.delete_album').click(function(){
        var el = $(this);
        var id = $(this).data('id');
        
        $.ajax({
            url: "delete_album.php",
            type: "post",
            data: {
                id:id
            },
            dataType: "text",
            success: function(response){
                el.closest('tr').remove();
            }
        });
    });

    $("#dragandDropImage").change(function(){
        var input = $('#dragandDropImage')[0];
        var formData = new FormData();
        var album_id = $('.album_id').val();
        formData.append('album_id',album_id);

        
        var total_pic = 1;
        $.each($('#dragandDropImage')[0].files, function(i, file) {
            formData.append('img', file);
            
            $.ajax({
                url: "gallery_save_2.php",
                type: "post",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(obj) {
                    
                    if(obj.status == 100){
                        var html = `<div class="col-md-3 imgDiv d-flex justify-content-center">
                                    <div class="card mt-2" style="width: 18rem;">
                                        <img src="images/${obj.img_name}" class="card-img-top" alt="..." style="height: 170px;width: 100%;" >
                                        <div class="card-body text-center">
                                            <a href="javascript:void(0);" data-id="0" class="btn btn-danger delete_img">Delete</a>
                                        </div>
                                    </div>
                                </div>`;
                        $('.allImages').append(html);
                        
                        $('.alert_msg').append(`<div class="message_${i} bg-success mb-2 p-2 text-white">${obj.msg}</div>`);
                    }else{
                        $('.alert_msg').append(`<div class="message_${i} bg-danger mb-2 p-2 text-white">${obj.msg}</div>`);
                    }
                    setTimeout(function(){
                        $('.message_'+i).remove();
                    }, 7000);
                }
            });
        });
    });


    $("#pickUpFileAttachment").change(function(){
        var formData = new FormData();
        var album_id = $('.album_id').val();
        formData.append('album_id',album_id);
        
        var total_pic = 0;
        $.each($('#pickUpFileAttachment')[0].files, function(i, file) {
            formData.append('img_'+i, file);
            total_pic++;
        });
        formData.append('total_pic',total_pic);

        $.ajax({
            url: "gallery_save.php",
            type: "post",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(msg) {
                $('.msg').html(msg);
                $('.msg').addClass('bg-info mb-2 p-2 text-white');
                setTimeout(function(){
                    window.location.href="gallery.php?id="+album_id;
                }, 3000)
            }
        });
    });

    $(document).delegate('.delete_img', 'click', function(){
        var el = $(this);
        var id = $(this).data('id');
        
        $.ajax({
            url: "delete_img.php",
            type: "post",
            data: {
                id:id
            },
            dataType: "text",
            success: function(response){
                el.closest('.imgDiv').remove();
            }
        });
    });
});