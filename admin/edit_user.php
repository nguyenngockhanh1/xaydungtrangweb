<?php 
//khởi tạo bộ nhớ đệm
ob_start();
include "../connect/mysql.php";
include "../connect/function.php";
include "includes/header.php";
if(isset($_GET['id'])&& filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
	$id=$_GET['id'];
}else{
	header('Location: list_user.php');
	// nếu không tồn tại thì công việc sẽ không thực hiện tiếp , do đó chúng ta dùng hàm ẽxit để kết thúc
	exit();
}
if($_SERVER['REQUEST_METHOD']=='POST'){
	$errors= array();
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
			$query_update= "UPDATE tbluser
			SET hoten='{$hoten}', email = '{$email}', dienthoai = '{$dienthoai}', diachi ='{$diachi}', status ={$status}
			WHERE id= {$id}
			";
			$result_update = mysqli_query($conn,$query_update);
			kt_query($result_update,$query_update);

		// kiểm tra xem ínsert có thành công hay không
			if(mysqli_affected_rows($conn)==1){
				$message = '<p style ="color:blue;">sửa tài khoản thành công</p>';
			}
			else {
				$message = '<p style="color: blue;">bạn chưa sửa gì</p>';
			}
	}else{
		$message = '<p style="color:red;">bạn cần nhập đầy đủ thông tin hoặc thông tin bạn nhập chưa chính xác</p>';
	}
}
$query_id ="SELECT taikhoan,hoten,dienthoai,email,diachi,status FROM tbluser WHERE id={$id}";
$result_id= mysqli_query($conn,$query_id);
kt_query($result_id,$query_id);
	//kiểm tra xem id có tồn tại hay không
if(mysqli_num_rows($result_id)==1){
			//Hàm mysqli_fetch_array () tìm nạp hàng kết quả dưới dạng mảng kết hợp, mảng số hoặc cả hai.
	//list() được sử dụng để gán giá trị cho một danh sách biến trong một hoạt động
	list($user,$hoten,$dienthoai,$email,$diachi,$status)=mysqli_fetch_array($result_id,MYSQLI_NUM);
}
else{
	$message ="<p style='color:red;'>id không tồn tại </p>";
}
?>

<form method="post">
	<?php if(isset($message)){echo $message;} ?>
	<h3>Sửa User</h3>
	<div class="form-group">
		<label for="">Tài khoản</label>
		<input value="<?php if (isset($user)) {echo $user;}?>" type="text" name="user" class='form-control' placeholder="tài khoản" readonly='true'>
	</div>
	<div class="form-group">
		<label for="">Họ Tên</label>
		<input type="text" name="hoten" class='form-control' placeholder="họ tên"
		value='<?php if(isset($hoten)){echo $hoten;} ?>'>
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
		value="<?php if(isset($dienthoai)){echo $dienthoai;} ?>">
	</div>
	<div class="form-group">
		<label for="">Email</label>
		<input type="text" name="email" class='form-control' placeholder="email"
		value='<?php if(isset($email)){echo $email;} ?>'>
		<?php 
		if(isset($errors)&&in_array('email',$errors)){
			echo '<p style= "color: red;">*email định dạng không đúng</p>';
		}
		?>
	</div>
	<div class="form-group">
		<label for="">Địa Chỉ</label>
		<input type="text" name="diachi" class='form-control' placeholder="diachi"
		value='<?php if(isset($diachi)){echo $diachi;} ?>'>
	</div>
	<div class='form-group'>
		<label style="display: block;">Trạng Thái</label>
		<?php
		if(isset($status)==1)
		{
			?>
			<label class="radio-inline"><input checked="checked" type="radio" name='status' value="1">Kích Hoạt</label>
			<label class='radio-inline'><input type="radio" name='status' value="0">Chưa kích hoạt</label>
			<?php
		}
		else
		{
			?>
			<label class="radio-inline"><input type="radio" name='status' value="1">Kích Hoạt</label>
			<label class='radio-inline'><input checked="checked" type="radio" name='status' value="0">Chưa kích hoạt</label>
			<?php
		}
		?>
	</div>
	<button type="submit" name="submit" class="btn btn-primary">Sửa</button>
</form>
<?php
ob_flush();
include "includes/footer.php";
?>