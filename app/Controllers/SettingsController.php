<?php

namespace App\Controllers;

use App\Models\PriorityModel;

class SettingsController extends BaseController
{
    protected $priorityModel;

    public function __construct()
    {
        $this->priorityModel = new PriorityModel();
        helper('form');
    }

    /**
     * Affiche la page des paramètres
     */
    public function index()
    {
        $userId = session()->get("user_id");
        $data = [
            'priorities' => $this->priorityModel->getPrioritiesByUser($userId),
        ];

        return view('settings/setting', $data);
    }

    /**
     * Traite la création d'une priorité
     */
    public function createPriority()
    {
        if (!$this->validate([
            'name' => 'required|max_length[50]',
            'color' => 'required|regex_match[/^#[0-9A-Fa-f]{6}$/]',
            'ordre' => 'required|integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->priorityModel->save([
            'usr_id' => (int) session()->get('user_id'),
            'name' => $this->request->getPost('name'),
            'color' => $this->request->getPost('color'),
            'ordre' => $this->request->getPost('ordre')
        ]);

        return redirect()->to('/settings')->with('success', 'Priorité créée avec succès.');
    }

    /**
     * Supprime une priorité
     */
    public function deletePriority($id)
    {
        $this->priorityModel->delete($id);
        return redirect()->to('/settings')->with('success', 'Priorité supprimée avec succès.');
    }

    /**
     * Traite la mise à jour d'une priorité
     */
    public function updatePriority($id)
    {
        if (!$this->validate([
            'name' => 'required|max_length[50]',
            'color' => 'required|regex_match[/^#[0-9A-Fa-f]{6}$/]',
            'ordre' => 'required|integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->priorityModel->update($id, [
            'name' => $this->request->getPost('name'),
            'color' => $this->request->getPost('color'),
            'ordre' => $this->request->getPost('ordre')
        ]);

        return redirect()->to('/settings')->with('success', 'Priorité modifiée avec succès.');
    }
}
