<?php
include ('../connect/mysql.php');
include ('../connect/function.php');
//filter_var()hàm để kiểm tra xem một biến có thuộc kiểu INT và có lớn hơn 1 hay không
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
	$id      = $_GET['id'];
	$query   = "DELETE FROM tblvideo WHERE id= {$id}";
	$results = mysqli_query($conn, $query);
	kt_query($results, $query);
	//chuyển hướng trang web
	header('Location: list_video.php');
} else {
	header('Location: list_video.php');
}
?>
