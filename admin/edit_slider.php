<?php
ob_start();
include "includes/header.php";
include "../connect/function.php";
?>
<?php
include "../connect/mysql.php";
if(isset($_GET['id'])&& filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
	$id= $_GET['id'];

}else {
	header("Location: list_slider.php");
	exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = array();
	if (empty($_POST['title'])) {
		$errors[] = 'title';
	} else {
		$title = $_POST['title'];
	}

	if (empty($_POST['ordernum'])) {
		$errors[] = 'ordernum';
	} else {
		$ordernum = $_POST['ordernum'];
	}
	$link = $_POST['link'];
	$status = $_POST['status'];
	if (empty($errors)) {
		if(($_FILES['img']['type']!= "image/jpeg")
			&&($_FILES['img']['type']!="image/ipg")
			&& ($_FILES['img']['type']!="image/png")
			&& ($_FILES['img']['type']!="image/gif")){
			$message= 'file không đúng định dạng';
	}
	elseif($_FILES['img']['size'] > 1000000){
		$message= 'kích thước file không được lớn hơn MB';
	}
	elseif($_FILES['img']['size']==0){
		$message= 'bạn chưa nhập file ảnh';
	}
	else{
		/*lấy tên ảnh*/
		$img=$_FILES['img']['name'];
		$move ="../upload/".$img;
		$link_img='upload/'.$img;
			// chuyển file ảnh vào thư mục upload
		move_uploaded_file($_FILES['img']['tmp_name'],$move);
	}
		//đối với kiểu int thì không cos dấu nháy
	$query   = "UPDATE tblslider
	SET title='{$title}',anh='{img}',link='{$link}',ordernum={$ordernum},status={$status}  
	WHERE id={$id}";
	$results = mysqli_query($conn, $query) ;
	kt_query($results, $query);
		// kiểm tra xem insert có thành công hay không
	if (mysqli_affected_rows($conn) == 1) {
		$message ="<p style='color: blue;'>*thêm mới thành công</p>";
	} else {

		$message= "<p style='color:red;'>*thêm mới không thành công</p>";
	}
	echo $message;
} else {
	echo '<p style="color:red;">*ban can nhap day du thong tin</p>';
}

}
?>
<!-- để upload file ta thêm vào form thuộc tính enctype=multipart/form-data -->
<form action="" method="post" enctype="multipart/form-data">
	<h3>Sửa ảnh<?php if(isset($title)){echo $title;} ?></h3>
	<div class="form-group">
		<label for="">Title</label>
		<input value="<?php if (isset($title)) {echo $title;}?>" type="text" name="title" class='form-control' placeholder="title">
		<?php
// check if in array have contais tile
		if (isset($errors) && in_array('title', $errors)) {
			echo "<p style= 'color:red;'>*you needs enter title of images </p>";
		}
		?>
	</div>
	<div class="form-group">
		<label>Ảnh đại diện</label>
		<input  style='outline: none;' type="file" name="img" value="<?php if(isset($img)){echo $img; } ?>">
	</div>
	<div class="form-group">
		<label for="">Link</label>
		<input value='<?php if(isset($link)){echo $link;} ?>' type="text" name="link" class="form-control" placeholder="link">
	</div>
	<div class="form-group">
		<label for="">Thứ tự</label>
		<input value='<?php if(isset($ordernum)){echo $ordernum;} ?>' type="text" name="ordernum" class='form-control' placeholder="thứ tự">
		<?php
// check if in array have contains ordernum
		if (isset($errors) && in_array('ordernum', $errors)) {
			echo '<p style= "color: red;">*you needs enter ordernum for image</p>';
		}
		?>
	</div>
	<div class='form-group'>
		<label style="display: block;">Trạng Thái</label>
		<label class="radio-inline"><input checked="checked" type="radio" name='status' value="1">Hiển Thị</label>
		<label class='radio-inline'><input type="radio" name='status' value="0">Không Hiển Thị</label>
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Thêm mới</button>
</form>
<?php
include "includes/footer.php";
ob_plush();
?>