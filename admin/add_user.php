<?php
include "includes/header.php";
include "../connect/mysql.php";
include "../connect/function.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
	$errors= array();
	if(empty($_POST['user'])){
		$errors[] ='user';

	}else {
		$user = $_POST['user'];
	}

	if(empty($_POST['pass'])){
		$errors[]= 'pass';
	}else{
		//hàm trim() dùng để cắt khoảng trắng
		//hàm md5() dùng để mã hóa mật khẩu
		$pass= trim($_POST['pass']);
	}
	if(trim($_POST['pass'])!=trim($_POST['repass'])){
		$errors[]='repass';
	}

	if(empty($_POST['hoten'])){
		$errors[] = 'hoten';
	}else {
		$hoten = $_POST['hoten'];
	}

	if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)== TRUE){
		$email = mysqli_real_escape_string($conn,$_POST['email']);
	}else{
		$errors[] ='email';
	}
	$dienthoai= $_POST['dienthoai'];
	$diachi =$_POST['diachi'];
	$status = $_POST['status'];

	if(empty($errors)){
		$query1 ="SELECT taikhoan FROM tbluser WHERE taikhoan = '{$user}'";
		$result_tk= mysqli_query($conn,$query1);
		kt_query($result_tk,$query1);
		$query2= "SELECT email FROM tbluser WHERE email = '{$email}'";
		$result_email = mysqli_query($conn,$query2);
		kt_query($result_email,$query2);
		// kiểm tra xem tài khoản  đã tồn tại trên hệ thông hay chưa
		if(mysqli_num_rows($result_tk)==1)
		{
			$message = "<p style='color: blue;'> tài khoản này đã tồn tại trên hệ thông</p>";
		}
		// kiểm tra xem email  đã tồn tại trên hệ thông hay chưa
		elseif(mysqli_num_rows($result_email)==1)
		{
			$message = "<p style='color: blue;'> email này đã tồn tại trên hệ thông</p>";
		}
		else{
			$query3 = " INSERT INTO tbluser(taikhoan,matkhau,hoten,dienthoai,email,diachi,status) VALUES('{$user}','{$pass}','{$hoten}','{$dienthoai}','{$email}','{$diachi}',{$status})";
			$result = mysqli_query($conn,$query3);
			kt_query($result,$query3);

		// kiểm tra xem ínsert có thành công hay không
			if(mysqli_affected_rows($conn==1)){
				$message = '<p style ="color:blue;">thêm mới tài khoản thành công</p>';
			}
			else {
				$message = '<p style="color: blue;">thêm mới không thành công </p>';
			}
		}
		$user ='';
		$pass= '';
		$hoten='';
		$email='';
		$diachi='';
		$dienthoai='';
	}else{
		$message = '<p style="color:red;">bạn cần nhập đầy đủ thông tin hoặc thông tin bạn nhập chưa chính xác</p>';
	}
	echo $message;
}
?>

<form method="post">
	<h3>Thêm User</h3>
	<div class="form-group">
		<label for="">Tài khoản</label>
		<input value="<?php if (isset($_POST['user'])) {echo $_POST['user'];}?>" type="text" name="user" class='form-control' placeholder="tài khoản">
		<?php
// check if in array have contais tile
		if (isset($errors) && in_array('user', $errors)) {
			echo "<p style= 'color:red;'>*you needs enter a name </p>";
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Mật Khẩu</label>
		<input value='<?php if(isset($_POST['pass'])){echo $_POST['pass'];} ?>' type="text" name="pass" class="form-control" placeholder="mật khẩu">
		<?php if(isset($errors)&& in_array('pass',$errors)){
			echo '<p style= "color:red;">*you needs enter pass</p>';
		} ?>

	</div>

	<div class="form-group">
		<label for="">Xác Nhận Mật Khẩu</label>
		<input value='<?php if(isset($_POST['repass'])){echo $_POST['repass'];} ?>' type="text" name="repass" class="form-control" placeholder="xác nhận mật khẩu">
		<?php if(isset($errors)&& in_array('repass',$errors)){
			echo '<p style= "color:red;">*you need to enter new password like the old password</p>';
		} ?>

	</div>
	<div class="form-group">
		<label for="">Họ Tên</label>
		<input type="text" name="hoten" class='form-control' placeholder="họ tên"
		value='<?php if(isset($_POST['hoten'])){echo $_POST['hoten'];} ?>'>
		<?php
// check if in array have contains hoten
		if (isset($errors) && in_array('hoten', $errors)) {
			echo '<p style= "color: red;">*you needs enter hoten</p>';
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Điện thoại</label>
		<input type="text" name="dienthoai" class='form-control' placeholder="dienthoai"
		value="<?php if(isset($_POST['dienthoai'])){echo $_POST['dienthoai'];} ?>">
	</div>
	<div class="form-group">
		<label for="">Email</label>
		<input type="text" name="email" class='form-control' placeholder="email"
		value='<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>'>
		<?php 
		if(isset($errors)&&in_array('email',$errors)){
			echo '<p style= "color: red;">*email định dạng không đúng</p>';
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Địa Chỉ</label>
		<input type="text" name="diachi" class='form-control' placeholder="diachi"
		value='<?php if(isset($_POST['diachi'])){echo $_POST['diachi'];} ?>'>
	</div>
	<div class='form-group'>
		<label style="display: block;">Trạng Thái</label>
		<label class="radio-inline"><input checked="checked" type="radio" name='status' value="1">Kích Hoạt</label>
		<label class='radio-inline'><input type="radio" name='status' value="0">Chưa kích hoạt</label>
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Thêm mới</button>
</form>
<?php
include "includes/footer.php";
?>