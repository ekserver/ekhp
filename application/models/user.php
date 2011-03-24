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
    | 1:$username, 2:$password
    */
    function register($data)
    {
        $db_auth    = $this->load->database('auth', TRUE);
        $query      = $db_auth->insert('account', $data);
        
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
        $db_auth    = $this->load->database('auth', TRUE);
    
        if(valid_email($name_mail)) // Input was email
        {
            $email              = $name_mail;

            // Select username from account where email = $email
            $db_auth->select('username')->from('account')->where('email', $email);
            $get_user_by_mail   = $db_auth->get();
            $row                = $get_user_by_mail->row();
            $username           = $row->username;
            
            // Select * from account where username = $username AND sha_pass_hash = sha_pass($username, $password)
            $db_auth->select('*')->from('account')->where('username', $username)->where('sha_pass_hash', sha_pass($username, $password));
            $get_user = $db_auth->get();
        }
        else // Input was username
        {
            $username = $name_mail;
            
            // Select * from account where username = $username AND sha_pass_hash = sha_pass($username, $password)
            $db_auth->select('*')->from('account')->where('username', $username)->where('sha_pass_hash', sha_pass($username, $password));
            $get_user = $db_auth->get();
        }

        if($get_user->num_rows() > 0)
        {
            $row = $get_user->row();

            $user_data = array(
                'id'            => $row->id,
                'username'      => $row->username,
                'email'         => $row->email,
                'joindate'      => $row->joindate,
                'lastip'        => $row->last_ip,
                'status'        => $row->locked,
                'lastlogin'     => $row->last_login,
                'ingame_online' => $row->online,
                'recruiter'     => $row->recruiter
            );
            $this->load->database('default',TRUE);
            $this->session->set_userdata($user_data);
            return true;
        }
        else
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
}