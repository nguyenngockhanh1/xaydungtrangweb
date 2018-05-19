<?php
//kiểm tra hàm trả về có đúng hay là không
function kt_query($results, $query) {
	global $conn;
	if (!$results) {
		die('ERROR QUERY {$query} <br> MYSQL ERROR'.mysqli_error($conn));
	}
}

//function đê quy danh mục
function show_categories($parent_id ="0",$insert_text=""){
	global $conn;
	$query_danhmucbv= "SELECT * FROM tbldanhmucbaiviet WHERE parent_id = '{$parent_id}' ORDER BY parent_id";
	$categories = mysqli_query($conn,$query_danhmucbv);
	// kt_query($categories,$query_danhmucbv);
	while($category =mysqli_fetch_array($categories,MYSQLI_ASSOC)){
		echo ("<option value=' ".$category['id'] ." '>". $insert_text.$category['danhmucbaiviet']."</option>");
		//chính nó gọi là nó - gọi là hàm đệ quy
		show_categories($category['id'],$insert_text.'-');
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
		}
		else{
			echo "<ul class='sub_menu'>";
		}
		foreach ($cate_child as $key => $item) {
			echo "<li ><a href='#'>".$item['danhmucbaiviet']."</a>";
			menu_dacap($item['id'],++$count);
			echo "</li>";
		}
		echo "</ul>";
	}
}
?>