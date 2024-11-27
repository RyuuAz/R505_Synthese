<?php

namespace App\Controllers;

use App\Models\DatabaseModel;

class DatabaseController extends BaseController
{
    public function index()
    {
        $dbModel = new DatabaseModel();

        // Récupérer les données de chaque table
        $data['users'] = $dbModel->getAllData('users');
        $data['projects'] = $dbModel->getAllData('project');
        $data['priorities'] = $dbModel->getAllData('priority');
        $data['tasks'] = $dbModel->getAllData('tasks');
        $data['comments'] = $dbModel->getAllData('comments');
        $data['notifications'] = $dbModel->getAllData('notifications');

        // Charger la vue principale
        return view('database_view', $data);
    }

    // Afficher le formulaire de modification
    public function edit($table, $id)
    {
        $dbModel = new DatabaseModel();
        $data['item'] = $dbModel->getDataById($table, $id);
        $data['table'] = $table;
        $data['primary_key'] = $dbModel->tables[$table]; // Ajout de la clé primaire spécifique à la table

        // Charger la vue pour modifier
        return view('edit_item', $data);
    }

    // Mettre à jour les données
    public function update($table, $id)
    {
        $dbModel = new DatabaseModel();
        $data = $this->request->getPost();

        // Mettre à jour les données dans la table correspondante
        $dbModel->updateData($table, $id, $data);

        // Rediriger vers la page principale
        return redirect()->to('/database');
    }

    // Supprimer une donnée
    public function delete($table, $id)
    {
        $dbModel = new DatabaseModel();
        $dbModel->deleteData($table, $id);

        // Rediriger vers la page principale
        return redirect()->to('/database');
    }
}
