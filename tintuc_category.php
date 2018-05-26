<?php 
session_start();
if(isset($_GET['dm'])&&filter_var($_GET['dm'],FILTER_VALIDATE_INT,array('min_range'=>1))){
	$dm=$_GET['dm'];

	include "includes/header.php";
	include "includes/slider.php";

	$query_dm = "SELECT id,danhmucbaiviet FROM tbldanhmucbaiviet WHERE id={$dm}";
	$result_dm = mysqli_query($conn,$query_dm);
	kt_query($result_dm,$query_dm);
	$dm_info = mysqli_fetch_assoc($result_dm);

	if(mysqli_num_rows($result_dm)==1){
		list($id,$dmbv)= mysqli_fetch_array($result_dm,MYSQLI_NUM);
		$_SESSION['id'] = $id;
		$_SESSION['dmbv'] = $dmbv;
	}
	?>
	<div class="row col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<?php include "includes/left.php"; ?>
		<div class="col-lg-9 col-sm-9 col-xs-9 col-md-9" id="center">
			<div class="box_center">
				<div class="box_center_top">
					<div class="box_center_top_l">
						<a href="tintuc_category.php?dm=<?php echo $dm_info['id']; ?>" title="<?php echo $dm_info['danhmucbaiviet']; ?>"><?php echo $dm_info['danhmucbaiviet']; ?></a>
					</div>
					<div class="box_center_top_r"></div>
					<div class="clearfix"></div>
				</div>
				<div class="box_center_main">
					<?php
						// đặt số bản ghi cần hiển thị
					$limit = 4;
						//xác địng vị trí bắt đầu
					if(isset($_GET['s'])&&filter_var($_GET['s'],FILTER_VALIDATE_INT,array('min_range'=>1))){
						$start = $_GET['s'];
					}else{
						$start =0;
					}
					if(isset($_GET['p'])&&filter_var($_GET['p'],FILTER_VALIDATE_INT,array('min_range'=>1))){
						$per_page = $_GET['p'];
					}else{
							// nếu p không có thì sẽ truy vấn cơ sở dữ liệu để tìm xem có bao nhiêu page
						$query_page= "SELECT count(id) FROM tblbaiviet WHERE danhmucbaiviet ='{$dm}' ";
						$result_page =mysqli_query($conn,$query_page);
						kt_query($result_page,$query_page);
							//$ record dùng để đếm số bản ghi có trong tblbaiviet
						list($record)=mysqli_fetch_array($result_page,MYSQLI_NUM);
						if($record > $limit){
							$per_page= ceil($record/$limit);
						}else{
							$per_page= 1;
						}
					}
					$query_dmbv= "SELECT * FROM tblbaiviet WHERE danhmucbaiviet ={$dm} ORDER BY id DESC LIMIT $start,$limit";
					$result_dmbv= mysqli_query($conn,$query_dmbv);
					kt_query($result_dmbv,$query_dmbv);
					while ($baiviet = mysqli_fetch_array($result_dmbv,MYSQLI_ASSOC)) {
						?>
						<div class="row">	
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<a  href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" class="tintuc_img"><img src="<?php echo $baiviet['hinhanh']; ?>" alt="anh"></a>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<a href="baivietchitiet.php?id=<?php echo $baiviet['id']; ?>" class=""><?php echo $baiviet['title'] ;?></a>
								<p><?php echo $baiviet['tomtat']; ?></p> 
							</div>

							<div class="clearfix"></div>
						</div>
						<?php
					}
					echo "<ul class='pagination'>";
					//kiểm tra xem số trang mà lớn hơn một thì ta mới hiển thị ra tính năng phân trang
					if($per_page >1){
						$current_page = ($start/$limit) +1;
							//nếu không phải trang đầu thì hiển thị nút back
						if($current_page!=1){
							echo "<li><a href='tintuc_category.php?dm=".$dm."&s=".($start-$limit)."&p=".$per_page."'>back</a></li>";
						}
						for($i=1;$i<=$per_page;$i++){
							if($i!=$current_page){
								echo "<li><a href='tintuc_category.php?dm=".$dm."&s=".($limit*($i-1))."&p={$per_page}'>{$i}</a></li>";
							}
							else{
								echo " <li class='active'><a>{$i}</a></li>";
							}
						}
				//nếu không phải trang cuối thì hiển thị nút next
						if($current_page!=$per_page){
							echo "<li><a href='tintuc_category.php?dm=".$dm."&s=".($start+$limit)."&p={$per_page}'>Next</a></li>";
						}
					}
					echo "</ul>";
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php
}else
{
	header("Location: index.php");
	exit();
}
include "includes/footer.php";
?>