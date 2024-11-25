<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $table = 'tasks';
    protected $primaryKey = 'tsk_id';
    protected $allowedFields = [
        'usr_id', 
        'prj_id', 
        'title', 
        'description', 
        'due_date', 
        'status', 
        'tsk_created_at', 
        'tsk_updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'tsk_created_at';
    protected $updatedField = 'tsk_updated_at';

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ajoute une tâche
     * @param array $data Données de la tâche à ajouter
     * @return int|false ID de la tâche ajoutée ou false en cas d'échec
     */
    public function add(array $data)
    {
        return $this->insert($data, true); // Retourne l'ID de la tâche insérée
    }

    /**
     * Modifie un ou plusieurs champs d'une tâche
     * @param int $id ID de la tâche
     * @param array $data Champs à mettre à jour
     * @return bool Succès ou échec de l'opération
     */
    public function upd(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Supprime une tâche
     * @param int $id ID de la tâche
     * @return bool Succès ou échec de l'opération
     */
    public function del(int $id)
    {
        return $this->delete($id);
    }
}
