<?php

session_start();
require "connection.php";

$id = $_GET['id'];
// get id of the product value from the url **.php?id=
$product = getProduct($id);
// $product is an associative array

function getProduct($id)
{
    /* CONNECTION */
    $conn = connection();

    /* SQL */
    $sql = "SELECT * FROM products WHERE id = $id";

    /* EXECUTION */
    if ($result = $conn->query($sql)) {
        //success
        return $result->fetch_assoc();
    // return the all products with sections from database
    } else {
        //fail
        die("Error retrieving all sections: " . $conn->error);
        // error is a generic error string holder
    }
}
function deleteProduct($id)
{
    /* CONNECTION */
    $conn = connection();

    /* SQL */
    $sql = "DELETE FROM products WHERE id =$id";

    /* EXECUTION */
    if ($conn->query($sql)) {
        //success
        header("location: products.php");
        // go to products.php if the query is successful
    // return the delete the sections from database
    } else {
        //fail
        die("Error deleting section: " . $conn->error);
        // error is a generic error string holder
    }
}
if(isset($_POST['btn_delete'])){
    $id = $_GET['id'];
    // get id of the product value from the url **.php?id=
    deleteProduct($id);
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
    <title>Delete Product</title>
</head>

<body><?php
    include 'main-nav.php' 
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <div class="text-center mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-warning display-4"></i>
                    <h2 class="fw-light mb-3 text-danger">Delete Product</h2>
                    <p class="fw-bold mb-0">Are you sure you want to delete "<?= $product['name'] ?>"?</p>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="products.php" class="btn btn-secondary w-100">Cancel</a>
                    </div>
                    <div class="col">
                        <form action="" method="post">
                            <button type="submit" class="btn btn-outline-secondary w-100"
                                name="btn_delete">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>