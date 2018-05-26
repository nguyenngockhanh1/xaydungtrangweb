       <?php
       $query_slider = "SELECT * FROM tblslider ORDER BY id DESC";
       $result_slider = mysqli_query($conn,$query_slider);
       kt_query($result_slider,$query_slider);
       ?>
       <div class="row" style="z-index:0;position: relative;">
        <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" id="slider">
         <div id="wowslider-container">
           <div class="ws_images">
            <ul>
             <?php
             while ($slider = mysqli_fetch_array($result_slider,MYSQLI_ASSOC)) {
              ?>
              <li>
                <a href="">
                  <img height="500px"  src="<?php echo $slider['anh']; ?>" alt="img" title="Beautiful Skins" />
                </a><?php echo $slider['title']; ?>
              </li>
              <?php
            }
            ?>
          </ul>
        </div>
    </div>
    <script type="text/javascript" src="js/wowslider.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
  </div>
</div>