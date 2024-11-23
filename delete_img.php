<?php 
    
include "connection.php";

$id = $_POST['id'];

$sql = "SELECT * FROM gallery WHERE id = ".$id;
$rowdata = mysqli_query($conn, $sql);

if (mysqli_num_rows($rowdata) > 0) {
    $row = mysqli_fetch_assoc($rowdata);
    
    $sql = "DELETE FROM gallery WHERE id=".$id;
    unlink('images/'.$row['image']);
    mysqli_query($conn, $sql);
}


?>