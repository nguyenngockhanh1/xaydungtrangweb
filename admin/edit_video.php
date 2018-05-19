<?php
// khởi tạo bộ nhớ đệm
ob_start();
include "includes/header.php";
include "../connect/mysql.php";
include "../connect/function.php";
// kiểm tra xem id có phải kiều số không
if(isset($_GET['id']) && filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
	$id= $_GET['id'];
}else{
	header('Location: list_video.php');
	// nếu không tồn tại thì công việc sẽ không thực hiện tiếp , do đó chúng ta dùng hàm ẽxit để kết thúc
	exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$errors = array();
	if (empty($_POST['title'])) {
		$errors[] = 'title';
	} else {
		$title = $_POST['title'];
	}

	if (empty($_POST['link'])) {
		$errors[] = 'link';
	} else {
		$link = $_POST['link'];
	}

	if (empty($_POST['ordernum'])) {
		$errors[] = 'ordernum';
	} else {
		$ordernum = $_POST['ordernum'];
	}
	$status = $_POST['status'];
	if (empty($errors)) {
		//đối với kiểu int thì không cos dấu nháy
		$query   = "UPDATE tblvideo
		SET title='{$title}',link='{$link}',ordernum={$ordernum},status={$status} 
		WHERE  id={$id}";
		$results = mysqli_query($conn, $query) or die("Error: {$query}" .mysqli_error($conn));
		// kiểm tra xem insert có thành công hay không
		if (mysqli_affected_rows($conn) == 1) {
			echo "<p style='color: blue;'>*sửa thành công</p>";
		} else {

			echo "<p style='color:red;'>*sửa thất bại</p>";
		}
	} else {
		echo '<p style="color:red;">*ban can nhap day du thong tin</p>';
	}

}
$query_id ="SELECT title,link,ordernum,status FROM tblvideo WHERE id = {$id}";
$result_id= mysqli_query($conn,$query_id);
kt_query($result_id,$query_id);
// Hàm mysqli_num_rows () trả về số hàng trong tập hợp kết quả.
// 
// kiểm tra id có tồn tại hay không
if(mysqli_num_rows($result_id)==1){
	//Hàm mysqli_fetch_array () tìm nạp hàng kết quả dưới dạng mảng kết hợp, mảng số hoặc cả hai.
	//list() được sử dụng để gán giá trị cho một danh sách biến trong một hoạt động
	list($title,$link,$ordernum,$status)=mysqli_fetch_array($result_id,MYSQLI_NUM);

}else{
	echo 'id không tồn tại';
}
?>
<form action="" method="post">
	<h3>Sửa Video <?php if(isset($title)){ echo $title;} ?></h3>
	<div class="form-group">
		<label for="">Title</label>
		<input value="<?php if (isset($title)) {echo $title;}?>" type="text" name="title" class='form-control' placeholder="title">
		<?php
// check if in array have contais tile
		if (isset($errors) && in_array('title', $errors)) {
			echo "<p style= 'color:red;'>*you needs enter title of video </p>";
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Link</label>
		<input value='<?php if(isset($link)){ echo $link;} ?>' type="text" name="link" class="form-control" placeholder="link">
		<?php
// check if in array have contais link
		if (isset($errors) && in_array('link', $errors)) {
			echo '<p style="color:red;"> *you needs enter link for video </p>';
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Thứ tự</label>
		<input value='<?php if(isset($ordernum)){echo $ordernum;}?>' type="text" name="ordernum" class='form-control' placeholder="thứ tự">
		<?php
// check if in array have contains ordernum
		if (isset($errors) && in_array('ordernum', $errors)) {
			echo '<p style= "color: red;">*you needs enter ordernum for video</p>';
		}
		?>
	</div>
	<div class='form-group'>
		<label style="display: block;">Trạng Thái</label>
		<?php
		if(isset($status) ==1){
			?>
			<label class="radio-inline"><input checked="checked" type="radio" name='status' value="1">Hiển Thị</label>
			<label class='radio-inline'><input type="radio" name='status' value="0">Không Hiển Thị</label>
			<?php
		}
		else{
			?>
			<label class="radio-inline"><input  type="radio" name='status' value="1">Hiển Thị</label>
			<label class='radio-inline'><input checked="checked" type="radio" name='status' value="0">Không Hiển Thị</label>
			<?php
		}
		?>
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Sửa video</button>
</form>
<?php
include "includes/footer.php";
ob_flush();
?>
