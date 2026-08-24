<?php

$products = [
        [
                "name" => "Notebook",
                "category" => "Electronics",
                "price" => 3500,
                "stock" => 4
        ],
        [
                "name" => "Mouse",
                "category" => "Accessories",
                "price" => 120,
                "stock" => 15
        ],
        [
                "name" => "Keyboard",
                "category" => "Accessories",
                "price" => 250,
                "stock" => 3
        ],
        [
                "name" => "Monitor",
                "category" => "Electronics",
                "price" => 1800,
                "stock" => 8
        ]
];
$total = 0;
for ($i = 0; $i < count($products); $i++) {
    $product = $products[$i];
    $productTotal = $product['price'] * $product['stock'];
    $products[$i]['total'] = number_format($productTotal, 2);
    $products[$i]['price'] = number_format($product['price'], 2);
    $products[$i]['status'] = $product['stock'] <= 5 ? 'table-danger' : '';
    $total += $productTotal;
}
$total = number_format($total, 2);
$totalCount = count($products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Inventory Dashboard</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        .table-primary {
            --bs-table-bg: var(--bs-primary);
        }

        .table-danger {
            --bs-table-color-state: #a6192a !important;
        }
    </style>
</head>
<body class="container py-5">
<div class="shadow rounded-3 p-3">
    <h1>Product Inventory Dashboard</h1>
    <div class="row g-3">
        <div class="col">
            <div class="bg-primary-subtle rounded-3 p-3">
                <h2 class="fs-5">Total Products</h2>
                <p><?= $totalCount ?></p>
            </div>
        </div>
        <div class="col">
            <div class="bg-primary-subtle rounded-3 p-3">
                <h2 class="fs-5">Total Inventory Value</h2>
                <p>$<?= $total ?></p>
            </div>
        </div>
    </div>
    <table class="table mt-5">
        <thead class="table-primary">
        <tr>
            <th class="text-white">Product</th>
            <th class="text-white">Category</th>
            <th class="text-white">Price</th>
            <th class="text-white">Stock</th>
            <th class="text-white">Total Value</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $product) : ?>
            <tr class="<?= $product['status'] ?>">
                <td><?= $product['name'] ?></td>
                <td><?= $product['category'] ?></td>
                <td>$<?= $product['price'] ?></td>
                <td><?= $product['stock'] ?> </td>
                <td>$<?= $product['total'] ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
