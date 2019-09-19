<?php include(APPPATH."views/admin/admin_header.php"); ?>

        <div class="container">
            <div class="row-fluid">
                <div class="span12" id="content">
                    <div class="row-fluid">

                        <!-- here will goes alert message -->
                        <!-- <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <h4>Success</h4>
                            The operation completed successfully
                        </div> -->
                        <!-- alert message end -->

                          <div class="navbar">
                              <div class="navbar-inner">
                                  <ul class="breadcrumb">
                                      <li>
                                          <b>Add Slider</b>  
                                      </li>
                                  </ul>
                              </div>
                          </div>
                      </div>


                         <!-- validation -->
                        <div class="row-fluid">
                             <!-- block -->
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Add Slider</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
                                                <!-- BEGIN FORM-->
                                                <form method="post" action=""  enctype="multipart/form-data" id="" class="form-horizontal">

                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <input type="hidden" name="slider_id" value="<?php if( isset($edit['SLIDER_ID']) && $edit['SLIDER_ID'] ){echo $this->webspice->encrypt_decrypt($edit['SLIDER_ID'], 'encrypt');} ?>" />
                                                    <fieldset>

                                                            <div class="control-group">
                                                                <label class="control-label">Slider Name<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="slider_name" data-required="1" class="span6 m-wrap" value="<?php echo set_value('slider_name',$edit['SLIDER_NAME']); ?>" />
                                                                </div>
                                                                <span class="fred"><?php echo form_error('slider_name'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                              <label class="control-label" for="slider_link">Slider Image</label>
                                                              <div class="controls">
                                                                <input type="file" name="slider_link" class="input-file uniform_on" id="slider_link" <?php if(set_value('slider_id',$edit['SLIDER_ID']))echo '';else echo 'required';?>>
                                                              </div>
                                                              <span class="fred"><?php echo form_error('slider_link'); ?></span>
                                                            </div>
                                                            <?php if( file_exists($this->webspice->get_path('slider_full').$edit['SLIDER_ID'].'.jpg') ): ?>
                                                              <div class="personnel-thm-img" style="padding-top:20px;margin-left:180px;"> 
                                                                <img src="<?php echo $this->webspice->get_path('slider').$edit['SLIDER_ID'].'.jpg'; ?>"  alt="" class="img-responsive" width="100"/> 
                                                              </div> 
                                                            <?php endif;  ?>
                                                            
                                                            <div class="form-actions">
                                                                <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"  />
                                                            </div>
                                                    </fieldset>
                                                </form>
                                                <!-- END FORM-->
                                            </div>
                                      </div>
                                   </div>
                              <!-- /block -->
                        </div>
                         <!-- /validation -->
                    
                    
                    
                </div>
        
            </div>
            
<?php include(APPPATH."views/admin/admin_footer.php"); ?>