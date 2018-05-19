<?php session_start();
if(isset($_SESSION['id_user'])){
    header('Location: index.php');
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>login</title>
	<link rel="stylesheet" href="">
	<!-- Bootstrap Core CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../css/sb-admin.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="../css/plugins/morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" type="text/css" href="../scss/style.css">
</head>
<body>
	<?php
	include '../connect/mysql.php';
	include '../connect/function.php';
	if($_SERVER['REQUEST_METHOD']== "POST"){
		$error = array();
		if(empty($_POST['user'])){
			$error[]= 'user';
		}else{
			$user= $_POST['user'];
		}

		if(empty($_POST['pass'])){
			$error[]= 'pass';
		}else{
			$pass=($_POST['pass']);
		}


		if(empty($error)){
			$query = "SELECT id,taikhoan,matkhau,status FROM tbluser WHERE taikhoan ='{$user}' AND matkhau = 
			'{$pass}'AND status =1";
			$result =mysqli_query($conn,$query);
			kt_query($result,$query);
			//nếu bằng 1 thì dữ liệu tồn tại trong database
			if(mysqli_num_rows($result)==1){
				list($id,$user,$pass,$status)= mysqli_fetch_array($result,MYSQLI_NUM);
				$_SESSION['id_user'] = $id;
				$_SESSION['taikhoan'] = $user;
				$_SESSION['matkhau'] = $pass;
				header('Location: index.php');
			}
			elseif (mysqli_affected_rows($conn) == 1) {
			$pass= '';
		} else {
				$message = '<p>tài khoản hoặc mật khẩu không đúng</p>';
			}
		}

	}
	 ?>
	<form method= "post" class="form-login">
		<table>
			<tr class="title"><td colspan="2">Đăng Nhập Hệ Thống</td></tr>
			<tr class=" user">
				<td class="input-group-addon"><span class='glyphicon glyphicon-user'></span></td>
				<td><input type="text" name="user" class="form-control" placeholder="user name"
				value ='<?php if(isset($_POST['user'])){ echo $_POST['user'];} ?>'></td>
			</tr>
			<tr class="warning" >
				<td colspan="2"> <?php if(isset($error) && in_array('user',$error)){ echo 'bạn cần nhập tài khoản' ; }?></td>
			</tr>
			<tr class="pass">
				<td class='input-group-addon'><span class='glyphicon glyphicon-lock'></span></td>
				<td><input type="password" name="pass" class="form-control" placeholder="******"
				value = "<?php if(isset($_POST['pass'])){echo $pass;} ?>"></td>
			</tr>
			<tr  class="warning" >
				<td colspan="2"> <?php if(isset($error)&& in_array('pass',$error)){echo 'bạn cần nhập mật khâu' ;} ?></td>
			</tr>
			<tr class="button"><td colspan="2" width="100%"><button class="btn btn-primary" type="submit">Thực Hiện</button></td></tr>
			<tr>
				<td colspan="2"><?php if(isset($message)){echo $message; }?></td>
			</tr>
		</table>
	</form>
</body>
</html>