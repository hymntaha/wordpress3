<?php

$libraryCookieName = 'library_auth_email';
$librarySessionName = 'library_auth_email';
$libraryPostName = 'library_auth_email';
$libraryValidEmails = null;

add_action('init', 'setup_library_emails');

function setup_library_emails()
{
    global $libraryValidEmails;
    
    $libraryValidEmails = explode("\r\n", get_field('library_allowed_email', 'option'));

    library_auth();
}

function library_has_access() 
{
    global $libraryValidEmails, $libraryCookieName;

    $authEmail = isset($_COOKIE[$libraryCookieName]) ? $_COOKIE[$libraryCookieName] : null;
    
    if (!$authEmail) {
        return false;
    }
    
    
    return in_array($authEmail, $libraryValidEmails);
}

function library_auth() 
{
    global $libraryPostName, $libraryValidEmails, $libraryCookieName;
    
    $authEmail = isset($_POST[$libraryPostName]) ? $_POST[$libraryPostName] : null;
    
    if ($authEmail && in_array($authEmail, $libraryValidEmails)) {
        setcookie($libraryCookieName, $authEmail, time() + (60*60*24), COOKIEPATH, COOKIE_DOMAIN);
        $_COOKIE[$libraryCookieName] = $authEmail;
    }
}

function library_auth_requested()
{
    global $libraryPostName;
    
    return isset($_POST[$libraryPostName]);
}