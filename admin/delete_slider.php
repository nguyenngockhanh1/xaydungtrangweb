<?php include '../connect/mysql.php'; ?>
<?php include '../connect/function.php'; ?>
<?php
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range' => 1))){
	$id=$_GET['id'];
	$query= "DELETE FROM tblslider WHERE id= {$id}";
	$resualt_slider= mysqli_query($conn,$query);
	kt_query($resualt_slider,$query);
	header("Location: list_slider.php");
}else 
{
	header("Location: list_slider.php");
}
?>

