<?php
include "connection.php";
$sql = "SELECT * FROM album";
$res = mysqli_query($conn, $sql) or die("Error: ".mysqli_error($conn));

$dataArray = array();
while( $row = mysqli_fetch_array($res) ) {

    $dataArray2 = [];
    $dataArray2['id'] = $row["id"];
    $dataArray2['name'] = $row["name"];
    
    $dataArray2['action'] = '<button type="button" class="btn btn-primary btn-sm albumModalBtn" data-id="'. $row['id'].'" data-bs-toggle="modal" data-bs-target="#albumModal"><i class="fa fa-edit"></i></button>
        <a href="gallery.php?id='. $row['id'].'" class="btn btn-info btn-sm"><i class="fa-solid fa-image"></i></a>
        <a href="javascript:void(0);" data-id="'. $row['id'].'" class="btn btn-danger delete_album btn-sm"><i class="fa-solid fa-trash"></i></a>';

    $dataArray[] = $dataArray2;

}

echo json_encode($dataArray);

?>