<?php
// Set page header
$page_title = "Create Product";
include_once 'layout_header.php';

// include db and object files
include_once 'config/database.php';
include_once 'objects/category.php';
include_once 'objects/product.php';

// get database connection
$datbase = new Database();
$db = $datbase->getConnection();

// pass connection to object
$product = new Product($db);
$category = new Category($db);

// if the form was submitted - PHP OOP CRUD Tutorial
if ($_POST) {

    // set product property values
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];
    $image = !empty($_FILES["image"]["name"])
        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
    $product->image = $image;

    // create the product
    if ($product->create()) {
        echo "<div class='alert alert-success'>Product was created.</div>";
        // try to upload the submitted file
        
        // uploadPhoto() method will return an error message, if any.
        echo $product->uploadPhoto();
    }

    // if unable to create the product, tell the user
    else {
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}

?>

<!-- Contents will be here -->
<div class='right-button-margin'>
    <a href='index.php' class='btn btn-primary  pull-right'>Read Products</a>
</div>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>

        <tr>
            <td>Price</td>
            <td><input type='text' name='price' class='form-control' /></td>
        </tr>

        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'></textarea></td>
        </tr>

        <tr>
            <td>Category</td>
            <td>
                <!-- categories from database will be here -->
                <?php
                // read the product categories from the database
                $stmt = $category->read();

                // put them in a select drop-down
                echo "<select class='form-control' name='category_id'>";
                echo "<option>Select category...</option>";

                while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row_category);
                    echo "<option value='{$id}'>{$name}</option>";
                }

                echo "</select>";
                ?>
            </td>

        </tr>
        <tr>
            <td>Photo</td>
            <td><input type="file" name="image" /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>

    </table>
</form>


<?php
// Footer
include_once 'layout_footer.php';

?>