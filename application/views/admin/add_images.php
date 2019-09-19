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
                                          <b>Add Gallery Image</b>  
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
                                    <div class="muted pull-left">Add Gallery Image</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
                                                <!-- BEGIN FORM-->
                                                <form method="post" action=""  enctype="multipart/form-data" id="" class="form-horizontal">

                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <input type="hidden" name="slider_id" value="<?php if( isset($edit['IMAGE_ID']) && $edit['IMAGE_ID'] ){echo $this->webspice->encrypt_decrypt($edit['IMAGE_ID'], 'encrypt');} ?>" />
                                                    <fieldset>

                                                            <div class="control-group">
                                                              <label class="control-label">Category Name<span class="required">*</span></label>
                                                              <div class="controls">
                                                                <select class="span6 m-wrap" name="cat_id">
                                                                  <?php
                                                                    $options = $this->db->query("SELECT * FROM category WHERE STATUS = 7 AND CATEGORY_NAME = 'Gallery'")->result();
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
                                                                    $options2 = $this->db->query("select sub_category.* from sub_category inner join category on category.category_id = sub_category.cat_id where category.category_name = 'Gallery' and sub_category.STATUS = 7")->result();
                                                                  ?>
                                                                  <?php foreach($options2 as $option2) : ?>
                                                                    <option value="<?php echo $option2->SUB_CATEGORY_ID ?>" <?php echo ($edit['SUB_CAT_ID'] == $option2->SUB_CATEGORY_ID) ? "selected" : ""; ?> ><?php echo $option2->SUB_CATEGORY_NAME; ?></option>
                                                                  <?php endforeach; ?>
                                                                </select>
                                                                <span class="fred"><?php echo form_error('sub_cat_id'); ?></span>
                                                              </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Food Name<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="image_caption" data-required="1" class="span6 m-wrap" value="<?php echo set_value('image_caption',$edit['IMAGE_CAPTION']); ?>" />
                                                                </div>
                                                                <span class="fred"><?php echo form_error('image_caption'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Price<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="price" data-required="1" class="span6 m-wrap" value="<?php echo set_value('price',$edit['PRICE']); ?>" />
                                                                    <span class="fred"><?php echo form_error('price'); ?></span>
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                              <label class="control-label" for="image_link">Upload Image</label>
                                                              <div class="controls">
                                                                <input type="file" name="image_link" class="input-file uniform_on" id="image_link" <?php if(set_value('image_id',$edit['IMAGE_ID']))echo '';else echo 'required';?>>
                                                              </div>
                                                              <span class="fred"><?php echo form_error('image_link'); ?></span>
                                                            </div>
                                                            <?php if( file_exists($this->webspice->get_path('gallery_full').$edit['IMAGE_ID'].'.jpg') ): ?>
                                                              <div class="personnel-thm-img" style="padding-top:20px;margin-left:180px;"> 
                                                                <img src="<?php echo $this->webspice->get_path('gallery').$edit['IMAGE_ID'].'.jpg'; ?>"  alt="" class="img-responsive" width="100"/> 
                                                              </div> 
                                                            <?php endif;  ?>

                                                            <div class="control-group">
                                                                <label class="control-label">Description</label>
                                                                <div class="controls">
                                                                    <textarea rows="10" cols="50" name="description" class="span6 m-wrap" ><?php echo set_value('description',$edit['DESCRIPTION']); ?></textarea>
                                                                    <span class="fred"><?php echo form_error('description'); ?></span>
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