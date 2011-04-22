<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| USER HELPER
| -------------------------------------------------------------------
| Diese Datei beinhaltet unterstützende Funktionen zum User_model.
| Bitte jede Funktion ausgiebig beschreiben und zusätzlich Nutzen in
| User_model angeben
| 
| @Author   Lennart Stein
| @date     22.03.2011
| @project  Eternal-Knights.net
*/

/*
| Generates SHA password out username:password
| 1: $type = $username, 2: $password
| <-> User_helper -> login()
*/

function sha_pass($tmp_username, $tmp_password)
{
    $username = trim(strtoupper($tmp_username));
    $password = trim(strtoupper($tmp_password));

    return sha1(''.$username.':'.$password.'');
}

function get_account_data($username, $password)
{
    $CI =& get_instance();
    
    // Select * from account where username = $username AND sha_pass_hash = sha_pass($username, $password)
    $CI->db->select('*')->from('account')->where('username', $username)->where('sha_pass_hash', sha_pass($username, $password));
    $get_data = $CI->db->get();

    if($get_data->num_rows() > 0)
    {
        $row = $get_data->row();

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
        
        return $user_data;
    }
    
    return false;
}
