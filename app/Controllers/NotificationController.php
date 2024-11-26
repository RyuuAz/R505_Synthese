<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notificationModel;
    protected $rules = [
        'usr_id' => 'required|integer',
        'type' => 'required|in_list[reminder,account_activation,password_reset]',
        'status' => 'required|in_list[pending,sent,failed]'
    ];

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        helper('form');
    }

    // Affiche le formulaire d'ajout de notification
    public function create()
    {
        return view('notification/create');
    }

    // Traite le formulaire d'ajout de notification
    public function store()
    {
        if (!$this->validate($this->rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'usr_id' => $this->request->getPost('usr_id'),
            'type' => $this->request->getPost('type'),
            'status' => $this->request->getPost('status')
        ];

        $this->notificationModel->add($data);
        return redirect()->to('/notifications')->with('success', 'Notification ajoutée.');
    }

    // Supprime une notification
    public function delete($id)
    {
        $this->notificationModel->del($id);
        return redirect()->to('/notifications')->with('success', 'Notification supprimée.');
    }
}
