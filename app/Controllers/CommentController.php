<?php

namespace App\Controllers;

use App\Models\CommentModel;

class CommentController extends BaseController
{
    protected $commentModel;
    protected $rules = [
        'content' => 'required|max_length[1000]',
        'tsk_id' => 'required|integer'
    ];

    public function __construct()
    {
        $this->commentModel = new CommentModel();
        helper('form');
    }

    // Affiche le formulaire d'ajout de commentaire
    public function create()
    {
        return view('comment/create');
    }

    // Traite le formulaire d'ajout de commentaire
    public function store()
    {
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'tsk_id' => $this->request->getPost('tsk_id'),
            'usr_id' => session()->get('usr_id'),
            'content' => $this->request->getPost('content')
        ];

        $this->commentModel->add($data);
        return redirect()->to('/comments')->with('success', 'Commentaire ajouté.');
    }

    // Supprime un commentaire
    public function delete($id)
    {
        $this->commentModel->del($id);
        return redirect()->to('/comments')->with('success', 'Commentaire supprimé.');
    }
}
