<?php
include "connection.php";
$id = $_REQUEST['id'];
$sql = "SELECT * FROM album WHERE id = ".$id;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $html = '<label for="name">Name</label>
    <input type="hidden" name="id" value="'.$row['id'].'" >
    <input type="text" name="name" class="form-control" value="'.$row['name'].'" required >';
}else{
    $html = '<label for="name">Name</label>
    <input type="hidden" name="id" value="" >
    <input type="text" name="name" class="form-control" required >';
}
echo $html;
?>