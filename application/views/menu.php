<?php include(APPPATH."views/froant_header.php"); ?>
<?php $url_prefix = $this->webspice->settings()->site_url_prefix; ?>

	   <!-- Start Blog banner  -->
  <section id="mu-blog-banner">
    <div class="container">
        <div class="mu-blog-banner-area">
       		<div class="mu-title">
              <span class="mu-subtitle">Our</span>
              <h2>Menu</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
            </div>
        </div>
    </div>
  </section>
  <!-- End Blog banner -->  
    <!-- Start menu us -->
  <section id="mu-our-menu">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-about-us-area">
            <div class="row">

              <?php foreach($category as $cv): ?>
                  <div class="col-md-4">
                    <div class="menu-list">
                      <?php $menu = $this->db->query("SELECT * FROM foods WHERE MENU_CATEGORY_ID=". $cv->MENU_CATEGORY_ID)->result(); ?>
                      <h3><?php echo $cv->NAME; ?></h3>
                      <ul>
                        <?php foreach($menu as $mv): ?>
                          <li> <i class="fa fa-caret-right" aria-hidden="true"></i><a href="#"><?php echo $mv->FOOD_NAME; ?></a> <span>৳<?php echo $mv->PRICE; ?></span></li>
                        <?php endforeach; ?>
                      </ul>

                    </div>
                  </div>
              <?php endforeach;?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End menu us -->
<?php include(APPPATH."views/testimonial_subscriber.php"); ?>
<?php include(APPPATH."views/froant_footer.php"); ?>