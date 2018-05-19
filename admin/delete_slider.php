<?php include '../connect/mysql.php'; ?>
<?php include '../connect/function.php'; ?>
<?php
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range' => 1))){
	$id=$_GET['id'];
	//xóa hình ảnh trong thư mục upload
	$sql = "SELECT * FROM tblslider WHERE id ={$id}";
	$query_a = mysqli_query($conn,$sql);
	// để hiển thị một bản ghi
	$anh_info = mysqli_fetch_assoc($query_a);
	//xóa hình ảnh trong thư mục upload
	unlink($anh_info['anh']);
	$query= "DELETE FROM tblslider WHERE id= {$id}";
	$resualt_slider= mysqli_query($conn,$query);
	kt_query($resualt_slider,$query);
	header("Location: list_slider.php");
}else 
{
	header("Location: list_slider.php");
}
?>

