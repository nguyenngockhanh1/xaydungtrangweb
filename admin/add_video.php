<?php
include "includes/header.php";
include "../connect/mysql.php";
include "../connect/function.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();
	if (empty($_POST['title'])) {
		$errors[] = 'title';
	} else {
		$title = $_POST['title'];
	}

	if(empty($_POST['link'])){
		$errors[]= 'link';
	}else {
		$link= $_POST['link'];
	}

	if (empty($_POST['ordernum'])) {
		$errors[] = 'ordernum';
	} else {
		$ordernum = $_POST['ordernum'];
	}

	$status = $_POST['status'];
	if (empty($errors)) {
		//đối với kiểu int thì không cos dấu nháy
		$query   = "INSERT INTO tblvideo(title,link,ordernum,status) VALUES('{$title}','{$link}',{$ordernum},{$status})";
		$results = mysqli_query($conn, $query) ;
		kt_query($results, $query);
		// kiểm tra xem insert có thành công hay không
		if (mysqli_affected_rows($conn) == 1) {
			$message ="<p style='color: blue;'>*thêm mới thành công</p>";
			$title    = '';
			$link     = '';
			$ordernum = '';
		} else {

			$message= "<p style='color:red;'>*thêm mới không thành công</p>";
		}
		echo $message;
	} else {
		echo '<p style="color:red;">*ban can nhap day du thong tin</p>';
	}

}
?>
<form method="post">
	<h3>Thêm Video</h3>
	<div class="form-group">
		<label for="">Title</label>
		<input value="<?php if (isset($_POST['title'])) {echo $title;}?>" type="text" name="title" class='form-control' placeholder="title">
		<?php
// check if in array have contais tile
		if (isset($errors) && in_array('title', $errors)) {
			echo "<p style= 'color:red;'>*you needs enter title of video </p>";
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Link</label>
		<input value='<?php if(isset($_POST['link'])){echo $link;} ?>' type="text" name="link" class="form-control" placeholder="link">
				<?php
// check if in array have contains link
		if (isset($errors) && in_array('link', $errors)) {
			echo '<p style= "color: red;">*you needs enter link for video</p>';
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Thứ tự</label>
		<input type="text" name="ordernum" class='form-control' placeholder="thứ tự">
		<?php
// check if in array have contains ordernum
		if (isset($errors) && in_array('ordernum', $errors)) {
			echo '<p style= "color: red;">*you needs enter ordernum for video</p>';
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
