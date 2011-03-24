<?php

class Signup extends CI_Controller {

    private $data;

    function __construct()
    {
        parent::__construct();
    }
    
    function index()
    {
        $this->template['title'] = 'EK | Accounterstellung';
        $this->template['layout'] = 'default';
        $this->template['content'] = 'signup';
        $this->load->view('template', $this->template);
        
        // Load form_validation library & set error delimiters
        $this->load->library('form_validation');
    }
    
    function signup()
    {
        $this->form_validation->set_rules('email', 'Email-Adresse', 'trim|required|valid_email|callback_check_email');
        $this->form_validation->set_rules('username', 'Benutzername', 'trim|required|min_length[4]|max_length[12]|callback_check_username');
        $this->form_validation->set_rules('password', 'Passwort', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password2', 'Passwort wiederholen', 'trim|required|matches[password]');
        $this->form_validation->set_rules('ip', 'Ip-Adresse', 'trim|required|callback_check_ip');
        
        /*$this->form_validation->set_rules('firstname', 'Vorname', 'trim|min_length[2]|max_length[12]');
        $this->form_validation->set_rules('lastname', 'Nachname', 'trim|min_length[3]|max_length[12]');
        $this->form_validation->set_rules('age', 'Alter', 'trim|required');
        $this->form_validation->set_rules('country', 'Land', 'trim|required');
        $this->form_validation->set_rules('state', 'Bundesland', 'trim');
        $this->form_validation->set_rules('city', 'Stadt', 'trim');*/
        
        if($this->form_validation->run() == TRUE)
        {
            $data_game          = array(
                'username'      => $this->input->post('username'),
                'email'         => $this->input->post('email'),
                'sha_pass_hash' => sha_pass($this->input->post('password')),
                'expansion'     => $this->input->post('expansion')
                );
                
            /*$data_personal  = array(
                'firstname' => $this->input->post('firstname');
                'lastname'  => $this->input->post('lastname');
                'age'       => $this->input->post('age');
                'country'   => $this->input->post('country');
                'state'     => $this->input->post('state');j
                'city'      => $this->input->post('city');
                );*/
            
            if($this->user->register($data_game))
            {
                redirect('signup/success');
            }
            return false;
        }
    }
    
    function check_username($username)
    {
        $db_auth = $this->load->database('auth', TRUE);
        
        $db_auth->select('id')->from('account')->like('username', $username);
        $get_username = $db_auth->get();
        
        if($get_username->num_rows() > 0)
        {
            $this->form_validation->set_message('check_username', 'Ein Benutzername &auml;hnlich "%s" ist bereits vorhanden!');
            return false;
        }
        else
        {
            return true;
        }
    }
    
    function check_email($email)
    {
        $db_auth = $this->load->database('auth', TRUE);
        
        $db_auth->select('id')->from('account')->where('email', $email);
        $get_email = $db_auth->get();
        
        if($get_email->num_rows() > 0)
        {
            $this->form_validation->set_message('check_email', 'Die Email-Adresse "%s" ist bereits vorhanden!');
            return false;
        }
        else
        {
            return true;
        }
    }
    
    function check_ban($ip)
    {
        // Load date helper
        $this->load->helper('date');
        
        $db_auth = $this->load->database('auth', TRUE);
        
        $db_auth->select('*')->from('ip_banned')->where('ip', $ip);
        $get_ip = $db_auth->get();
        
        if($get_ip->num_rows() > 0)
        {
            $row        = $get_ip->row();
            
            $ip         = $row['ip'];
            $bandate    = $row['bandate'];
            $unbandate  = $row['unbandate'];
            $reason     = $row['banreason'];
            
            // If permanent bann, user isn't allowed to create new account
            if($bandate == $unbandate)
            {
                $this->form_validation->set_message('check_ip', 'Deine IP %s wurde permanent gebannt! Grund: '.$reason.'.! Du kannst leider nicht mehr am Projekt teilnehmen :(');
                return false;
            }
            elseif($bandate != $unbandate && (now() > $unbandate)) // If user was already banned but ban is not active anymore, user gets message that ip is free and user can login again
            {
                $this->form_validation->set_message('check_ip', 'Deine IP %s war bereits vom '.unix_to_human($bandate, TRUE, "eu").' bis '. unix_to_human($unbandate, TRUE, "eu").' gebannt! Du kannst dich nun wieder einloggen! Doppelaccounts sind NICHT m&ouml;glich!');
                return false;
            }
            else
            {
                $this->form_validation->set_message('check_ip', 'Deine IP %s ist noch bis '.unix_to_human($unbandate, TRUE, "eu").' gebannt und kannst dich erst dann wieder einloggen! Doppelaccounts sind NICHT m&ouml;glich!'); 
                return false;
            }
        }
        else
            return true;
    }
}    