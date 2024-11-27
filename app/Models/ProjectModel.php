<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'project';
    protected $primaryKey = 'prj_id';
    protected $allowedFields = [
        'usr_id',
        'title',
        'description',
        'status',
        'prj_created_at',
        'prj_updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'prj_created_at';
    protected $updatedField = 'prj_updated_at';

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ajoute un projet
     * @param array $data Données du projet à ajouter
     * @return int|false ID du projet ajouté ou false en cas d'échec
     */
    public function add(array $data)
    {
        return $this->insert($data, true); // Retourne l'ID du projet inséré
    }

    /**
     * Modifie un ou plusieurs champs d'un projet
     * @param int $id ID du projet
     * @param array $data Champs à mettre à jour
     * @return bool Succès ou échec de l'opération
     */
    public function upd(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Supprime un projet
     * @param int $id ID du projet
     * @return bool Succès ou échec de l'opération
     */
    public function del(int $id)
    {
        return $this->delete($id);
    }

    /**
     * Récupère tous les projets d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @return array Liste des projets
     */
    public function getProjectsByUser(int $userId)
    {
        return $this->where('usr_id', $userId)->findAll();
    }

    public function getProjectById(int $prjID)
    {
        return $this->where('prj_id', $prjID)->first();
    }
}
