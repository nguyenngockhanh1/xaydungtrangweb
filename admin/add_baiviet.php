<?php include "includes/header.php"; ?>
<?php include "includes/sidebar.php";?>
<?php include "../connect/mysql.php"; ?>
<?php include "../connect/function.php"; ?>


<form method= "post">
	<h3>Thêm Bài Viết</h3>
	<div class="form-group">
		<label style='display: block;'>Danh mục bài viết</label>
		<?php selectCtrl('parent' , 'parent'); ?>
	</div>
	<div class="form-group">
		<label>Title</label>
		<input type="text" class="form-control" name="title" placeholder="title"
		value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
	</div>
	<div class="form-group">
		<label style ="display: block;">Tóm Tắt</label>
		<textarea style="height:150px;" class="form-control" name="tomtat" value="<?php if(isset($_POST['tomtat'])){echo $_POST['tomtat'];} ?>"></textarea>
	</div>
	<div class="form-group">
		<label style ="display: block;">Nội Dung</label>
		<textarea style="height:150px;" class="form-control" name="noidung" value="<?php if(isset($_POST['noidung'])){echo $_POST['noidung'];} ?>"></textarea>
	</div>
	<div class="form-group">
		<label style ="display: block;">Ảnh Đại Diện</label>
		<input type="file" name="img" value="<?php if(isset($_POST['img'])){echo $_POST['img'];} ?>">
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
</form>
<?php include "includes/footer.php"; ?>