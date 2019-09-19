<?php include(APPPATH."views/froant_header.php"); ?>
<?php $url_prefix = $this->webspice->settings()->site_url_prefix; ?>
   <!-- Start Blog banner  -->
  <section id="mu-blog-banner">
    <div class="container">
      <div class="mu-blog-banner-area">
       		<div class="mu-title">
              <span class="mu-subtitle">Make A</span>
              <h2>Reservation</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
            </div>
      </div>
    </div>
  </section>
  <!-- End Blog banner -->  

    <!-- Start reservation us -->
  <section id="mu-reservation-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
		<?php 
                $msg = $this->session->flashdata('msg');
                if($msg != NULL){
                    echo "<h3 style='text-align:center; color: #CB2430;'>". $msg ."</h3>";
                }
            ?>
          <div class="mu-about-us-area">
            <div class="row">
              <div class="col-md-6">
		           <div class="mu-reservation-content">
		              <form action="<?php echo $url_prefix;?>site_controller/reservation_insertdata" method="post" class="mu-reservation-form">
					  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		                <div class="row">
		                  <div class="col-md-6">
		                    <div class="form-group">                       
		                      <input name="name" value="<?php echo set_value('name'); ?>" type="text" class="form-control" placeholder="Full Name">
							    <?php  echo form_error('name'); ?>
		                    </div>
		                  </div>
		                  <div class="col-md-6">
		                    <div class="form-group">                        
		                      <input name="email" type="email" value="<?php echo set_value('email'); ?>" class="form-control" placeholder="Email">
							   <?php  echo form_error('email'); ?>
		                    </div>
		                  </div>
		                  <div class="col-md-6">
		                    <div class="form-group">                        
		                      <input name="phone_1" value="<?php echo set_value('phone_1'); ?>" type="text" class="form-control" placeholder="Phone Number">
							  <?php  echo form_error('phone_1'); ?>
		                    </div>
		                  </div>
		                  <div class="col-md-6">
		                    <div class="form-group">
		                      <select name="how_many" class="form-control">
		                        <option value="0">How Many?</option>
		                        <option value="1 Person">1 Person</option>
		                        <option value="2 People">2 People</option>
		                        <option value="3 People">3 People</option>
		                        <option value="4 People">4 People</option>
		                        <option value="5 People">5 People</option>
		                        <option value="6 People">6 People</option>
		                        <option value="7 People">7 People</option>
		                        <option value="8 People">8 People</option>
		                        <option value="9 People">9 People</option>
		                        <option value="10 People">10 People</option>
		                      </select>
						<?php  echo form_error('how_many'); ?>							  
		                    </div>
		                  </div>
		                  <div class="col-md-6">
		                    <div class="form-group">
		                      <input name="date" value="<?php echo set_value('date'); ?>" type="text" class="form-control" id="datepicker" placeholder="Date">   
								<?php  echo form_error('date'); ?>
		                    </div>
		                  </div>
		                  <div class="col-md-6">
		                    <div class="form-group">
		                      <input name="phone_2" value="<?php echo set_value('phone_2'); ?>" type="text" class="form-control" placeholder="Phone No">   
								<?php  echo form_error('phone_2'); ?>							  
		                    </div>
		                  </div>
		                  <div class="col-md-12">
		                    <div class="form-group">
		                      <textarea name="message" class="form-control" cols="30" rows="10" placeholder="Your Message"></textarea>
							  <?php  echo form_error('message'); ?>	
		                    </div>
		                  </div>
		                  <button type="submit" class="mu-readmore-btn">Make Reservation</button>
		                </div>
		              </form>      
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
  <!-- End reservation us -->
<?php include(APPPATH."views/testimonial_subscriber.php"); ?>
<?php include(APPPATH."views/froant_footer.php"); ?>