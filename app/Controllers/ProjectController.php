<?php

namespace App\Controllers;

use App\Models\ProjectModel;

class ProjectController extends BaseController
{
    protected $projectModel;
    protected $rules = [
        'title' => 'required|max_length[255]',
        'description' => 'permit_empty',
        'status' => 'required|in_list[pending,completed,overdue]'
    ];

    public function __construct()
    {
        $this->projectModel = new ProjectModel();
        helper('form');
    }

    // Affiche le formulaire de création de projet
    public function create()
    {
        return view('project/create');
    }

    // Traite le formulaire de création
    public function store()
    {
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'usr_id' => session()->get('usr_id'), // Récupère l'utilisateur connecté
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status')
        ];

        $this->projectModel->add($data);
        return redirect()->to('/projects')->with('success', 'Projet créé.');
    }

    // Supprime un projet
    public function delete($id)
    {
        $this->projectModel->del($id);
        return redirect()->to('/projects')->with('success', 'Projet supprimé.');
    }
}
