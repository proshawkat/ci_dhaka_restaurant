<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
	}
	
	/*
	>> Error log should be added prefix Error:
	Log Prefix:
	login_attempt - Login Ateempt
	login_success
	unauthorized_access
	password_retrieve_request
	password_changed
	insert_error:
	
	>> status
	1=Pending | 2=Approved | 3=Resolved | 4=Forwarded  | 5=Deployed  | 6=New  | 7=Active  | 
	8=Initiated  | 9=On Progress  | 10=Delivered  | -2=Declined | -3=Canceled | 
	-5=Taking out | -6=Renewed/Replaced | -7=Inactive
	*/
	
	
	public function create_user($data=null){

		$url_prefix = $this->webspice->settings()->site_url_prefix;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_user');
		$this->webspice->permission_verify('create_user');
		
		if( !isset($data['edit']) ){
			$data['edit'] = array(
			'USER_ID'=>null,
			'USER_NAME'=>null,  
			'USER_EMAIL'=>null,
			'USER_PHONE'=>null,
			'USER_ROLE'=>null
			);
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user_name','user name','required|trim|xss_clean|max_length[50]');
		$this->form_validation->set_rules('user_email','user email','required|valid_email|trim|xss_clean|max_length[50]');
		$this->form_validation->set_rules('user_phone','user phone','required|trim|xss_clean|max_length[50]');
		$this->form_validation->set_rules('user_role','user role','required|trim|xss_clean');
		// $this->form_validation->set_rules('user_type','user type','required|trim|xss_clean|max_length[50]');
		// $this->form_validation->set_rules('company_id','company id','required|trim|xss_clean');

		if( !$this->form_validation->run() ){ 
			$this->load->view('admin/master/create_user', $data);
			return FALSE;
		}
		
		# get input post
		$input = $this->webspice->get_input('user_id');
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM user WHERE USER_EMAIL=?", array( $input->user_email), 'You are not allowed to enter duplicate user', 'USER_ID', $input->user_id, $data, 'admin/master/create_user');
		
		# remove cache
		$this->webspice->remove_cache('user');
		
		# update process
		if( $input->user_id ){
			#update query
			$sql = "
			UPDATE user SET USER_NAME=?, USER_EMAIL=?, USER_PHONE=?, ROLE_ID=?,n UPDATED_BY=?, UPDATED_DATE=? 
			WHERE USER_ID=?";
			$this->db->query($sql, array($input->user_name, $input->user_email, $input->user_phone, $input->user_role, $this->webspice->get_user_id(), $this->webspice->now(), $input->user_id)); 

			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('user_updated - '.$input->user_email); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_user');
			return false;
		}
		
		#create user
		$random_password = rand(1,5);
		$sql = "
		INSERT INTO user
		(USER_NAME, USER_EMAIL, USER_PHONE, USER_PASSWORD, ROLE_ID, CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		(?, ?, ?, ?, ?, ?, ?, 6)";
		$this->db->query($sql, array($input->user_name, $input->user_email, $input->user_phone,
		$this->webspice->encrypt_decrypt($random_password, 'encrypt'), $input->user_role, $this->webspice->get_user_id(), $this->webspice->now()));
		
		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
		
		# send verification email
		$this->load->library('email_template');
		$this->email_template->send_new_user_password_change_email($input->user_name, $input->user_email);
		
		$this->webspice->message_board('An account has been created and sent an email to the user.');
		$this->webspice->force_redirect($url_prefix . 'manage_user');
		 
	}

	public function create_student($data=null){

		$url_prefix = $this->webspice->settings()->site_url_prefix;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_student');
		$this->webspice->permission_verify('create_student');
		
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'USER_ID'=>null,
				'USER_NAME'=>null,
				'STUDENT_ID'=>null,
				'USER_EMAIL'=>null,
				'USER_PHONE'=>null,
				'USER_ROLE'=>null
			);
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('student_id','student name','required|trim|xss_clean');
		$this->form_validation->set_rules('user_role','user role','required|trim|xss_clean');

		if( !$this->form_validation->run() ){ 
			$this->load->view('admin/master/create_student', $data);
			return FALSE;
		}
		
		# get input post
		$input = $this->webspice->get_input('user_id');
		// dd($input);
		$stu_data = $this->db->query("SELECT * FROM student_info WHERE STUDENT_ID=".$input->student_id)->row();
		$input->user_name = $stu_data->NAME;
		$input->user_email = $stu_data->EMAIL;
		$input->user_phone = $stu_data->PHONE;
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM user WHERE STUDENT_ID=?", array($input->student_id), 'You are not allowed to enter duplicate student', 'USER_ID', $input->user_id, $data, 'admin/master/create_student');
		
		# remove cache
		$this->webspice->remove_cache('user_student');
		
		# update process
		if( $input->user_id ){
			#update query
			$sql = "
			UPDATE user SET USER_NAME=?, STUDENT_ID=?, USER_EMAIL=?, USER_PHONE=?, ROLE_ID=?,UPDATED_BY=?, UPDATED_DATE=? 
			WHERE USER_ID=?";
			$this->db->query($sql, array($input->user_name, $input->student_id, $input->user_email, $input->user_phone, $input->employee_id,$input->user_role, $this->webspice->get_user_id(), $this->webspice->now(), $input->user_id)); 

			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('user_updated - '.$input->user_email); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_user');
			return false;
		}
		
		#create user
		$random_password = rand(1,5);
		$sql = "
		INSERT INTO user
		(USER_NAME, USER_EMAIL, USER_PHONE, USER_PASSWORD, ROLE_ID, STUDENT_ID, CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		(?, ?, ?, ?, ?, ?, ?, ?, 6)";
		$this->db->query($sql, array($input->user_name, $input->user_email, $input->user_phone,
		$this->webspice->encrypt_decrypt($random_password, 'encrypt'), $input->user_role, $input->student_id, $this->webspice->get_user_id(), $this->webspice->now()));
		
		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
		
		# send verification email
		$this->load->library('email_template');
		$this->email_template->send_new_user_password_change_email($input->user_name, $input->user_email);
		
		$this->webspice->message_board('An account has been created and sent an email to the user.');
		$this->webspice->force_redirect($url_prefix . 'manage_user');
		 
	}

	public function create_teacher_user($data=null){

		$url_prefix = $this->webspice->settings()->site_url_prefix;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_teacher_user');
		$this->webspice->permission_verify('create_teacher_user');
		
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'USER_ID'=>null,
				'USER_NAME'=>null,
				'TEACHER_ID'=>null,
				'USER_EMAIL'=>null,
				'USER_PHONE'=>null,
				'USER_ROLE'=>null
			);
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('teacher_id','teacher name','required|trim|xss_clean');
		$this->form_validation->set_rules('user_role','user role','required|trim|xss_clean');

		if( !$this->form_validation->run() ){ 
			$this->load->view('admin/master/create_teacher', $data);
			return FALSE;
		}
		
		# get input post
		$input = $this->webspice->get_input('user_id');
		// dd($input);
		$teacher_data = $this->db->query("SELECT * FROM teacher WHERE TEACHER_ID=".$input->teacher_id)->row();
		$input->user_name = $teacher_data->TEACHER_NAME;
		$input->user_email = $teacher_data->EMAIL;
		$input->user_phone = $teacher_data->PHONE;
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM user WHERE TEACHER_ID=?", array($input->teacher_id), 'You are not allowed to enter duplicate teacher', 'USER_ID', $input->user_id, $data, 'admin/master/create_teacher');
		
		# remove cache
		$this->webspice->remove_cache('user_teacher');
		
		# update process
		if( $input->user_id ){
			#update query
			$sql = "
			UPDATE user SET USER_NAME=?, TEACHER_ID=?, USER_EMAIL=?, USER_PHONE=?, ROLE_ID=?,UPDATED_BY=?, UPDATED_DATE=? 
			WHERE USER_ID=?";
			$this->db->query($sql, array($input->user_name, $input->teacher_id, $input->user_email, $input->user_phone, $input->employee_id,$input->user_role, $this->webspice->get_user_id(), $this->webspice->now(), $input->user_id)); 

			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('user_updated - '.$input->user_email); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_user');
			return false;
		}
		
		#create user
		$random_password = rand(1,5);
		$sql = "
		INSERT INTO user
		(USER_NAME, USER_EMAIL, USER_PHONE, USER_PASSWORD, ROLE_ID, TEACHER_ID, CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		(?, ?, ?, ?, ?, ?, ?, ?, 6)";
		$this->db->query($sql, array($input->user_name, $input->user_email, $input->user_phone,
		$this->webspice->encrypt_decrypt($random_password, 'encrypt'), $input->user_role, $input->teacher_id, $this->webspice->get_user_id(), $this->webspice->now()));
		
		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
		
		# send verification email
		$this->load->library('email_template');
		$this->email_template->send_new_user_password_change_email($input->user_name, $input->user_email);
		
		$this->webspice->message_board('An account has been created and sent an email to the user.');
		$this->webspice->force_redirect($url_prefix . 'manage_user');
		 
	}

	public function create_parents($data=null){

		$url_prefix = $this->webspice->settings()->site_url_prefix;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_parents');
		$this->webspice->permission_verify('create_parents');
		
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'USER_ID'=>null,
				'USER_NAME'=>null,
				'PARENT_ID'=>null,
				'USER_EMAIL'=>null,
				'USER_PHONE'=>null,
				'USER_ROLE'=>null
			);
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('parent_id','parent name','required|trim|xss_clean');
		$this->form_validation->set_rules('user_role','user role','required|trim|xss_clean');

		if( !$this->form_validation->run() ){ 
			$this->load->view('admin/master/create_parents', $data);
			return FALSE;
		}
		
		# get input post
		$input = $this->webspice->get_input('user_id');
		// dd($input);
		$parent_data = $this->db->query("SELECT * FROM parent WHERE PARENT_ID=".$input->parent_id)->row();
		// dd($parent_data);
		$input->user_name = $parent_data->PARENT_NAME;
		$input->user_email = $parent_data->EMAIL;
		$input->user_phone = $parent_data->PHONE;
		$input->student_id = $parent_data->STUDENT_ID;
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM user WHERE PARENT_ID=?", array($input->parent_id), 'You are not allowed to enter duplicate parent', 'USER_ID', $input->user_id, $data, 'admin/master/create_parents');
		
		# remove cache
		$this->webspice->remove_cache('user_parent');
		
		# update process
		if( $input->user_id ){
			#update query
			$sql = "
			UPDATE user SET USER_NAME=?, PARENT_ID=?, STUDENT_ID=?, USER_EMAIL=?, USER_PHONE=?, ROLE_ID=?,UPDATED_BY=?, UPDATED_DATE=? 
			WHERE USER_ID=?";
			$this->db->query($sql, array($input->user_name, $input->parent_id, $input->student_id, $input->user_email, $input->user_phone, $input->employee_id,$input->user_role, $this->webspice->get_user_id(), $this->webspice->now(), $input->user_id)); 

			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('user_updated - '.$input->user_email); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_user');
			return false;
		}
		
		#create user
		$random_password = rand(1,5);
		$sql = "
		INSERT INTO user
		(USER_NAME, USER_EMAIL, USER_PHONE, USER_PASSWORD, ROLE_ID, PARENT_ID, STUDENT_ID, CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		(?, ?, ?, ?, ?, ?, ?, ?, ?, 6)";
		$this->db->query($sql, array($input->user_name, $input->user_email, $input->user_phone,
		$this->webspice->encrypt_decrypt($random_password, 'encrypt'), $input->user_role, $input->parent_id, $input->student_id, $this->webspice->get_user_id(), $this->webspice->now()));
		
		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
		
		# send verification email
		$this->load->library('email_template');
		$this->email_template->send_new_user_password_change_email($input->user_name, $input->user_email);
		
		$this->webspice->message_board('An account has been created and sent an email to the user.');
		$this->webspice->force_redirect($url_prefix . 'manage_user');
		 
	}

	function manage_user(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_user');
		$this->webspice->permission_verify('manage_user');

		$this->load->database();
	    $orderby = ' ORDER BY user.USER_ID DESC';
	    $groupby = null;
	    $where = '';
	    $page_index = 0;
	    $no_of_record = 20;
	    $limit = ' LIMIT '.$no_of_record;
	    $filter_by = 'Last Created';
	    $data['pager'] = null;
	    $criteria = $this->uri->segment(2);
	    $key = $this->uri->segment(3);
	    if ($criteria == 'page') {
	    	$page_index = (int)$key; 
	    	$page_index < 0 ? $page_index=0 : $page_index=$page_index;
	    }

			$initialSQL = "
			SELECT user.*,
			ROLE.ROLE_NAME
			FROM user
			LEFT JOIN ROLE ON ROLE.ROLE_ID = user.ROLE_ID "	;
	    
	   	# filtering records
	    if( $this->input->post('filter') ){
				$result = $this->webspice->filter_generator(
				$TableName = 'user', 
				$InputField = array(), 
				$Keyword = array('USER_ID','USER_NAME','USER_EMAIL','USER_PHONE'),
				$AdditionalWhere = null,
				$DateBetween = array('CREATED_DATE', 'date_from', 'date_end')
				);

				$result['where'] ? $where = $result['where'] : $where=$where;
				$result['filter'] ? $filter_by = $result['filter'] : $filter_by=$filter_by;
	   	}

	    # action area
	    switch ($criteria) {
			case 'print':
			case 'csv':
			if( !isset($_SESSION['sql']) || !$_SESSION['sql'] ){
				$_SESSION['sql'] = $initialSQL . $where . $orderby;
				$_SESSION['filter_by'] = $filter_by;
			}

			$record = $this->db->query( substr($_SESSION['sql'], 0, stripos($_SESSION['sql'],'LIMIT')) );										 		
			$data['get_record'] = $record->result();
			$data['filter_by'] = $_SESSION['filter_by'];

			$this->load->view('report/print_user',$data);
			return false;
			break;

			case 'edit':
			$this->webspice->edit_generator($TableName='user', $KeyField='USER_ID', $key, $RedirectController='master_controller', $RedirectFunction='create_user', $PermissionName='manage_user', $StatusCheck=null, $Log='edit_user');          
				return false;
			break;

			case 'inactive':
			$this->webspice->action_executer($TableName='user', $KeyField='USER_ID', $key, $RedirectURL='manage_user', $PermissionName='manage_user', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='user', $Log='inactive_user');
				return false;	
			break; 

			case 'active':
				$this->webspice->action_executer($TableName='user', $KeyField='USER_ID', $key, $RedirectURL='manage_user', $PermissionName='manage_user', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='user', $Log='active_user');
				return false;	
			break;                  
	    }
	    
	    # default
	    $sql = $initialSQL . $where . $groupby . $orderby . $limit;
	    
	    # only for pager
	    if( $criteria == 'page' ){
	    	if( !isset($_SESSION['sql']) || !$_SESSION['sql'] ){
	    		$sql = $sql;
	    	}
	    	$limit = sprintf("LIMIT %d, %d", $page_index, $no_of_record);		# this is to avoid SQL Injection
	    	$sql = substr($_SESSION['sql'], 0, strpos($_SESSION['sql'],'LIMIT'));
	    	$sql = $sql . $limit;
	    }
	    
		# load all records
		if( !$this->input->post('filter') ){
			$count_data = $this->db->query( substr($sql,0,strpos($sql,'LIMIT')) );
			$count_data = $count_data->result();
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_user/page/', 10 );
		}
	    
	    $_SESSION['sql'] = $sql;
	    $_SESSION['filter_by'] = $filter_by;
	    $result = $this->db->query($sql)->result();
	  	
		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/master/manage_user', $data);
	}
	
	function create_role($data=null){
		$url_prefix = $this->webspice->settings()->site_url_prefix;

		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_user');
		$this->webspice->permission_verify('create_role,manage_role');
		
		if( !isset($data['edit']) ){
			$data['edit'] = array(
			'ROLE_ID'=>null,
			'ROLE_NAME'=>null,  
			'PERMISSION_NAME'=>null
			);
		}
		
		# get permission name
		$sql = "
		SELECT permission.* 
		FROM permission
		WHERE permission.STATUS = 1
		GROUP BY permission.GROUP_NAME,permission.PERMISSION_NAME
		ORDER BY permission.GROUP_NAME
		";
		$data['get_permission'] = $this->db->query($sql);
		$result_set = $this->db->query($sql);
		$data['get_permission_data'] = $result_set->result();
		// dd($data);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('role_name','role_name','required|trim|xss_clean');

		if( !$this->form_validation->run() ){ 
			$this->load->view('admin/master/create_role', $data);
			return FALSE;
		}
		
		# get input post
		$input = $this->webspice->get_input('ROLE_ID');

		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM ROLE WHERE ROLE_NAME=?", array( $input->role_name), 'You are not allowed to enter duplicate role name.', 'ROLE_ID', $input->ROLE_ID, $data, 'admin/master/create_role');
		
		# remove cache
		$this->webspice->remove_cache('role');
		
		# update data
		if( $input->ROLE_ID ){
			#update query
			$sql = "
			UPDATE ROLE SET ROLE_NAME=?, PERMISSION_NAME=?, UPDATED_BY=?, UPDATED_DATE=? 
			WHERE ROLE_ID=?";
			$this->db->query($sql, array($input->role_name, implode(',',$input->permission), $this->webspice->get_user_id(), $this->webspice->now(), $input->ROLE_ID)); 

			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('role_updated - '.$input->role_name); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_role');
			return false;
		}
		
		# insert data
		$sql = "
		INSERT INTO ROLE
		(ROLE_NAME, PERMISSION_NAME, CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		(?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->role_name, implode(',',$input->permission), $this->webspice->get_user_id(), $this->webspice->now()));
		
		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
		
		$this->webspice->message_board('New Role has been created.');
		if( $this->webspice->permission_verify('manage_role', true) ){
			$this->webspice->force_redirect($url_prefix.'manage_role');
		}
		
		$this->webspice->force_redirect($url_prefix);
	}
	
	function manage_role(){
	$url_prefix = $this->webspice->settings()->site_url_prefix;
	
	$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_user');
	$this->webspice->permission_verify('manage_role');

	$this->load->database();
    $orderby = ' ORDER BY ROLE.ROLE_ID DESC';
    $groupby = null;
    $where = "WHERE ROLE.ROLE_NAME !='company_role' ";
    $page_index = 0;
    $no_of_record = 20;
    $limit = ' LIMIT '.$no_of_record;
    $filter_by = 'Last Created';
    $data['pager'] = null;
    $criteria = $this->uri->segment(2);
    $key = $this->uri->segment(3);
    if ($criteria == 'page') {
    	$page_index = (int)$key; 
    	$page_index < 0 ? $page_index=0 : $page_index=$page_index;
    }

	$initialSQL = "
	SELECT ROLE.*
	FROM ROLE  ";
    
   	# filtering records
    if( $this->input->post('filter') ){
		$result = $this->webspice->filter_generator(
		$TableName = 'ROLE', 
		$InputField = array(),
		$Keyword = array('ROLE_ID','ROLE_NAME','PERMISSION_NAME','CREATED_DATE','UPDATED_DATE'),
		$AdditionalWhere = null,
		$DateBetween = array('CREATED_DATE', 'date_from', 'date_end')
		);

		$result['where'] ? $where = str_replace('WHERE', 'WHERE (', $result['where']).')  AND ROLE.ROLE_NAME !="company_role"' : $where=$where;
		$result['filter'] ? $filter_by = $result['filter'] : $filter_by=$filter_by;	
			
   	}

    # action area
    switch ($criteria) {
		case 'print':
		case 'csv':
			if( !isset($_SESSION['sql']) || !$_SESSION['sql'] ){
				$_SESSION['sql'] = $initialSQL . $where . $orderby;
				$_SESSION['filter_by'] = $filter_by;
			}

			$record = $this->db->query( substr($_SESSION['sql'], 0, stripos($_SESSION['sql'],'LIMIT')) );										 		
			$data['get_record'] = $record->result();
			$data['filter_by'] = $_SESSION['filter_by'];

			$this->load->view('report/print_role',$data);
			return false;
		break;

		case 'edit':
			$this->webspice->edit_generator($TableName='ROLE', $KeyField='ROLE_ID', $key, $RedirectController='master_controller', $RedirectFunction='create_role', $PermissionName='create_role', $StatusCheck=null, $Log='edit_role');          
			return false;
		break; 

		case 'inactive':
			$this->webspice->action_executer($TableName='ROLE', $KeyField='ROLE_ID', $key, $RedirectURL='manage_role', $PermissionName='manage_role', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='role', $Log='inactive_role');
			return false;	
		break; 

		case 'active':
			$this->webspice->action_executer($TableName='ROLE', $KeyField='ROLE_ID', $key, $RedirectURL='manage_role', $PermissionName='manage_role', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='role', $Log='active_role');
			return false;	
		break;                  
    }
    
    # default
    $sql = $initialSQL . $where . $groupby . $orderby . $limit;	
    
    # only for pager
    if( $criteria == 'page' ){
    	if( !isset($_SESSION['sql']) || !$_SESSION['sql'] ){
    		$sql = $sql;
    	}
    	$limit = sprintf("LIMIT %d, %d", $page_index, $no_of_record);		# this is to avoid SQL Injection
    	$sql = substr($_SESSION['sql'], 0, strpos($_SESSION['sql'],'LIMIT'));
    	$sql = $sql . $limit;
    }
    
	# load all records for pager
	if( !$this->input->post('filter') ){
		$count_data = $this->db->query( substr($sql,0,strpos($sql,'LIMIT')) );
		$count_data = $count_data->result();
		$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_role/page/', 10 );
	}
    
    $_SESSION['sql'] = $sql;
    $_SESSION['filter_by'] = $filter_by;
    $result = $this->db->query($sql)->result();
  	
	$data['get_record'] = $result;
	$data['filter_by'] = $filter_by;

	$this->load->view('admin/master/manage_role', $data);
	}
	
	
	
	# call confirmation for redirect another url with message
	function confirmation($message){
		$_SESSION['confirmation'] = $message;
		$this->webspice->force_redirect($this->webspice->settings()->site_url_prefix.'confirmation');
	}
	
	function show_confirmation(){
		if( !isset($_SESSION['confirmation']) ){
			$_SESSION['confirmation'] = array();	
		}
		$data = $_SESSION['confirmation'];
		$this->load->view('view_message',$data);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */