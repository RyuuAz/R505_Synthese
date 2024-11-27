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

    /**
     * Traite l'ajout d'un commentaire pour une tâche
     * @return \CodeIgniter\HTTP\RedirectResponse Redirige vers la page de la tâche
     */
    public function store()
    {
        $data = [
            'tsk_id' => $this->request->getPost('tsk_id'),
            'usr_id' => session()->get('user_id'),
            'content' => $this->request->getPost('content')
        ];

        $commentModel = new \App\Models\CommentModel();
        $commentModel->add($data);

        return redirect()->to('/dashboard')->with('success', 'Commentaire ajouté.');
    }


    // Supprime un commentaire
    public function delete($id)
    {
        $this->commentModel->del($id);
        return redirect()->to('/comments')->with('success', 'Commentaire supprimé.');
    }
}
