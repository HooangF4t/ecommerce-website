<?php
//chứa các hàm tiện ích cho cả dự án (nếu cần submit form, kiểm tra đăng nhập, ...)
//hàm kiểm tra xem người dùng đã đăng nhập hay chưa
//nếu chưa đăng nhập thì chuyển hướng người dùng về trang login
// function checkLogin(){
function checkLogin(){
    session_start();
    if(!isset($_SESSION['user'])){
        header('location: login.php');
    }
}
//fixSQLInjection ==> $sql = "ghi câu lệnh SQL vào đây"
function fixSQLInject($sql){
    $sql = str_replace('\'', '\\\'', $sql);
    $sql = str_replace('\\"', '\\\\"', $sql);
    return $sql;
}

function getGet($key){
    $value = '';
    if(isset($_GET[$key])){
        $value = $_GET[$key];
        $value = fixSQLInject($value);
    }
    return $value;
}
function getPost($key){
    $value = '';
    if(isset($_POST[$key])){
        $value = $_POST[$key];
        $value = fixSQLInject($value);
    }
    return $value;
}
function getRequest($key){
    $value = '';
    if(isset($_REQUEST[$key])){
        $value = $_REQUEST[$key];
        $value = fixSQLInject($value);
    }
    return $value;
}
function getCookie($key){
    $value = '';
    if(isset($_COOKIE[$key])){
        $value = $_COOKIE[$key];
        $value = fixSQLInject($value);
    }
    return $value;
}
