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

include "header.php";
?>

    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <!-- <div class="card-body">
                    <div class="mb-2">
                        <button type="button" class="btn btn-primary albumModalBtn" data-id="0" data-bs-toggle="modal" data-bs-target="#albumModal">Create Album</button>
                    </div>
                    <table class="table table-striped ajax-dataTable" id="myTable" style="width:100%">
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
                </div> -->

                <div class="card-body">
                    <div class="mb-2">
                        <button type="button" class="btn btn-primary albumModalBtn" data-id="0" data-bs-toggle="modal" data-bs-target="#albumModal">Create Album</button>
                    </div>
                    <table class="table table-striped ajax-dataTable" id="myTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th class="w-50">Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
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


<?php include "footer.php"; ?>