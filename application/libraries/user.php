<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| USER LIBRARY CLASS
| -------------------------------------------------------------------
| Diese Datei beinhaltet s�mtliche Funktionen die mit den WoW-Usern
| zu tun haben. Bitte jede Funktion ausgiebig beschreiben.
| 
| @Author   Lennart Stein
| @date     22.03.2011
| @project  Eternal-Knights.net
*/

class EK_user {

    // User Library nutzt User_helper f�r unterst�tzende Functions aus �bersichtsgr�nden
    $CI &= get_instance();
    $CI->load_helper('user_helper');
    
    /*
    | Registriert Nutzer in Authserver Database
    | Ben�tigt wird dennoch ein extra Table f�r User genutzt von Codeigniter
    | f�r Informationen wie Vorname, Spitzname, Alter, ect. pp.
    | Dies ist nur die direkte Function "register", ben�tigt weitere helper zur Abwicklung
    | -> User_helper
    | 1:$username, 2:$password, 3:$email
    */
    function register($username, $password, $email/*, $firstname, $lastname*/)
    {
    
    }
    /*
    | Loggt Benutzer mit den Logindaten der Authserver Database ein.
    | Gespeichert werden soll dies als Session, sowie ein Cookie gesetzt werden,
    | somit die Informationen public f�r die Homepage verf�gbar sind.
    | Desweiteren besteht die M�glichkeit die Nutzer auch mit der Email-Adresse einloggen zu lassen.
    | Passwort sollte aus Sicherheitsgr�nden vorher rehashed werden, um somit nicht das klare
    | Passwort in dem Login auslesen zu lassen.
    | -> User_helper
    | 1:$id, 2:$username, 3:$email 4:$re_hashed_password, 5:$remember == FALSE
    */
    function login($user_id, $username, $re_hashed_password, $email, $remember == FALSE)
    {
    
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
    function edit(attribute == $edit_password)
    {
    
    }
}