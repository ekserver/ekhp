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
    
    /*
    | Registriert Nutzer in Authserver Database
    | Benötigt wird dennoch ein extra Table für User genutzt von Codeigniter
    | für Informationen wie Vorname, Spitzname, Alter, ect. pp.
    | Dies ist nur die direkte Function "register", benötigt weitere helper zur Abwicklung
    | -> User_helper
    | 1:$username, 2:$password, 3:$email
    */
    function register($username, $password, $email/*, $firstname, $lastname*/)
    {
        
    }
    /*
    | Loggt Benutzer mit den Logindaten der Authserver Database ein.
    | Gespeichert werden soll dies als Session, sowie ein Cookie gesetzt werden,
    | somit die Informationen public für die Homepage verfügbar sind.
    | Desweiteren besteht die Möglichkeit die Nutzer auch mit der Email-Adresse einloggen zu lassen.
    |
    | -> User_helper -> sha_pass($password)
    | 1:$name_mail, 2:$password
    */
    function login($name_mail, $password)
    {        
        if($this->valid_email($name_mail)) // Input was email
        {
            $email              = $name_mail;
            
            $this->db_auth->select('username');
            $this->db_auth->from('account');
            $this->db_auth->where('email', $email);
            
            $get_user_by_mail   = $this->db_auth->get();
            $row                = $get_user_by_mail->row();
            $username           = $row->username;
            
            $get_user       = $this->db_auth->get_where('account', array(
                'username'      => $username,
                'sha_pass_hash' => $this->sha_pass($username, $password)
                )
            );
        }
        else // Input was username
        {
            $username       = $name_mail; 
            $get_user       = $this->db_auth->get_where('account', array(
                'username'      => $username,
                'sha_pass_hash' => $this->sha_pass($username, $password)
                )   
            );
        }
        
        if($get_user->num_rows() > 0)
        {
            $row = $get_user->row();
            
            $user_data = array(
                'id'            => $row->id,
                'username'      => $row->username,
                'email'         => $row->email,
                'joindate'      => $row->joindate,
                'lastip'        => $row->lastip,
                'status'        => $row->locked,
                'lastlogin'     => $row->last_login,
                'ingame_online' => $row->online,
                'recruiter'     => $row->recruiter
            );
        
            $this->session->set_userdata($user_data);
            return true;
        }
        else
            return false;
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
}