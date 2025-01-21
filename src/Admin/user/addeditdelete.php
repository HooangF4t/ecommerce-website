<?php
// Bắt đầu session để quản lý đăng nhập
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập thì chuyển hướng đến trang đăng nhập
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../login.php');
    exit();
}

// Kết nối đến cơ sở dữ liệu
require_once '../../config/db.php';

// Xử lý thêm, xóa, sửa người dùng
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $userId = $_POST['user_id'] ?? null;
    $fullname = $_POST['fullname'] ?? '';
    $email = $_POST['email'] ?? '';
    $phoneNumber = $_POST['phone_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $password = $_POST['password'] ?? '';
    $roleId = $_POST['role_id'] ?? 2; // Mặc định là user

    if ($action == 'add') {
        // Thêm người dùng mới
        $hashedPassword = md5($password);
        $stmt = $conn->prepare("INSERT INTO users (role_id, fullname, email, phone_number, address, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $roleId, $fullname, $email, $phoneNumber, $address, $hashedPassword);
        $stmt->execute();
    } elseif ($action == 'edit' && $userId) {
        // Sửa thông tin người dùng
        if (!empty($password)) {
            $hashedPassword = md5($password);
            $stmt = $conn->prepare("UPDATE users SET role_id = ?, fullname = ?, email = ?, phone_number = ?, address = ?, password = ? WHERE id = ?");
            $stmt->bind_param("isssssi", $roleId, $fullname, $email, $phoneNumber, $address, $hashedPassword, $userId);
        } else {
            $stmt = $conn->prepare("UPDATE users SET role_id = ?, fullname = ?, email = ?, phone_number = ?, address = ? WHERE id = ?");
            $stmt->bind_param("issssi", $roleId, $fullname, $email, $phoneNumber, $address, $userId);
        }
        $stmt->execute();
    } elseif ($action == 'delete' && $userId) {
        // Xóa người dùng
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
    }
}

// Lấy danh sách người dùng
$result = $conn->query("SELECT * FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng - PNDShop</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <header>
        <h1>Quản lý người dùng</h1>
        <nav>
            <ul>
                <li><a href="../dashboard.php">Bảng điều khiển</a></li>
                <li><a href="../products.php">Quản lý sản phẩm</a></li>
                <li><a href="../categories.php">Quản lý danh mục</a></li>
                <li><a href="../orders.php">Quản lý đơn hàng</a></li>
                <li><a href="../feedback.php">Quản lý phản hồi</a></li>
                <li><a href="../logout.php">Đăng xuất</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Danh sách người dùng</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                    <td><?php echo htmlspecialchars($user['role_id'] == 1 ? 'Admin' : 'User'); ?></td>
                    <td>
                        <form action="addeditdelete.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit">Sửa</button>
                        </form>
                        <form action="addeditdelete.php" method="post" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Thêm/Sửa người dùng</h2>
        <form action="addeditdelete.php" method="post">
            <input type="hidden" name="action" value="add">
            <label for="fullname">Họ tên:</label>
            <input type="text" id="fullname" name="fullname" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="phone_number">Số điện thoại:</label>
            <input type="text" id="phone_number" name="phone_number">
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address">
            <label for="password">Mật khẩu:</label>
            <input type="password" id="password" name="password" required>
            <label for="role_id">Vai trò:</label>
            <select id="role_id" name="role_id">
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select>
            <button type="submit">Thêm người dùng</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2023 PNDShop. All rights reserved.</p>
    </footer>
</body>
</html>

