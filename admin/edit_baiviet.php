<?php 
ob_start();
include "includes/header.php";
include "includes/sidebar.php";
include "../connect/mysql.php"; 
include "../connect/function.php"; 
if(isset($_GET['id'])&&filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
	$id= $_GET['id'];
}else{
	header("Location:list_baiviet.php");
	exit();
}
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
	if(empty($_POST['ordernum'])){
		$ordernum = 0;
	}else{
		$ordernum = $_POST['ordernum'];
	}
	/*format for img*/
	if($_FILES['img']['size']==' '){
		$link_img =$_POST['anh_hidden'];
	}
	else{
		if(($_FILES['img']['type']!="image/jpeg")&&
			($_FILES['img']['type']!="image/jpg")&&
			($_FILES['img']['type']!="image/gif")&&
			($_FILES['img']['type']!="image/png"))
		{
			$message_img ="file không đúng địng dạng";
			$error = "img";
		}
		elseif($_FILES['img']['size']>1000000){
			$message_img = "kích thước file quá lớn";
			$error = "img";
		}
		elseif($_FILES['img']['size']==0){
			$message_img ="bạn chưa chọn file ảnh";
			$error = "img";
		}else{
			$img= $_FILES['img']['name'];
			$img_address= "../upload/".$img;
			$file_tmp =$_FILES['img']['tmp_name'];
			$link_img ="upload/".$img;
		//hàm di chuyển ảnh vào thư mục upload
			move_uploaded_file($file_tmp,$img_address);
		}
		/*end img*/
			// tiến hành xóa ảnh cũ sau khi cập nhật ảnh mới
		$query_delete_img="SELECT hinhanh FROM tblbaiviet WHERE id={$id}";
		$result_delete_img= mysqli_query($conn,$query_delete_img);
		kt_query($result_delete_img,$query_delete_img);
		$img_info= mysqli_fetch_assoc($result_delete_img);
		unlink("../".$img_info['hinhanh']);
	}
	$status = $_POST['status'];
	if(empty($error)){

	//định dạng ngày cho đúng với định dạng ngày quốc tế
	//ham explode dùng để cắt chuỗi ở trước và sau -
		$ngaydang_vn= explode('-',$_POST['ngaydang']);
		$ngaydang_qt= $ngaydang_vn[2].'-'.$ngaydang_vn[1].'-'.$ngaydang_vn[0];
		$giodang_qt = $_POST['giodang'];


	//tiến hành insert  vào trong database
		$query_update= "UPDATE tblbaiviet
		SET danhmucbaiviet={$parent_id},title='{$title}',tomtat='{$tomtat}',noidung='{$noidung}',
		hinhanh='{$link_img}',
		ngaydang='{$ngaydang_qt}',giodang='{$giodang_qt}',ordernum={$ordernum},status={$status}
		WHERE id={$id}";
		$result_update = mysqli_query($conn,$query_update);
		kt_query($result_update,$query_update);
	 //kiểm tra xem update  có thành công hay không
		if(mysqli_affected_rows($conn)==1){
			$message = "Bạn đã sửa thành công";
			//nếu update thành công thì tiến hàng xóa ảnh cũ trong thư mục update
		}
		else{
			$message = "Bạn chưa sửa gì";
		}

	}else{
		$message= "bạn cần nhập đầy đủ thông tin";
	}
}
$query_hienthi= "SELECT * FROM tblbaiviet WHERE id={$id}";
$result_hienthi = mysqli_query($conn,$query_hienthi);
kt_query($result_hienthi,$query_hienthi);
$hienthi_info = mysqli_fetch_assoc($result_hienthi);
?>

<form method= "post" enctype="multipart/form-data">
	<?php if(isset($message)){echo "<p style='color:red;'>*$message</p>";} ?>
		<h3>Sửa Bài Viết</h3>
		<div class="form-group">
			<label style='display: block;'>Danh mục bài viết</label>
			<?php selectCtrl('parent' ,'parent'); ?>

		</div>
		<div class="form-group">
			<label>Title</label>
			<input type="text" class="form-control" name="title" placeholder="title"
			value="<?php if(isset($hienthi_info['title'])){echo $hienthi_info['title'];} ?>">
			<?php if(isset($error)&&in_array('title',$error)){echo "<p style='color:red;'>*you need enter title for bài viết</p>";} ?>
			</div>
			<div class="form-group">
				<label style ="display: block;">Tóm Tắt</label>
				<textarea  style="height:150px;" class="form-control" name="tomtat" 
				value= "<?php if(isset($hienthi_info['tomtat'])){echo $hienthi_info['tomtat'];} ?>"><?php if(isset($hienthi_info['tomtat'])){echo $hienthi_info['tomtat'];} ?></textarea>
			</div>
			<div class="form-group">
				<label style ="display: block;">Nội Dung</label>
				<textarea id='noidung' style="height:150px;" class="form-control" name="noidung" value="<?php if(isset($hienthi_info['noidung'])){echo $hienthi_info['noidung'];} ?>"></textarea>
			</div>
			<div class="form-group">
				<label style ="display: block;">Ảnh Đại Diện</label>
				<input type="file" name="img"><br>
				<p style="color: green">Nếu không chọn ảnh mới thì mặc định sẽ lấy ảnh dưới</p>
				<input type="hidden" name="anh_hidden" value="<?php echo $hienthi_info['hinhanh']; ?>">
				<img width="200px" src="../<?php echo $hienthi_info['hinhanh']; ?>" alt="hinhanh">
				<?php if(isset($message_img)){echo "<p style='color:red;'>*$message_img</p>";} ?>
				</div>
				<div class="form-group">
					<label style ="display: block;">Ngày Đăng</label>
					<div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
						<input value =<?php echo $hienthi_info['ngaydang']; ?> type="text" readonly="true" class="form-control" name="ngaydang">
						<span class="input-group-addon">
							<i class="glyphicon glyphicon-calendar"></i>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label style ="display: block;">Giờ Đăng</label>
					<input class="form-control" type="text" name="giodang" value="<?php echo $hienthi_info['giodang']; ?>">
				</div>
				<div class="form-group">
					<label style ="display: block;">Thứ Tự</label>
					<input class="form-control" placeholder="thứ tự"  type="text" name="ordernum" value="<?php if(isset($hienthi_info['ordernum'])){echo $hienthi_info['ordernum'];} ?>">
				</div>
				<div class="form-group">
					<label style ="display: block;">Trạng Thái</label>
					<label class="radio-inline"><input checked="checked" type="radio" name="status" value="1">Hiển Thị</label>
					<label class="radio-inline"><input type="radio" name="status" value="0">Không Hiển Thị</label>
				</div>
				<div class="form-group">
					<input type="submit" name="submit" class="btn btn-primary" value="sửa">
				</div>
			</form>
			<?php
			include "includes/footer.php";
			ob_flush();
			?>