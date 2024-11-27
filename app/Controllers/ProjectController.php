<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TaskModel;
use App\Models\PriorityModel;

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

    /**
     * Affiche tous les projets d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @return string Vue avec les projets
     */
    public function getProjectByID($prjID)
    {
        session()->set('prj_id', $prjID);
        $projects = $this->projectModel->getProjectById($prjID);
        $tacheModel = new TaskModel();
        $taches = $tacheModel->getTasksByProject($prjID);
        $prioriteModel = new PriorityModel();
        $priorites = $prioriteModel->getPrioritiesByUser((int)session()->get('user_id'));

        $tachesParStatut = [
            'a_faire' => [],
            'en_cours' => [],
            'termine' => []
        ];
    
        foreach ($taches as $tache) {
            switch ($tache['status']) {
                case 'pending':
                    $tachesParStatut['a_faire'][] = $tache;
                    break;
                case 2:
                    $tachesParStatut['en_cours'][] = $tache;
                    break;
                case 3:
                    $tachesParStatut['termine'][] = $tache;
                    break;
            }
        }
    
        

        return view('Projet/projet_vue', ['projet' => $projects, 'tachesParStatut' => $tachesParStatut, 'priorities' => $priorites]);
    }

    public function addTaskforProject() {
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
                'status' => 'pending',
                'prj_id' => (int) session()->get('prj_id')
            ];
            $taskModel->add($data);
        }
        return redirect()->to('/projects/view/'.session()->get('prj_id'));    
    }


}
