<?php
//kiểm tra hàm trả về có đúng hay là không
function kt_query($results, $query) {
	global $conn;
	if (!$results) {
		die('ERROR QUERY {$query} <br> MYSQL ERROR'.mysqli_error($conn));
	}
}
?>