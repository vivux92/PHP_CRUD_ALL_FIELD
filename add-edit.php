<?php

require_once "conn.php";

$id = $_GET['id'] ?? '';
$data = [];

if ($id) {
    $sql = "SELECT * FROM user_4 WHERE id='$id'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id            = $_POST['id'] ?? '';
    $first_name    = $_POST['first_name'] ?? '';
    $last_name     = $_POST['last_name'] ?? '';
    $email         = $_POST['email'] ?? '';
    $password      = $_POST['password'] ?? '';
    $gender        = $_POST['gender'] ?? '';
    $language      = implode(",", $_POST['language']) ?? '';
    $country       = $_POST['conutry'] ?? '';
    $date          = $_POST['date_birth'] ?? '';
    $old_img       = $_POST['old_image'] ?? '';

    $password_hash = "";
    if ($password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT) ?? '';
    }

    $file_name = $old_img;
    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        // echo "<pre>";
        // print_r($_FILES);
        // exit();
        if ($file_name) {
            unlink('./profile/' . $file_name);
        }
        $file_name = time().'-' .rand(1,9999). '-' . $_FILES['image']['name'];
        $file_tmp  = $_FILES['image']['tmp_name'];

        $upload = move_uploaded_file($file_tmp, "profile/" . $file_name);
    }
    if ($id) {
        if ($password_hash) {
            $sql = "UPDATE user_4 SET first_name='$first_name',last_name='$last_name',email='$email',password='$password_hash',gender='$gender',language='$language',file_name='$file_name',date_birth='$date',country='$country'  WHERE id='$id'";
        } else {
            $sql = "UPDATE user_4 SET first_name='$first_name',last_name='$last_name',email='$email',gender='$gender',language='$language',file_name='$file_name',date_birth='$date',country='$country' WHERE id='$id'";
        }
    } else {

        $sql = "INSERT INTO user_4 (first_name,last_name,email,password,gender,language,file_name,date_birth,country) 
        VALUES ('$first_name','$last_name','$email','$password_hash','$gender','$language','$file_name','$date','$country')";
        // echo "<pre>";
        // print_r($sql);
        // exit();
    }

    if (mysqli_query($con, $sql)) {
        // echo "new user add";
        header("Location:index.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add|Edit - User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    

    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4><?php echo (isset($id) && $id ? 'Edit' : 'Add') ?> User</h4>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="index.php" class="btn btn-outline-primary">Back To list</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" id="myform">
                            <div class="uploadIcon d-flex justify-content-center">
                                <img class="img-thumbnail imgUpload" src="<?php echo (isset($data['file_name']) && $data['file_name'] ? "./profile/" . $data['file_name'] : './profile/male-1.jpg'); ?>" alt="pic" height="200px"
                                    width="200px" style="border-radius: 50%;">
                            </div>
                            <input type="file" id="photo" style="display: none;" value="image" name="image">
                            <input type="hidden" name="id" id="id" value="<?php echo $data['id'] ?? '' ?>">
                            <input type="hidden" name="old_image" id="old_image" value="<?php echo $data['file_name'] ?? '' ?>">
                            <div class="form-group">
                                <label for="password">First name :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter First name" name="first_name" value="<?php echo $data['first_name'] ?? '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last name :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter Last name" name="last_name" value="<?php echo $data['last_name'] ?? '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address :<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="Enter Email" name="email" value="<?php echo $data['email'] ?? '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password :<span class="text-danger"><?php echo (isset($id) && $id ? '' : '*') ?></span></label>
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>
                            <div class="mt-2"><label for="gender">Gender <span class="text-danger">*</span></label></div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input gender" name="gender" value="male" <?php echo (isset($data['gender']) && $data['gender'] == 'male' ? 'checked' : 'checked') ?>>Male
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input gender" name="gender" value="female" <?php echo (isset($data['gender']) && $data['gender'] == 'female' ? 'checked' : '') ?>>Female
                                </label>
                            </div>
                            <?php
                            if (isset($data['language'])) {
                                $data['language'] = explode(',', $data['language']);
                            }
                            ?>
                            <div class="mt-2">
                                <div class="mt-2"><label for="language">Language <span class="text-danger">*</span></label></div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input language" name="language[]" value="PHP" <?php echo (isset($data['language']) && in_array('PHP', $data['language']) ? 'checked' : '') ?>>PHP
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input language" name="language[]" value="JAVA" <?php echo (isset($data['language']) && in_array('JAVA', $data['language']) ? 'checked' : '') ?>>JAVA
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input language" name="language[]" value="PYHTON" <?php echo (isset($data['language']) && in_array('PYTHON', $data['language']) ? 'checked' : '') ?>>PYHTON
                                    </label>
                                </div>
                            </div>
                            <div class="mt-2"><label for="date">Enter Your Date : <span class="text-danger">*</span></label></div>
                            <div class="form-group">
                                <input type="date" name="date_birth" class="form-control" value="<?php echo $data['date_birth'] ?? ''?>" max="<?php echo date('Y-m-d') ?>">
                            </div>
                            <select name="conutry" class="form-control">
                                <option value="">Select Counrty</option>
                                <option value="india"  <?php echo (isset($data['country']) && $data['country'] == 'india' ? 'selected' : '') ?>>india</option>
                                <option value="u.s.a"  <?php echo (isset($data['country']) && $data['country'] == 'u.s.a' ? 'selected' : '') ?>>u.s.a</option>
                                <option value="russia" <?php echo (isset($data['country']) && $data['country'] == 'russia' ? 'selected' : '') ?>>russia</option>
                            </select>
                    </div>
                    <div class="card-footer text-right">
                        <button type="reset" class="btn btn-outline-warning">Reset</button>
                        <button type="submit" class="btn btn-outline-success">Submit</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $("#myform").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true
                },
                password: {
                    required: function() {
                        if ($('#id').val()) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                date_birth: {
                    required: true
                },
                conutry: {
                    required: true
                },
            },

            submitHandler: function() {
                return true;
            }

        });
        $(".uploadIcon").click(function() {
            $("#photo").trigger('click');
        });
        $("#photo").change(function() {
            file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $(".imgUpload")
                        .attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>