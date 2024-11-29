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
     * Méthode qui affiche toutes les tâches
     * @return string Vue avec les tâches
     */
    public function showAllTasks()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = (int) session()->get('user_id');

        $taskModel = new TaskModel();
        $commentModel = new CommentModel();
        $priorityModel = new PriorityModel();

        // Récupérer les tâches de l'utilisateur
        $tasks = $taskModel->getTasksByUser($userId);

        // Récupérer les commentaires de l'utilisateur
        $commentaires = $commentModel->getCommentsByUser($userId);

        // Récupérer les priorités de l'utilisateur
        $priorities = $priorityModel->getPrioritiesByUser($userId);
    
        return view('allTasks', [
        'tasks' => $tasks,
        'commentaires' => $commentaires,
        'priorities' => $priorities] );
    }

    static function genererBandeauTache($tsk_id, $titre, $date, $description, $bgColor, $commentaires = []) {
        // Convertir les commentaires en HTML si le tableau n'est pas vide
        $commentairesHTML = '';
        if (!empty($commentaires)) {
            foreach ($commentaires as $commentaire) {
                $commentairesHTML .= '
                <div class="editable-parent d-flex justify-content-between align-items-center mb-2">
                    <div class="editable-comment" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                        <p class="mb-0 text-dark comment-text">' . htmlspecialchars($commentaire['content']) . '</p>
                        <input class="form-control comment-input d-none" type="text" value="' . htmlspecialchars($commentaire['content']) . '">
                    </div>
                    <div class="d-flex">
                        <!-- Bouton d\'édition -->
                        <button class="btn btn-sm btn-outline-primary me-2 edit-btn" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-success me-2 validate-btn d-none" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                            <i class="bi bi-check-lg"></i>
                        </button>

                        <!-- Bouton de suppression -->
                        <button class="btn btn-sm btn-outline-danger">
                            <a class="danger" href="comments/delete/' . htmlspecialchars($commentaire['cmt_id']) . '">
                                <i class="bi bi-trash"></i>
                            </a>
                        </button>
                    </div>
                </div>';
            }
        } else {
            $commentairesHTML .= '<p>Aucun commentaire.</p>';
        }

        // Générer les éléments du formulaire
        $hidden = form_hidden('tsk_id', $tsk_id);
        $textarea = form_textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Écrire un commentaire...']);
        $submit = form_submit('submit', 'Ajouter un commentaire', ['class' => 'btn btn-primary mt-2']);

        // Générer le bandeau HTML
        return '
        <div class="container mt-0 p-0 mb-3">
            <!-- Barre principale -->
            <div class="task-bar d-flex align-items-center justify-content-between" style="background-color: ' . htmlspecialchars($bgColor) . '; padding: 1rem;">
                <div class="d-flex align-items-center">
                    <!-- Affichage du titre et de la date d\'échéance -->
                    <strong class="me-3">' . htmlspecialchars($titre) . '</strong>
                    <span>' . htmlspecialchars($date) . '</span>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Icônes d\'édition et de suppression -->
                    <button class="icon-btn me-3"><i class="bi bi-pencil"></i></button>
                    <a href="/dashboard/deleteLoneTask/' . $tsk_id . '" class="icon-btn me-3">
                        <i class="bi bi-trash"></i>
                    </a>
                    <!-- Bouton de dépliement -->
                    <button class="icon-btn" data-bs-toggle="collapse" data-bs-target="#task-details-' . md5($titre) . '" aria-expanded="false">
                        <i type="button" class="bi bi-chevron-right rotate-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Contenu dépliable -->
            <div id="task-details-' . md5($titre) . '" class="collapse mt-0 p-0">
                <div class="task-details" style="background-color: ' . htmlspecialchars($bgColor) . '; padding: 1rem;">
                    <!-- Description -->
                    <div class="task-description">
                        <strong>Description :</strong>
                        <p>' . htmlspecialchars($description) . '</p>
                    </div>

                    <!-- Séparation entre la description et les commentaires -->
                    <hr class="my-3" />

                    <!-- Commentaires -->
                    <div class="task-comments">
                        <strong>Commentaires :</strong>
                        ' . $commentairesHTML . '
                        <hr class="my-3" />
                        <!-- Formulaire pour ajouter un commentaire -->
                        <form action="comments/store" method="post">
                            ' . $hidden . '
                            ' . $textarea . '
                            ' . $submit . '
                        </form>
                    </div>
                </div>
            </div>
        </div>
        ';
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