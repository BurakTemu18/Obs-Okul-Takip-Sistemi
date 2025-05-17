<?php



function requireLogin($role = null)
{
    $session = session();

    if (!$session->get('logged_in')) {
        
        $response = redirect()->to('/login');
        $response->send();
        exit; 
    }

    if ($role && $session->get('role') !== $role) {
        echo "Bu sayfaya erişim yetkiniz yok.";
        exit;
    }
}