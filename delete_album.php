<?php 
    
include "connection.php";

$id = $_POST['id'];

$sql = "SELECT * FROM gallery WHERE album_id = ".$id;
$resImgData = mysqli_query($conn, $sql);


if (mysqli_num_rows($resImgData) > 0) {
    while($row = mysqli_fetch_assoc($resImgData)) {
        $sql = "DELETE FROM gallery WHERE id=".$row['id'];
        unlink('images/'.$row['image']);
        mysqli_query($conn, $sql);
    }
}
$sql2 = "DELETE FROM album WHERE id=".$id;
if(mysqli_query($conn, $sql2)){
    echo true;
}else{
    echo false;
}

?>