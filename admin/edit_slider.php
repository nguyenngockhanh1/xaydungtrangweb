<?php
// khởi tạo bộ nhớ đệm
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
	//  check if image have error
	if($_FILES['anh']['size']==' '){
		$link_img = $_POST['anh_hidden'];
		$thumb = $_POST['anhthumb_hidden'];

	}
	else{
		if(($_FILES['anh']['type']!= "image/jpeg")
			&&($_FILES['anh']['type']!="image/ipg")
			&& ($_FILES['anh']['type']!="image/png")
			&& ($_FILES['anh']['type']!="image/gif"))
		{
			$message= 'file không đúng định dạng';
		}
		elseif($_FILES['anh']['size'] > 1000000){
			echo 'kích thước file không được lớn hơn MB';
			$errors[] = 'anh';
		}
		else{
			/*lấy tên ảnh*/
			$anh=$_FILES["anh"]["name"];
			$img_address="../slider/".$anh;
			$file_tmp=$_FILES["anh"]["tmp_name"];
			$link_img="slider/".$anh;
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
			$thumb= 'slider/resized'.$temp[0].'thum_b'.'.'.$temp[1];
	//$imageThumb = new ImagesHelper($link_img);
		// resize anh
		// nếu ảnh có độ rộng lớn hơn 700 thì thực hiện resize
	// if($imageThumb-> width() > 700)
	// {
	// 		//ta có thể resize vê một kích cỡ bất kì
	// 	$imageThumb -> resize(600, 'resize');
	// }
	// $imageThumb-> save($temp[0].'_thumb','../upload/resized');

		}
					// tiến hành xóa ảnh cũ sau khi cập nhật ảnh mới
		$sql = "SELECT anh,anh_thumb FROM tblslider WHERE id={$id}";
		$result_update = mysqli_query($conn,$sql);
		$anh_info= mysqli_fetch_assoc($result_update);
// delete img in folder upload
		unlink($anh_info['anh']);
	}
	//  end image
	$link = $_POST['link'];
	$status = $_POST['status'];
	if (empty($errors)) {
		//đối với kiểu int thì không cos dấu nháy
		$query   = "UPDATE tblslider
		SET title= '{$title}',anh='{$link_img}',anh_thumb = '{$thumb}',link='{$link}',
		ordernum = {$ordernum},status={$status}
		WHERE id= {$id} ";
		$results = mysqli_query($conn, $query) ;
		kt_query($results, $query);
		// kiểm tra xem insert có thành công hay không
		if (mysqli_affected_rows($conn) == 1) {
			$message ="<p style='color: blue;'>*sửa thành công</p>";

		} else {

			$message= "<p style='color:red;'>*bạn chưa sửa gì !</p>";
		}
		$title    = '';
		$link     = '';
		$ordernum = '';
		echo $message;
	} else {
		echo '<p style="color:red;">*ban can nhap day du thong tin</p>';
	}

}
$query_id = "SELECT title,anh,anh_thumb,link,ordernum,status FROM tblslider WHERE id= {$id}";
$result_id = mysqli_query($conn,$query_id);
kt_query($result_id,$query_id);
//  hàm msqli_num_rows() trả về số hàng trong tập kết quả
//  kiểm tra xem id có tồn tại hay không
if(mysqli_num_rows($result_id)==1){
	list($title,$anh,$thumb,$link,$ordernum,$status) = mysqli_fetch_array($result_id,MYSQLI_NUM);
}else{
	echo "id không tồn tại";
}
?>
<!-- để upload file ta thêm vào form thuộc tính enctype=multipart/form-data -->
<form action="" method="post" enctype="multipart/form-data">
	<h3>Sửa ảnh <?php if(isset($title)){echo $title;} ?></h3>
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
		<label>Ảnh đại diện</label><br>
		<img src='<?php echo '../'.$anh; ?>' width= "200px;" alt=""><br><br>
		<!-- khi người dùng không nhập ảnh thì tự động sẽ lấy ảnh cũ nhờ hai ô input với type= "hidden" -->
		<input type="hidden" name="anh_hidden" value= "<?php echo '../'.$anh; ?>">
		<input type="hidden" name="anhthumb_hidden" value= "<?php echo $thumb; ?>">
		<input  style='outline: none;' type="file" name="anh">
		<?php
// check if in array have contais tile
		if (isset($errors) && in_array('anh', $errors)) {
			echo "<p style= 'color:red;'>*you needs enter  images </p>";
		}
		?>
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
	<button type="submit" name="submit" class="btn btn-primary">Sửa ảnh</button>
</form>
<?php
include "includes/footer.php";
ob_flush();
?>