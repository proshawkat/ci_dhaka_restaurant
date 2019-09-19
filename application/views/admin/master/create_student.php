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
                                          <b>Create Student</b>  
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
                                  <div class="muted pull-left">Create tudent</div>
                              </div>
                              <div class="block-content collapse in" style="min-height:400px">
                                <div class="span12">
                                    <!-- BEGIN FORM-->
                                    <form method="post" action=""  enctype="multipart/form-data" id="" class="form-horizontal">

                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                        <input type="hidden" name="user_id" value="<?php if( isset($edit['USER_ID']) && $edit['USER_ID'] ){echo $this->webspice->encrypt_decrypt($edit['USER_ID'], 'encrypt');} ?>" />
                                        <fieldset>

                                        <div class="control-group">
                                            <label class="control-label">Student Name<span class="required">*</span></label>
                                            <div class="controls">
                                              <select class="span6 m-wrap chzn-select" name="student_id">
                                                <option value="">Select...</option>
                                                <?php
                                                $options = $this->db->query("SELECT * FROM student_info WHERE STATUS = 7")->result();
                                                ?>
                                                <?php foreach($options as $option) : ?>
                                                <option value="<?php echo $option->STUDENT_ID ?>" <?php echo (isset($edit['STUDENT_ID']) && $edit['STUDENT_ID'] == $option->STUDENT_ID) ? "selected" : ""; ?> ><?php echo $option->NAME; ?></option>
                                                <?php endforeach; ?>
                                              </select>
                                              <span class="fred"><?php echo form_error('student_id'); ?></span>
                                            </div>
                                          </div>

                                          <div class="control-group">
                                            <label class="control-label">User Role<span class="required">*</span></label>
                                            <div class="controls">
                                              <select class="span6 m-wrap" name="user_role">
                                                <option value="">Select...</option>
                                                <?php
                                                $options = $this->db->query("SELECT * FROM role WHERE STATUS = 7")->result();
                                                ?>
                                                <?php foreach($options as $option) : ?>
                                                <option value="<?php echo $option->ROLE_ID ?>" <?php echo (isset($edit['ROLE_ID']) && $edit['ROLE_ID'] == $option->ROLE_ID) ? "selected" : ""; ?> ><?php echo $option->ROLE_NAME; ?></option>
                                                <?php endforeach; ?>
                                              </select>
                                              <span class="fred"><?php echo form_error('user_role'); ?></span>
                                            </div>
                                          </div>
                                                
                                          <div class="form-actions">
                                              <input type="submit" name="submit" class="btn btn-success" value="Submit Data"  />
                                              <a class="btn btn-danger" href="<?php echo $url_prefix; ?>manage_user">Cancel</a>
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