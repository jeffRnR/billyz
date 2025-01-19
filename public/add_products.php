<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <?php include '../includes/db_connect.php'; ?>

    <div class="form-container">
        <h2>Add New Product</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $category = $_POST['category'];
            $cost = $_POST['cost'];

            $sql = "INSERT INTO products (product_id, product_name, category, cost) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $product_id, $product_name, $category, $cost);

            if ($stmt->execute()) {
                echo "<div class='message success'>Product added successfully.</div>";
            } else {
                echo "<div class='message error'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="product_id">Product ID:</label>
            <input type="text" id="product_id" name="product_id" required pattern="BC[1-5][0-9]{2}"
                title="ID must start with BC followed by a number between 100 and 500">

            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>

            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required>

            <label for="cost">Cost:</label>
            <input type="number" id="cost" name="cost" step="0.01" required>

            <button type="submit">Add Product</button>
        </form>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>

</html>