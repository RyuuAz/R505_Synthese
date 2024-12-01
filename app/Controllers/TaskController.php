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
        $priorityModel = new PriorityModel();
        $priorities = $priorityModel->getPrioritiesByUser($userId);
        return view('AffichageTaches', ['taches' => $tachesParStatut, 'priorities' => $priorities]);
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
     * Méthode qui affiche toutes les tâches sans projet
     * @return string Vue avec les tâches
     */
    public function showSingleTask()
    {
        // Récupération des tâches
        $tasks = $this->taskModel->getTasksByUserWithoutProject($userId); // Assurez-vous que cette ligne renvoie bien des données
        $tachesParStatut = [
            'a_faire' => [],
            'en_cours' => [],
            'termine' => []
        ];

        // Tri des tâches par statut
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

        // Envoie les deux variables à la vue
        return view('AffichageTaches', [
            'taches' => $tachesParStatut,  // Tâches par statut
        ]);
    }



    /** 
     * Méthode qui affiche toutes les tâches
     * @return string Vue avec les tâches
     */
    public function showAllTasks()
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
        // Transmettre à la vue les deux variables
        return view('AffichageTaches', [
            'taches' => $tachesParStatut,  // Liste des tâches par statut
            'tasks' => $tasks             // Liste complète des tâches
        ]);

        
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
        // Générer HTML des commentaires
        $commentairesHTML = !empty($commentaires) 
            ? implode('', array_map(function ($commentaire) {
                return '
                <div class="editable-parent d-flex justify-content-between align-items-center mb-2">
                    <div class="editable-comment" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                        <p class="mb-0 text-dark comment-text">' . htmlspecialchars($commentaire['content']) . '</p>
                        <input class="form-control comment-input d-none" type="text" value="' . htmlspecialchars($commentaire['content']) . '">
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-sm btn-outline-primary me-2 edit-btn" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-success me-2 validate-btn d-none" data-comment-id="' . htmlspecialchars($commentaire['cmt_id']) . '">
                            <i class="bi bi-check-lg"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <a class="danger" href="comments/delete/' . htmlspecialchars($commentaire['cmt_id']) . '">
                                <i class="bi bi-trash"></i>
                            </a>
                        </button>
                    </div>
                </div>';
            }, $commentaires))
            : '<p>Aucun commentaire.</p>';
    
        // Formulaire d'ajout de commentaire
        $formulaireCommentaires = '
            <form action="comments/store" method="post">
                ' . form_hidden('tsk_id', $tsk_id) . '
                ' . form_textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Écrire un commentaire...']) . '
                ' . form_submit('submit', 'Ajouter un commentaire', ['class' => 'btn btn-primary mt-2']) . '
            </form>
        ';
    
        // Bandeau principal
        return '
            <div id="task-details-' . md5($titre) . '" class=" mt-0 p-0">
                <div class="task-details" style="background-color: ' . htmlspecialchars($bgColor) . '; padding: 1rem;">
                    <!-- Description -->
                    <div class="task-description">
                        <strong>Description :</strong>
                        <p>' . htmlspecialchars($description) . '</p>
                    </div>
                    <hr class="my-3" />
                    <!-- Commentaires -->
                    <div class="task-comments">
                        <strong>Commentaires :</strong>
                        ' . $commentairesHTML . '
                        <hr class="my-3" />
                        ' . $formulaireCommentaires . '
                    </div>
                </div>
            </div>
        </div>';
    }
    

    /**
     * Traite le formulaire de création de tâche
     * @return \CodeIgniter\HTTP\RedirectResponse Redirection avec un message
     */
    public function store()
    {
       // if (!$this->validate($this->rules)) {
      //      return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
      //  }
        

        $data = [
            'usr_id' => session()->get('user_id'),
            'prio_id' => $this->request->getPost('prio_id'), // ID de la priorité sélectionnée
            'prj_id' => $this->request->getPost('prj_id') ?? null, // ID du projet sélectionné
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
            'status' => 'pending'
        ];

        $this->taskModel->add($data);

        return redirect()->to('/tasks')->with('success', 'Tâche créée.');
    }
    public function edit($id)
    {
        $model = new TaskModel();
        $task = $model->find($id);
        return view('edit', ['task' => $task]);
    }

    public function update()
    {
        $model = new TaskModel();
        $id = $this->request->getPost('tsk_id');
        $data = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'due_date' => $this->request->getPost('due_date'),
        ];

        $model->upd($id, $data);
        return redirect()->back();
    }

    // Supprime une tâche
    public function delete($id)
    {
        $this->taskModel->del($id);
        return redirect()->to('/tasks');
    }
    public function deleteBasic()
    {
        $data = $this->request->getJSON();
        $this->taskModel->delete($data->id);
        return $this->response->setJSON(['success' => 'success']);
        
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

    public function delayTaskFilter()
    {
        $userId = session()->get('user_id');
        $tasks = $this->taskModel->getTasksByUser($userId);
        $delayedTasks = [];
        foreach ($tasks as $task) {
            if (strtotime($task['due_date']) < time()) {
                $delayedTasks[] = $task;
            }
        }
        return view('filteredTaskView', ['tasks' => $delayedTasks]);
    }

    public function priorityTaskFilter()
    {
        $userId = session()->get('user_id');
        
        $tasks = $this->taskModel->getTasksByUser($userId);

        // Tri des tâches par priorité (ordre décroissant, 10 étant la plus haute priorité)
        usort($tasks, function ($a, $b) {
            return $b['prio_id'] <=> $a['prio_id'];
        });

        return view('filteredTaskView', ['tasks' => $tasks]);
    }

    public function tasksByDueDate()
    {
        $userId = session()->get('user_id'); // Récupérer l'utilisateur connecté
        $tasks = $this->taskModel->getTasksByUserOrderByDueDate($userId); // Appel de la méthode du modèle
        
        return view('filteredTaskView', ['tasks' => $tasks]); // Envoyer les tâches triées à la vue
    }

    public function allTasks()
    {
        $userId = session()->get('user_id'); // Récupérer l'utilisateur connecté
        $tasks = $this->taskModel->getTasksByUser($userId); // Appel de la méthode du modèle
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
        return view('DefaultTaskView', ['tachesParStatut' => $tachesParStatut]); // Passe les tâches à la vue
    }
}