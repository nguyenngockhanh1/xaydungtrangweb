<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Xây dựng website</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript" src="js/wowslider.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container">
   <div class="row">
     <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" id="header">
      <div id="logo">
        <p><img src="images/logo.jpg"></p>
      </div>
      <div id="menu">
        <?php 
        include "connect/mysql.php";
        include "connect/function.php";
        menu_dacap();
        ?>
     <div class="clearfix"></div>
     <div id="search">
      <form name="frmsearch" method="POST" action="">
       <input type="text" name="ten" value="" placeholder="Tìm kiếm từ khóa">
       <input type="submit" name="submit" value="Tìm kiếm">
     </form>		
   </div>
 </div>
</div>
</div>