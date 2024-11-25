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

include "header.php";
?>

<link rel="stylesheet" href="assets/img.css">

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

<?php include "footer.php"; ?>
