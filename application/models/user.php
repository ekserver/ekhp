<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| USER MODEL CLASS
| -------------------------------------------------------------------
| Diese Datei beinhaltet s�mtliche Funktionen die mit den WoW-Usern
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

    /*
    | Registriert Nutzer in Authserver Database
    | Ben�tigt wird dennoch ein extra Table f�r User genutzt von Codeigniter
    | f�r Informationen wie Vorname, Spitzname, Alter, ect. pp.
    | Dies ist nur die direkte Function "register", ben�tigt weitere helper zur Abwicklung
    | -> User_helper
    | 1:$data|array($username, $email, $sha_pass_hash, $expansion)
    */
    function register($data)
    {
        $query      = $this->db->insert('account', $data);
        
        if($query)
            return true;
        else
            return false;
    }
    /*
    | Loggt Benutzer mit den Logindaten der Authserver Database ein.
    | Gespeichert werden soll dies als Session, sowie ein Cookie gesetzt werden,
    | somit die Informationen public f�r die Homepage verf�gbar sind.
    | Desweiteren besteht die M�glichkeit die Nutzer auch mit der Email-Adresse einloggen zu lassen.
    |
    | -> User_helper -> sha_pass($password)
    | 1:$name_mail, 2:$password
    */
    function login($name_mail, $password)
    {
        if(valid_email($name_mail)) // Input was email
        {
            $email              = $name_mail;

            // Select * from account where email = $email
            $this->db->select('*')->from('account')->where('email', $email);
            $get_username = $this->db->get();
            
            // If username exist
            if($get_username->num_rows() > 0)
            {
                $row_username   = $get_username->row();
                $f_username     = $row->username;
                
                // Get account data
                if($user_data = get_account_data($f_username, $password))
                {
                    // Set session data
                    $this->session->set_userdata($user_data);
                    return true;
                }
            }
        }
        else // Input was username
        {
            $username = $name_mail;
            
            // Get account data
            if($user_data = get_account_data($username, $password))
            {
                // Set session data
                $this->session->set_userdata($user_data);
                return true;
            }
        }
        return false;
    }
    
    /*
    | Funktion zum ver�ndert der Benutzerdaten
    | M�glichkeiten:
    | - Benutzernamen �ndern (Login �ndern) (ben�tigt ebenfalls neu generiertes Passwort nach Core Richtlinien)
    | - Passwort �ndern
    | - Vor- und Zunamen hinzuf�gen/�ndern
    | - Alter hinzuf�gen/�ndern
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
    
    function logout()
    {
        $this->session->sess_destroy();
    }
    
    /*
    | �berpr�ft, ob der Nutzer eingeloggt ist
    | R�ckgabe: eingeloggt = TRUE, nicht eingeloggt = FALSE
    */
    function is_logged_in()
    {
        if ($this->session->userdata('id'))
            return TRUE;
        else
            return FALSE;
    }
}
