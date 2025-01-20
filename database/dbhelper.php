<?php
require_once('config.php');

//Các lệnh chính sẽ dùng sau này như:insert, update, delete, select
//SQL: insert, update, delete
//thực ra các dữ án lớn sẽ tác mở kết nối, đóng kết nối sẽ tách ra riêng nên nếu có thời gian sẽ tìm hiểu
function execute($sql){     
    
    //Kết nối database
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($conn, 'utf8');
    
    //Thực hiện câu lệnh SQL "truy vấn"
    mysqli_query($conn, $sql);
    
    //Đóng kết nối
    mysqli_close($conn);
}
//SQL: select -> lấy dữ liệu đầu ra "hàm lấy dữ liệu ra từ database"
function executeResult($sql){   
    $data = [];
    
    //Kết nối database
    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
    mysqli_set_charset($conn, 'utf8');
    
    //Thực hiện câu lệnh SQL "truy vấn"
    $resultset = mysqli_query($conn, $sql); //trả về 1 bảng dữ liệu
    if($isSingle) {
        $data = mysqli_fetch_array($resultset, 1);
    } else {
        while(($row = mysqli_fetch_array($resultset, 1)) != null) {
            $data[] = $row;
        }
    }
  
    //Đóng kết nối
    mysqli_close($conn);

    return $data; //trả về 1 mảng dữ liệu
} 
