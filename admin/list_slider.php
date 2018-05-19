<?php include 'includes/header.php';?>
<?php include '../connect/mysql.php';?>
<?php include '../connect/function.php';?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Danh sách slider</h3>
		<table style='background: #fff;' class='table table-hover'>
			<thead>
				<tr>
					<th>Id</th>
					<th>Title</th>
					<th>Ảnh</th>
					<th>Link</th>
					<th>Thứ Tự</th>
					<th>Trạng Thái</th>
					<th>Update</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query   = "SELECT * FROM tblslider ORDER BY ordernum";
				$results = mysqli_query($conn, $query);
				kt_query($results, $query);
// ĐƯA ra một mảng với các chỉ số là tên trường
				while ($slider = mysqli_fetch_array($results, MYSQL_ASSOC)) {
					?>
					<tr>
						<td><?php echo $slider['id'];?></td>
						<td><?php echo $slider['title'];?></td>
						<td><img width="100px;" src="<?php echo $slider['anh'];?>"/></td>
						<td><?php echo $slider['link'];?></td>
						<td><?php echo $slider['ordernum'];?></td>
						<td><?php if ($slider['status'] == 1) {
							echo "Hiển Thị";
						} else {
							echo "Không Hiển Thị";
						}
						?></td>
						<td><a href="edit_slider.php?id=<?php echo $slider['id'];?>"><img style='margin: 0 auto; display: block;' src="../images/icon_update.jpeg" alt="icon_update" width= '20px'></a></td>
						<td><a onclick="return confirm('bạn có thật sự muốn xóa không')" href='delete_slider.php?id= <?php echo $slider['id'];?>'><img style='margin: 0 auto; display: block;' src="../images/delete.png" alt="icon_delete" width= '20px'></a></td>
					</tr>
					<?php
				}?>
			</tbody>
		</table>
	</div>
</div>
<?php include 'includes/footer.php';?>