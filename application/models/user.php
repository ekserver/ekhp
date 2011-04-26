<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| USER MODEL CLASS
| -------------------------------------------------------------------
| Diese Datei beinhaltet sämtliche Funktionen die mit den WoW-Usern
| zu tun haben. Bitte jede Funktion ausgiebig beschreiben.
| 
| @Author   Lennart Stein
| @date     22.03.2011
| @project  Eternal-Knights.net
*/

class User extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Erstellt einen Trinity kompatiblen Password-Hash
     *
     * @param string $tmp_username
     * @param string $tmp_password
     * @return string
     */
    function sha_pass($tmp_username, $tmp_password)
    {
        $username = trim(strtoupper($tmp_username));
        $password = trim(strtoupper($tmp_password));
    
        return sha1(''.$username.':'.$password.'');
    }

    /**
     * Registriert einen Nutzer in der Authserver Database
     * Benötigt einen Array (key = column)
     * Das Feld 'password' wird automatisch in einen kompatiblen
     * Hash umgewandelt.
     * 
     * @param array $data
     * @return bool
     */
    function register($data)
    {
    	// username & password is required
    	if(!isset($data['username']) OR 
    	   !isset($data['password']))
    	{
    		return FALSE;
    	}
    	
    	if(!isset($data['expansion']))
    	{
    		$data['expansion'] = EXPANSION_WOTLK;
    	}
    	
    	$data['last_ip'] = $_SERVER['REMOTE_ADDR'];
    	$data['sha_pass_hash'] = $this->sha_pass($data['username'], $data['password']);
    	unset($data['password']);
    	    	
        return $this->db->insert('account', $data);
    }
    
    /**
     * Loggt Benutzer mit den Logindaten der Authserver Database ein.
     * Gespeichert werden soll dies als Session, sowie ein Cookie gesetzt werden,
     * somit die Informationen public für die Homepage verfügbar sind.
     * Desweiteren besteht die Möglichkeit die Nutzer auch mit der Email-Adresse einloggen zu lassen.
     *
     * @param string $name_mail		Email oder Username
     * @param string $password		Passwort (unhashed)
     */
    function login($name_mail, $password)
    {
    	// if user submitted an email, fetch matching username (required to create password hash)
    	if(valid_email($name_mail))
    	{
    		$query = $CI->db->select('username')->from('account')->where('email', $name_email)->limit(1)->get();
    		
    		if($query->num_rows() > 0)
    		{
    			$username = $query->row()->username;
    		}
    		else
    		{
				return FALSE;
			}
    	}
    	else
    	{
			$username = $name_mail;
		}
    	
        // fetch user record with gmlevel (userlevel)
	    $query = $this->db->select(array('account.id', 'account.username', 'account.email', 'account.joindate',
			    				 	     'account.last_ip', 'account.locked', 'account.last_login', 'account.online',
			    					     'account.recruiter', 'account_access.gmlevel AS userlevel'))
			    	   ->from('account')
			    	   ->where('account.username', $username)
			    	   ->where('account.sha_pass_hash', $this->sha_pass($username, $password))
			    	   ->join('account_access', 'account.id = account_access.id', 'left')
			    	   ->limit(1)
			    	   ->get();
	   	
	   	// matching record found?
	   	if($query->num_rows() > 0)
	   	{
        	$userdata = $query->row_array();
        	
        	// if user is no gm, set userlevel to 0
        	if(!isset($userdata['userlevel']))
			{
				$userdata['userlevel'] = 0;
			}
			
			// save data to session
			$this->session->set_userdata($userdata);
			return TRUE;
	   	}
	   	
        return FALSE;
    }
    
    /*
    | Funktion zum verändert der Benutzerdaten
    | Möglichkeiten:
    | - Benutzernamen ändern (Login ändern) (benötigt ebenfalls neu generiertes Passwort nach Core Richtlinien)
    | - Passwort ändern
    | - Vor- und Zunamen hinzufügen/ändern
    | - Alter hinzufügen/ändern
    | - Benutzeraccount deaktivieren (Nutzt table_data LOCKED der account_table)
    | -> User_helper
    | 1: $edit_username, 2: $edit_password, 3: $edit_personal, 4: $edit_age, 5: $edit_birth, 6: $edit_lock
    */
    function edit($attribute)
    {
        if( ($user_id || $this->session->get('id')) && $logged_in) // If user is logged in and userid exists
        {
            switch($attribute) // get attribute
            {
                default:
                    return false;
                    break;
                case 1: // edit username
                {
                    $this->edit_username();
                }
                case 2: // edit password
                {
                    $this->edit_password();
                }
                case 3: // edit_personal
                {
                    $this->edit_personal();
                }
                case 4: // edit_age
                {
                    $this->edit_age();
                }
                case 5: // edit_birth
                {
                    $this->edit_birth();
                }
                case 6: // edit_lock
                {
                    $this->edit_lock();
                }
            }
        }
        else
            error_message($error);
            return false;
    }
    
    function recover_password($attribute, $security_answer)
    {
        // Load Email helper
        $this->load->helper('email');

        if(valid_email($attribute))
        {
            $email = $attribute;
            $this->db->select('*')->from('account')->where('email', $email);
            $data = $this->db->get();
        }
        else
        {
            $username = $attribute;
            $this->db->select('*')->from('account')->where('username', $username);
            $data = $this->db->get();
        }
        
        if($data->num_rows() > 0)
        {
            $row                = $data->row();
            
            $security_answer_db = $row->security_answer;
            $email              = $row->email;
            $username           = $row->username;
            $firstname          = $row->firstname;
                
            if($security_answer == $security_answer_db)
            {
                // generate password
                $pass_pool = "qwertzupasdfghkyxcvbnm";
                $pass_pool .= "23456789";
                $pass_pool .= "WERTZUPLKJHGFDSAYXCVBNM";
                
                srand((double)microtime()*1000000);

                for($i = 0; $i < 5; $i++)
                {
                    $password .= substr($pass_pool,(rand()%(strlen($pass_pool))), 1);
                }
                
                $this->email->from('password@eternal-knights.net', 'Eternal-Knights.net');
                $this->email->to($email);
                $this->email->subject('Your new Password');
                    
                $message = '
                <html>
                <head>
                    <title>Your new password</title>
                </head>
                <body>
                    <p>Hi '.$firstname.'!</p>
                    <p>Your new password is:</p>
                    <p></p>
                    <p><b>'.$password.'</b>
                    <p></p>
                    <p>The Eternal-Knights-Team</p>
                </body>
                </html>
                ';
                    
                $this->email->message($message);
                
                if($this->email->send())
                {
                    $update_data = array(
                        'sha_pass_hash' => $this->sha_pass($username, $password)
                    );
                    $this->db->where('username', $username);
                    $this->db->update('account', $update_data);
                    
                    return true;
                }
            }
        }
        
        return false;
    }

    function logout()
    {
        $this->session->sess_destroy();
    }
    
    /*
    | Überprüft, ob der Nutzer eingeloggt ist
    | Rückgabe: eingeloggt = TRUE, nicht eingeloggt = FALSE
    */
    function is_logged_in()
    {
        if ($this->session->userdata('id'))
            return TRUE;
        else
            return FALSE;
    }
}
