<?php 
include '../connect/mysql.php';
include '../connect/function.php';
// kiểm tra xem id có phải kiểu int và lớn hơn 1 hay không
if(isset($_GET['id'])&&filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
		$id=$_GET['id'];
		$query= "DELETE FROM tbluser WHERE id='{$id}'";
		$result = mysqli_query($conn,$query);
		kt_query($result,$query);
		header('Location:list_user.php');
	}
	else{
		header('Location:list_user.php');
	}
 ?>
