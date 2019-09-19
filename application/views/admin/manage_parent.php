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
                                          <b>Manage Parent</b>  
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
                                <div class="muted pull-left">Manage parent</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                      <div class="btn-group">
                                         <a href="<?php echo $url_prefix . 'create_parent' ?>"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
                                      </div>
                                      <div class="btn-group">
                                         <a href="<?php echo $url_prefix . 'manage_parent' ?>"><button class="btn btn-primary">Refresh</button></a>
                                      </div>
                                      <!-- print button -->
                                      <div class="btn-group">
                                         <a target="_blank" href="<?php echo $url_prefix . 'manage_parent/print' ?>"><button class="btn btn-warning">&nbsp;&nbsp;Print&nbsp;&nbsp;</button></a>
                                      </div>
                                      <!-- export button -->
                                      <div class="btn-group">
                                         <a target="_blank" href="<?php echo $url_prefix . 'manage_parent/csv' ?>"><button class="btn btn-info">&nbsp;&nbsp;Export&nbsp;&nbsp;</button></a>
                                      </div>
                                      <!-- pdf button -->
                                       <div class="btn-group">
                                         <a href="<?php echo $url_prefix . 'manage_parent/pdf' ?>"><button class="btn btn-danger">&nbsp;&nbsp;PDF&nbsp;&nbsp;</button></a>
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
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Parent Name</th>
                                                <th>Student Name</th>
                                                <th>Class Name</th>
                                                <th>Section Name</th>
                                                <th>Relation With Student</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>parent National Id</th>
                                                <th>Parent Occopation</th>
                                                <th>Gender</th>
                                                <th>Address</th>
                                                <th>Image</th>
                                                <th>Created Date</th>
                                                <th>Created By</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($get_record as $v) : ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $v->PARENT_ID; ?></td>
                                                <td><?php echo $v->PARENT_NAME; ?></td>
                                                <td>
                                                  <?php
                                                    $cat = $this->db->query("SELECT NAME FROM student_info WHERE  STUDENT_ID=".$v->STUDENT_ID)->result();
                                                    echo($cat[0]->NAME);
                                                  ?>
                                                </td>
                                                  <td><?php
                                                      if($cat = $this->db->query("SELECT sd.*, c.ClASS_ID, c.ClASS_NAME FROM student_data AS sd INNER JOIN class AS c ON c.ClASS_ID=sd.ClASS_ID INNER JOIN section AS s ON s.SECTION_ID=sd.SECTION_ID WHERE  sd.STUDENT_ID=".$v->STUDENT_ID)->result()){
                                                        echo ($cat[0]->ClASS_NAME);
                                                      }else{
                                                        echo " ";
                                                      }
                                                   ?></td>
                                                  <td><?php 
                                                      if($cat = $this->db->query("SELECT sd.*, c.ClASS_ID, c.ClASS_NAME, s.SECTION_ID, s.SECTION_NAME FROM student_data AS sd INNER JOIN class AS c ON c.ClASS_ID=sd.ClASS_ID INNER JOIN section AS s ON s.SECTION_ID=sd.SECTION_ID WHERE  sd.STUDENT_ID=".$v->STUDENT_ID)->result()){
                                                      echo($cat[0]->SECTION_NAME);
                                                    }else{
                                                      echo " ";
                                                    }
                                                    ?></td>
                                                  <td><?php echo $v->RELATION_WITH_STU; ?></td>
                                                  <td><?php echo $v->PHONE; ?></td>
                                                  <td><?php echo $v->EMAIL; ?></td>
                                                  <td><?php echo $v->NATIONAL_ID_NO; ?></td>
                                                  <td><?php echo $v->OCCOPATION; ?></td>
                                                  <td><?php echo $v->GENDER; ?></td>
                                                  <td><?php echo $v->ADDRESS; ?></td>
                                                  <td>
                                                    <?php if( file_exists($this->webspice->get_path('parent_full').$v->PARENT_ID.'.jpg') ): ?>
                                                      <img src="<?php echo $this->webspice->get_path('parent').$v->PARENT_ID.'.jpg'; ?>"  alt="" class="img-responsive" width="100px;"/>
                                                  <?php endif;  ?>
                                                  </td>
                                                <td><?php echo $v->CREATED_DATE; ?></td>
                                                <td><?php echo $this->webspice->admin_user_name($v->CREATED_BY); ?></td>
                                                <td><?php echo $this->webspice->static_status($v->STATUS); ?></td>
                                                <td>
                                                  <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-default dropdown-toggle customized-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      Action
                                                      <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu customized-menu">
                                                      <li>
                                                        <?php if( $this->webspice->permission_verify('manage_parent',true) && $v->STATUS!=9 ): ?>
                                                            <a href="<?php echo $url_prefix; ?>manage_parent/edit/<?php echo $this->webspice->encrypt_decrypt($v->PARENT_ID,'encrypt'); ?>" class="btn btn-success">Edit</a>
                                                        <?php endif; ?>
                                                      </li>
                                                      <li>
                                                        <?php if( $this->webspice->permission_verify('manage_parent',true) && $v->STATUS==7 ): ?>
                                                            <a href="<?php echo $url_prefix; ?>manage_parent/inactive/<?php echo $this->webspice->encrypt_decrypt($v->PARENT_ID,'encrypt'); ?>" class="btn btn-warning">Inactive</a>
                                                        <?php endif; ?>
                                                      </li>
                                                      <li>
                                                        <?php if( $this->webspice->permission_verify('manage_parent',true) && $v->STATUS==-7 ): ?>
                                                            <a href="<?php echo $url_prefix; ?>manage_parent/active/<?php echo $this->webspice->encrypt_decrypt($v->PARENT_ID,'encrypt'); ?>" class="btn btn-warning">Active</a>
                                                        <?php endif; ?>
                                                      </li>
                                                      <li>
                                                        <?php if( $this->webspice->permission_verify('manage_parent',true)): ?>
                                                            <a href="<?php echo $url_prefix; ?>manage_parent/delete/<?php echo $this->webspice->encrypt_decrypt($v->PARENT_ID,'encrypt'); ?>" class="btn btn-danger">Delete</a>
                                                        <?php endif; ?>
                                                      </li>
                                                    </ul>
                                                  </div>
                                                </td>
                                            </tr>
                                          <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
<!-- table end -->
                    
                    
                    
                </div>
        
            </div>
            
<?php include(APPPATH."views/admin/admin_footer.php"); ?>