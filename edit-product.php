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
function gettAllSections()
{
    /* CONNECTION */
    $conn = connection();

    /* SQL */
    $sql = "SELECT * FROM sections";

    /* EXECUTION */
    if ($result = $conn->query($sql)) {
        //success
        return $result;
    // return the all sections from database
    } else {
        //fail
        die("Error retrieving all sections: " . $conn->error);
        // error is a generic error string holder
    }
}
function updateProduct($id,$name,$description,$price,$section_id)
{
    /* CONNECTION */
    $conn = connection();

    /* SQL */
    $sql = "UPDATE `products` SET `name`='$name',`description`='$description',`price`='$price',`section_id`=$section_id
    WHERE id=$id";

    /* EXECUTION */
    if ($conn->query($sql)) {
        //success
        header("location: products.php");
        // go to products.php if the query is successful
        exit;
        // same as die()
    } else {
        //fail
        die("Error inserting the product: " . $conn->error);
        // error is a generic error string holder
    }
}
if (isset($_POST['btn_update'])) {
    $id = $_GET['id'];
    // get id of the product value from the url **.php?id=
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $section_id = $_POST['section_id'];
    updateProduct($id,$name,$description,$price,$section_id);
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
    <title>Edit Product</title>
</head>

<body><?php
    include 'main-nav.php' 
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <h2 class="fw-light mb-3">Edit Product</h2>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control" 
                        value="<?= $product['name'] ?>" max="50" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label small fw-bold">Description</label>
                        <textarea name="description" id="description" rows="5" class="form-control" required><?= $product['description'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label small fw-bold">Price</label>
                        <div class="input-group">
                            <div class="input-group-text">$</div>
                            <input type="number" name="price" id="price" class="form-control" 
                            value="<?= $product['price'] ?>" step="any" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="section-id" class="form-label small fw-bold">Section</label>
                        <select name="section_id" id="section-id" class="form-select" required>
                            <option value="" hidden>Select Section</option>
                                <?php
                                $all_sections = gettAllSections();
                                while ($section = $all_sections->fetch_assoc()) {
                                    if($section['id'] == $product['section_id']){

                                        echo "<option value='".$section['id']."' selected>".$section['name']."</option>";
                                    }else{
                                    echo "<option value='".$section['id']."'>".$section['name']."</option>";
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <a href="products.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" name="btn_update" class="btn btn-secondary fw-bold">
                        <i class="fa-solid fa-check"></i> Save changes</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>