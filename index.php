<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Submission Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Add new product</h2>
        <form id="productForm">
            <input type="hidden" id="productIndex" name="index">
            <div class="form-group my-2">
                <label for="productName" class="fw-bold mb-1">Product Name</label>
                <input type="text" class="form-control" id="productName" name="product_name" required>
            </div>
            <div class="form-group my-2">
                <label for="quantity" class="fw-bold mb-1">Quantity in Stock</label>
                <input type="number" min="0.01" class="form-control" id="quantity" name="quantity" required>
            </div>
            <div class="form-group my-2">
                <label for="price" class="fw-bold mb-1">Price per Item (in dollars $)</label>
                <input type="number" min="0.01" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary my-3" id="submitButton">Submit</button>
        </form>

        <h3 class="mt-5 mb-3 text-decoration-underline">Submitted Products</h3>
        <div id="productTable"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataFile = 'products.json';
    $products = json_decode(file_get_contents($dataFile), true) ?: [];
    $isEdit = isset($_POST['index']) && $_POST['index'] !== '';

   
    $productData = [
        "product_name" => $_POST['product_name'],
        "quantity" => $_POST['quantity'],
        "price" => $_POST['price'],
        "datetime" => date('Y-m-d H:i:s'),
        "total_value" => $_POST['quantity'] * $_POST['price']
    ];

    if ($isEdit) {
        $products[$_POST['index']] = $productData;
    } else {
        $products[] = $productData;
    }

    file_put_contents($dataFile, json_encode($products));

  
    echo json_encode($products);
    exit();
}
?>
