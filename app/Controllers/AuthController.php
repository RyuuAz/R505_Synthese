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
        $userModel = new UserModel();
        $user = $userModel->emailExists("max.galmant@gmail.com");

        var_dump($user);
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function forgotPassword()
    {
        return view('forgot_password');
    }

    public function processLogin()
    {
        $userModel = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        // Récupérer l'utilisateur avec l'email donné
        $user = $userModel->emailExists($email);

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return redirect()->back()->with('error', 'E-mail ou mot de passe invalide');
        }

        // Vérifier si le compte est activé
        if (empty($user['is_active']) || $user['is_active'] !== 't') {
            return redirect()->back()->with('error', 'Votre compte n\'est pas activé.');
        }
        

        // Vérifier le mot de passe
        if (password_verify($password, $user['password'])) {
            // Démarrer la session utilisateur
            session()->set(['user_id' => $user['usr_id'], 'isLoggedIn' => true, 'session_start_time' => time()]);
            return redirect()->to('/dashboard');
        }

        // Ajouter un message d'erreur si le mot de passe est incorrect
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

        $email = $this->request->getPost('email');
		$user = $userModel->getUserByEmail($email);
		// Dans la méthode sendResetLink du contrôleur ForgotPasswordController
		echo 'Adresse e-mail soumise : ' . $email. ' ';
		if ($user) {
			// Générer un jeton de réinitialisation de MDP et enregistrer-le dans BD
			$token = bin2hex(random_bytes(16));
			$expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
			$userModel->set('reset_token', $token)
			->set('reset_token_exp', $expiration)
			->update($user['usr_id']);
			// Envoyer l'e-mail avec le lien de réinitialisation
			$activationLink = site_url("active_account/$token");
			$message = "Cliquez sur le lien suivant pour activer votre compte: $activationLink";
			// Utilisez la classe Email de CodeIgniter pour envoyer l'e-mail
			$emailService = \Config\Services::email();
			//paramètres du mail
			$from = \Config\Services::email()->fromEmail;
			$to = $this->request->getPost('to');
			$subject = $this->request->getPost('subject');
			//envoi du mail
			$emailService->setTo($email);
			$emailService->setFrom($from);
			$emailService->setSubject('Activation de compte');
			$emailService->setMessage($message);
			if ($emailService->send()) {
			echo 'E-mail envoyé avec succès.';
			} else {
				echo $emailService->printDebugger();
			}
		} else {
			echo 'Adresse e-mail non valide.';
		}
        return redirect()->to('/')->with('success', 'Inscription réussie. Veuillez vous connecter.');
    }

    public function activeAccount($token)
    {
        $userModel = new UserModel();
        $user = $userModel->getUserByResetTokenAndValid($token);
        if ($user) {
            $userModel->set('is_active', true)
            ->set('reset_token', null)
            ->set('reset_token_exp', null)
            ->update($user['usr_id']);
            return redirect()->to('/')->with('success', 'Compte activé avec succès.');
        } else {
            return redirect()->to('/')->with('error', 'Lien d\'activation non valide.');
        }
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

    public function sendResetLink()
	{
		$email = $this->request->getPost('email');
		$userModel = new UserModel();
		$user = $userModel->getUserByEmail($email);
		// Dans la méthode sendResetLink du contrôleur ForgotPasswordController
		echo 'Adresse e-mail soumise : ' . $email. ' ';
		if ($user) {
			// Générer un jeton de réinitialisation de MDP et enregistrer-le dans BD
			$token = bin2hex(random_bytes(16));
			$expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
			$userModel->set('reset_token', $token)
			->set('reset_token_exp', $expiration)
			->update($user['usr_id']);
			// Envoyer l'e-mail avec le lien de réinitialisation
			$resetLink = site_url("reset_password/$token");
			$message = "Cliquez sur le lien suivant pour réinitialiser MDP: $resetLink";
			// Utilisez la classe Email de CodeIgniter pour envoyer l'e-mail
			$emailService = \Config\Services::email();
			//paramètres du mail
			$from = \Config\Services::email()->fromEmail;
			$to = $this->request->getPost('to');
			$subject = $this->request->getPost('subject');
			//envoi du mail
			$emailService->setTo($email);
			$emailService->setFrom($from);
			$emailService->setSubject('Réinitialisation de mot de passe');
			$emailService->setMessage($message);
			if ($emailService->send()) {
			echo 'E-mail envoyé avec succès.';
			} else {
				echo $emailService->printDebugger();
			}
		} else {
			echo 'Adresse e-mail non valide.';
		}
	}

    public function resetPassword($token)
	{
		helper(['form']);
		$userModel = new UserModel();
		$user = $userModel->getUserByResetToken($token);
		if ($user) {
			return view('update_password', ['token' => $token]);
		} else {
			return redirect()->to('/forgot_password')->with('error', 'Lien de réinitialisation non valide.');
		}
	}
	public function updatePassword()
	{
		$token = $this->request->getPost('token');
		$password = $this->request->getPost('password');
		$confirmPassword = $this->request->getPost('confirm_password');
		// Valider et traiter les données du formulaire
		$userModel = new UserModel();
		$user = $userModel->getUserByResetTokenAndValid($token);
		if ($user && $password === $confirmPassword) {
			// Mettre à jour le mot de passe et réinitialiser le jeton
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$userModel->set('password', $hashedPassword)
			->set('reset_token', null)
			->set('reset_token_exp', null)
			->update($user['usr_id']);

            $userModel->deleteResetToken($user['usr_id']);

			return redirect()->to('/login')->with('success', 'Mot de passe réinitialisé avec succès. Connectez-vous.');
		} else {
			echo ($user);
			return redirect()->to('/forgot_password')->with('error', 'Erreur lors de la réinitialisation du mot de passe.');
		}
	}
    
}
