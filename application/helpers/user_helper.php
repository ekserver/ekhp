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

function sha_pass($username, $password)
{
    $tmp_accountname = trim(strtoupper($accountname));
    $tmp_password = trim(strtoupper($password));

    return sha1(''.$tmp_accountname.':'.$tmp_password.'');
}