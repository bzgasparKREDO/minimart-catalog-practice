<?php
session_start();
    require "connection.php";

    function getAllProduct()
    {
        /* CONNECTION */
        $conn = connection();

        /* SQL */
        $sql = "SELECT products.id AS id,
                        products.name AS `name`,
                        products.description AS `description`,
                        products.price AS price,
                        sections.name AS section
         FROM products
         INNER JOIN sections
         ON products.section_id = sections.id
         ORDER BY products.id";

        /* EXECUTION */
        if ($result = $conn->query($sql)) {
            //success
            return $result;
        // return the all products with sections from database
        } else {
            //fail
            die("Error retrieving all sections: " . $conn->error);
            // error is a generic error string holder
        }
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
    <title>Products</title>
</head>

<body><?php
    include 'main-nav.php' 
    ?>
    <main class="container">
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-light">Products</h2>
            </div>
            <div class="col text-end">
                <a href="add-product.php" class="btn btn-success"><i class="fa-solid fa-plus-circle"></i>New Product</a>
            </div>
        </div>
        <table class="table table-hover align-middle border">
            <thead class="small table-success">
                <tr>
                    <th>ID</th>
                    <th style="width:250px;">NAME</th>
                    <th>DESCRIPTION</th>
                    <th>PRICE</th>
                    <th>SECTION</th>
                    <th style="width: 95px;"></th>

                </tr>
            </thead>
            <tbody>
                <?php
                $all_products = getAllProduct();
                while ($product = $all_products->fetch_assoc()) {
                ?>
                <tr>
                    <td><?=$product['id'] ?> </td>
                    <td><?=$product['name'] ?> </td>
                    <td><?=$product['description'] ?> </td>
                    <td><?=$product['price'] ?> </td>
                    <td><?=$product['section'] ?> </td>
                    <td>
                    <a href="edit-product.php?id=<?=$product['id'] ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-pencil-alt"></i>
                    </a>
                    <a href="delete-product.php?id=<?=$product['id'] ?>" class="btn btn-outline-danger btn-sm">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </main>
</body>

</html>