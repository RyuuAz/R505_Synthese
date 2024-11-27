<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\PriorityModel;

class DashboardController extends BaseController
{

    public function __construct()
    {
        helper(['form']);
    }
    public function index()
    {
        $model = new TaskModel();
        $projectModel = new ProjectModel();
        $tasks = $model->getTasksByUser(session()->get("user_id"));
        $projects = $projectModel->getProjectsByUser(session()->get("user_id"));

        echo view('dashboard/dashboard', [
            'tasks' => $tasks,
            'projects' => $projects
        ]);
    }

    public function traitementTasks()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nomTache' => 'required',
            'descriptionTache' => 'required'
        ]);

        if($this->validate($validation->getRules())){
            $this->addTask();
        }
    }

    public function addTask()
    {
        
        $model = new TaskModel();
        if ($this->request->getMethod() === 'POST' ) {
            $model = new TaskModel();
            $model->add([
                'title' => $this->request->getPost(''),
                'description' => $this->request->getPost('descriptionTache'),
                'usr_id' => (int) session()->get('user_id')
            ]);
            session()->setFlashdata('active_tab', value: 'tasks');
        }
        return redirect()->to('/dashboard');
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
            if (!$this->validate([
                'title' => 'required|max_length[255]',
                'due_date' => 'required|valid_date',
                'prio_id' => 'required|integer'
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $taskModel->add([
                'usr_id' => session()->get('usr_id'),
                'prio_id' => $this->request->getPost('prio_id'), // ID de la priorité sélectionnée
                'prj_id' => null, // Pas de projet associé
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'due_date' => $this->request->getPost('due_date'),
                'status' => 'pending'
            ]);

            return redirect()->to('/dashboard')->with('success', 'Tâche ajoutée avec succès.');
        }

        // Si la méthode HTTP est GET, affiche le formulaire
        $userId = session()->get('usr_id');
        $priorities = $priorityModel->getPrioritiesByUser($userId);

        return view('task/create', ['priorities' => $priorities]);
    }
}
