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
                                          <b>Add Product</b>  
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
                                    <div class="muted pull-left">Add Product</div>
                                </div>
                                <div class="block-content collapse in">
                                    <div class="span12">
                                                <!-- BEGIN FORM-->
                                                <form method="post" action=""  enctype="multipart/form-data" id="" class="form-horizontal">

                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                    <input type="hidden" name="product_id" value="<?php if( isset($edit['PRODUCT_ID']) && $edit['PRODUCT_ID'] ){echo $this->webspice->encrypt_decrypt($edit['PRODUCT_ID'], 'encrypt');} ?>" />
                                                    <fieldset>

                                                          <div class="control-group">
                                                            <label class="control-label">Category Name<span class="required">*</span></label>
                                                            <div class="controls">
                                                              <select class="span6 m-wrap" name="cat_id">
                                                                <option value="">Select...</option>
                                                                <?php
                                                                  $options = $this->db->query("SELECT * FROM category WHERE STATUS = 7")->result();
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
                                                                  $options2 = $this->db->query("SELECT * FROM sub_category WHERE STATUS = 7")->result();
                                                                ?>
                                                                <?php foreach($options2 as $option2) : ?>
                                                                  <option value="<?php echo $option2->SUB_CATEGORY_ID ?>" <?php echo ($edit['SUB_CAT_ID'] == $option2->SUB_CATEGORY_ID) ? "selected" : ""; ?> ><?php echo $option2->SUB_CATEGORY_NAME; ?></option>
                                                                <?php endforeach; ?>
                                                              </select>
                                                              <span class="fred"><?php echo form_error('sub_cat_id'); ?></span>
                                                            </div>
                                                          </div>
                                                        
                                                            <div class="control-group">
                                                                <label class="control-label">Product Name<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="product_name" data-required="1" class="span6 m-wrap" value="<?php echo set_value('product_name',$edit['PRODUCT_NAME']); ?>" />
                                                                </div>
                                                                <span class="fred"><?php echo form_error('product_name'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Product Price<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <input type="text" name="product_price" data-required="1" class="span6 m-wrap" value="<?php echo set_value('product_price',$edit['PRODUCT_PRICE']); ?>" />
                                                                </div>
                                                                <span class="fred"><?php echo form_error('product_price'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Product Description<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <textarea name="product_description" data-required="1" class="span6 m-wrap" ><?php echo set_value('product_description',$edit['PRODUCT_DESCRIPTION']); ?></textarea>
                                                                </div>
                                                                <span class="fred"><?php echo form_error('product_description'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Product Details<span class="required">*</span></label>
                                                                <div class="controls">
                                                                    <textarea rows="10" cols="50" name="product_details" data-required="1" class="span6 m-wrap" ><?php echo set_value('product_details',$edit['PRODUCT_DETAILS']); ?></textarea>
                                                                </div>
                                                                <span class="fred"><?php echo form_error('product_details'); ?></span>
                                                            </div>

                                                            <div class="control-group">
                                                              <label class="control-label" for="product_img">Product Image</label>
                                                              <div class="controls">
                                                                <input type="file" name="product_img" class="input-file uniform_on" id="product_img" <?php if(set_value('product_id',$edit['PRODUCT_ID']))echo '';else echo 'required';?>>
                                                              </div>
                                                              <span class="fred"><?php echo form_error('product_img'); ?></span>
                                                            </div>
                                                            <?php if( file_exists($this->webspice->get_path('product_full').$edit['PRODUCT_ID'].'.jpg') ): ?>
                                                              <div class="personnel-thm-img" style="padding-top:20px;margin-left:180px;"> 
                                                                <img src="<?php echo $this->webspice->get_path('product').$edit['PRODUCT_ID'].'.jpg'; ?>"  alt="" class="img-responsive" width="100"/> 
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