<?php
include_once "../config/DBUntil.php";
$db = new DBUntil();
$errors = [];


if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = '';
}
if ($id) {
    $result = $db->select("SELECT * FROM category WHERE id = $id");
    if ($result && count($result) > 0) {
        $category = $result[0];
    } else {
        echo "category not found";
        exit;
    }
} else {
    echo "category ID is missing";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name'])) {
        $errors['name'] = "Name is required";
    } else {
        $name = $_POST['name'];
    }

    if (count($errors) == 0) {
        $updated = $db->update("category", [
            "name" => $name
        ], "id = $id");

        if ($updated) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Update success',
                text: 'Update product successfully',
            });
            </script>";
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Update failed',
                text: 'Failed to update product.',
            });
            </script>";
        }
    }
}
?>

<div class="container">
    <form action="index.php?view=update-category&id=<?= $id ?>" method="post">
        <h2 class="mt-3">Update category</h2>
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" value="<?= isset($category['name']) ? $category['name'] : '' ?>" name="name">
            <?php if (isset($errors['name'])) {
                echo "<p class='text-danger'>" . $errors['name'] . "</p>";
            } ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>