<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\PriorityModel;
use App\Models\CommentModel;

class DashboardController extends BaseController
{

    public function __construct()
    {
        helper(['form']);
    }
    public function index()
    {
        $model = new TaskModel();
        $modelComments = new CommentModel();
        $modelpriority = new PriorityModel();
        $projectModel = new ProjectModel();
        $tasks = $model->getTasksByUser(session()->get('user_id'));
        $commentaires = $modelComments->getCommentById(session()->get('user_id'));
        $projects = $projectModel->getProjectsByUser(session()->get('user_id'));
        $priorities = $modelpriority->getPrioritiesByUser(session()->get('user_id'));

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

        echo view('dashboard/dashboard', [
            'tasks' => $tasks,
            'commentaires' => $commentaires,
            'tachesParStatut' => $tachesParStatut,
            'projects' => $projects,
            'priorities' => $priorities
        ]);
    }

    public function traitement()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nomProjet' => 'required',
            'descriptionProjet' => 'required'
        ]);

        if ($this->validate($validation->getRules())) {
            $this->addProject();
        }
    }

    public function addProject()
    {

        $model = new ProjectModel();
        if ($this->request->getMethod() === 'POST') {
            $model = new ProjectModel();
            $model->add([
                'title' => $this->request->getPost('nomProjet'),
                'description' => $this->request->getPost('descriptionProjet'),
                'usr_id' => (int) session()->get('user_id')
            ]);
            session()->setFlashdata('active_tab', 'projects');
        }
        return redirect()->to('/dashboard');
    }

    /**
     * Ajoute une tâche hors projet
     * @return \CodeIgniter\HTTP\RedirectResponse Redirection vers le tableau de bord
     */
    public function addLoneTask()
    {
        $priorityModel = new PriorityModel();
        $taskModel = new TaskModel();

        // Si la méthode HTTP est POST, traite le formulaire
        if ($this->request->getMethod() === 'POST') {
            // Définir les règles de validation
            $validationRules = [
                'nomTache' => 'required|max_length[255]',
                'dateTache' => 'required|valid_date',
                'prio_id' => 'required|integer',
            ];

            // Ajouter la tâche dans la base de données
            $data = [
                'usr_id' => (int) session()->get('user_id'),
                'prio_id' =>(int) $this->request->getPost('menuSelection'), // ID de la priorité sélectionnée
                'title' => $this->request->getPost('nomTache'),
                'description' => $this->request->getPost('descriptionTache'),
                'due_date' => $this->request->getPost('datetache'),
                'status' => 'pending'
            ];
            $taskModel->add($data);

            

            return redirect()->to('/dashboard')->with('success', 'Tâche ajoutée avec succès.');
        }

        // Si la méthode HTTP est GET, affiche le formulaire
        $userId = session()->get('usr_id');
        $priorities = $priorityModel->getPrioritiesByUser($userId);

        return view('task/create', ['priorities' => $priorities]);
    }


}
