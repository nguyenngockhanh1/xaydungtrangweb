<?php 
include "includes/header.php";
include "includes/sidebar.php";
include "../connect/mysql.php";
include "../connect/function.php";
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Danh sách bài viết</h3>
		<table class='table table-hover'>
			<thead>
				<tr>
					<th>Title</th>
					<th>Tóm Tắt</th>
					<th>Hình ảnh</th>
					<th>Ngày Đăng</th>
					<th>Giờ Đăng</th>
					<th>Thứ Tự</th>
					<th>Trạng Thái</th>
					<th>Update</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$limit = 4;
				if(isset($_GET['s'])&&filter_var($_GET['s'],FILTER_VALIDATE_INT,array('min_range'=>1))){
					$start = $_GET['s'];
				}
				else{
					//nếu không phải thì mặc định sẽ là trang đầu tiên
					$start = 0;
				}
				if(isset($_GET['p'])&& filter_var($_GET['p'],FILTER_VALIDATE_INT,array('min_range'=>1))){
					$per_page = $_GET['p'];
				}else{
					//nếu không phải thì truy vấn cơ sở dữ liệu để kiểm tra số trang
					$query_perpage = "SELECT COUNT(id) FROM tblbaiviet";
					$result_perpage = mysqli_query($conn,$query_perpage);
					kt_query($result_perpage,$query_perpage);
					list($record) = mysqli_fetch_array($result_perpage,MYSQLI_NUM);
					//record là số bản ghi đếm được trong dâtabbase
					if($record > $limit){
						// nếu số bản ghi lớn hơn thì ta lấy $record / $limit rồi làm tròn bằng hàm ceil
						$per_page = ceil($record / $limit);
					}else{
						//nếu không lớn hơn thì mặc định số trang sẽ là 
						$per_page = 1;
					}
				}
				?>
				<?php
				//start dùng để xác định số bản ghi bắt đầu
				$query_list_baiviet = "SELECT * FROM tblbaiviet ORDER BY ordernum DESC LIMIT {$start},{$limit}";
				$result_list_baiviet = mysqli_query($conn,$query_list_baiviet);
				kt_query($result_list_baiviet,$query_list_baiviet);
				while($baiviet = mysqli_fetch_array($result_list_baiviet,MYSQLI_ASSOC)){
					?>
					<tr>
						<td><?php echo $baiviet['title']; ?></td>
						<td><?php echo $baiviet['tomtat'];?></td>
						<td><img width="100px;" src="<?php echo '../'.$baiviet['hinhanh']; ?>" alt=""></td>
						<td><?php echo $baiviet['ngaydang'];?></td>
						<td><?php echo $baiviet['giodang'];?></td>
						<td><?php echo $baiviet['ordernum'];?></td>
						<td><?php if(isset($baiviet['status'])==1){echo "Hiển Thị" ;}else{echo "Không Hiển Thị ";}?></td>
						<td><a href="edit_baiviet.php?id=<?php echo $baiviet['id']; ?>"><img width="30px" src="../images/icon_update.jpeg" alt="update"></a></td>
						<td><a href="delete_baiviet.php?id=<?php echo $baiviet['id'];?>"><img width="30px" src="../images/delete.png" alt="delete"></a></td>
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
		<?php
		echo "<ul class='pagination'>";
				//kiểm tra xem số trang mà lớn hơn một thì ta mới hiển thị ra tính năng phân trang
		if($per_page >1){
					// $current_page  là trang hiện hành
			$current_page = $start/$limit +1;
					//nếu không phải trang đầu tiên thì hiển thị nút trở về
			if($current_page !=1){
				echo "<li><a href= 'list_baiviet.php?s=".($start- $limit)."&p={$per_page}'>Back</a></li>";
			}
					//hiển thị những phần còn lại của trang
			for($i=1;$i<=$per_page;$i++){
						//nếu $i không phải trang hiện tại
				if($i != $current_page){
					echo "<li><a href= 'list_baiviet.php?s=".($limit*($i-1))."&p={$per_page}'>{$i}</a></li>";
				}else{	
					echo "<li class='active'><a>{$i}</a></li>";
				}
			}
					//nếu không phải trang cuối thì hiển thị nút next
			if($current_page!= $per_page){
				echo "<li><a href='list_baiviet.php?s=".($start +$limit)."&p = {$per_page}'>Next</a></li>";
			}
		}
		echo "</ul>";
		?>	
	</div>
</div>

<?php include "includes/footer.php"; ?>