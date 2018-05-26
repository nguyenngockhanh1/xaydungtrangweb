<?php include "includes/header.php"; ?>
<?php include "includes/sidebar.php";?>
<?php include "../connect/mysql.php"; ?>
<?php include "../connect/function.php"; ?>
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	$error= array();
	if($_POST['parent']==0){
		$parent_id= 0;
	}else{
		$parent_id= $_POST['parent'];
	}

	if(empty($_POST['title'])){
		$error[] ='title';
	}else{
		$title= $_POST['title'];
	}
	$tomtat= $_POST['tomtat'];
	$noidung = $_POST['noidung'];
	$status = $_POST['status'];
	if(empty($_POST['ordernum'])){
		$ordernum = 0;
	}else{
		$ordernum = $_POST['ordernum'];
	}
	/*format for img*/
	if(($_FILES['img']['type']!="image/jpeg")&&
		($_FILES['img']['type']!="image/jpg")&&
		($_FILES['img']['type']!="image/gif")&&
		($_FILES['img']['type']!="image/png"))
	{
		$message_img ="file không đúng địng dạng";
		$error[] = "img";
	}
	elseif($_FILES['img']['size']>1000000){
		$message_img = "kích thước file quá lớn";
		$error[] = "img";
	}
	elseif($_FILES['img']['size']==0){
		$message_img ="bạn chưa chọn file ảnh";
		$error[] = "img";
	}else{
		$img= $_FILES['img']['name'];
		$img_address= "../upload/".$img;
		$file_tmp =$_FILES['img']['tmp_name'];
		$link_img ="upload/".$img;
		//hàm di chuyển ảnh vào thư mục upload
		move_uploaded_file($file_tmp,$img_address);
	}
	/*end img*/
	if(empty($error)){

	//định dạng ngày cho đúng với định dạng ngày quốc tế
	//ham explode dùng để cắt chuỗi ở trước và sau -
		$ngaydang_vn= explode('-',$_POST['ngaydang']);
		$ngaydang_qt= $ngaydang_vn[2].'-'.$ngaydang_vn[1].'-'.$ngaydang_vn[0];
		$giodang_qt = $_POST['giodang'];


	//tiến hành insert  vào trong database
		$query_baiviet= "INSERT INTO tblbaiviet(danhmucbaiviet,title,tomtat,noidung,hinhanh,ngaydang,giodang,ordernum,status)
		VALUES({$parent_id},
		'{$title}',
		'{$tomtat}',
		'{$noidung}',
		'{$link_img}',
		'{$ngaydang_qt}',
		'{$giodang_qt}',
		{$ordernum},
		{$status})";
		$result_baiviet = mysqli_query($conn,$query_baiviet);
		kt_query($result_baiviet,$query_baiviet);
	 //kiểm tra xem insert  có thành công hay không
		if(mysqli_affected_rows($conn)==1){
			$message = "Bạn đã thêm mới thành công";
			$_POST['title'] ='';
			$_POST['tomtat']= "";
			$_POST['noidung']='';
			$_POST['ordernum'] ='';
		}
		else{
			$message = "Thêm mới thất bại";
		}

	}else{
		$message= "bạn cần nhập đầy đủ thông tin";
	}
}
?>

<form method= "post" enctype="multipart/form-data">
	<?php if(isset($message)){echo "<p style='color:red;'>*$message</p>";} ?>
		<h3>Thêm Bài Viết</h3>
		<div class="form-group">
			<label style='display: block;'>Danh mục bài viết</label>
			<?php selectCtrl('parent' , 'parent'); ?>
		</div>
		<div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" name="title" placeholder="title"
			value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
			<?php if(isset($error)&&in_array('title',$error)){echo "<p style='color:red;'>*you need enter title for bài viết</p>";} ?>
			</div>
			<div class="form-group">
				<label style ="display: block;">Tóm Tắt</label>
				<textarea style="height:150px;" class="form-control" name="tomtat" value="<?php if(isset($_POST['tomtat'])){echo $_POST['tomtat'];} ?>"></textarea>
			</div>
			<div class="form-group">
				<label style ="display: block;">Nội Dung</label>
				<textarea id='noidung' style="height:150px;" class="form-control" name="noidung" value="<?php if(isset($_POST['noidung'])){echo $_POST['noidung'];} ?>"></textarea>
			</div>
			<div class="form-group">
				<label style ="display: block;">Ảnh Đại Diện</label>
				<input type="file" name="img" value="<?php if(isset($_POST['img'])){echo $_POST['img'];} ?>">
				<?php if(isset($message_img)){echo "<p style='color:red;'>*$message_img</p>";} ?>
				</div>
				<div class="form-group">
					<label style ="display: block;">Ngày Đăng</label>
					<div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
						<input type="text" readonly="true" class="form-control" name="ngaydang">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-calendar"></i>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label style ="display: block;">Giờ Đăng</label>
					<?php 
					date_default_timezone_get('Asia/Ho_Chi_Minh');
					$today = date('g:i A');
					?>
					<input class="form-control" type="text" name="giodang" value="<?php echo $today; ?>">
				</div>
				<div class="form-group">
					<label style ="display: block;">Thứ Tự</label>
					<input class="form-control" placeholder="thứ tự"  type="text" name="ordernum" value="<?php if(isset($_POST['ordernum'])){echo $_POST['ordernum'];} ?>">
				</div>
				<div class="form-group">
					<label style ="display: block;">Trạng Thái</label>
					<label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiển Thị</label>
					<label class="radio-inline"><input type="radio" name="status" value="0">Không Hiển Thị</label>
				</div>
				<div class="form-group">
					<input type="submit" name="submit" class="btn btn-primary" value="thêm mới">
				</div>
			</form>
			<?php include "includes/footer.php"; ?>