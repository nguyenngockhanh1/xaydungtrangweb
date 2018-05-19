<?php
session_start();
//khởi tạo bộ nhớ đệm
ob_start();
include 'includes/header.php';
include '../connect/mysql.php';
include '../connect/function.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
	$matkhaucu = $_POST['old_pass'];
	$matkhaumoi =$_POST['new_pass'];
	$query = "SELECT id,matkhau FROM tbluser WHERE id={$_SESSION['id_user']} AND matkhau= '{$matkhaucu}'";
	$result = mysqli_query($conn,$query);
	kt_query($result,$query);
	//kiểm tra xem id có tồn tại trên hệ thống hay không
	if(mysqli_num_rows($result)==1){
		if(trim($_POST['new_pass'])!= trim($_POST['re_new_pass'])){
			$message ="<p style='color:red;'>*mật khẩu mới không trùng với mật khẩu cũ</p>";
		}else{
			$query_pass ="UPDATE tbluser SET matkhau= trim('{$matkhaumoi}') WHERE id={$_SESSION['id_user']}";
			$result_pass = mysqli_query($conn,$query_pass);
			kt_query($result_pass,$query_pass);
			//kiểm tra xem update có thành công hay không
			if(mysqli_affected_rows($result_pass)==1){
				$message ="<p style='color:blue;'>cập nhật mật khẩu thành công</p>";
			}
			else{
				$message ="<p style='color:blue;'>cập nhật mật khẩu không thành công</p>";
			}
		}
	}
	else{
		$message ="<p style='color:red;'>*mật khẩu cũ không đúng</p>";
	}
}
 ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<?php if(isset($message)){echo $message;} ?>
		<form method='post'>
			<h3>Đổi Mật Khẩu Cho</h3>
			<div class="form-group">
				<label>Tài Khoản</label>
				<input disabled="disabled" class='form-control' type="text" name="user" value='<?php echo  $_SESSION["taikhoan"] ;?>'>
			</div>
			<div class="form-group">
				<label>Mật Khẩu Cũ</label>
				<input class='form-control' type="text" name="old_pass" placeholder="mật khẩu cũ" 
				value='<?php if(isset($_POST["old_pass"])){echo $_POST["old_pass"];}?>'>
			</div>
			<div class="form-group">
				<label>Mật Khẩu Mới</label>
				<input class='form-control' type="text" name="new_pass" placeholder="mật khẩu mới"
				value="<?php if(isset($_POST['new_pass'])){echo $_POST['new_pass'];} ?>">
			</div>
			<div class="form-group">
				<label>Nhập Lại Mật Khẩu</label>
				<input class='form-control' type="text" name="re_new_pass" placeholder="nhập lại mật khẩu"
				value="<?php if(isset($_POST['re_new_pass'])){echo $_POST['re_new_pass'];} ?>">
			</div>
			<button type="submit" class='btn btn-primary'>Đổi</button>
		</form>
	</div>
</div>
 <?php include 'includes/footer.php'; 
ob_flush();
 ?>