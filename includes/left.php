<?php include "../connect/mysql.php"; ?>
<?php include "../connect/function.php" ;?>
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="left">
   <div class="box">
     <div class="box_top">
      <p>Hỗ trợ trực tuyến</p>		
    </div>
    <div class="box_main">
      <div id="support">
        <p><a href=""><img src="images/yahoo.png"></a><a href=""><img src="images/skype.png"></a></p> 	
        <p>Hotline:&nbsp;<span>0919 405 624 - 0989 493 036</span></p>
        <p>Email:&nbsp;hotro@ttm.edu.vn</p>
      </div>
    </div>
  </div>
  <div class="box">
   <div class="box_top">
    <p>Video</p>		
  </div>
  <div class="box_main">
    <div id="video">
      <div id="content_video">
      <?php
      // chỉ hiển thị duy nhất một video khi load trang
        $query_video_one ="SELECT * FROM tblvideo ORDER BY ordernum LIMIT 1";
        $result_video_one = mysqli_query($conn,$query_video_one);
        kt_query($result_video_one,$query_video_one);
        $query_video_two = mysqli_fetch_assoc($result_video_one);
        $str_one = explode('=',$query_video_two['link']);
      ?>
       <iframe width="100%" height="162px" class="embed-player" src="http://www.youtube.com/embed/<?php echo $str_one[1]; ?>" frameborder="0" allowfullscreen></iframe>
       <br />
       <?php 
       $query_video = "SELECT * FROM tblvideo ORDER BY ordernum";
       $result_video = mysqli_query($conn,$query_video);
       kt_query($result_video,$query_video);
       ?>
       <ul class="list-video">
         <?php
         //sử dụng hàm explode để cắt chuỗi
         while ($video = mysqli_fetch_array($result_video,MYSQLI_ASSOC)) {
          //kí tự ở sau dấu bằng là mã video
          $str = explode('=',$video['link']);
          ?>
          <!-- vì khi sử dụng hàm explode thì nó sẽ cắt chuỗi làm hai phần trước và sau dấu =
          phần tử mảng chạy từ 0 , nên muốn lấy chuỗi ở sau dấu bằng thì ta lây là $str[1] -->

          <li><a style="cursor:pointer;" title="<?php echo $str[1]; ?>"><i class="fa fa-caret-right fw"></i>&nbsp; <?php echo $video['title']; ?></a></li>
          <?php    
        }
        ?>
        <script>                        
         $(document).ready(function(){
           $('.list-video li').click(function(){
            //tạo sự kiện để đưa video vào 
             $(this).parent().siblings('.embed-player').attr('src','http://www.youtube.com/embed/'+$(this).children('a').attr('title'));                                     
           });
         });
       </script>
     </ul>
     <div class="clearfix"></div>
   </div>
   <div class="clearfix"></div>
 </div>
</div>
</div>
<div class="box">
 <div class="box_top">
  <p>Bài viết mới nhất</p>		
</div>
<div class="box_main">
  <ul id="baiviet_l">
    <li><a href="">Tin mới 1</a></li>
    <li><a href="">Tin mới 1</a></li>
    <li><a href="">Tin mới 1</a></li>
    <li><a href="">Tin mới 1</a></li>
    <li><a href="">Tin mới 1</a></li>	
  </ul>
</div>
</div>	
</div>
