<?php

class Forgotpw extends Ext_Controller {

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->set_title('Passwort vergessen');
        $this->display('forgotpw');
    }

	function forget()
    {
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
            
            return FALSE;
        }
        $this->index();
    }
    
    function _check_username($username)
    {
        $this->db->select('id')->from('account')->where('username', $username);
        $get_username = $this->db->get();
        
        if($get_username->num_rows() > 0)
            return TRUE;
        else
        {
            $this->form_validation->set_message('check_username', 'Der Benutzername "%s" ist nicht vorhanden!');
            return FALSE;
        }
    }
}
