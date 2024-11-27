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
        $modelpriority = new PriorityModel();
        $projectModel = new ProjectModel();
        $tasks = $model->getTasksByUser(session()->get("user_id"));
        $projects = $projectModel->getProjectsByUser(session()->get("user_id"));
        $priorities = $modelpriority->getPrioritiesByUser(session()->get("user_id"));

        echo view('dashboard/dashboard', [
            'tasks' => $tasks,
            'projects' => $projects,
            'priorities' => $priorities
        ]);
    }

    public function traitementTasks()
    {
        $validation = \Config\Services::validation();

        // Définir les règles de validation
        $validation->setRules([
            'nomTache' => 'required',
            'descriptionTache' => 'required',
            'datetache' => 'required|valid_date',  // Vérifier que la date d'échéance est bien remplie et valide
            'joursAvant' => 'required|greater_than_equal_to[0]'  // Vérifier que le nombre de jours avant est >= 0
        ]);

        // Si la validation est réussie
        if ($this->validate($validation->getRules())) {
                // Obtenez les valeurs du formulaire
                $dateTache = $this->request->getPost('datetache');
                $joursAvant = $this->request->getPost('joursAvant');
                $today = new \DateTime();  // Date actuelle

                // Convertir la date d'échéance en objet DateTime
                $dueDate = new \DateTime($dateTache);

                // Vérifier si le nombre de jours avant l'échéance est valide (ne doit pas dépasser la date d'aujourd'hui)
                $interval = $today->diff($dueDate);  // Calculer l'intervalle entre la date actuelle et la date d'échéance
                $daysDiff = $interval->days;

                // Si le nombre de jours avant dépasse la date d'aujourd'hui, afficher une erreur
                if ($joursAvant > $daysDiff) {
                    // Ajouter une erreur de validation personnalisée pour le champ 'joursAvant'
                    $validation->setError('joursAvant', 'Le nombre de jours pour prévenir ne peut pas dépasser le nombre de jours restants avant l\'échéance.');
                    return;
                }

                // Si tout est valide, procéder à l'ajout de la tâche
                $this->addTask();
            } else {
                // Si la validation échoue, retourner un message d'erreur ou afficher un message de validation
                return view('form_view', ['validation' => $this->validator]);
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
                'title' => 'required|max_length[255]',
                'due_date' => 'required|valid_date',
                'prio_id' => 'required|integer',
                'joursAvant' => 'required|greater_than_equal_to[0]'  // Vérifier que 'joursAvant' est >= 0
            ];

            if (!$this->validate($validationRules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Obtenez les valeurs du formulaire
            $dueDate = $this->request->getPost('due_date');
            $joursAvant = $this->request->getPost('joursAvant');
            $today = new \DateTime();  // Date actuelle
            $dueDateObj = new \DateTime($dueDate);  // Date d'échéance

            // Calculer la différence en jours entre aujourd'hui et la date d'échéance
            $interval = $today->diff($dueDateObj);
            $daysDiff = $interval->days;

            // Vérifier si le nombre de jours avant l'échéance dépasse la différence de jours
            if ($joursAvant > $daysDiff) {
                // Ajouter une erreur de validation personnalisée
                $this->validator->setError('joursAvant', 'Le nombre de jours pour prévenir ne peut pas dépasser le nombre de jours restants avant l\'échéance.');
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Ajouter la tâche dans la base de données
            $taskModel->add([
                'usr_id' => session()->get('usr_id'),
                'prio_id' => $this->request->getPost('prio_id'), // ID de la priorité sélectionnée
                'prj_id' => null, // Pas de projet associé
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'due_date' => $dueDate,  // La date d'échéance
                'status' => 'pending'  // Statut de la tâche
            ]);

            return redirect()->to('/dashboard')->with('success', 'Tâche ajoutée avec succès.');
        }

        // Si la méthode HTTP est GET, affiche le formulaire
        $userId = session()->get('usr_id');
        $priorities = $priorityModel->getPrioritiesByUser($userId);

        return view('task/create', ['priorities' => $priorities]);
    }

}
