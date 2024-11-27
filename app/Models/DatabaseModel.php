<?php

namespace App\Models;

use CodeIgniter\Model;

class DatabaseModel extends Model
{
    // Définition des noms de tables
    protected $tables = [
        'users' => 'usr_id',
        'project' => 'prj_id',
        'priority' => 'prio_id',
        'tasks' => 'tsk_id',
        'comments' => 'cmt_id',
        'notifications' => 'notif_id'
    ];

    // Récupérer toutes les données d'une table
    public function getAllData($table)
    {
        return $this->db->table($table)->get()->getResultArray();
    }

    // Récupérer une ligne spécifique par ID
    public function getDataById($table, $id)
    {
        return $this->db->table($table)->where($this->tables[$table], $id)->get()->getRowArray();
    }

    // Mettre à jour une donnée spécifique dans une table
    public function updateData($table, $id, $data)
    {
        return $this->db->table($table)->where($this->tables[$table], $id)->update($data);
    }

    // Supprimer une donnée spécifique dans une table
    public function deleteData($table, $id)
    {
        return $this->db->table($table)->where($this->tables[$table], $id)->delete();
    }
}
