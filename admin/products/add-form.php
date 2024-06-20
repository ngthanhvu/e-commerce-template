<?php
include_once "../config/DBUntil.php";
$db = new DBUntil();
$errors = [];
$categories = $db->select("SELECT * FROM category");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name']) && empty($_POST['name'])) {
        $errors['name'] = "Name is required";
    } else {
        $name = $_POST['name'];
    }

    if (isset($_POST['price']) && empty($_POST['price'])) {
        $errors['price'] = "Price is required";
    } else {
        $price = $_POST['price'];
    }

    // if (isset($_POST['image']) && empty($_POST['image'])) {
    //     $errors['image'] = "Image is required";
    // } else {
    //     $image = $_POST['image'];
    // }

    if (isset($_POST['quantity']) && empty($_POST['quantity'])) {
        $errors['quantity'] = "Quantity is required";
    } else {
        $quantity = $_POST['quantity'];
    }

    if (isset($_POST['description']) && empty($_POST['description'])) {
        $errors['description'] = "Description is required";
    } else {
        $description = $_POST['description'];
    }

    if (isset($_POST['category_id']) && empty($_POST['category_id'])) {
        $errors['category_id'] = "Category is required";
    } else {
        $category_id = $_POST['category_id'];
    }

    if (isset($_FILES['image']) && !$_FILES['image']['error'] > UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . "/uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $IMAGE_TYPES = array('jpg', 'jpeg', 'png');

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $errors['image'] = "folder upload not found";
        }

        if (!in_array($imageFileType, $IMAGE_TYPES)) {
            $errors['image'] = "image type must is image format";
        }

        if (
            $_FILES['image']["size"] > 1000000
        ) {
            $errors['image'] = "image too large";
        }
    } else {
        $image = null;
    }


    if (count($errors) == 0) {
        global $db;
        $image = null;
        if (isset($_FILES['image']) && !$_FILES['image']['error'] > UPLOAD_ERR_OK) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = htmlspecialchars(basename($_FILES["image"]["name"]));
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $product = $db->insert("product", [
            "name" => $name,
            "image" => $image,
            "price" => $price,
            "quantity" => $quantity,
            "description" => $description,
            "category_id" => $category_id
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
    <form action="index.php?view=add-product" method="post" enctype="multipart/form-data">
        <h2 class="mt-3">Add product</h2>
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
            <?php if (isset($errors['name'])) {
                echo "<p class='text-danger'>" . $errors['name'] . "</p>";
            } ?>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image:</label>
            <input type="file" class="form-control" id="image" placeholder="Enter image" name="image">
            <?php if (isset($errors['image'])) {
                echo "<p class='text-danger'>" . $errors['image'] . "</p>";
            } ?>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="text" class="form-control" id="price" placeholder="Enter price" name="price">
            <?php if (isset($errors['price'])) {
                echo "<p class='text-danger'>" . $errors['price'] . "</p>";
            } ?>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity:</label>
            <input type="text" class="form-control" id="quantity" placeholder="Enter quantity" name="quantity">
            <?php if (isset($errors['quantity'])) {
                echo "<p class='text-danger'>" . $errors['quantity'] . "</p>";
            } ?>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description:</label>
            <input type="text" class="form-control" id="description" placeholder="Enter description" name="description">
            <?php if (isset($errors['description'])) {
                echo "<p class='text-danger'>" . $errors['description'] . "</p>";
            } ?>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category:</label>
            <select class="form-control" id="category_id" name="category_id">
                <option value="">Select category</option>
                <?php foreach ($categories as $category) { ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php } ?>
            </select>
            <?php if (isset($errors['category_id'])) {
                echo "<p class='text-danger'>" . $errors['category_id'] . "</p>";
            } ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>