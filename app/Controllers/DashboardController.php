<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TaskModel;

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

        if($this->validate($validation->getRules())){
            $this->addProject();
        }
    }

    public function addProject()
    {
        
        $model = new ProjectModel();
        if ($this->request->getMethod() === 'POST' ) {
            $model = new ProjectModel();
            $model->add([
                'title' => $this->request->getPost('nomProjet'),
                'description' => $this->request->getPost('descriptionProjet'),
                'usr_id' => (int) session()->get('user_id')
            ]);
            
        }
        return redirect()->to('/dashboard');
    }
}
