<?php include(APPPATH."views/admin/admin_header.php");?>

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
                                          <b>Edit Marks</b>  
                                      </li>
                                  </ul>
                              </div>
                          </div>
                      </div>
<!-- table start -->
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Edit Marks</div>

                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                      <div class="data_info">
                                        <h5>Exam Name: <?php echo $exam_name; ?></h5>
                                        <h5>Class Name: <?php echo $class_name; ?></h5>
                                        <h5>Section Name: <?php echo $section_name; ?></h5>
                                        <h5>Subject Name: <?php echo $subject_name; ?></h5>
                                        <h5>Session: <?php echo date("Y"); ?></h5>
                                      </div>
                                      <!-- <div class="btn-group pull-right">
                                         <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
                                         <ul class="dropdown-menu">
                                            <li><a href="#">Print</a></li>
                                            <li><a href="#">Save as PDF</a></li>
                                            <li><a href="#">Export to Excel</a></li>
                                         </ul>
                                      </div> -->
                                   </div>

                                   <?php //dd($exam_data[0]->CLASS_ID); ?>

                                    <!-- BEGIN FORM-->
                                    <form method="post" action=""  enctype="multipart/form-data" id="" class="">

                                      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

                                      <!-- additional data -->
                                      <input type="hidden" name="class_id" value="<?php echo $exam_data[0]->CLASS_ID; ?>" />
                                      <input type="hidden" name="section_id" value="<?php echo $exam_data[0]->SECTION_ID; ?>" />
                                      <input type="hidden" name="subject_id" value="<?php echo $exam_data[0]->SUBJECT_ID; ?>" />
                                      <input type="hidden" name="exam_id" value="<?php echo $exam_data[0]->EXAM_ID; ?>" />
                                      
                                      <?php if(count($exam_data)) { ?>

                                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">

                                            <tr>
                                                <th>Student Name</th>
                                                <th>Roll No</th>
                                                <th>Mark Obtained</th>
                                                <th>Comment</th>
                                            </tr>
                                            <?php foreach($exam_data as $data) : ?>
                                            <tr>
                                              <td>
                                                <?php echo $data->NAME ?>
                                                <input type="hidden" name="mark_id[]" data-required="1" class="span6 m-wrap" value="<?php echo $data->MARK_ID; ?>" />
                                              </td>
                                              <td>
                                                <?php echo $data->ROLL_NO ?>
                                              </td>
                                              <td>
                                                <div class="control-group">
                                                    <!-- <label class="control-label">Staff Name<span class="required">*</span></label> -->
                                                    <div class="controls">
                                                        <input type="text" name="mark_obtained[]" data-required="1" class="span6 m-wrap" value="<?php echo $data->MARK_OBTAINED; ?>" />
                                                        <span class="fred"><?php //echo form_error('mark_obtained'); ?></span>
                                                    </div>
                                                </div>
                                              </td>
                                              <td>
                                                <div class="control-group">
                                                    <!-- <label class="control-label">Staff Name<span class="required">*</span></label> -->
                                                    <div class="controls">
                                                        <textarea name="comment[]" data-required="1" class="span6 m-wrap"><?php echo $data->COMMENT; ?></textarea>
                                                        <span class="fred"><?php //echo form_error('comment'); ?></span>
                                                    </div>
                                                </div>
                                              </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                              <td></td>
                                              <td></td>
                                              <td>
                                                <!-- <div class="form-actions"> -->
                                                    <input type="submit" name="submit" class="btn btn-primary" value="Submit Data"  />
                                                     <a class="btn btn-danger" href="<?php echo $url_prefix; ?>manage_marks">Cancel</a>
                                                <!-- </div> -->
                                              </td>
                                            </tr>
                                        </table>

                                      <?php } else { ?>
                                        <div class="alert alert-danger" role="alert">Sorry, no student found on this search</div>
                                      <?php } ?>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
<!-- table end -->
                    
                    
                    
                </div>
        
            </div>
            
<?php include(APPPATH."views/admin/admin_footer.php"); ?>