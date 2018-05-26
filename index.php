<?php include "includes/header.php"; ?>
<?php include "includes/slider.php"; ?>
<?php include "includes/left.php";?>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" id="center">
    <!-- giải trí -->
    <div class="box_center">
       <div class="box_center_top">
        <div class="box_center_top_l">
            <a href="tintuc_category.php?dm=6">Giải Trí</a>     
        </div>
        <div class="box_center_top_r"></div>
        <div class="clearfix"></div>
    </div>
    <div class="box_center_main">
        <div class="row">
           <?php
           $query_home_title = "SELECT * FROM tblbaiviet WHERE danhmucbaiviet=6 ORDER BY rand() LIMIT 0,3 ";
           $result_home_title = mysqli_query($conn,$query_home_title);
           kt_query($result_home_title,$query_home_title);
           while ($title_img = mysqli_fetch_array($result_home_title,MYSQLI_ASSOC)) {
            ?>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 tinhome_item">
                <a href="baivietchitiet.php?id=<?php echo $title_img['id']; ?>" class="tinhome_item_img"><img height="150px" src="<?php echo $title_img['hinhanh']; ?>"></a>
                <a href="baivietchitiet.php?id=<?php echo $title_img['id']; ?>" class="tinhome_item_name" title="<?php echo $title_img['title']; ?>"><?php echo $title_img['title']; ?></a>      
            </div>
            <?php
        }
        ?>
    </div>
</div>
</div>
<!-- end giải trí -->
<!-- thể thao-->
<div class="box_center">
   <div class="box_center_top">
    <div class="box_center_top_l">
        <a href="tintuc_category.php?dm=11">Thể Thao</a>     
    </div>
    <div class="box_center_top_r"></div>
    <div class="clearfix"></div>
</div>
<div class="box_center_main">
    <div class="row">
       <?php
       $query_home_tt = "SELECT * FROM tblbaiviet WHERE danhmucbaiviet=11 ORDER BY rand() LIMIT 0,3 ";
       $result_home_tt = mysqli_query($conn,$query_home_tt);
       kt_query($result_home_tt,$query_home_tt);
       while ($tt_img = mysqli_fetch_array($result_home_tt,MYSQLI_ASSOC)) {
        ?>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 tinhome_item">
            <a href="baivietchitiet.php?id=<?php echo $tt_img['id']; ?>" class="tinhome_item_img"><img height="150px" src="<?php echo $tt_img['hinhanh']; ?>"></a>
            <a href="baivietchitiet.php?id=<?php echo $tt_img['id']; ?>" class="tinhome_item_name"
                title="<?php echo $tt_img['title']; ?>"><?php echo $tt_img['title']; ?></a>      
            </div>
            <?php
        }
        ?>
    </div>
</div>
</div>
<!-- end thể thao-->
<!-- giải trí -->
<div class="box_center">
   <div class="box_center_top">
    <div class="box_center_top_l">
        <a href="tintuc_category.php?dm=15">Giáo Dục</a>     
    </div>
    <div class="box_center_top_r"></div>
    <div class="clearfix"></div>
</div>
<div class="box_center_main">
    <div class="row">
       <?php
       $query_home_gd = "SELECT * FROM tblbaiviet WHERE danhmucbaiviet=15 ORDER BY rand() LIMIT 0,3 ";
       $result_home_gd = mysqli_query($conn,$query_home_gd);
       kt_query($result_home_gd,$query_home_gd);
       while ($gd_title_img = mysqli_fetch_array($result_home_gd,MYSQLI_ASSOC)) {
        ?>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 tinhome_item">
            <a href="baivietchitiet.php?id=<?php echo $gd_title_img['id'] ?>" class="tinhome_item_img"><img height="150px" src="<?php echo $gd_title_img['hinhanh']; ?>"></a>
            <a  href="baivietchitiet.php?id=<?php echo $gd_title_img['id'] ?>"  class="tinhome_item_name" title="<?php echo $gd_title_img['title']; ?>"><?php echo $gd_title_img['title']; ?></a>      
        </div>
        <?php
    }
    ?>
</div>
</div>
</div>
<!-- end giải trí -->

</div>                      
</div>                        
</div>
</div>   
</div>
<?php include "includes/footer.php"; ?>  
</body>
</html>