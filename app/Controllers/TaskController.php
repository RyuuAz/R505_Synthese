<?php
namespace App\Controllers;

use App\Models\TaskModel;
use App\Models\PriorityModel;
use App\Models\CommentModel;

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

    public function index()
    {
        $userId = session()->get('user_id'); // Récupère l'utilisateur connecté
        $tasks = $this->taskModel->getTasksByUser($userId); // Récupère les tâches de l'utilisateur
        $tachesParStatut = [
            'a_faire' => [],
            'en_cours' => [],
            'termine' => []
        ];
        foreach ($tasks as $tache) {
            switch ($tache['status']) {
                case 'pending':
                    $tachesParStatut['a_faire'][] = $tache;
                    break;
                case 'overdue':
                    $tachesParStatut['en_cours'][] = $tache;
                    break;
                case 'completed':
                    $tachesParStatut['termine'][] = $tache;
                    break;
            }
        }
        return view('AffichageTaches', ['taches' => $tachesParStatut]); // Passe les tâches à la vue
    }

    /**
     * Affiche le formulaire de création de tâche
     * @return string Vue du formulaire
     */
    public function create()
    {
        $userId = session()->get('usr_id'); // Récupère l'utilisateur connecté
        $priorityModel = new PriorityModel(); // Charge le modèle PriorityModel
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
            'prio_id' => $this->request->getPost('prio_id'), // ID de la priorité sélectionnée
            'prj_id' => $this->request->getPost('prj_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
            'status' => 'pending'
        ];

        $this->taskModel->add($data);

        return redirect()->to('/dashboard');
    }
    public function edit($id)
    {
        $model = new TaskModel();
        $task = $model->find($id);
        return view('edit', ['task' => $task]);
    }

    public function update($id)
    {
        $model = new TaskModel();
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
        ];

        $model->update($id, $data);
        return redirect()->to('/dashboard');
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

    /**
     * Affiche les détails d'une tâche avec les commentaires
     * @param int $taskId ID de la tâche
     * @return string Vue avec les commentaires
     */
    public function show($taskId)
    {
        $taskModel = new TaskModel();
        $commentModel = new CommentModel();

        // Récupérer les détails de la tâche
        $task = $taskModel->find($taskId);

        // Récupérer les commentaires associés à la tâche
        $comments = $commentModel->getCommentsByTask($taskId);

        // Passer les données à la vue
        return view('task/show', [
            'task' => $task,
            'comments' => $comments
        ]);
    }

    public function updateTaskStatus()
    {
        $data = $this->request->getJSON();
        $this->taskModel->update($data->id, ['status' => $data->status]);
        return $this->response->setJSON(['status' => 'success']);
    }
}