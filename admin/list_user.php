<?php include 'includes/header.php' ;
include '../connect/mysql.php';
include '../connect/function.php';
?>
<div class='row'>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Danh Sách Tài Khoản</h3>
		<table class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Tài Khoản</th>
					<th>Điện Thoại</th>
					<th>Họ Tên</th>
					<th>Email</th>
					<th>Trạng Thái</th>
					<th>Update</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//limit dùng để lấy ra số bản ghi trên một page
				//đặt số bản ghi cần hiển thị
				$limit =1;
				//xác định vị trị bắt đầu nếu nó tồn tại và nó là kiểu số
				if(isset($_GET['s'])&& filter_var($_GET['s'],FILTER_VALIDATE_INT,array('min_range'=>1))){
					$start = $_GET['s'];
				}
				//nếu không phải kiểu số thì mặc định nó sẽ là trang đầu
				else{
					// đang nằm ở trang đầu tiên
					$start = 0;
				}

				if(isset($_GET['p'])&& filter_var($_GET['p'],FILTER_VALIDATE_INT,array('min_range'=>1))){
					//$per_page là số trang hiển thị
					$per_page = $_GET['p'];
				}else{
					// nếu p không có thì sẽ truy vấn cơ sở dữ liệu đẻ xem có bao nhiêu page
					$query_pg= " SELECT COUNT(id) FROM tbluser ";
					$result_pg =mysqli_query($conn,$query_pg);
					kt_query($result_pg,$query_pg);
					// record là số bản ghi đếm dc trong cơ sở dữ liệu
					list($record)= mysqli_fetch_array($result_pg,MYSQLI_NUM);
					//tìm số trang bằng cách chia số dữ liệu cho limit
					if($record>$limit){
						// dùng hàm ceil để làm tròn lên vd : 3.2 thành 4
						$per_page= ceil($record/$limit);
					}else {
						//nếu số bản ghi mà nhỏ hơn limit thì
						$per_page =1;
					}
				}
				// start dùng để xác nhận số bản ghi bắt đầu
				
				$query = "SELECT * FROM tbluser ORDER BY id LIMIT {$start},{$limit}";
				$result = mysqli_query($conn,$query);
				kt_query($result,$query);
				while($user = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					?>
					<tr>
						<td><?php echo $user['id']; ?></td>
						<td><?php echo $user['taikhoan']; ?></td>
						<td><?php echo $user['dienthoai']; ?></td>
						<td><?php echo $user['hoten']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<td><?php if($user['status']==1){
							echo 'kích hoạt';
						}else {
							echo 'chưa kích hoạt';
						} 
						?></td>
						<td><a href="edit_user.php?id=<?php echo $user['id'];?>"><img style='margin: 0 auto; display: block;' src="../images/icon_update.jpeg" alt="icon_update" width= '20px'></a></td>
						<td><a onclick="return confirm('bạn có thật sự muốn xóa không')" href='delete_user.php?id= <?php echo $user['id'];?>'><img style='margin: 0 auto; display: block;' src="../images/delete.png" alt="icon_delete" width= '20px'></a></td>
					</tr>
					<?php

				}
				?>
			</tbody>
		</table>
		
			<?php 
			echo '<ul class="pagination">';
			//kiểm tra xem số trang mà lớn hơn một thì ta mới hiển thị ra tính năng phân trang
			if($per_page >1){
				$current_page = $start/$limit +1;
				// nếu không phải trang đầu thì hiển thị trang trước 
				if($current_page !=1){
	
					echo "<li><a href='list_user.php?s=".($start-$limit)."&p={$per_page}'>Back</a></li>";
				}

				//hiển thị những phần còn lại của trang
				for($i=1;$i<=$per_page;$i++){
					if($i!=$current_page){
						echo "<li><a href='list_user.php?s=".($limit*($i-1))."&p={$per_page}'>{$i}</a></li>";
					}
					else{
						echo " <li class='active'><a>{$i}</a></li>";
					}
				}
				//nếu không phải trang cuối thì hiển thị nút next
				if($current_page!=$per_page){
					echo "<li><a href='list_user.php?s=".($start+$limit)."&p={$per_page}'>Next</a></li>";
				}
			}
			echo '</ul>';
			?>
	</div>
</div>


<?php include 'includes/footer.php'; ?>