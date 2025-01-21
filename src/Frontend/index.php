<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNDShop - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Chào mừng đến với PNDShop</h1>
        <nav>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="products.php">Sảm phẩm</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>

            </ul>
        </nav>
    </header>
    <main>
        <section class="hero">
            <h2>Tìm ưu đãi tốt nhất cho các mặt hàng đã qua sử dụng</h2>
            <p>Khám phá nhiều loại sản phẩm đã qua sử dụng của chúng tôi với mức giá cạnh tranh nhất.</p>
            <a href="products.php" class="btn">Xem ngay</a>
        </section>
        <section class="featured-products">
            <h2>Featured Products</h2>
            <div class="product-list">
                <!-- Ví dụ về một sản phẩm -->
                <div class="product-item">
                    <img src="images/product1.jpg" alt="Product 1">
                    <h3>Product 1</h3>
                    <p>100.000 VNĐ</p>
                    <a href="product-details.php?id=1" class="btn">Xem mô tả</a>
                </div>
                <!-- Thêm nhiều sản phẩm khác nếu cần -->
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2025 PNDShop. All rights reserved.</p>
    </footer>
</body>
</html>
