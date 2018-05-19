<?php 
include "includes/header.php";
include "includes/sidebar.php";
include "../connect/mysql.php";
include "../connect/function.php";

if($_SERVER['REQUEST_METHOD']== 'POST'){
	$errots =array();
	if(empty($_POST['danhmucbv'])){
		$errors[]= 'danhmucbv';
	}else {
		$danhmucbv = $_POST['danhmucbv'];
	}
	if(empty($ordernum)){
		$ordernum =0;
	}else{
		$ordernum = $_POST['ordernum'];
	}
	$menu = $_POST['menu'];
	$home = $_POST['home'];
	$status = $_POST['status'];
	if(empty($errors)){
		//nếu người dùng không lựa chọn một danh mục thì tức là danh mục đó là danh mục cha 
		if($_POST['parent']==0){
			$parent_id = 0;
		}else{
			$parent_id = $_POST['parent'] ;
		}
		$query_danhmucbv = "INSERT INTO
		tbldanhmucbaiviet(danhmucbaiviet,menu,home,ordernum,status,parent_id) VALUES(
		'{$danhmucbv}',
		{$menu},
		{$home},
		{$ordernum},
		{$status},
		{$parent_id})";
		$result_danhmucbv = mysqli_query($conn,$query_danhmucbv);
		kt_query($result_danhmucbv,$query_danhmucbv);
		//kiểm tra xem insert có thành công hay không
		if(mysqli_affected_rows($conn)==1){
			$message= "insert thành công";
			$_POST['danhmucbv'] ="";
			$_POST['ordernum'] = "";
		}
		else{
			$message = "insert thất bại";
		}
	}
	else{
		$message = "bạn cần nhập đầy đủ thông tin";
	}
}
?>
<form method="post" >
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<?php if(isset($message)){echo "<p style ='color:red' >". $message ."</p>";} ?>
			<h3>Thêm danh mục bài viết</h3>
			<div class="form-group">
				<label>Danh mục bài viêt</label>
				<input type="text" name="danhmucbv" class="form-control" placeholder="title" value = "<?php if(isset($_POST['danhmucbv'])){echo $_POST['danhmucbv'];} ?>">
				<?php if(isset($errors) && in_array('danhmucbv',$errors)){
					echo "<p style='color:red;'>*bạn chưa nhập title cho danh mục bài biết ! </p>";
				} ?>
			</div>
			<div class="form-group">
				<label>Danh mục cha</label>
				<?php selectCtrl('parent','parent') ?>
			</div>
			<div class="form-group">
				<label style="display: block;">Menu</label>
				<label class="radio-inline"><input type="radio" checked="checked" name="menu" value="1">Hiển Thị</label>
				<label class="radio-inline"><input type="radio" name="menu" value="0">Không Hiển Thị</label>
			</div>
			<div class="form-group">
				<label style="display: block;">Home</label>
				<label class="radio-inline"><input type="radio" checked="checked" name="home" value="1">Hiển Thị</label>
				<label class="radio-inline"><input type="radio" name="home" value="0">Không Hiển Thị</label>
			</div>
			<div class="form-group">
				<label>Thứ Tự</label>
				<input type="text" name="ordernum" class="form-control" placeholder="thứ tự" value="<?php if(isset($_POST['ordernum'])){ echo $_POST['ordernum'];} ?>">
			</div>
			<div class="form-group">
				<label style="display: block;">Trạng Thái</label>
				<label class="radio-inline"><input type="radio" checked="checked" name="status" value="1">Hiển Thị</label>
				<label class="radio-inline"><input type="radio" name="status" value="0">Không Hiển Thị</label>
			</div>
			<div>
				<input type="submit" name="submit" class="btn btn-primary" value="submit">
			</div>
		</div>
	</form>
	<?php include "includes/footer.php"; ?>