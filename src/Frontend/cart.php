<?php
// Bắt đầu session để quản lý giỏ hàng
session_start();

// Kết nối đến cơ sở dữ liệu
require_once '../../config/db.php';

// Xử lý thêm, xóa, sửa sản phẩm trong giỏ hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $productId = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? 1;

    if ($action == 'add' && $productId) {
        // Thêm sản phẩm vào giỏ hàng
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    } elseif ($action == 'update' && $productId) {
        // Cập nhật số lượng sản phẩm trong giỏ hàng
        $_SESSION['cart'][$productId] = $quantity;
    } elseif ($action == 'delete' && $productId) {
        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$productId]);
    }
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
    <title>Giỏ hàng - PNDShop</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <header>
        <h1>Giỏ hàng của bạn</h1>
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
        <h2>Danh sách sản phẩm trong giỏ hàng</h2>
        <?php if (empty($cartItems)): ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td><?php echo number_format($item['price']); ?> VND</td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                <input type="number" name="quantity" value="<?php echo htmlspecialchars($_SESSION['cart'][$item['id']]); ?>" min="1">
                                <button type="submit">Cập nhật</button>
                            </form>
                        </td>
                        <td><?php echo number_format($item['price'] * $_SESSION['cart'][$item['id']]); ?> VND</td>
                        <td>
                            <form action="cart.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Tổng tiền: <?php echo number_format(array_sum(array_map(function($item) {
                return $item['price'] * $_SESSION['cart'][$item['id']];
            }, $cartItems))); ?> VND</h3>
            <a href="checkout.php">Thanh toán</a>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2023 PNDShop. All rights reserved.</p>
    </footer>
</body>
</html>

