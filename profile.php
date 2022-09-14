<?php
session_start();
require "connection.php";
$user = getUser();

function getUser()
{
    /* CONNECTION */
    $conn = connection();
    /* getting user id from session */
    $id = $_SESSION['id'];
    /* SQL */
    $sql = "SELECT * FROM users WHERE id=$id";

    /* EXECUTION */
    if ($result = $conn->query($sql)) {
        //success
        return $result->fetch_assoc();
    // return the user data from database
    } else {
        //fail
        die("Error retrieving your data: " . $conn->error);
        // error is a generic error string holder
    }
}
function updatePhoto($id,$photo_name,$photo_tmp){
    /* CONNECTION */
    $conn = connection();

    /* SQL */
    // $photo_name = mysqli_real_escape_string($photo_name);
    $sql = "UPDATE users SET photo='$photo_name' WHERE id =$id";

    /* EXECUTION */
    if ($result = $conn->query($sql)) {
        //success

        // folder path where images will be stored
        $destination = "assets/images/$photo_name";
        // moving the photo to the path
        move_uploaded_file($photo_tmp,$destination);
        // refresh page
        header("refresh:0");
    } else {
        //fail
        die("Error retrieving your data: " . $conn->error);
        // error is a generic error string holder
    }
}

if(isset($_POST['btn_upload_photo'])){
    $id = $_SESSION['id'];
    $photo_name = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    updatePhoto($id,$photo_name,$photo_tmp);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Profile</title>
</head>

<body>
<?php
    include 'main-nav.php' 
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <?php 
                    if($user['photo']){
                        ?>
                        <img src="assets/images/<?= $user['photo'] ?>" alt="<?= $user['photo'] ?>" class="profile-photo d-flex m-auto">
                <?php 
                    }else{
                        ?>
                        <i class="fa-regular fa-user d-block text-center profile-icon"></i>
                <?php 
                    }
                ?>
                <div class="mt-2 mb-3 text-center">
                    <p class="h4 mb-0">
                        <?= $user['username'] ?>
                    </p>
                    <p class="h4 mb-0">
                        <?= $user['first_name'] . " " . $user['last_name'] ?>
                    </p>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-2">
                        <input type="file" name="photo" class="form-control">
                        <button type="submit" class="btn btn-outline-secondary" name="btn_upload_photo">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>