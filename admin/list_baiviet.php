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
					$query_list_baiviet = "SELECT * FROM tblbaiviet ORDER BY ordernum DESC";
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
	</div>
</div>

<?php include "includes/footer.php"; ?>