<?php
// kiểm tra xem id có hợp lệ hay không
if($_GET['id']&&filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
	$id = $_GET['id'];
	include "includes/header.php";
	include "includes/slider.php";
	//lấy dữ liệu từ bảng tblbaiviet
	$query_chitiet= "SELECT * FROM tblbaiviet WHERE id = {$id}";
	$result_chitiet = mysqli_query($conn,$query_chitiet);
	kt_query($result_chitiet,$query_chitiet);
	$chitiet_info = mysqli_fetch_assoc($result_chitiet);

	$view = $chitiet_info['view'] +1;
	$query_view = "UPDATE tblbaiviet SET view = {$view} WHERE id= {$id}";
	$result_view = mysqli_query($conn,$query_view);
	kt_query($result_view,$query_view);

	$query_after_update= "SELECT * FROM tblbaiviet WHERE id= {$id}";
	$result_after_update =mysqli_query($conn,$query_after_update);
	kt_query($result_after_update,$query_after_update);
	$after_update_info = mysqli_fetch_assoc($result_after_update);



	//lấy dữ liệu từ bảng tbldanhmucbaiviet
	$query_dmbv ="SELECT id,danhmucbaiviet FROM tbldanhmucbaiviet WHERE id = {$chitiet_info['danhmucbaiviet']}";
	$result_dmbv =mysqli_query($conn,$query_dmbv);
	kt_query($result_dmbv,$query_dmbv);
	//hiển thị dữ liệu một dòng thì dùng msqli_fetch_assoc
	//hiển thị nhiều dòng thì dùng vòng lặp while and hàm mysqli_fetch_array
	$dmbv_info= mysqli_fetch_assoc($result_dmbv);
	?>
	<div class="row container" style="padding-bottom:10px;">
		<?php include "includes/left.php"; ?>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="center">
			<div class="box_center col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding-left: 3px !important;">
				<div class="box_center_top">
					<div class="box_center_top_l"><a href="tintuc_category.php?dm=<?php echo $dmbv_info['id']; ?>" title="<?php echo $dmbv_info['danhmucbaiviet']; ?>"><?php echo $dmbv_info['danhmucbaiviet']; ?></a></div>
					<div class="box_center_top_r"></div>
					<div class="clearfix"></div>
				</div>

				<div class="box_center_main">
					<ol class="breadcrumb">
						<li>
							<a href="<?php echo BASE_URL ?>" title= "trang chủ"><i class="glyphicon glyphicon-home"></i></a>
						</li>
						<li>
							<a href="tintuc_category.php?dm=<?php echo $dmbv_info['id']; ?>"  title="<?php echo $dmbv_info['danhmucbaiviet']; ?>"><?php echo $dmbv_info['danhmucbaiviet']; ?></a>
						</li>
						<li class="active"><?php echo $chitiet_info['title']; ?></li>
					</ol>
					<div class="baiviet_ct">
						<h1><?php if(isset($chitiet_info['title'])){echo $chitiet_info['title'];} ?></h1>
						<div id="time">
							<?php
							$ngaydang = explode('-',$chitiet_info['ngaydang']);
							$ngaydang_vn = $ngaydang[2].'-'.$ngaydang[1].'-'.$ngaydang[0];
							?>
							<span style='color: #5b5b5b;font-size:13px;margin:bottom:15px;'>Ngày Đăng: <?php echo $ngaydang_vn." | ".$chitiet_info['giodang']." | ".$after_update_info['view']." lượt xem"; ?></span>
						</div>
						<hr>
						<div class="p" style= "margin-top: 20px;">
							<?php if($chitiet_info['noidung']){echo $chitiet_info['noidung'];} ?>
						</div>
						<div class="tin_row">
							<p>Tin liên quan</p>
							<ul>
								<?php 
								$query_lq= "SELECT * FROM tblbaiviet WHERE id != {$chitiet_info['id']} 
								AND danhmucbaiviet = {$chitiet_info['danhmucbaiviet']} ORDER BY ordernum DESC LIMIT 0,4";
								$result_lq =mysqli_query($conn,$query_lq);
								kt_query($result_lq,$query_lq);
								while($tin_lq = mysqli_fetch_array($result_lq,MYSQLI_ASSOC)){
									?>
									<li><a href="baivietchitiet.php?id=<?php echo $tin_lq['id']; ?>" title="<?php echo $tin_lq['title']; ?>"><?php echo $tin_lq['title']; ?></a></li>
									<?php
								}
								?>
							</ul>
						</div>
						<div class="tin_xemnhieu tin_row">
							<p>Tin xem nhiều</p>
							<ul>
								<?php 
								$query_xn = "SELECT * FROM tblbaiviet ORDER BY view DESC LIMIT 0,4";
								$result_xn = mysqli_query($conn,$query_xn);
								kt_query($result_xn,$query_xn);
								while($tin_xn = mysqli_fetch_array($result_xn,MYSQLI_ASSOC)){
									?>
									<li><a href="baivietchitiet.php?id=<?php echo $tin_xn['id']; ?>" title="<?php echo $tin_xn['title']; ?>"><?php echo $tin_xn['title']; ?></a></li>
									<?php
								}
								?>
							</ul>
						</div>
						<div class="tin_row">
							<p>Tin ngẫu nhiên</p>
							<ul>
								<?php 
								// hàm rand() dùng để hiển thị ngẫu nhiên một bản ghi;
								$query_random = "SELECT * FROM tblbaiviet ORDER BY rand() LIMIT 0,4";
								$result_random = mysqli_query($conn,$query_random);
								kt_query($result_random,$query_random);
								while($tin_random = mysqli_fetch_array($result_random,MYSQLI_ASSOC)){
									?>
									<li><a href="baivietchitiet.php?id=<?php echo $tin_random['id']; ?>" title="<?php echo $tin_random['title']; ?>"><?php echo $tin_random['title']; ?></a></li>
									<?php 
								}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
<?php
include "includes/footer.php";
}else{
	header("Location:tintuc_category.php");
	exit();
}
?>

