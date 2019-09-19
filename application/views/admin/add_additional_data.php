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
                                          <b>Add Additional Data</b>  
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
                                    <div class="muted pull-left">Add Additional Data</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
                                                <!-- BEGIN FORM-->
                                                <form method="post" action=""  enctype="multipart/form-data" id="" class="form-horizontal">

                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <input type="hidden" name="add_id" value="<?php if( isset($edit['ADD_ID']) && $edit['ADD_ID'] ){echo $this->webspice->encrypt_decrypt($edit['ADD_ID'], 'encrypt');} ?>" />
                                                    <fieldset>
                                                        
                                                            <div class="control-group">
                                                                <label class="control-label">Type Name<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="type" data-required="1" class="span6 m-wrap" value="<?php echo set_value('type',$edit['TYPE']); ?>" />
                                                                    <span class="fred"><?php echo form_error('type'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Title<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="title" data-required="1" class="span6 m-wrap" value="<?php echo set_value('title',$edit['TITLE']); ?>" />
                                                                    <span class="fred"><?php echo form_error('title'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">URL</label>
                                                                <div class="controls">
                                                                    <input type="text" name="url" data-required="1" class="span6 m-wrap" value="<?php echo set_value('url',$edit['URL']); ?>" />
                                                                    <span class="fred"><?php echo form_error('url'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Detail Description<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <textarea name="details" data-required="1" class="span6 m-wrap" ><?php echo set_value('details',$edit['DETAILS']); ?></textarea>
                                                                    <span class="fred"><?php echo form_error('details'); ?></span>
                                                                </div>
                                                            </div>
                                                            
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