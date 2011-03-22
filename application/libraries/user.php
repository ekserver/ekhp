<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| USER LIBRARY CLASS
| -------------------------------------------------------------------
| Diese Datei beinhaltet sämtliche Funktionen die mit den WoW-Usern
| zu tun haben. Bitte jede Funktion ausgiebig beschreiben.
| 
| @Author   Lennart Stein
| @date     22.03.2011
| @project  Eternal-Knights.net
*/

class EK_user {

    // User Library nutzt User_helper für unterstützende Functions aus Übersichtsgründen
    $CI &= get_instance();
    $CI->load_helper('user_helper');
    
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
    | Passwort sollte aus Sicherheitsgründen vorher rehashed werden, um somit nicht das klare
    | Passwort in dem Login auslesen zu lassen.
    | -> User_helper
    | 1:$id, 2:$username, 3:$email 4:$re_hashed_password, 5:$remember == FALSE
    */
    function login($user_id, $username, $re_hashed_password, $email, $remember == FALSE)
    {
    
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
    function edit(attribute == $edit_password)
    {
    
    }
}