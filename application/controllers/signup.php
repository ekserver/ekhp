<?php

class Signup extends CI_Controller {

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
    }
    
    function create()
    {
        // Load form_validation library
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email-Adresse', 'trim|required|valid_email|callback__check_email');
        $this->form_validation->set_rules('username', 'Benutzername', 'trim|required|min_length[4]|max_length[12]|callback__check_username');
        $this->form_validation->set_rules('password', 'Passwort', 'trim|required|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('password2', 'Passwort wiederholen', 'trim|required|matches[password]');
        $this->form_validation->set_rules('expansion', 'Erweiterung', 'trim|required');
        $this->form_validation->set_rules('ip', 'Ip-Adresse', 'trim|required|callback__check_ip');
        
        $this->form_validation->set_rules('firstname', 'Vorname', 'trim|min_length[2]|max_length[12]');
        $this->form_validation->set_rules('lastname', 'Nachname', 'trim|min_length[3]|max_length[12]');
        
        if($this->form_validation->run() == TRUE)
        {
            $data               = array(
                'username'      => $this->input->post('username'),
                'email'         => $this->input->post('email'),
                'sha_pass_hash' => sha_pass($this->input->post('username'), $this->input->post('password')),
                'expansion'     => $this->input->post('expansion'),
                'firstname'     => $this->input->post('firstname'),
                'lastname'      => $this->input->post('lastname'),
                'age'           => $this->input->post('age_d').'-'.$this->input->post('age_m').'-'.$this->input->post('age_y'),
                'last_ip'       => $this->input->post('ip')
            );
            
            if($this->user->register($data))
            {
                redirect('signup/success');
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
        {
            $this->form_validation->set_message('check_username', 'Der Benutzername "%s" ist bereits vorhanden!');
            return false;
        }
        else
        {
            return true;
        }
    }
    
    function _check_email($email)
    {
        $this->db->select('id')->from('account')->where('email', $email);
        $get_email = $this->db->get();
        
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
    
    function _check_ip($ip)
    {
        // Load date helper
        $this->load->helper('date');
        
        $this->db->select('*')->from('ip_banned')->where('ip', $ip);
        $get_ip = $this->db->get();
        
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
            }
            elseif($bandate != $unbandate && (now() > $unbandate)) // If user was already banned but ban is not active anymore, user gets message that ip is free and user can login again
            {
                $this->form_validation->set_message('check_ip', 'Deine IP %s war bereits vom '.unix_to_human($bandate, TRUE, "eu").' bis '. unix_to_human($unbandate, TRUE, "eu").' gebannt! Du kannst dich nun wieder einloggen! Doppelaccounts sind NICHT m&ouml;glich!');
            }
            else
            {
                $this->form_validation->set_message('check_ip', 'Deine IP %s ist noch bis '.unix_to_human($unbandate, TRUE, "eu").' gebannt und kannst dich erst dann wieder einloggen! Doppelaccounts sind NICHT m&ouml;glich!'); 
            }
            return false;
        }
        else
            return true;
    }
}    
