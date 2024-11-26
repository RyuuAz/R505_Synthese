<?php

namespace App\Controllers;

use App\Models\TaskModel;

class TaskController extends BaseController
{
    protected $taskModel;
    protected $rules = [
        'title' => 'required|max_length[255]',
        'description' => 'permit_empty',
        'due_date' => 'required|valid_date',
        'status' => 'required|in_list[pending,completed,overdue]'
    ];

    public function __construct()
    {
        $this->taskModel = new TaskModel();
        helper('form');
    }

    /**
     * Affiche le formulaire de création de tâche
     * @return string Vue du formulaire
     */
    public function create()
    {
        $userId = session()->get('usr_id'); // Récupère l'utilisateur connecté
        $priorityModel = new \App\Models\PriorityModel(); // Charge le modèle PriorityModel
        $priorities = $priorityModel->getPrioritiesByUser($userId); // Récupère les priorités de l'utilisateur

        return view('task/create', ['priorities' => $priorities]); // Passe les priorités à la vue
    }



    /**
     * Traite le formulaire de création de tâche
     * @return \CodeIgniter\HTTP\RedirectResponse Redirection avec un message
     */
    public function store()
    {
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'usr_id' => session()->get('usr_id'),
            'prj_id' => $this->request->getPost('prj_id'),
            'prio_id' => $this->request->getPost('prio_id'), // ID de la priorité sélectionnée
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
            'status' => 'pending'
        ];

        $this->taskModel->add($data);

        return redirect()->to('/tasks')->with('success', 'Tâche créée avec succès.');
    }


    // Supprime une tâche
    public function delete($id)
    {
        $this->taskModel->del($id);
        return redirect()->to('/tasks')->with('success', 'Tâche supprimée.');
    }

    /**
     * Récupère toutes les tâches d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @return \CodeIgniter\HTTP\ResponseInterface JSON avec les tâches
     */
    public function listByUser($userId)
    {
        $tasks = $this->taskModel->getTasksByUser($userId);
        return $this->response->setJSON($tasks);
    }

    /**
     * Récupère toutes les tâches d'un projet
     * @param int $projectId ID du projet
     * @return \CodeIgniter\HTTP\ResponseInterface JSON avec les tâches
     */
    public function listByProject($projectId)
    {
        $tasks = $this->taskModel->getTasksByProject($projectId);
        return $this->response->setJSON($tasks);
    }

    /**
     * Récupère toutes les tâches d'un utilisateur sans projet
     * @param int $userId ID de l'utilisateur
     * @return \CodeIgniter\HTTP\ResponseInterface JSON avec les tâches
     */
    public function listByUserWithoutProject($userId)
    {
        $tasks = $this->taskModel->getTasksByUserWithoutProject($userId);
        return $this->response->setJSON($tasks);
    }
}
