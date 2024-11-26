<?php

namespace App\Controllers;

use App\Models\TaskModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $model = new TaskModel();
        $tasks = $model->where('usr_id', session()->get('user_id'))->findAll();
        return view('index', ['tasks' => $tasks]);
    }
}
