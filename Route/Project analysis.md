Xây dựng: Website bán hàng
Mẫu thiết kế: pndshop.[...].com
I) Phân tích dự án:

![image](https://github.com/user-attachments/assets/2462cc15-9281-49ab-8f22-6a5899bac362)
- Frontend:
  - Trang chủ - Home page (nơi đầu tiên khách hàng đặt chân đến khi truy cập vào tên miền "domain" website PNDShop).
  - Trang danh mục sản phẩm ( nơi mà người dùng website sẽ tìm đến khi họ muốn tìm hiểu thêm về các sản phẩm website đang bán).
  - Trang chi tiết của từng sản phẩm ( cung cấp thông tin chi tiết về sản phẩm một cách rõ ràng, hấp dẫn & mua hàng).
  - Trang giỏ hàng - shopping cart ( là cầu nối giữa trang sản phẩm và quy trình thanh toán trên website).
  - Trang thanh toán - checkout ( là nơi khách hàng hoàn tất thanh toán các đơn hàng trong giỏ hàng của mình).
  - Trang thanh toán hoàn thành (là điểm đến cuối cùng trong hành trình mua hàng của khách hàng, khi khách hàng đã quyết định mua sản phẩm và bắt đầu các bước thanh toán).
  - Trang liên hệ - ( đóng vai trò như một cầu nối giữa khách mua hàng với cửa hàng).
- Admin:
    - Tài khoản người dùng:
        + Quản lý role (admin, user).
        + Quản lý người dùng: admin/user (không tự tạo mà tạo bằng trang quản trị để thiết lập với các tính năng như thêm/xóa/sửa/hiển thị danh sách).
        + Đăng ký tài khoản (user).
        + Đăng nhập tài khoản (user).
    - Quản lý doanh mục sản phẩm ( nơi hển thị ra danh mục các sản phẩm, admin có thể thêm/xóa/sửa).
    - Quản lý sản phẩm ( từng sản phẩm).
    - Quản lý đơn hàng ( nơi cho ta biết thông tin chi tiết của đơn hàng, hiển thị giảm dần theo thời gian và trạng thái của đơn hàng như đã giao đã nhận).
    - Quản lý phản hồi ( cho phép xem tất cả phản hồi người đùng gửi lên như đánh giá sản phẩm hay dịch vụ của web)
      
  II) Phân tích - thiết kế Database
  1) Role table
     - id (type: int): Là trường "khóa chính" tự tăng để quản lý từng bản ghi [6 ký tự số]
     - name (type: string) hay còn gọi là varchar trong database [ 20 ký tự chữ ]
  2) User table
     - id (type: int): là trường Khóa chính tự tăng để quản lý từng bản ghi
     - role_id ( type: int) là foreign để kết nối tới "role" ở cột (id)
     - fullname (type: string) tên của user [ 50 ký tự ]
     - email ( type: string) [ 150 ký tự ]
     - phone_number ( type: string) có số cần +84 hay 0 ở đầu nên dùng string [ 20 ký tự ]
     - address (type: string) [ 200 ký tự ]
     - password ( type: string ) mã hóa md5 với 32 ký tự ( độ dài chính xác)
  3) Category ( bảng danh mục sản phẩm)
     - id (type: int) là trường khóa tự tăng để quản lý từng bản ghi
     - name (type: string) [ 100 ký tự ]
  4)  Product ( bảng sản phẩm )
     - id (type: int): là trường Khóa chính tự tăng để quản lý từng bản ghi
     - category_id (type: int) vì mỗi sản phẩm đều thuộc 1 danh mục nhất định và cũng là foreign key liên kết với bảng "category" ở cột (id)
     - title ( type: string) tên tiêu đề của sản phẩm [ 350 ký tự]
     - price (type: int) Giá gốc của một sản phẩm
     - discount (type: int) giá đã được áp dụng ưu đãi hay giảm giá
     - thumbnail (type: string) hình ảnh mô tả của sản phẩm [ 500 ký tự ] - sau này có thể phát triển lên nhiều hình ảnh thumbnail 1 lượt cho 1 sản phẩm
     - decription (type: longtext) mô tả sản phẩm
     - created_at (type: datetime) là ngày tạo ra bản ghi
     - update_at (type: datetime) là ngày sửa bản ghi đó
  5)  Galery table ( bảng quản lý tất cả các hình ảnh mô tả sản phẩm )
     - id (type: int): là trường Khóa chính tự tăng
     - product_id (type: int) vì tất cả hình ảnh thumbnail nào đó thuộc về 1 sản phẩm sản phẩm nào và nó cũng là foreign key liên kết với bảng "product" ở cột (id)
     - thumbnail (type: string) [ 500 ký tự]
  6)  feedback ( bảng quản lý phản hồi)
     - id (type: int): là trường Khóa chính tự tăng để quản lý từng bản ghi
     - firstname (type: string) [ 30 ký tự ]
     - lastname  (type: string) [ 30 ký tự ]
     - email (type: string) [ 150 ký tự ]
     - phone_number ( type: string) có số cần +84 hay 0 ở đầu nên dùng string [ 20 ký tự ]
     - subject_name  ( type: string) name của tiêu đề [ 200 ký tự]
     - note ( type: string) [ max 500 ký tự ]
  7) quản lý đơn hàng
     - id (type: int): là trường Khóa chính tự tăng để quản lý từng bản ghi
     - fullname (type: string) [ 60 ký tự ]
     - email (type: string) [ 150 ký tự ]
     - phone_number ( type: string) có số cần +84 hay 0 ở đầu nên dùng string [ 20 ký tự ]
     - address (type: string) địa chỉ nhận đơn hàng [ 200 ký tự ]
     - note ( type: string) [ max 500 ký tự ]
     - order_date (type: datetime) thời điểm đặt đơn hàng
     - product list:
       + product 1 x số lượng x giá thời điểm mua
       + product 2 x số lượng x giá thời điểm mua
     - product list:
    7.1) Order table ( bảng quản lý đơn hàng)
     - id (type: int): là trường Khóa chính tự tăng để quản lý từng bản ghi
     - fullname (type: string) [ 60 ký tự ]
     - email (type: string) [ 150 ký tự ]
     - phone_number ( type: string) có số cần +84 hay 0 ở đầu nên dùng string [ 20 ký tự ]
     - address (type: string) địa chỉ nhận đơn hàng [ 200 ký tự ]
     - note ( type: string) [ max 500 ký tự ]
     - order_date (type: datetime) thời điểm đặt đơn hàng
     - status (type: int) trạng thái của đơn hàng như đang chờ duyệt (pending), đã được duyệt (approved), đang giao hàng (on delivery), đã giao hàng thành công (successfully), đã hủy đơn hàng (cancelled)\
     -  total_money (type: int) tổng tiền của đơn hàng
    7.1) Order detail table ( bảng chi tiết đơn hàng)
     - id (type: int): là trường Khóa chính tự tăng để quản lý từng bản ghi
     - order_id (type: int) chi tiết sản phẩm này thuộc đơn hàng nào và nó cũng là foreign key liên kết với  "order table" tại cột (id)
     - product_id (type: int) sản phẩm này là gì ( dựa vào đây sẽ lấy được thông tin của sản phẩm như tiêu đề hay hình ảnh) nên là foreign key liên kết với  "product table" tại cột (id)
     - price (type: int) giá của đơn hàng
     - num (type: int) số lượng sản phẩm mua
     - total_money (type: int) lưu tổng tiền sản phẩm (price * num) dùng để các câu truy vấn có thể tiết kiệm thời gian
