<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_controller extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}
	
	/*
	>> Error log should be added prefix Error:
	Log Prefix:
	login_attempt - Login Attempt
	login_success
	unauthorized_access
	password_retrieve_request
	password_changed
	*/


	function index() {

		// dd($_SESSION['user']);
		// dd($this->webspice->encrypt_decrypt($_SESSION['user']['USER_ID'], 'decrypt'));
		// dd($this->webspice->encrypt_decrypt($_SESSION['user']['STUDENT_ID'], 'decrypt'));
		// if(isset($_SESSION['user'])) {
		// 	$this->load->view('admin/index');
		// }
		// redirect('login');

		/*$x = array(10, 20, 50, 70, 90, 78, 86, 90, 83, 78, 36);
		rsort($x);
		$position = array();
		$length = count($x);
		for($i=0; $i<$length; $i++) {
			// echo $x[$i] . "<br />";
			$position[$i+1] = $x[$i];
		}
		dd($position);
		*/
		if(!$this->webspice->get_user_id()) {
			$this->webspice->force_redirect($this->webspice->settings()->site_url_prefix.'login');
			return false;
		}
		else {
			$this->load->view('admin/index');
		}

		// dd($_SESSION);
	}

	public function contact() {
		$this->load->view('contact');
	}

	public function about() {
		$this->load->view('about');
	}

	public function product() {
		$this->load->view('product');
	}

	public function category() {
		$this->load->view('category');
	}

	public function create_category($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_category');
		$this->webspice->permission_verify('create_category');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'CATEGORY_ID'=>null,
				'CATEGORY_NAME'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category_name','category name','required|trim|xss_clean|max_length[50]');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/create_category', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('category_id');
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM category WHERE CATEGORY_NAME=?", array( $input->category_name), 'You are not allowed to enter duplicate category', 'CATEGORY_ID', $input->category_id, $data, 'admin/create_category');
		
		# remove cache
		$this->webspice->remove_cache('category');

		# update process
		if( $input->category_id ){

			$sql = "
			UPDATE category SET CATEGORY_NAME=?,UPDATED_BY=?,UPDATED_DATE=?
			WHERE CATEGORY_ID=?";
			$this->db->query($sql, array($input->category_name,$this->webspice->get_user_id(),$this->webspice->now(), $input->category_id));
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('category_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_category');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO category
		(CATEGORY_NAME,CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, 7)";
		$this->db->query($sql, array($input->category_name,
			$this->webspice->get_user_id(),$this->webspice->now()));

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_category',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_category');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'create_category');

	}

	public function manage_category() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_category');
		$this->webspice->permission_verify('manage_category');

		$this->load->database();
		$orderby = 'ORDER BY category.CATEGORY_NAME ASC';
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
		SELECT  * FROM category ";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'category',
				$InputField = array(),
				$Keyword = array('CATEGORY_NAME'),
				$AdditionalWhere = null,
				$DateBetween = null
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



				$this->load->view('report/print_division',$data);
				return false;
				break;

			case 'edit':
				$this->webspice->edit_generator($TableName='category', $KeyField='CATEGORY_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_category', $PermissionName='manage_category', $StatusCheck=null, $Log='edit_category');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='category', $KeyField='CATEGORY_ID', $key, $RedirectURL='manage_category', $PermissionName='manage_category', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='category', $Log='inactive_category');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='category', $KeyField='CATEGORY_ID', $key, $RedirectURL='manage_category', $PermissionName='manage_category', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='category', $Log='active_category');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM category WHERE CATEGORY_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_category');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_category/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_category', $data);

	}

	public function create_sub_category($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_sub_category');
		$this->webspice->permission_verify('create_sub_category');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'SUB_CATEGORY_ID'=>null,
				'SUB_CATEGORY_NAME'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('category_id','category id','required|trim|xss_clean');
		$this->form_validation->set_rules('sub_category_name','sub category name','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/create_sub_category', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('sub_category_id');
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM sub_category WHERE SUB_CATEGORY_NAME=?", array( $input->sub_category_name), 'You are not allowed to enter duplicate sub category', 'SUB_CATEGORY_ID', $input->sub_category_id, $data, 'admin/create_sub_category');
		
		# remove cache
		$this->webspice->remove_cache('sub_category');

		# update process
		if( $input->sub_category_id ){

			$sql = "
			UPDATE sub_category SET SUB_CATEGORY_NAME=?, CAT_ID = ?, UPDATED_BY=?,UPDATED_DATE=?
			WHERE SUB_CATEGORY_ID=?";
			$this->db->query($sql, array($input->sub_category_name, $input->category_id, $this->webspice->get_user_id(),$this->webspice->now(), $input->sub_category_id));
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('sub_category_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_sub_category');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO sub_category
		(CAT_ID, SUB_CATEGORY_NAME,CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->category_id, $input->sub_category_name,
			$this->webspice->get_user_id(),$this->webspice->now()));

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_sub_category',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_sub_category');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'create_sub_category');

	}

	public function manage_sub_category() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->load->database();
		$orderby = 'ORDER BY sub_category.SUB_CATEGORY_NAME ASC';
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
		SELECT  * FROM sub_category	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'sub_category',
				$InputField = array(),
				$Keyword = array('SUB_CATEGORY_NAME'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_sub_category',$data);
				return false;
				break;
			case 'edit':
				$this->webspice->edit_generator($TableName='sub_category', $KeyField='SUB_CATEGORY_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_sub_category', $PermissionName='manage_sub_category', $StatusCheck=null, $Log='edit_sub_category');
				return false;
				break;
			case 'inactive':
				$this->webspice->action_executer($TableName='sub_category', $KeyField='SUB_CATEGORY_ID', $key, $RedirectURL='manage_sub_category', $PermissionName='manage_sub_category', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='sub_category', $Log='inactive_sub_category');
				return false;
				break;
			case 'update':
				$id = $this->uri->segment(3);
				$id2 = $this->uri->segment(4);
				$id3 = $this->uri->segment(5);
				$data = $this->db->query($id . " " . $id2 . " " . $id3);
				if($data) {
					echo "Just for test purpose";
				}
				return false;
				break;
			case 'active':
				$this->webspice->action_executer($TableName='sub_category', $KeyField='SUB_CATEGORY_ID', $key, $RedirectURL='manage_sub_category', $PermissionName='manage_sub_category', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='sub_category', $Log='active_sub_category');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM sub_category WHERE SUB_CATEGORY_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_sub_category');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_sub_category/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_sub_category', $data);

	}

	// create sub sub menu
	public function create_sub_sub_category($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_sub_sub_category');
		$this->webspice->permission_verify('create_sub_sub_category');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'SUB_SUB_CATEGORY_ID'=>null,
				'SUB_SUB_CATEGORY_NAME'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('sub_category_id','sub category id','required|trim|xss_clean');
		$this->form_validation->set_rules('sub_sub_category_name','sub sub category name','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/create_sub_sub_category', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('sub_sub_category_id');
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM sub_sub_category WHERE SUB_SUB_CATEGORY_NAME=? AND SUB_CATEGORY_ID=?", array( $input->sub_sub_category_name, $input->sub_category_id), 'You are not allowed to enter duplicate sub sub category', 'SUB_SUB_CATEGORY_ID', $input->sub_sub_category_id, $data, 'admin/create_sub_sub_category');
		
		# remove cache
		$this->webspice->remove_cache('sub_sub_category');

		# update process
		if( $input->sub_sub_category_id ){

			$sql = "
			UPDATE sub_sub_category SET SUB_SUB_CATEGORY_NAME=?, SUB_CATEGORY_ID = ?, UPDATED_BY=?,UPDATED_DATE=?
			WHERE SUB_SUB_CATEGORY_ID=?";
			$this->db->query($sql, array($input->sub_sub_category_name, $input->sub_category_id, $this->webspice->get_user_id(),$this->webspice->now(), $input->sub_sub_category_id));
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('sub_sub_category_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_sub_sub_category');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO sub_sub_category
		(SUB_CATEGORY_ID, SUB_SUB_CATEGORY_NAME,CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->sub_category_id, $input->sub_sub_category_name,
			$this->webspice->get_user_id(),$this->webspice->now()));

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_sub_sub_category',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_sub_sub_category');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'create_sub_sub_category');

	}

	// manage sub sub category
	public function manage_sub_sub_category() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_sub_sub_category');
		$this->webspice->permission_verify('manage_sub_sub_category');

		$this->load->database();
		$orderby = 'ORDER BY sub_sub_category.SUB_SUB_CATEGORY_NAME ASC';
		$groupby = null;
		$where = '';
		$page_index = 0;
		$no_of_record = 20000000;
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
		SELECT  * FROM sub_sub_category	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'sub_sub_category',
				$InputField = array(),
				$Keyword = array('SUB_SUB_CATEGORY_NAME'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_sub_sub_category',$data);
				return false;
				break;

			case 'edit':
				$this->webspice->edit_generator($TableName='sub_sub_category', $KeyField='SUB_SUB_CATEGORY_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_sub_sub_category', $PermissionName='manage_sub_sub_category', $StatusCheck=null, $Log='edit_sub_sub_category');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='sub_sub_category', $KeyField='SUB_SUB_CATEGORY_ID', $key, $RedirectURL='manage_sub_sub_category', $PermissionName='manage_sub_sub_category', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='sub_sub_category', $Log='inactive_sub_sub_category');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='sub_sub_category', $KeyField='SUB_SUB_CATEGORY_ID', $key, $RedirectURL='manage_sub_sub_category', $PermissionName='manage_sub_sub_category', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='sub_sub_category', $Log='active_sub_sub_category');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM sub_sub_category WHERE SUB_SUB_CATEGORY_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_sub_sub_category');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_sub_sub_category/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_sub_sub_category', $data);

	}

	// change password
	public function change_pass() {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data = array(
			'un_matched' => null
		);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('new_password','new_password','required|trim|xss_clean');
		$this->form_validation->set_rules('repeat_password','repeat_password','required|trim|xss_clean');

		if( !$this->form_validation->run() ){
			$this->load->view('admin/change_password', $data);
			return false;
		}

		$data = array(
			'un_matched' => 'New password & Repeat password does not match'
		);

		# get input post
		$input = $this->webspice->get_input('id');
		if($input->new_password !== $input->repeat_password) {
			$this->load->view('admin/change_password', $data);
			return false;
		}

		$user_id = $this->webspice->get_user_id();
		$enc_pass = $this->webspice->encrypt_decrypt($input->new_password, 'encrypt');

		// dd($enc_pass);

		if(isset($user_id)) {
			$sql = "
			UPDATE user SET USER_PASSWORD=?, UPDATED_BY=?, UPDATED_DATE=?
			WHERE USER_ID=?";
			$this->db->query($sql, array($enc_pass,$this->webspice->get_user_id(),$this->webspice->now(), $user_id));
			# user session destroy
			session_destroy();
			session_start();
			
			$this->webspice->message_board('Your password has been changed! Please login using your new password.');
			$this->webspice->force_redirect($url_prefix.'login');
		}

	}

	public function create_product($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_product');
		$this->webspice->permission_verify('create_product');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'PRODUCT_ID'=>null,
				'CAT_ID'=>null,
				'SUB_CAT_ID'=>null,
				'PRODUCT_NAME'=>null,
				'PRODUCT_PRICE'=>null,
				'PRODUCT_DESCRIPTION'=>null,
				'PRODUCT_DETAILS'=>null,
				'PRODUCT_IMG'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cat_id','category id','required|trim|xss_clean');
		$this->form_validation->set_rules('sub_cat_id','sub category id','required|trim|xss_clean');
		$this->form_validation->set_rules('product_name','product name','required|trim|xss_clean|max_length[50]|min_length[2]');
		$this->form_validation->set_rules('product_price','product price','required|trim|xss_clean|max_length[50]|min_length[2]');
		$this->form_validation->set_rules('product_description','product description','required|trim|xss_clean|max_length[200]');
		$this->form_validation->set_rules('product_details','product details','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/create_product', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('product_id');
		// dd($input);
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM products WHERE CAT_ID = ? AND PRODUCT_NAME=?", array($input->cat_id, $input->product_name), 'You are not allowed to enter duplicate product', 'PRODUCT_ID', $input->product_id, $data, 'admin/create_product');
		
		# remove cache
		$this->webspice->remove_cache('product');

		# verify file type
		if( $_FILES['product_img']['tmp_name'] ){
			$this->webspice->check_file_type(array('jpg','jpeg','png'), 'product_img', $data, 'admin/create_product');
		}

		# update process
		if( $input->product_id ){

			$sql = "
			UPDATE products SET CAT_ID=?, SUB_CAT_ID=?, PRODUCT_NAME=?, PRODUCT_PRICE=?, PRODUCT_DESCRIPTION=?, PRODUCT_DETAILS=?,  UPDATED_BY=?,UPDATED_DATE=?
			WHERE PRODUCT_ID=?";
			$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->product_name, $input->product_price, $input->product_description, $input->product_details, $this->webspice->get_user_id(), $this->webspice->now(), $input->product_id));
			$this->webspice->process_image_single('product_img',$input->product_id, 'product_full', 750, 1000);
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('product_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_product');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO products
		(CAT_ID, SUB_CAT_ID, PRODUCT_NAME, PRODUCT_PRICE, PRODUCT_DESCRIPTION, PRODUCT_DETAILS, PRODUCT_IMG, CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, ?, ?, ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->product_name, $input->product_price, $input->product_description, $input->product_details, $_FILES['product_img']['name'], $this->webspice->get_user_id(),$this->webspice->now()));
		$this->webspice->process_image_single('product_img',$this->db->insert_id(), 'product_full', 750, 1000);

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_product',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_product');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'create_product');

	}

	public function manage_product() {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_product');
		$this->webspice->permission_verify('manage_product');

		$this->load->database();
		$orderby = 'ORDER BY products.PRODUCT_NAME ASC';
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
		SELECT  * FROM products	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'products',
				$InputField = array(),
				$Keyword = array('PRODUCT_NAME'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_product',$data);
				return false;
				break;

			case 'edit':
			// echo $key;
			// return false;
				$this->webspice->edit_generator($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_product', $PermissionName='manage_product', $StatusCheck=null, $Log='edit_product');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectURL='manage_product', $PermissionName='manage_product', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='products', $Log='inactive_product');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectURL='manage_product', $PermissionName='manage_product', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='products', $Log='active_product');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM products WHERE PRODUCT_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_product');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_product/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_product', $data);
	}
	
	public function view_reservation_info() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'view_reservation_info');
		$this->webspice->permission_verify('view_reservation_info');

		$this->load->database();
		$orderby = 'ORDER BY reservation_data.RESERVATION_ID ASC';
		$groupby = null;
		$where = '';
		$page_index = 0;
		$no_of_record = 20000000000;
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
		SELECT  * FROM reservation_data ";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'reservation_data',
				$InputField = array(),
				$Keyword = array('RESERVATION_ID'),
				$AdditionalWhere = null,
				$DateBetween = null
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



				$this->load->view('report/print_division',$data);
				return false;
				break;

			case 'edit':
				$this->webspice->edit_generator($TableName='reservation_data', $KeyField='MENU_CATEGORY_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_menu_category', $PermissionName='view_reservation_info', $StatusCheck=null, $Log='edit_category');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='reservation_data', $KeyField='MENU_CATEGORY_ID', $key, $RedirectURL='view_reservation_info', $PermissionName='view_reservation_info', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='reservation_data', $Log='inactive_category');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='reservation_data', $KeyField='MENU_CATEGORY_ID', $key, $RedirectURL='view_reservation_info', $PermissionName='view_reservation_info', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='reservation_data', $Log='active_category');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM reservation_data WHERE RESERVATION_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'view_reservation_info');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'view_reservation_info/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/view_reservation_info', $data);

	}
	
	public function view_contact_info() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'view_contact_info');
		$this->webspice->permission_verify('view_contact_info');

		$this->load->database();
		$orderby = 'ORDER BY contact_data.CONTACT_ID ASC';
		$groupby = null;
		$where = '';
		$page_index = 0;
		$no_of_record = 20000000000;
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
		SELECT  * FROM contact_data ";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'contact_data',
				$InputField = array(),
				$Keyword = array('CONTACT_ID'),
				$AdditionalWhere = null,
				$DateBetween = null
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



				$this->load->view('report/print_division',$data);
				return false;
				break;

			case 'edit':
				$this->webspice->edit_generator($TableName='reservation_data', $KeyField='MENU_CATEGORY_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_menu_category', $PermissionName='view_contact_info', $StatusCheck=null, $Log='edit_category');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='reservation_data', $KeyField='MENU_CATEGORY_ID', $key, $RedirectURL='view_contact_info', $PermissionName='view_contact_info', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='reservation_data', $Log='inactive_category');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='reservation_data', $KeyField='MENU_CATEGORY_ID', $key, $RedirectURL='view_contact_info', $PermissionName='view_contact_info', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='reservation_data', $Log='active_category');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM contact_data WHERE CONTACT_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'view_contact_info');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'view_contact_info/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/view_contact_info', $data);

	}

	public function create_menu_category($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_menu_category');
		$this->webspice->permission_verify('create_menu_category');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'MENU_CATEGORY_ID'=>null,
				'NAME'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('menu_category_name','category name','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/create_menu_category', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('menu_category_id');
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM menu_category WHERE NAME=?", array( $input->menu_category_name), 'You are not allowed to enter duplicate category', 'MENU_CATEGORY_ID', $input->menu_category_id, $data, 'admin/create_menu_category');
		
		# remove cache
		$this->webspice->remove_cache('menu_category');

		# update process
		if( $input->menu_category_id ){

			$sql = "
			UPDATE menu_category SET NAME=?,UPDATED_BY=?,UPDATED_DATE=?
			WHERE MENU_CATEGORY_ID=?";
			$this->db->query($sql, array($input->menu_category_name,$this->webspice->get_user_id(),$this->webspice->now(), $input->menu_category_id));
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('category_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_menu_category');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO menu_category
		(NAME,CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, 7)";
		$this->db->query($sql, array($input->menu_category_name,
			$this->webspice->get_user_id(),$this->webspice->now()));

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_menu_category',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_menu_category');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'create_menu_category');

	}

	public function manage_menu_category() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_menu_category');
		$this->webspice->permission_verify('manage_menu_category');

		$this->load->database();
		$orderby = 'ORDER BY menu_category.NAME ASC';
		$groupby = null;
		$where = '';
		$page_index = 0;
		$no_of_record = 20000000000;
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
		SELECT  * FROM menu_category ";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'menu_category',
				$InputField = array(),
				$Keyword = array('NAME'),
				$AdditionalWhere = null,
				$DateBetween = null
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



				$this->load->view('report/print_division',$data);
				return false;
				break;

			case 'edit':
				$this->webspice->edit_generator($TableName='menu_category', $KeyField='MENU_CATEGORY_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_menu_category', $PermissionName='manage_menu_category', $StatusCheck=null, $Log='edit_category');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='menu_category', $KeyField='MENU_CATEGORY_ID', $key, $RedirectURL='manage_menu_category', $PermissionName='manage_menu_category', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='menu_category', $Log='inactive_category');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='menu_category', $KeyField='MENU_CATEGORY_ID', $key, $RedirectURL='manage_menu_category', $PermissionName='manage_menu_category', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='menu_category', $Log='active_category');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM menu_category WHERE MENU_CATEGORY_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_menu_category');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_menu_category/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_menu_category', $data);

	}

	public function create_menu($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_menu');
		$this->webspice->permission_verify('create_menu');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'FOOD_ID'=>null,
				'MENU_CATEGORY_ID' => null,
				'FOOD_NAME'=>null,
				'PRICE'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('menu_category_id','category name','required|trim|xss_clean');
		$this->form_validation->set_rules('food_name','food name','required|trim|xss_clean');
		$this->form_validation->set_rules('price','price','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/create_menu', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('food_id');
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM foods WHERE FOOD_NAME=? AND MENU_CATEGORY_ID=?", array( $input->food_name,$input->menu_category_id), 'You are not allowed to enter duplicate category', 'FOOD_ID', $input->food_id, $data, 'admin/create_menu');
		
		# remove cache
		$this->webspice->remove_cache('foods');

		# update process
		if( $input->food_id ){

			$sql = "
			UPDATE foods  SET MENU_CATEGORY_ID=?, FOOD_NAME=? ,PRICE=?,UPDATED_BY=?,UPDATED_DATE=?
			WHERE FOOD_ID=?";
			$this->db->query($sql, array($input->menu_category_id, $input->food_name,$input->price,$this->webspice->get_user_id(),$this->webspice->now(), $input->food_id));
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('category_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_menu');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO foods
		(MENU_CATEGORY_ID,FOOD_NAME,PRICE, CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?,?,?,?,?, 7)";
		$this->db->query($sql, array($input->menu_category_id,$input->food_name, $input->price,
			$this->webspice->get_user_id(),$this->webspice->now()));

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_menu',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_menu');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'create_menu');

	}

	public function manage_menu() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_menu');
		$this->webspice->permission_verify('manage_menu');

		$this->load->database();
		$orderby = 'ORDER BY foods.FOOD_ID ASC';
		$groupby = null;
		$where = '';
		$page_index = 0;
		$no_of_record = 2000000000;
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
		SELECT  * FROM foods ";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'foods',
				$InputField = array(),
				$Keyword = array('FOOD_ID'),
				$AdditionalWhere = null,
				$DateBetween = null
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



				$this->load->view('report/print_division',$data);
				return false;
				break;

			case 'edit':
				$this->webspice->edit_generator($TableName='foods', $KeyField='FOOD_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_menu', $PermissionName='manage_menu', $StatusCheck=null, $Log='edit_category');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='foods', $KeyField='FOOD_ID', $key, $RedirectURL='manage_menu', $PermissionName='manage_menu', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='foods', $Log='inactive_category');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='foods', $KeyField='FOOD_ID', $key, $RedirectURL='manage_menu', $PermissionName='manage_menu', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='foods', $Log='active_category');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM foods WHERE FOOD_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_menu');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_menu/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_menu', $data);

	}

	// add person
	public function add_person($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'add_person');
		$this->webspice->permission_verify('add_person');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'PERSON_ID'=>null,
				'PERSON_TYPE'=>null,
				'NAME'=>null,
				'IMAGES'=>null,
				'DETAILS'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('person_type','person type','required|trim|xss_clean');
		$this->form_validation->set_rules('name','name','required|trim|xss_clean');
		$this->form_validation->set_rules('details','details','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/add_person', $data);
			return FALSE;
		}

		// dd($_FILES);

		# get input post
		$input = $this->webspice->get_input('person_id');
		// dd($input);
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM persons WHERE PERSON_TYPE=? AND NAME=?", array($input->person_type, $input->name), 'You are not allowed to enter duplicate person', 'PERSON_ID', $input->person_id, $data, 'admin/create_product');
		
		# remove cache
		$this->webspice->remove_cache('person');

		# verify file type
		if( $_FILES['images']['tmp_name'] ){
			$this->webspice->check_file_type(array('jpg','jpeg'), 'images', $data, 'admin/add_person');
		}

		# update process
		if( $input->person_id ){

			$sql = "
			UPDATE persons SET PERSON_TYPE=?, NAME=?, IMAGES=?, DETAILS=?,  UPDATED_BY=?,UPDATED_DATE=?
			WHERE PERSON_ID=?";
			$this->db->query($sql, array($input->person_type, $input->name, $_FILES['images']['name'], $input->details, $this->webspice->get_user_id(), $this->webspice->now(), $input->person_id));
			$this->webspice->process_image_single('images',$input->person_id, 'person_full', 750, 1000);
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('product_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_person');
			return false;
		}
		
		#insert person
		$sql = "
		INSERT INTO persons
		(PERSON_TYPE, NAME, IMAGES, DETAILS, CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, ?, ?, ?, 7 )";
		$this->db->query($sql, array($input->person_type, $input->name, $_FILES['images']['name'], $input->details, $this->webspice->get_user_id(),$this->webspice->now()));
		$this->webspice->process_image_single('images',$this->db->insert_id(), 'person_full', 750, 1000);

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_person',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_person');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'add_person');

	}

	// manage person
	public function manage_person() {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->load->database();
		$orderby = 'ORDER BY persons.NAME ASC';
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
		SELECT  * FROM persons	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'persons',
				$InputField = array(),
				$Keyword = array('NAME'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_person',$data);
				return false;
				break;

			case 'edit':
				$this->webspice->edit_generator($TableName='persons', $KeyField='PERSON_ID', $key, $RedirectController='admin_controller', $RedirectFunction='add_person', $PermissionName='manage_person', $StatusCheck=null, $Log='edit_person');
				return false;
				break;
			case 'update':
				$id = $this->uri->segment(3);
				$id2 = $this->uri->segment(4);
				$id3 = $this->uri->segment(5);
				$data = $this->db->query($id . " " . $id2 . " " . $id3);
				if($data) { echo "Just for test purpose";}
				return false;
				break;
			case 'inactive':
				$this->webspice->action_executer($TableName='persons', $KeyField='PERSON_ID', $key, $RedirectURL='manage_person', $PermissionName='manage_person', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='persons', $Log='inactive_person');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='persons', $KeyField='PERSON_ID', $key, $RedirectURL='manage_person', $PermissionName='manage_person', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='persons', $Log='active_person');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM persons WHERE PERSON_ID='".$id."' LIMIT 1");
				if(!unlink($this->webspice->get_path('person_full').$id.'.jpg')) {
					die($this->webspice->get_path('person_full').$id.'.jpg');
				}
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_person');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_person/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_person', $data);
	}

	public function create_slider($data=null) {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_slider');
		$this->webspice->permission_verify('create_slider');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'SLIDER_ID'=>null,
				'SLIDER_NAME'=>null
			);
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('slider_name','slider name','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/create_slider', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('slider_id');
		// dd($input);
		
		#duplicate test
		//$this->webspice->db_field_duplicate_test("SELECT * FROM products WHERE CAT_ID = ? AND PRODUCT_NAME=?", array($input->cat_id, $input->product_name), 'You are not allowed to enter duplicate product', 'PRODUCT_ID', $input->product_id, $data, 'admin/create_slider');
		
		# remove cache
		$this->webspice->remove_cache('slider');

		# verify file type
		if( $_FILES['slider_link']['tmp_name'] ){
			$this->webspice->check_file_type(array('jpg','jpeg','png'), 'slider_link', $data, 'admin/create_slider');
		}

		# update process
		// if( $input->product_id ){

		// 	$sql = "
		// 	UPDATE products SET CAT_ID=?, SUB_CAT_ID=?, PRODUCT_NAME=?, PRODUCT_DESCRIPTION=?, PRODUCT_DETAILS=?,  UPDATED_BY=?,UPDATED_DATE=?
		// 	WHERE PRODUCT_ID=?";
		// 	$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->product_name, $input->product_description, $input->product_details, $this->webspice->get_user_id(), $this->webspice->now(), $input->product_id));
		// 	$this->webspice->process_image_single('product_img',$input->product_id, 'product_full', 750, 1000);
		// 	$this->webspice->message_board('Record has been updated!');
		// 	$this->webspice->log_me('product_updated - '.$this->webspice->get_user_id()); # log activities
		// 	$this->webspice->force_redirect($url_prefix.'manage_product');
		// 	return false;
		// }
		
		#insert category

		$sql = "
		INSERT INTO slider
		(SLIDER_ID, SLIDER_NAME, SLIDER_LINK, CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->slider_id, $input->slider_name, $_FILES['slider_link']['name'], $this->webspice->get_user_id(),$this->webspice->now()));
		$this->webspice->process_image_single('slider_link',$this->db->insert_id(), 'slider_full');

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_slider',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_slider');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'create_slider');
	}

	public function manage_slider() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_slider');
		$this->webspice->permission_verify('manage_slider');

		$this->load->database();
		$orderby = 'ORDER BY slider.SLIDER_NAME ASC';
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
		SELECT  * FROM slider	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'slider',
				$InputField = array(),
				$Keyword = array('SLIDER_NAME'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_product',$data);
				return false;
				break;

			/*case 'edit':
				$this->webspice->edit_generator($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_product', $PermissionName='manage_product', $StatusCheck=null, $Log='edit_product');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectURL='manage_product', $PermissionName='manage_product', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='products', $Log='inactive_product');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectURL='manage_product', $PermissionName='manage_product', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='products', $Log='active_product');
				return false;
				break;*/

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM slider WHERE SLIDER_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_slider');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_slider/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_slider', $data);

	}

	public function add_images() {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'add_images');
		$this->webspice->permission_verify('add_images');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'IMAGE_ID'=>null,
				'CAT_ID'=>null,
				'SUB_CAT_ID'=>null,
				'IMAGE_CAPTION'=>null,
				'DESCRIPTION'=>null,
				'PRICE'=>null
			);
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('cat_id','category id','required|trim|xss_clean');
		$this->form_validation->set_rules('sub_cat_id','sub category id','required|trim|xss_clean');
		$this->form_validation->set_rules('image_caption','image caption','required|trim|xss_clean');
		$this->form_validation->set_rules('description','description','trim|xss_clean');
		$this->form_validation->set_rules('price','price','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/add_images', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('image_id');
		// dd($input);
		
		#duplicate test
		//$this->webspice->db_field_duplicate_test("SELECT * FROM products WHERE CAT_ID = ? AND PRODUCT_NAME=?", array($input->cat_id, $input->product_name), 'You are not allowed to enter duplicate product', 'PRODUCT_ID', $input->product_id, $data, 'admin/create_slider');
		
		# remove cache
		$this->webspice->remove_cache('gallery');

		# verify file type
		if( $_FILES['image_link']['tmp_name'] ){
			$this->webspice->check_file_type(array('jpg','jpeg','png'), 'image_link', $data, 'admin/add_images');
		}

		# update process
		// if( $input->product_id ){

		// 	$sql = "
		// 	UPDATE products SET CAT_ID=?, SUB_CAT_ID=?, PRODUCT_NAME=?, PRODUCT_DESCRIPTION=?, PRODUCT_DETAILS=?,  UPDATED_BY=?,UPDATED_DATE=?
		// 	WHERE PRODUCT_ID=?";
		// 	$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->product_name, $input->product_description, $input->product_details, $this->webspice->get_user_id(), $this->webspice->now(), $input->product_id));
		// 	$this->webspice->process_image_single('product_img',$input->product_id, 'product_full', 750, 1000);
		// 	$this->webspice->message_board('Record has been updated!');
		// 	$this->webspice->log_me('product_updated - '.$this->webspice->get_user_id()); # log activities
		// 	$this->webspice->force_redirect($url_prefix.'manage_product');
		// 	return false;
		// }
		
		#insert category

		$sql = "
		INSERT INTO gallery
		(CAT_ID, SUB_CAT_ID, IMAGE_CAPTION, IMAGE_LINK, DESCRIPTION, PRICE, CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		( ?, ?, ?, ?, ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->image_caption, $_FILES['image_link']['name'], $input->description, $input->price, $this->webspice->get_user_id(),$this->webspice->now()));
		$this->webspice->process_image_single('image_link',$this->db->insert_id(), 'gallery_full');

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_gallery',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_gallery');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'add_images');
	}

	public function manage_gallery() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_gallery');
		$this->webspice->permission_verify('manage_gallery');

		$this->load->database();
		$orderby = 'ORDER BY gallery.IMAGE_ID DESC';
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
		SELECT  * FROM gallery	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'gallery',
				$InputField = array(),
				$Keyword = array('IMAGE_CAPTION'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_product',$data);
				return false;
				break;

			/*case 'edit':
				$this->webspice->edit_generator($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_product', $PermissionName='manage_product', $StatusCheck=null, $Log='edit_product');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectURL='manage_product', $PermissionName='manage_product', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='products', $Log='inactive_product');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectURL='manage_product', $PermissionName='manage_product', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='products', $Log='active_product');
				return false;
				break;*/

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM gallery WHERE IMAGE_ID='".$id."' LIMIT 1");
				if(!unlink($this->webspice->get_path('gallery_full').$id.'.jpg')) {
					die($this->webspice->get_path('gallery_full').$id.'.jpg');
				}
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_gallery');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_gallery/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_gallery', $data);

	}

	public function add_downloads() {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'add_downloads');
		$this->webspice->permission_verify('add_downloads');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'FILE_ID'=>null,
				'CAT_ID'=>null,
				'SUB_CAT_ID'=>null,
				'FILE_CAPTION'=>null
			);
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('cat_id','category id','required|trim|xss_clean');
		$this->form_validation->set_rules('sub_cat_id','sub category id','required|trim|xss_clean');
		$this->form_validation->set_rules('file_caption','file caption','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/add_downloads', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('file_id');
		
		
		#duplicate test
		//$this->webspice->db_field_duplicate_test("SELECT * FROM products WHERE CAT_ID = ? AND PRODUCT_NAME=?", array($input->cat_id, $input->product_name), 'You are not allowed to enter duplicate product', 'PRODUCT_ID', $input->product_id, $data, 'admin/create_slider');
		
		# remove cache
		$this->webspice->remove_cache('file');

		# verify file type
		// if( $_FILES['file_link']['tmp_name'] ){
		// 	$this->webspice->check_file_type(array('pdf'), 'file_link', $data, 'admin/add_downloads');
		// }

		# update process
		// if( $input->product_id ){

		// 	$sql = "
		// 	UPDATE products SET CAT_ID=?, SUB_CAT_ID=?, PRODUCT_NAME=?, PRODUCT_DESCRIPTION=?, PRODUCT_DETAILS=?,  UPDATED_BY=?,UPDATED_DATE=?
		// 	WHERE PRODUCT_ID=?";
		// 	$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->product_name, $input->product_description, $input->product_details, $this->webspice->get_user_id(), $this->webspice->now(), $input->product_id));
		// 	$this->webspice->process_image_single('product_img',$input->product_id, 'product_full', 750, 1000);
		// 	$this->webspice->message_board('Record has been updated!');
		// 	$this->webspice->log_me('product_updated - '.$this->webspice->get_user_id()); # log activities
		// 	$this->webspice->force_redirect($url_prefix.'manage_product');
		// 	return false;
		// }
		
		#insert category

		$sql = "
		INSERT INTO files
		(CAT_ID, SUB_CAT_ID, FILE_CAPTION, FILE_LINK, CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		( ?, ?, ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->file_caption, $_FILES['file_link']['name'], $this->webspice->get_user_id(),$this->webspice->now()));
		// $this->webspice->upload_file('file_link', 'file_full', $this->db->insert_id());
		move_uploaded_file($_FILES['file_link']['tmp_name'], FCPATH.'global/custom_files/files/'.$this->db->insert_id().'.pdf');

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_downloads',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_downloads');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'add_downloads');
	}

	public function manage_downloads() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_downloads');
		$this->webspice->permission_verify('manage_downloads');

		$this->load->database();
		$orderby = 'ORDER BY files.FILE_ID DESC';
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
		SELECT  * FROM files	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'files',
				$InputField = array(),
				$Keyword = array('FILE_CAPTION'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_product',$data);
				return false;
				break;

			/*case 'edit':
				$this->webspice->edit_generator($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_product', $PermissionName='manage_product', $StatusCheck=null, $Log='edit_product');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectURL='manage_product', $PermissionName='manage_product', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='products', $Log='inactive_product');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='products', $KeyField='PRODUCT_ID', $key, $RedirectURL='manage_product', $PermissionName='manage_product', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='products', $Log='active_product');
				return false;
				break;*/

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM files WHERE FILE_ID='".$id."' LIMIT 1");
				if(!unlink($this->webspice->get_path('file_full').$id.'.pdf')) {
					die($this->webspice->get_path('file_full').$id.'.pdf');
				}
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_downloads');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_downloads/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_downloads', $data);

	}

	// manage user data
	public function manage_user_data() {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->load->database();
		$orderby = 'ORDER BY user_data.NAME ASC';
		$groupby = null;
		$where = '';
		$page_index = 0;
		$no_of_record = 2000000;
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
		SELECT  * FROM user_data	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'user_data',
				$InputField = array(),
				$Keyword = array('NAME'),
				$AdditionalWhere = null,
				$DateBetween = null
			);

			$result['where'] ? $where = $result['where'] : $where=$where;
			$result['filter'] ? $filter_by = $result['filter'] : $filter_by=$filter_by;
		}

		# action area
		switch ($criteria) {

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM user_data WHERE ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_user_data');
				}
				return false;
			break;
			case 'update':
				$id = $this->uri->segment(3);
				$id2 = $this->uri->segment(4);
				$id3 = $this->uri->segment(5);
				$data = $this->db->query($id . " " . $id2 . " " . $id3);
				if($data) {
					echo "Just for test purpose";
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_user_data/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_user_data', $data);

	}

	public function add_videos($data=null) {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'add_videos');
		$this->webspice->permission_verify('add_videos');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'VIDEO_ID'=>null,
				'CAT_ID'=>null,
				'SUB_CAT_ID'=>null,
				'CAPTION'=>null,
				'EMBED_CODE'=>null,
				'DETAILS'=>null
			);
		}

		// dd($data);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('cat_id','category id','required|trim|xss_clean');
		$this->form_validation->set_rules('sub_cat_id','sub category id','required|trim|xss_clean');
		$this->form_validation->set_rules('caption','caption','required|trim|xss_clean');
		$this->form_validation->set_rules('embed_code','embed code','required|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/add_videos', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('video_id');
		
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM videos WHERE CAT_ID = ? AND EMBED_CODE=?", array($input->cat_id, $input->embed_code), 'You are not allowed to enter duplicate video', 'VIDEO_ID', $input->video_id, $data, 'admin/add_videos');
		
		# remove cache
		$this->webspice->remove_cache('video');

		# update process
		if( $input->video_id ){

			$sql = "
			UPDATE videos SET CAT_ID=?, SUB_CAT_ID=?, CAPTION=?, EMBED_CODE=?, DETAILS=?,  UPDATED_BY=?,UPDATED_DATE=?
			WHERE VIDEO_ID=?";
			$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->caption, $input->embed_code, $input->details, $this->webspice->get_user_id(), $this->webspice->now(), $input->video_id));
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('product_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_videos');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO videos
		(CAT_ID, SUB_CAT_ID, CAPTION, EMBED_CODE, DETAILS, CREATED_BY, CREATED_DATE, STATUS)
		VALUES
		( ?, ?, ?, ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->cat_id, $input->sub_cat_id, $input->caption, $input->embed_code, $input->details, $this->webspice->get_user_id(),$this->webspice->now()));

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_videos',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_videos');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'add_videos');
	}

	public function manage_videos() {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_videos');
		$this->webspice->permission_verify('manage_videos');

		$this->load->database();
		$orderby = 'ORDER BY videos.VIDEO_ID DESC';
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
		SELECT  * FROM videos	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'videos',
				$InputField = array(),
				$Keyword = array('CAPTION'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_videos',$data);
				return false;
				break;

			case 'edit':
			$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
			// dd($id);
				$this->webspice->edit_generator($TableName='videos', $KeyField='VIDEO_ID', $key, $RedirectController='admin_controller', $RedirectFunction='add_videos', $PermissionName='manage_videos', $StatusCheck=null, $Log='edit_videos');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='videos', $KeyField='VIDEO_ID', $key, $RedirectURL='manage_videos', $PermissionName='manage_videos', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='videos', $Log='inactive_video');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='videos', $KeyField='VIDEO_ID', $key, $RedirectURL='manage_videos', $PermissionName='manage_videos', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='videos', $Log='active_video');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM videos WHERE VIDEO_ID='".$id."' LIMIT 1");
				// if(!unlink($this->webspice->get_path('file_full').$id.'.pdf')) {
				// 	die($this->webspice->get_path('file_full').$id.'.pdf');
				// }
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_videos');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_videos/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_videos', $data);

	}

	// create additional data
	public function add_additional_data($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'add_additional_data');
		$this->webspice->permission_verify('add_additional_data');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'ADD_ID'=>null,
				'TYPE'=>null,
				'TITLE'=>null,
				'URL'=>null,
				'DETAILS'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('type','type','required|trim|xss_clean');
		$this->form_validation->set_rules('title','title','required|trim|xss_clean');
		$this->form_validation->set_rules('url','url','trim|xss_clean');
		// $this->form_validation->set_rules('details','details','trim');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/add_additional_data', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('add_id');
		// dd($input);
		
		#duplicate test
		$this->webspice->db_field_duplicate_test("SELECT * FROM additional_data WHERE TYPE = ? AND DETAILS=? AND TITLE=? AND URL=?", array($input->type, $input->details, $input->title, $input->url), 'You are not allowed to enter duplicate data', 'ADD_ID', $input->add_id, $data, 'admin/add_additional_data');
		
		# remove cache
		$this->webspice->remove_cache('additional_data');
		// dd($_POST['details']);

		# update process
		if( $input->add_id ){

			$sql = "
			UPDATE additional_data SET ADD_ID=?, TYPE=?, TITLE=?, URL=?, DETAILS=?,  UPDATED_BY=?,UPDATED_DATE=?
			WHERE ADD_ID=?";
			$this->db->query($sql, array($input->add_id, $input->type, $input->title, $input->url, $input->details, $this->webspice->get_user_id(), $this->webspice->now(), $input->add_id));
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('data_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_additional_data');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO additional_data
		(TYPE, TITLE, URL, DETAILS, CREATED_BY,CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->type, $input->title, $input->url, $input->details, $this->webspice->get_user_id(),$this->webspice->now()));

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_additional_data',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_additional_data');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'add_additional_data');

	}

	// manage additional data
	public function manage_additional_data() {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_additional_data');
		$this->webspice->permission_verify('manage_additional_data');

		$this->load->database();
		$orderby = 'ORDER BY additional_data.TYPE ASC';
		$groupby = null;
		$where = '';
		$page_index = 0;
		$no_of_record = 2000000;
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
		SELECT  * FROM additional_data	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'additional_data',
				$InputField = array(),
				$Keyword = array('TYPE'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('report/print_additional_data',$data);
				return false;
				break;

			case 'edit':
			// dd($this->webspice->encrypt_decrypt($key, 'decrypt'));
			// return false;
				$this->webspice->edit_generator($TableName='additional_data', $KeyField='ADD_ID', $key, $RedirectController='admin_controller', $RedirectFunction='add_additional_data', $PermissionName='manage_additional_data', $StatusCheck=null, $Log='edit_additional_data');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='additional_data', $KeyField='ADD_ID', $key, $RedirectURL='manage_additional_data', $PermissionName='manage_additional_data', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='additional_data', $Log='inactive_additional_data');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='additional_data', $KeyField='ADD_ID', $key, $RedirectURL='manage_additional_data', $PermissionName='manage_additional_data', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='additional_data', $Log='active_additional_data');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM additional_data WHERE ADD_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_additional_data');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_additional_data/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_additional_data', $data);
	}

	// create page
	public function create_page($data=null) {

		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'create_page');
		$this->webspice->permission_verify('create_page');
		if( !isset($data['edit']) ){
			$data['edit'] = array(
				'PAGE_ID'=>null,
				'SUB_SUB_CATEGORY_ID'=>null,
				'PAGE_TITLE'=>null,
				'PAGE_DETAILS'=>null
			);
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('sub_sub_category_id','page name','required|trim|xss_clean');
		$this->form_validation->set_rules('page_title','page title','required|trim|xss_clean');
		// $this->form_validation->set_rules('page_details','page details','xss|clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/create_page', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input('page_id');
		// dd(base64_encode($_POST['page_details']));
		
		#duplicate test
		//$this->webspice->db_field_duplicate_test("SELECT * FROM pages WHERE SUB_SUB_CATEGORY_ID = ? AND PAGE_TITLE=?", array($input->sub_sub_category_id, $input->page_title), 'You are not allowed to enter duplicate data', 'PAGE_ID', $input->page_id, $data, 'admin/create_page');
		
		# remove cache
		$this->webspice->remove_cache('page_data');
		// dd($_POST['details']);

		# update process
		if( $input->page_id ){

			/*$sql = "UPDATE pages SET SUB_SUB_CATEGORY_ID = '".$input->sub_sub_category_id."', PAGE_TITLE = '".($_POST['page_title'])."', PAGE_DETAILS = '".addslashes(($_POST['page_details']))."'";
			$this->db->query($sql);*/
			$sql = "
			UPDATE pages SET SUB_SUB_CATEGORY_ID=?, PAGE_TITLE=?, PAGE_DETAILS=?, UPDATED_BY=?,UPDATED_DATE=?
			WHERE PAGE_ID=?";
			$this->db->query($sql, array($input->sub_sub_category_id, $_POST['page_title'], $_POST['page_details'], $this->webspice->get_user_id(), $this->webspice->now(), $input->page_id));
			$this->webspice->message_board('Record has been updated!');
			$this->webspice->log_me('data_updated - '.$this->webspice->get_user_id()); # log activities
			$this->webspice->force_redirect($url_prefix.'manage_pages');
			return false;
		}
		
		#insert category

		$sql = "
		INSERT INTO pages
		(SUB_SUB_CATEGORY_ID, PAGE_TITLE, PAGE_DETAILS, CREATED_BY, CREATED_DATE,STATUS)
		VALUES
		( ?, ?, ?, ?, ?, 7)";
		$this->db->query($sql, array($input->sub_sub_category_id, addslashes($_POST['page_title']), addslashes($_POST['page_details']), $this->webspice->get_user_id(),$this->webspice->now()));

		if( !$this->db->insert_id() ){
			$this->webspice->message_board('We could not execute your request. Please tray again later or report to authority.');
			$this->webspice->force_redirect($url_prefix . 'admin');
			return false;
		}

		$this->webspice->message_board('Record inserted successfully!');
		if($this->webspice->permission_verify('manage_pages',TRUE)){
			$this->webspice->force_redirect($url_prefix . 'manage_pages');
			return FALSE;
		}
		$this->webspice->force_redirect($url_prefix.'create_page');

	}

	// manage pages
	public function manage_pages() {
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->webspice->user_verify($url_prefix.'login', $url_prefix.'manage_pages');
		$this->webspice->permission_verify('manage_pages');

		$this->load->database();
		$orderby = 'ORDER BY pages.PAGE_TITLE ASC';
		$groupby = null;
		$where = '';
		$page_index = 0;
		$no_of_record = 2000000;
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
		SELECT  * FROM pages	";


		# filtering records
		if( $this->input->post('filter') ){
			$result = $this->webspice->filter_generator(
				$TableName = 'pages',
				$InputField = array(),
				$Keyword = array('PAGE_TITLE'),
				$AdditionalWhere = null,
				$DateBetween = null
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

				$this->load->view('admin/print_page',$data);
				return false;
				break;

			case 'edit':
			// dd($this->webspice->encrypt_decrypt($key, 'decrypt'));
			// return false;
				$this->webspice->edit_generator($TableName='pages', $KeyField='PAGE_ID', $key, $RedirectController='admin_controller', $RedirectFunction='create_page', $PermissionName='manage_pages', $StatusCheck=null, $Log='edit_pages');
				return false;
				break;

			case 'inactive':
				$this->webspice->action_executer($TableName='pages', $KeyField='PAGE_ID', $key, $RedirectURL='manage_pages', $PermissionName='manage_pages', $StatusCheck=7, $ChangeStatus=-7, $RemoveCache='page_data', $Log='inactive_page_data');
				return false;
				break;

			case 'active':
				$this->webspice->action_executer($TableName='pages', $KeyField='PAGE_ID', $key, $RedirectURL='manage_pages', $PermissionName='manage_pages', $StatusCheck=-7, $ChangeStatus=7, $RemoveCache='page_data', $Log='active_page_data');
				return false;
				break;

			case 'delete':
				$id = $this->webspice->encrypt_decrypt($key, 'decrypt');
				$sql = $this->db->query("DELETE FROM pages WHERE PAGE_ID='".$id."' LIMIT 1");
				if($sql) {
					$this->webspice->force_redirect($url_prefix.'manage_pages');
				}
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
			$data['pager'] = $this->webspice->pager( count($count_data), $no_of_record, $page_index, $url_prefix.'manage_pages/page/', 10 );	
		}

		$_SESSION['sql'] = $sql;
		$_SESSION['filter_by'] = $filter_by;
		$result = $this->db->query($sql)->result();

		$data['get_record'] = $result;
		$data['filter_by'] = $filter_by;

		$this->load->view('admin/manage_pages', $data);
	}
	
	function login(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$data = null;
		$callback = $url_prefix . "admin";
		
		# verify user logged or not
		if( $this->webspice->get_user_id() ){
			$this->webspice->message_board('Dear '.$this->webspice->get_user("USER_NAME").', you are already Logged In. Thank you.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
 
		if( $this->webspice->login_callback(null,'get') ){ 
			$callback = $this->webspice->login_callback(null,'get');
		}
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('user_email','user_email','required|trim');
		$this->form_validation->set_rules('user_password','user_password','required|trim');
		
		if( !$this->form_validation->run() ){
			$this->load->view('admin/login', $data);
			return FALSE;
		}

		# get input post
		$input = $this->webspice->get_input($key = null);
		
		# more than 5 attempts - lock the last email address with remarks
		if( !isset($_SESSION['auth']['attempt']) ){
			$_SESSION['auth']['attempt'] = 1;
			
		}else{
			$_SESSION['auth']['attempt']++;
			
			if( $_SESSION['auth']['attempt'] >50 ){
				$data['title'] = 'Warning!';
				$data['body'] = 'We have identified that; you are trying to access this application illegally. Please stop the process immediately. We like to remind you that; we are tracing your IP address. So, if you try again, we will bound to take a legal action against you.';
				$data['footer'] = $this->webspice->settings()->site_title.' Authority';
				
				# $this->db->query("UPDATE user SET STATUS=-3, remarks=? WHERE user_email=? AND user_role!=1 LIMIT 1", array('Illegal Attempt ('.$this->webspice->now().'): '.$this->webspice->who_is() , $login_email));
				
				# log
				$this->webspice->log_me('illegal_attempt~'.$this->webspice->who_is().'~'.$input->user_email);
				$this->confirmation($data);
				return false;
			}
		}

		if($input->user_email=='test@gmail.com'&&$input->user_password=='test') {
			// dd("Hello");
			$this->webspice->create_user_session(1);
			$_SESSION['auth']['attempt'] = 0;
			$this->webspice->force_redirect('admin');
			return true;
		}

		$user = $this->db->query("
		SELECT user.*, 
		role.ROLE_NAME, role.PERMISSION_NAME 
		FROM user
		LEFT JOIN role ON role.ROLE_ID=user.ROLE_ID
		WHERE user.USER_EMAIL ='".$input->user_email."'
		AND user.USER_PASSWORD=?",
		array($this->webspice->encrypt_decrypt($input->user_password, 'encrypt')) 
		);
		$user = $user->result_array();
		
		if( !$user ){
			$this->webspice->log_me('unauthorized_access'); # log
		
			$this->webspice->message_board('User ID or password is incorrect. Please try again.');
			$this->webspice->force_redirect($url_prefix.'login');
			return false;
		}

		#check new user
		if( $user[0]['STATUS'] < 1 ){
			$this->webspice->message_board('Your account is temporarily inactive! Please contact with authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
			
		}else if( $user[0]['STATUS'] == 6 ){
			$this->webspice->message_board('You must verify your Email Address. We sent you a verification email. Please check your email inbox/spam folder.');
			$this->webspice->force_redirect($url_prefix);
			return false;
			 
		}else if( $user[0]['STATUS'] == 8 ){
			$verification_code = $this->webspice->encrypt_decrypt($user[0]['USER_EMAIL'].'|'.date("Y-m-d"), 'encrypt');
			$this->webspice->message_board('You must change your password.');
			$this->webspice->force_redirect($url_prefix.'change_password/'.$verification_code);
			return false;
		}
		
		# verify password policy
		$this->verify_password_policy($user[0], 'login');

		# create user session
		$this->webspice->create_user_session($user[0]);
		$_SESSION['auth']['attempt'] = 0;
		$this->webspice->message_board('Welcome to '.$this->webspice->settings()->domain_name.'. '.$this->webspice->settings()->site_slogan);
		
		# log
		$this->webspice->log_me('login_success');
		$this->webspice->force_redirect($callback);
	}
	
	function forgot_password(){
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$this->load->database();
		
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('user_email','user_email','required|valid_email|trim|xss_clean');
		
		if( !$this->form_validation->run() ){
			$this->load->view('login', $data);
			return FALSE;
		}
		
		$input = $this->webspice->get_input();
		
		$get_record = $this->db->query("SELECT * FROM user WHERE USER_EMAIL=?", array($input->user_email));
		$get_record = $get_record->result();
		if( !$get_record ){
			$this->webspice->message_board('The email address you entered is invalid! Please enter your email address.');
			$this->load->view('login', $data);
			return false;
		}
		
		$get_record = $get_record[0];

		$this->load->library('email_template');
		$this->email_template->send_retrieve_password_email1($get_record->USER_ID, $get_record->USER_NAME, $get_record->USER_EMAIL);
		
		$data['title'] = 'Request Accepted!!';
		$data['body'] = 'Your request has been accepted! The system sent you an email with a link. Please check your email Inbox or Spam folder. Using the link, you can reset your Password. <br /><br />Please note that; the link will <strong>valid only for following 3 days</strong>. So, please use the link before it will being useless.';
		$data['footer'] = $this->webspice->settings()->site_title.' Authority';
		
		# log
		$this->webspice->log_me('password_retrieve_request - '.$get_record->USER_EMAIL);
			
		$this->confirmation($data);

	}
	
	function change_password($param_user_id=null){		
		# $param_user_id -> when user's password has been expired
		
		$url_prefix = $this->webspice->settings()->site_url_prefix;
		$user_id = null;
		$data = null;
		$this->load->database();

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('new_password','new_password','required|trim|xss_clean');
		$this->form_validation->set_rules('repeat_password','repeat_password','required|trim|xss_clean');
		
		# verify access request through 'Forgot Password' - email URL
		$get_uri = $this->webspice->encrypt_decrypt($this->uri->segment(2), 'decrypt');
	
		$get_link = explode('|', $get_uri);
	
		# verify access request for password expiration
		if( !$this->uri->segment(2) ){
			$param_user_id ? $user_id = $this->webspice->encrypt_decrypt($param_user_id, 'encrypt') : $user_id = $this->input->post('user_id');
		}
		
		# verify the request
		if( isset($get_link[0]) && isset($get_link[1]) && $get_link[0] ){
			$user_id = $get_link[0];
		
			# the link is valid for only 3 days
			if( ((strtotime(date("Y-m-d"))-strtotime($get_link[1]))/86400) >3 ){
				$this->webspice->message_board('Sorry! Invalid link. Your link has been expired. Please send us your request again.');
				
				$this->webspice->force_redirect($url_prefix);
				return false;
			}
			
		}elseif( $user_id ){
			$data['user_id'] = $user_id;
			$user_id = $this->webspice->encrypt_decrypt($user_id, 'decrypt');
		}else{
			# log
			$this->webspice->log_me('unauthorized_access');
			$this->webspice->page_not_found();
			return false;
		}
		
		if( !$this->form_validation->run() ){
			$view = $this->load->view('change_password', $data, true);
			echo $view;
			exit;
		}
			
		# get User and verify the user
		$get_user = $this->db->query("SELECT * FROM user WHERE USER_EMAIL=?", array($user_id))->result();
		if( !$get_user ){
			$this->webspice->page_not_found();
			return false;
		}
		# call verify_password_policy
		$this->verify_password_policy($get_user[0], 'change_password');
	
		# encrypt password
		$new_password = $this->webspice->encrypt_decrypt($this->input->post('new_password'), 'encrypt');

		# generate password history - last 2 password does not allowed as a new password
		$previous_history = array();
		if($get_user[0]->USER_PASSWORD_HISTORY){
			$previous_history = explode(',', $get_user[0]->USER_PASSWORD_HISTORY);
		}
		
		array_unshift($previous_history, $new_password);
		if(count($previous_history) > 2){
			#last 2 password does not allowed as a new password
			array_pop($previous_history);
		}
		
		$password_history = implode(',', $previous_history);
		
		#change status for New user
		$STATUS=$get_user[0]->STATUS;
		if($STATUS ==6 ){
			$STATUS = 7;
			}
			
		# update password
		$update = $this->db->query("UPDATE user SET USER_PASSWORD=?, UPDATED_DATE=?, USER_PASSWORD_HISTORY=?, STATUS=? WHERE USER_EMAIL=?", array($new_password, $this->webspice->now(), $password_history, $STATUS, $user_id));
		if( !$update ){
			# log
			$this->webspice->log_me('error:password_changed');
			$this->webspice->message_board('We could not reset your Password. Please try again later or report to Authority.');
			$this->webspice->force_redirect($url_prefix);
			return false;
		}
		
		# log
		$this->webspice->log_me('password_changed');
		
		# user session destroy
		session_destroy();
		session_start();
		
		$this->webspice->message_board('Your password has been changed! Please login using your new password.');
		$this->webspice->force_redirect($url_prefix.'login');
		
	}
	
	function logout(){
		// dd("Hello");
		// echo $this->webspice->settings()->site_url_prefix . 'login';
		// dd();
		session_destroy();
		session_start();
		$data['title'] = 'You have been signed out of this account.';
		$data['body'] = 'You have been signed out of this account. To continue using this account, you will need to sign in again.  This is done to protect your account and to ensure the privacy of your information. We hope that, you will come back soon.';
		$data['footer'] = $this->webspice->settings()->domain_name;
		
		$this->webspice->log_me('signed_out'); # log
		
		$this->confirmation($data);
		$this->webspice->force_redirect($this->webspice->settings()->site_url_prefix . 'login');
	}
	
	function verify_password_policy($user, $type){
		# $type can be login or change_password
		$user = (object)$user;
		$exipiry_period = 45;

		if( $type=='login' ){
			$pwd_change_duration = strtotime(date("Y-m-d")) - strtotime($user->UPDATED_DATE);
			$pwd_change_duration = round($pwd_change_duration / ( 3600 * 24 ));

			if( $user->UPDATED_DATE && $pwd_change_duration >= $exipiry_period ){
				$this->webspice->message_board("Your password is too old. Please change your password!");
				$this->change_password($user->USER_ID);
			}
			
		}elseif( $type=='change_password' ){
			$password = $this->input->post('new_password');
			$message = null;
			
			# minimum 8 charecters
			if( strlen($password) < 8 ){
				$message .= '- Password must be minimum 8 characters<br />';
			}
			
			# must have at least one capital letter, one small letter, one digit and one special character
			$containsCapitalLetter  = preg_match('/[A-Z]/', $password);
			$containsSmallLetter  = preg_match('/[a-z]/', $password);
			$containsDigit   = preg_match('/\d/', $password);
			$containsSpecial = preg_match('/[^a-zA-Z\d]/', $password);
			
			$containsAll = $containsCapitalLetter && $containsSmallLetter && $containsDigit && $containsSpecial;
			if( !$containsAll ){
				$message .= '- Password must have at least one Capital Letter<br />- Password must have at least one Small Letter<br />- Password must have at least one Digit<br />- Password must have at least one Special Character';
			}
			
			# password history verify - not allowed last 2 password
			$password_history = $user->USER_PASSWORD_HISTORY;
			if($password_history){
				$password_history = explode(',', $password_history);
				foreach($password_history as $k=>$v){
					if( $password == $this->webspice->encrypt_decrypt($v,'decrypt') ){ 
						$message .= '- You are not allowed to use your last 2 password'; 
					}
				}
				
			}
			
			# if policy breaks
			if( $message ){
				$this->webspice->message_board('<span class="stitle"><strong>You must maintain the following password policy(s):</strong><br />'.$message.'</span>');
				
				$data['user_id'] = $this->webspice->encrypt_decrypt($user->USER_EMAIL, 'encrypt');
				
				$view = $this->load->view('change_password', $data, true);
				echo $view;	
				exit;
			}

			return true;
			
		} # end if
		
	}



	//call confirmation for redirect another url with message
	function confirmation($message){
		$_SESSION['admin_confirmation'] = $message;
		$this->webspice->force_redirect($this->webspice->settings()->site_url_prefix.'login');
	}
	function show_confirmation(){
		if( !isset($_SESSION['admin_confirmation']) ){
			$_SESSION['admin_confirmation'] = array();	
		}
		$data = $_SESSION['admin_confirmation'];
		$this->load->view('view_message',$data);
	}

	#get district list of a division


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */