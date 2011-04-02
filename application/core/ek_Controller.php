<?php

class User_Controller extends CI_Controller
{
    /*
    | Überprüft, ob der User eingeloggt ist, oder nicht
    | Wenn der User nicht eingeloggt ist,
    | wird er zur Error-Seite 403 (Zugriff verweigert) geleitet
    */
    function User_Controller()
    {
        parent::__construct();
        
        if ( !$this->user->is_logged_in() )
        {
            redirect('');
            return;
        }
    }
}