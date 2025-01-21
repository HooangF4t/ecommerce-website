<?php
// Bắt đầu session để quản lý đăng nhập
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Kết nối đến cơ sở dữ liệu
require_once '../config/db.php';

// Lấy thông tin người dùng từ session
$admin = $_SESSION['admin_logged_in'];

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị - PNDShop</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <header>
        <h1>Chào mừng, <?php echo htmlspecialchars($admin['fullname']); ?>!</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Bảng điều khiển</a></li>
                <li><a href="products.php">Quản lý sản phẩm</a></li>
                <li><a href="categories.php">Quản lý danh mục</a></li>
                <li><a href="orders.php">Quản lý đơn hàng</a></li>
                <li><a href="users.php">Quản lý người dùng</a></li>
                <li><a href="feedback.php">Quản lý phản hồi</a></li>
                <li><a href="logout.php">Đăng xuất</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Bảng điều khiển</h2>
        <p>Chọn một mục từ menu để quản lý.</p>
    </main>
    <footer>
        <p>&copy; 2023 PNDShop. All rights reserved.</p>
    </footer>
</body>
</html>

