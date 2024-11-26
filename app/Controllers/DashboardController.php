<?php

namespace App\Controllers;

use App\Models\TaskModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $model = new TaskModel();
        $tasks = $model->getTasksByUser(session()->get("user_id"));
        echo view('dashboard/dashboard', [
            'tasks' => $tasks
        ]);
    }
}
