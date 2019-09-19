<?php include(APPPATH."views/froant_header.php"); ?>
<?php $url_prefix = $this->webspice->settings()->site_url_prefix; ?>
   <!-- Start Blog banner  -->
  <section id="mu-blog-banner">
    <div class="container">
      <div class="mu-blog-banner-area">
          <div class="mu-title">
              <span class="mu-subtitle">Get In Touch</span>
              <h2>Contact Us</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
           </div>
      </div>
    </div>
  </section>
  <!-- End Blog banner -->  
 
 

  <!-- Start Contact section -->
  <section id="mu-contact">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
           <?php 
                $msg = $this->session->flashdata('msg');
                if($msg != NULL){
                    echo "<h3 style='text-align:center; color: #CB2430;'>". $msg ."</h3>";
                }
            ?>
          <div class="mu-contact-area">
            <div class="mu-contact-content">
              <div class="row">
                <div class="col-md-6">
                  <div class="mu-contact-left">
                    <form action="<?php echo $url_prefix;?>site_controller/contact_insert" method="post" class="mu-contact-form">
                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                      <div class="form-group">
                        <label for="name">Your Name</label>
                        <input name="name" value="<?php echo set_value('name'); ?>" type="text" class="form-control" id="name" placeholder="Name">
                        <?php  echo form_error('name'); ?>
                      </div>
                      <div class="form-group">
                        <label for="email">Email address</label>
                        <input name="email" value="<?php echo set_value('email'); ?>" type="email" class="form-control" id="email" placeholder="Email">
                        <?php  echo form_error('email'); ?>
                      </div>                      
                      <div class="form-group">
                        <label for="subject">Subject</label>
                        <input name="subject" value="<?php echo set_value('subject'); ?>" type="text" class="form-control" id="subject" placeholder="Subject">
                        <?php  echo form_error('subject'); ?>
                      </div>
                      <div class="form-group">
                        <label for="message">Message</label>                        
                          <textarea name="comments" class="form-control" id="message" cols="30" rows="10" placeholder="Type Your Message"></textarea>
                          <?php  echo form_error('comments'); ?>
                      </div>                      
                      <button type="submit" class="mu-send-btn">Send Message</button>
                    </form>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mu-contact-right">
                    <div class="mu-contact-widget">
                      <h3>Address</h3>
                      <p>G-25/3, Progoti Soroni, Shahjadpur <br/> Gulshan, Dhaka-1212</p>
                      <address>
                        <p><i class="fa fa-phone"></i>+88-02-8899937</p>
                        <p><i class="fa fa-mobile"></i>+8801712683670, +8801676818038</p>
                        <p><i class="fa fa-envelope-o"></i>Email: dhakaresturant@yahoo.com</p>
                      </address>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Contact section -->

  <!-- Start Map section -->
  <section id="mu-map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9207.358598888495!2d-85.64847801496286!3d30.183918972289003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x2320479d70eb6202!2sDillard&#39;s!5e0!3m2!1sbn!2sbd!4v1462359735720" width="100%" height="100%" frameborder="0"allowfullscreen></iframe>
  </section>
  <!-- End Map section -->

<?php include(APPPATH."views/testimonial_subscriber.php"); ?>
<?php include(APPPATH."views/froant_footer.php"); ?>