<?php
include "includes/header.php";
include "../connect/function.php";
include "../connect/image_helper.php";
?>
<?php
include "../connect/mysql.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();
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


	if(($_FILES['anh']['type']!= "image/jpeg")
		&&($_FILES['anh']['type']!="image/ipg")
		&& ($_FILES['anh']['type']!="image/png")
		&& ($_FILES['anh']['type']!="image/gif")){
		echo  'file không đúng định dạng';
	$errors[] = 'anh';
}
elseif($_FILES['anh']['size'] > 1000000){
	echo 'kích thước file không được lớn hơn MB';
	$errors[] = 'anh';
}
elseif($_FILES['anh']['size']==0){
	echo 'bạn chưa nhập file ảnh';
	$errors[] = 'anh';
}
else{
	/*lấy tên ảnh*/
	$anh=$_FILES["anh"]["name"];
	$img_address="../upload/".$anh;
	$file_tmp=$_FILES["anh"]["tmp_name"];
	$link_img="../upload/".$anh;
			// chuyển file ảnh vào thư mục upload
	move_uploaded_file($file_tmp,$img_address);
		// xử lí resize , crop image
		// hàm explode dùng để cắt đuôi sau dấu . 
	$temp = explode('.',$anh);
	if($temp[1] == 'jpeg' or $temp[1] == 'JPEG'){
		$temp = 'jpg';
	}
		//chuyển hết tất cả các định đạng đuôi ảnh thành chữ thường
	$temp[1] = strtolower($temp[1]);
	$thumb= 'upload/resized'.$temp[0].'thum_b'.'.'.$temp[1];
	$imageThumb = new ImagesHelper($link_img);
		//resize anh
		//nếu ảnh có độ rộng lớn hơn 700 thì thực hiện resize
	if($imageThumb-> width() > 700)
	{
			//ta có thể resize vê một kích cỡ bất kì
		$imageThumb -> resize(600, 'resize');
	}
	$imageThumb-> save($temp[0].'_thumb','../upload/resized');

}
if (empty($errors)) {
		//đối với kiểu int thì không cos dấu nháy
	$query   = "INSERT INTO tblslider(title,anh,anh_thumb,link,ordernum,status) VALUES('{$title}','{$link_img}','{$thumb}','{$link}',{$ordernum},{$status})";
	$results = mysqli_query($conn, $query) ;
	kt_query($results, $query);
		// kiểm tra xem insert có thành công hay không
	if (mysqli_affected_rows($conn) == 1) {
		$message ="<p style='color: blue;'>*thêm mới thành công</p>";
	} else {

		$message= "<p style='color:red;'>*thêm mới không thành công</p>";
	}
	$title    = '';
	$link     = '';
	$ordernum = '';
	echo $message;
} else {
	echo '<p style="color:red;">*ban can nhap day du thong tin</p>';
}

}
?>
<!-- để upload file ta thêm vào form thuộc tính enctype=multipart/form-data -->
<form action="add_slider.php" method="post" enctype="multipart/form-data">
	<h3>Thêm Mới Ảnh</h3>
	<div class="form-group">
		<label for="">Title</label>
		<input value="<?php if(isset($_POST['title'])) {echo $title;}?>" type="text" name="title" class='form-control' placeholder="title">
		<?php
// check if in array have contais tile
		if (isset($errors) && in_array('title', $errors)) {
			echo "<p style= 'color:red;'>*you needs enter title ò images </p>";
		}
		?>
	</div>
	<div class="form-group">
		<label>Ảnh đại diện</label>
		<input style='outline: none;' type="file" name="anh" value="">
		<?php
// check if in array have contais tile
		if (isset($errors) && in_array('anh', $errors)) {
			echo "<p style= 'color:red;'>*you needs enter images </p>";
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Link</label>
		<input value='<?php if(isset($_POST['link'])){echo $link;} ?>' type="text" name="link" class="form-control" placeholder="link">
	</div>
	<div class="form-group">
		<label for="">Thứ tự</label>
		<input type="text" name="ordernum" class='form-control' placeholder="thứ tự">
		<?php
// check if in array have contains ordernum
		if (isset($errors) && in_array('ordernum',$errors)) {
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
?>