<?php

require "connection.php";
function login($username, $password)
{
    /* CONNECTION */
    $conn = connection();

    /* SQL */
    $sql = "SELECT * FROM users WHERE username = '$username'";

    /* EXECUTION */
    if ($result = $conn->query($sql)) {
        //success
        // check if the username exists
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            //check if password is correct
            if (password_verify($password, $user['password'])) {
                /***** SESSION *****/
                session_start();
                
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['first_name']." ".$user['last_name'];
                header('location:products.php');
                exit;
            } else {
                echo "<div class='alert alert-danger'>Incorrect Password</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>User Not Found</div>";
        }
    } else {
        //fail
        die("Error retrieving all sections: " . $conn->error);
        // error is a generic error string holder
    }
}

if (isset($_POST['btn_log_in'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    login($username, $password);
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
    <title>Login Update</title>
</head>

<body class="bg-light">
    <div style="height:100vh;">
        <div class="row h-100 m-0">
            <div class="card w-25 mx-auto my-auto p-0">
                <div class="card-header text-primary bg-white">
                    <h1 class="card-title mb-0">Minimart Catalog</h1>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label small fw-bold">Username</label>
                            <input type="text" name="username" id="username" class="form-control" maxlength="15"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <button type="submit" name="btn_log_in" class="btn btn-primary w-100">Sign Up</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="sign-up.php">Created Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>