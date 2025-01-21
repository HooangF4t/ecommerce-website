<?php
// Kết nối cơ sở dữ liệu
include 'db_connection.php';

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy thông tin chi tiết sản phẩm từ cơ sở dữ liệu
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $product = mysqli_fetch_assoc($result);
} else {
    echo "Không tìm thấy sản phẩm.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

