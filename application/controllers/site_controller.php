<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
	}


	public function initial_function() {
		$data = array();
        $data['siteTitle'] = "welcome to dhaka restuarant";
        $data['sitemenu'] = "home";
        $data['slider'] = $this->db->order_by("SLIDER_ID", "asc")->get("slider")->result(); 
        $data['category'] = $this->db->order_by("SUB_CATEGORY_ID", "asc")->get("sub_category")->result();
        $data['category_wise_product'] = $this->db->order_by("IMAGE_ID", "desc")->get("gallery")->result();       
        $this->load->view("home", $data);
	}

	public function about(){
		$data = array();
        $data['siteTitle'] = "About";
        $data['sitemenu'] = "about";
        $this->load->view("about", $data);
	}

	public function menu(){
		$data = array();
        $data['siteTitle'] = "Menu";
        $data['sitemenu'] = "menu";
        $data['category'] = $this->db->order_by("MENU_CATEGORY_ID", "asc")->get("menu_category")->result();
        $this->load->view("menu", $data);
	}

	public function reservation(){
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$data = array();
        $data['siteTitle'] = "Reservation";
        $data['sitemenu'] = "reservation";
        $this->load->view("reservation", $data);
	}

	public function contact(){
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$data = array();
        $data['siteTitle'] = "Contact";
        $data['sitemenu'] = "contact";
        $this->load->view("contact", $data);
	}

	public function contact_insert() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_emails');
        $this->form_validation->set_rules('subject', 'subject', 'required');
        $this->form_validation->set_rules('comments', 'comments', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->contact();
        } else {
            $udata = array(
                "NAME" => $this->input->post("name"),
                "EMAIL" => $this->input->post("email"),
                "SUBJECT" => $this->input->post("subject"),
                "MESSAGE" => $this->input->post("comments"),
                "CREATED_DATE" => date("Y-m-d"),
                "STATUS" => "7"
            );
            //print_r($udata);
            //die();
            if ($this->db->insert("contact_data", $udata)) {
                $this->session->set_flashdata('msg', 'Thanks For Your Message .');
               $this->webspice->force_redirect('contact');
            } else {
                 $this->session->set_flashdata('msg', 'Server Busy Try Agin.');
                $this->webspice->force_redirect('contact');
            }
            //$this->session->set_userdata($mdata);
            //redirect(base_url() . "registration", "refresh");
        }
    }
	
	public function reservation_insertdata() {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_emails');
        $this->form_validation->set_rules('phone_1', 'first phone number', 'required');
        $this->form_validation->set_rules('how_many', 'how_many', 'required');
		$this->form_validation->set_rules('date', 'date', 'required');
		$this->form_validation->set_rules('message', 'message', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->reservation();
        } else {
            $udata = array(
                "FULL_NAME" => $this->input->post("name"),
                "EMAIL" => $this->input->post("email"),
				"PHONE_1" => $this->input->post("phone_1"),
				"PHONE_2" => $this->input->post("phone_1"),
                "HOW_MANY" => $this->input->post("how_many"),
				"OR_DATE" => date("Y-m-d", strtotime($this->input->post("date"))),
                "MESSAGE" => $this->input->post("message"),
                "CREATED_DATE" => date("Y-m-d"),
                "STATUS" => "7"
            );
            //print_r($udata);
            //die();
            if ($this->db->insert("reservation_data", $udata)) {
                $this->session->set_flashdata('msg', 'Thanks For Your Reservation .');
               $this->webspice->force_redirect('reservation');
            } else {
                 $this->session->set_flashdata('msg', 'Server Busy Try Agin.');
                $this->webspice->force_redirect('reservation');
            }
            //$this->session->set_userdata($mdata);
            //redirect(base_url() . "registration", "refresh");
        }
    }
}
