<?php 
include "includes/header.php";
include "includes/sidebar.php";
include "../connect/mysql.php";
include "../connect/function.php";
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Danh mục bài viết</h3>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Danh Mục Bài Viết( Menu)</th>
					<th>Trạng Thái</th>
					<th>Update</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$query_list_dm= "SELECT * FROM tbldanhmucbaiviet ORDER BY ordernum DESC";
				$result_dm = mysqli_query($conn,$query_list_dm);
				kt_query($result_dm,$query_list_dm);
				while($list_dmbv = mysqli_fetch_array($result_dm,MYSQLI_ASSOC)){
					?>
					<tr>
						<td><?php echo $list_dmbv['danhmucbaiviet']; ?></td>
						<td><?php if($list_dmbv['status']==1){ echo "Hiển Thị"; }else{echo "Không HIển Thị";} ?></td>
						<td><a href="edit_dmbv.php?id=<?php echo $list_dmbv['id']; ?>"><img width="30px" src="../images/icon_update.jpeg" alt="update"></a></td>
						<td><a href="delete_dmbv.php?id=<?php echo $list_dmbv['id']; ?>"><img width="30px" src="../images/delete.png" alt="delete"></a></td>
					</tr>
					<?php
				}

				?>
			</tbody>
		</table>
	</div>
</div>
<?php include "includes/footer.php"; ?>