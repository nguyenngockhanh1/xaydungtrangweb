<?php include 'includes/header.php';
include 'includes/slider.php';
?>
<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<?php include "includes/left.php"; ?>
	<div class="col-lg-9 col-sm-9 col-xs-9 col-md-9" id="center">
		<div class="box_center">
			<div class="box_center_top">
				<div class="box_center_top_l"><span>Tìm Kiếm</span></div>
				<div class="box_center_top_r"></div>
				<div class="clearfix"></div>
			</div>
			<div class="box_center_main">
				<br>
				<?php 
				if(isset($_REQUEST['submit'])){
					$search =$_GET['ten'];
					if(empty($search)){
						echo "<span style='color: red;'> Yêu cầu nhập dữ liệu vào ô trống! </span>";
					}
					else{
						$query_search = "SELECT * FROM tblbaiviet  WHERE title like '%$search%'";
						$result_search = mysqli_query($conn,$query_search);
						kt_query($result_search,$query_search);
						// nếu không có bài viết nào phù hợp với dữ liệu tìm kiếm
						if(mysqli_num_rows($result_search)<1)
						{
							 echo "<p style='color: red;'>Không tìm thấy từ khóa ($search)</p>";
						}
						while($search_tt= mysqli_fetch_array($result_search,MYSQLI_ASSOC)){
							?>
							<div class="row">	
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
									<a  href="baivietchitiet.php?id=<?php echo $search_tt['id']; ?>" class="tintuc_img"><img src="<?php echo $search_tt['hinhanh']; ?>" alt="anh"></a>
								</div>
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
									<a href="baivietchitiet.php?id=<?php echo $search_tt['id']; ?>" class=""><?php echo $search_tt['title'] ;?></a>
									<p><?php echo $search_tt['tomtat']; ?></p> 
								</div>

								<div class="clearfix"></div>
							</div>
							<?php
						}
					}
				}
				?>
			</div>
		</div>
	</div>
</div>	
<?php
include 'includes/footer.php';
?>