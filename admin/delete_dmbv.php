<?php
include "../connect/mysql.php";
include "../connect/function.php";
if(isset($_GET['id'])&&filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
	$id= $_GET['id'];
	$query_delete = "DELETE FROM tbldanhmucbaiviet WHERE id={$id}";
	$result_delete =mysqli_query($conn,$query_delete);
	kt_query($result_delete,$query_delete);
	header("Location:list_danhmucbv.php");
}else{
	header("Location:list_danhmucbv.php");
}
?>