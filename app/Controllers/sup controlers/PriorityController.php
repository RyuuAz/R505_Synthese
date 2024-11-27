<?php

namespace App\Controllers;

use App\Models\PriorityModel;

class PriorityController extends BaseController
{
    protected $priorityModel;
    protected $rules = [
        'ordre' => 'required|integer',
        'name' => 'required|max_length[255]',
        'color' => 'required|max_length[7]'
    ];

    public function __construct()
    {
        $this->priorityModel = new PriorityModel();
        helper('form');
    }

    // Affiche le formulaire de création de priorité
    public function create()
    {
        return view('priority/create');
    }

    // Traite le formulaire de création
    public function store()
    {
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'ordre' => $this->request->getPost('ordre'),
            'name' => $this->request->getPost('name'),
            'color' => $this->request->getPost('color'),
            'tsk_id' => $this->request->getPost('tsk_id')
        ];

        $this->priorityModel->add($data);
        return redirect()->to('/priorities')->with('success', 'Priorité ajoutée.');
    }

    // Supprime une priorité
    public function delete($id)
    {
        $this->priorityModel->del($id);
        return redirect()->to('/priorities')->with('success', 'Priorité supprimée.');
    }
}
