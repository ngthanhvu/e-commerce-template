<?php
include_once "../config/DBUntil.php";
$db = new DBUntil();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && empty($_POST['name'])) {
        $errors['name'] = "Name is required";
    } else {
        $name = $_POST['name'];
    }


    if (count($errors) == 0) {
        global $db;
        $product = $db->insert("category", [
            "name" => $name
        ]);
        if ($product) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Add success',
                text: 'Add product successfully',
            });
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Add failed',
                text: 'Failed to add product.',
            });
            </script>";
        }
    }
}

?>

<div class="container">
    <form action="index.php?view=add-category" method="post">
        <h2 class="mt-3">Add category</h2>
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            <?php if (isset($errors['name'])) {
                echo "<p class='text-danger'>" . $errors['name'] . "</p>";
            } ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>