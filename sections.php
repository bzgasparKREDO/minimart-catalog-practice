<?php
session_start();
    require "connection.php";

    function createSection($name)
    {
        /* CONNECTION */
        $conn = connection();

        /* SQL */
        $sql = "INSERT INTO sections (`name`) VALUE ('$name')";

        /* EXECUTION */
        if ($conn->query($sql)) {
            //success
            header("refresh: 0");
        // refresh the current page after 0 seconds
        } else {
            //fail
            die("Error adding new product section: " . $conn->error);
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

    function deleteSection($section_id)
    {
        /* CONNECTION */
        $conn = connection();

        /* SQL */
        $sql = "DELETE FROM sections WHERE id =$section_id";

        /* EXECUTION */
        if ($result = $conn->query($sql)) {
            //success
            return $result;
        // return the delete the sections from database
        } else {
            //fail
            die("Error deleting section: " . $conn->error);
            // error is a generic error string holder
        }
    }
    //collect data from the form
    if (isset($_POST['btn_add'])) {
        $name = $_POST['name'];

        createSection($name);
    }
    //delete data from the database
    if(isset($_POST['btn_delete'])){
        $section_id = $_POST['btn_delete'];
        deleteSection($section_id);
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
    <title>Sections</title>
</head>

<body>
<?php
    include 'main-nav.php' 
    ?>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-3">
                <h2 class="fw-light mb-3">Sections</h2>
                <div class="mb-3">
                    <form action="" method="post">
                        <div class="row gx-2">
                            <div class="col">
                                <input type="text" name="name" class="form-control"
                                    placeholder="Add a new Section here..." max="50" required autofocus>
                            </div>
                            <div class="col-auto">
                                <button type="submit" name="btn_add" class="btn btn-info w-100 fw-bold">
                                    <i class="fa-solid fa-plus"></i>Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Display Section or Retrieve Data -->
                <table class="table table-sm align-middle text-center">
                    <thead class="table-info">
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $all_sections = gettAllSections();
                                while ($section = $all_sections->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $section['id'] ?></td>
                            <td><?= $section['name'] ?></td>
                            <td>
                                <form action="" method="post">
                                    <button type="submit" name="btn_delete" value="<?= $section['id'] ?>" class="btn btn-outline-danger border-0">
                                    <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>

</html>