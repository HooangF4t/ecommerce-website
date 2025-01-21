<?php
// Bắt đầu session để quản lý trạng thái
session_start();

// Kiểm tra nếu không có đơn hàng vừa được tạo thì chuyển hướng về trang chủ
if (!isset($_SESSION['order_completed'])) {
    header('Location: index.php');
    exit();
}

// Xóa trạng thái đơn hàng hoàn thành sau khi hiển thị
unset($_SESSION['order_completed']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoàn thành thanh toán - PNDShop</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Hoàn thành thanh toán</h1>
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="products.php">Sản phẩm</a></li>
                <li><a href="cart.php">Giỏ hàng</a></li>
                <li><a href="checkout.php">Thanh toán</a></li>
                <li><a href="contact.php">Liên hệ</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Cảm ơn bạn đã mua hàng tại PNDShop!</h2>
        <p>Đơn hàng của bạn đã được xử lý thành công. Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng và giao hàng trong thời gian sớm nhất.</p>
        <p>Bạn có thể xem lại đơn hàng của mình trong <a href="orders.php">lịch sử đơn hàng</a>.</p>
        <a href="index.php">Tiếp tục mua sắm</a>
    </main>
    <footer>
        <p>&copy; 2023 PNDShop. All rights reserved.</p>
    </footer>
</body>
</html>
