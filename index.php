<?php
require_once "conn.php";

$sql    = "SELECT * FROM user_4";
$result = mysqli_query($con,$sql);
$data   = [];

if(mysqli_num_rows($result) > 0){
    $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Listing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>User Listing</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="add-edit.php" class="btn btn-outline-info">Add User</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Language</th>
                                    <th>Date birth</th>
                                    <th>country</th>
                                    <th>Profile Photo</th>
                                    <th colspan="2">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($data as $key => $value){
                                    ?>
                                    <tr>
                                        <td><?php echo $value['id'] ?? ''?></td>
                                        <td><?php echo $value['first_name'] ?? ''?></td>
                                        <td><?php echo $value['last_name'] ?? ''?></td>
                                        <td><?php echo $value['email'] ?? ''?></td>
                                        <td><?php echo $value['gender'] ?? ''?></td>
                                        <td><?php echo $value['language'] ?? ''?></td>
                                        <td><?php echo $value['date_birth'] ?? ''?></td>
                                        <td><?php echo $value['country'] ?? ''?></td>
                                        <td><img width="60px" height="50px" src="profile/<?php echo $value['file_name'] ?? ''?>"></td>
                                        <td><a href="add-edit.php?id=<?php echo $value['id']?>" class="btn btn-outline-success">Edit</a></td>
                                        <td><a href="delete.php?id=<?php echo $value['id']?>" class="btn btn-outline-danger">Delete</a></td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>