<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $rules = [
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]'
    ];

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper('form'); // Chargement du helper form
    }

    // Affiche les informations de l'utilisateur connecté
    public function index()
    {
        $user = $this->userModel->find(session()->get('user_id'));
        return view('profile', ['user' => $user]);
    }

    // Met à jour les informations de l'utilisateur connecté
    public function update()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté pour effectuer cette action.');
        }

        // Récupération des données
        $firstname = $this->request->getPost('first_name');
        $lastname = $this->request->getPost('last_name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validation
        $rules = ['email' => 'required|valid_email'];
        if (!empty($password)) {
            $rules['password'] = 'required|min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if (!empty($password) && $password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Les mots de passe ne correspondent pas.');
        }

        // Mise à jour des informations
        $data = [
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $email
        ];
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->upd($userId, $data);

        return redirect()->to('/users')->with('success', 'Informations mises à jour avec succès.');
    }

    // Supprime le compte de l'utilisateur connecté
    public function deleteAccount()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Vous devez être connecté pour effectuer cette action.');
        }

        //Afficher une pop-up de confirmation

        $confirm = $this->request->getPost('confirm');
        if (empty($confirm)) {
            return redirect()->back()->with('error', 'Vous devez confirmer la suppression de votre compte.');
        }

        $this->userModel->del($userId);

        // Déconnecte l'utilisateur
        session()->destroy();

        return redirect()->to('/')->with('success', 'Compte supprimé avec succès.');
    }

    // Active un utilisateur
    public function activate($id)
    {
        $this->userModel->active($id);
        return redirect()->to('/users')->with('success', 'Utilisateur activé.');
    }

    // Désactive un utilisateur
    public function deactivate($id)
    {
        $this->userModel->unactive($id);
        return redirect()->to('/users')->with('success', 'Utilisateur désactivé.');
    }
}