<?php

class Forget_password extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->template['title'] = 'EK | Passwort vergessen';
        $this->template['layout'] = 'default';
        $this->template['content'] = 'forget_password';
        $this->load->view('template', $this->template);
    }

	function forget()
    {
        // Load form_validation library
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Benutzername', 'trim|required|min_length[4]|max_length[12]|callback__check_username');
        $this->form_validation->set_rules('security', 'Security Answer', 'trim|required|min_length[3]');
        
        if($this->form_validation->run() == TRUE)
        {
            $username           = $this->input->post('username');
            $security_answer    = $this->input->post('security');
            
            if($this->user->recover_password($username, $security_answer))
            {
                redirect('login/new_password_send');
            }
            
            return false;
        }
        $this->index();
    }
    
    function _check_username($username)
    {
        $this->db->select('id')->from('account')->where('username', $username);
        $get_username = $this->db->get();
        
        if($get_username->num_rows() > 0)
            return true;
        else
        {
            $this->form_validation->set_message('check_username', 'Der Benutzername "%s" ist nicht vorhanden!');
            return false;
        }
    }
}
