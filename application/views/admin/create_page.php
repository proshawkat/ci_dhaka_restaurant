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
                                          <b>Create Page</b>  
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
                                    <div class="muted pull-left">Create Page</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
                                                <!-- BEGIN FORM-->
                                                <form method="post" action=""  enctype="multipart/form-data" id="" class="form-horizontal">

                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <input type="hidden" name="page_id" value="<?php if( isset($edit['PAGE_ID']) && $edit['PAGE_ID'] ){echo $this->webspice->encrypt_decrypt($edit['PAGE_ID'], 'encrypt');} ?>" />
                                                    <fieldset>


                                                          <div class="control-group">
                                                            <label class="control-label">Page Name<span class="required">*</span></label>
                                                            <div class="controls">
                                                              <select class="span6 m-wrap" name="sub_sub_category_id">
                                                                <option value="">Select...</option>
                                                                <?php
                                                                  if(count($edit['PAGE_ID'])) {
                                                                    $options = $this->db->query("SELECT * FROM sub_sub_category")->result();
                                                                  } else {
                                                                    $options = $this->db->query("SELECT * FROM sub_sub_category WHERE SUB_SUB_CATEGORY_ID NOT IN (SELECT SUB_SUB_CATEGORY_ID FROM pages)")->result();
                                                                  }
                                                                ?>
                                                                <?php foreach($options as $option) : ?>
                                                                  <option value="<?php echo $option->SUB_SUB_CATEGORY_ID ?>" <?php echo (isset($edit['SUB_SUB_CATEGORY_ID']) && $edit['SUB_SUB_CATEGORY_ID'] == $option->SUB_SUB_CATEGORY_ID) ? "selected" : ""; ?> ><?php echo $option->SUB_SUB_CATEGORY_NAME; ?></option>
                                                                <?php endforeach; ?>
                                                              </select>
                                                              <span class="fred"><?php echo form_error('sub_sub_category_id'); ?></span>
                                                            </div>
                                                          </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Page Title<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="page_title" data-required="1" class="span6 m-wrap" value="<?php echo set_value('page_title',$edit['PAGE_TITLE']); ?>" />
                                                                    <span class="fred"><?php echo form_error('page_title'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Page Details<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <textarea rows="10" cols="50" name="page_details" data-required="1" class="span6 m-wrap" ><?php echo set_value('details',$edit['PAGE_DETAILS']); ?></textarea>
                                                                    <span class="fred"><?php echo form_error('page_details'); ?></span>
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