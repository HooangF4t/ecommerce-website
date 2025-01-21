<?php
// Bắt đầu session để quản lý giỏ hàng
session_start();

// Kết nối đến cơ sở dữ liệu
require_once '../../config/db.php';

// Kiểm tra nếu giỏ hàng trống thì chuyển hướng về trang giỏ hàng
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Xử lý thanh toán
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $note = $_POST['note'] ?? '';

    // Tạo đơn hàng mới
    $stmt = $conn->prepare("INSERT INTO orders (fullname, email, phone_number, address, note, order_date, status, total_money) VALUES (?, ?, ?, ?, ?, NOW(), 0, ?)");
    $totalMoney = array_sum(array_map(function($item) {
        return $item['price'] * $_SESSION['cart'][$item['id']];
    }, $cartItems));
    $stmt->bind_param("sssssi", $fullname, $email, $phoneNumber, $address, $note, $totalMoney);
    $stmt->execute();
    $orderId = $stmt->insert_id;

    // Thêm chi tiết đơn hàng
    foreach ($cartItems as $item) {
        $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, price, num, total_money) VALUES (?, ?, ?, ?, ?)");
        $quantity = $_SESSION['cart'][$item['id']];
        $total = $item['price'] * $quantity;
        $stmt->bind_param("iiiii", $orderId, $item['id'], $item['price'], $quantity, $total);
        $stmt->execute();
    }

    // Xóa giỏ hàng sau khi thanh toán thành công
    unset($_SESSION['cart']);

    // Chuyển hướng đến trang thanh toán hoàn thành
    header('Location: order_success.php');
    exit();
}

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $productIds = implode(',', array_keys($_SESSION['cart']));
    $result = $conn->query("SELECT * FROM products WHERE id IN ($productIds)");
    $cartItems = $result->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - PNDShop</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Thanh toán</h1>
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
        <h2>Thông tin thanh toán</h2>
        <form action="checkout.php" method="post">
            <label for="fullname">Họ tên:</label>
            <input type="text" id="fullname" name="fullname" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" id="phone_number" name="phone_number" required>
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" required>
            <label for="note">Ghi chú:</label>
            <textarea id="note" name="note"></textarea>
            <h3>Danh sách sản phẩm</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td><?php echo number_format($item['price']); ?> VND</td>
                        <td><?php echo htmlspecialchars($_SESSION['cart'][$item['id']]); ?></td>
                        <td><?php echo number_format($item['price'] * $_SESSION['cart'][$item['id']]); ?> VND</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Tổng tiền: <?php echo number_format(array_sum(array_map(function($item) {
                return $item['price'] * $_SESSION['cart'][$item['id']];
            }, $cartItems))); ?> VND</h3>
            <button type="submit">Thanh toán</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 PNDShop. All rights reserved.</p>
    </footer>
</body>
</html>

