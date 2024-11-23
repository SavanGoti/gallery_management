<?php 

include "connection.php";

$album_id = $_POST['album_id'];
$total_pic = $_POST['total_pic'];

$msg = "";
for ($x = 0; $x < $total_pic; $x++) {

    if(!empty($_FILES['img_'.$x]['name'])){
        $errors     = array();
        $maxsize    = 5242880; // 5 MB
        $acceptable = array(
            'image/png',
            'image/jpg',
            'image/jpeg',
        );

        $file_size = $_FILES['img_'.$x]['size'];
        $file_type = $_FILES['img_'.$x]['type'];
        $file_tmp_name = $_FILES['img_'.$x]['tmp_name'];

        if(($file_size > $maxsize) || ($file_size == 0)) {
            $errors[] = 'File too large. File must be less than 5 megabytes.';
        }
    
        if((!in_array($file_type, $acceptable)) && (!empty($file_type))) {
            $errors[] = 'Invalid file type. Only JPG, JPEG and PNG types are accepted.';
        }
        
        if(count($errors) === 0) {
    
            $file_name = $_FILES['img_'.$x]['name'];
            $fileext = pathinfo($file_name, PATHINFO_EXTENSION);
            $filename = time().rand().'.'.$fileext;
            move_uploaded_file($file_tmp_name, 'images/'.$filename);
            
            $sql = "INSERT INTO gallery (`album_id`,`image`) VALUES ('".$album_id."','".$filename."');";
            if(mysqli_query($conn, $sql)){
                $msg = "New Images Add successfully.";
            }else{
                $msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
                die;
            }
        } else {
            foreach($errors as $error) {
                echo $error;
            }
            die();
        }
    }
}
echo $msg;
mysqli_close($conn);

?>