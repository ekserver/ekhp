<?php

class Forgetpw extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->template['title'] = 'EK | Passwort vergessen';
        $this->template['layout'] = 'default';
        $this->template['content'] = 'forget_pw/start';
        $this->load->view('template', $this->template);
    }

    function step1()
    {
        $this->template['title'] = 'Passwort vergessen | Step 1';
        $this->template['layout'] = 'default';
        $this->template['content'] = 'forget_pw/step1';
        $this->load->view('template', $this->template);
        
        // Load form_validation library
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Benutzername', 'trim|required|min_length[4]|max_length[12]|callback__check_input');
        
        if($this->form_validation->run() == TRUE)
        {
            $username           = $this->input->post('username');
            $this->step2($username);
        }
        $this->index();
    }
    
    function step2($username)
    {
        $this->template['title'] = 'Password vergessen | Step 2';
        $this->template['layout'] = 'default';
        $this->template['content'] = 'forget_pw/step2';
        $this->load->view('template', $this->template);
        
        // Load form_validation library
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('security_question', 'Security Question', 'trim|required');
        $this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required');
        
        if($this->form_validation->run() == TRUE)
        {
            $security_answer = $this->input->post('security_answer');
            
            $this->db->select('security_answer')->from->('account')->where('username', $username);
            $get_security_answer_db = $this->db->get();
            
            if($get_security_answer_db->num_rows() > 0)
            {
                if($security_answer == $security_answer_db)
                    return true;
                else
                {
                    $this->form_validation->set_message('security_answer', 'Die Antwort <b>%s</b> ist nicht korrekt!');
                    return false;
                }
            }
            $this->form_validation->set_message('security_answer', 'Es konnte keine Sicherheitsfrage zu diesem Account gefunden werden!');
            return false;
        }
        $this->index();
    }
    
    function _check_input($input)
    {
        if(valid_email($input))
        {
            $email = $input;
        
            $this->db->select('id')->from('account')->where('email', $email);
            $get_email = $this->db->get();
            
            if($get_email->num_rows() > 0)
                return true;
            else
            {
                $this->form_validation->set_message('check_input', 'Die Email-Adresse <b>%s</b> ist nicht bekannt!');
                return false;
            }
        }
        else
        {
            $username = $input;
            
            $this->db->select('id')->from('account')->where('username', $username);
            $get_username = $this->db->get();
            
            if($get_username->num_rows() > 0)
                return true;
            else
            {
                $this->form_validation->set_message('check_input', 'Der Benutzername <b>%s</b> ist nicht bekannt!');
                return false;
            }
        }
    }
}
