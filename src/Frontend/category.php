<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Mục Sản Phẩm</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Danh Mục Sản Phẩm</h1>
    </header>
    <main>
        <section class="categories">
            <h2>Danh Mục Của Chúng Tôi</h2>
            <ul>
                <?php
                // Kết nối cơ sở dữ liệu
                $servername = "localhost";
                $username = "username";
                $password = "password";
                $dbname = "ecommerce";

                // Tạo kết nối
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Kiểm tra kết nối
                if ($conn->connect_error) {
                    die("Kết nối thất bại: " . $conn->connect_error);
                }

                $sql = "SELECT id, name FROM categories";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Xuất dữ liệu của từng hàng
                    while($row = $result->fetch_assoc()) {
                        echo "<li><a href='category.php?id=" . $row["id"] . "'>" . $row["name"] . "</a></li>";
                    }
                } else {
                    echo "Không có kết quả";
                }
                // Đóng kết nối cơ sở dữ liệu
                $conn->close();
                ?>
            </ul>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 PNDShop. All rights reserved.</p>
    </footer>
</body>
</html>
