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
                                          <b>Add Video</b>  
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
                                    <div class="muted pull-left">Add Video</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
                                                <!-- BEGIN FORM-->
                                                <form method="post" action=""  enctype="multipart/form-data" id="" class="form-horizontal">

                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <input type="hidden" name="video_id" value="<?php if( isset($edit['VIDEO_ID']) && $edit['VIDEO_ID'] ){echo $this->webspice->encrypt_decrypt($edit['VIDEO_ID'], 'encrypt');} ?>" />
                                                    <fieldset>

                                                            <div class="control-group">
                                                              <label class="control-label">Category Name<span class="required">*</span></label>
                                                              <div class="controls">
                                                                <select class="span6 m-wrap" name="cat_id">
                                                                  <?php
                                                                    $options = $this->db->query("SELECT * FROM category WHERE STATUS = 7 AND CATEGORY_NAME = 'Videos'")->result();
                                                                  ?>
                                                                  <?php foreach($options as $option) : ?>
                                                                    <option value="<?php echo $option->CATEGORY_ID ?>" <?php echo ($edit['CAT_ID'] == $option->CATEGORY_ID) ? "selected" : ""; ?> ><?php echo $option->CATEGORY_NAME; ?></option>
                                                                  <?php endforeach; ?>
                                                                </select>
                                                                <span class="fred"><?php echo form_error('cat_id'); ?></span>
                                                              </div>
                                                            </div>

                                                            <div class="control-group">
                                                              <label class="control-label">Sub Category Name<span class="required">*</span></label>
                                                              <div class="controls">
                                                                <select class="span6 m-wrap" name="sub_cat_id">
                                                                  <option value="">Select...</option>
                                                                  <?php
                                                                    $options2 = $this->db->query("select sub_category.* from sub_category inner join category on category.category_id = sub_category.cat_id where category.category_name = 'Videos' and sub_category.STATUS = 7")->result();
                                                                  ?>
                                                                  <?php foreach($options2 as $option2) : ?>
                                                                    <option value="<?php echo $option2->SUB_CATEGORY_ID ?>" <?php echo ($edit['SUB_CAT_ID'] == $option2->SUB_CATEGORY_ID) ? "selected" : ""; ?> ><?php echo $option2->SUB_CATEGORY_NAME; ?></option>
                                                                  <?php endforeach; ?>
                                                                </select>
                                                                <span class="fred"><?php echo form_error('sub_cat_id'); ?></span>
                                                              </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Video Caption<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="caption" data-required="1" class="span6 m-wrap" value="<?php echo set_value('caption',$edit['CAPTION']); ?>" />
                                                                <span class="fred"><?php echo form_error('caption'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Embed Code<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="embed_code" data-required="1" class="span6 m-wrap" value="<?php echo set_value('embed_code',$edit['EMBED_CODE']); ?>" />
                                                                <span class="fred"><?php echo form_error('embed_code'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Details<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <textarea rows="10" cols="50" name="details" data-required="1" class="span6 m-wrap" ><?php echo set_value('details',$edit['DETAILS']); ?></textarea>
                                                                </div>
                                                                <span class="fred"><?php echo form_error('details'); ?></span>
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