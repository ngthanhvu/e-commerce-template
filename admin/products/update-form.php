<?php
include_once "../config/DBUntil.php";
$db = new DBUntil();
$errors = [];

$categories = $db->select("SELECT * FROM category");

if (isset($_GET['id'])) {
     $id = $_GET['id'];
} else {
     $id = '';
}
if ($id) {
    $result = $db->select("SELECT * FROM product WHERE id = $id");
    if ($result && count($result) > 0) {
        $product = $result[0];
    } else {
        echo "Product not found";
        exit;
    }
} else {
    echo "Product ID is missing";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name'])) {
        $errors['name'] = "Name is required";
    } else {
        $name = $_POST['name'];
    }

    if (empty($_POST['price'])) {
        $errors['price'] = "Price is required";
    } else {
        $price = $_POST['price'];
    }

    if (empty($_POST['image'])) {
        $errors['image'] = "Image is required";
    } else {
        $image = $_POST['image'];
    }

    if (empty($_POST['quantity'])) {
        $errors['quantity'] = "Quantity is required";
    } else {
        $quantity = $_POST['quantity'];
    }

    if (empty($_POST['description'])) {
        $errors['description'] = "Description is required";
    } else {
        $description = $_POST['description'];
    }

    if (empty($_POST['category_id'])) {
        $errors['category_id'] = "Category is required";
    } else {
        $category_id = $_POST['category_id'];
    }

    if (count($errors) == 0) {
        $updated = $db->update("product", [
            "name" => $name,
            "image" => $image,
            "price" => $price,
            "quantity" => $quantity,
            "description" => $description,
            "category_id" => $category_id
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
    <form action="index.php?view=update-product&id=<?= $id ?>" method="post">
        <h2 class="mt-3">Update product</h2>
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" value="<?= isset($product['name']) ? $product['name'] : '' ?>" name="name">
            <?php if (isset($errors['name'])) { echo "<p class='text-danger'>" . $errors['name'] . "</p>"; } ?>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="text" class="form-control" id="image" value="<?= isset($product['image']) ? $product['image'] : '' ?>" name="image">
            <?php if (isset($errors['image'])) { echo "<p class='text-danger'>" . $errors['image'] . "</p>"; } ?>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="text" class="form-control" id="price" value="<?= isset($product['price']) ? $product['price'] : '' ?>" name="price">
            <?php if (isset($errors['price'])) { echo "<p class='text-danger'>" . $errors['price'] . "</p>"; } ?>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity:</label>
            <input type="text" class="form-control" id="quantity" value="<?= isset($product['quantity']) ? $product['quantity'] : '' ?>" name="quantity">
            <?php if (isset($errors['quantity'])) { echo "<p class='text-danger'>" . $errors['quantity'] . "</p>"; } ?>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <input type="text" class="form-control" id="description" value="<?= isset($product['description']) ? $product['description'] : '' ?>" name="description">
            <?php if (isset($errors['description'])) { echo "<p class='text-danger'>" . $errors['description'] . "</p>"; } ?>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category:</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Select category</option>
                <?php foreach ($categories as $category) { ?>
                    <option value="<?= $category['id']; ?>" <?= (isset($product['category_id']) && $category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                        <?= $category['name']; ?>
                    </option>
                <?php } ?>
            </select>
            <?php if (isset($errors['category_id'])) { echo "<p class='text-danger'>" . $errors['category_id'] . "</p>"; } ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
