<?php 
include "connect/mysql.php";
include "connect/function.php";
if(isset($_GET['dm'])&&filter_var($_GET['dm'],FILTER_VALIDATE_INT,array('min_range'=>1))){
  $dm= $_GET['dm'];
  $query_dm="SELECT * FROM tbldanhmucbaiviet WHERE id={$dm}";
  $result_dm = mysqli_query($conn,$query_dm);
  kt_query($result_dm,$query_dm);
  $dm_info= mysqli_fetch_assoc($result_dm);
}
if(isset($_GET['id'])&&filter_var($_GET['id'],FILTER_VALIDATE_INT,array('min_range'=>1))){
  $id= $_GET['id'];
  $query_title="SELECT * FROM tblbaiviet WHERE id={$id}";
  $result_title = mysqli_query($conn,$query_title);
  kt_query($result_title,$query_title);
  $title_info= mysqli_fetch_assoc($result_title);
}
if(isset($_GET['submit'])){
  $submit = $_GET['submit'];
}
if(empty($_GET['ten'])){
  $ten = '';
}else{
  $ten = ' | '.$_GET['ten'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>
    <?php 
    if(isset($dm_info['danhmucbaiviet'])){
      echo $dm_info['danhmucbaiviet'];
    }
    elseif(isset($title_info['title'])){
      echo $title_info['title'];
    }
    elseif(isset($submit)){
      echo $submit.$ten;
    }
    else{
      echo "Trang Chủ";
    }
    ?>
  </title>
  <link rel="shortcut icon" type="image/x-icon" href="images/logo .png">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="scss/style.css">
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/wowslider.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<div class="box_page">
   <div class="row">
     <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" id="header">
      <div id="logo">
      <!-- <p style="text-align: center;padding-top:50px;font-size:35px;color:red;font-weight: 800;">Website Tin Tức</p> -->
      </div>
      <div id="menu">
        <?php 
        menu_dacap();
        ?>
        <div class="clearfix"></div>
        <div id="search">
          <form name="frmsearch" method="GET" action="search.php">
           <input type="text" name="ten" value="" placeholder="Tìm kiếm từ khóa">
           <input type="submit" name="submit" value="Tìm kiếm">
         </form>		
       </div>
     </div>
   </div>
 </div>