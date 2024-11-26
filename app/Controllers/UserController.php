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

    // Traite le formulaire d'inscription
    public function store()
    {
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => false
        ];

        $this->userModel->add($data);
        return redirect()->to('/login')->with('success', 'Inscription réussie, activez votre compte.');
    }

    // Supprime un utilisateur
    public function delete($id)
    {
        $this->userModel->del($id);
        return redirect()->to('/users')->with('success', 'Utilisateur supprimé.');
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