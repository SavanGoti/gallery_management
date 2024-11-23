<?php 

include "connection.php";

$album_id = $_POST['album_id'];

$msg = [];

if(!empty($_FILES['img']['name'])){
    $errors     = array();
    $maxsize    = 5242880; // 5 MB
    $acceptable = array(
        'image/png',
        'image/jpg',
        'image/jpeg',
    );

    $file_size = $_FILES['img']['size'];
    $file_type = $_FILES['img']['type'];
    $file_tmp_name = $_FILES['img']['tmp_name'];
    $file_name = $_FILES['img']['name'];

    if(($file_size > $maxsize) || ($file_size == 0)) {
        $errors[] = $file_name.' File too large. File must be less than 5 MB.';
    }

    if((!in_array($file_type, $acceptable)) && (!empty($file_type))) {
        $errors[] = $file_name.' Invalid file type. Only JPG, JPEG and PNG types are accepted.';
    }
    
    if(count($errors) === 0) {

        $fileext = pathinfo($file_name, PATHINFO_EXTENSION);
        $filename = time().rand().'.'.$fileext;
        move_uploaded_file($file_tmp_name, 'images/'.$filename);
        
        $sql = "INSERT INTO gallery (`album_id`,`image`) VALUES ('".$album_id."','".$filename."');";
        if(mysqli_query($conn, $sql)){
            $msg['img_name'] = $filename;
            $msg['msg'] = "New Images Add successfully.";
            $msg['status'] = 100;
        }else{
            $msg['img_name'] = '';
            $msg['msg'] = "Error: " . $sql . "<br>" . mysqli_error($conn);
            $msg['status'] = 200;
        }
    } else {
        $err_msg = "";
        foreach($errors as $error) {
            $err_msg .= $error;
        }
        $msg['img_name'] = '';
        $msg['msg'] = $err_msg;
        $msg['status'] = 200;
    }
}
echo json_encode($msg);

?>