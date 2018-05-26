
<div class="row">
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" id="left">
   <div class="box">
     <div class="box_top">
      <p>Hỗ trợ trực tuyến</p>		
    </div>
    <div class="box_main">
      <div id="support">
        <p><a href="https://www.facebook.com/dong.vutrong.79"><img width="40px" src="images/icon-facebook.png"></a>
        <a href="https://mail.google.com/mail/u/0/#inbox"><img width="38px" src="images/icon-gmail.jpeg"></a></p> 	
        <p>Hotline:&nbsp;<span style="font-size: 13px;">01688 162 714 -- 0123 743 2585</span></p>
        <p style="color:green;">Email:&nbsp;trongdong717@gmail.com</p>
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
    <?php 
    $query_moi= "SELECT * FROM tblbaiviet ORDER BY id DESC LIMIT 0,8";
    $result_moi = mysqli_query($conn,$query_moi);
    kt_query($result_moi,$query_moi);
    while($tin_moi = mysqli_fetch_array($result_moi,MYSQLI_ASSOC)){
      ?>
      <li><a href="baivietchitiet.php?id=<?php echo $tin_moi['id'] ?>" title="<?php echo $tin_moi['title']; ?>"><?php echo $tin_moi['title']; ?></a></li>
      <?php 
    }
    ?>

  </ul>
</div>
</div>	
</div>