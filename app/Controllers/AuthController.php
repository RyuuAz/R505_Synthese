<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $rules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]'
    ];

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function processLogin()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Démarrer la session utilisateur
            session()->set(['user_id' => $user['usr_id'], 'isLoggedIn' => true, 'session_start_time' => time()]);
            return redirect()->to('/dashboard');
        }

        // Ajouter un message d'erreur si les identifiants sont incorrects
        return redirect()->back()->with('error', 'E-mail ou mot de passe invalide');
    }

    public function processRegister()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($password !== $passwordConfirm) {
            // Redirection avec un message d'erreur si les mots de passe ne correspondent pas
            return redirect()->back()->with('error', 'Les mots de passe ne correspondent pas');
        }

        $data = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'is_active' => false
        ];

        $userModel->save($data);
        return redirect()->to('/')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }

    public function setSession()
    {
        session()->set(['user_id' => 123, 'session_start_time' => time()]);
        helper('cookie');
        set_cookie('user_id_cookie', '123', 3600); // Durée d'expiration : 3600 secondes (1 heure)
        echo 'Session et cookie définis avec succès.';
    }

    public function getSession()
    {
        $userId = session()->get('user_id');
        $request = service('request');
        $userIdCookie = $request->getCookie('user_id_cookie') ?? 'Cookie non trouvé';

        echo 'User ID de session : ' . ($userId ?? 'Session non définie');
        echo ' | User ID de cookie : ' . $userIdCookie;
    }

    public function checkSessionExpiration()
    {
        $sessionStartTime = session()->get('session_start_time');
        
        if ($sessionStartTime !== null) {
            $expirationTime = 3600; // Temps d'expiration : 1 heure
            $currentTime = time();

            if ($currentTime - $sessionStartTime <= $expirationTime) {
                echo 'Session active.';
            } else {
                session()->destroy();
                echo 'Session expirée.';
                return redirect()->to('/');
            }
        } else {
            echo 'Pas de session active.';
            return redirect()->to('/');
        }
    }

    public function checkCookie()
    {
        $request = service('request');
        $userIdCookie = $request->getCookie('user_id_cookie');

        if ($userIdCookie !== null) {
            echo 'Cookie trouvé : User ID = ' . $userIdCookie;
        } else {
            echo 'Cookie non trouvé.';
        }
    }

    public function logout()
    {
        session()->destroy(); // Supprimer toutes les données de session
        helper('cookie');
        delete_cookie('user_id_cookie'); // Supprimer le cookie utilisateur
        return redirect()->to('/')->with('success', 'Déconnexion réussie.');
    }
}
