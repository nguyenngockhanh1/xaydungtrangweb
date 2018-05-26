<?php
define("BASE_URL", "http://localhost/xaydungweb/");

//kiểm tra hàm trả về có đúng hay là không
function kt_query($results, $query) {
	global $conn;
	if (!$results) {
		die('ERROR QUERY '.$query.' <br> MYSQL ERROR '.mysqli_error($conn));
	}
}

//function đê quy danh mục
function show_categories($parent_id ="0",$insert_text=""){
	global $conn;
	$query_danhmucbv= "SELECT * FROM tbldanhmucbaiviet WHERE parent_id = '{$parent_id}' ORDER BY parent_id";
	$categories = mysqli_query($conn,$query_danhmucbv);
	if(isset($_GET['id'])){
		$id= $_GET['id'];
		$query_bv= "SELECT * FROM tblbaiviet WHERE id = {$id}";
		$bv= mysqli_query($conn,$query_bv);
		kt_query($bv,$query_bv);
		$info = mysqli_fetch_assoc($bv);
		$dm = $info['danhmucbaiviet'];
	}
	while($category =mysqli_fetch_array($categories,MYSQLI_ASSOC)){
		// if($category['id']==$dm){
		// 	echo ("<option selected='selected' value=' ".$category['id'] ." '>". $insert_text.$category['danhmucbaiviet']."</option>");
		// //chính nó gọi là nó - gọi là hàm đệ quy
		// 	show_categories($category['id'],$insert_text.'-');
		// }
		// else{
			echo ("<option value=' ".$category['id'] ." '>". $insert_text.$category['danhmucbaiviet']."</option>");
		//chính nó gọi là nó - gọi là hàm đệ quy
			show_categories($category['id'],$insert_text.'-');
		//}
	}
	return true;
}
function selectCtrl($name,$class){
	global $conn;
	echo "<select name='".$name."' class= '".$class." ' >";
	echo "<option value ='0'>danh muc cha</option>";
	show_categories();
	echo "</select>";
}

function menu_dacap($parent_id=0,$count=0){
	global $conn;
	$cate_child= array();
	$query_dq_menu = "SELECT * FROM tbldanhmucbaiviet WHERE parent_id ='{$parent_id}' ";
	$result_menu =mysqli_query($conn,$query_dq_menu);
	while ($menu=mysqli_fetch_array($result_menu,MYSQLI_ASSOC)) {
		$cate_child[]= $menu;
	}
	// echo "<pre>";
	// print_r($cate_child);
	// echo "</pre>";
	if($cate_child){
		if($count == 0){
			echo "<ul id='menu_top'>";
			?>
			<li><a href="<?php echo BASE_URL ?>" title= "trang chủ"><span style="top:0px !important;padding-right:5px !important" class="glyphicon glyphicon-home"></span>Trang Chủ</a></li>;
			<?php
		}
		else{
			echo "<ul class='sub_menu'>";
		}
		foreach ($cate_child as $key => $item) {
			echo "<li ><a href='tintuc_category.php?dm=".$item['id']."'>".$item['danhmucbaiviet']."</a>";
			menu_dacap($item['id'],++$count);
			echo "</li>";
		}
		// if(count($cate_child) ==$count){
		// 	echo "<li><a href=''>Liên Hệ</a></li>";
		// }
		echo "</ul>";
	}
}
?>