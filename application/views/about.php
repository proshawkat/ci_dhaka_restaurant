<?php include(APPPATH."views/froant_header.php"); ?>
<?php $url_prefix = $this->webspice->settings()->site_url_prefix; ?>
   <!-- Start Blog banner  -->
  <section id="mu-blog-banner">
    <div class="container">
      <div class="mu-blog-banner-area">
        <div class="mu-title">
              <span class="mu-subtitle">Discover</span>
              <h2>ABOUT US</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
            </div>
      </div>
    </div>
  </section>
  <!-- End Blog banner -->  

    <!-- Start About us -->
  <section id="mu-about-us">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-about-us-area">
            <div class="row">
              <div class="col-md-6">
                <div class="mu-about-us-left">
                 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam minus aliquid, itaque illum assumenda repellendus dolorem, dolore numquam totam saepe, porro delectus, libero enim odio quo. Explicabo ex sapiente sit eligendi, facere voluptatum! Quia vero rerum sunt porro architecto corrupti eaque corporis eum, enim soluta, perferendis dignissimos, repellendus, beatae laboriosam.</p>                              
                  <ul>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia.</li>                    
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quia.</li>
                  </ul>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque similique molestias est quod reprehenderit, quibusdam nam qui, quam magnam. Ex.</p>  
                </div>
              </div>
              <div class="col-md-6">
                <div class="mu-about-us-right">                
                 <ul class="mu-abtus-slider">                 
                   <li><img src="<?php echo $url_prefix;  ?>global/assets/img/about-us/abtus-img-1.jpg" alt="img"></li>
                   <li><img src="<?php echo $url_prefix;  ?>global/assets/img/about-us/abtus-img-2.jpg" alt="img"></li>
                   <li><img src="<?php echo $url_prefix;  ?>global/assets/img/about-us/abtus-img-3.jpg" alt="img"></li>
                   <li><img src="<?php echo $url_prefix;  ?>global/assets/img/about-us/abtus-img-4.jpg" alt="img"></li>
                   <li><img src="<?php echo $url_prefix;  ?>global/assets/img/about-us/abtus-img-5.jpg" alt="img"></li>
                 </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End About us -->

<?php include(APPPATH."views/testimonial_subscriber.php"); ?>

<?php include(APPPATH."views/froant_footer.php"); ?>