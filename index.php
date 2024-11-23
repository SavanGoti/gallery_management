<?php 
include "connection.php";

if (isset($_POST["submit"])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    if(!empty($id)){
        $sql = "UPDATE album SET name='".$name."' WHERE id=".$id;
    }else{
        $sql = "INSERT INTO album (name) VALUES ('".$name."')";
    }
    if(mysqli_query($conn, $sql)){
        header('Location: http://localhost/gallery_management');
    }
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
    <link rel="stylesheet" href="assets/dataTables.dataTables.min.css">

</head>
<body>
    
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        <button type="button" class="btn btn-primary albumModalBtn" data-id="0" data-bs-toggle="modal" data-bs-target="#albumModal">Create Album</button>
                    </div>
                    <table class="table table-striped" id="myTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th class="w-50">Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $limit = 10;
                                $page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
                                $startAt = $limit * ($page - 1);

                                $query = "SELECT COUNT(*) as total FROM album";
                                $r = mysqli_fetch_assoc(mysqli_query($conn, $query));
                                $totalPages = ceil($r['total'] / $limit);

                                $sql = "SELECT * FROM album LIMIT ".$startAt.",". $limit;
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                        <tr>
                                            <td><?= $row['id']; ?></td>
                                            <td><?= $row['name']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm albumModalBtn" data-id="<?= $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#albumModal"><i class="fa fa-edit"></i></button>
                                                <a href="gallery.php?id=<?= $row['id']; ?>" class="btn btn-info btn-sm"><i class="fa-solid fa-image"></i></a>
                                                <a href="javascript:void(0);" data-id="<?= $row['id']; ?>" class="btn btn-danger delete_album btn-sm"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                        </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item <?= ($page == 1)?'disabled':''; ?>">
                                <a class="page-link" href="<?= ($page > 1)?'index.php?page='.($page-1):''; ?>" >Previous</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++) { 
                                $active = '';
                                if($i == $page){
                                    $active = 'active';
                                }
                                ?>
                                <li class="page-item <?= $active; ?> "><a class="page-link" href="index.php?page=<?= $i; ?>"><?= $i; ?></a></li>
                            <?php } ?>
                            <li class="page-item <?= ($page == $totalPages)?'disabled':''; ?>">
                                <a class="page-link" href="<?= ($page < $totalPages)?'index.php?page='.($page+1):''; ?>">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="albumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="albumFormLabel">Album Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" class="was-validated" >
                    <div class="modal-body">
                        <div class="albumFormData">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" value="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dataTables.min.js"></script>

    <script>
        $(document).ready(function(){
            
            // $('#myTable').DataTable();

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
        });
    </script>
</body>
</html>