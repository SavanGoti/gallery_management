<?php
include "connection.php";
$id = $_REQUEST['id'];
$sql = "SELECT * FROM album WHERE id = ".$id;
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
}else{
    header('Location: http://localhost/gallery_management');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery management</title>
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="assets/img.css">
</head>
<body>
    
<div class="mt-4">
    <div class="card">
        <div class="card-body">
            <div>
                <a href="index.php" class="btn btn-primary mb-2" ><i class="fa-solid fa-arrow-left"></i> Back</a>
            </div>
            <div class="alert_msg"></div>
            <form method="post" class="was-validated gallery_form" enctype="multipart/form-data" >
                <input type="hidden" name="album_id" class="album_id" value="<?= $row['id']; ?>" >
                <div class="">
                    <label  class="main-container" for="dragandDropImage">
                        <div id="dropZone" class="drop-zone">
                            <div class="drop-zone-icons">
                                <svg class="upload-icon" viewBox="0 0 24 24" fill="#FF5A5F"><path d="M12 6l-4 4h3v4h2v-4h3m-10 6v2h12v-2h-12z"></path></svg>
                            </div>
                            <span class="drop-zone-text">Drag and drop files here or click to upload</span>
                        </div>
                    </label>
                    <input type="file" class="form-control img_input_field" id="dragandDropImage" accept=".jpg,.jpeg,.png" multiple required />
                </div>
            </form>
        </div>
    </div>
</div>


<!-- <div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div>
                    <a href="index.php" class="btn btn-primary mb-2" ><i class="fa-solid fa-arrow-left"></i> Back</a>
                </div>
                <div class="msg"></div>
                <form method="post" class="was-validated gallery_form" enctype="multipart/form-data" >
                    <input type="hidden" name="album_id" class="album_id" value="<?= $row['id']; ?>" >
                    <div class="">
                        <label for="phota">Phota</label>
                        <input type="file" class="form-control" name="file[]" id="pickUpFileAttachment" accept=".jpg,.jpeg,.png" multiple required />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

<div class=" mt-3">
    <div class="card">
        <div class="card-body">
            <div class="row allImages">
                <?php $sql2 = "SELECT * FROM gallery WHERE album_id = ".$id;
                $result2 = mysqli_query($conn, $sql2);
                if (mysqli_num_rows($result2) > 0) { ?>
                    <?php while($row2 = mysqli_fetch_assoc($result2)) { ?>
                        <div class="col-md-3 imgDiv d-flex justify-content-center">
                            <div class="card mt-2" style="width: 18rem;">
                                <img src="images/<?= $row2['image'] ?>" class="card-img-top" alt="..." style="height: 170px;width: 100%;" >
                                <div class="card-body text-center">
                                    <a href="javascript:void(0);" data-id="<?= $row2['id']; ?>" class="btn btn-danger delete_img">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<script src="assets/img.js"></script>

<script>
    
    $(document).ready(function(){

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
</script>
</body>
</html>