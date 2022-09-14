<?php
session_start();
require "connection.php";

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
function createProduct($name,$description,$price,$section_id){
    
    /* CONNECTION */
    $conn = connection();

    /* SQL */
    $sql = "INSERT INTO `products` (`name`,`description`,`price`,`section_id`)VALUES('$name','$description','$price','$section_id')";

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

    //collect data from the form
    if (isset($_POST['btn_add'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $section_id = $_POST['section_id'];
        createProduct($name,$description,$price,$section_id);
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
    <title>New Product</title>
</head>

<body>
<?php
    include 'main-nav.php' 
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <h2 class="fw-light mb-3">New Product</h2>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label small fw-bold">Name</label>
                        <input type="text" name="name" id="name" class="form-control" max="50" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label small fw-bold">Description</label>
                        <textarea name="description" id="description" rows="5" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label small fw-bold">Price</label>
                        <div class="input-group">
                            <div class="input-group-text">$</div>
                            <input type="number" name="price" id="price" class="form-control" step="any" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="section-id" class="form-label small fw-bold">Section</label>
                        <select name="section_id" id="section-id" class="form-select" required>
                            <option value="" hidden>Select Section</option>
                                <?php
                                $all_sections = gettAllSections();
                                while ($section = $all_sections->fetch_assoc()) {
                                    echo "<option value='".$section['id']."'>".$section['name']."</option>";
                                }
                                ?>
                        </select>
                    </div>
                    <a href="products.php" class="btn btn-outline-success">Cancel</a>
                    <button type="submit" name="btn_add" class="btn btn-success fw-bold px-5">Add</button>
                </form>
            </div>
        </div>
    </main>
</body>

</html>