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
                                          <b>Add Person</b>  
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
                                    <div class="muted pull-left">Add Person</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
                                                <!-- BEGIN FORM-->
                                                <form method="post" action=""  enctype="multipart/form-data" id="" class="form-horizontal">

                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <input type="hidden" name="person_id" value="<?php if( isset($edit['PERSON_ID']) && $edit['PERSON_ID'] ){echo $this->webspice->encrypt_decrypt($edit['PERSON_ID'], 'encrypt');} ?>" />
                                                    <fieldset>
                                                        
                                                            <div class="control-group">
                                                                <label class="control-label">Person Type<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="person_type" data-required="1" class="span6 m-wrap" value="<?php echo set_value('person_type',$edit['PERSON_TYPE']); ?>" />
                                                                </div>
                                                                <span class="fred"><?php echo form_error('person_type'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Person Name<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="name" data-required="1" class="span6 m-wrap" value="<?php echo set_value('name',$edit['NAME']); ?>" />
                                                                </div>
                                                                <span class="fred"><?php echo form_error('name'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Person Details<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <textarea name="details" data-required="1" class="span6 m-wrap" ><?php echo set_value('details',$edit['DETAILS']); ?></textarea>
                                                                </div>
                                                                <span class="fred"><?php echo form_error('details'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                              <label class="control-label" for="images">Person Image</label>
                                                              <div class="controls">
                                                                <input type="file" name="images" class="input-file uniform_on" id="images" <?php if(set_value('person_id',$edit['PERSON_ID']))echo '';else echo 'required';?>>
                                                              </div>
                                                              <span class="fred"><?php echo form_error('images'); ?></span>
                                                            </div>
                                                            <?php if( file_exists($this->webspice->get_path('person_full').$edit['PERSON_ID'].'.jpg') ): ?>
                                                              <div class="personnel-thm-img" style="padding-top:20px;margin-left:180px;"> 
                                                                <img src="<?php echo $this->webspice->get_path('person').$edit['PERSON_ID'].'.jpg'; ?>"  alt="" class="img-responsive" width="100"/> 
                                                              </div> 
                                                            <?php endif;  ?>
                                                            
                                                            <div class="form-actions">
                                                                <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"  />
                                                                <button type="button" class="btn">Cancel</button>
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