<?php $url_prefix = $this->webspice->settings()->site_url_prefix; ?>
<?php include(APPPATH."views/froant_header.php"); ?>


  
  <!-- Start slider  -->
  <section id="mu-slider">
    <div class="mu-slider-area"> 
      <!-- Top slider -->
      <div class="mu-top-slider">
        <?php foreach ($slider as $v): ?>
        <!-- Top slider single slide -->
        <div class="mu-top-slider-single">
          <?php if( file_exists($this->webspice->get_path('slider_full').$v->SLIDER_ID.'.jpg') ): ?>
              <img src="<?php echo $this->webspice->get_path('slider').$v->SLIDER_ID.'.jpg'; ?>"  alt="" class="img-responsive" width="100px;"/> 
          <?php endif;  ?>
          <!-- Top slider content -->
          <div class="mu-top-slider-content">
            <span class="mu-slider-small-title">Welcome</span>
            <h2 class="mu-slider-title"><em>TO</em> <br> Dhaka Chainese Restaurant</h2>
            
          </div>
          <!-- / Top slider content -->
        </div>
        <!-- / Top slider single slide -->    
      <?php endforeach; ?>
      </div>
    </div>
  </section>
  <!-- End slider  -->

  <!-- Start About us -->
  <section id="mu-about-us">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-about-us-area">
            <div class="mu-title">
              <span class="mu-subtitle">Discover</span>
              <h2>ABOUT US</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
            </div>
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

  <!-- Start Counter Section -->
  <section id="mu-counter">
    <div class="mu-counter-overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="mu-counter-area">
            <ul class="mu-counter-nav">
              <li class="col-md-3 col-sm-3 col-xs-12">
                <div class="mu-single-counter">
                  <span>Fresh</span>
                  <h3><span class="counter">55</span><sup>+</sup></h3>
                  <p>Breakfast Items</p>
                </div>
              </li>
              <li class="col-md-3 col-sm-3 col-xs-12">
                <div class="mu-single-counter">
                  <span>Delicious</span>
                  <h3><span class="counter">130</span><sup>+</sup></h3>
                  <p>Lunch Items</p>
                </div>
              </li>
               <li class="col-md-3 col-sm-3 col-xs-12">
                <div class="mu-single-counter">
                  <span>Hot</span>
                   <h3><span class="counter">35</span><sup>+</sup></h3>
                  <p>Coffee Items</p>
                </div>
              </li>
               <li class="col-md-3 col-sm-3 col-xs-12">
                <div class="mu-single-counter">
                  <span>Satisfied</span>
                  <h3><span class="counter">3562</span><sup>+</sup></h3>
                  <p>Customers</p>
                </div>
              </li>
            </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Counter Section --> 

  <!-- Start Restaurant Menu -->
  <section id="mu-restaurant-menu">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-restaurant-menu-area">
            <div class="mu-title">
              <span class="mu-subtitle">Discover</span>
              <h2>OUR MENU</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
            </div>
            <div class="mu-restaurant-menu-content">
              <ul class="nav nav-tabs mu-restaurant-menu">
                <?php $i = 0; foreach ($category as $cv): ?>
                <li <?php echo ($i==0) ? "class='active'" : ""; ?> ><a href="#<?php echo $cv->SUB_CATEGORY_ID; ?>" data-toggle="tab"> <?php echo $cv->SUB_CATEGORY_NAME; ?></a></li>
              <?php $i++; endforeach; ?>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <?php $x=0; foreach($category as $v): ?>
                  <div <?php if($x==0) { echo 'class="tab-pane fade in active"'; }else {echo 'class="tab-pane"'; } ?> id="<?php echo $v->SUB_CATEGORY_ID;  ?>">
                    <div class="mu-tab-content-area">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="mu-tab-content-left">
                            <ul class="mu-menu-item-nav">
                              <?php $g = $this->db->query("SELECT * FROM gallery WHERE SUB_CAT_ID=". $v->SUB_CATEGORY_ID)->result(); ?>
                              
                                <li>
                                  <?php foreach($g as $v): ?>
                                  <div class="media">
                                    <div class="media-left">
                                      <a href="#">
                                        <?php if( file_exists($this->webspice->get_path('gallery_full').$v->IMAGE_ID.'.jpg') ): ?>
                                            <img src="<?php echo $this->webspice->get_path('gallery').$v->IMAGE_ID.'.jpg'; ?>"  alt="" /> 
                                        <?php endif;  ?>
                                      </a>
                                    </div>
                                    <div class="media-body">
                                      <h4 class="media-heading"><a href="#"><?php echo $v->IMAGE_CAPTION; ?></a></h4>
                                      <span class="mu-menu-price">৳<?php echo $v->PRICE; ?></span>
                                      <p><?php echo $v->DESCRIPTION; ?></p>
                                    </div>
                                  </div>
                                   <?php endforeach; ?>
                                </li>
                             
                            </ul>   
                          </div>
                        </div>
                     </div>
                   </div>
                  </div>
                <?php $x++; endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Restaurant Menu -->

  <!-- Start Reservation section -->
  <section id="mu-reservation">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-reservation-area">
            <div class="mu-title">
              <span class="mu-subtitle">Make A</span>
              <h2>Reservation</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
            </div>
            <div class="mu-reservation-content">
              <form class="mu-reservation-form">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">                       
                      <input type="text" class="form-control" placeholder="Full Name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">                        
                      <input type="email" class="form-control" placeholder="Email">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">                        
                      <input type="text" class="form-control" placeholder="Phone Number">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <select class="form-control">
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
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" id="datepicker" placeholder="Date">              
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Phone No">                      
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea class="form-control" cols="30" rows="10" placeholder="Your Message"></textarea>
                    </div>
                  </div>
                  <button type="submit" class="mu-readmore-btn">Make Reservation</button>
                </div>
              </form>      
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>  
  <!-- End Reservation section -->

  <!-- Start Gallery -->
  <section id="mu-gallery">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-gallery-area">
            <div class="mu-title">
              <span class="mu-subtitle">Discover</span>
              <h2>Our Gallery</h2>
              <i class="fa fa-spoon"></i>              
              <span class="mu-title-bar"></span>
            </div>
            <div class="mu-gallery-content">
              <div class="mu-gallery-top">
                <!-- Start gallery menu -->
                <ul>
                  <li class="filter active" data-filter="all">ALL</li>
                  <li class="filter" data-filter=".food">BANGLA</li>
                  <li class="filter" data-filter=".drink">CHAINESE</li>
                  <li class="filter" data-filter=".restaurant">BARBIE QUE</li>
                  <li class="filter" data-filter=".dinner">FAST FOOD</li>
                  <li class="filter" data-filter=".dessert">SWEET BAKERY</li>
                </ul>
              </div>
              <!-- Start gallery image -->
              <div class="mu-gallery-body" id="mixit-container">
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix food">
                  <div class="mu-single-gallery-item">
                    <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/1.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                      <a href="<?php echo $url_prefix;  ?>global/assets/img/gallery/big/1.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>                  
                  </div>
                </div>
                <!-- End single gallery image -->
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix drink">
                  <div class="mu-single-gallery-item">
                    <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/2.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                     <a href="<?php echo $url_prefix;  ?>global/assets/img/gallery/big/2.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>                  
                  </div>
                </div>               
                <!-- End single gallery image -->
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix restaurant">                  
                  <div class="mu-single-gallery-item">
                   <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/3.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                      <a href="<?php echo $url_prefix;  ?>global/assets/img/gallery/big/3.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>
                  </div>
                </div>               
                <!-- End single gallery image -->
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix dinner">                  
                  <div class="mu-single-gallery-item">
                    <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/4.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                      <a href="<?php echo $url_prefix;  ?>global/assets/img/gallery/big/4.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>                  
                  </div>
                </div>
                <!-- End single gallery image -->
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix dinner">                  
                  <div class="mu-single-gallery-item">
                    <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/5.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                     <a href="<?php echo $url_prefix;  ?>global/assets/img/gallery/big/5.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>   
                  </div>
                </div>               
                <!-- End single gallery image -->               
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix food">                  
                  <div class="mu-single-gallery-item">
                    <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/6.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                      <a href="assets/img/gallery/big/6.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>                  
                  </div>
                </div>
                <!-- End single gallery image -->
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix drink">                  
                  <div class="mu-single-gallery-item">
                    <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/7.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                     <a href="<?php echo $url_prefix;  ?>global/assets/img/gallery/big/7.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>                  
                  </div>
                </div>               
                <!-- End single gallery image -->
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix restaurant">                  
                  <div class="mu-single-gallery-item">
                   <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/8.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                      <a href="<?php echo $url_prefix;  ?>global/assets/img/gallery/big/8.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>
                  </div>
                </div>               
                <!-- End single gallery image -->
                <!-- start single gallery image -->
                <div class="mu-single-gallery col-md-4 mix dessert">                  
                  <div class="mu-single-gallery-item">
                    <figure class="mu-single-gallery-img">
                      <a href="#"><img alt="img" src="<?php echo $url_prefix;  ?>global/assets/img/gallery/small/9.jpg"></a>
                    </figure>
                    <div class="mu-single-gallery-info">
                      <a href="<?php echo $url_prefix;  ?>global/assets/img/gallery/big/9.jpg" data-fancybox-group="gallery" class="fancybox">
                        <img src="<?php echo $url_prefix;  ?>global/assets/img/plus.png" alt="plus icon img">
                      </a>
                    </div>                  
                  </div>
                </div>
                <!-- End single gallery image -->                         
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Gallery -->
  

  <!-- Start Client Testimonial section -->
  <section id="mu-client-testimonial">
    <div class="mu-overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="mu-client-testimonial-area">
              <div class="mu-title">
                <span class="mu-subtitle">Testimonials</span>
                <h2>What Customers Say</h2>
                <i class="fa fa-spoon"></i>              
                <span class="mu-title-bar"></span>
              </div>
              <!-- testimonial content -->
              <div class="mu-testimonial-content">
                <!-- testimonial slider -->
                <ul class="mu-testimonial-slider">
                  <li>
                    <div class="mu-testimonial-single">                   
                      <div class="mu-testimonial-info">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate consequuntur ducimus cumque iure modi nesciunt recusandae eligendi vitae voluptatibus, voluptatum tempore, ipsum nisi perspiciatis. Rerum nesciunt fuga ab natus, dolorem?</p>
                      </div>
                      <div class="mu-testimonial-bio">
                        <p>- David Muller</p>                      
                      </div>
                    </div>
                  </li>
                   <li>
                    <div class="mu-testimonial-single">                   
                      <div class="mu-testimonial-info">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate consequuntur ducimus cumque iure modi nesciunt recusandae eligendi vitae voluptatibus, voluptatum tempore, ipsum nisi perspiciatis. Rerum nesciunt fuga ab natus, dolorem?</p>
                      </div>
                      <div class="mu-testimonial-bio">
                        <p>- David Muller</p>                      
                      </div>
                    </div>
                  </li>
                   <li>
                    <div class="mu-testimonial-single">                   
                      <div class="mu-testimonial-info">
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate consequuntur ducimus cumque iure modi nesciunt recusandae eligendi vitae voluptatibus, voluptatum tempore, ipsum nisi perspiciatis. Rerum nesciunt fuga ab natus, dolorem?</p>
                      </div>
                      <div class="mu-testimonial-bio">
                        <p>- David Muller</p>                      
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Client Testimonial section -->

  <!-- Start Contact section -->
  <section id="mu-contact">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-contact-area">
            <div class="mu-contact-content">
              <div class="row">
                <div class="col-md-6">
                  <div class="mu-contact-left">
                    <form class="mu-contact-form">
                      <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" placeholder="Email">
                      </div>                      
                      <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" placeholder="Subject">
                      </div>
                      <div class="form-group">
                        <label for="message">Message</label>                        
                        <textarea class="form-control" id="message" cols="30" rows="10" placeholder="Type Your Message"></textarea>
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


<?php include(APPPATH."views/froant_footer.php"); ?>